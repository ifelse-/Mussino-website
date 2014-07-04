<?php 
require_once "config/functions.inc.php"; 
require_once "session.inc.php"; 
$sql_default = "SELECT * FROM default_video_master WHERE Status =1 AND Video_Id=1";
$result_default = mysql_query($sql_default);
$colles_default = mysql_fetch_array($result_default);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>Contest Judge History</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="description" content="Default Description">
<meta name="keywords" content="">
<meta name="robots" content="">
<?php include "common.inc.php"; ?>
<script type="text/javascript" src="fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="fancybox/jquery.fancybox-1.3.4.css" media="screen" />
<script type="text/javascript">
  $(document).ready(function(){
				
	$("#viewComments").fancybox({
				'overlayShow'	: true,
				'transitionIn'	: 'elastic',
				'transitionOut'	: 'elastic'
			});
	
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
<?php include "contest-juge-history-middle.php"; ?>
</div>
</div>
<?php include "footer.inc.php"; ?>
</body>
</html>