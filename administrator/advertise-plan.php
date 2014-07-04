<?php 
include("../config/functions.inc.php");
include("session.inc.php");
$list_page ='advertise-plan-list.php';
$head_page ='advertise-plan.php';
if(isset($_REQUEST['submit']))
{ 

  @extract($_POST);
  @extract($_REQUEST);
  $Ad_Plan_Name = addslashes(trim($Ad_Plan_Name));
  $Ad_Plan_Desc = addslashes(trim($Ad_Plan_Desc));
    
  if($_REQUEST['id']!='')
	{
		$sql = "SELECT * FROM advertise_plan_master WHERE Ad_Plan_Name = '$Ad_Plan_Name'  AND Advertise_Plan_Id !='".$_REQUEST['id']."'";
		$result = mysql_query($sql) or die('<br>'.$sql.'<br>'.mysql_error());
		if(mysql_num_rows($result)>0)
		{
			$_SESSION['sess_mess'] = "Plan already exist";
			header("location: ". $head_page."?id=".$_REQUEST['id']);
		    exit;
		}
		else
		{	
			$sql = "UPDATE advertise_plan_master SET 
					Ad_Plan_Name = '$Ad_Plan_Name',
					Ad_Plan_Amount 	 = '$Ad_Plan_Amount',
					Ad_Plan_Duration = '$Ad_Plan_Duration',
					Ad_Plan_Desc = '$Ad_Plan_Desc',
					Status = '$Status'
					WHERE Advertise_Plan_Id = '".$_REQUEST['id']."'";
			$result = mysql_query($sql) or die('<br>'.$sql.'<br>'.mysql_error());
			$_SESSION['sess_mess'] = "Plan updated successfully.";
			header("location: ". $list_page);
			exit;
		}
	}
	else
	{
		
			$sql = "SELECT * FROM advertise_plan_master WHERE Ad_Plan_Name = '$Ad_Plan_Name'  ";
			$result = mysql_query($sql) or die('<br>'.$sql.'<br>'.mysql_error());
			if(mysql_num_rows($result)>0)
			{
				$_SESSION['sess_mess'] = "Plan already exist";
				header("location: ". $head_page);
		        exit;
			}
			else
			{
			
				
				$sql = "INSERT INTO advertise_plan_master SET
						Ad_Plan_Name = '$Ad_Plan_Name',
					    Ad_Plan_Amount 	 = '$Ad_Plan_Amount',
					    Ad_Plan_Duration = '$Ad_Plan_Duration',
					    Ad_Plan_Desc = '$Ad_Plan_Desc',
						Ad_Plan_Date = now(),
						Status = '$Status'";
				$result = mysql_query($sql) or die('<br>'.$sql.'<br>'.mysql_error());
				$_SESSION['sess_mess'] =  "Plan successfully added";
				
				header("location: ". $list_page);
				exit;
			}
		
	}
  
	
}


if($_GET['id']!='')
{
$sql = "SELECT * FROM advertise_plan_master WHERE Advertise_Plan_Id ='".$_GET['id']."'";
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
<script type="text/javascript" src="../tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script>
function validate_submitsite_form(placeadd) 
{
	if (placeadd.Ad_Plan_Name.value == "") 
	{
		alert("\nPlease enter plan name.")
		placeadd.Ad_Plan_Name.focus();
		return false;
	}
	
	else if (placeadd.Ad_Plan_Amount.value == "") 
	{
		alert("\nPlease enter Price.")
		placeadd.Ad_Plan_Amount.focus();
		return false;
	}
	else if (placeadd.Ad_Plan_Duration.value == "") 
	{
		alert("\nPlease enter duration.")
		placeadd.Ad_Plan_Duration.focus();
		return false;
	}
	
	
	
} 

	// Default skin
	tinyMCE.init({
		// General options
		mode : "exact",
		elements : "Ad_Plan_Desc",
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
       <form name="placeadd" id="placeadd" action="<?=$PHP_SELF?>" method="POST"  onSubmit="return validate_submitsite_form(placeadd)">
       <div class="box-1">
       <h2> Advertise Plan <?=$_GET['id']!='' ? 'Edit' : 'Add';?></h2>
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
            <td width="200" align="left" valign="middle">Plan Name</td>
            <td align="left" valign="top" class="input-1"><input type="text" name="Ad_Plan_Name" value="<?=stripslashes(trim($dataColles['Ad_Plan_Name']));?>"  size="50" class="textbox"></td>
          </tr>
          
          <tr>
            <td width="200" align="left" valign="middle">Plan Price</td>
            <td align="left" valign="top" class="input-1"><input type="text" name="Ad_Plan_Amount" value="<?=trim($dataColles['Ad_Plan_Amount']);?>"  size="50" class="textbox"></td>
          </tr>
          
           <tr>
            <td width="200" align="left" valign="middle">Duration</td>
            <td align="left" valign="top" class="input-1">
            <select name="Ad_Plan_Duration" size="1" class="textbox">
            <option value="">Select</option>
            <option value="ad space for 1 week" <? if($dataColles['Ad_Plan_Duration']=='ad space for 1 week') { echo "SELECTED";}?>>ad space for 1 week</option>
            <option value="ad space for 1 month" <? if($dataColles['Ad_Plan_Duration']=='ad space for 1 month') { echo "SELECTED";}?>>ad space for 1 month</option>
            <option value="ad space for 2 month" <? if($dataColles['Ad_Plan_Duration']=='ad space for 2 month') { echo "SELECTED";}?>>ad space for 2 month</option>
            <option value="ad space for 3 month" <? if($dataColles['Ad_Plan_Duration']=='ad space for 3 month') { echo "SELECTED";}?>>ad space for 3 month</option>
            <option value="ad space for 6 month" <? if($dataColles['Ad_Plan_Duration']=='ad space for 6 month') { echo "SELECTED";}?>>ad space for 6 month</option>
            <option value="ad space for 1 year" <? if($dataColles['Ad_Plan_Duration']=='ad space for 1 year') { echo "SELECTED";}?>>ad space for 1 year</option>
            </select>
          
            </td>
          </tr>
          
           <tr>
            <td width="200" align="left" valign="middle">Detail</td>
            <td align="left" valign="top" class="input-1"> <textarea name="Ad_Plan_Desc" rows="3" cols="60"><?=stripslashes($dataColles['Ad_Plan_Desc'])?></textarea></td>
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
            <td align="left" valign="middle"><input type="hidden" name="id" value="<?=$dataColles['Advertise_Plan_Id'];?>" /></td>
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
