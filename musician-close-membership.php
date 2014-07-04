<?php 
include("config/functions.inc.php");

if($_SESSION['SESS_ID']!='')
{
  
	$sql_up = "UPDATE membership_upgrade_history_master SET Status='".$_REQUEST['st']."' WHERE Member_Account_Id='".$_SESSION['SESS_ID']."'";
	mysql_query($sql_up);

	header("location:".$_SERVER['HTTP_REFERER']);
    exit();
}
else
{
header("location:".$_SERVER['HTTP_REFERER']);
exit();
}
?>