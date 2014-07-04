<?php 
include("../config/functions.inc.php");
include("session.inc.php");
$list_page ='agent-list.php';
$head_page ='agent.php';
if(isset($_REQUEST['submit']))
{ 

  @extract($_POST);
  @extract($_REQUEST);
  $Agentname = addslashes($Agentname);
    
  if($_REQUEST['id']!='')
	{
		$sql = "SELECT * FROM addagent WHERE Agentname = '$Agentname'  AND Id !='".$_REQUEST['id']."'";
		$result = mysql_query($sql) or die('<br>'.$sql.'<br>'.mysql_error());
		if(mysql_num_rows($result)>0)
		{
			$_SESSION['sess_mess'] = "Agent already exist";
			header("location: ". $head_page."?id=".$_REQUEST['id']);
		    exit;
		}
		else
		{	
			$sql = "UPDATE addagent SET 
					Agentname = '".addslashes($Agentname)."',
					URL = '$URL',
					Address = '".addslashes($Address)."',
					EmailId = '$EmailId',
					Company = '$Company',
					Country = '".addslashes($Country)."',
					State = '".addslashes($State)."',
					Commision = '$Commision',
					Phoneno = '$Phoneno',
					Status = '$Status'
					WHERE Id = '".$_REQUEST['id']."'";
			$result = mysql_query($sql) or die('<br>'.$sql.'<br>'.mysql_error());
			$_SESSION['sess_mess'] = "Agent updated successfully.";
			header("location: ". $list_page);
			exit;
		}
	}
	else
	{
		
			$sql = "SELECT * FROM addagent WHERE Agentname = '$Agentname'  ";
			$result = mysql_query($sql) or die('<br>'.$sql.'<br>'.mysql_error());
			if(mysql_num_rows($result)>0)
			{
				$_SESSION['sess_mess'] = "Agent already exist";
				header("location: ". $head_page);
		        exit;
			}
			else
			{
			
				
				$sql = "INSERT INTO addagent SET
						Agentname = '".addslashes($Agentname)."',
						URL = '$URL',
						Address = '".addslashes($Address)."',
						EmailId = '$EmailId',
						Company = '$Company',
						Country = '".addslashes($Country)."',
						State = '".addslashes($State)."',
						Commision = '$Commision',
						Phoneno = '$Phoneno',
						DATE = now(),
						Status = '$Status'";
				$result = mysql_query($sql) or die('<br>'.$sql.'<br>'.mysql_error());
				$_SESSION['sess_mess'] =  "Agent successfully added";
				
				header("location: ". $list_page);
				exit;
			}
		
	}
  
	
}


if($_GET['id']!='')
{
$sql = "SELECT * FROM addagent WHERE Id ='".$_GET['id']."'";
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
<script language="javascript">

function validateFormOnSubmit(theForm) {
var reason = "";

	reason += validateEmpty(theForm.Agentname);
	reason += validateEmpty1(theForm.URL);
	reason += validateEmpty2(theForm.EmailId);
	reason += validateEmpty3(theForm.Phoneno);
	
	
  if (reason != "") {
    alert("You must fill out the following fields : \n\n" + reason);
    return false;
  } else
	{ return true; }
}

function trim(s)
{
  return s.replace(/^\s+|\s+$/, '');
}

function validateEmpty2(fld) {
    var error="";
    var tfld = trim(fld.value);                        // value of field with Blackspace trimmed off
    var emailFilter = /^[^@]+@[^@.]+\.[^@]*\w\w$/ ;
    var illegalChars= /[\(\)\<\>\ \,\;\:\\\"\[\]]/ ;
   
    if (fld.value == "") {
        fld.style.background = 'Yellow';
		error = "Email Address \n";
    } else if (!emailFilter.test(tfld)) {              //test email for illegal characters
        fld.style.background = 'Yellow';
		error = "Invalid Email Address \n";
    } else if (fld.value.match(illegalChars)) {
		fld.style.background = 'Yellow';
		error = "Email Address contains illegal characters \n";
    } else {
        fld.style.background = 'White';
    }
    return error;
}

function validateEmpty(fld) {
    var error = "";
 
    if (fld.value.length == 0) {
        fld.style.background = 'Yellow'; 
        error = "Agent Name \n"
    } else {
        fld.style.background = 'White';
    }
    return error;  
}
function validateEmpty1(fld) {
    var error = "";
 
    if (fld.value.length == 0) {
        fld.style.background = 'Yellow'; 
        error = "URL \n"
    } else {
        fld.style.background = 'White';
    }
    return error;  
}
function validateEmpty3(fld) {
    var error = "";
 
    if (fld.value.length == 0) {
        fld.style.background = 'Yellow'; 
        error = "Phone Number \n"
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
       <h2> Agent <?=$_GET['id']!='' ? 'Edit' : 'Add';?></h2>
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
            <td width="200" align="left" valign="middle">Agent Name</td>
            <td align="left" valign="top" class="input-1"><input type="text" name="Agentname" value="<?=stripslashes(trim($dataColles['Agentname']));?>"  size="50" class="textbox"></td>
          </tr>
          
          <tr>
            <td width="200" align="left" valign="middle">URL</td>
            <td align="left" valign="top" class="input-1"><input type="text" name="URL" value="<?=stripslashes(trim($dataColles['URL']));?>"  size="50" class="textbox"></td>
          </tr>
          
          <tr>
            <td width="200" align="left" valign="middle">Address </td>
            <td align="left" valign="top" class="input-1"><input type="text" name="Address" value="<?=stripslashes(trim($dataColles['Address']));?>"  size="50" class="textbox"></td>
          </tr>
          
          <tr>
            <td width="200" align="left" valign="middle">Email</td>
            <td align="left" valign="top" class="input-1"><input type="text" name="EmailId" value="<?=stripslashes(trim($dataColles['EmailId']));?>"  size="50" class="textbox"></td>
          </tr>
          
          <tr>
            <td width="200" align="left" valign="middle">PIN Code</td>
            <td align="left" valign="top" class="input-1"><input type="text" name="Company" value="<?=stripslashes(trim($dataColles['Company']));?>"  size="50" class="textbox"></td>
          </tr>
          
          <tr>
            <td width="200" align="left" valign="middle">Country </td>
            <td align="left" valign="top" class="input-1"><input type="text" name="Country" value="<?=stripslashes(trim($dataColles['Country']));?>"  size="50" class="textbox"></td>
          </tr>
          
          <tr>
            <td width="200" align="left" valign="middle">State</td>
            <td align="left" valign="top" class="input-1"><input type="text" name="State" value="<?=stripslashes(trim($dataColles['State']));?>"  size="50" class="textbox"></td>
          </tr>
          
          <tr>
            <td width="200" align="left" valign="middle">Commision (%)</td>
            <td align="left" valign="top" class="input-1"><input type="text" name="Commision" value="<?=stripslashes(trim($dataColles['Commision']));?>"  size="50" class="textbox"></td>
          </tr>
          
          <tr>
            <td width="200" align="left" valign="middle">Phone</td>
            <td align="left" valign="top" class="input-1"><input type="text" name="Phoneno" value="<?=stripslashes(trim($dataColles['Phoneno']));?>"  size="50" class="textbox"></td>
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
            <td align="left" valign="middle"><input type="hidden" name="id" value="<?=$dataColles['Id'];?>" /></td>
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
