<?php 
include("../config/functions.inc.php");
include("session.inc.php");
$list_page ='unreleased-product-list.php';
$head_page ='unreleased-product.php';

$sql_cat = "SELECT Category_Id, Category_Name FROM category_master WHERE Status=1 AND Parent_Id='0' ORDER BY Category_Name";
$result_cat = mysql_query($sql_cat) or die('<br>'.$sql_cat.'<br>'.mysql_error());

$sql_pro = "SELECT * FROM product_master WHERE Product_Id='".$_REQUEST['id']."'";
$result_pro = mysql_query($sql_pro);
$colles_pro = mysql_fetch_array($result_pro);

$member_id = $colles_pro['Member_Account_Id'];

if($_GET['img']!="")
{
if($_GET['name']=="Image_Name"){ unlink("../products/product_image/".$_GET['img']); }
if($_GET['name']=="bigVideo"){ unlink("../products/large_video/".$_GET['img']); }
if($_GET['name']!="") { executeQuery("update products set ".$_GET['name']."='' where 1 AND Product_Id='".$_GET['id']."' "); }
}

 
	
if($_POST['Image_Name']!='') {  $smallImage = $_POST['Image_Name']; } else {  $smallImage = $colles_pro['Image_Name']; }	 
if($_POST['smallVideo']!='') { $smallVideo = $_POST['smallVideo']; } else { $smallVideo = $colles_pro['Short_FIle_Name']; }


if($_REQUEST['id']!="" && isset($_POST['buttonSubmit']))
{ 
			
			@extract($_POST);
					
			
			$sql = "SELECT * FROM product_master WHERE Title='".$Title."' AND Product_Id!='".$id."'";
			$result = mysql_query($sql);
			if(mysql_num_rows($result)>0)
			{
			$_SESSION['sess_mess']="Product Title Already Exist";
			header("location: product.php"); 
			exit();
			}
			else
			{		
			
			executeQuery("UPDATE product_master SET Image_Name='".$smallImage."' where Product_Id='".$_POST['id']."'");
			executeQuery("UPDATE product_master SET Short_FIle_Name='".$smallVideo."' where Product_Id='".$_POST['id']."'");
			
			   
			$query= "UPDATE product_master SET
			         Member_Account_Id = '".$member_id."',
			         Title = '".addslashes(trim($Title))."',
					 Sound = '".addslashes(trim($_POST['Sound']))."',
					 Type = '3',
					 Price = '".addslashes(trim($Price))."',
					 Short_Desc = '".addslashes(trim($Short_Desc))."',
					 Category_Id = '".$_POST['Category_Id']."',
					 New_Music_Releases = '".$New_Music_Releases."'
					 WHERE Product_Id='".$_POST['id']."'";
			executeQuery($query);

			
	        $_SESSION['sess_mess']="Data updated successfully";
			header("location: product-list.php");
			exit();
			}
		
}

////update record

if($_POST['id']=="" && isset($_POST['buttonSubmit']))
{ 
	     			
						
					$smallVideo = trim($_POST['smallVideo']);
					$smallImage = trim($_POST['Image_Name']);
										
					
					$sql = "SELECT * FROM product_master WHERE Title='".$Title."'";
					$result = mysql_query($sql);
					if(mysql_num_rows($result)>0)
					{
					$_SESSION['sess_mess']="Product Title Already Exist";
					header("location: product.php"); 
					exit();
					}
					else
					{
		            $query = "INSERT INTO product_master SET
			                  Title = '".addslashes(trim($_POST['Title']))."',
							  Sound = '".addslashes(trim($_POST['Sound']))."',
							  Type = '3',
							  Price = '".addslashes(trim($_POST['Price']))."',
							  Short_Desc = '".addslashes(trim($_POST['Short_Desc']))."',
							  Category_Id = '".$_POST['Category_Id']."',
							  Image_Name = '".$smallImage."',
							  New_Music_Releases = '".$New_Music_Releases."',
							  Short_FIle_Name = '".$smallVideo."',
							  Product_Date = now(),
							  Status ='1' ";
					 
			        executeQuery($query);
					
			        
				$_SESSION['sess_mess']="Record saved successfully";
				header("location: product-list.php"); 
				exit();
				}
		
}


