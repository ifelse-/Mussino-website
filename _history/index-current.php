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
if(strtolower($ext)=='mp3' || strtolower($ext)=='wma') 
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
if(strtolower($ext)=='mp3' || strtolower($ext)=='wma') 
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
<script type="text/javascript" src="script/jquery.tinycarousel.min.js"></script>
<script type="text/javascript" src="script/config-tab.js"></script>
<script type="text/javascript" src="fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="fancybox/jquery.fancybox-1.3.4.css" media="screen" />
<script type="text/javascript">
  $(document).ready(function(){
	$('#slider1').tinycarousel({ display: 2 });
	$("#variousSongwriterSignup").fancybox({
				'overlayShow'	: true,
				'transitionIn'	: 'elastic',
				'transitionOut'	: 'elastic'
			});
	$("#variousMusicianRegister").fancybox({
				'overlayShow'	: true,
				'transitionIn'	: 'elastic',
				'transitionOut'	: 'elastic'
			});
	$("#variousJudgeSignup").fancybox({
				'overlayShow'	: true,
				'transitionIn'	: 'elastic',
				'transitionOut'	: 'elastic'
			});
	$("#variousRegister").fancybox({
				'overlayShow'	: true,
				'transitionIn'	: 'elastic',
				'transitionOut'	: 'elastic'
			});
			
	$("#variousTellaFriend").fancybox({
				'overlayShow'	: true,
				'transitionIn'	: 'elastic',
				'transitionOut'	: 'elastic'
			});
			
	$(".global-box").fancybox({
				'overlayShow'	: true,
				'transitionIn'	: 'elastic',
				'transitionOut'	: 'elastic'
			});
		$("#variousInviteFriends").fancybox({
				'overlayShow'	: true,
				'transitionIn'	: 'elastic',
				'transitionOut'	: 'elastic'
			});	
			
		$("#comingsoon").fancybox({
				'overlayShow'	: true,
				'transitionIn'	: 'elastic',
				'transitionOut'	: 'elastic'
			}).trigger("click");	
	
	
});
</script>
<script type="text/javascript" src="Scripts/AC_RunActiveContent.js"></script>
</head>

<body>
<script type="text/javascript" src="wz_tooltip.js"></script>
<div id="wrapper">
<?php include "header.middle.inc.php"; ?>
<div class="content-container">
<?php include "header.top.inc.php"; ?>
<?php  require_once "top.inc.php"; ?>
<?php include "main.inc.php"; ?>
<?php include "bottom.top.inc.php"; ?>
<?php include "bottom.middle.inc.php"; ?>
<?php if($_SESSION['SESS_ID']!='') { ?>
<?php include"footer-div.inc.php"; ?>
<?php } ?>
</div>

<!-- 	Remove This after website launch -->
<a id="comingsoon" href="#comingsoonrun" style="display:none"></a>
<div style="display:none;"><div id="comingsoonrun" style="width:500px;height:270px; padding:20px; color:#069">
<strong style="font-size:16px;"><center>Welcome to Mussino.com</center></strong>
THE NEW MUSIC INDUSTRY. <em>Where discoveries are made and talent gets paid!</em><br />

<br />
<strong>ATTENTION:</strong> Mussino.com is still underconstruction and working on creating a better user experience for our users. We should be launching our website in Beta LATE Febuary or EARLY March 1, 2012 <br /><br /><strong>Accounts:</strong> If you happen to visit our website, please feel free to look around. You can also create a profile and start adding content about you but no transaction will be made at this time<br /><br />
<strong>How it works?</strong> Mussino.com is the place where Musicians & Artists meet to create a music session to showcase skills for the Royalties. Sign up.
Create one of three Profiles below
<br />
• Musician Account - A Musician uploads their original instrumental<br />
• Artist Account - An Artist uploads their original lyrics <br />
• Judge Account - Judges vote on their favorite lyricist <br />
• Manager Account (Coming soon) - Create a group Record label 
</div></div>
<!-- /Remove This after website launch -->

</div>
<?php include "footer.inc.php"; ?>
</body>
</html>