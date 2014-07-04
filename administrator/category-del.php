<?php
include("../config/functions.inc.php");
include("session.inc.php");

if(count($_POST['ids'])>0)
{
    $ids = $_POST['ids'];

    $ids=implode(",",$ids);

	if($_POST['Submit']=='Delete')  
	{
		$query="select * from category_master where Category_Id  in (".$ids.") ";  
		$result=executeQuery($query);
		 
		 
		 while($line=mysql_fetch_array($result))
		 {
		  
		  $count=0;
		  $count=getSingleResult("select count(*) from category_master where 1 AND Parent_Id='".$line['Category_Id']."'");
		  
		  if($count>=1)
		  {
		  $_SESSION['sess_mess'].= ms_stripslashes($line['Category_Name'])." category can't delete because sub-categories exits";
		  continue;
		  }
		  
		  
		  $sql="delete from category_master where Category_Id='".$line['Category_Id']."'";
		  executeQuery($sql);
		  $_SESSION['sess_mess']="Selected records deleted successfully";
		  }
		
	}

	if($_POST['Submit']=='Active') 
	{
	  $sql = "UPDATE category_master  SET Status='1' WHERE Category_Id in (".$ids.")";
	  executeQuery($sql);
	  $_SESSION['sess_mess']="Selected records activated successfully";
	}

   if($_POST['Submit']=='Inactive') 
   {
    $sql = "UPDATE category_master SET Status='0' WHERE Category_Id in (".$ids.")";
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