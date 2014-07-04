<?php
require_once "config/functions.inc.php";

	if($_REQUEST['Lyrics_Comment']=='')
	{
	echo "Empty Value";
	}
	elseif($_REQUEST['pid']=='' && $_REQUEST['mid']=='')
	{
	echo "Error";	
	} 
	else
	{
	
		$sql = "SELECT * FROM lyrics_post_comment_master WHERE  Product_Id='".$_REQUEST['pid']."' AND Member_Account_Id='".$_REQUEST['mid']."'";
		$result = executeQuery($sql);

		if(mysql_num_rows($result )==0)
		{
		$sql_insert = "INSERT INTO lyrics_post_comment_master SET
						Lyrics_Comment = '".addslashes($_REQUEST['Lyrics_Comment'])."',
						Member_Account_Id = '".$_REQUEST['mid']."',
						Product_Id = '".$_REQUEST['pid']."',
						Lyrics_Comment_Date = now(),
						Status = '1'";
		executeQuery($sql_insert);
		echo "Post Added";
		}
		else
		{
		echo "Post Already Exist";
		}

	}

?>