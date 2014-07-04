<?php 
ob_start();
require_once "config/functions.inc.php";
require_once "session.inc.php"; 
//echo'<pre>'; print_r($_POST);
function get_time_difference( $start, $end )
{
    $uts['start']      =    strtotime( $start );
    $uts['end']        =    strtotime( $end );
    if( $uts['start']!==-1 && $uts['end']!==-1 )
    {
        if( $uts['end'] >= $uts['start'] )
        {
            $diff    =    $uts['end'] - $uts['start'];
            if( $days=intval((floor($diff/86400))) )
                $diff = $diff % 86400;
            if( $hours=intval((floor($diff/3600))) )
                $diff = $diff % 3600;
            if( $minutes=intval((floor($diff/60))) )
                $diff = $diff % 60;
            $diff    =    intval( $diff );            
            return( array('days'=>$days, 'hours'=>$hours, 'minutes'=>$minutes, 'seconds'=>$diff) );
        }
        else
        {
            trigger_error( "Ending date/time is earlier than the start date/time", E_USER_WARNING );
        }
    }
    else
    {
        trigger_error( "Invalid date/time data detected", E_USER_WARNING );
    }
    return( false );
}


$pageName = basename($_SERVER['PHP_SELF']); 
$sql = "SELECT * FROM member_account_master WHERE Member_Account_Id='".$_SESSION['SESS_ID']."'";
$result = mysql_query($sql);
$colles = mysql_fetch_array($result);


$sqlMusicianCount = "SELECT COUNT(*) AS CMusicianTotal FROM product_master WHERE Member_Account_Id='".$_SESSION['SESS_ID']."' ";
$resMusicianCount = mysql_query($sqlMusicianCount);
$collesMusicianCount = mysql_fetch_array($resMusicianCount);


 $sql_membership_check = "SELECT * FROM membership_upgrade_history_master WHERE Member_Account_Id='".$_SESSION['SESS_ID']."' AND Status=1";
 $result_membership_check = mysql_query($sql_membership_check);
 $sql_membership_check1 = "SELECT * FROM membership_upgrade_history_master WHERE Member_Account_Id='".$_SESSION['SESS_ID']."' AND Status=0";
 $result_membership_check1 = mysql_query($sql_membership_check1);
 
if(mysql_num_rows($result_membership_check)>0)
{
$sql_notes = "SELECT sum(b.Membership_No+5) as notesTotal FROM membership_upgrade_master a JOIN membership_upgrade_history_master b ON (a.Membership_Upgrade_Id=b.Membership_Upgrade_Id) WHERE a.Status='1' AND b.Status='1' AND b.Member_Account_Id='".$_SESSION['SESS_ID']."'";
$result_notes = mysql_query($sql_notes);
$colles_notes = mysql_fetch_array($result_notes);
$NOTES = $colles_notes['notesTotal'];
	if($NOTES=='')
	{
	$TOTAL_NOTES = 0;
	}
	else
	{
	$collesMusicianCount['CMusicianTotal'];
	$TOTAL_NOTES = $NOTES-$collesMusicianCount['CMusicianTotal'];
	}
}
elseif(mysql_num_rows($result_membership_check1)>0)
{

		 $sql_notes = "SELECT sum(b.Membership_No+5) as notesTotal FROM membership_upgrade_master a JOIN membership_upgrade_history_master b ON (a.Membership_Upgrade_Id=b.Membership_Upgrade_Id) WHERE a.Status='1' AND b.Status='1' AND b.Member_Account_Id='".$_SESSION['SESS_ID']."'";
        $result_notes = mysql_query($sql_notes);
        $colles_notes = mysql_fetch_array($result_notes);
        $NOTES = $colles_notes['notesTotal'];
		if($NOTES=='')
		{
		$TOTAL_NOTES = 0;
		}
		else
		{
		$collesMusicianCount['CMusicianTotal'];
		$TOTAL_NOTES = $NOTES-$collesMusicianCount['CMusicianTotal'];
		}
}
else
{
$TOTAL_NOTES = 5-$collesMusicianCount['CMusicianTotal'];
}


$sql_pro = "SELECT * FROM product_master WHERE Product_Id='".$_REQUEST['Product_Id']."'";
$result_pro = mysql_query($sql_pro);
$colles_pro = mysql_fetch_array($result_pro);
@extract($colles_pro);


