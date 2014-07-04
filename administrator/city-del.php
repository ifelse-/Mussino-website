<?php
include("../config/functions.inc.php");
include("session.inc.php");

if(count($_POST['ids'])>0)
{
    $ids = $_POST['ids'];

    $ids=implode(",",$ids);

	if($_POST['Submit']=='Delete')  
	{
	 $sql = "DELETE FROM city_master WHERE City_Id in (".$ids.") ";  
	 executeQuery($sql);
	 $_SESSION['SESS_MSG']="Selected records deleted successfully";
	}

	if($_POST['Submit']=='Active') 
	{
	  $sql = "UPDATE city_master  SET Status='1' WHERE City_Id in (".$ids.")";
	  executeQuery($sql);
	  $_SESSION['SESS_MSG']="Selected records activated successfully";
	}

   if($_POST['Submit']=='Inactive') 
   {
    $sql = "UPDATE city_master SET Status='0' WHERE City_Id in (".$ids.")";
    executeQuery($sql);
    $_SESSION['SESS_MSG']="Selected records inactivated successfully";
    }
  
  header("location: $_SERVER[HTTP_REFERER]");
  exit();
}
else
{
	$_SESSION['SESS_MSG']="Please check the check boxes! ";
	header("location: $_SERVER[HTTP_REFERER]");
	exit();
}
?>