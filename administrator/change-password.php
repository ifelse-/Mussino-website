<?php 
include("../config/functions.inc.php");
include("session.inc.php");

if($_POST['submit']=='Save')
{
	@extract($_POST);
	$oldpassword = base64_encode(addslashes(trim($_POST['oldpassword'])));
	
	$sql = "SELECT Password FROM member_account_master WHERE Account_Type  = 'ADMIN' AND Password ='".$oldpassword."'";
	$result = mysql_query($sql) or die('<br>'.$sql.'<br>'.mysql_error());
	$line = mysql_fetch_array($result);
	

	if($oldpassword === $line['Password'])
	{
		$Password = base64_encode(addslashes(trim($_POST['password'])));

		$sql = "UPDATE member_account_master SET Password  = '$Password' WHERE Account_Type  = 'ADMIN' AND Password ='".$oldpassword."'";
		$result = mysql_query($sql) or die('<br>'.$sql.'<br>'.mysql_error());
		
		echo "<script>alert('PASSWORD CHANGED SUCCESSFULLY'); location.replace('logout.php');</script>";
		exit;
	}
	else
	{
		$_SESSION['sess_mess'] = "Invalid Old Password.";
		header("location: ".$_SERVER['HTTP_REFERER']);
		exit;
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
<script>
function checkValidPassword(theForm)
{
var reason = "";

	reason += validateEmpty(theForm.oldpassword);
	reason += validatePassword(theForm.password);
	reason += validateEmpty1(theForm.re_password);
	
		 
  if (reason != "") {
    alert("You must fill out the following fields:-\n\n" + reason);
    return false;
  } else
	{ return true; }
}
function validateEmpty(fld) {
    var error = "";
 
    if (fld.value.length == 0) {
        fld.style.background = '#5C5B5B'; 
        error = "OLD PASSWORD \n"
    } else {
        fld.style.background = '#D5D5D5';
    }
    return error;  
}

function validatePassword(fld) {
    var error = "";
    var illegalChars = /[\W_]/; // allow only letters and numbers 
 
    if (fld.value == "") {
        fld.style.background = '#5C5B5B';
        error = "NEW PASSWORD \n";
    } else if ((fld.value.length < 2) || (fld.value.length > 15)) {
        error = "NEW PASSWORD IS THE WRONG LENGTH \n";
        fld.style.background = '#5C5B5B';
    } else if (illegalChars.test(fld.value)) {
        error = "NEW PASSWORD CONTAINS ILLEGAL CHARACTERS \n";
        fld.style.background = '#5C5B5B';
    } else if (!((fld.value.search(/(a-z)+/)) && (fld.value.search(/(0-9)+/)))) {
        error = "NEW PASSWORD MUST CONTAIN AT LEAST ONE NUMERAL \n";
        fld.style.background = '#5C5B5B';
    } else {
        fld.style.background = '#D5D5D5';
    }
   return error;
}  
function validateEmpty1(fld) {
    var error = "";
 
    if (fld.value.length == 0) {
        fld.style.background = '#5C5B5B'; 
        error = "CONFIRM PASSWORD \n"
		} else if (document.form1.password.value != document.form1.re_password.value) {
        error = "YOUR PASSWORD DID NOT MATCH \n";
        fld.style.background = '#5C5B5B';
		} else {
        fld.style.background = '#D5D5D5';
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
       <form name="form1" id="form1" action="" method="POST"  onSubmit="return checkValidPassword(this);">
       <div class="box-1">
       <h2> Admin Password</h2>
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
            <td width="200" align="left" valign="middle">Old Password</td>
            <td align="left" valign="top" class="input-1">
            <input type="password" name="oldpassword" value="" size="50" class="textbox">
            </td>
          </tr>
          
          <tr>
            <td width="200" align="left" valign="middle">New Password</td>
            <td align="left" valign="top" class="input-1"><input type="password" name="password" value="" size="50" class="textbox"></td>
          </tr>
          
          <tr>
            <td align="left" valign="middle">Confirm Password</td>
            <td align="left" valign="top" class="input-1">
             <input type="password" name="re_password" value="" size="50" class="textbox">
            </td>
          </tr>
          <tr>
            <td align="left" valign="middle"></td>
            <td align="left" valign="top" class="input-2"><input type="submit" name="submit" value="Save"  class="buttons" /></td>
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