if($_GET['img']!="")
{
if($_GET['name']=="Image_Name"){ unlink("products/product_image/".$_GET['img']); }
if($_GET['name']=="bigVideo"){ unlink("products/large_video/".$_GET['img']); }
if($_GET['name']=="smallVideo"){ unlink("products/small_video/".$_GET['img']); }
if($_GET['name']!="") { executeQuery("update product_master set ".$_GET['name']."='' where 1 AND Product_Id='".$_GET['Product_Id']."' "); }
}

 
	
if($_POST['Image_Name']!='') { $smallImage = $_POST['Image_Name']; } else { $smallImage = $Image_Name; }	 
if($_POST['smallVideo']!='') { $smallVideo = $_POST['smallVideo']; } else { $smallVideo = $Short_FIle_Name; }


if($_REQUEST['Product_Id']!="" && isset($_POST['buttonSubmit']))
{ 
			
			@extract($_POST);
			@extract($_GET);
			
			
			/*$sql = "SELECT * FROM product_master WHERE Title='".$Title."' AND Product_Id!='".$Product_Id."'";
			$result = mysql_query($sql);
			if(mysql_num_rows($result)>0)
			{
			$_SESSION['sess_messs']="Product Title Already Exist";
			
			}
			else
			{	*/	
			
			
			executeQuery("UPDATE product_master SET Image_Name='".$smallImage."' where Product_Id='".$_POST['Product_Id']."'");
			executeQuery("UPDATE product_master SET Short_FIle_Name='".$smallVideo."' where Product_Id='".$_POST['Product_Id']."'");
			executeQuery("UPDATE product_master SET Long_FIle_Name='".$bigVideo."' where Product_Id='".$_POST['Product_Id']."'");
			if(!empty($_POST['sd']) && !empty($_POST['sm']) && !empty($_POST['sy']) && !empty($_POST['shh']) && !empty($_POST['smm']) && !empty($_POST['sss']))
			{
			$Start_Date = $_POST['sy'].'-'.$_POST['sm'].'-'.$_POST['sd'].' '.$_POST['shh'].':'.$_POST['smm'].':'.$_POST['sss'];
			}
			if(!empty($_POST['ed']) && !empty($_POST['em']) && !empty($_POST['ey']) && !empty($_POST['ehh']) && !empty($_POST['emm']) && !empty($_POST['ess']))
			{
			$End_Date = $_POST['ey'].'-'.$_POST['em'].'-'.$_POST['ed'].' '.$_POST['ehh'].':'.$_POST['emm'].':'.$_POST['ess'];
			}
			
			$op_type =($_REQUEST['fg']='0')? 'Rhymes':'Poetry';
			   
			$query= "UPDATE product_master SET
			         Member_Account_Id = '".$_SESSION['SESS_ID']."',
			         Title = '".addslashes(trim($Title))."',
					 Sound = '".addslashes(trim($_POST['Sound']))."',
					 Product_Notes = '".trim($Product_Notes)."',
					 Type = '1',
					 OptionType = '".$op_type."',
					 Price = '".addslashes(trim($Price))."',
					 Short_Desc = '".addslashes(trim($Short_Desc))."',
					 Category_Id = '".$_POST['Category_Id']."',
					 Session_Start_Date = '".$Start_Date."',
					 Session_End_Date = '".$End_Date."'
					 WHERE Product_Id='".$_POST['Product_Id']."'";
			executeQuery($query);

			
	        $_SESSION['sess_messs']="Data updated successfully";
			header("location: product-list.php");
			exit();
			//}
		


}

////update record

