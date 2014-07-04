<?php 
include("../config/functions.inc.php");
include("session.inc.php");
$list_page ='membership-upgrade-list.php';
$head_page ='membership-upgrade.php';
if(isset($_REQUEST['submit']))
{ 

  @extract($_POST);
  @extract($_REQUEST);
  $Membership_Package_Name = addslashes(trim($Membership_Package_Name));
  $Membership_Package_Desc = addslashes(trim($Membership_Package_Desc));
  $Help_Desc = addslashes(trim($Help_Desc));  
  if($_REQUEST['id']!='')
	{
		$sql = "SELECT * FROM membership_upgrade_master WHERE Membership_Package_Name = '$Membership_Package_Name'  AND Membership_Upgrade_Id !='".$_REQUEST['id']."'";
		$result = mysql_query($sql) or die('<br>'.$sql.'<br>'.mysql_error());
		if(mysql_num_rows($result)>0)
		{
			$_SESSION['sess_mess'] = "Membership upgrade package already exist";
			header("location: ". $head_page."?id=".$_REQUEST['id']);
		    exit;
		}
		else
		{	
			$sql = "UPDATE membership_upgrade_master SET 
					Membership_Package_Name = '$Membership_Package_Name',
					Membership_Package_Amount = '$Membership_Package_Amount',
					Membership_No = '$Membership_No',
					Membership_Package_Desc = '$Membership_Package_Desc',
					Help_Desc = '$Help_Desc',
					Status = '$Status'
					WHERE Membership_Upgrade_Id = '".$_REQUEST['id']."'";
			$result = mysql_query($sql) or die('<br>'.$sql.'<br>'.mysql_error());
			$_SESSION['sess_mess'] = "Membership upgrade package updated successfully.";
			header("location: ". $list_page);
			exit;
		}
	}
	else
	{
		
			$sql = "SELECT * FROM membership_upgrade_master WHERE Membership_Package_Name = '$Membership_Package_Name'  ";
			$result = mysql_query($sql) or die('<br>'.$sql.'<br>'.mysql_error());
			if(mysql_num_rows($result)>0)
			{
				$_SESSION['sess_mess'] = "Membership upgrade package already exist";
				header("location: ". $head_page);
		        exit;
			}
			else
			{
			
				
				$sql = "INSERT INTO membership_upgrade_master SET
						Membership_Package_Name = '$Membership_Package_Name',
						Membership_Package_Amount 	 = '$Membership_Package_Amount',
						Membership_No = '$Membership_No',
						Membership_Package_Desc = '$Membership_Package_Desc',
						Help_Desc = '$Help_Desc',
						Membership_Package_Date = now(),
						Status = '$Status'";
				$result = mysql_query($sql) or die('<br>'.$sql.'<br>'.mysql_error());
				$_SESSION['sess_mess'] =  "Membership upgrade package successfully added";
				
				header("location: ". $list_page);
				exit;
			}
		
	}
  
	
}


if($_GET['id']!='')
{
$sql = "SELECT * FROM membership_upgrade_master WHERE Membership_Upgrade_Id ='".$_GET['id']."'";
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
	if (placeadd.Membership_Package_Name.value == "") 
	{
		alert("\nPlease enter upgrade membership package name.")
		placeadd.Membership_Package_Name.focus();
		return false;
	}
	
	else if (placeadd.Membership_Package_Amount.value == "") 
	{
		alert("\nPlease enter Price.")
		placeadd.Membership_Package_Amount.focus();
		return false;
	}
	
	
	
} 

	// Default skin
	tinyMCE.init({
		// General options
		mode : "exact",
		elements : "Package_Desc",
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
       <h2> Musician Upgrade Membership Package <?=$_GET['id']!='' ? 'Edit' : 'Add';?></h2>
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
            <td width="200" align="left" valign="middle">Package Name</td>
            <td align="left" valign="top" class="input-1"><input type="text" name="Membership_Package_Name" value="<?=stripslashes(trim($dataColles['Membership_Package_Name']));?>"  size="50" class="textbox"></td>
          </tr>
          
          <tr>
            <td width="200" align="left" valign="middle">Package Price</td>
            <td align="left" valign="top" class="input-1"><input type="text" name="Membership_Package_Amount" value="<?=trim($dataColles['Membership_Package_Amount']);?>"  size="50" class="textbox"></td>
          </tr>
          
          <tr>
            <td width="200" align="left" valign="middle">Number of Package</td>
            <td align="left" valign="top" class="input-1"><input type="text" name="Membership_No" value="<?=trim($dataColles['Membership_No']);?>"  size="50" class="textbox"></td>
          </tr>
          
           
           <tr>
            <td width="200" align="left" valign="middle">Detail</td>
            <td align="left" valign="top" class="input-1"> <input type="text" name="Membership_Package_Desc" value="<?=trim($dataColles['Membership_Package_Desc']);?>"  size="50" class="textbox"></td>
          </tr>
          
          <tr>
            <td width="200" align="left" valign="middle">Help MSG</td>
            <td align="left" valign="top" class="input-1"> <input type="text" name="Help_Desc" value="<?=stripslashes($dataColles['Help_Desc']);?>"  size="50" class="textbox"></td>
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
            <td align="left" valign="middle"><input type="hidden" name="id" value="<?=$dataColles['Membership_Upgrade_Id'];?>" /></td>
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
