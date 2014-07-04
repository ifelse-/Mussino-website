<?php
require_once "config/functions.inc.php";

 
  	
	if($_REQUEST['Email']=='')
	{
	echo "<span style='color:#900'>Please Enter Email ID</span>";
	
	}
	elseif(!preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i",$_REQUEST['Email']))
	{
	echo "<span style='color:#900'>Invalid Email ID</span>";
	}
	elseif($_REQUEST['Password']=='')
	{
	echo "<span style='color:#900'>Please Enter Password</span>";	
	} 
	elseif($_REQUEST['ConfirmPassword']=='')
	{
	echo "<span style='color:#900'>Please Enter Confirm Password</span>";	
	}	
	elseif($_REQUEST['Password']!=$_REQUEST['ConfirmPassword'])
	{
	echo "<span style='color:#900'>Password Mis-Match</span>";	
	}
	elseif($_REQUEST['First_Name']=='')
	{
	echo "<span style='color:#900'>Please Enter Stage Name</span>";	
	}
	elseif( $_REQUEST['security_code']=='')
	{
	echo "<span style='color:#900'>Please Enter Image Code </span>";
	}
	elseif( $_SESSION['security_code'] != $_REQUEST['security_code'] && !empty($_SESSION['security_code']))
	{
	echo "<span style='color:#900'>The letters entered are incorrect. Please try again.</span>";
	}
	elseif($_REQUEST['terms']==0)
	{
	echo "<span style='color:#900'>Please agree to mussino terms of service and privacy policy </span>";
	}
	else
	{
	
		
		$query = "SELECT * FROM member_account_master WHERE Email='".$_REQUEST['Email']."'";
		$result = executeQuery($query);
		if(mysql_num_rows($result )==0)
		{
		$sql= " INSERT INTO member_account_master SET
		        Email = '".addslashes(trim($_REQUEST['Email']))."',
				Password = '".base64_encode(addslashes(trim($_REQUEST['Password'])))."',
				First_Name = '".addslashes(trim($_REQUEST['First_Name']))."',
				Account_Type = '".trim($_REQUEST['Account_Type'])."',
				Show_Profile = 'show',
				Date = now(),
				Status = '1'";
		$inserted = executeQuery($sql);
		
		# Email to admin about new registration
			
		    $SUBJECT = "New Registration at Mussino.com";
			$TO  = Get_Single_Field("general_setting_master","Mails_Id","Gen_Set_Id","1");
			
						
			$BODY  = "Stage Name : ".addslashes(trim($_REQUEST['First_Name']))." \n";
			$BODY .= "Email : ".addslashes(trim($_REQUEST['Email']))." \n";
			$BODY .= "Password : ".trim($_REQUEST['Password'])." \n";
			$BODY .= "Member : ".trim($_REQUEST['Account_Type'])." \n";
						
	
			$HEADER = "From: ".addslashes(trim($_REQUEST['First_Name']))." <".addslashes(trim($_REQUEST['Email']))."> \n";
			$HEADER .= "Reply-To: $To <$TO>\n";
			$HEADER .= "X-Mailer: PHP/" . phpversion() . "\n";
			$HEADER .= "X-Priority: 1";
		   
			$MAILSEND = @mail($TO, $SUBJECT, $BODY, $HEADER);
			
			# Email to user about new registration
			
			$SUBJECT1 = "Welcome to Mussino.com";
			$TO1   = addslashes(trim($_REQUEST['Email']));
			
			$BODY1  = "Dear ".addslashes(trim($_REQUEST['First_Name'])).",\n\n";
			$BODY1 .= "Stage Name : ".addslashes(trim($_REQUEST['First_Name']))." \n";
			$BODY1 .= "Email : ".addslashes(trim($_REQUEST['Email']))." \n";
			$BODY1 .= "Password : ".trim($_REQUEST['Password'])." \n";
			$BODY1 .= "Member : ".trim($_REQUEST['Account_Type'])." \n";
            
			
			$HEADER1 = "From: ".$TO." \n";
			$HEADER1 .= "X-Mailer: PHP/" . phpversion() . "\n";
			$HEADER1 .= "X-Priority: 1";
			
			$MAILSEND1 = @mail($TO1, $SUBJECT1, $BODY1, $HEADER1);		 
		
		
		$sql = "SELECT * FROM member_account_master WHERE  Email='".$_REQUEST['Email']."' AND Password='".base64_encode(addslashes(trim($_REQUEST['Password'])))."'";
		$result = executeQuery($sql);
		
		$line=mysql_fetch_array($result);
		$_SESSION['SESS_ID'] = $line['Member_Account_Id'];
		$_SESSION['SESS_EMAIL'] = $line['Email'];
		$_SESSION['SESS_FIRST_NAME']= ucfirst($line['First_Name']);
		$_SESSION['SESS_ACCOUNT_TYPE'] = $line['Account_Type'];
		
		mysql_query("UPDATE member_account_master SET Last_Visited=now() WHERE Member_Account_Id='".$_SESSION['SESS_ID']."'");
		
		echo'Go Welcome';
		}
		else
		{
		echo "<span style='color:#900'>Email ".$_REQUEST['Email']." already in use</span>";
		}
			
		
		
	}

?>