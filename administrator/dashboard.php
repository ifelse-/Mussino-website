<?php 
include("../config/functions.inc.php");
include("session.inc.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Administrator</title>
<link href="css/layout-admin.css" rel="stylesheet" type="text/css" />
<link href="css/css.css" rel="stylesheet" type="text/css">
</head>

<body>
<div id="wrapper">
  <div class="header-container">
   <? include"header.inc.php"?> 
   <div class="msg-1">
    <?=$_SESSION['sess_mess']?>
    <?php $_SESSION['sess_mess']='';?>
   </div>
  </div>
  <div class="content-container">
    <div class="left-navigation fl">
      <div class="left-navigation_inner">
        <? require_once "left.inc.php"; ?>
      </div>
    </div>
    <div class="detail-col fr">
      <div class="detail-col_inner">
        <!--<div class="box-1">
          <h2>Categories</h2>
      
          
          <div class="btn-1 fr">
            <a href="category-list.php"><span>View More</span></a>
          </div>
          <div class="cl"></div>
        </div>
        <div class="box-1">
          <h2>Products</h2>
          
          <div class="btn-1 fr">
            <a href="product-list.php"><span>View More</span></a>
          </div>
          <div class="cl"></div>
        </div>-->
        
      </div>
    </div>
    <div class="cl"></div>
  </div>
  <? include"footer.inc.php"?>
</div>

</body>
</html>
