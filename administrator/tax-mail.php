<?php 
include("../config/functions.inc.php");
include("session.inc.php");


if($_POST['Submit']=='Send Mail')
{
  
  $arrayCustomer = $_POST['Member_Account_Id'];
  
  
	if(count($arrayCustomer)>0)
	{
	$Subject = ms_stripslashes($_POST['Subject']);
	$Content = ms_stripslashes($_POST['Message']);
	$from = $_POST['From'];
	
	
	
	$email_count=0;
	for($i=0;$i<count($arrayCustomer);$i++)
	{
	$To  = $arrayCustomer[$i]; 
    $Header = "From: ".$from." \r\n";
    $Header .= "Content-type: text/html\r\n"; 
    $MAILSEND = @mail($To, $Subject, $Content, $Header);
	$email_count++;
	}
	
	$_SESSION['sess_mess']= '('.$email_count.') Emails has been sent';
	header("location: tax-setting.php");
	exit();
    }
	else
	{
	$_SESSION['sess_mess']='ERROR : Please select at least one Customer';
	header("Location:tax-mail.php");
    exit();
	}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Administrator</title>
<link href="css/layout-admin.css" rel="stylesheet" type="text/css" />
<link href="css/css.css" rel="stylesheet" type="text/css">
<script language="javascript">

function validateFormOnSubmit(theForm) {
var reason = "";

	reason += validateEmpty(theForm.Member_Account_Id);
	reason += validateEmpty(theForm.Subject);
	reason += validateEmpty2(theForm.From);
	
	
  if (reason != "") {
    alert("You must fill out the following fields : \n\n" + reason);
    return false;
  } else
	{ return true; }
}



function validateEmpty(fld) {
    var error = "";
 
    if (fld.value.length == 0) {
        fld.style.background = 'Yellow'; 
        error = "Customer \n"
    } else {
        fld.style.background = 'White';
    }
    return error;  
}

function validateEmpty1(fld) {
    var error = "";
 
    if (fld.value.length == 0) {
        fld.style.background = 'Yellow'; 
        error = "Subject \n"
    } else {
        fld.style.background = 'White';
    }
    return error;  
}
function validateEmpty2(fld) {
    var error = "";
 
    if (fld.value.length == 0) {
        fld.style.background = 'Yellow'; 
        error = "From \n"
    } else {
        fld.style.background = 'White';
    }
    return error;  
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
       <form name="placeadd" id="placeadd" action="<?=$PHP_SELF?>" method="POST"  onSubmit="return validateFormOnSubmit(this)">
       <div class="box-1">
       <h2> Send Tax Mail </h2>
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
            <td width="200" align="left" valign="middle">Select Customer</td>
            <td align="left" valign="top">
            <select name="Member_Account_Id[]" id="Member_Account_Id" multiple="multiple" size="10" style="width:210px;">
            <option value="">Select</option>
            <?php
            $sql_member="SELECT First_Name,	Last_Name, Email FROM member_account_master WHERE Status=1 AND Account_Type!='ADMIN' ORDER BY First_Name,Last_Name ";
            $result_member = mysql_query($sql_member);
            while($colles_member = mysql_fetch_array($result_member))
            {
            ?>
            <option value="<?=$colles_member['Email']?>"><?=trim($colles_member['First_Name'].' '.$colles_member['Last_Name'])?></option>
            <?php
            }
            ?>
            </select>
            </td>
          </tr>
          
          <tr>
            <td width="200" align="left" valign="middle">Mail Subject</td>
            <td align="left" valign="top" class="input-1"><input type="text" name="Subject" value="<?=stripslashes(trim($dataColles['Coupon_Code']));?>"  size="50" class="textbox"></td>
          </tr>
          
          <tr>
            <td width="200" align="left" valign="middle">Mail From</td>
            <td align="left" valign="top" class="input-1"><input type="text" name="From" value="<?=stripslashes(trim($dataColles['Coupon_Amount']));?>"  size="50" class="textbox"></td>
          </tr>
          
          <tr>
            <td width="200" align="left" valign="middle">Mail Message</td>
            <td align="left" valign="top" class="input-1"> 
			<?php
            include("../FCKeditor/fckeditor.php");
            $oFCKeditor = new FCKeditor('Message') ;
            $oFCKeditor->BasePath = '../FCKeditor/';
            $oFCKeditor->Value = stripslashes($Message);
            $oFCKeditor->Width  = '600' ;
            $oFCKeditor->Height = '400' ;
            $oFCKeditor->Create();
            ?>	
            </td>
          </tr>
          
          <tr>
            <td align="left" valign="middle"></td>
            <td align="left" valign="top" class="input-2"><input type="submit" name="Submit" value="Send Mail" class="buttons" /></td>
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
