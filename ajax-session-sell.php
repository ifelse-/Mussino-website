<?php
require_once "config/functions.inc.php";

	if($_REQUEST['Price']=='' || $_REQUEST['Price']=='0.00' || $_REQUEST['Percent']=='0')
	{
	echo "<span style='color:#ff0000'>Please Enter Price</span>";
	}
    elseif($_REQUEST['Percent']=='' || $_REQUEST['Percent']=='0.00' || $_REQUEST['Percent']=='0')
	{
	echo "<span style='color:#ff0000'>Please Enter Percentage</span>";	
	}
	else
	{
	
		$total = ($_REQUEST['Price']*$_REQUEST['Percent'])/100;
		
		$musicianid = Get_Single_Field("product_master","Member_Account_Id","Product_Id","$_REQUEST[lpi]");
		
		$query = "SELECT * FROM sell_session WHERE Artist_Id ='".$_SESSION['SESS_ID']."' AND Lyrics_Post_Id='".$_REQUEST['lpi']."'";
		$result = executeQuery($query);
		if(mysql_num_rows($result )==0)
		{
		$sql= " INSERT INTO sell_session SET
		        Price = '".trim($_REQUEST['Price'])."',
				Percentage = '".trim($_REQUEST['Percent'])."',
				Lyrics_Post_Id = '".trim($_REQUEST['lpi'])."',
				Songwriter_Total = '".trim($total)."',
				Artist_Id ='".$_SESSION['SESS_ID']."',
				Musician_Id ='".$musicianid."',
				Date = now(),
				Status = '0'";
		$inserted = executeQuery($sql);
				
		echo"<span style='color:#000'>Record added successfully</span>";
		}
		else
		{
		echo "<span style='color:#ff0000'>Record already added</span>";
		}
			
		
		
	}

?>