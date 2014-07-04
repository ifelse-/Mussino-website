<?php 
ob_start();
include("../config/functions.inc.php");
include("session.inc.php");
$list_page ='product-list.php';
$head_page ='product.php';
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
$sql_cat = "SELECT Category_Id, Category_Name FROM category_master WHERE Status=1 AND Parent_Id='0' ORDER BY Category_Name";
$result_cat = mysql_query($sql_cat) or die('<br>'.$sql_cat.'<br>'.mysql_error());

$sql_pro = "SELECT * FROM product_master WHERE Product_Id='".$_REQUEST['id']."'";
$result_pro = mysql_query($sql_pro);
$colles_pro = mysql_fetch_array($result_pro);

$member_id = $colles_pro['Member_Account_Id'];

if($_GET['img']!="")
{

if($_GET['name']=="Image_Name"){ unlink("../products/product_image/".$_GET['img']); }
if($_GET['name']=="smallVideo"){ unlink("../products/small_video/".$_GET['img']); }
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
				
				if(!empty($_POST['sd']) && !empty($_POST['sm']) && !empty($_POST['sy']) && !empty($_POST['shh']) && !empty($_POST['smm']) && !empty($_POST['sss']))
				{
				$Start_Date = $_POST['sy'].'-'.$_POST['sm'].'-'.$_POST['sd'].' '.$_POST['shh'].':'.$_POST['smm'].':'.$_POST['sss'];
				}
				if(!empty($_POST['ed']) && !empty($_POST['em']) && !empty($_POST['ey']) && !empty($_POST['ehh']) && !empty($_POST['emm']) && !empty($_POST['ess']))
				{
				$End_Date = $_POST['ey'].'-'.$_POST['em'].'-'.$_POST['ed'].' '.$_POST['ehh'].':'.$_POST['emm'].':'.$_POST['ess'];
				}
				$arrayDate = @get_time_difference( $Start_Date, $End_Date );
			
				if($arrayDate['days']<=7)	
				{   
				$query= "UPDATE product_master SET
						 Member_Account_Id = '".$member_id."',
						 Title = '".addslashes(trim($Title))."',
						 Sound = '".addslashes(trim($_POST['Sound']))."',
						 Product_Notes = '".trim($Product_Notes)."',
						 Type = '1',
						 Price = '".addslashes(trim($Price))."',
						 Short_Desc = '".addslashes(trim($Short_Desc))."',
						 Category_Id = '".$_POST['Category_Id']."',
						 Royalties = '".trim($_POST['Royalties'])."',
						 Posts = '".trim($_POST['Posts'])."',
						 Judges_Vote = '".trim($_POST['Judges_Vote'])."',
						 Session_Start_Date = '".$Start_Date."',
						 Session_End_Date = '".$End_Date."'
						 WHERE Product_Id='".$_POST['id']."'";
				executeQuery($query);
	
				
				$_SESSION['sess_mess']="Data updated successfully";
				header("location: product-list.php");
				exit();
				}
				else
				{
				$_SESSION['sess_mess']="Invalid Session Date, Session Cerated 1 Week Only";	
				}
		    }
}

////update record

