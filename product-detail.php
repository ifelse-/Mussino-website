<?php 
require_once "config/functions.inc.php";

include("includes/rating_functions.php");

$sql = "SELECT P.Product_Id, P.Member_Account_Id,	P.Title, P.Sound,P.Product_Notes, P.Type, P.Image_Name, P.Short_FIle_Name, P.Long_FIle_Name, P.Short_Desc, P.Long_Desc, P.Price,	P.Session_Start_Date, P.Session_End_Date, DATE_FORMAT(P.Session_Start_Date,'%m-%d-%Y %T %p') as StartDate, DATE_FORMAT(P.Session_End_Date,'%m-%d-%Y %T %p') as EndDate, DATE_FORMAT(P.Product_Date,'%m/%d/%Y %h:%i %p') as Date, P.Status FROM product_master P WHERE P.Product_Id='".$_GET['id']."'";

$result = mysql_query($sql);

$colles = mysql_fetch_array($result);



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>Product Details</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="description" content="Default Description">
<meta name="keywords" content="">
<meta name="robots" content="">
<?php include "common.inc.php"; ?>
<link href="greybox/css_pirobox/demo5/style.css" class="piro_style" media="screen" title="white" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="greybox/js/jquery.min.js"></script>
<script type="text/javascript" src="greybox/js/pirobox.js"></script>
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


});
</script>
<script type="text/javascript">

$(document).ready(function() {

	$().piroBox({

			my_speed: 400, //animation speed

			bg_alpha: 0.3, //background opacity

			slideShow : true, // true == slideshow on, false == slideshow off

			slideSpeed : 4, //slideshow duration in seconds(3 to 6 Recommended)

			close_all : '.piro_close,.piro_overlay'// add class .piro_overlay(with comma)if you want overlay click close piroBox



	});

});

</script>

<link href="css/rating_style.css" rel="stylesheet" type="text/css" media="all">

	<script type="text/javascript" src="js/rating_update.js"></script>	
</head>
<body>
<div id="wrapper">
  <!-- HEADER -->
  <?php include "header.middle.inc.php"; ?>
  <div class="content-container">
    <?php include "header.top.inc.php"; ?>
    <!-- TOP SPOTLIGHT 1 -->
    <div class="content-box-2">
      <div class="cor_1set-5"></div>
      <div class="cor_1set-6"></div>
      <div class="pro-wrapper full">
        <div class="title">
          <div class="title_wrap-1">
            <div class="title_wrap-2">
              <div class="blue-btn-1"> <span><span>Product Details</span></span> </div>
            </div>
          </div>
        </div>
        <div class="pro-content">
          <div class="form-container">
            <ul>

						<li class="product-image product fl">

							<div class="imageOuter">

								<?php

								if(file_exists("products/product_image/$colles[Image_Name]"))

								{

								?>

								<img src="products/product_image/<?=$colles['Image_Name']?>" class="img_border"  width="100" height="100" border="0" alt="<?=stripslashes($colles['Title']);?>">

								<?

								}

								else

								{

								?>

								<img src="images/no-image.gif" width="100" class="img_border" height="100" border="0" alt="<?=stripslashes($colles['Title']);?>">

								<?php

								}

								?>

								<a href="products/product_image/<?=$colles['Image_Name']?>" class="pirobox_gall clkZoom" title="<?=ucwords(ms_stripslashes($colles['Title']))?>">Click to Zoom</a>

								<div style="padding: 10px 0 0 10px;"><? //echo pullRating(25,false,true,true); ?></div>

							</div>

						</li>

						<li class="pro_details fl paddingLeft10">

							<ul>

								<li class="title">

									<h3><?=stripslashes($colles['Title'])?></h3>

								</li>
                                
                                <li>

									<strong>Session Notes</strong><b> : </b><span><b><?=$colles['Product_Notes'];?></b></span>

								</li>

								<li>

									<strong>Release</strong><b> : </b><span><b>$<?=$colles['Price'];?></b></span>

								</li>

								<li>

									<strong>Sound</strong><b> : </b><span><?=stripslashes(Get_Single_Field("sound_type_master","Sound_Type_Name","Sound_Type_Id","$colles[Sound]"));?></span>

								</li>

								<li>

									<strong>Type</strong><b> : </b><span><?=stripslashes(Get_Single_Field("type_master","Type_Name","Type_Id","$colles[Type]"));?></span>

								</li>

								

								<li>

									<strong>Date & Time</strong><b> : </b><span><?=stripslashes($colles['Date'])?></span>

								</li>

								<li>

									<strong>Session Start</strong><b> : </b><span><?=$colles['StartDate']?></span>

								</li>

								<li>

									<strong>Session End</strong><b> : </b><span><?=$colles['EndDate']?></span>

								</li>

								<li>

									<strong>Details</strong><b> : </b><span><?=stripslashes($colles['Short_Desc'])?></span>

								</li>

							</ul>

						</li>

					</ul>
                    
             <div class="fr">
             <img src="images/ad.png" />
             </div>       
                    
                    
    <div class="cl"></div>                
                    
          </div>
        </div>
      </div>
      <div class="cor_1set-3"></div>
      <div class="cor_1set-4"></div>
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
