<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$(window).bind("load",function() {
        loadPopup();// function show popup
    });
    $("#btn-close").click(function(){
        disablePopup();
    });
    $(this).keydown(function(event) {
        if (event.which == 27) { // 27 is 'Ecs' in the keyboard
            disablePopup();  // function close pop up
        }
    });
    $("#background-popup").click(function() {
        disablePopup();  // function close pop up
        disableLoginPopup();
    });
    var popupStatus = 0; // set value
    function loadPopup() {
        if(popupStatus == 0) { // if value is 0, show popup
            $("#to-popup").fadeIn(200); // fadein popup div
            $("#background-popup").css("opacity", "0.8"); // css opacity, supports IE7, IE8
            $("#background-popup").fadeIn(200);
            popupStatus = 1; // and set value to 1
        }
    }
	function disablePopup() {
	    if(popupStatus == 1) { // if value is 1, close popup
	        $("#to-popup").fadeOut(300);
	        $("#background-popup").fadeOut(300);
	        $('body,html').css("overflow","auto");//enable scroll bar
	        popupStatus = 0;  // and set value to 0
	    }
	}
});
</script>
<?php global $OUTPUT;?>
<div id="to-popup">
    <span id="btn-close"></span>
    <div id="popup-content">
        <img src="<?php echo $OUTPUT->pix_url('home/bgfooter', 'theme')?>" />
    </div><!--end #popup-content-->
</div> <!--to-popup end-->
<div id="background-popup"></div>