if($_POST['id']=="" && isset($_POST['buttonSubmit']))
{ 
	     			
						
					$smallVideo = trim($_POST['smallVideo']);
					$smallImage = trim($_POST['Image_Name']);
					$bigVideo = trim($_POST['bigVideo']);
					
					if(!empty($_POST['sd']) && !empty($_POST['sm']) && !empty($_POST['sy']) && !empty($_POST['shh']) && !empty($_POST['smm']) && !empty($_POST['sss']))
					{
					$Start_Date = $_POST['sy'].'-'.$_POST['sm'].'-'.$_POST['sd'].' '.$_POST['shh'].':'.$_POST['smm'].':'.$_POST['sss'];
					}
					if(!empty($_POST['ed']) && !empty($_POST['em']) && !empty($_POST['ey']) && !empty($_POST['ehh']) && !empty($_POST['emm']) && !empty($_POST['ess']))
					{
					$End_Date = $_POST['ey'].'-'.$_POST['em'].'-'.$_POST['ed'].' '.$_POST['ehh'].':'.$_POST['emm'].':'.$_POST['ess'];
					}
					$arrayDate = @get_time_difference( $Start_Date, $End_Date );
					
					if($arrayDate['days']<=7)	
					{
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
					          Member_Account_Id = '".$member_id."',
			         		  Title = '".addslashes(trim($_POST['Title']))."',
							  Product_Notes = '".trim($_POST['Product_Notes'])."',
							  Sound = '".addslashes(trim($_POST['Sound']))."',
							  Type = '1',
							  Price = '".addslashes(trim($_POST['Price']))."',
							  Short_Desc = '".addslashes(trim($_POST['Short_Desc']))."',
							  Category_Id = '".$_POST['Category_Id']."',
							  Session_Start_Date = '".$Start_Date."',
							  Session_End_Date = '".$End_Date."',
							  Image_Name = '".$smallImage."',
							  Short_FIle_Name = '".$smallVideo."',
							  Long_FIle_Name = '".$bigVideo."',
							  Royalties = '".trim($_POST['Royalties'])."',
					          Posts = '".trim($_POST['Posts'])."',
					          Judges_Vote = '".trim($_POST['Judges_Vote'])."',
							  Product_Date = now(),
							  Status ='1' ";
					executeQuery($query);
					
			        
					$_SESSION['sess_mess']="Record saved successfully";
					header("location: product-list.php"); 
					exit();
					}
					}
					else
					{
					$_SESSION['sess_mess']="Invalid Session Date, Session Cerated 1 Week Only";
					
					}
		
}


