<?php
include("config/functions.inc.php");


	$sql = "SELECT * FROM temp_ad_order WHERE Sess_Id ='".$sess_id."'";
    $result = mysql_query($sql);
	$colles = mysql_fetch_array($result);
	
	$total = Get_Single_Field("advertise_plan_master","Ad_Plan_Amount","Advertise_Plan_Id","$colles[Ad_Plan]");
	
	echo"<html><body><form name='formtt' method='post' action='https://www.paypal.com/cgi-bin/webscr'>";
	echo "<input type=hidden name='redir_url' value='" . $_SERVER["SCRIPT_NAME"] . "'>";
	echo "<input type=hidden name='redir_query_string' value='" . $_SERVER["QUERY_STRING"] . "'>";
	echo"<input type='hidden' name='cmd' value='_xclick'>";
	echo"<input type='hidden' name='business' value='".Get_Single_Field("general_setting_master","PayPall_Payment_Id","Gen_Set_Id","1")."'>";
	echo"<input type='hidden' name='item_name' value='Advertise Online Payment'>";
	echo"<input type='hidden' name='no_shipping' value='1'>";
	echo"<input type='hidden' name='upload' value='1' >";
	echo"<input type='hidden' name='amount' value='".$total."'/>";
	echo"<input type='hidden' name='lc' value='US' />";
	echo"<input type='hidden' name='rm' value='2'>";
	echo"<input type='hidden' name='currency_code' value='USD'>";
	echo"<input TYPE='hidden' name='address_override' value='1'>";
	echo"<input type='hidden' name='return' value='http://localhost/music_site/advertise-invoice.php'>";
	echo "</form>";
	echo "<script language='JavaScript'>";
	echo "document.formtt.submit();";
	echo "</script></body></html>";
    
?>