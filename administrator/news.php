<?php 
include("../config/functions.inc.php");
include("session.inc.php");
$list_page ='news-list.php';
$head_page ='news.php';


$sql = "SELECT * FROM news_master WHERE News_Id ='".$_GET['id']."'";
$result = mysql_query($sql);
$colles = mysql_fetch_array($result);


if(isset($_REQUEST['submit']))
{ 

  @extract($_POST);
  @extract($_REQUEST);
  $Title = addslashes($Title);
  $Desc = addslashes(trim($Desc));
    
  if($_REQUEST['id']!='')
	{
		$sql = "SELECT * FROM news_master WHERE Title = '$Title'  AND News_Id !='".$_REQUEST['id']."'";
		$result = mysql_query($sql) or die('<br>'.$sql.'<br>'.mysql_error());
		if(mysql_num_rows($result)>0)
		{
			$_SESSION['sess_mess'] = "News already exist";
			header("location: ". $head_page."?id=".$_REQUEST['id']);
		    exit;
		}
		else
		{	
			list($m,$d,$y) = explode('-',$Date);
			$Date = $y.'-'.$m.'-'.$d;
			
			if(!empty($_FILES['Image']['name']))
			{
			
				if($colles['Image']!='')
				{
				$image_name = $colles['Image'];
				$path = "../products/news_image/";
				$target_path = $path.$image_name;
				unlink($target_path);
				}

				list($getname,$getext) = explode(".",$_FILES['Image']['name']);
				$lastId = $_GET['id'];
				$create_name = "Image_".$lastId;
				$new_filename = $create_name.".".$getext;
				$upload_path = "../products/news_image/".$new_filename;

				move_uploaded_file($_FILES['Image']['tmp_name'],$upload_path);
		   }
		   else
		   {
		   $new_filename = $colles['Image'];
		   }
			
			
			
			$sql = "UPDATE news_master SET 
					Title = '$Title',
					Type = '$Type',
					Image = '".trim($new_filename)."',
					`Desc` = '$Desc',
					Date = '$Date',
					Status = '$Status'
					WHERE News_Id = '".$_REQUEST['id']."'";
			$result = mysql_query($sql) or die('<br>'.$sql.'<br>'.mysql_error());
			$_SESSION['sess_mess'] = "News updated successfully.";
			header("location: ". $list_page);
			exit;
		}
	}
	else
	{
		
			$sql = "SELECT * FROM news_master WHERE Title = '$Title'  ";
			$result = mysql_query($sql) or die('<br>'.$sql.'<br>'.mysql_error());
			if(mysql_num_rows($result)>0)
			{
				$_SESSION['sess_mess'] = "News already exist";
				header("location: ". $head_page);
		        exit;
			}
			else
			{
			 
			 list($m,$d,$y) = explode('-',$Date);
			 $Date = $y.'-'.$m.'-'.$d;
			 
			  $sql = "INSERT INTO news_master SET
						Title = '$Title',
						Type = '$Type',
						`Desc` = '".trim($Desc)."',
						Date = '".$Date."',
						Status = '$Status'";
				$result = mysql_query($sql) or die('<br>'.$sql.'<br>'.mysql_error());
				
				$lastId = mysql_insert_id();
				if(!empty($_FILES['Image']['name']))
				{
					list($getname,$getext) = explode(".",$_FILES['Image']['name']);
					$create_name = "Image_".$lastId;
					$new_filename = $create_name.".".$getext;
					$upload_path = "../products/news_image/".$new_filename;
					move_uploaded_file($_FILES['Image']['tmp_name'],$upload_path);
					$sql_update = mysql_query("UPDATE news_master SET Image='".$new_filename."' WHERE News_Id='".$lastId."'");
	     	    }
				
				
				$_SESSION['sess_mess'] =  "News successfully added";
				header("location: ". $list_page);
				exit;
				
			}
		
	}
  
	
}


