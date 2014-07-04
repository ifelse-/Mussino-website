<?php
include("../config/functions.inc.php");
include("session.inc.php");

if(count($_POST['ids'])>0)
{
    $ids = $_POST['ids'];

    $ids=implode(",",$ids);

	if($_POST['Submit']=='Delete')  
	{
			  
		  
		  $sql="delete from sound_type_master where Sound_Type_Id='".$line['Category_Id']."'";
		  executeQuery($sql);
		  $_SESSION['sess_mess']="Selected records deleted successfully";
		 
	}

	if($_POST['Submit']=='Active') 
	{
	  $sql = "UPDATE sound_type_master  SET Status='1' WHERE Sound_Type_Id in (".$ids.")";
	  executeQuery($sql);
	  $_SESSION['sess_mess']="Selected records activated successfully";
	}

   if($_POST['Submit']=='Inactive') 
   {
    $sql = "UPDATE sound_type_master SET Status='0' WHERE Sound_Type_Id in (".$ids.")";
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