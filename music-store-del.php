<?php
include("config/functions.inc.php");
include("session.inc.php");

if(count($_REQUEST['ids'])>0)
{
    $ids = $_REQUEST['ids'];

    $ids=implode(",",$ids);

	if($_REQUEST['Submit']=='Delete')  
	{
	
	$sql_pro = "SELECT * FROM product_master WHERE Product_Id Product_Id in (".$ids.") ";
    $result_pro = mysql_query($sql_pro);
    $colles_pro = mysql_fetch_array($result_pro);
	if($colles_pro['Image_Name']!='')
	{
	 unlink("products/product_image/".$colles_pro['Image_Name']);
	}
	if($colles_pro['Short_FIle_Name']!='')
	{
	 unlink("products/small_video/".$colles_pro['Short_FIle_Name']);
	}
	if($colles_pro['Long_FIle_Name']!='')
	{
	 unlink("products/large_video/".$colles_pro['Long_FIle_Name']);
	}
	 
	$sql1 = "DELETE FROM product_master WHERE Product_Id in (".$ids.") ";  
	 executeQuery($sql1);
	// $sql2 = "DELETE FROM product_category_master WHERE Product_Id in (".$ids.") ";  
	// executeQuery($sql2);
	
	
	 $_SESSION['sess_messs']="Selected records deleted successfully";
	
	}

	  
  header("location: $_SERVER[HTTP_REFERER]");
  exit();
}
else
{
	$_SESSION['sess_messs']="Please check the check boxes! ";
	header("location: $_SERVER[HTTP_REFERER]");
	exit();
}
?>