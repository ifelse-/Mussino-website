<?php
require_once "config/functions.inc.php";
	if($_REQUEST['action']!='undefined')
	{
	
		
		$sql_collaborate = "SELECT * FROM member_account_master WHERE Member_Account_Id='".$_REQUEST['id']."' AND Collaborate_Id='".$_SESSION['SESS_ID']."'";
		$result_collaborate = mysql_query($sql_collaborate);
		$colles_collaborate = mysql_fetch_array($result_collaborate);
		
		$Email = $colles_collaborate['Email'];
		
		$u_no = time();
		
		$sql_member = "SELECT * FROM member_account_master WHERE Member_Account_Id='".$_SESSION['SESS_ID']."'";
		$result_member = mysql_query($sql_member);
		$colles_member = mysql_fetch_array($result_member);
				
		$sql= " INSERT INTO invite_feiends_log SET
		        Collaborate_Id = '".$_REQUEST['id']."',
				Reason_Id = '".$_REQUEST['Reason']."',
				Action = '".$_REQUEST['action']."',
				U_No = '".$u_no."',
				Member_Account_Id = '".$_SESSION['SESS_ID']."',
				Invitation_Date = now()";

		mysql_query($sql);
		
		
		
		$subject = $_REQUEST['action']." AT Music Site From ".$colles_member['First_Name']." ".$colles_member['Last_Name'];	
			
		$message= 'Dear '.$colles_collaborate['First_Name'].' '.$colles_collaborate['Last_Name'].',</br></br>';		
		
		$message.= '</br></br>Please give me confirmation as below</br></br>';
		$message.= '<a href="http://mussino.com/notes-plan.php?status=accept&u_no=$u_no" target="_blank">Accept</a> OR <a href="http://mussino.com/notes-plan.php?status=deny&u_no=$u_no" target="_blank">Deny</a>';
		$message.= 'Thanks </br>';
		$message.= $colles_member['First_Name'].' '.$colles_member['Last_Name'];
		
		$header = "From: ".$colles_member['Email']." \r\n";
		$header .= "Content-type: text/html\r\n"; 
		
		$mail = @mail($Email, $subject, $message, $header);
		if($mail)
		{
		$_SESSION['sess_msg']='An email has been sent to your friend(s).';
		header('location:'.$_SERVER['HTTP_REFERER']);
		exit();
		}
		else
		{
		$_SESSION['sess_msg']='Mail server error.';
		header('location:'.$_SERVER['HTTP_REFERER']);
		exit();
		}
	}
	else
	{
	$_SESSION['sess_msg']='Please check the radio button value';
	header('location:'.$_SERVER['HTTP_REFERER']);
	exit();
	}
?>