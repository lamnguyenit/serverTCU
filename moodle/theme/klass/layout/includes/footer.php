<?php
$footnote = theme_klass_get_setting('footnote', 'format_html');

$fburl    = theme_klass_get_setting('fburl');
$pinurl   = theme_klass_get_setting('pinurl');
$twurl    = theme_klass_get_setting('twurl');
$gpurl    = theme_klass_get_setting('gpurl');

$address  = theme_klass_get_setting('address');
$emailid  = theme_klass_get_setting('emailid');
$phoneno  = theme_klass_get_setting('phoneno');
$copyright_footer = theme_klass_get_setting('copyright_footer');
$infolink = theme_klass_get_setting('infolink');

?>
<footer id="footer">
  <div class="footer-main">
    <div class="container-fluid">
      <div class="row-fluid">
        <div class="span4">
          <div class="infoarea">
            <div class="footer-logo">
              <a href="<?php echo $CFG->wwwroot;?>">
              	<img src="<?php echo get_logo_url('footer'); ?>" width="183" height="80" alt="Klass">
              </a>
            </div>
            <?php echo $footnote; ?>
          </div>
        </div>
        <div class="span2">
          <div class="foot-links">
            <h5><?php echo get_string('info','theme_klass');?></h5>
            <ul>
           <?php
			 $info_settings =	explode("\n",$infolink);

			 	foreach($info_settings as $key => $settingval)
				{
					$exp_set = explode("|",$settingval);
					list($ltxt,$lurl) = $exp_set;
					$ltxt = trim($ltxt);
					$lurl = trim($lurl);
					if(empty($ltxt))
					    continue;
					echo '<li><a href="'.$lurl.'" target="_blank">'.$ltxt.'</a></li>';
				}
			//	$atto_settings = $natto_settings;

			 ?>
             </ul>
          </div>
        </div>
        <div class="span3">
          <div class="contact-info">
            <h5><?php echo get_string('contact_us', 'theme_klass');?></h5>
            <p><?php echo $address; ?><br>
            <i class="fa fa-phone-square"></i><?php echo get_string('phone', 'theme_klass'); ?>: <?php echo $phoneno; ?><br>
            <i class="fa fa-envelope"></i><?php echo get_string('email','theme_klass'); ?>: <a class="mail-link" href="mailto:<?php echo $emailid; ?>"><?php echo $emailid; ?></a></p></div>
			
			<?php
			 if($fburl!='' || $pinurl!='' || $twurl!='' || $gpurl!='')
			 {
			 ?>
			  <div class="social-media">
				<h5><?php echo get_string('get_social','theme_klass'); ?></h5>
				<ul>
				 <?php if($fburl!=''){?> <li class="smedia-01"><a href="<?php echo $fburl; ?>"><i class="fa fa-facebook-square"></i></a></li><?php }?>
				   <?php if($pinurl!=''){?><li class="smedia-02"><a href="<?php echo $pinurl; ?>"><i class="fa fa-pinterest-square"></i></a></li><?php }?>
				  <?php if($twurl!=''){?> <li class="smedia-03"><a href="<?php echo $twurl; ?>"><i class="fa fa-twitter-square"></i></a></li><?php }?>
				  <?php if($gpurl!=''){?> <li class="smedia-04"><a href="<?php echo $gpurl; ?>"><i class="fa fa-google-plus-square"></i></a></li><?php }?>
				</ul>
			  </div>
			 <?php
			 }
			 ?>
        </div>
        <div class="span3">
			<!--hình ảnh footer -->
		   <img src="<?php echo get_logo_url('bgfooter'); ?>">
        </div>
      </div>
    </div>
  </div>
  <div class="footer-foot">
  	<div class="container-fluid">
	  	 <?php if ($copyright_footer): ?>
      	<p><?php echo $copyright_footer; ?></p>
       <?php endif; ?>
    </div>
  </div>
</footer>
<!--E.O.Footer-->

<?php  echo $OUTPUT->standard_end_of_body_html() ?>

<div id="fb-root"></div>
<script>(function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id))
            return;
        js = d.createElement(s);
        js.id = id;
        js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.5";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
<style>
    #cfacebook{position:fixed;bottom:0px;right:0px;z-index:99;width:260px;height:auto;border-top-left-radius:5px;border-top-right-radius:5px;overflow:hidden;}
    #cfacebook .fchat{float:left;width:100%;height:270px;overflow:hidden;display:none;background-color:#fff;}
    #cfacebook .fchat .fb-page{margin-top:-5px;float:left;}
    #cfacebook a.chat_fb{float:left;padding:0 25px;width:260px;color:#fff;text-decoration:none;height:40px;line-height:40px;text-shadow:0 1px 0 rgba(0,0,0,0.1);background-image:url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAAqCAMAAABFoMFOAAAAWlBMV…8/UxBxQDQuFwlpqgBZBq6+P+unVY1GnDgwqbD2zGz5e1lBdwvGGPE6OgAAAABJRU5ErkJggg==);background-repeat:repeat-x;background-size:auto;background-position:0 0;background-color:#009fe5;border:0;border-bottom:1px solid #133783;z-index:9999999;margin-right:12px;font-size:18px;}
    #cfacebook a.chat_fb:hover{color:yellow;text-decoration:none;}
    .fchat span{ width:260px!important;}
</style>
<script>
    jQuery(document).ready(function () {
        jQuery(".chat_fb").click(function () {
            jQuery('.fchat').toggle('slow');
        });
    });
</script>
<div id="cfacebook">
    <a href="javascript:;" class="chat_fb" onClick="return:false;"><i class="fa fa-facebook-square"></i> Hỗ trợ trực tuyến</a>
    <div class="fchat">
        <div style="width:250px;" class="fb-page"
             data-href="https://www.facebook.com/mitechcenter/"
             data-tabs="messages"
             data-width="260"
             data-height="280"
             data-small-header="true">
            <div class="fb-xfbml-parse-ignore">
                <blockquote></blockquote>
            </div>
        </div>
    </div>
</div>
</div>
<!-- Go to www.addthis.com/dashboard to customize your tools -->
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-597c532a85079895"></script>
