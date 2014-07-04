<?php 
require_once "config/functions.inc.php";
require_once "session.inc.php"; 
$pageName = basename($_SERVER['PHP_SELF']); 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>Favorite Musician</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="description" content="Default Description">
<meta name="keywords" content="">
<meta name="robots" content="">
<?php include "common.inc.php"; ?>

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
              <div class="blue-btn-1"> <span><span><a href="<?=SITE_WS_PATH?>/<?=trim($_SESSION['SESS_ID'])?>/<?=$_SESSION['SESS_FIRST_NAME']?>" >My Profile</a></span></span> </div>
              &raquo; Favorite Musician
            </div>
          </div>
        </div>
        <div class="pro-content">
        
        
          
<table width="100%" bgcolor="#ffffff" border="0" bordercolor="#ffffff" cellpadding="1" cellspacing="1">


<tr>
	<td colspan="2" align='left'>
	<form action="<?php echo $_SERVER['PHP_SELF']?>" method="POST"  name="form1">
	<table cellspacing="1" cellpadding="1" border="0" width="100%">
	
	<? if($_SESSION['MSG']!=''){?>
	<tr>
	<td colspan="3" align="center" class="collecton-txt"><font color="#CC3300"><?=$_SESSION['MSG']?><? $_SESSION['MSG'] = '';?></font></td>
	</tr>
	<? }?>
	
	<tr height="26" bgcolor="#151515">
	<td width="10%"  style="color:#ffffff;"><b>SL. No.</b></td>
    <td width="20%"  style="color:#ffffff;"><b>Photo</b></td>
	<td width="20%" style="color:#ffffff;"><b>First Name</b></td>
	<td width="20%"  style="color:#ffffff;"><b>Last Name</b></td>
	<!--<td width="30%" style="color:#ffffff;"><b>Email</b></td>-->
	</tr>
	<?php
	$k=0;
	
	$sql_favorite = "SELECT * FROM my_favorite_tab WHERE My_Id ='".$_SESSION['SESS_ID']."' ";
	$result_favorite = mysql_query($sql_favorite) or die('<br>'.$sql_favorite.'<br>'.mysql_error());
	if(mysql_num_rows($result_favorite)>0)
	{
	while($colles_favorite = mysql_fetch_array($result_favorite))
	{
	$sql = "SELECT * FROM member_account_master WHERE Member_Account_Id ='".$colles_favorite['MY_Favorite_Id']."' ORDER BY First_Name,Last_Name";
	$res = mysql_query($sql) or die('<br>'.$sql.'<br>'.mysql_error());
	
	while($line=mysql_fetch_array($res))
	{
	$bgcolor = ($k%2==0? '#FFFFFF': '#FFFFFF');
	?>
	<tr bgcolor="<?php echo $bgcolor?>">
	<td width="10%"><?=$k+1;?></td>
    <td width="20%" class="linksmall-txt-line">
    <a href="<?=SITE_WS_PATH?>/<?=trim($line['Member_Account_Id'])?>/<?=ucfirst(stripslashes($line['First_Name']))?>">
    <?php if(file_exists("products/user_image/$line[Photo]") && $line['Photo']!='') { ?>
    <img src="products/user_image/<?php echo $line['Photo']; ?>" border="0" width="60" height="60"  />
    <?php } else { ?>
    <img src="images/user_big.png" border="0" width="60" height="60" />
    <?php } ?>
    </a>
    </td>
	<td width="20%" class="linksmall-txt-line"><?php echo $line['First_Name']; ?></td>
	<td width="20%" class="linksmall-txt-line"><?php echo $line['Last_Name']; ?></td>
	<!--<td width="30%" class="linksmall-txt-line"><?php echo $line['Email']; ?></td>-->
	</tr>
	<?php
	$k++;
	}
	
	}
	}
	else
	{ 
	echo "<td colspan='3' style='padding: 12px 0 0 270px;' align='center'>sorry, no record(s).</td>";
	}
	?>
	
	
	</table>
	</form>
	</td>
</tr>
</table>
                  
            
          
          </div>
       <div class="cl"></div>
       
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