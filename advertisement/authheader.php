<?php
session_start();
$ss = $_SESSION['HAdd'];

if ($ss != "passed")
{
	$type = $_POST['type'];
	require_once "auth/config.php";

	if($hostname == "" || $dbname == "" || $username == "")
	{
	 echo "<div align=center class=rad>Invalid Data, Please give proper values in configuration file</div>";
	}

	if($type=="auth")
	{
		include "checkauth.php";
	}
	else{
	 include "authlogin.php";
	 $block = true;
	}

	
}else
{
	$block = false;
}
?>