<?php 
require_once "config/functions.inc.php"; 
$start=0;
if(isset($_GET['start'])) $start=$_GET['start'];
$pagesize=15;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title><?=Get_Single_Field("category_master","Category_Name","Category_Id","$_REQUEST[id]")?></title>
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
				
		
$("#variousRegister").fancybox({
				'overlayShow'	: true,
				'transitionIn'	: 'elastic',
				'transitionOut'	: 'elastic'
			});
			
		$("#sessionbox").fancybox({
				'overlayShow'	: true,
				'transitionIn'	: 'elastic',
				'padding'		: 0,
				'transitionOut'	: 'elastic'
			}).trigger("click");		


});
</script>
</head>
<body>
<script type="text/javascript" src="wz_tooltip.js"></script>
<?php include "header.middle.inc.php"; ?>
<div id="wrapper">
<div class="content-container">
<?php include "header.top.inc.php"; ?>

<!-- 	Remove This after website launch -->
<a id="sessionbox" href="#sessionboxrun" style="display:none;"></a>
<div style="display:none; background-image:none;"><div id="sessionboxrun" style="width:800px;height:700px; color:#000">
<img src="images/explain-session.png" />
</div></div>
<!-- /Remove This after website launch -->

<?php include "session-middle.php"; ?>
<?php if($_SESSION['SESS_ID']!='') { ?>
<?php include"footer-div.inc.php"; ?>
<?php } ?>
</div>
</div>
</div>
<?php include "footer.inc.php"; ?>
</body>
</html>