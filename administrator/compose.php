<?php 
include("../config/functions.inc.php");
include("session.inc.php");


if($_POST['submit']=='Send Mail')
{

	if(trim($_POST['id'])!="")
	{
	
	
	$Subject = ms_stripslashes($_POST['Subject']);
	$Content = ms_stripslashes($_POST['Message']);
	$from = $_POST['From'];
	
	$sql = "SELECT Email FROM member_account_master WHERE Member_Account_Id in ($_POST[id])";
	$result = mysql_query($sql);
	
	$colles = mysql_fetch_array($result);
	
	$To  = $colles['Email']; 
    $Header = "From: ".$from." \r\n";
    $Header .= "Content-type: text/html\r\n"; 
    $MAILSEND = @mail($To, $Subject, $Content, $Header);
	
	
	
	$_SESSION['sess_mess']= 'Mail has been sent';
	header("location: winner-list.php");
	exit();
	}
	
}

$sql = "SELECT * FROM product_master WHERE Product_Id='".$_REQUEST['id']."' AND Jack_Pot_Status='Winner'";
$result = mysql_query($sql);
$colles = mysql_fetch_array($result);
$musician = Get_Single_Field("member_account_master","Email","Member_Account_Id","$colles[Member_Account_Id]");

$sql_artist = "SELECT m.Email FROM member_account_master m INNER JOIN my_bank b ON(m.Member_Account_Id=b.From_Member_Account_Id) WHERE b.Product_Id='".$_REQUEST['id']."' AND b.Account_Type ='Artist' AND b.Jack_Pot_Status='Winner'";
$result_artist = mysql_query($sql_artist);
$artist='';
while($colles_artist = mysql_fetch_array($result_artist))
{
$artist.=$colles_artist['Email'].',';
}
$artist = substr($artist,0,-1);

$sql_judge = "SELECT m.Email FROM member_account_master m INNER JOIN my_bank b ON(m.Member_Account_Id=b.From_Member_Account_Id) WHERE b.Product_Id='".$_REQUEST['id']."' AND b.Account_Type ='Contest Judge' AND b.Jack_Pot_Status='Winner'";
$result_judge = mysql_query($sql_judge);
$judge='';
while($colles_judge = mysql_fetch_array($result_judge))
{
$judge.=$colles_judge['Email'].',';
}
$judge = substr($judge,0,-1);

$email = $musician.','.$artist.','.$judge;

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

    reason += validateEmpty(theForm.To);
	reason += validateEmpty1(theForm.Subject);
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
        error = "To \n"
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
  <div class="content-container-2">
<div class="content-container">
    <div class="left-navigation fl">
      <div class="left-navigation_inner">
        <? require_once "left.inc.php"; ?>
      </div>
    </div>
    <div class="detail-col fr">
      <div class="detail-col_inner">
       <form name="placeadd" id="placeadd" action="<?=$PHP_SELF?>" method="POST" onSubmit="return validateFormOnSubmit(this)">
       <div class="box-1">
       <h2>Compose Mail</h2>
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
            <td width="200" align="left" valign="middle">To</td>
            <td align="left" valign="top"><input type="text" name="To" value="<?=$email?>"  size="100" class="textbox" style="padding:3px 0 3px 0; background-color:#cccccc;"></td>
          </tr>
        
          <tr>
            <td width="200" align="left" valign="middle">Subject</td>
            <td align="left" valign="top" class="input-1"><input type="text" name="Subject" value=""  size="50" class="textbox"></td>
          </tr>
          
          <tr>
            <td width="200" align="left" valign="middle">From</td>
            <td align="left" valign="top" class="input-1"><input type="text" name="From" value=""  size="50" class="textbox"></td>
          </tr>
          
          
          
                     
          <tr>
            <td width="200" align="left" valign="middle">Message</td>
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
            <td align="left" valign="middle"><input type="hidden" name="id" value="<?=$id?>" /></td>
            <td align="left" valign="top" class="input-2"><input type="submit" name="submit" value="Send Mail"  class="buttons" /></td>
          </tr>
        </table>
       </div>
       
        </form>
      </div>
    </div>
    <div class="cl"></div>
  </div></div>
  <? include"footer.inc.php"?>
</div>

</body>
</html>
