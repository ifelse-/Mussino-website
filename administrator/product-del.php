<?php
include("../config/functions.inc.php");
include("session.inc.php");

if(count($_POST['ids'])>0)
{
    $ids = $_POST['ids'];

    $ids=implode(",",$ids);

	if($_POST['Submit']=='Delete')  
	{
	
	 
	 $sql1 = "DELETE FROM product_master WHERE Product_Id in (".$ids.") ";  
	 executeQuery($sql1);
	 	
	 $_SESSION['sess_mess']="Selected records deleted successfully";
	
	}

	if($_POST['Submit']=='Active') 
	{
	  $sql = "UPDATE product_master  SET Status='1' WHERE Product_Id in (".$ids.")";
	  executeQuery($sql);
	  $_SESSION['sess_mess']="Selected records activated successfully";
	}

   if($_POST['Submit']=='Inactive') 
   {
    $sql = "UPDATE product_master SET Status='0' WHERE Product_Id in (".$ids.")";
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