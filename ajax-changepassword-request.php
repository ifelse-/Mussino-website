<?php
require_once "config/functions.inc.php";
  	
	if($_REQUEST['oldpassword']=='')
	{
	echo "<span style='color:#ff0000'>Please Enter Old Password</span>";
	}
	elseif($_REQUEST['Password']=='')
	{
	echo "<span style='color:#ff0000'>Please Enter New Password</span>";	
	} 
	elseif($_REQUEST['re_password']=='')
	{
	echo "<span style='color:#ff0000'>Please Enter Confirm Password</span>";	
	} 
	elseif($_REQUEST['Password']!=$_REQUEST['re_password'])
	{
	echo "<span style='color:#ff0000'>Password Mis-Match</span>";	
	}
	else
	{
	
		$oldpassword = base64_encode(addslashes(trim($_REQUEST['oldpassword'])));
		$sql = "SELECT Password FROM member_account_master WHERE  Password='".$oldpassword."' AND Member_Account_Id='".$_SESSION['SESS_ID']."'";
		$result = executeQuery($sql);
		$line = mysql_fetch_array($result);
		
		if($oldpassword === $line['Password'])
		{
			
			$Password = base64_encode(addslashes(trim($_REQUEST['Password'])));
			$sql = "UPDATE member_account_master SET Password  = '$Password' WHERE  Member_Account_Id='".$_SESSION['SESS_ID']."'";
			$result = mysql_query($sql) or die('<br>'.$sql.'<br>'.mysql_error());
			echo "<span style='color:#00FF00'>Password Changed Successfully</span>";
			
		}
		else
		{
			die(B);
			echo "<span style='color:#ff0000'>Invalid Old Password</span>";
			
		}
		
		
		
	}

?>