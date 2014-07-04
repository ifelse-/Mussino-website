<?php
require_once("config/functions.inc.php");
$sql33= "SELECT * FROM temp_order  WHERE  Sess_Id='".$sess_id."' ORDER BY T_Id ASC ";
$result33=mysql_query($sql33);


$sql_member = "SELECT * FROM member_account_master WHERE Member_Account_Id='".$_SESSION['SESS_ID']."' AND Account_Type!='ADMIN'";
$result_member = mysql_query($sql_member);
$colles_member = mysql_fetch_array($result_member);
$Total = 0;
$Grand_Total =0;
srand ((double) microtime()*1000000);
$random_number = rand();
$_SESSION['random_number'] = $random_number;
list($YY,$MM,$DD) = explode('-',date('Y-m-d'));
$nextOneMonth = mktime(0,0,0,$MM+1,$DD,$YY);
while($colles33 = mysql_fetch_array($result33))
{
if($colles33['Mode']==2 || $colles33['Mode']==3) { $nextOneMonthDate = date("Y-m-d", $nextOneMonth); } else { $nextOneMonthDate='0000-00-00'; }
$insert_sql = "INSERT INTO  orders SET
               Member_Account_Id  = '".$_SESSION['SESS_ID']."',
			   Grand_Amount  = '".$_SESSION['Grand_Full_Amount']."',
			   Pay_Type  = '".$_SESSION['SESS_TYPE']."',
			   Order_Date  = now(),
			   Next_Order_Date = '".$nextOneMonthDate."',
			   Status  = '1'";

$result_insert = mysql_query($insert_sql);

$l_insert = mysql_insert_id();

include("mail-containts.php");

$m_message=str_replace("Thank you for using our store.","Thank you for using our store. An order notification has been sent to your e-mail address.",$message);
executeQuery("INSERT INTO invoice set invoice='".trim(addslashes($m_message))."', U_No='".$_SESSION['random_number']."', Member_Account_Id='".$_SESSION['SESS_ID']."', O_Id='".$l_insert."'");

if($colles33['Mode']==0) 
	{ 
	
	$sql = "INSERT INTO package_history_master SET 
			Package_Id = '".$colles33['Id']."', 
			Member_Account_Id ='".$_SESSION['SESS_ID']."',
			Payment_Amount= '".Get_Single_Field("package_master","Package_Amount","Package_Id","$colles33[Id]")."',
			O_Id = '".$l_insert."',
			Mode = '0',
			Payment_Date=now(),
			Status='1' ";
			
	$result = mysql_query($sql)or die('<br>'.$sql.'<br>'.mysql_error());
	}
	elseif($colles33['Mode']==1) 
	{ 
	$sql = "INSERT INTO product_history_master SET 
			Product_Id = '".$colles33['Id']."', 
			Member_Account_Id ='".$_SESSION['SESS_ID']."',
			Payment_Amount= '".Get_Single_Field("product_master","Price","Product_Id","$colles33[Id]")."',
			O_Id = '".$l_insert."',
			Mode = '1',
			Payment_Date=now(),
			Status='1' ";
			
	$result = mysql_query($sql)or die('<br>'.$sql.'<br>'.mysql_error()); 
	}  
	elseif($colles33['Mode']==2) 
	{ 
	
	$sql = "INSERT INTO membership_upgrade_history_master SET 
			Membership_Upgrade_Id = '".$colles33['Id']."', 
			Member_Account_Id ='".$_SESSION['SESS_ID']."',
			Payment_Amount = '".Get_Single_Field("membership_upgrade_master","Membership_Package_Amount","Membership_Upgrade_Id","$colles33[Id]")."',
			Membership_No = '".Get_Single_Field("membership_upgrade_master","Membership_No","Membership_Upgrade_Id","$colles33[Id]")."',
			O_Id = '".$l_insert."',
			Mode = '2',
			Payment_Date=now(),
			Status='1' ";
			
	$result = mysql_query($sql)or die('<br>'.$sql.'<br>'.mysql_error());
	}
	elseif($colles33['Mode']==3) 
	{ 
	
	$sql = "INSERT INTO membership_artist_upgrade_history_master SET 
			Membership_Upgrade_Id = '".$colles33['Id']."', 
			Member_Account_Id ='".$_SESSION['SESS_ID']."',
			Payment_Amount= '".Get_Single_Field("membership_artist_upgrade_master","Membership_Package_Amount","Membership_Upgrade_Id","$colles33[Id]")."',
			Membership_No = '".Get_Single_Field("membership_upgrade_master","Membership_No","Membership_Upgrade_Id","$colles33[Id]")."',
			O_Id = '".$l_insert."',
			Mode = '3',
			Payment_Date=now(),
			Status='1' ";
			
	$result = mysql_query($sql)or die('<br>'.$sql.'<br>'.mysql_error());
	}
	elseif($colles33['Mode']==4) 
	{ 
	$sql = "INSERT INTO product_history_master SET 
			Product_Id = '".$colles33['Id']."', 
			Member_Account_Id ='".$_SESSION['SESS_ID']."',
			Payment_Amount= '".Get_Single_Field("product_master","Price","Product_Id","$colles33[Id]")."',
			O_Id = '".$l_insert."',
			Mode = '4',
			Payment_Date=now(),
			Status='1' ";
			
	$result = mysql_query($sql)or die('<br>'.$sql.'<br>'.mysql_error()); 
	} 
	elseif($colles33['Mode']==5) 
	{ 
	$sql = "INSERT INTO sell_session_history_master SET 
			S_S_Id = '".$colles33['Id']."', 
			Member_Account_Id ='".$_SESSION['SESS_ID']."',
			Payment_Amount= '".Get_Single_Field("sell_session","Price","S_S_Id","$colles33[Id]")."',
			O_Id = '".$l_insert."',
			Mode = '5',
			Payment_Date=now(),
			Status='1' ";
			
	$result = mysql_query($sql)or die('<br>'.$sql.'<br>'.mysql_error()); 
	} 

$To  = $colles_member['Email'];
$Name = $colles_member['First_Name']." ".$colles_member['Last_Name'];
$message1 = "Dear ".$Name.",\n\n";	
$message1 .= "Your Invoice Details \n\n";	
$message1 .= $message."\n\n";

$subject = "Mussino Order Confirmation";
$from_to =Get_Single_Field("general_setting_master","Mails_Id","Gen_Set_Id","1");

$To .=",".$from_to;
$mail = explode(",",$To);
$FROM  = Get_Single_Field("general_setting_master","Mails_Id","Gen_Set_Id","1");
$HEADER = "From: ".$FROM." \n";
$HEADER .= "MIME-Version: 1.0" . "\r\n";
$HEADER .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";



$mail = array_unique($mail);

foreach($mail as $k=>$a) 
{	 
 $MAILSEND = @mail($a, $subject, $message1, $HEADER);
}

$ct++;
}		
?>