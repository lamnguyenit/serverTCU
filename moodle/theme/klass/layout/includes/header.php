<?php
$surl = new moodle_url('/course/search.php');
$phoneno  = theme_klass_get_setting('phoneno');
?>
<style>
.lert-header-top ul li {
    float: left;
    margin: 10px;
    text-decoration: none;
    list-style: none;
    color: #fff;
    text-align: center;
}
 div#cfacebook1 {
      position: fixed;
      z-index: 999;
      left: 15px;
      bottom: 20px;
  }
  div#cfacebook1 div a img:hover {
      border: 1.5px dotted rgb(123, 117, 117);
      border-radius: 50px;
  }
</style>
<header id="header">
	<div class="header-top">
		<div class="lert-header-top">
		  <ul class="inline-block ul-li-list-style-none ul-li-inline-block mb0 pl0">
			  <li class="hotline">
				  <span class="text">Tư vấn tuyển sinh: <a style="font-weight: bold;" href="tel:<?php echo $phoneno; ?>" data-wpel-link="internal"><?php echo $phoneno; ?></a></span>
				  <!--<span class="icon"><a href="tel:19006747" data-wpel-link="internal"><i class="fa fa-phone-square" aria-hidden="true"></i></a></span>-->
			  </li>
			  <li class="social-icon">
				  <a href="#" data-wpel-link="external" target="_blank" rel="nofollow external noopener noreferrer"><i class="fa fa-facebook"></i></a>
			  </li>
			  <li class="social-icon">
				  <a href="#" data-wpel-link="external" target="_blank" rel="nofollow external noopener noreferrer"><i class="fa fa-google-plus"></i></a>
			  </li>
			  <li class="social-icon">
				  <a href="#" data-wpel-link="external" target="_blank" rel="nofollow external noopener noreferrer"><i class="fa fa-youtube-play"></i></a>
			  </li>
			  <li class="social-icon">
				  <a href="#" data-wpel-link="external" target="_blank" rel="nofollow external noopener noreferrer"><i class="fa fa-twitter" aria-hidden="true"></i></a>
			  </li>
			  <li class="social-icon">
				  <a href="#" data-wpel-link="external" target="_blank" rel="nofollow external noopener noreferrer"><i class="fa fa-instagram" aria-hidden="true"></i></a>
			  </li>
			  <li class="social-icon">
				  <a href="#" data-wpel-link="external" target="_blank" rel="nofollow external noopener noreferrer"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
			  </li>
		  </ul>
		</div>
        <div class="span6" style="float: right;">
          <div class="container-fluid">
            <?php if($CFG->branch > "27"): ?>
            <?php echo $OUTPUT->user_menu(); ?>
            <?php endif; ?>
            <div class="clearfix"></div>
           </div>
        </div>
      </div> 
    </div>
  </div>
  <div class="header-main">
	  <div class="header-main-content">
    	<div class="container-fluid">
      	<div class="row-fluid">
        	<div class="span6">
          	<div id="logo"><a href="<?php echo $CFG->wwwroot;?>"><img src="<?php echo get_logo_url(); ?>" width="183" height="80" alt="Klass"></a></div>
          </div>
           <?php if(! $PAGE->url->compare($surl, URL_MATCH_BASE)): ?>
        	<div class="span6">
          	<div class="top-search">
           <form action="<?php echo new moodle_url('/course/search.php'); ?>" method="get">
              <input type="text" placeholder="<?php echo get_string('searchcourses'); ?>" name="search" value="">
              <input type="submit" value="Search">
           </form>
            </div>
            <div class="clearfix"></div>
          </div>
           <?php endif; ?>
        </div>
      </div>
    </div>
    <div class="header-main-menubar">
      <div class="navbar">
        <div class="navbar-inner">
          <div class="container-fluid">
            <a data-target=".navbar-responsive-collapse" data-toggle="collapse" class="btn btn-navbar">
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </a>
            <a href="#" class="brand" style="display: none;">Title</a>
            <p class="navbar-text"><a href="<?php echo $CFG->wwwroot;?>"><i class="fa fa-home"></i><?php echo get_string('home','theme_klass');?></a></p>
            <div class="nav-collapse collapse navbar-responsive-collapse">
              <p class="navbar-text"><a href="<?php echo $CFG->wwwroot;?>"><i class="fa fa-home"></i><?php echo get_string('home','theme_klass');?></a></p>
              <?php echo $OUTPUT->custom_menu(); ?>
              <ul class="nav pull-right">
                  <li><?php echo $OUTPUT->page_heading_menu(); ?></li>
                  <?php if($CFG->branch < "28"): ?>
                   <li class="navbar-text"><?php echo $OUTPUT->login_info() ?></li>
                 <?php endif; ?>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
   <div id="cfacebook1">
        <div id="czalo">
            <a href="http://zalo.me/<?php echo $phoneno; ?>"><img src="https://xuhuongdongphuc.vn/wp-content/uploads/zalo.png" width="56px" height="60px"></a>
        </div>
        <div id="cface"><a href="https://m.me/mitechcenter"><img src="https://xuhuongdongphuc.vn/wp-content/uploads/facebook-messenger.svg" width="52px" height="52px"></a></div>
    </div>
<script>
$(document).ready(function(){ 
	pos=$(".header-main").position(); 
	$(window).scroll(function(){ 
		var posScroll=$(document).scrollTop(); 
		if(parseInt(posScroll)>parseInt(pos.top)) { 
			$(".header-main").addClass('fixed'); 
		}else 
		{ 
			$(".header-main").removeClass('fixed'); 
		} 
	}); 
});
</script>
</header

<!--E.O.Header-->