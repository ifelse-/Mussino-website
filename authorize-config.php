<?php
require_once('authorizenet.cim.class.php');
$auth_net_login_id			= "5MY5BdRf6y9";
$auth_net_tran_key			= "5D692svSv5y4RM9G";
$cim = new AuthNetCim($auth_net_login_id, $auth_net_tran_key, false);
?>