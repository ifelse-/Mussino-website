<?php
require_once "config/functions.inc.php";
 
if($_REQUEST['st']!='')
{
if($_REQUEST['st']=='hide') { $st = 'show'; } else { $st = 'hide'; }
mysql_query("UPDATE member_account_master SET Show_Profile='".$st."' WHERE Member_Account_Id='".$_SESSION['SESS_ID']."'");
header("location:my-profile.php");
exit;
}
?>