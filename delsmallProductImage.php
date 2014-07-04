<?php include("config/functions.inc.php");
$smallImage=$_GET['Image_Name'];
@unlink($smallImage);
if(!empty($_GET['Product_Id']))
	{
	  $sql="UPDATE product_master SET Image_Name='' where 	Product_Id='".$_GET['Product_Id']."'";
	  mysql_query($sql);
	}
echo '1';
?>

