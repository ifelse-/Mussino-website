<?php
require_once "config/functions.inc.php";
$hash = substr(md5(mt_rand(1, 1000)), 10, 20);
	
	
	
	if($_REQUEST['Email']=='')
	{
	echo "<span style='color:#ff0000'>Please Enter Email</span>";
	}
	elseif(!preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i",$_REQUEST['Email']))
	{
	echo "<span style='color:#ff0000'>Invalid Email</span>";
	}
	elseif( $_REQUEST['security_code']=='')
	{
	echo "<span style='color:#ff0000'>Please Enter Image Code</span>";
	}
	elseif( $_SESSION['security_code'] != $_REQUEST['security_code'] && !empty($_SESSION['security_code']))
	{
	echo "<span style='color:#ff0000'>The letters entered are incorrect. Please try again.</span>";
	}	
	else
	{
	
				
		$sql="SELECT * FROM member_account_master WHERE  Email='".$Email."' AND Status=1";
		
		$result=executeQuery($sql);
		if(mysql_num_rows($result)==0)
		{
		echo "Invalid Email";
		}
		else
		{
		$line = mysql_fetch_array($result);
		$Password = base64_decode($line['Password']);
		
		
		$SUBJECT = 'Soundslikecash Password Change Confirmation';
		$from = Get_Single_Field("general_setting_master","Mails_Id","Gen_Set_Id","1");
		
		$BODY = "Your account information is below. <br><br>Email ID : $Email <br>Password : ".$Password;
		$BODY.= "<br><br>Thanks,";
		$BODY.= "<br>The Soundslikecash Team";

		$HEADER = "From: ".$from." <".$from."> \n";
		$HEADER .= "Reply-To: $Email <$Email>\n";
		$HEADER .= "Content-type: text/html\r\n"; 

	   
		$MAILSEND = @mail($Email, $SUBJECT, $BODY, $HEADER);
		
		echo "<span style='color:#00FF00'>An email has been sent to you. If you do not receive it within a few minutes, please check your junk mail folder before contacting us.</span>";
		}
	}

?>