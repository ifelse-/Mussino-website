<?php 
require_once "config/functions.inc.php";
$sql = "SELECT News_Id, Image, Title, Type, `Desc`, DATE_FORMAT(Date,'%b %d, %Y') as fDate FROM news_master WHERE  News_Id='".$_GET['id']."'";
$result = mysql_query($sql);
$colles = mysql_fetch_array($result);

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
<script type="text/javascript" src="fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="fancybox/jquery.fancybox-1.3.4.css" media="screen" />
<script type="text/javascript">
  $(document).ready(function(){
				
	$(".global-box").fancybox({
				'overlayShow'	: true,
				'transitionIn'	: 'elastic',
				'transitionOut'	: 'elastic'
			});
	
$("#variousRegister").fancybox({
				'overlayShow'	: true,
				'transitionIn'	: 'elastic',
				'transitionOut'	: 'elastic'
			});


});
</script>
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
              <div class="blue-btn-1"> <span><span><?=stripslashes($colles['Title'])?></span></span> </div>
              <div class="date"><?=stripslashes($colles['fDate'])?></div>
              <div class="cl"></div>
            </div>
          </div>
        </div>
        <div class="pro-content">
        <div class="pro-left fl">
       <div class="user-img"> <?php if(file_exists("products/news_image/$colles[Image]") && $colles['Image']!='') { ?>
            <img src="products/news_image/<?=$colles['Image']?>" width="100" height="100"  />
            <?php  } else { ?>
            <img src="images/no-image.gif" width="100" height="100"  />
            <?php } ?></div>
        </div>
        <div class="pro-right">
          <?=stripslashes($colles['Desc'])?>
        </div>  
         <div class="cl"></div> 
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