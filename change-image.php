<?php 
require_once "config/functions.inc.php";
require_once "session.inc.php"; 
$pageName = basename($_SERVER['PHP_SELF']); 
$sql = "SELECT * FROM member_account_master WHERE Member_Account_Id='".$_SESSION['SESS_ID']."'";
$result = mysql_query($sql);
$colles = mysql_fetch_array($result);
if($_POST['buttonSubmit']=='Submit')
{
	$imageStatus = Get_Single_Field("member_account_master","Photo","Member_Account_Id","$_SESSION[SESS_ID]");
	
	
	
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
	$create_name = "Image_".$lastId;
	$new_filename = $create_name.".".$getext;
	$upload_path = "products/user_image/".$new_filename;
	
	
	move_uploaded_file($_FILES['Photo']['tmp_name'],$upload_path);
	
	
	$sql_update = "UPDATE member_account_master SET Photo = '$new_filename' WHERE Member_Account_Id = '".$_SESSION['SESS_ID']."' "; 
	mysql_query($sql_update);
		
	
	$_SESSION['sess_messs'] =  "<span style='color:#00FF00'>Photo Updated</span>";
	header("location: change-image.php");
	exit;
	}
	else
	{
	$_SESSION['sess_messs'] =  "<span style='color:#ff0000'>Photo Field Empty</span>";
	header("location: change-image.php");
	exit;
	}
	
	

}
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
              &raquo; Change Image
            </div>
          </div>
        </div>
        <div class="pro-content" style="height:500px;">
        <form id="frmChangeImage" name="frmChangeImage" enctype="multipart/form-data" method="post" action="">
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
                  <div class="caption-2" style="width:250px;">Upload album cover</div>
                  <div class="input-2">
                    <input type="file" name="Photo" id="Photo" class="input-text" size="30" onChange="validateFileExtension1234(this)"><br /><span style="font-family:Arial, Helvetica, sans-serif; font-size:11px; color: #FFF"><strong>[ only upload png, gif, jpg, jpeg ]</strong></span>
                  </div>
                  <div class="cl"></div>
                </li>
                <li>
                <br />
                  <div class="">
                    <input name="buttonSubmit" type="submit" value="Submit" class="button" >
                  </div>
                  <div class="cl"></div>
                </li>
                
                
                 
                
              </ul>
            
          </div>
          </div>
          <div class="cl"></div>
        </form>
        
        <div class="pro-right3" style="margin-top: -250px;" >
        <div style="font-size:18px; font-weight:bold; color: #F90;  padding:15px 0 15px 0;"><img src="images/mussino_webcam.png" width="30" align="absmiddle" /> Or take a Webcam Snap Shot</div>
        <P>(This may work better on Firefox or IE browser)</P>
        <div>
         <script language="JavaScript">
		 document.write( webcam.get_html(320, 240) );
         </script>
         <form>
		<input type=button value="Configure..." onClick="webcam.configure()">
		&nbsp;&nbsp;
		<input type=button value="Take Snapshot" onClick="take_snapshot()">
	    </form>

		<script language="JavaScript">
            webcam.set_api_url( 'webcame-upload-image.php' );
                webcam.set_quality( 90 ); // JPEG quality (1 - 100)
                webcam.set_shutter_sound( true ); // play shutter click sound
                webcam.set_hook( 'onComplete', 'my_completion_handler' );
        
                function take_snapshot() {
                    // take snapshot and upload to server
                    document.getElementById('upload_results').innerHTML = '<h4>Uploading...</h4>';
                    webcam.snap();
                }
        
                function my_completion_handler(msg) {
                    // extract URL out of PHP output
                    if (msg.match(/(http\:\/\/\S+)/)) {
                        // show JPEG image in page
                        document.getElementById('upload_results').innerHTML =
                            '<h4>Photo Upload Successfully</h4>';
        
                        // reset camera for another shot
                        webcam.reset();
                        location.replace('change-image.php');
                    }
                    else alert("PHP Error: " + msg);
                }
            </script>
          <div id="upload_results" style="background-color:#fff;"></div>
         </div>
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
</div>
<!-- FOOTER -->
<?php include "footer.inc.php"; ?>
<!-- //FOOTER -->

</body>
</html>