if($_POST['Product_Id']=="" && isset($_POST['buttonSubmit']))
{ 
	     			
					$sqlCount = "SELECT COUNT(*) AS Ctotal FROM product_master WHERE Member_Account_Id='".$_SESSION['SESS_ID']."' ";
					$resCount = mysql_query($sqlCount);
					$collesCount = mysql_fetch_array($resCount);
					
					
					$smallVideo = trim($_POST['smallVideo']);
					$smallImage = trim($_POST['Image_Name']);
					
					$name = $_REQUEST['name'];
				    $output = $_REQUEST['output'];
		            $sig_hash = sha1($output);
					
					
					if(!empty($_POST['sd']) && !empty($_POST['sm']) && !empty($_POST['sy']) && !empty($_POST['shh']) && !empty($_POST['smm']) && !empty($_POST['sss']))
					{
					$Start_Date = $_POST['sy'].'-'.$_POST['sm'].'-'.$_POST['sd'].' '.$_POST['shh'].':'.$_POST['smm'].':'.$_POST['sss'];
					}
					if(!empty($_POST['ed']) && !empty($_POST['em']) && !empty($_POST['ey']) && !empty($_POST['ehh']) && !empty($_POST['emm']) && !empty($_POST['ess']))
					{
					$End_Date = $_POST['ey'].'-'.$_POST['em'].'-'.$_POST['ed'].' '.$_POST['ehh'].':'.$_POST['emm'].':'.$_POST['ess'];
					}
					$arrayDate = @get_time_difference( $Start_Date, $End_Date );
						
					
					
					if($collesCount['Ctotal']<5 )
					{
					
					          if($arrayDate['days']<=7)	
						      {
															
								/*$sql = "SELECT * FROM product_master WHERE Title='".$Title."'";
								$result = mysql_query($sql);
								if(mysql_num_rows($result)>0)
								{
								$_SESSION['sess_messs']="Product Title Already Exist";
								}
								else
								{*/
								$query = "INSERT INTO product_master SET
									 Member_Account_Id = '".$_SESSION['SESS_ID']."',
									 Title = '".addslashes(trim($_POST['Title']))."',
									 Product_Notes = '".trim($_POST['Product_Notes'])."',
									 Sound = '".addslashes(trim($_POST['Sound']))."',
									 Type = '1',
									 OptionType = '".$op_type."',
									 Price = '".addslashes(trim($_POST['Price']))."',
									 Short_Desc = '".addslashes(trim($_POST['Short_Desc']))."',
									 Category_Id = '".$_POST['Category_Id']."',
									 Session_Start_Date = '".$Start_Date."',
									 Session_End_Date = '".$End_Date."',
									 Image_Name = '".$smallImage."',
									 Short_FIle_Name = '".$smallVideo."',
									 Signator = '".addslashes(trim($name))."',
									 Signature = '".addslashes(trim($output))."',
									 Sig_Hash = '".trim($sig_hash)."',
									 Product_Date = now(),
									 Status ='1' ";
							      executeQuery($query);
									 
								 # Email to admin about new registration
						
								$SUBJECT = ucfirst($_SESSION['SESS_FIRST_NAME'].' '.$_SESSION['SESS_LAST_NAME'])." create new session @ Mussino.com";
								$TO  = Get_Single_Field("general_setting_master","Mails_Id","Gen_Set_Id","1");
								
											
								$BODY  = "Title : ".addslashes(trim($_REQUEST['Title']))." \n";
								$BODY .= "Product Notes : ".addslashes(trim($_REQUEST['Product_Notes']))." \n";
								$BODY .= "Sound : ".Get_Single_Field("sound_type_master","Sound_Type_Name","Sound_Type_Id","$_POST[Sound]")." \n";
								$BODY .= "Details : ".trim($_REQUEST['Short_Desc'])." \n";
								$BODY .= "Session Start : ".$Start_Date." \n";
								$BODY .= "Session End : ".$End_Date." \n";
											
						
								$HEADER = "From: ".addslashes(trim($_SESSION['SESS_FIRST_NAME']))." <".addslashes(trim($_SESSION['SESS_EMAIL']))."> \n";
								$HEADER .= "Reply-To: $TO <$TO>\n";
								$HEADER .= "X-Mailer: PHP/" . phpversion() . "\n";
								$HEADER .= "X-Priority: 1";
							   
								$MAILSEND = @mail($TO, $SUBJECT, $BODY, $HEADER);
												
								$_SESSION['sess_messs']="Session Cerated Successfully";
								header("location: product-list.php"); 
								exit();
								//}
							   
							   }
							   else
							   {
							   $_SESSION['sess_messs']="Invalid Session Date, Session Cerated 1 Week Only";
							   
							   }
					
					}
					elseif($TOTAL_NOTES+5>5)
					{
								if($arrayDate['days']<=7)	
						        {
								
													
								
								/*$sql = "SELECT * FROM product_master WHERE Title='".$Title."'";
								$result = mysql_query($sql);
								if(mysql_num_rows($result)>0)
									{
									$_SESSION['sess_messs']="Product Title Already Exist";
									}
									else
									{*/
										$query = "INSERT INTO product_master SET
												 Member_Account_Id = '".$_SESSION['SESS_ID']."',
												 Title = '".addslashes(trim($_POST['Title']))."',
												 Product_Notes = '".trim($_POST['Product_Notes'])."',
												 Sound = '".addslashes(trim($_POST['Sound']))."',
												 Type = '1',
												 OptionType = '".$op_type."',
												 Price = '".addslashes(trim($_POST['Price']))."',
												 Short_Desc = '".addslashes(trim($_POST['Short_Desc']))."',
												 Category_Id = '".$_POST['Category_Id']."',
												 Session_Start_Date = '".$Start_Date."',
												 Session_End_Date = '".$End_Date."',
												 Image_Name = '".$smallImage."',
												 Short_FIle_Name = '".$smallVideo."',
												 Signator = '".addslashes(trim($name))."',
												 Signature = '".addslashes(trim($output))."',
												 Sig_Hash = '".trim($sig_hash)."',
												 Product_Date = now(),
												 Status ='1' ";
										 executeQuery($query);
									 
									 # Email to admin about new registration
							
									$SUBJECT = ucfirst($_SESSION['SESS_FIRST_NAME'].' '.$_SESSION['SESS_LAST_NAME'])." create new session @ Mussino.com";
									$TO  = Get_Single_Field("general_setting_master","Mails_Id","Gen_Set_Id","1");
									
												
									$BODY  = "Title : ".addslashes(trim($_REQUEST['Title']))." \n";
									$BODY .= "Product Notes : ".addslashes(trim($_REQUEST['Product_Notes']))." \n";
									$BODY .= "Sound : ".Get_Single_Field("sound_type_master","Sound_Type_Name","Sound_Type_Id","$_POST[Sound]")." \n";
									$BODY .= "Details : ".trim($_REQUEST['Short_Desc'])." \n";
									$BODY .= "Session Start : ".$Start_Date." \n";
									$BODY .= "Session End : ".$End_Date." \n";
												
							
									$HEADER = "From: ".addslashes(trim($_SESSION['SESS_FIRST_NAME']))." <".addslashes(trim($_SESSION['SESS_EMAIL']))."> \n";
									$HEADER .= "Reply-To: $TO <$TO>\n";
									$HEADER .= "X-Mailer: PHP/" . phpversion() . "\n";
									$HEADER .= "X-Priority: 1";
								   
									$MAILSEND = @mail($TO, $SUBJECT, $BODY, $HEADER);
													
									$_SESSION['sess_messs']="Session Cerated Successfully";
									header("location: product-list.php"); 
									exit();
									//}
							   
							   }
							   else
							   {
							   $_SESSION['sess_messs']="Invalid Session Date, Session Cerated 1 Week Only";
							   
							   }
				   }
				   else
				   {
				   $_SESSION['sess_mess']="You have $TOTAL_NOTES credits. Please upgrade membership plan.";
				   header("location: membership-upgrade.php"); 
				   exit();
				   }
				   
		
}

