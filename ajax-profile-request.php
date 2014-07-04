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
	echo "<span style='color:#ff0000'>Please Enter Stagename</span>";	
	}
	else
	{
	
		
		$query = "SELECT * FROM member_account_master WHERE Email='".$_REQUEST['Email']."' AND Member_Account_Id !='".$_SESSION['SESS_ID']."' AND Account_Type!='ADMIN'";
		$result = executeQuery($query);
		if($_REQUEST['City_Id']=='999999') { $city = $_REQUEST['City']; } else { $city = '';}
		if(mysql_num_rows($result )==0)
		{
			if(trim(addslashes($_REQUEST['map_location_city_lng'])) != '' && trim(addslashes($_REQUEST['map_location_city_lat'])) != '')
			{
			$extra_str = ",`map_location` = '".trim(addslashes($_REQUEST['map_location']))."',
				`map_location_city` = '".trim(addslashes($_REQUEST['map_location_city']))."',
				`map_location_city_lat` = '".trim(addslashes($_REQUEST['map_location_city_lat']))."',
				`map_location_city_lng` = '".trim(addslashes($_REQUEST['map_location_city_lng']))."'";
			}	
		$sql= " UPDATE member_account_master SET
		        Email = '".addslashes(trim($_REQUEST['Email']))."',
				Paypal_Email = '".addslashes(trim($_REQUEST['Paypal_Email']))."',
				First_Name = '".addslashes(trim($_REQUEST['First_Name']))."',
				Last_Name = '".addslashes(trim($_REQUEST['Last_Name']))."',
				Address = '".addslashes(trim($_REQUEST['Address']))."',
				Country_Id = '".trim($_REQUEST['Country_Id'])."',
				State_Id = '".trim($_REQUEST['State_Id'])."',
				City_Id = '".trim($_REQUEST['City_Id'])."',
				Other_City 	= '".addslashes($city)."',
				Phone = '".trim($_REQUEST['Phone'])."',
				Zip = '".trim($_REQUEST['Zip'])."',
				Personal_Msg = '".trim($_REQUEST['Personal_Msg'])."',
				Session_Email = '".trim($_REQUEST['Session_Email'])."',
				News_Letter = '".trim($_REQUEST['News_Letter'])."',
				About_Me = '".trim(addslashes($_REQUEST['About_Me']))."'			
				".$extra_str."
				WHERE Member_Account_Id='".$_SESSION['SESS_ID']."'";
		$inserted = executeQuery($sql);
		echo "<span style='color:#00FF00'>Profile Updated</span>";
		}
		else
		{
		echo "<span style='color:#ff0000'>Email ".$_REQUEST['Email']." already in use</span>";
		}
			
		
		
	}

?>