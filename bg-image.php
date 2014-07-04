<?php 
require_once "config/functions.inc.php";
require_once "session.inc.php"; 
$pageName = basename($_SERVER['PHP_SELF']); 
$sql = "SELECT * FROM member_account_master WHERE Member_Account_Id='".$_SESSION['SESS_ID']."'";
$result = mysql_query($sql);
$colles = mysql_fetch_array($result);
if($_POST['buttonSubmit']=='Submit')
{
	$imageStatus = Get_Single_Field("member_account_master","Bg_Image","Member_Account_Id","$_SESSION[SESS_ID]");
	
	
	
	if(!empty($_FILES['Photo']['name']))
	{
	
	if($imageStatus!='')
	{
	$image_name = $imageStatus;
	$path = "products/user_image/";
	$target_path = $path.$image_name;
	unlink($target_path);
	}
	
	
	
	list($getname,$getext) = explode(".",$_FILES['Photo']['name']);
	$lastId = $_SESSION['SESS_ID'];
	$create_name = "Bg_Image_".$lastId;
	$new_filename = $create_name.".".$getext;
	$upload_path = "products/user_image/".$new_filename;
	
	
	move_uploaded_file($_FILES['Photo']['tmp_name'],$upload_path);
	
	
	$sql_update = "UPDATE member_account_master SET Bg_Image = '$new_filename' WHERE Member_Account_Id = '".$_SESSION['SESS_ID']."' "; 
	mysql_query($sql_update);
		
	
	$_SESSION['sess_messs'] =  "<span style='color:#00FF00'>Backgorund Image Updated</span>";
	header("location: bg-image.php");
	exit;
	}
	else
	{
	$_SESSION['sess_messs'] =  "<span style='color:#ff0000'>Backgorund Image Empty</span>";
	header("location: bg-image.php");
	exit;
	}
	
	

}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>Backgorund Image</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="description" content="Default Description">
<meta name="keywords" content="">
<meta name="robots" content="">
<?php include "common.inc.php"; ?>
<script type="text/javascript" src="webcam.js"></script>
<script language="javascript">
function validateFileExtension1234(fld) 
	{

		if(!/(\.png|\.gif|\.jpg|\.jpeg)$/i.test(fld.value)) 
		{
		alert("Invalid image file type.");
		fld.form.reset();
		fld.focus();
		return false;
		}
		return true;
	}
</script>
</head>

<body>
<div id="wrapper">
<!-- HEADER -->
<?php include "header.middle.inc.php"; ?>
<div class="content-container">
<?php include "header.top.inc.php"; ?>
<!-- TOP SPOTLIGHT 1 -->
<div class="content-box-2" >
      <div class="cor_1set-5"></div>
      <div class="cor_1set-6"></div>
      <div class="pro-wrapper full">
        <div class="title">
          <div class="title_wrap-1">
            <div class="title_wrap-2">
              <div class="blue-btn-1"> <span><span><a href="<?=SITE_WS_PATH?>/<?=trim($_SESSION['SESS_ID'])?>/<?=$_SESSION['SESS_FIRST_NAME']?>" >My Profile</a></span></span> </div>
              &raquo; Backgorund Image
            </div>
          </div>
        </div>
        <div class="pro-content" style="height:500px;">
        <form id="frmBgImage" name="frmBgImage" enctype="multipart/form-data" method="post" action="">
          <div class="pro-left fl">
            <div class="user-img">
            <a href="<?=SITE_WS_PATH?>/<?=trim($_SESSION['SESS_ID'])?>/<?=$_SESSION['SESS_FIRST_NAME']?>" >
			<?php if(file_exists("products/user_image/$colles[Photo]") && $colles['Photo']!='') { ?>
              <img src="products/user_image/<?php echo $colles['Photo']; ?>" border="0" width="100" height="150" />
               <?php } else { ?>
              <img src="images/user_big.png" border="0" width="100" height="150" />
            <?php } ?>
            </a>
            <p><?=$colles['Account_Type']?></p>
            </div>
            <div class="pro-btn_row">
               <?php include "left-profile.inc.php"; ?>  
            </div>
          </div>
          <div class="pro-right3">
             <?php if($_SESSION["sess_messs"]!='') { ?>
              <div style="padding: 0 0 0 110px;"><?=$_SESSION["sess_messs"]?> <? $_SESSION["sess_messs"]='';?></div>
             <?php } ?>
             <div class="form-container">
              <ul>
                <li>
                  <div id="view_login_result"></div>
                </li>
                <li class="formBG2">
                  <div class="caption-2" style="width:250px;">Upload Background Image</div>
                  <div class="input-2">
                    <input type="file" name="Photo" id="Photo" class="input-text" size="30" onChange="validateFileExtension1234(this)"><br /><span style="font-family:Arial, Helvetica, sans-serif; font-size:11px; color: #CCC"><strong>[ only upload png, gif, jpg, jpeg ]</strong></span>
                  </div>
                  <div class="cl"></div>
                </li>
                <br />
                <li>
                  <div class="">
                    <input name="buttonSubmit" type="submit" value="Submit" class="button" >
                  </div>
                  <div class="cl"></div>
                </li>
                 
                 <li>
                 <div style="padding:20px 0 0 0;">
                 <?php if(file_exists("products/user_image/$colles[Bg_Image]") && $colles['Bg_Image']!='') { ?>
                 <img src="products/user_image/<?php echo $colles['Bg_Image']; ?>" border="0" width="500" height="300" />
                 <?php } ?>
                 </div>
                 </li>              
                
              </ul>
            
          </div>
          </div>
          <div class="cl"></div>
        </form>
        
        
        </div>
      </div>
      <div class="cor_1set-3"></div>
      <div class="cor_1set-4"></div>
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