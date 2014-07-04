<?php
require_once "config/functions.inc.php";
	if($_REQUEST['Email']=='')
	{
	echo "<span style='color:#ff0000'>Please Enter Email ID</span>";
	}
	elseif(!preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i",$_REQUEST['Email']))
	{
	echo "<span style='color:#ff0000'>Invalid Email ID</span>";
	}
	elseif($_REQUEST['Password']=='')
	{
	echo "<span style='color:#ff0000'>Please Enter Password</span>";	
	} 
	else
	{
	$sql = "SELECT * FROM member_account_master WHERE  Email='".$_REQUEST['Email']."' AND Password='".base64_encode(addslashes(trim($_REQUEST['Password'])))."'";
	$result = executeQuery($sql);
	    if(mysql_num_rows($result)>0)
		{
		$line=mysql_fetch_array($result);
		$_SESSION['SESS_ID'] = $line['Member_Account_Id'];
		$_SESSION['SESS_EMAIL'] = $line['Email'];
		$_SESSION['SESS_FIRST_NAME']= ucfirst($line['First_Name']);
		$_SESSION['SESS_LAST_NAME']= ucfirst($line['Last_Name']);
		$_SESSION['SESS_ACCOUNT_TYPE'] = $line['Account_Type'];
	
		mysql_query("UPDATE member_account_master SET Last_Visited=now() WHERE Member_Account_Id='".$_SESSION['SESS_ID']."'");
    	echo'Go Welcome';
		}
		else
		{
		echo "<span style='color:#ff0000'>Enter valid username and password</span>";
		}

	}
?>