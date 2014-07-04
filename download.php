<?php 
require_once "config/functions.inc.php"; 
require_once "session.inc.php"; 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>New Release Download</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="description" content="Default Description">
<meta name="keywords" content="">
<meta name="robots" content="">
<?php include "common.inc.php"; ?>
<script type="text/javascript" src="<?=SITE_WS_PATH?>/script/jquery.tinycarousel.min.js"></script>
<script type="text/javascript" src="<?=SITE_WS_PATH?>/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="<?=SITE_WS_PATH?>/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="<?=SITE_WS_PATH?>/fancybox/jquery.fancybox-1.3.4.css" media="screen" />

<script type="text/javascript">
  $(document).ready(function(){
	$('#slider2').tinycarousel({ display: 2 });
	$('#slider3').tinycarousel({ display: 2 });
	$("#variousCollaborate").fancybox({
				'overlayShow'	: true,
				'transitionIn'	: 'elastic',
				'transitionOut'	: 'elastic'
			});
	$("#variousNotebook").fancybox({
				'overlayShow'	: true,
				'transitionIn'	: 'elastic',
				'transitionOut'	: 'elastic'
			});
	$("#variousMembershipUpgrade").fancybox({
				'overlayShow'	: true,
				'transitionIn'	: 'elastic',
				'transitionOut'	: 'elastic'
			});
});

</script>

<!-- HOW TO PACKAGE -->
<link rel="stylesheet" type="text/css" href="<?=SITE_WS_PATH?>/howto/css/howto.css" />
<script language="JavaScript" src="http://mussino.com/servertime.php"></script>
<script src="<?=SITE_WS_PATH?>/howto/js/jquery.scrollTo-min.js"></script>
<script src="<?=SITE_WS_PATH?>/howto/js/jquery.scrollTo.js"></script>
<script src="<?=SITE_WS_PATH?>/howto/js/howto.js"></script>
<!-- / HOW TO PACKAGE -->	
</head>

<body>
<?php include "header.middle.inc.php"; ?>
<div id="wrapper">
<script type="text/javascript" src="<?=SITE_WS_PATH?>/wz_tooltip.js"></script>
<div class="content-container">
<?php include "header.top.inc.php"; ?>
<?php include "profile-middle3.php"; ?>
</div>
</div>
</div>
<?php include "footer.inc.php"; ?>
</body>
</html>