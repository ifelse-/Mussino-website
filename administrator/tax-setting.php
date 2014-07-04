<?php 
include("../config/functions.inc.php");
include("session.inc.php");
$head_page ='tax-setting.php';
if(isset($_REQUEST['submit']))
{ 

  @extract($_POST);
  
	$sql = "UPDATE tax_percentage SET 
			Tax_New_Releases   = '$Tax_New_Releases',
			Tax_Admin   = '$Tax_Admin',
			Tax_Musician   = '$Tax_Musician'
			WHERE Tax_Percentage_Id  = '1'";
	$result = mysql_query($sql) or die('<br>'.$sql.'<br>'.mysql_error());
	$_SESSION['sess_mess'] = "Tax percentage setting updated successfully.";
	header("location: ". $head_page);
	exit;
		
	
}



$sql = "SELECT * FROM tax_percentage WHERE Tax_Percentage_Id  ='1'";
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
	if (placeadd.Tax_Value.value == "") 
	{
		alert("\nPlease enter tax percentage value.")
		placeadd.Tax_Value.focus();
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
       <h2> Tax Percentage Settings</h2>
       <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table-1">
       
       	 <tr>
            <td width="200" align="right" valign="middle" colspan="2"><a href="tax-mail.php" class="lin2">Send Mail</a></td>
            
          </tr>
       
          <?php if($_SESSION['sess_mess']!='') { ?>
          <tr>
            <td align="left" valign="middle" colspan="2" style="padding: 5px 0 5px 210px; font-weight:bolder; color:#666666; font-size:14px;">
             <?=$_SESSION['sess_mess']?><? $_SESSION['sess_mess']="";?>         
            </td>
            </tr>
          <? } ?>
          
          
           <!--<tr>
            <td width="200" align="left" valign="middle">Active Sessions Tax Percentage</td>
            <td align="left" valign="top" class="input-1"><input type="text" name="Tax_Active_Sessions" value="<?=trim($dataColles['Tax_Active_Sessions']);?>"  size="50" class="textbox"></td>
          </tr>-->
          
           <tr>
            <td width="200" align="left" valign="middle">New Releases Tax Percentage</td>
            <td align="left" valign="top" class="input-1"><input type="text" name="Tax_New_Releases" value="<?=trim($dataColles['Tax_New_Releases']);?>"  size="50" class="textbox"></td>
          </tr>
          
          <tr>
            <td width="200" align="left" valign="middle">Admin Tax Percentage</td>
            <td align="left" valign="top" class="input-1"><input type="text" name="Tax_Admin" value="<?=trim($dataColles['Tax_Admin']);?>"  size="50" class="textbox"></td>
          </tr>
          
          <tr>
            <td width="200" align="left" valign="middle">Musician Tax Percentage</td>
            <td align="left" valign="top" class="input-1"><input type="text" name="Tax_Musician" value="<?=trim($dataColles['Tax_Musician']);?>"  size="50" class="textbox"></td>
          </tr>
          
          <!--<tr>
            <td width="200" align="left" valign="middle">Artist Tax Percentage</td>
            <td align="left" valign="top" class="input-1"><input type="text" name="Tax_Artist" value="<?=trim($dataColles['Tax_Artist']);?>"  size="50" class="textbox"></td>
          </tr>-->
          
         
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
