<?php 
require_once "config/functions.inc.php"; 
$sqlIns = "SELECT * FROM product_master where Status=1 AND Title='".$_REQUEST['q']."'";
$resultIns = mysql_query($sqlIns);
if(mysql_num_rows($resultIns)>0)
{
if($_REQUEST['q']!='')
{

if ( isset($_SERVER["REMOTE_ADDR"]) )    {
$ip=$_SERVER["REMOTE_ADDR"] . ' ';
} else if ( isset($_SERVER["HTTP_X_FORWARDED_FOR"]) )    {
$ip=$_SERVER["HTTP_X_FORWARDED_FOR"] . ' ';
} else if ( isset($_SERVER["HTTP_CLIENT_IP"]) )    {
$ip=$_SERVER["HTTP_CLIENT_IP"] . ' ';
}

    $sqlCC = "SELECT * FROM tags WHERE tag_name='".$_REQUEST['q']."' AND client_ip='".$ip."'";
    $resultCC = mysql_query($sqlCC);
	if(mysql_num_rows($resultCC)==0)
	{
	
	$sql_insert = "INSERT INTO tags SET tag_name='".$_REQUEST['q']."', client_ip='".$ip."'  ";
	mysql_query($sql_insert);
	}
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
<script type="text/javascript" src="fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="fancybox/jquery.fancybox-1.3.4.css" media="screen" />
<script type="text/javascript">
  $(document).ready(function(){
	
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
			
	
	
});
</script>
</head>
<body>
<script type="text/javascript" src="wz_tooltip.js"></script>
<div id="wrapper">
<?php include "header.middle.inc.php"; ?>
<div class="content-container">
<?php include "header.top.inc.php"; ?>
<?php include "main-search.php"; ?>
<?php if($_SESSION['SESS_ID']!='') { ?>
<?php include"footer-div.inc.php"; ?>
<?php } ?>
</div>
</div>
<?php include "footer.inc.php"; ?>
</body>
</html>