if($_GET['Product_Id']!='')
{
$sql="select * from product_master  where Product_Id ='".$_GET['Product_Id']."'";
$result=executeQuery($sql);
$row=mysql_fetch_array($result);
@extract($row);
}

function addDayswithdate($date,$days){

    $date = strtotime("+".$days." days", strtotime($date));
    return  date("Y-m-d", $date);

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
					 alert("Music audio or video file already exist, Please delete before upload new one")
					 return false;
					}
				 if ( !(ext && /^(avi|AVI|3gp|3GP|flv|FLV|mkv|MKV|mov|MOV|mp3|MP3|mp4|MP4|mpeg|MPEG|wma|WMA|wmv|WMV)$/.test(ext))){ 
                    // extension is not allowed 
					status.text('Only avi, 3gp, flv, mkv, mov, mp3, mp4, mpeg, wma, wmv files are allowed');
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
				$("<img id=\"DelImage\" style=\"cursor:pointer;\" src=\"images/delete-icn.gif\" onclick=\"deleteImage('"+arrayNode[1]+"','delSmallVideo.php','#small_video_files','')\" border=\"0\" title=\"Delete Product Audio or Video\">").appendTo('#small_video_files');
				} else{
					$('<li></li>').appendTo('#small_video_files').text(arrayNode[0]).addClass('error');
				}
			}
		});
		
	});
	



function validateRegisterFormOnSubmit(theForm) {
var reason = "";

	reason += validateEmpty(theForm.Title);
	reason += validateEmpty1(theForm.Product_Notes);
	reason += validateEmpty2(theForm.Category_Id);
	reason += validateEmpty3(theForm.Sound);
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
        error = "Notes \n"
    }
    return error;  
}

