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
	elseif($_REQUEST['Message']=='')
	{
	echo "<span style='color:#ff0000'>Please Enter Message</span>";	
	}
	else
	{
		
		
		@extract();
		$subject = "Checkout ";		
		$message= 'Dear friend, </br></br>';		
		$message.= $Message;
		$message.= 'Thanks';
		$header = "From: ".$Email." \r\n";
		$header .= "Content-type: text/html\r\n"; 
		
		$mail = @mail($Email, $subject, $message, $header);
		if($mail)
		{
		echo "<span style='color:#00FF00'>An email has been sent to your friend(s).</span>";
		}
		else
		{
		echo "<span style='color:#ff0000'>Mail server error.</span>";
		}
	}
?>