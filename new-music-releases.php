<?php 
require_once "config/functions.inc.php"; 
require_once "session.inc.php"; 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>Profile</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="description" content="Default Description">
<meta name="keywords" content="">
<meta name="robots" content="">
<?php include "common.inc.php"; ?>
</head>

<body>
<div id="wrapper">
<script type="text/javascript" src="wz_tooltip.js"></script>
<!-- HEADER -->
<?php include "header.middle.inc.php"; ?>
<div class="content-container">
<?php include "header.top.inc.php"; ?>

<!-- MAIN CONTAINER -->
<?php include "new-music-middle.php"; ?>
<!-- //MAIN CONTAINER --> 


<!-- BOTTOM SPOTLIGHT 2 -->
<?php //include "bottom.footer.inc.php"; ?>
<!-- //BOTTOM SPOTLIGHT 2--> 
</div>
</div>
<!-- FOOTER -->
<?php include "footer.inc.php"; ?>
<!-- //FOOTER -->

</body>
</html>