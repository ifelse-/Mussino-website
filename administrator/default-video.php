<?php 
include("../config/functions.inc.php");
include("session.inc.php");
$list_page ='default-video-list.php';
$head_page ='default-video.php';

$sql = "SELECT * FROM default_video_master WHERE Video_Id ='".$_GET['id']."'";
$result = mysql_query($sql);
$colles = mysql_fetch_array($result);


if(isset($_REQUEST['submit']))
{ 

  @extract($_POST);
  $Video_Name = addslashes($Video_Name);
    
  if($_REQUEST['id']!='')
	{
		$sql = "SELECT * FROM default_video_master WHERE Video_Name = '".$Video_Name."' AND Display = '".$Display."'  AND Video_Id !='".$_REQUEST['id']."'";
		$result = mysql_query($sql) or die('<br>'.$sql.'<br>'.mysql_error());
		if(mysql_num_rows($result)>0)
		{
			$_SESSION['sess_mess'] = "Video already exist";
			header("location: ". $head_page."?id=".$_REQUEST['id']);
		    exit;
		}
		else
		{	
			
			if(!empty($_FILES['Video_File']['name']))
			{
			
				if($colles['Video_File']!='')
				{
				$image_name = $colles['Video_File'];
				$path = "../products/default_video/";
				$target_path = $path.$image_name;
				unlink($target_path);
				}

				list($getname,$getext) = explode(".",$_FILES['Video_File']['name']);
				$lastId = $_GET['id'];
				$create_name = "Default_File_".$lastId;
				$new_filename = $create_name.".".$getext;
				$upload_path = "../products/default_video/".$new_filename;
				
				move_uploaded_file($_FILES['Video_File']['tmp_name'],$upload_path);
				
		   }
		   else
		   {
		   $new_filename = $colles['Video_File'];
		   }
		   
		   
		   
			
			$sql = "UPDATE default_video_master SET 
					Video_Name = '$Video_Name',
					Video_File = '".trim($new_filename)."',
					Video_Embded_File = '".addslashes($Video_Embded_File)."',
					Display = '".$Display."',
					Status = '$Status'
					WHERE 	Video_Id = '".$_REQUEST['id']."'";
			$result = mysql_query($sql) or die('<br>'.$sql.'<br>'.mysql_error());
			$_SESSION['sess_mess'] = "Video updated successfully.";
			header("location: ". $list_page);
			exit;
		}
	}
	else
	{
		
			$sql = "SELECT * FROM default_video_master WHERE Video_Name = '".$Video_Name."' AND Display = '".$Display."' ";
			$result = mysql_query($sql) or die('<br>'.$sql.'<br>'.mysql_error());
			if(mysql_num_rows($result)>0)
			{
				$_SESSION['sess_mess'] = "Video already exist";
				header("location: ". $head_page);
		        exit;
			}
			else
			{
			
				
				$sql = "INSERT INTO default_video_master SET
						Video_Name = '$Video_Name',
						Video_Embded_File = '".addslashes($Video_Embded_File)."',
					    Display = '".$Display."',
						Video_Date = now(),
					    Status = '$Status'";
				$result = mysql_query($sql) or die('<br>'.$sql.'<br>'.mysql_error());
				
				$lastId = mysql_insert_id();
				if(!empty($_FILES['Video_File']['name']))
				{
					list($getname,$getext) = explode(".",$_FILES['Video_File']['name']);
					$create_name = "Default_File_".$lastId;
					$new_filename = $create_name.".".$getext;
					$upload_path = "../products/default_video/".$new_filename;
					move_uploaded_file($_FILES['Video_File']['tmp_name'],$upload_path);
					$sql_update = mysql_query("UPDATE default_video_master SET Video_File='".$new_filename."' WHERE Video_Id='".$lastId."'");
	     	    }
				/*if(!empty($_FILES['Video_Image']['name']))
				{
					list($getname,$getext) = explode(".",$_FILES['Video_Image']['name']);
					$create_name = "Video_File_Image".$lastId;
					$new_filename_image = $create_name.".".$getext;
					$upload_path = "../products/default_video/".$new_filename_image;
					move_uploaded_file($_FILES['Video_Image']['tmp_name'],$upload_path);
					$sql_update = mysql_query("UPDATE default_video_master SET Video_Image='".$new_filename_image."' WHERE Video_Id='".$lastId."'");
	     	    }*/
				
				$_SESSION['sess_mess'] =  "Video successfully added";
				header("location: ". $list_page);
				exit;
			}
		
	}
  
	
}


