<?php 
include("../config/functions.inc.php");
include("session.inc.php");
$list_page ='package-list.php';
$head_page ='package.php';
if(isset($_REQUEST['submit']))
{ 

  @extract($_POST);
  @extract($_REQUEST);
  $Package_Name = addslashes(trim($Package_Name));
  $Package_Desc = addslashes(trim($Package_Desc));
    
  if($_REQUEST['id']!='')
	{
		$sql = "SELECT * FROM package_master WHERE Package_Name = '$Package_Name'  AND Package_Id !='".$_REQUEST['id']."'";
		$result = mysql_query($sql) or die('<br>'.$sql.'<br>'.mysql_error());
		if(mysql_num_rows($result)>0)
		{
			$_SESSION['sess_mess'] = "Package already exist";
			header("location: ". $head_page."?id=".$_REQUEST['id']);
		    exit;
		}
		else
		{	
			$sql = "UPDATE package_master SET 
					Package_Name = '$Package_Name',
					Package_Amount 	 = '$Package_Amount',
					No_Of_Package = '$No_Of_Package',
					Package_Desc = '$Package_Desc',
					Status = '$Status'
					WHERE Package_Id = '".$_REQUEST['id']."'";
			$result = mysql_query($sql) or die('<br>'.$sql.'<br>'.mysql_error());
			$_SESSION['sess_mess'] = "Package updated successfully.";
			header("location: ". $list_page);
			exit;
		}
	}
	else
	{
		
			$sql = "SELECT * FROM package_master WHERE Package_Name = '$Package_Name'  ";
			$result = mysql_query($sql) or die('<br>'.$sql.'<br>'.mysql_error());
			if(mysql_num_rows($result)>0)
			{
				$_SESSION['sess_mess'] = "Package already exist";
				header("location: ". $head_page);
		        exit;
			}
			else
			{
			
				
				$sql = "INSERT INTO package_master SET
						Package_Name = '$Package_Name',
						Package_Amount 	 = '$Package_Amount',
						No_Of_Package = '$No_Of_Package',
						Package_Desc = '$Package_Desc',
						Package_Date = now(),
						Status = '$Status'";
				$result = mysql_query($sql) or die('<br>'.$sql.'<br>'.mysql_error());
				$_SESSION['sess_mess'] =  "Package successfully added";
				
				header("location: ". $list_page);
				exit;
			}
		
	}
  
	
}


if($_GET['id']!='')
{
$sql = "SELECT * FROM package_master WHERE Package_Id ='".$_GET['id']."'";
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
	if (placeadd.Package_Name.value == "") 
	{
		alert("\nPlease enter package name.")
		placeadd.Package_Name.focus();
		return false;
	}
	
	else if (placeadd.Package_Amount.value == "") 
	{
		alert("\nPlease enter Price.")
		placeadd.Package_Amount.focus();
		return false;
	}
	else if (placeadd.No_Of_Package.value == "") 
	{
		alert("\nPlease enter notes.")
		placeadd.No_Of_Package.focus();
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
       <h2> Package <?=$_GET['id']!='' ? 'Edit' : 'Add';?></h2>
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
            <td align="left" valign="top" class="input-1"><input type="text" name="Package_Name" value="<?=stripslashes(trim($dataColles['Package_Name']));?>"  size="50" class="textbox"></td>
          </tr>
          
          <tr>
            <td width="200" align="left" valign="middle">Package Price</td>
            <td align="left" valign="top" class="input-1"><input type="text" name="Package_Amount" value="<?=trim($dataColles['Package_Amount']);?>"  size="50" class="textbox"></td>
          </tr>
          
           <tr>
            <td width="200" align="left" valign="middle">Notes</td>
            <td align="left" valign="top" class="input-1"><input type="text" name="No_Of_Package" value="<?=trim($dataColles['No_Of_Package']);?>"  size="10" class="textbox"></td>
          </tr>
          
           <tr>
            <td width="200" align="left" valign="middle">Detail</td>
            <td align="left" valign="top" class="input-1"> <textarea name="Package_Desc" rows="3" cols="60"><?=stripslashes($dataColles['Package_Desc'])?></textarea></td>
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
            <td align="left" valign="middle"><input type="hidden" name="id" value="<?=$dataColles['Package_Id'];?>" /></td>
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
