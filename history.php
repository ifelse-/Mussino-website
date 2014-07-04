<?php 
require_once "config/functions.inc.php"; 
require_once "session.inc.php";
$sql_default = "SELECT * FROM default_video_master WHERE Status =1 AND Video_Id=1";
$result_default = mysql_query($sql_default);
$colles_default = mysql_fetch_array($result_default); 
$sqlTextLyrics = "SELECT * FROM lyrics_post_master WHERE Product_Id='".$_GET['id']."' AND Status=1 AND Member_Account_Id='".$_SESSION['SESS_ID']."'";
$resTextLyrics = mysql_query($sqlTextLyrics);
$collesTextLyrics = mysql_fetch_array($resTextLyrics);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>History</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="description" content="Default Description">
<meta name="keywords" content="">
<meta name="robots" content="">
<?php include "common.inc.php"; ?>
<script type="text/javascript" src="Scripts/AC_RunActiveContent.js"></script>
</head>
<body>
<script type="text/javascript" src="wz_tooltip.js"></script>
<div id="wrapper">
<?php include "header.middle.inc.php"; ?>
<div class="content-container">
<?php include "header.top.inc.php"; ?>
<?php include "history-middle.php"; ?>
<?php if($_SESSION['SESS_ID']!='') { ?>
<?php include"footer-div.inc.php"; ?>
<?php } ?>
</div>
</div>
</div>
<?php include "footer.inc.php"; ?>
</body>
</html>