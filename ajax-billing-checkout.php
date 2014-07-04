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
	elseif($_REQUEST['First_Name']=='')
	{
	echo "<span style='color:#ff0000'>Please Enter First Name</span>";	
	} 
	elseif($_REQUEST['Last_Name']=='')
	{
	echo "<span style='color:#ff0000'>Please Enter Last Name</span>";	
	}	
	elseif($_REQUEST['Address']=='')
	{
	echo "<span style='color:#ff0000'>Please Enter Address</span>";	
	}
	elseif($_REQUEST['Country_Id']=='')
	{
	echo "<span style='color:#ff0000'>Please Select Country</span>";	
	}
	elseif($_REQUEST['State_Id']=='')
	{
	echo "<span style='color:#ff0000'>Please Select State</span>";	
	}
	elseif($_REQUEST['City_Id']=='')
	{
	echo "<span style='color:#ff0000'>Please Select City</span>";	
	}
	elseif($_REQUEST['City_Id']=='999999' && $_REQUEST['City']=='')
	{
	echo "<span style='color:#ff0000'>Please Enter Other City</span>";	
	}
	elseif($_REQUEST['Zip']=='')
	{
	echo "<span style='color:#ff0000'>Please Enter Zip</span>";	
	}
	elseif($_REQUEST['Phone']=='')
	{
	echo "<span style='color:#ff0000'>Please Enter Phone</span>";	
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
	
		if($_REQUEST['City_Id']=='999999') { $city = $_REQUEST['City']; } else { $city = '';}
		$query = "SELECT * FROM member_account_master WHERE Email='".$_REQUEST['Email']."' AND Member_Account_Id !='".$_SESSION['SESS_ID']."' AND Account_Type!='ADMIN'";
		$result = executeQuery($query);
		if(mysql_num_rows($result )==0)
		{
		$sql= " UPDATE member_account_master SET
		        Email = '".addslashes(trim($_REQUEST['Email']))."',
				First_Name = '".addslashes(trim($_REQUEST['First_Name']))."',
				Last_Name = '".addslashes(trim($_REQUEST['Last_Name']))."',
				Address = '".addslashes(trim($_REQUEST['Address']))."',
				Country_Id = '".trim($_REQUEST['Country_Id'])."',
				State_Id = '".trim($_REQUEST['State_Id'])."',
				City_Id = '".trim($_REQUEST['City_Id'])."',
				Other_City = '".addslashes($city)."',
				Zip = '".addslashes(trim($_REQUEST['Zip']))."',
				Phone = '".addslashes(trim($_REQUEST['Phone']))."'
				WHERE Member_Account_Id='".$_SESSION['SESS_ID']."'";
		$updated = executeQuery($sql);
				
		echo'Go Checkout';
		}
		else
		{
		echo "<span style='color:#ff0000'>Email ".$_REQUEST['Email']." already in use</span>";
		}
			
		
		
	}

?>