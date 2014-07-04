<?php include("../config/functions.inc.php");

$smallImage=$_GET['imageName'];

@unlink($smallImage);
if(!empty($_GET['productID']))
	{
	  $sql="UPDATE product_master SET Image_Name='' where 	Product_Id='".$_GET['productID']."'";
	  mysql_query($sql);
	}
echo '1';
?>
