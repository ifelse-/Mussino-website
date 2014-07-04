<?php
require_once "config/functions.inc.php";

 
  	if($_REQUEST['Account_Type']=='' || $_REQUEST['Account_Type']=='undefined')
	{
	echo "<span style='color:#ff0000'>Please Select Account Type</span>";	
	}
	elseif($_REQUEST['First_Name']=='')
	{
	echo "<span style='color:#ff0000'>Please Enter First Name</span>";	
	}	
	elseif($_REQUEST['Email']=='')
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
	elseif( $_REQUEST['security_code']=='')
	{
	echo "<span style='color:#ff0000'>Please Enter Image Code </span>";
	}
	elseif( $_SESSION['security_code'] != $_REQUEST['security_code'] && !empty($_SESSION['security_code']))
	{
	echo "<span style='color:#ff0000'>The letters entered are incorrect. Please try again.</span>";
	}
	elseif($_REQUEST['terms']==0)
	{
	echo "<span style='color:#ff0000'>Please agree to mussino terms of service and privacy policy </span>";
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
			
			$last_id = mysql_insert_id();
			if($_REQUEST['Account_Type']=='Artist') 
			{
				$gen_sat = mysql_query("SELECT * FROM general_setting_master WHERE Gen_Set_Id  ='1'");
				$gen_sat_row = mysql_fetch_array($gen_sat);
				if((int)$gen_sat_row['artist_free_package'] > 0)
				{
					$insert_sql = "INSERT INTO  orders SET
						   Member_Account_Id  = '".$last_id."',
						   Grand_Amount  = '0.00',
						   Pay_Type  = 'Free',
						   Order_Date  = now(),
						   Next_Order_Date = '0000-00-00',
						   Status  = '1'";

					$result_insert = mysql_query($insert_sql);
					$mysql_last_order_id = mysql_insert_id();	
						
					$sql_P = "  INSERT INTO package_history_master SET 
								Package_Id = '".(int)$gen_sat_row['artist_free_package']."', 
								Member_Account_Id ='".$last_id."',
								Payment_Amount= '0.00',
								O_Id = '".$mysql_last_order_id."',
								Mode = '0',
								Payment_Date=now(),
								Status='1' ";
					
					$result = mysql_query($sql_P);
				}
			
			}
		    # Email to admin about new registration
			
		    $SUBJECT = "New Registration at Mussino.com";
			$TO  = Get_Single_Field("general_setting_master","Mails_Id","Gen_Set_Id","1");
			
						
			$BODY  = "Name : ".addslashes(trim($_REQUEST['First_Name']))." \n";
			$BODY .= "Email : ".addslashes(trim($_REQUEST['Email']))." \n";
			$BODY .= "Password : ".trim($_REQUEST['Password'])." \n";
			$BODY .= "Member : ".trim($_REQUEST['Account_Type'])." \n";
						
	
			$HEADER = "From: ".addslashes(trim($_REQUEST['First_Name']))." <".addslashes(trim($_REQUEST['Email']))."> \n";
			$HEADER .= "Reply-To: $TO <$TO>\n";
			$HEADER .= "X-Mailer: PHP/" . phpversion() . "\n";
			$HEADER .= "X-Priority: 1";
		   
			$MAILSEND = @mail($TO, $SUBJECT, $BODY, $HEADER);
			
			# Email to user about new registration
			
			$SUBJECT1 = "Welcome to Mussino.com";
			$TO1   = addslashes(trim($_REQUEST['Email']));
			
			$BODY1  = "Dear ".addslashes(trim($_REQUEST['First_Name'])).",\n\n";
			$BODY1 .= "Name : ".addslashes(trim($_REQUEST['First_Name']))." \n";
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
		echo "<span style='color:#ff0000'>Email ".$_REQUEST['Email']." already in use</span>";
		}
			
		
		
	}

?>