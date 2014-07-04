<?php
require_once("config/functions.inc.php");
mysql_query("DELETE FROM temp_order WHERE Sess_Id ='".$sess_id."'");
session_unset();
session_destroy();
header("location:login.php");
exit();
?>