if($_GET['id']!='')
{
$sql = "SELECT * FROM default_video_master WHERE Video_Id ='".$_GET['id']."'";
$result = mysql_query($sql) or die('<br>'.$sql.'<br>'.mysql_error());
$dataColles = mysql_fetch_array($result);
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Administrator</title>
<link href="css/layout-admin.css" rel="stylesheet" type="text/css" />
<link href="css/css.css" rel="stylesheet" type="text/css">
<script language="javascript">
function validateFileExtension1234(fld) 
{

	if(!/(\.avi|\.AVI|\.3gp|\.3GP|\.flv|\.FLV|\.mkv|\.MKV|\.mp3|\.MP3|\.mp4|\.MP4|\.mpeg|\.MPEG|\.WMA|\.wma|\.wmv|\.WMV)$/i.test(fld.value)) 
	{
	alert("Invalid image file type.");
	fld.form.reset();
	fld.focus();
	return false;
	}
	return true;
}
function validateFileExtensionImage(fld) 
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
function validateFormOnSubmit(theForm) {
var reason = "";

	reason += validateEmpty(theForm.Video_Name);
	
	
  if (reason != "") {
    alert("You must fill out the following fields : \n\n" + reason);
    return false;
  } else
	{ return true; }
}



function validateEmpty(fld) {
    var error = "";
 
    if (fld.value.length == 0) {
        fld.style.background = 'Yellow'; 
        error = "VIDEO NAME \n"
    } else {
        fld.style.background = 'White';
    }
    return error;  
}


</script>
</head>

<body>
<div id="wrapper">
  <div class="header-container">
   <? include"header.inc.php"?> 
  
  </div>
  <div class="content-container-2">
<div class="content-container">
    <div class="left-navigation fl">
      <div class="left-navigation_inner">
        <? require_once "left.inc.php"; ?>
      </div>
    </div>
    <div class="detail-col fr">
      <div class="detail-col_inner">
       <form name="placeadd" id="placeadd" action="<?=$PHP_SELF?>" method="POST" enctype="multipart/form-data"  onSubmit="return validateFormOnSubmit(this)">
       <div class="box-1">
       <h2> Default Audio Or Video <?=$_GET['id']!='' ? 'Edit' : 'Add';?></h2>
       <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table-1">
          <?
          if($_SESSION['sess_mess']!='') {
          ?>
          <tr>
            <td align="left" valign="middle" colspan="2" style="padding: 5px 0 5px 210px; font-weight:bolder; color:#666666; font-size:14px;">
             <?=$_SESSION['sess_mess']?><? $_SESSION['sess_mess']="";?>         
            </td>
            </tr>
        <? } ?>
          <tr>
            <td width="200" align="left" valign="middle">Audio Or Video Name</td>
            <td align="left" valign="top" class="input-1"><input type="text" name="Video_Name" value="<?=stripslashes(trim($dataColles['Video_Name']));?>"  size="50" class="textbox"></td>
          </tr>
          
         
         
         <?php if($_GET['id']!='') { ?>
          <tr>
            <td width="200" align="left" valign="middle"></td>
            <td align="left" valign="top" class="input-1" height="30">
			<?php 
			if(file_exists("../products/default_video/$dataColles[Video_File]") && $dataColles['Video_File']!='') 
			{ 
			echo $dataColles['Video_File'];
			?> 
           
            <?php
            } 
			elseif($dataColles['Video_Embded_File']!='') 
			{
            echo $dataColles['Video_Embded_File'];
            } 
			?>
            </td>  
          </tr>
          <?php } ?>
          
          <tr valign="top">
                    <td width="200" align="left" valign="middle">Audio Or Video File</td>
                    <td align="left" valign="top" class="input-1"><input type="file" name="Video_File" id="Video_File" class="input-text" size="30" onChange="validateFileExtension1234(this)"><br /><span style="font-family:Arial, Helvetica, sans-serif; font-size:11px; color:#25A6D5">[ only upload avi, 3gp, flv, mkv, mov, mp3, mp4, mpeg, wma, wmv ]</span></td>
         </tr>
         
        
          
          <tr>
            <td align="left" valign="middle">Status</td>
            <td align="left" valign="top" class="input-1">
              <select name="Status" size="1" class="textbox">
                  <option value="1" <? if($dataColles['Status']=='1') { echo "SELECTED";}?>>Active</option>
                  <option value="0" <? if($dataColles['Status']=='0') { echo "SELECTED";}?>>Inactive</option>
                </select>
            </td>
          </tr>
          <tr>
            <td align="left" valign="middle"><input type="hidden" name="id" value="<?=$dataColles['Video_Id'];?>" /></td>
            <td align="left" valign="top" class="input-2"><input type="submit" name="submit" value="<?php if($_REQUEST['id']!='') { echo 'Update'; } else { echo'Insert Record'; }?>"  class="buttons" /></td>
          </tr>
        </table>
       </div>
       
        </form>
      </div>
    </div>
    <div class="cl"></div>
  </div></div>
  <? include"footer.inc.php"?>
</div>

</body>
</html>
