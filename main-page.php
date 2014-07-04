<?php 
require_once "config/functions.inc.php"; 
$Con_Sql="select * from content_master  where Id='".$_REQUEST['id']."' AND Status=1 order by display_order ASC";
$Con_Result=executeQuery($Con_Sql);
$Con_Line=mysql_fetch_array($Con_Result);
$Content_Array[0]=ucwords(ms_stripslashes($Con_Line['Con_Title']));
$Content_Array[1]=ms_stripslashes($Con_Line['Con_Detail']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title><?=ucwords($Content_Array[0])?></title>
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
			
	
	
});
</script>
</head>

<body>
<!-- HEADER -->
<?php include "header.middle.inc.php"; ?>
<div id="wrapper">
<div class="content-container">
<?php include "header.top.inc.php"; ?>

<!-- MAIN CONTAINER -->
<?php include "main-page-middle.inc.php"; ?>
<!-- //MAIN CONTAINER --> 
<?php if($_SESSION['SESS_ID']!='') { ?>
<?php include"footer-div.inc.php"; ?>
<?php } ?>
</div>
</div>
</div>
<!-- FOOTER -->
<?php include "footer.inc.php"; ?>
<!-- //FOOTER -->

</body>
</html>