if($_GET['id']!='')
{
$sql = "SELECT * FROM news_master WHERE News_Id ='".$_GET['id']."'";
$result = mysql_query($sql) or die('<br>'.$sql.'<br>'.mysql_error());
$dataColles = mysql_fetch_array($result);
list($y,$m,$d) = explode('-',$dataColles['Date']);
$Date = $m.'-'.$d.'-'.$y;
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Administrator</title>
<link href="css/layout-admin.css" rel="stylesheet" type="text/css" />
<link href="css/css.css" rel="stylesheet" type="text/css">
<link href="css/css.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<link rel="stylesheet" href="jquery/ui.all.css" type="text/css" media="screen" />
<script type="text/javascript" src="jquery/jquery.js"></script>
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
<script>
function validate_submitsite_form(placeadd) 
{
	
	if (placeadd.Title.value == "") 
	{
		alert("\nPlease enter title name.")
		placeadd.Title.focus();
		return false;
	}
	else if (placeadd.Type.value == "") 
	{
		alert("\nPlease select type.")
		placeadd.Type.focus();
		return false;
	}
	
	else if (placeadd.Date.value == "") 
	{
		alert("\nPlease select date.")
		placeadd.Date.focus();
		return false;
	}
	
} 
tinyMCE.init({
		// General options
		mode : "exact",
		elements : "Desc",
		theme : "simple"
	});
</script>
</head>

<body>
<div id="wrapper">
  <div class="header-container">
   <? include"header.inc.php"?> 
  
  </div>
  <div class="content-container">
    <div class="left-navigation fl">
      <div class="left-navigation_inner">
        <? require_once "left.inc.php"; ?>
      </div>
    </div>
    <div class="detail-col fr">
      <div class="detail-col_inner">
       <form name="placeadd" id="placeadd" action="<?=$PHP_SELF?>" method="POST"  enctype="multipart/form-data" onSubmit="return validate_submitsite_form(placeadd)">
       <div class="box-1">
       <h2> News <?=$_GET['id']!='' ? 'Edit' : 'Add';?></h2>
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
            <td width="200" align="left" valign="middle">Title</td>
            <td align="left" valign="top" class="input-1"><input type="text" name="Title" value="<?=stripslashes(trim($dataColles['Title']));?>"  size="50" class="textbox"></td>
          </tr>
          
           <tr>
            <td align="left" valign="middle">Type</td>
            <td align="left" valign="top" class="input-1">
              <select name="Type" size="1" class="textbox">
                  <option value="">Select</option>
                  <option value="Latest Artist" <? if($dataColles['Type']=='Latest Artist') { echo "SELECTED";}?>>Learn Mussino</option>
                  <option value="Latest Musician" <? if($dataColles['Type']=='Latest Musician') { echo "SELECTED";}?>>Promotion Advertisment </option>
             </select>
            </td>
          </tr>
          
           <?php if($_GET['id']!='') { ?>
          <tr>
            <td width="200" align="left" valign="middle"></td>
            <td align="left" valign="top" class="input-1">
			<?php if(file_exists("../products/news_image/$dataColles[Image]") && $dataColles['Image']!='') { ?>
            <img src="../products/news_image/<?php echo $dataColles['Image']; ?>" border="0" width="100" height="100" />
            <?php } else { ?>
            <img src="../images/no-image.gif" border="0" width="100" height="150" />
            <?php } ?>
            </td>  
          </tr>
          <?php } ?>
          
          <tr valign="top">
                    <td width="200" align="left" valign="middle">Image </td>
                    <td align="left" valign="top" class="input-1"><input type="file" name="Image" id="Image" class="input-text" size="30" onChange="validateFileExtension1234(this)"><br /><span style="font-family:Arial, Helvetica, sans-serif; font-size:11px; color:#25A6D5">[ only upload png, gif, jpg, jpeg ]</span></td>
         </tr>
          
          <tr>
            <td width="200" align="left" valign="middle">Description</td>
            <td align="left" valign="top" class="input-1"> <textarea name="Desc" rows="3" cols="60"><?=stripslashes($dataColles['Desc'])?></textarea></td>
          </tr>
          
          <tr>
            <td width="200" align="left" valign="middle">Date</td>
            <td align="left" valign="top" class="input-1"> 
            <input type="text" name="Date" id="Date" readonly="" size="12" value="<?=$Date?>">
            <script type="text/javascript" src="jquery/1.5.3_jquery-ui.min.js"></script>
            <script type="text/javascript">
			$(document).ready(function(){
					$("#Date").datepicker({ yearRange: '1947:2020', showOn: 'button', buttonImageOnly: true, altField: 'input#Date', altFormat: 'mm-dd-yy', buttonImage: 'images/img_cal.gif'});
			});
	       </script>
            </td>
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
            <td align="left" valign="middle"><input type="hidden" name="id" value="<?=$dataColles['News_Id'];?>" /></td>
            <td align="left" valign="top" class="input-2"><input type="submit" name="submit" value="<?php if($_REQUEST['id']!='') { echo 'Update'; } else { echo'Insert Record'; }?>"  class="buttons" /></td>
          </tr>
        </table>
       </div>
       
        </form>
      </div>
    </div>
    <div class="cl"></div>
  </div>
  <? include"footer.inc.php"?>
</div>

</body>
</html>
