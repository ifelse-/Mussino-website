<?php
require_once "config/functions.inc.php";
	if($_REQUEST['pro_id']=='')
	{
	echo "<span style='color:#ff0000'>Server Error : 80040 your url have broken </span>";		
	}
	elseif($_REQUEST['Subject']=='')
	{
	echo "<span style='color:#ff0000'>Please Enter Subject </span>";	
	}
	elseif($_REQUEST['Message']=='')
	{
	echo "<span style='color:#ff0000'>Please Enter Message </span>";	
	}
	else
	{
		
		$toemail = Get_Single_Field("member_account_master","Email","Member_Account_Id","$_REQUEST[pro_id]");
		$sql = "SELECT Member_Account_Id FROM member_account_master WHERE Email LIKE '%".$toemail."%' AND Status=1 AND Account_Type!='ADMIN' AND Account_Type!='ADMINISTRATOR USER'";
		$result = mysql_query($sql);
		$colles = mysql_fetch_array($result);
		if(mysql_num_rows($result)>0)
		{
		$insert_Query = "INSERT INTO message_master SET
						 To_Id = '".trim($_REQUEST['pro_id'])."',
						 From_Id = '".trim($_SESSION['SESS_ID'])."',
						 Subject = '".trim(addslashes($_REQUEST['Subject']))."',
						 Message = '".trim(nl2br(addslashes($_REQUEST['Message'])))."',
						 Date = now(),
						 Sent=1";
		mysql_query($insert_Query);
		echo "<span style='color:#1FB221'>A message has been sent successfully.</span>";
	   }
	   else
	   {
	    echo "<span style='color:#ff0000'>Server Error : 80044 not authorize  </span>";	   
	   }
}
?>