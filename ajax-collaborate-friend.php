<?php
require_once "config/functions.inc.php";
	if($_REQUEST['pro_id']!='')
	{
	
		
		$sql_collaborate = "SELECT * FROM member_account_master WHERE Member_Account_Id='".$_REQUEST['pro_id']."' ";
		$result_collaborate = mysql_query($sql_collaborate);
		$colles_collaborate = mysql_fetch_array($result_collaborate);
		
		$Email = $colles_collaborate['Email'];
		
		$u_no = time();
		
		$sql_member = "SELECT * FROM member_account_master WHERE Member_Account_Id='".$_SESSION['SESS_ID']."'";
		$result_member = mysql_query($sql_member);
		$colles_member = mysql_fetch_array($result_member);
		
		$sql_collaborate_temp = "SELECT * FROM collaborate_frnd_request_temp WHERE Collaborate_Id = '".$_SESSION['SESS_ID']."' AND Profile_Id = '".$_REQUEST['pro_id']."'";		
		$result_collaborate_temp = mysql_query($sql_collaborate_temp);
		if(mysql_num_rows($result_collaborate_temp)==0) { 
		$sql = "INSERT INTO collaborate_frnd_request_temp SET
				Collaborate_Id = '".$_SESSION['SESS_ID']."', 
				Profile_Id = '".$_REQUEST['pro_id']."',
				U_No ='".$u_no."'";
		$result = mysql_query($sql) or die('<br>'.$sql.'<br>'.mysql_error());
		
		
		$subject = "Collaborate Friend Request AT Music Site From ".$colles_member['First_Name']." ".$colles_member['Last_Name'];	
			
		$message= 'Dear '.$colles_collaborate['First_Name'].' '.$colles_collaborate['Last_Name'].',</br></br>';		
		
		$message.= '</br></br>Please give me confirmation as below</br></br>';
		$message.= '<a href="http://mussino.com/col-frnd-request.php?action=accept&u_no=$u_no" target="_blank">Accept</a> OR <a href="http://mussino.com/col-frnd-request.php?action=deny&u_no=$u_no" target="_blank">Deny</a>';
		$message.= 'Thanks </br>';
		$message.= $colles_member['First_Name'].' '.$colles_member['Last_Name'];
		
		$header = "From: ".$colles_member['Email']." \r\n";
		$header .= "Content-type: text/html\r\n";
		
		
		$mail = @mail($Email, $subject, $message, $header);
		if($mail)
		{
		echo 'An email has been successfully sent to '.$colles_collaborate['First_Name'].' '.$colles_collaborate['Last_Name'].' Please waiting your request Accept/Deny.';
		}
		else
		{
		echo 'Mail server error.';
		}
		}
		else
		{
		echo 'Already, You have requested become collaborating this guy';
		}
	}
	else
	{
	echo 'error';
	}
?>