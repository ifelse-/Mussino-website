<?php 
ob_start();
require_once "config/functions.inc.php";
require_once "session.inc.php"; 
$pageName = basename($_SERVER['PHP_SELF']); 
$sql = "SELECT * FROM member_account_master WHERE Member_Account_Id='".$_SESSION['SESS_ID']."'";
$result = mysql_query($sql);
$colles = mysql_fetch_array($result);

###########################




$sql_pro = "SELECT * FROM product_master WHERE Product_Id='".$_REQUEST['id']."'";
$result_pro = mysql_query($sql_pro);
$colles_pro = mysql_fetch_array($result_pro);
@extract($colles_pro);


if($_GET['img']!="")
{
if($_GET['name']=="Image_Name"){ unlink("products/product_image/".$_GET['img']); }
if($_GET['name']=="smallVideo"){ unlink("products/small_video/".$_GET['img']); }
if($_GET['name']!="") { executeQuery("update product_master set ".$_GET['name']."='' where 1 AND Product_Id='".$_GET['id']."' "); }
}

 
	
if($_POST['Image_Name']!='') { $smallImage = $_POST['Image_Name']; } else { $smallImage = $Image_Name; }	 
if($_POST['smallVideo']!='') { $smallVideo = $_POST['smallVideo']; } else { $smallVideo = $Short_FIle_Name; }

 

if($_REQUEST['id']!="" && isset($_POST['buttonSubmit']))
{ 
			
			@extract($_POST);
			
			/*$sql = "SELECT * FROM product_master WHERE Title='".$Title."' AND Product_Id!='".$id."'";
			$result = mysql_query($sql);
			if(mysql_num_rows($result)>0)
			{
			$_SESSION['sess_messs']="Title Already Exist";
			}
			else
			{	*/	
						
			executeQuery("UPDATE product_master SET Image_Name='".$smallImage."' where Product_Id='".$_POST['id']."'");
			executeQuery("UPDATE product_master SET Short_FIle_Name='".$smallVideo."' where Product_Id='".$_POST['id']."'");
			
			   
			$query= "UPDATE product_master SET
			         Member_Account_Id = '".$_SESSION['SESS_ID']."',
			         Title = '".addslashes(trim($_POST['Title']))."',
					 Sound = '".addslashes(trim($_POST['Sound']))."',
					 Product_Notes = '".trim($Product_Notes)."',
					 Type = '5',
					 Price = '".addslashes(trim($Price))."',
					 Short_Desc = '".addslashes(trim($Short_Desc))."',
					 Category_Id = '".$_POST['Category_Id']."'
					 WHERE Product_Id='".$_POST['id']."'";
			executeQuery($query);

			
	        $_SESSION['sess_messs']="Data updated successfully";
			header("location: artist-music-store-list.php");
			exit();
			//}
		


}

### update record

if($_POST['id']=="" && isset($_POST['buttonSubmit']))
{ 
	     													
			$smallVideo = trim($_POST['smallVideo']);
			$smallImage = trim($_POST['Image_Name']);
													
			
			/*$sql = "SELECT * FROM product_master WHERE Title='".$Title."'";
			$result = mysql_query($sql);
			if(mysql_num_rows($result)>0)
			{
			$_SESSION['sess_messs']="Title Already Exist";
			}
			else
			{*/
			    $name = $_REQUEST['name'];
				$output = $_REQUEST['output'];
		        $sig_hash = sha1($output);
			   
			   $query = "INSERT INTO product_master SET
						 Member_Account_Id = '".$_SESSION['SESS_ID']."',
						 Title = '".addslashes(trim($_POST['Title']))."',
						 Product_Notes = '".trim($_POST['Product_Notes'])."',
						 Sound = '".addslashes(trim($_POST['Sound']))."',
						 Type = '5',
						 Price = '".addslashes(trim($_POST['Price']))."',
						 Short_Desc = '".addslashes(trim($_POST['Short_Desc']))."',
						 Category_Id = '".$_POST['Category_Id']."',
						 Image_Name = '".$smallImage."',
						 Short_FIle_Name = '".$smallVideo."',
						 Long_FIle_Name = '".$bigVideo."',
						 Signator = '".addslashes(trim($name))."',
				         Signature = '".addslashes(trim($output))."',
				         Sig_Hash = '".trim($sig_hash)."',
						 Product_Date = now(),
						 Status ='1' ";
						 executeQuery($query);
			 
			  # Email to admin about new registration
			
			$SUBJECT = ucfirst($_SESSION['SESS_FIRST_NAME'].' '.$_SESSION['SESS_LAST_NAME'])." artist create music store  @ Mussino.com";
			$TO  = Get_Single_Field("general_setting_master","Mails_Id","Gen_Set_Id","1");
			
						
			$BODY  = "Title : ".addslashes(trim($_REQUEST['Title']))." \n";
			$BODY .= "Sound : ".Get_Single_Field("sound_type_master","Sound_Type_Name","Sound_Type_Id","$_POST[Sound]")." \n";
			$BODY .= "Release Price : ".addslashes(trim($_REQUEST['Price']))." \n";
			$BODY .= "Details : ".trim($_REQUEST['Short_Desc'])." \n";
											
			
			$HEADER = "From: ".addslashes(trim($_SESSION['SESS_FIRST_NAME']))." <".addslashes(trim($_SESSION['SESS_EMAIL']))."> \n";
			$HEADER .= "Reply-To: $TO <$TO>\n";
			$HEADER .= "X-Mailer: PHP/" . phpversion() . "\n";
			$HEADER .= "X-Priority: 1";
			
			$MAILSEND = @mail($TO, $SUBJECT, $BODY, $HEADER);
							
												
			$_SESSION['sess_messs']="Record saved successfully";
			header("location: artist-music-store-list.php"); 
			exit();
			//}
					
		
}

