<?php 
require_once "config/functions.inc.php"; 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>Error</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="description" content="Default Description">
<meta name="keywords" content="">
<meta name="robots" content="">
<?php include "common.inc.php"; ?>
</head>

<body>
<script type="text/javascript" src="wz_tooltip.js"></script>
<div id="wrapper">
<!-- HEADER -->
<?php include "header.middle.inc.php"; ?>
<div class="content-container">
<?php include "header.top.inc.php"; ?>



<div id="ja-topsl" class="wrap">
  <div class="main">
    <div class="inner clearfix"> 
    
      
         <div>
        <div class="middle-col">
        <div class="middle-col-wrapper">
          <div class="middle-col-title">
            <div class="cor-1"></div>
            <h3>Error </h3>
            <div class="cor-2"></div>
            <div class="arrow-1"></div>
          </div>
          <div class="middle-col-detail">
            <div class="cor-1"></div>
            <div class="cor-2"></div>
            <div class="cor-3"></div>
            <div class="cor-4"></div>
            <div class="form-container" style="height:230px;">
            <?php if($_SESSION["SESS_MSG"]!='') { ?>
            <div style="color:#757575; padding: 50px 0 0 26%;"><?=$_SESSION["SESS_MSG"]?> <? $_SESSION["SESS_MSG"]='';?></div>
            <?php } ?>
            <div style="color:#757575; padding: 10px 0 0 26%;"><a href="checkout.php"><img src="images/arraow.jpg" /></a></div>
            </div>
          </div>
        </div>
      </div>
      </div>
      
    </div>
  </div>
</div>

<?php if($_SESSION['SESS_ID']!='') { ?>
<?php include"footer-div.inc.php"; ?>
<?php } ?>
</div>
</div>
<!-- FOOTER -->
<?php include "footer.inc.php"; ?>
<!-- //FOOTER -->

</body>
</html>