if($_GET['id']!='')
{
$sql = "SELECT * FROM product_master WHERE Type=3 AND Product_Id ='".$_GET['id']."'";
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
<script type="text/javascript" src="javascript/jquery-1.3.2.js" ></script>
<script type="text/javascript" src="javascript/ajaxupload.3.5.js" ></script>
<script type="text/javascript" src="javascript/jquery.js" ></script>
<link rel="stylesheet" type="text/css" href="styles.css" />
<script type="text/javascript" src="../tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<link rel="stylesheet" href="javascript/ui.all.css" type="text/css" media="screen" />

<script type="text/javascript" >
	$(function(){
		var btnUpload=$('#imageupload');
		var status=$('#imagestatus');
		new AjaxUpload(btnUpload, {
			action: 'small_image.php',
			name: 'imagefile',
			onSubmit: function(file, ext){
				 if($("#imagefiles li").children().is("img"))
				 	{
					 alert("Thumbnail already exist, Please delete before upload new one")
					 return false;
					}
				 if (! (ext && /^(jpg|png|bmp|jpeg|gif)$/.test(ext))){ 
                    // extension is not allowed 
					status.text('Only JPG, BMP, PNG or GIF files are allowed');
					return false;
				}
				status.html('<img src="loading.gif"/>');
			},
			onComplete: function(file, response){
				//On completion clear the status
				var arrayNode=response.split("|")
				status.text('');
				//Add uploaded file to list
				if(arrayNode[2]==="success"){
				status.html('');
				
				$('<li></li>').appendTo('#imagefiles').html('<img src="'+arrayNode[1]+'" alt="" /><br />'+arrayNode[0]).addClass('success');
				$('<input type="hidden" name="Image_Name"/>').appendTo('#imagefiles').val(arrayNode[0]).addClass('success');
				$("<img id=\"DelImage\" style=\"cursor:pointer;\" src=\"images/delete-icn.gif\" onclick=\"deleteImage('"+arrayNode[1]+"','delsmallProductImage.php','#imagefiles','')\" border=\"0\" title=\"Delete Product Thumbnail\">").appendTo('#imagefiles');
				} else{
					$('<li></li>').appendTo('#imagefiles').text(arrayNode[0]).addClass('error');
				}
			}
		});
		
	});
</script>

<script type="text/javascript" >
// for small video
	$(function(){
		var btnUpload=$('#small_video_upload');
		var status=$('#small_video_status');
		new AjaxUpload(btnUpload, {
			action: 'small_video.php',
			name: 'small_video_uploadfile',
			onSubmit: function(file, ext){
				 if($("#small_video_files li").children().is("img"))
				 	{
					 alert("Teaser video already exist, Please delete before upload new one")
					 return false;
					}
				 if ((ext && /^(jpg|png|bmp|jpeg|gif)$/.test(ext))){ 
                    // extension is not allowed 
					status.text('JPG, PNG, BMP or GIF files are not allowed');
					return false;
				}
				status.html('<img src="loading.gif"/>');
			},
			onComplete: function(file, response){
				//On completion clear the status
				var arrayNode=response.split("|")
				status.text('');
				//Add uploaded file to list
				if(arrayNode[2]==="success"){
				status.html('');
				// $('<li></li>').appendTo('#small_video_files').html('<img src="'+arrayNode[1]+'" alt="" /><br />'+arrayNode[0]).addClass('success');
				$('<li></li>').appendTo('#small_video_files').html(arrayNode[0]).addClass('success');
				$('<input type="hidden" name="smallVideo"/>').appendTo('#small_video_files').val(arrayNode[0]).addClass('success');
				$("<img id=\"DelImage\" style=\"cursor:pointer;\" src=\"images/delete-icn.gif\" onclick=\"deleteImage('"+arrayNode[1]+"','delSmallVideo.php','#small_video_files','')\" border=\"0\" title=\"Delete Product Teaser Video\">").appendTo('#small_video_files');
				} else{
					$('<li></li>').appendTo('#small_video_files').text(arrayNode[0]).addClass('error');
				}
			}
		});
		
	});
	


</script>

<script type="text/javascript" >
// big video
	$(function(){
		var btnUpload=$('#big_video_upload');
		var status=$('#big_video_status');
		new AjaxUpload(btnUpload, {
			action: 'big_video.php',
			name: 'big_video_uploadfile',
			onSubmit: function(file, ext){
				 if($("#big_video_files li").children().is("img"))
				 	{
					 alert("Solution video already exist, Please delete before upload new one")
					 return false;
					}
				 if ((ext && /^(jpg|png|bmp|jpeg|gif)$/.test(ext))){ 
                    // extension is not allowed 
					status.text('JPG, PNG, BMP or GIF files are not allowed');
					return false;
				}
				status.html('<img src="loading.gif"/>');
			},
			onComplete: function(file, response){
				//On completion clear the status
				var arrayNode=response.split("|")
				status.text('');
				//Add uploaded file to list
				if(arrayNode[2]==="success"){
				status.html('');
				$('<li></li>').appendTo('#big_video_files').html(arrayNode[0]).addClass('success');
				$('<input type="hidden" name="bigVideo"/>').appendTo('#big_video_files').val(arrayNode[0]).addClass('success');
				$("<img id=\"DelImage\" style=\"cursor:pointer;\" src=\"images/delete-icn.gif\" onclick=\"deleteImage('"+arrayNode[1]+"','delBigVideo.php','#big_video_files','')\" border=\"0\" title=\"Delete Product Solution Video\">").appendTo('#big_video_files');
				} else{
					$('<li></li>').appendTo('#big_video_files').text(arrayNode[0]).addClass('error');
				}
			}
		});
		
	});
	


</script>

<script language="javascript">

function validateRegisterFormOnSubmit(theForm) {
var reason = "";

	reason += validateEmpty(theForm.Title);
	reason += validateEmpty1(theForm.Sound);
	reason += validateEmpty2(theForm.Category_Id);
	
         
  if (reason != "") {
    alert("You must fill out the following fields :\n\n" + reason);
    return false;
  } else
	{ return true; }
}

function validateEmpty(fld) {
    var error = "";
 
    if (fld.value.length == 0) {
        fld.style.background = '#EAE1C1'; 
        error = "Title \n"
    } else {
        fld.style.background = '#FFFFFF';
    }
    return error;  
}

function validateEmpty1(fld) {
    var error = "";
 
    if (fld.value.length == 0) {
        fld.style.background = '#EAE1C1'; 
        error = "Sound Type \n"
    } else {
        fld.style.background = '#FFFFFF';
    }
    return error;  
}
function validateEmpty2(fld) {
    var error = "";
 
    if (fld.value.length == 0) {
        fld.style.background = '#EAE1C1'; 
        error = "Category \n"
    } else {
        fld.style.background = '#FFFFFF';
    }
    return error;  
}

	
tinyMCE.init({
		// General options
		mode : "exact",
		elements : "Short_Desc",
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
       <form name="placeadd" id="placeadd" action="<?=$PHP_SELF?>" method="POST"  enctype="multipart/form-data" onsubmit="return validateRegisterFormOnSubmit(this)">
       <div class="box-1">
       <h2> unreleased Product <?=$_GET['id']!='' ? 'Edit' : 'Add';?></h2>
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
            <td width="200" align="left" valign="middle"> Title </td>
            <td align="left" valign="top" class="input-1"><input type="text" name="Title" value="<?=stripslashes(trim($dataColles['Title']));?>"  size="50" class="textbox"></td>
          </tr>
          
          
          <tr>
            <td width="200" align="left" valign="middle" >Sound Type</td>
            <td align="left" valign="top" class="input-1">
            <select name="Sound" size="1" class="input-text" style="width:213px;">
            <option value="">Select</option>
             <?php
			$sql_type_master = "SELECT * FROM sound_type_master WHERE Status='1'  ORDER BY Sound_Type_Name";
			$result_type_master = mysql_query($sql_type_master);
			while($colles_type_master = mysql_fetch_array($result_type_master))
			{
			?>
			<option value="<?=$colles_type_master['Sound_Type_Id']?>" <? if($dataColles['Sound']==$colles_type_master['Sound_Type_Id']) { echo "SELECTED";}?>><?=stripslashes($colles_type_master['Sound_Type_Name'])?></option>
			<?php
			} 
			?>
           </select> 
            </td>
          </tr>
          
          
           <tr>
            <td width="200" align="left" valign="middle">Release Price</td>
            <td align="left" valign="top" class="input-1"><input type="text" name="Price" value="<?=stripslashes(trim($dataColles['Price']));?>"  size="50" class="textbox"></td>
          </tr>
          
          
          <tr>
            <td width="200" align="left" valign="middle">Category</td>
            <td align="left" valign="top" class="input-1">
            <select name="Category_Id" id="Category_Id" style="width:213px;" class="input-text" >
            <option value="">Select</option>
            <?php
            while($colles_cat = mysql_fetch_array($result_cat))
            {
            $catName = stripslashes($colles_cat['Category_Name']);
            $catId = $colles_cat['Category_Id']
            ?>
            <option value="<?=$catId?>" <?php if($catId==$dataColles['Category_Id']) { echo 'selected'; } ?> ><?=$catName?></option>
            <?php
            }
            ?>
            </select>
            </td>
          </tr>
          
          <tr>
            <td width="200" align="left" valign="middle">Description</td>
            <td align="left" valign="top" class="input-1"><textarea id="Short_Desc" rows="2" cols="27" class="input-text" name="Short_Desc"><?=stripslashes($dataColles['Short_Desc'])?></textarea></td>
          </tr>
          
                    
            <tr valign="top">
            <td width="30%">Image </td>
            <td width="70%"><div id="imageupload"></div><span id="imagestatus" ></span></td>
            </tr>
            
            <tr valign="top">
            <td width="30%"> </td>
            <td width="70%">
             <ul id="imagefiles" >
            <?php			  
            if (file_exists("../products/product_image/".$dataColles['Image_Name'])) 
            {
            if(file_exists("../products/product_image/".$dataColles['Image_Name']) && $dataColles['Image_Name']!="") 
            { 
            ?>
            <li><img src="../products/product_image/<?=$dataColles['Image_Name']?>">
            <img id="DelImage" style="cursor:pointer;" src="images/delete-icn.gif" onclick="deleteImage('<?="../products/product_image/".$dataColles['Image_Name']?>','delsmallProductImage.php','#imagefiles','<?=$dataColles['Product_Id']?>')" border="0" title="Delete Product Image"/></li>

            <?
            }
            } 
            else 
            {
            echo "Image not upload";
            }
            ?>
            </ul>  
            </td>
            </tr>
            
            <tr valign="top">
            <td width="30%">Music</td>
            <td width="70%"><div id="small_video_upload" >&nbsp;</div><span id="small_video_status" ></span></td>
            </tr>
            
            <tr valign="top">
            <td width="30%"></td>
            <td width="70%" id="videogallery">
            <ul id="small_video_files">
    
               <?php 
               if (file_exists("../products/small_video/".$dataColles['Short_FIle_Name'])) 
               { 
               if(file_exists("../products/small_video/".$dataColles['Short_FIle_Name']) && $dataColles['Short_FIle_Name']!="") 
               {
               ?>
                <li>
                <a rel="#voverlay" href="video/engine/swf/player.swf?url=../../../../products/small_video/<?=$dataColles['Short_FIle_Name']?>" title="demonstration_bk"><span style="color:#00FF00">Show Teaser Video &nbsp;&nbsp; <?=$dataColles['Short_FIle_Name']?></span></a> </li>
                <img id="DelImage" style="cursor:pointer;" src="images/delete-icn.gif" onclick="deleteImage('<?="../products/small_video/".$dataColles['Short_FIle_Name']?>','delSmallVideo.php','#small_video_files','<?=$dataColles['Product_Id']?>')" border="0" title="Delete Product Small Video"/>
                <?  
                } 
                } 
                else 
                { 
                echo "Small video not upload"; 
                } 
                ?>
                
            </ul>
            </td>
            </tr>
                    
          
           <tr>
            <td width="200" align="left" valign="middle">Top Releases</td>
            <td align="left" valign="top" ><input type="checkbox" name="New_Music_Releases" value="1" <?php if($dataColles['New_Music_Releases']=='1') { echo'checked'; }?>  class="textbox"></td>
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
            <td align="left" valign="middle"><input type="hidden" name="id" value="<?=$dataColles['Product_Id'];?>" /></td>
            <td align="left" valign="top" class="input-2"><input type="submit" name="buttonSubmit" value="<?php if($_REQUEST['id']!='') { echo 'Update'; } else { echo'Insert Record'; }?>"  class="buttons" /></td>
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