if($_GET['id']!='')
{
$sql="SELECT * FROM product_master WHERE Type='5' AND Product_Id ='".$_GET['id']."' ";
$result=executeQuery($sql);
$row=mysql_fetch_array($result);
@extract($row);
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>Music Store</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="description" content="Default Description">
<meta name="keywords" content="">
<meta name="robots" content="">
<?php include "common.inc.php"; ?>
<link rel="stylesheet" href="build/jquery.signaturepad.css">
<script type="text/javascript" src="javascript/ajaxupload.3.5.js" ></script>
<script type="text/javascript" src="javascript/jquery.js" ></script>
<script type="text/javascript" src="tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<link rel="stylesheet" type="text/css" href="styles.css" />
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
				 if ( !(ext && /^(flv|FLV|mp3|MP3)$/.test(ext))){                 //avi|AVI|3gp|3GP|flv|FLV|mkv|MKV|mov|MOV|mp3|MP3|mp4|MP4|mpeg|MPEG|wma|WMA|wmv|WMV
                    // extension is not allowed 
					status.text('Only mp3 or flv files are allowed');
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
				 $('<li></li>').appendTo('#small_video_files').html('<img src="'+arrayNode[1]+'" alt="" /><br />'+arrayNode[0]).addClass('success');
				//$('<li></li>').appendTo('#small_video_files').html(arrayNode[0]).addClass('success');
				$('<input type="hidden" name="smallVideo"/>').appendTo('#small_video_files').val(arrayNode[0]).addClass('success');
				$("<img id=\"DelImage\" style=\"cursor:pointer;\" src=\"images/delete-icn.gif\" onclick=\"deleteImage('"+arrayNode[1]+"','delSmallVideo.php','#small_video_files','')\" border=\"0\" title=\"Delete Product Teaser Video\">").appendTo('#small_video_files');
				} else{
					$('<li></li>').appendTo('#small_video_files').text(arrayNode[0]).addClass('error');
				}
			}
		});
		
	});
	

function validateRegisterFormOnSubmit(theForm) {
var reason = "";

	reason += validateEmpty(theForm.Title);
	reason += validateEmpty1(theForm.Sound);
	reason += validateEmpty2(theForm.Price);
	reason += validateEmpty3(theForm.Category_Id);
	/*reason += validateEmpty4(theForm.name);
	reason += validateEmpty5(theForm.output);*/
	
         
  if (reason != "") {
    alert("You must fill out the following fields :\n\n" + reason);
    return false;
  } else
	{ return true; }
}

function validateEmpty(fld) {
    var error = "";
 
    if (fld.value.length == 0) {
        error = "Title \n"
    } 
    return error;  
}

function validateEmpty1(fld) {
    var error = "";
 
    if (fld.value.length == 0) {
        error = "Sound Type \n"
    } 
    return error;  
}
function validateEmpty2(fld) {
    var error = "";
 
    if (fld.value.length == 0) {
       error = "Price \n"
    } 
    return error;  
}

function validateEmpty3(fld) {
    var error = "";
 
    if (fld.value.length == 0) {
       error = "Category \n"
    } 
    return error;  
}
function validateEmpty4(fld) {
    var error = "";
 
    if (fld.value.length == 0) {
       error = "Print your name \n"
    } 
    return error;  
}
function validateEmpty5(fld) {
    var error = "";
 
    if (fld.value.length == 0) {
       error = "Draw it \n"
    } 
    return error;  
}

tinyMCE.init({
		mode : "exact",
		elements : "Short_Desc",
		theme : "simple"
	});

</script>
</head>

