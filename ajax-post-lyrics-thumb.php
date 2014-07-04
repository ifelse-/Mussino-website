<?php
require_once "config/functions.inc.php";

	
		$sql1 = "SELECT * FROM lyrics_post_master WHERE  Product_Id='".$_REQUEST['pid']."' AND Member_Account_Id='".$_REQUEST['mid']."'";
		$result1 = executeQuery($sql1);
		if(mysql_num_rows($result1)==0)
		{
		$sql = "SELECT * FROM lyrics_post_master WHERE  Product_Id='".$_REQUEST['pcid']."' AND Member_Account_Id='".$_REQUEST['mid']."'";
		$result = executeQuery($sql);
		$colles = mysql_fetch_array($result);
		$sql_insert = "INSERT INTO lyrics_post_master SET
		        Lyrics = '".addslashes($colles['Lyrics'])."',
				Type = '".$_REQUEST['type']."',
				Member_Account_Id = '".$_REQUEST['mid']."',
				Product_Id = '".$_REQUEST['pid']."',
				Lyrics_Date = now(),
				Status = '1'";
		executeQuery($sql_insert);
		echo "Post Added";
		}
		else
		{
		echo "Post Already Exist";
		}

?>