<?php
require_once("config/functions.inc.php");
if($_SESSION['SESS_EMAIL']=="")
{
#$_SESSION["sess_mess"]="Access denied! Please login first.";
header("location:login.php");
exit();
}
?>