<?php
require_once("config/functions.inc.php");
$sql_temp1 = "SELECT * FROM temp_order WHERE Sess_Id='".$sess_id."'";
$result_temp1 = mysql_query($sql_temp1);
include("mail.php");
$_SESSION['invoice']="yes";
					
executeQuery("delete from temp_order where Sess_Id='".$sess_id."' ");

$_SESSION['SESS_CARD_NUMBER']=='';
$_SESSION['SESS_EXPIRY_DATE']=='';
$_SESSION['SESS_TYPE']=='';
$_SESSION['Grand_Full_Amount']=='';
$_SESSION['go']=='';
$_SESSION['SESS_MSG'] = 'Order Successfully';
header("location: success.php");
exit();
?>