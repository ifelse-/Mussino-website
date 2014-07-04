<?php
require_once "config/functions.inc.php";
	if($_REQUEST['To']=='')
	{
	echo "<span style='color:#ff0000'>Please Enter Email ID</span>";
	}
	elseif(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$",$_REQUEST['To']))
	{
	echo "<span style='color:#ff0000'>Invalid Email ID</span>";
	}
	elseif($_REQUEST['Subject']=='')
	{
	echo "<span style='color:#ff0000'>Please Enter Subject</span>";	
	}
	elseif($_REQUEST['Message']=='')
	{
	echo "<span style='color:#ff0000'>Please Enter Message</span>";	
	}
	elseif( $_REQUEST['security_code']=='')
	{
	echo "<span style='color:#ff0000'>Please Enter Image Code</span>";
	}
	elseif( $_SESSION['security_code'] != $_REQUEST['security_code'] && !empty($_SESSION['security_code']))
	{
	echo "<span style='color:#ff0000'>The code entered is incorrect. </span>";
	}
	else
	{
		
		 
		$sql = "SELECT Member_Account_Id FROM member_account_master WHERE Email LIKE '%".$_REQUEST['To']."%' AND Status=1 AND Account_Type!='ADMIN' AND Account_Type!='ADMINISTRATOR USER'";
		$result = mysql_query($sql);
		$colles = mysql_fetch_array($result);
		if(mysql_num_rows($result)>0)
		{
		$insert_Query = "INSERT INTO message_master SET
						 To_Id = '".trim($colles['Member_Account_Id'])."',
						 From_Id = '".trim($_SESSION['SESS_ID'])."',
						 Subject = '".trim(addslashes($_REQUEST['Subject']))."',
						 Message = '".trim(nl2br(addslashes($_REQUEST['Message'])))."',
						 Date = now(),
						 Sent=1";
		mysql_query($insert_Query);
		echo "<span style='color:#1FB221'>A message has been sent successfully.</span>";
		}
		else
		{
		echo "<span style='color:#ff0000'>404 ERROR</span>";
		}
		
		/*$subject = $_REQUEST['Subject'];		
		$message= 'Hello, </br></br>';		
		$message.= $Message;
		$message.= 'Thanks';
		$header = "From: ".$_SESSION['SESS_EMAIL']." \r\n";
		$header .= "Content-type: text/html\r\n"; 
		
		$mail = @mail($To, $subject, $message, $header);
		if($mail)
		{
		echo "<span style='color:#00FF00'>A message has been sent.</span>";
		}
		else
		{
		echo "<span style='color:#ff0000'>Mail server error.</span>";
		}*/
	}
?>