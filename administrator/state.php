<?php 
include("../config/functions.inc.php");
include("session.inc.php");
$list_page ='state-list.php';
$head_page ='state.php';
if(isset($_REQUEST['submit']))
{ 

  @extract($_POST);
  @extract($_REQUEST);
  $State_Name = addslashes($State_Name);
    
  if($_REQUEST['id']!='')
	{
		$sql = "SELECT * FROM state_master WHERE State_Name = '$State_Name'  AND Country_Id='$Country_Id' AND State_Id !='".$_REQUEST['id']."'";
		$result = mysql_query($sql) or die('<br>'.$sql.'<br>'.mysql_error());
		if(mysql_num_rows($result)>0)
		{
			$_SESSION['sess_mess'] = "State already exist";
			header("location: ". $head_page."?id=".$_REQUEST['id']);
		    exit;
		}
		else
		{	
			$sql = "UPDATE state_master SET 
			        Country_Id = '$Country_Id',
					State_Name = '$State_Name',
					Status = '$Status'
					WHERE State_Id = '".$_REQUEST['id']."'";
			$result = mysql_query($sql) or die('<br>'.$sql.'<br>'.mysql_error());
			$_SESSION['sess_mess'] = "State updated successfully.";
			header("location: ". $list_page);
			exit;
		}
	}
	else
	{
		
			$sql = "SELECT * FROM state_master WHERE State_Name = '$State_Name'  AND Country_Id='$Country_Id' ";
			$result = mysql_query($sql) or die('<br>'.$sql.'<br>'.mysql_error());
			if(mysql_num_rows($result)>0)
			{
				$_SESSION['sess_mess'] = "State already exist";
				header("location: ". $head_page);
		        exit;
				
			}
			else
			{
			
				
				$sql = "INSERT INTO state_master SET
						Country_Id = '$Country_Id',
					    State_Name = '$State_Name',
						Status = '$Status'";
				$result = mysql_query($sql) or die('<br>'.$sql.'<br>'.mysql_error());
				$_SESSION['sess_mess'] =  "State successfully added";
				
				header("location: ". $list_page);
				exit;
			}
		
	}
  
	
}


if($_GET['id']!='')
{
$sql = "SELECT * FROM state_master WHERE State_Id ='".$_GET['id']."'";
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
<script>

    

function validate_submitsite_form(placeadd) 
{
	if (placeadd.Country_Id.value == "") 
	{
		alert("\nPlease select country name.")
		placeadd.Country_Id.focus();
		return false;
	}
	
	if (placeadd.State_Name.value == "") 
	{
		alert("\nPlease enter state name.")
		placeadd.State_Name.focus();
		return false;
	}
	
	
} 
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
       <h2> State <?=$_GET['id']!='' ? 'Edit' : 'Add';?></h2>
       <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table-1">
          <?
          if($_SESSION['sess_mess']!='') {
          ?>
          <tr>
             <td align="left" valign="middle" colspan="2" style="padding: 5px 0 5px 210px; font-weight:bolder; color:#666666; font-size:14px;"><?=$_SESSION['sess_mess']?><? $_SESSION['sess_mess']="";?>         
            </td>
          </tr>
        <? } ?>
          
          <tr>
            <td width="200" align="left" valign="middle">Country Name</td>
            <td align="left" valign="top" class="input-1">
            <select name="Country_Id">
            <option value="">Select</option>
            <?php
			$sql_country = "SELECT Country_Id, Country_Name FROM country_master WHERE Status=1 ORDER BY Country_Name";
			$result_country = mysql_query($sql_country) or die('<br>'.$sql_country.'<br>'.mysql_error());
			while($colles_country = mysql_fetch_array($result_country))
			{
			?>
            <option value="<?=$colles_country['Country_Id']?>" <?php if($colles_country['Country_Id']==$dataColles['Country_Id']) { echo 'selected'; } ?>><?=stripslashes($colles_country['Country_Name'])?></option>
            <?php
			}
			?>
            </select>
            </td>
          </tr>
          
          <tr>
            <td width="200" align="left" valign="middle">State Name</td>
            <td align="left" valign="top" class="input-1"><input type="text" name="State_Name" value="<?=stripslashes(trim($dataColles['State_Name']));?>"  size="50" class="textbox"></td>
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
            <td align="left" valign="middle"><input type="hidden" name="id" value="<?=$dataColles['State_Id'];?>" /></td>
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