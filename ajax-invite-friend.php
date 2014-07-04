<?php
require_once "config/functions.inc.php";
	if($_REQUEST['Name']=='')
	{
	echo "<span style='color:#ff0000'>Please Enter Friend Name</span>";
	}
	elseif($_REQUEST['Email']=='')
	{
	echo "<span style='color:#ff0000'>Please Enter Friend Email ID</span>";
	}
	elseif(!preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i",$_REQUEST['Email']))
	{
	echo "<span style='color:#ff0000'>Invalid Email ID</span>";
	}
	elseif($_REQUEST['Message']=='')
	{
	echo "<span style='color:#ff0000'>Please Enter Message</span>";	
	}
	elseif( $_REQUEST['security_code']=='')
	{
	echo "<span style='color:#ff0000'>Please Enter Image Code </span>";
	}
	elseif( $_SESSION['security_code'] != $_REQUEST['security_code'] && !empty($_SESSION['security_code']))
	{
	echo "<span style='color:#ff0000'>The letters entered are incorrect. Please try again.</span>";
	}
	else
	{
		$Email = $_REQUEST['Email'];
		
		$u_no = range("Z", "A", 2).substr(rand(1, 1000000),0,4);
		
		$sql_member = "SELECT * FROM member_account_master WHERE Member_Account_Id='".$_SESSION['SESS_ID']."'";
		$result_member = mysql_query($sql_member);
		$colles_member = mysql_fetch_array($result_member);
				
		$sql= " INSERT INTO invite_feiends_log SET
		        Friend_Email = '".addslashes(trim($_REQUEST['Email']))."',
				Friend_Name = '".addslashes(trim($_REQUEST['Name']))."',
				U_No = '".$u_no."',
				Member_Account_Id = '".$_SESSION['SESS_ID']."',
				Invitation_Date = now()";

		mysql_query($sql);
		
		
		
		$subject = "Music Notes Invitation From ".$colles_member['First_Name']." ".$colles_member['Last_Name'];	
			
		$message= 'Dear '.$_REQUEST['Name'].',</br></br>';		
		$message.= $_REQUEST['Message'];
		/*$message.= '</br></br>Please give me confirmation as below</br></br>';
		$message.= '<a href="http://localhost/music_site/notes-plan.php?status=accept&u_no=$u_no" target="_blank">Accept</a> OR <a href="http://localhost/music_site/notes-plan.php?status=deny&u_no=$u_no" target="_blank">Deny</a>';*/
		$message.= 'Thanks </br>';
		$message.= $colles_member['First_Name'].' '.$colles_member['Last_Name'];
		
		$header = "From: ".$colles_member['Email']." \r\n";
		$header .= "Content-type: text/html\r\n"; 
		
		$mail = @mail($Email, $subject, $message, $header);
		if($mail)
		{
		echo"<span style='color:#00FF00'>An email has been sent to your friend(s).</span>";
		}
		else
		{
		echo "<span style='color:#ff0000'>Mail server error.</span>";
		}
	}
?>