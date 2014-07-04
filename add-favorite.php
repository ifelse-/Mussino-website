<?php 
include("config/functions.inc.php");

if($_SESSION['SESS_ID']!='')
{

    $sql = "SELECT * FROM my_favorite_tab WHERE MY_Favorite_Id='".$_REQUEST['fav_id']."' AND My_Id='".$_SESSION['SESS_ID']."'";
	$result = mysql_query($sql);
	if(mysql_num_rows($result)==0)
	{
	$sql_ins = "INSERT INTO my_favorite_tab SET
			My_Id='".$_SESSION['SESS_ID']."',
			MY_Favorite_Id='".$_REQUEST['fav_id']."'";
			mysql_query($sql_ins);

	
	}
	header("location:unreleased-music.php");
    exit();
}
else
{
header("location:".$_SERVER['HTTP_REFERER']);
exit();
}
?>