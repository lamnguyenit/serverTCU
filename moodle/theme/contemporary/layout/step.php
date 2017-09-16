<?php
if (isloggedin() && !is_siteadmin() && !isguestuser()) {
    if ($_SESSION['confirm_info_user'] == 'YES') {
        ?>
        <!-- Modal -->
        <div id="confirmInfoUserModal" class="modal fade in" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-lg">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title text-center">Thông tin thí sinh</h4>
                    </div>
                   <div class="modal-body">
                        
                        <div id="confirmInfoUser">
                            <table class="table">
                                <tr>
                                    <td>Họ tên:</td>
                                    <td><?php echo fullname($USER) ?> </td>
                                </tr>
                                <tr>
                                    <td>Ngày sinh:</td>
                                    <td>
                                        <?php
                                        // Check if a date has been specified.
                                        if (empty($USER->profile['Birthday'])) {
                                            echo get_string('notset', 'profilefield_datetime');
                                        } else {
                                            echo userdate($USER->profile['Birthday'], get_string('strftimedate', 'langconfig'));
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Số CMND:</td>
                                    <td>
                                        <?php
                                        // Check if a date has been specified.
                                        if (empty($USER->profile['IdentityCard'])) {
                                            echo get_string('notset', 'profilefield_datetime');
                                        } else {
                                            echo $USER->profile['IdentityCard'];
                                        }
                                        ?>
                                    </td>
                                </tr>
                            </table>
                            <div class="confirm">
                                <input type="checkbox" id="chkConfirmInfoUser" value="1" /> <label for="chkConfirmInfoUser">Tôi đã đọc và xác nhận các thông tin trên là đúng</label>
                            </div>
                        </div>
                        <div id="confirmRegulations" style="display: none;">
                            <?php echo $PAGE->theme->settings->confirminfouser_regulations;?>
                            <div class="confirm">
                                <input type="checkbox" id="chkConfirmRegulations" value="1" /> <label for="chkConfirmRegulations">Tôi đã đọc và đồng ý với những quy định trên</label>
                            </div>
                        </div>
                        <div id="confirmGuide" style="display: none;">
                            <?php echo $PAGE->theme->settings->confirminfouser_guide; ?>
                            <div class="confirm">
                                <input type="checkbox" id="chkConfirmGuide" value="1" /> <label for="chkConfirmGuide">Tôi đã đọc và hiểu các nội dung trên</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default continue">Tiếp theo</button>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            $(document).ready(function () {
                var $confirmInfoUserModal = $("#confirmInfoUserModal");
                var $confirmInfoUser = $("#confirmInfoUser");
                var $confirmRegulations = $("#confirmRegulations");
                var confirmRegulationsTitle = '<?php echo get_string('confirminfouser_regulations', 'theme_contemporary') ?>';
                var $confirmGuide = $("#confirmGuide");
                var confirmGuideTitle = '<?php echo get_string('confirminfouser_guide', 'theme_contemporary') ?>';
                if (!$('body').hasClass('pagelayout-base')) {
                    $confirmInfoUserModal.modal("show");
                }

                $confirmInfoUserModal.on('click', ".continue", function (e) {
                    if ($confirmInfoUser.is(':visible'))
                    {
						if(!$("#chkConfirmInfoUser").is(":checked")){
							$confirmInfoUser.find('.confirm').addClass('error');
							$('.modal-body').animate({ scrollTop: $('.modal-body').prop("scrollHeight")}, 1000);
							return false;
						}else{
							$confirmInfoUser.find('.confirm').removeClass('error');
						}
                        $confirmInfoUser.fadeOut(500, function () {
                            $confirmInfoUserModal.find('.modal-title').html(confirmRegulationsTitle);
                            $confirmRegulations.slideDown('slow');
                        });
                    } else if ($confirmRegulations.is(':visible')) {
						
						if(!$("#chkConfirmRegulations").is(":checked")){
							$confirmRegulations.find('.confirm').addClass('error');
							$('.modal-body').animate({ scrollTop: $('.modal-body').prop("scrollHeight")}, 1000);
							return false;
						}else{
							$confirmRegulations.find('.confirm').removeClass('error');
						}
						
                        $confirmRegulations.fadeOut(500, function () {
                            $confirmInfoUserModal.find('.modal-title').html(confirmGuideTitle);
                            $confirmGuide.slideDown('slow');
                        });
                    } else if ($confirmGuide.is(':visible')) {
						
						if(!$("#chkConfirmGuide").is(":checked")){
							$confirmGuide.find('.confirm').addClass('error');
							$('.modal-body').animate({ scrollTop: $('.modal-body').prop("scrollHeight")}, 1000);
							return false;
						}else{
							$confirmGuide.find('.confirm').removeClass('error');
						}
						
                        $confirmInfoUserModal.modal("hide");
                        $.ajax({
                                url: "<?php echo $CFG->wwwroot ?>" + "/webservice/del_session.php",
                            type: 'GET',
                            data: {"del_session_confirm_info_user": "fdgfdgdfg"},
                            success: function (data, textStatus, jqXHR) {

                            }
                        });
                    }
                });
            });
        </script>
        <?php
    }
}
?>
