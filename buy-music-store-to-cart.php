<?php 
include("config/functions.inc.php");
if($_REQUEST['id']!='')
{
	$sql = "INSERT INTO temp_order SET
			Sess_Id='".$sess_id."',
			Id='".$_REQUEST['id']."',
			Mode='4'";
			mysql_query($sql);
	header("location:my-cart.php");
    exit();
}
else
{
header("location:".$_SERVER['HTTP_REFERER']);
exit();
}
?>