<?php
include("config/functions.inc.php");
if ($_REQUEST['Action']=='modify-cart')  
{
 mysql_query("DELETE FROM temp_order WHERE T_Id ='".$_REQUEST['id']."' AND Sess_Id='".$sess_id."'");
 header("location: $_SERVER[HTTP_REFERER]");
 exit();
}
?>