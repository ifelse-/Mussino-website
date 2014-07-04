<?php
require_once "config/functions.inc.php";

 
  	
	if($_REQUEST['OrderId']=='')
	{
	echo "<span style='color:#ff0000'>Please Enter Order Id</span>";
	}
	else if($_REQUEST['OrderAmount']=='')
	{
	echo "<span style='color:#ff0000'>Please Enter Order Amount</span>";
	}
	else
	{
	 
	 $resultGetCommission = mysql_query("SELECT Commision FROM addagent WHERE Id='".$_REQUEST['AgentId']."'");
     $row = mysql_fetch_array($resultGetCommission);
	 
	 $commision_discount = $row['Commision']*$_REQUEST['OrderAmount']/100;
	 
	 $sql = "INSERT INTO useragents SET
	        Date = now(),
			OrderId = '".$_REQUEST['OrderId']."',
			OrderAmount = '".$_REQUEST['OrderAmount']."',
			AgentId = '".$_REQUEST['AgentId']."',
			Commision = '".$commision_discount."'";
	mysql_query($sql);
	echo "<span style='color:#00FF00'>Order Placed successfully</span>";
		
		
	}

?>