function validateEmpty2(fld) {
    var error = "";
 
    if (fld.value.length == 0) {
       error = "Category \n"
    } 
    return error;  
}
function validateEmpty3(fld) {
    var error = "";
 
    if (fld.value.length == 0) {
       error = "Sound Type \n"
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
		// General options
		mode : "exact",
		elements : "Short_Desc",
		theme : "simple"
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
              <div class="blue-btn-1"> <span><span><a href="<?=SITE_WS_PATH?>/<?=trim($_SESSION['SESS_ID'])?>/<?=$_SESSION['SESS_FIRST_NAME']?>" >My Profile</a></span></span> </div>
              &raquo; <?=$_GET['Product_Id']==''?'Create New Session':'Update Session';?>
            </div>
          </div>
        </div>
        <div class="pro-content">
              
        <form action="<?=$PHP_SELF?>" method="POST" enctype="multipart/form-data" name="placeadd" id="placeadd" onsubmit="return validateRegisterFormOnSubmit(this)" class="sigPad">
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
          
       <!-- CREDIT BOX -->   
       <div class="creditBox">
               <div style="padding:2px 0 2px 0; font-size:18px; font-weight:bold;">
        <?php if($TOTAL_NOTES=='0') { ?>
        <img src="<?=SITE_WS_PATH?>/images/cross.png" align="absmiddle" class="creditImg" /> <div class="creditNum"><?=$TOTAL_NOTES?></div>
        <?php } else { ?>
        <img src="<?=SITE_WS_PATH?>/images/tick.png" align="absmiddle" class="creditImg" /> <div class="creditNum"><?=$TOTAL_NOTES?></div>
        <?php } ?>
        </div>
        
        <p class="creditTxt">Need more credits? <a href="/membership-upgrade.php" target="_blank">Click Here</a> to upgrade your account</p>
        
          </div>
       <!-- CREDIT BOX -->    
          
          
          
          <div class="pro-right2">
             <?php if($_SESSION["sess_messs"]!='') { ?>
              <div style="color:#FF0000; font-weight:bold;"><?=$_SESSION["sess_messs"]?> <? $_SESSION["sess_messs"]='';?></div>
             <?php } ?>
             <div class="form-container">
             
             <p style="margin-left:10px; font-size:15px;"><strong>Sessions are music contests that you control.</strong></p> 
              <ul>
                <li>
                  <div id="view_login_result" class="error"></div>
                </li>
                <li class="formBG">
                
               
                  <div class="caption-2">Session Title</div>
                  <div class="input-2">
                  <img class="inputCorner" src="images/input_left.gif">
                  <input type="text" name="Title" id="Title" value="<?=$Title?>" class="input-text textinput" size="30" />
                  <img class="inputCorner" src="images/input_right.gif">
                  </div>
                  <div class="cl"></div>
                </li>
              <?php /*?> <?php echo $collesMemberShip['Membership_Upgrade_Id'] ?><?php */?>
                <li class="formBG0">
                  <div style="margin-top:25px"><strong>How many credits songwriters need to enter this session?</strong> <p style="font-size:10px;">Free account only have 1 option. Upgrade membership to <a href="http://www.mussino.com/membership-upgrade.php" target="_blank">business account</a> for more options</p></div> 
                  <div class="input-2">
                  <select name="Product_Notes">
                  <option value="">Select</option>
                  <?php
				  for($i=1;$i<=1;$i++)
				  {
				  ?>
                  <option value="<?=$i?>" <?php if($i==$colles_pro['Product_Notes']) { echo'selected';} ?>><?=$i?></option>
                  <?php
				  }
				  ?>
                  </select>
                  
                  1 credit x 100 Lyricist = $100 you earn 23% Royalties
                 </div>
                  <div class="cl"></div>
                </li>
          
               
                <li class="formBG0">
                  <div class="caption-2">Select Genre</div>
                  <div class="input-2"><select name="Category_Id" id="Category_Id" style="width:240px;" class="input-text" />
                   <option value="">Select</option>
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
                
                
                      <li class="formBG0">
                  <div class="caption-2">Sound Type</div>
                  <div class="input-2"><select name="Sound" size="1" class="input-text" style="width:213px;" />
                    <option value="">Select</option>
                    <?php
					if($_SESSION['SESS_ACCOUNT_TYPE']=='Artist' ) {
					$sql_type_master = "SELECT * FROM sound_type_master WHERE Status='1' AND Sound_Type='Songwriter' ORDER BY Sound_Type_Name";
					}
					elseif($_SESSION['SESS_ACCOUNT_TYPE']=='Musician')
					{
					$sql_type_master = "SELECT * FROM sound_type_master WHERE Status='1' AND Sound_Type='Musician' ORDER BY Sound_Type_Name";
					}
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
                  <div class="caption-2" style="width:300px;">Producer advice to lyricist?</div>
                  <div class="input-2"><textarea id="Short_Desc" rows="4" cols="50" class="input-text" name="Short_Desc"><?=stripslashes($colles_pro['Short_Desc'])?></textarea></div>
                  <div class="cl"></div>
                </li>
               
                <?php /*?><li class="formBG0">
                
                
                <h1><img src="images/iinfo.png" width="50" align="absmiddle" />This session is already set for a 7 day session</h1>
                  <div id="hideme" class="sessionTime" style="width:500px"><span style="padding-right:5px;"><img src="images/date.png" width="40" height="40" align="absmiddle" /></span><strong>Session Start Date </strong> <?php echo date('l F j, Y'); ?></div>
                  <div class="input-2">
                   <table cellpadding="0" cellspacing="0" width="380" border="0">
                   <tr>
                     <td width="68" align="left" style="color:#25A6D5; font-weight:bold;">Day</td>
                     <td width="78" align="left" style="font-weight:bold;">Month</td>
                     <td width="75" align="left" style="font-weight:bold;">Year</td>
                     <td width="60" align="left" style="color:#25A6D5; font-weight:bold;">Hours</td>
                     <td width="60" align="left" style="font-weight:bold;">Minutes</td>
                     <td width="65" align="left" style="font-weight:bold;">Seconds</td>
                   </tr>
                    <tr>
                     <td><select name="sd" id="sd" disabled="disabled">
                     <option value="">Day</option>
                    <?php
					
                    for($sd=1;$sd<=31;$sd++)
                    {
                    if($sd<10){ $sd="0".$sd; }
                    ?>
                    <option value="<?=$sd?>" <?php if($sd==date('d')) { echo 'selected'; } ?>><?=$sd?></option>
                    <?php
                    }
                    ?>
                    </select></td>
                     <td><select name="sm" id="sm" disabled="disabled">
                    <option value="">Month</option>
                    <?php
                    for($sm=1;$sm<=12;$sm++)
                    {
                    if($sm<10){ $sm="0".$sm; }
                    ?>
                    <option value="<?=$sm?>" <?php if($sm==date('m')) { echo 'selected'; } ?>><?=$sm?></option>
                    <?php
                    }
                    ?>
                    </select></td>
                     <td><select name="sy" id="sy" disabled="disabled">
                     <option value="">Year</option>
                    <?php
                    for($sy=date('Y');$sy<=date('Y')+10;$sy++)
                    {
                    //if(strlen($y)==1){$y="0".$y;}
                    ?>
                    <option value="<?=$sy?>" <?php if($sy==date('Y')) { echo 'selected'; } ?>><?=$sy?></option>
                    <?php
                    }
                    ?>
                    </select></td>
                     <td>
                     <select name="shh" id="shh" >
                    <option value="00">00</option>
                    <?php
                    for($shh=1;$shh<=12;$shh++)
                    {
                    if($shh<10){ $shh="0".$shh; }
                    ?>
                    <option value="<?=$shh?>" <?php if($shh==date('h')) { echo 'selected'; } ?>><?=$shh?></option>
                    <?php
                    }
                    ?>
                    </select>
                    </td>
                     <td>
                     <select name="smm" id="smm" >
                    <option value="00">00</option>
                    <?php
                    for($smm=1;$smm<=60;$smm++)
                    {
                    if($smm<10){ $smm="0".$smm; }
                    ?>
                    <option value="<?=$smm?>" <?php if($smm==date('i')) { echo 'selected'; } ?>><?=$smm?></option>
                    <?php
                    }
                    ?>
                    </select>
                    </td>
                     <td><select name="sss" id="sss">
                    <option value="00">00</option>
                    <?php
                    for($sss=1;$sss<=60;$sss++)
                    {
                    if($sss<10){ $sss="0".$sss; }
                    ?>
                    <option value="<?=$sss?>" <?php if($sss==date('s')) { echo 'selected'; } ?>><?=$sss?></option>
                    <?php
                    }
                    ?>
                    </select></td>
                   </tr>
                   
                   </table>  
                    
                  </div>
                  <input type="hidden" name="sd" value="<?=date('d')?>" />
                  <input type="hidden" name="sm" value="<?=date('m')?>" />
                  <input type="hidden" name="sy" value="<?=date('Y')?>" />
                  <input type="hidden" name="shh" value="<?=date('h')?>" />
                  <input type="hidden" name="smm" value="<?=date('i')?>" />
                  <input type="hidden" name="sss" value="<?=date('s')?>" />
                  <div class="cl"></div>
                  
                </li><?php */?>
                
                
               <?php /*?> <?php 
				$nextWeek = date('d m Y h i s', strtotime('+1 week')); 
				list($eDay,$eMon,$eYear,$eHour,$eMinute,$eSecond) = explode(' ',$nextWeek);
				?><?php */?>
                
                
                <?php /*?><li id="hideme1" class="sessionTime formBG0">
                  <div style="width:500px"><span style="padding-right:5px;"><img src="images/date1.png" width="40" height="40" align="absmiddle" /></span><strong>Session End Date</strong> <?php echo date('l F j, Y', strtotime("+7 days")); ?> </div>
                  <div class="input-2">
                  <table cellpadding="0" cellspacing="0" width="380" border="0">
                   <tr>
                     <td width="68" align="left" style="color:#25A6D5; font-weight:bold;">Day</td>
                     <td width="78" align="left" style="font-weight:bold;">Month</td>
                     <td width="75" align="left" style="font-weight:bold;">Year</td>
                     <td width="60" align="left" style="color:#25A6D5; font-weight:bold;">Hours</td>
                     <td width="60" align="left" style="font-weight:bold;">Minutes</td>
                     <td width="65" align="left" style="font-weight:bold;">Seconds</td>
                   </tr>
                    <tr>
                     <td><select name="ed" id="ed" >
                     <?php
                     for($ed=1;$ed<=31;$ed++)
                     {
                     if($ed<10){ $ed="0".$ed; }
                     ?>
                     <option value="<?=$ed?>" <?php if($ed==$eDay) { echo 'selected'; } ?>><?=$ed?></option>
                     <?php
                     }
                     ?>
                     </select></td>
                     <td><select disabled="disabled"  name="em" id="em"  >
                    <?php
                    for($em=1;$em<=12;$em++)
                    {
                    if($em<10){ $em="0".$em; }
                    ?>
                    <option value="<?=$em?>" <?php if($em==$eMon) { echo 'selected'; } ?>><?=$em?></option>
                    <?php
                    }
                    ?>
                    </select></td>
                     <td><select disabled="disabled" name="ey" id="ey" >
                    <?php
                    for($ey=date('Y');$ey<=date('Y')+10;$ey++)
                    {
                    //if(strlen($y)==1){$y="0".$y;}
                    ?>
                    <option  value="<?=$ey?>" <?php if($ey==$eYear) { echo 'selected'; } ?>><?=$ey?></option>
                    <?php
                    }
                    ?>
                    </select></td>
                     <td><select name="ehh" id="ehh" >
                    <option value="00">00</option>
                    <?php
                    for($ehh=1;$ehh<=12;$ehh++)
                    {
                    if($ehh<10){ $ehh="0".$ehh; }
                    ?>
                    <option value="<?=$ehh?>" <?php if($ehh==$eHour) { echo 'selected'; } ?>><?=$ehh?></option>
                    <?php
                    }
                    ?>
                    </select></td>
                     <td><select name="emm" id="emm" >
                    <option value="00">00</option>
                    <?php
                    for($emm=1;$emm<=60;$emm++)
                    {
                    if($emm<10){ $emm="0".$emm; }
                    ?>
                    <option value="<?=$emm?>" <?php if($emm==$eMinute) { echo 'selected'; } ?>><?=$emm?></option>
                    <?php
                    }
                    ?>
                    </select></td>
                     <td><select name="ess" id="ess" >
                    <option value="00">00</option>
                    <?php
                    for($ess=1;$ess<=60;$ess++)
                    {
                    if($ess<10){ $ess="0".$ess; }
                    ?>
                    <option value="<?=$ess?>" <?php if($ess==$eSecond) { echo 'selected'; } ?>><?=$ess?></option>
                    <?php
                    }
                    ?>
                    </select></td>
                   </tr>
                   
                  <!-- <tr>
                   <td colspan="6" style="color:#FF0000; padding:10px 0 8px 0;"><strong>Tip :</strong> You can create a session to last for a couple of hours or 7 days</td>
                   </tr>-->
                   <input type="hidden" name="eed"  id="eed" value="<?=$eDay?>" />
                    <input type="hidden" name="eem"  id="eem" value="<?=$eMon?>" />
                    <input type="hidden" name="eey"  id="eey" value="<?=$eYear?>" />
                    <input type="hidden" name="eehh" id="eehh" value="<?=$eHour?>" />
                    <input type="hidden" name="eemm" id="eemm" value="<?=$eMinute?>" />
                    <input type="hidden" name="eess" id="eess" value="<?=$eSecond?>" />
                   </table> 
                    
                    
                  </div>
                  <div class="cl"></div>
                </li><?php */?>
                <br />
                <li class="formBG2">
                  <div class="caption-2">Session Image</div>
                  <div class="input-2"><div id="imageupload"></div><span id="imagestatus" ></span></div>
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
                    echo "Image Not Upload";
                    }
                    ?>
                    </ul>
                  </div>
                  <div class="cl"></div>
                </li>
                
                <li class="formBG" style="width:600px;">
                  <div class="caption-2" style="width:350px;">Upload Beat Audio or Video</div>
                  <div class="input-2"><div id="small_video_upload" >&nbsp;</div><span id="small_video_status" > </span><br />
                  
                  <span style="font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#25A6D5"><br />
                 <!-- [ only upload avi, 3gp, flv, mkv,  mov, mp3, mp4, mpeg, wma, wmv ]-->
                [<strong>For Video:</strong> use mp4, flv]
                [<strong>For Audio:</strong> use mp3 ]
                 
                 </span></div>
                  <div class="cl"></div>
                </li>
                <li>
                  <div class="caption-2"><!--Title--></div>
                  <div class="input-2" id="videogallery">
                   <ul id="small_video_files">
					   <?php 
                       if (file_exists("products/small_video/".$Short_FIle_Name)) 
                       { 
                       if(file_exists("products/small_video/".$Short_FIle_Name) && $Short_FIle_Name!="") 
                       {
                       ?>
                        <div ><a href="preview-player.php?id=<?=$Product_Id?>" title="<?=stripslashes($Title)?>" rel="gb_page_center[640, 360]" class="global-box"><strong><?=stripslashes($Title)?> File Play </strong></a>
                       <span style="padding-left:10px;" >
                         
                        <img id="DelImage" style="cursor:pointer;" src="images/delete-icn.gif" onclick="deleteImage('<?="products/small_video/".$Short_FIle_Name?>','delSmallVideo.php','#small_video_files','<?=$Product_Id?>')" border="0" title="Delete Product Audio & Video"/></span></div>
                        <?  
                        } 
                        } 
                        else 
                        { 
                        echo "Audio & Video Not Upload"; 
                        } 
                        ?>
                       </ul> 
                    
                  </div>
                  <div class="cl"></div>
                </li>
                
                <?php if($_REQUEST['id']=='') { ?>
                 <div style="font-size:16px; color:#0099CC; text-transform:uppercase; margin-top:15px;">electronic signature author content</div>
                
                <li style="width:200px; padding:10px 0 0 0;">
                <label for="name">Print your name</label>
                <input type="text" name="name" id="name" class="name" style="background: none repeat scroll 0 0 #EDF6FF;border: 1px solid #0099CC;color: #566D7E;font-size: 12px;
    font-weight: bold;height: 25px;margin-top: 2px;padding: 0 5px; width: 100px;">
                <p class="typeItDesc">Review your signature below</p>
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
                  <div style="font-family:Arial, Helvetica, sans-serif; font-size:13px; color: #F00; padding: 10px 0 10px 0;"><strong>Note : Only admin can delete an active session. <br> Send email to editsession@mussino.com</strong></div>
                  <div class="cl"></div>
                </li>
                <li>
                  <div class="input-1">
                 <?php if($_REQUEST['Product_Id']=="")	{ ?>
                    <input name="buttonSubmit" type="submit" value="Create session" class="button" />
                    <?php } else { ?>
                    <input type="hidden" name="Product_Id" value="<?=$_REQUEST['Product_Id']?>" />
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