<?php
include("../config/functions.inc.php");
include("session.inc.php");

if(count($_POST['ids'])>0)
{
    $ids = $_POST['ids'];

    $ids=implode(",",$ids);

		if($_POST['Submit']=='Delete')  
		{
		 
			$sql1 = "SELECT * FROM news_master WHERE News_Id  in (".$ids.") ";
			$result1 = mysql_query($sql1);
			while($colles = mysql_fetch_array($result1))
			{
				if($colles['Image']!='')
				{
				$image_name = $colles['Image'];
				$path = "../products/news_image/";
				$target_path = $path.$image_name;
				unlink($target_path);
				}
			 
				$sql = "DELETE FROM news_master WHERE News_Id in (".$ids.") ";  
				executeQuery($sql);
				$_SESSION['sess_mess']="Selected records deleted successfully";
			
			}
		}
		if($_POST['Submit']=='Active') 
		{
		  $sql = "UPDATE news_master  SET Status='1' WHERE News_Id in (".$ids.")";
		  executeQuery($sql);
		  $_SESSION['sess_mess']="Selected records activated successfully";
		}
	
	   if($_POST['Submit']=='Inactive') 
	   {
		$sql = "UPDATE news_master SET Status='0' WHERE News_Id in (".$ids.")";
		executeQuery($sql);
		$_SESSION['sess_mess']="Selected records inactivated successfully";
		}
  
  header("location: $_SERVER[HTTP_REFERER]");
  exit();
}
else
{
	$_SESSION['sess_mess']="Please check the check boxes! ";
	header("location: $_SERVER[HTTP_REFERER]");
	exit();
}
?>