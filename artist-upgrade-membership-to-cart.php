<?php 
include("config/functions.inc.php");

		   if($_REQUEST['id']!='')
		   {
		   $sql = "SELECT * FROM temp_order WHERE Sess_Id='".$sess_id."' AND Mode=3";
		   $result = mysql_query($sql);
		   if(mysql_num_rows($result)==0)
		   {
	       $sql = "INSERT INTO temp_order SET
			       Sess_Id='".$sess_id."',
			       Id='".$_REQUEST['id']."',
			       Mode='3'";
			mysql_query($sql);
		   }
		   else
		   {
		   $sql = "UPDATE temp_order SET Id='".$_REQUEST['id']."'  WHERE Sess_Id='".$sess_id."' AND Mode=3";
			mysql_query($sql);
		   }
		header("location:my-cart.php");
    	exit();
		}
		else
		{
        header("location:".$_SERVER['HTTP_REFERER']);
        exit();
		}
?>