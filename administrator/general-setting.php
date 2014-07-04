<?php 
include("../config/functions.inc.php");
include("session.inc.php");
$head_page ='general-setting.php';
if(isset($_REQUEST['submit']))
{ 

  @extract($_POST);
  
	$sql = "UPDATE general_setting_master SET 
			PayPall_Payment_Id   = '$PayPall_Payment_Id',
			Mails_Id = '$Mails_Id',
			musician_free_credit = '$musician_free_credit',
			artist_free_package = '$artist_free_package',
			genre_email_notification = '$genre_email_notification'
			WHERE Gen_Set_Id  = '1'";
	$result = mysql_query($sql) or die('<br>'.$sql.'<br>'.mysql_error());
	$_SESSION['sess_mess'] = "General setting updated successfully.";
	header("location: ". $head_page);
	exit;
		
	
}



$sql = "SELECT * FROM general_setting_master WHERE Gen_Set_Id  ='1'";
$result = mysql_query($sql) or die('<br>'.$sql.'<br>'.mysql_error());
$dataColles = mysql_fetch_array($result);
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
	if(placeadd.PayPall_Payment_Id.value == "") 
	{
		alert("\nPlease enter paypall email-Id.")
		placeadd.PayPall_Payment_Id.focus();
		return false;
	}
	else if(placeadd.Mails_Id.value == "") 
	{
		alert("\nPlease enter mail email.")
		placeadd.Mails_Id.focus();
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
       <h2> General Settings Edit</h2>
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
            <td width="200" align="left" valign="middle">Paypall Payment Email</td>
            <td align="left" valign="top" class="input-1"><input type="text" name="PayPall_Payment_Id" value="<?=trim($dataColles['PayPall_Payment_Id']);?>"  size="50" class="textbox"></td>
          </tr>
          
           <tr>
            <td width="200" align="left" valign="middle">Mail Email</td>
            <td align="left" valign="top" class="input-1"><input type="text" name="Mails_Id" value="<?=trim($dataColles['Mails_Id']);?>"  size="50" class="textbox"></td>
          </tr>
		<tr><td colspan="2"><strong>Session creation notification</strong></td></tr>
		<tr>
			<td width="200" align="left" valign="middle">Session notification</td>
			<td align="left" valign="top" class="input-1">
				<select name="genre_email_notification" class="textbox">
					<option value="yes" <?php echo (trim($dataColles['genre_email_notification']) == 'yes') ? ' selected="selected" ': ""; ?> >Enabled</option>
					<option value="no" <?php echo (trim($dataColles['genre_email_notification']) == 'no') ? ' selected="selected" ': ""; ?>>Disabled</option>
				</select>
			</td>
		</tr>
		<tr><td colspan="2"><strong>Signup free credits settings</strong></td></tr>
		<tr>
			<td width="200" align="left" valign="middle">Musician</td>
			<td align="left" valign="top" class="input-1"><input type="text" name="musician_free_credit" value="<?=trim($dataColles['musician_free_credit']);?>"  size="50" class="textbox"></td>
		</tr>
		<tr>
			<td width="200" align="left" valign="middle">Artist Free package</td>
			<td align="left" valign="top" class="input-1">
				<select name="artist_free_package" class="textbox">
				<?php
				$anysel = "no";
				$get_pkgs = mysql_query("select * FROM package_master where  Status=1 order by No_Of_Package");
				while($pkgs_row = mysql_fetch_array($get_pkgs))
				{
					$sel = "";
					if($pkgs_row['Package_Id'] == trim($dataColles['artist_free_package']))
					{
						$sel = " selected='selected' ";
						$anysel = "yes";
					}	
					$pkg_optns .= "<option value='".$pkgs_row['Package_Id']."' $sel>".$pkgs_row['Package_Name']."</option>";
				}
				if($anysel == "yes")				
					echo "<option value='0'>Select</option>";
				else
					echo "<option value='0' selected='selected'>Select</option>";
					
				echo $pkg_optns;
				?>
				</select>
			</td>
		</tr>
         
          <tr>
            <td align="left" valign="middle"></td>
            <td align="left" valign="top" class="input-2"><input type="submit" name="submit" value="Update"  class="buttons" /></td>
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
