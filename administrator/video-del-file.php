<?php
include("../config/functions.inc.php");
include("session.inc.php");


	if($_REQUEST['id']!='')  
	{
		 
	$sql1 = "SELECT * FROM video_master WHERE Video_Id ='".$_REQUEST['id']."' ";
	$result1 = mysql_query($sql1);
	$colles = mysql_fetch_array($result1);
	
	
	$image_name = $colles['Video_File'];
	$path = "../products/video_file/";
	$target_path = $path.$image_name;
	unlink($target_path);
	
	 $sql = "UPDATE video_master SET Video_File='' WHERE Video_Id ='".$_REQUEST['id']."'";  
	 executeQuery($sql);
	 
	}
	

header("location: $_SERVER[HTTP_REFERER]");
exit();

?>