<body>
<!-- HEADER -->
<?php include "header.middle.inc.php"; ?>
<div id="wrapper">
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
              &raquo; <?=$_REQUEST['id']==''?Create:Edit?> Music Store 
            </div>
          </div>
        </div>
        
        
        
        <div class="pro-content">
       
        <form action="" method="POST" enctype="multipart/form-data" name="placeadd" id="placeadd" onsubmit="return validateRegisterFormOnSubmit(this)" class="sigPad">
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
              <div class="succes"><?=$_SESSION["sess_messs"]?> <? $_SESSION["sess_messs"]='';?></div>
             <?php } ?>
             <div class="form-container">
              <ul>
                <li>
                  <div id="view_login_result" class="error"></div>
                </li>
                <li class="formBG">
                
               
                  <div class="caption-2">Song Title</div>
                  <div class="input-2">
                  
                  <input type="text" name="Title" id="Title" value="<?=$Title?>" class="input-text textinput" size="30" /></div>
                  <div class="cl"></div>
                </li>
                              
                <li class="formBG0">
                  <div class="caption-2">Sound Type</div>
                  <div class="input-2"><select name="Sound" size="1" class="input-text" style="width:213px;" />
                    <option value="">Select</option>
                    <?php
					$sql_type_master = "SELECT * FROM sound_type_master WHERE Status='1' ORDER BY Sound_Type_Name";
					$result_type_master = mysql_query($sql_type_master);
					while($colles_type_master = mysql_fetch_array($result_type_master))
					{
					?>
                    <option value="<?=$colles_type_master['Sound_Type_Id']?>" <? if($colles_pro['Sound']==$colles_type_master['Sound_Type_Id']) { echo "SELECTED";}?>><?=stripslashes($colles_type_master['Sound_Type_Name'])?></option>
                    <?php
					}
					?>
                    </select></div>
                  <div class="cl"></div>
                </li>
                <li class="formBG2">
                  <div class="caption-2">How much</div>
                  <div class="input-2">
                  
                  <input type="text" name="Price" id="Price" value="<?=$Price?>" class="input-text textinput" size="30" /></div>
                  <div class="cl"></div>
                </li>
                <li class="formBG0">
                  <div class="caption-2">Main Genre</div>
                  <div class="input-2"><select name="Category_Id" id="Category_Id" style="width:240px;" class="input-text" />
                    <?php
					$sql_cat = "SELECT Category_Id, Category_Name FROM category_master WHERE Status=1 ORDER BY Category_Name";
                    $result_cat = mysql_query($sql_cat) or die('<br>'.$sql_cat.'<br>'.mysql_error());

					while($colles_cat = mysql_fetch_array($result_cat))
                    {
					
                    ?>
                    <option value="<?=$colles_cat['Category_Id']?>" <?php if($colles_cat['Category_Id']==$Category_Id) { echo 'selected'; } ?> ><?=stripslashes($colles_cat['Category_Name'])?></option>
                    <?php
					}
					?>
                    
                    </select></div>
                  <div class="cl"></div>
                </li>
                <li class="formBG">
                  <div class="caption-2">Description</div>
                  <div class="input-2"><textarea id="Short_Desc" rows="4" cols="50" class="input-text" name="Short_Desc"><?=stripslashes($Short_Desc)?></textarea></div>
                  <div class="cl"></div>
                </li>
                
                
                <li class="formBG2">
                  <div class="caption-2">Image</div>
                  <div class="input-2"><div id="imageupload"></div><span id="imagestatus" ></span><span style="font-family:Arial, Helvetica, sans-serif; font-size:11px; color:#FFF">For best look [ Image Dimensions 200 x 200 or Size 300 KB  ]</span></div>
                  <div class="cl"></div>
                </li>
                <li>
                  <div class="caption-2"></div>
                  <div class="input-2">
                    <ul id="imagefiles" >
					<?php			  
                    if (file_exists("products/product_image/".$Image_Name)) 
                    {
                    if(file_exists("products/product_image/".$Image_Name) && $Image_Name!="") 
                    { 
                    ?>
                    <li><img src="products/product_image/<?=$Image_Name?>">
                    <img id="DelImage" style="cursor:pointer;" src="images/delete-icn.gif" onclick="deleteImage('<?="products/product_image/".$Image_Name?>','delsmallProductImage.php','#imagefiles','<?=$Product_Id?>')" border="0" title="Delete Product Image"/></li>
        
                    <?
                    }
                    } 
                    else 
                    {
                    echo "Image not upload";
                    }
                    ?>
                    </ul>
                  </div>
                  <div class="cl"></div>
                </li>
                
                <li class="formBG">
                  <div class="caption-2" style="width:300px;">Music Audio or Video</div>
                  <div class="input-2"><div id="small_video_upload" >&nbsp;</div><span id="small_video_status" ></span></div>
                  <div class="cl"></div>
                   <br />
                   <span style="font-family:Arial, Helvetica, sans-serif; font-size:13px; color: #09C"><!--[ only upload avi, 3gp, flv, mkv, mov, mp3, mp4, mpeg, wma, wmv ]-->
                [<strong>For Audio:</strong> use mp3 ]</span>
                      
                </li>
                <li>
                  <div class="caption-2"><!--Title--></div>
                  <div class="input-2">
                   <ul id="small_video_files" >
					   <?php 
                       	if (file_exists("products/small_video/".$Short_FIle_Name)) 
                       { 			  
                       if(file_exists("products/small_video/".$Short_FIle_Name) && $Short_FIle_Name!="") 
                       { 
                       ?>
                       
                         <div >
                         <a href="preview-player.php?id=<?=$Product_Id?>" title="<?=stripslashes($Title)?>" rel="gb_page_center[640, 360]" class="global-box"><strong><?=stripslashes($Title)?> File Play </strong></a>
                         <span style="padding-left:10px;" ><img id="DelImage" style="cursor:pointer;" src="images/delete-icn.gif" onclick="deleteImage('<?="products/small_video/".$Short_FIle_Name?>','delSmallVideo.php','#small_video_files','<?=$Product_Id?>')" border="0" title="Delete Unreleased Music Audio or Video"/></span></div>
                        
                        <?  
                        }
                        } 
                        else 
                        { 
                        echo "Audio & Videoo Not Upload"; 
                        } 
                        ?>
                       
                        
                   </ul>
                  </div>
                  <div class="cl"></div>
                </li class="formBG3">
                <?php if($_REQUEST['id']=='') { ?>
                <div style="font-size:16px; color:#0099CC; margin-top:15px;">Electronic Copyright Signature </div>
                
                <li style="width:200px; padding:10px 0 0 0;">
                <label for="name">Print your name</label>
                <input type="text" name="name" id="name" class="name" style="background: none repeat scroll 0 0 #EDF6FF;border: 1px solid #0099CC;color: #566D7E;font-size: 12px;
    font-weight: bold;height: 25px;margin-top: 2px;padding: 0 5px; width: 100px;">
                <p class="typeItDesc">Review your signature</p>
                <p class="drawItDesc">Draw your signature</p>
                <ul class="sigNav">
                  <li></li>
                  <li class="typeIt"><a href="#type-it" class="current">Type It</a></li>
                  <li class="drawIt"><a href="#draw-it" >Draw It</a></li>
                  <li class="clearButton" style=" font-size:12px;"><a href="#clear" style="line-height:1px;">Clear</a></li>
                </ul>
                <div class="sig sigWrapper">
                  <div class="typed"></div>
                  <canvas class="pad" width="198" height="55">test</canvas>
                  <input type="hidden" name="output" class="output">
                </div>
                </li>
                
                <?php } else { ?>
                <div style="font-size:18px; font-weight:bold; color: #F90;  padding:15px 0 15px 0;">SIGNATURE</div>
                <div class="sigPad signed">
                <div class="sigWrapper">
                <div class="typed"><?php echo htmlentities($name, ENT_NOQUOTES, 'UTF-8'); ?></div>
                <canvas class="pad" width="198" height="55"></canvas>
                </div>
                <p><?php echo htmlentities($Signator, ENT_NOQUOTES, 'UTF-8'); ?><br><?php echo date("F j, Y ", strtotime($Product_Date));?></p>
                </div>
                <?php } ?>
                <li>
                  <div class="input-1">
                 <?php if($_REQUEST['id']=="")	{ ?>
                    <input name="buttonSubmit" type="submit" value="Insert Record" class="button" />
                    <?php } else { ?>
                    <input type="hidden" name="id" value="<?=$_REQUEST['id']?>" />
                    <input name="buttonSubmit" type="submit" value="Update" class="button" />
                    <?php } ?>
                  </div>
                  <div class="cl"></div>
                </li>
                
              </ul>
            
          </div>
          </div>
          <div class="cl"></div>
        </form>
        <script src="build/jquery.signaturepad.min.js"></script>
        <?php if($_REQUEST['id']=='') { ?>
        <script>
        $(document).ready(function() {
          $('.sigPad').signaturePad({validateFields : false});
        });
       </script>
      <script src="build/json2.min.js"></script>
      <?php } else { ?>
       <script>
         $(document).ready(function () {
          // Write out the complete signature from the database to Javascript
          var sig = <?php echo $Signature ?>;
          $('.sigPad').signaturePad({displayOnly : true}).regenerate(sig);
        });
      </script>
      <?php } ?>
      <script src="build/json2.min.js"></script>
        </div>
      </div>
      <div class="cor_1set-3"></div>
      <div class="cor_1set-4"></div>
    </div>


</div>
</div>
</div>
<!-- FOOTER -->
<?php include "footer.inc.php"; ?>
<!-- //FOOTER -->

</body>
</html>