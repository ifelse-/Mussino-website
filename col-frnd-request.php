<?php 
require_once "config/functions.inc.php";
if($_REQUEST['action']!='' && $_REQUEST['u_no']!='')
{
		if($_REQUEST['action']=='accept')
		{
		$sql = "SELECT * FROM collaborate_frnd_request_temp WHERE U_No = '".$_REQUEST['u_no']."'";
		$result = mysql_query($sql);
		$colles = mysql_fetch_array($result);
		
		$sql_check =  "SELECT * FROM member_account_master WHERE Member_Account_Id = '".$colles['Profile_Id']."'";
		$result_check = mysql_query($sql_check);
		$colles_check = mysql_fetch_array($result_check);
		if($colles_check['Collaborate_Id']=='')
		{
		$collaborate_id = trim($colles['Collaborate_Id']);
		}
		else
		{
		$collaborate_id = $colles_check['Collaborate_Id'].','.trim($colles['Collaborate_Id']);
		}
		$sql_status= " UPDATE member_account_master SET Collaborate_Id = '".$collaborate_id."' WHERE Member_Account_Id  = '".$colles['Profile_Id']."'";
		mysql_query($sql_status);
		
		
		$sql_check1 =  "SELECT * FROM member_account_master WHERE Member_Account_Id = '".$colles['Collaborate_Id']."'";
		$result_check1 = mysql_query($sql_check1);
		$colles_check1 = mysql_fetch_array($result_check1);
		if($colles_check1['Collaborate_Id']=='')
		{
		$profile_id = trim($colles['Profile_Id']);
		}
		else
		{
		$profile_id = $colles_check1['Collaborate_Id'].','.trim($colles['Profile_Id']);
		}
		
		$sql_status1 = " UPDATE member_account_master SET Collaborate_Id = '".$profile_id."' WHERE Member_Account_Id  = '".$colles['Collaborate_Id']."'";
		mysql_query($sql_status1);
		$sql_delete = " DELETE FROM collaborate_frnd_request_temp WHERE	U_No = '".$_REQUEST['u_no']."'";
		mysql_query($sql_delete);
		header('location:mussino.com');
		}
		
		if($_REQUEST['action']=='deny')
		{
		$sql_delete = " DELETE FROM collaborate_frnd_request_temp WHERE	U_No = '".$_REQUEST['u_no']."'";
		mysql_query($sql_delete);
		header('location:mussino.com');
		}
		
}
?>