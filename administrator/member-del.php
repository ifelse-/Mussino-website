<?php
include("../config/functions.inc.php");
include("session.inc.php");

if(count($_POST['ids'])>0)
{
    $ids = $_POST['ids'];

    $ids=implode(",",$ids);

	if($_POST['Submit']=='Delete')  
	{
	 $sql ="SELECT * FROM product_master WHERE Member_Account_Id in (".$ids.")";
	 $result = executeQuery($sql);
	 if(mysql_num_rows($result)>0)
	 {
	 while($colles = mysql_fetch_array($result))
	 {
	 $sqlPC = "DELETE FROM product_category_master WHERE Product_Id ='".$colles['Product_Id']."'";  
	 executeQuery($sqlPC);
	 }
	 }
	 
	 $sql1 = "DELETE FROM product_master WHERE Member_Account_Id in (".$ids.") ";  
	 executeQuery($sql1);
	 $sql2 = "DELETE FROM package_history_master WHERE Member_Account_Id in (".$ids.") ";  
	 executeQuery($sql2);
	 $sql3 = "DELETE FROM member_account_master WHERE Member_Account_Id in (".$ids.") ";  
	 executeQuery($sql3);
	 $_SESSION['sess_mess']="Selected records deleted successfully";
	
	}

	if($_POST['Submit']=='Active') 
	{
	  $sql = "UPDATE member_account_master  SET Status='1' WHERE Member_Account_Id in (".$ids.")";
	  executeQuery($sql);
	  $_SESSION['sess_mess']="Selected records activated successfully";
	}

   if($_POST['Submit']=='Inactive') 
   {
    $sql = "UPDATE member_account_master SET Status='0' WHERE Member_Account_Id in (".$ids.")";
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