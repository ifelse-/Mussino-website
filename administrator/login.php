<?php
include("../config/functions.inc.php");
$Email = trim($_POST['Email']);
$Password=base64_encode(addslashes(trim($_POST['Password'])));

$sql="SELECT * FROM member_account_master  WHERE Email='$Email' AND Password='$Password' AND status=1 AND Account_Type = 'ADMIN' ";
$result=executeQuery($sql);
$line=mysql_fetch_array($result);
$num=mysql_num_rows($result);
if($num>0)
{
	if($_POST['Remember_Me']==1)
	{
	  setcookie("Email",trim(stripslashes($_POST['Email'])),time()+60*60*24*30);
	  setcookie("Password",trim(stripslashes($_POST['Password'])),time()+60*60*24*30);
	}
	else
	{
	  setcookie("Email","");
	  setcookie("Password","");
	}

	$_SESSION["FIRST_NAME"]=$line['First_Name'];
	$_SESSION["LAST_NAME"]=$line['Last_Name'];
	$_SESSION["LAST_VISITED"]=$line['Last_Visited'];
	$_SESSION["ADMIN"]=$line['Email'];
	$_SESSION["ID"]=$line['Member_Account_Id'];
	mysql_query("UPDATE member_account_master SET Last_Visited=now() WHERE Account_Type='ADMIN'");
	header("Location:dashboard.php");
	exit();
}
else
{
	$_SESSION['sess_msg']="Enter valid username and password";
	header("Location:index.php");
	exit();
}

?>