if($_GET['id']!='')
{
$sql = "SELECT * FROM product_master WHERE Product_Id ='".$_GET['id']."'";
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
	


</script>


<script language="javascript">

function validateRegisterFormOnSubmit(theForm) {
var reason = "";

	reason += validateEmpty(theForm.Title);
	reason += validateEmpty1(theForm.Product_Notes);
	reason += validateEmpty2(theForm.Sound);
	reason += validateEmpty3(theForm.Category_Id);
	
         
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
        error = "Notes \n"
    } else {
        fld.style.background = '#FFFFFF';
    }
    return error;  
}
function validateEmpty2(fld) {
    var error = "";
 
    if (fld.value.length == 0) {
        fld.style.background = '#EAE1C1'; 
        error = "Sound Type \n"
    } else {
        fld.style.background = '#FFFFFF';
    }
    return error;  
}
function validateEmpty3(fld) {
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
       <h2> Session Product <?=$_GET['id']!='' ? 'Edit' : 'Add';?></h2>
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
          
         
          <tr id="hideme2">
            <td width="200" align="left" valign="middle" >Notes </td>
            <td align="left" valign="top" class="input-1">
            <select name="Product_Notes">
            <option value="">Select</option>
            <?php
            for($i=1;$i<=5;$i++)
            {
            ?>
            <option value="<?=$i?>" <?php if($i==$dataColles['Product_Notes']) { echo'selected';} ?>><?=$i?></option>
            <?php
            }
            ?>
            </select>
          </td>
          </tr>
          
          
          <tr id="hideme3">
            <td width="200" align="left" valign="middle" >Sound Type</td>
            <td align="left" valign="top" class="input-1" id="view_sound_type_result">
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
          
         
            <div>
            <tr valign="top" id="hideme">
            <td width="30%">Start Session</td>
            <td width="70%">
             <select name="sm" id="sm">
            <option value="">Month</option>
            <?php
            for($sm=1;$sm<=12;$sm++)
            {
            if($sm<10){ $sm="0".$sm; }
            ?>
            <option value="<?=$sm?>" <?php if($smonth=='') { if($sm==date('m'))  echo 'selected';  } else { if($sm==$smonth)  echo 'selected';  } ?>><?=$sm?></option>
            <?php
            }
            ?>
            </select>
            <select name="sd" id="sd">
            <option value="">Day</option>
            <?php
            if($dataColles['Session_Start_Date']!='')
            {
            list($sdate,$stime) = explode(' ',$dataColles['Session_Start_Date']);
            list($syear,$smonth,$sday) = explode('-',$sdate);
            list($shour,$sminute,$ssecond) = explode(':',$stime);
            }
            for($sd=1;$sd<=31;$sd++)
            {
            if($sd<10){ $sd="0".$sd; }
            ?>
            <option value="<?=$sd?>" <?php if($sday=='') { if($sd==date('d'))  echo 'selected';  } else { if($sd==$sday)  echo 'selected'; }?>><?=$sd?></option>
            <?php
            }
            ?>
            </select>
           
            <select name="sy" id="sy">
             <option value="">Year</option>
            <?php
            for($sy=2010;$sy<=date('Y')+10;$sy++)
            {
            //if(strlen($y)==1){$y="0".$y;}
            ?>
            <option value="<?=$sy?>" <?php if($syear=='') { if($sy==date('Y'))  echo 'selected'; } else { if($sy==$syear)  echo 'selected'; } ?>><?=$sy?></option>
            <?php
            }
            ?>
            </select> 
             <select name="shh" id="shh" >
            <option value="">Hours</option>
            <?php
            for($shh=1;$shh<=12;$shh++)
            {
            if($shh<10){ $shh="0".$shh; }
            ?>
            <option value="<?=$shh?>" <?php if($shour=='') { if($shh==date('h'))  echo 'selected'; } else { if($shh==$shour)  echo 'selected'; } ?>><?=$shh?></option>
            <?php
            }
            ?>
            </select>
             <select name="smm" id="smm" >
            <option value="">Minutes</option>
            <?php
            for($smm=1;$smm<=60;$smm++)
            {
            if($smm<10){ $smm="0".$smm; }
            ?>
            <option value="<?=$smm?>" <?php if($sminute=='') { if($smm==date('i'))  echo 'selected'; } else { if($smm==$sminute)  echo 'selected'; } ?>><?=$smm?></option>
            <?php
            }
            ?>
            </select>
            <select name="sss" id="sss" >
            <option value="">Seconds</option>
            <?php
            for($sss=1;$sss<=60;$sss++)
            {
            if($sss<10){ $sss="0".$sss; }
            ?>
            <option value="<?=$sss?>" <?php if($sminute=='') { if($sss==date('s'))  echo 'selected'; } else { if($sss==$ssecond)  echo 'selected'; } ?>><?=$sss?></option>
            <?php
            }
            ?>
            </select>
            <input type="hidden" name="sd" value="<?=date('d')?>" />
          <input type="hidden" name="sm" value="<?=date('m')?>" />
          <input type="hidden" name="sy" value="<?=date('Y')?>" />
          <input type="hidden" name="shh" value="<?=date('h')?>" />
          <input type="hidden" name="smm" value="<?=date('i')?>" />
          <input type="hidden" name="sss" value="<?=date('s')?>" />
            </td>
            </tr>
            </div>
            
            <div> 
			<?php 
			$nextWeek = date('d m Y h i s', strtotime('+1 week')); 
			list($eNextDay,$eNextMon,$eNextYear,$eNextHour,$eNextMinute,$eNextSecond) = explode(' ',$nextWeek);
			?>
            <tr valign="top" id="hideme1">
            <td width="30%">End Session</td>
            <td width="70%">
             <select name="em" id="em" >
            <option value="">Month</option>
            <?php
            for($em=1;$em<=12;$em++)
            {
            if($em<10){ $em="0".$em; }
            ?>
            <option value="<?=$em?>" <?php if($emonth=='') { if($em==$eNextMon)  echo 'selected'; } else { if($em==$emonth)  echo 'selected'; }?>><?=$em?></option>
            <?php
            }
            ?>
            </select>
            <select name="ed" id="ed" >
             <option value="">Day</option>
            <?php
            if($dataColles['Session_End_Date']!='')
            {
            list($edate,$etime) = explode(' ',$dataColles['Session_End_Date']);
            list($eyear,$emonth,$eday) = explode('-',$edate);
            list($ehour,$eminute,$esecond) = explode(':',$etime);
            }
            for($ed=1;$ed<=31;$ed++)
            {
            if($ed<10){ $ed="0".$ed; }
            ?>
            <option value="<?=$ed?>" <?php if($eday=='') { if($ed==$eNextDay)  echo 'selected'; } else { if($ed==$eday)  echo 'selected'; } ?>><?=$ed?></option>
            <?php
            }
            ?>
            </select>
           
            <select name="ey" id="ey" >
             <option value="<? echo date("Y") ?>"><? echo date("Y") ?></option>
           
          
            
            </select> 
             <select name="ehh" id="ehh" >
            <option value="">Hours</option>
            <?php
            for($ehh=1;$ehh<=12;$ehh++)
            {
            if($ehh<10){ $ehh="0".$ehh; }
            ?>
            <option value="<?=$ehh?>" <?php if($ehour=='') { if($ehh==$eNextHour)  echo 'selected'; } else { if($ehh==$ehour)  echo 'selected';  } ?>><?=$ehh?></option>
            <?php
            }
            ?>
            </select>
             <select name="emm" id="emm" >
            <option value="">Minutes</option>
            <?php
            for($emm=1;$emm<=60;$emm++)
            {
            if($emm<10){ $emm="0".$emm; }
            ?>
            <option value="<?=$emm?>" <?php if($eminute=='') { if($emm==$eNextMinuteif)  echo 'selected'; } else { if($emm==$eminute)  echo 'selected'; } ?>><?=$emm?></option>
            <?php
            }
            ?>
            </select>
            <select name="ess" id="ess" >
            <option value="">Seconds</option>
            <?php
            for($ess=1;$ess<=60;$ess++)
            {
            if($ess<10){ $ess="0".$ess; }
            ?>
            <option value="<?=$ess?>" <?php if($esecond=='') { if($ess==$eNextSecond)  echo 'selected'; } else { if($ess==$esecond)  echo 'selected'; }?>><?=$ess?></option>
            <?php
            }
            ?>
            </select>
            </td>
            </tr>
            </div>
                    
                    
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
            <td width="30%">Music Audio or Video</td>
            <td width="70%"><div id="small_video_upload" >&nbsp;</div><span id="small_video_status" ></span>
            <div style="padding:12px 0 0 0;"><span style="font-family:Arial, Helvetica, sans-serif; font-size:11px; color:#25A6D5">[ only upload avi, 3gp, flv, mkv, mov, mp3, mp4, mpeg, wma, wmv ]</span></div></td>
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
                 <li >
               
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
            <td width="200" align="left" valign="middle">Royalties </td>
            <td align="left" valign="top" class="input-1"><input type="text" name="Royalties" value="<?=stripslashes(trim($dataColles['Royalties']));?>"  size="50" class="textbox"></td>
          </tr>
          
           <tr>
            <td width="200" align="left" valign="middle">Posts </td>
            <td align="left" valign="top" class="input-1"><input type="text" name="Posts" value="<?=stripslashes(trim($dataColles['Posts']));?>"  size="50" class="textbox"></td>
          </tr>
          
           <tr>
            <td width="200" align="left" valign="middle">No Judges Vote </td>
            <td align="left" valign="top"><input type="checkbox" name="Judges_Vote" value="1" <?php if($dataColles['Judges_Vote']==1) { echo 'checked'; }?>   class="textbox"></td>
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
