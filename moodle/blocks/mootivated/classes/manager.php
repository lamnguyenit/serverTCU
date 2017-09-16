<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Manager.
 *
 * @package    block_mootivated
 * @copyright  2017 Mootivation Technologies Corp.
 * @author     Frédéric Massart <fred@branchup.tech>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace block_mootivated;
defined('MOODLE_INTERNAL') || die();

use cache;
use coding_exception;
use context;
use moodle_exception;
use stdClass;
use local_mootivated\school;

/**
 * Manager class.
 *
 * @package    block_mootivated
 * @copyright  2017 Mootivation Technologies Corp.
 * @author     Frédéric Massart <fred@branchup.tech>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class manager {

    /** @var context The context we're in. */
    protected $context;
    /** @var stdClass The user. */
    protected $user;
    /** @var stdClass The user ID. */
    protected $userid;
    /** @var school The school, if any. */
    protected $school = false;
    /** @var cache The coins cache. */
    protected $coinscache;

    /**
     * Constructor.
     *
     * @param object|int $user The user, or its ID.
     * @param context $context The context we are in, not the block context.
     */
    public function __construct($userorid, context $context) {
        global $USER;
        $this->context = $context;

        $user = null;
        $userid = $userorid;
        if (is_object($userorid)) {
            $user = $userorid;
            $userid = $user->id;
        }

        $this->userid = $userid;
        if ($user !== null) {
            $this->set_user($user);
        }
    }

    /**
     * Whether the user has managing rights.
     *
     * @return bool
     */
    public function can_manage() {
        return has_capability('block/mootivated:addinstance', $this->context, $this->userid);
    }

    /**
     * Whether the user can view the content.
     *
     * @return bool
     */
    public function can_view() {
        return has_capability('block/mootivated:view', $this->context, $this->userid);
    }

    /**
     * Require for the user to be able to view the content.
     *
     * @throws moodle_exception
     */
    public function require_view() {
        require_capability('block/mootivated:view', $this->context, $this->userid);
    }

    /**
     * Return the context.
     *
     * @return context
     */
    public function get_context() {
        return $this->context;
    }

    /**
     * Add locally earned coins.
     *
     * We save when a user earns coins locally in order to avoid purging the cache
     * everytime that happens. The locally earned coins will be added to the amount of
     * coins we retrieved from the server to compute the total amount of coins they own.
     *
     * @param int $amount The amount.
     * @return void
     */
    public function add_locally_earned_coins($amount) {
        $cache = $this->get_coins_cache();
        $fromcache = $cache->get($this->userid);
        if ($fromcache === false) {
            // We don't have a cache, so no need.
            return;
        }

        if (!isset($fromcache['fromlocal'])) {
            $fromcache['fromlocal'] = 0;
        }
        $fromcache['fromlocal'] += $amount;
        $cache->set($this->userid, $fromcache);
    }

    /**
     * Get the amount of coins the user has.
     *
     * @return int
     */
    public function get_coins() {
        $school = $this->get_school();
        if (!$school) {
            return 0;
        }

        $cache = $this->get_coins_cache();
        $coins = $cache->get($this->userid);

        // We have our own TTL because the docs are very discouraging about using the built-in TTL:
        // "It is strongly recommended that you don't make use of this".
        $expiredat = time() - (HOURSECS * 6);
        if ($coins === false || $coins['time'] < $expiredat) {
            $coins = [
                'fromserver' => $this->get_coins_from_server(),
                'fromlocal' => 0,
                'time' => time()
            ];
            $cache->set($this->userid, $coins);
        }

        return $coins['fromserver'] + $coins['fromlocal'];
    }

    /**
     * Get the coins cache.
     *
     * The cache is indexed by user ID, and contains an array with:
     *
     * fromserver (int): The amount of coins retrieved from the server.
     * fromlocal (int): The amount of coins earned locally since the last fetch from server.
     * time (int): Timestamp representing when the cache was set, to maintain our own TTL.
     *
     * @return cache
     */
    protected function get_coins_cache() {
        if (!$this->coinscache) {
            $this->coinscache = cache::make('block_mootivated', 'coins');
        }
        return $this->coinscache;
    }

    /**
     * Get the coins from the server.
     *
     * @return int
     */
    protected function get_coins_from_server() {
        $school = $this->get_school();
        if (!$school) {
            throw new coding_exception('Whoops, where is the school?');
        }

        // We don't want failures here, always assume this succeeded.
        try {
            $coins = $school->get_user_coins($this->userid);
        } catch (moodle_exception $e) {
            $coins = 0;
        }

        return $coins;
    }

    /**
     * Get a user's school.
     *
     * @return school|null
     */
    public function get_school() {
        if ($this->school !== null) {
            $this->school = school::load_from_member($this->userid);
        }
        return $this->school;
    }

    /**
     * Return the user.
     *
     * @return stdClass
     */
    public function get_user() {
        global $DB, $USER;
        if (!$this->user) {
            $this->set_user();
        }
        return $this->user;
    }

    /**
     * Set the current user.
     *
     * @return void
     */
    protected function set_user(stdClass $user = null) {
        global $DB, $USER;
        $updatepicture = true;

        // If we were not given a user object, or IDs don't match, fetch the right one.
        if ($user === null || $user->id != $this->userid) {

            // Reuse the user object when possible.
            if ($USER->id == $this->userid) {
                $user = $USER;
            } else {
                $user = core_user::get_user($this->userid);
                $updatepicture = false;
            }
        }

        // We need to update the picture field in case the user has uploaded a new avatar.
        if ($updatepicture) {
            $user->picture = $DB->get_field('user', 'picture', ['id' => $user->id], IGNORE_MISSING);
        }

        $this->user = $user;
    }

    /**
     * Whether the current user has a school.
     *
     * @return bool
     */
    public function has_school() {
        return $this->get_school() !== null;
    }

}
