<?php
require_once "config/functions.inc.php";
$redirect_url = SITE_WS_MPATH.'/'.$_SESSION['SESS_ID'].'/'.$_SESSION['SESS_FIRST_NAME'];
header("location:".$redirect_url);
exit(0);
?>