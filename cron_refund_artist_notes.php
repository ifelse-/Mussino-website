<?php
require_once("config/functions.inc.php");
$sql = "SELECT m.Bank_Id, m.Product_Id, m.From_Member_Account_Id 
        FROM my_bank m INNER JOIN product_master p ON(p.Product_Id=m.Product_Id) 
		WHERE p.Status=1 AND p.Type!='3' AND m.Account_Type='Artist' AND  now() >= p.Session_End_Date";
$result = mysql_query($sql) or die('<br>'.$sql.'<br>'.mysql_error());

if(mysql_num_rows($result)=='1')
{
$colles = mysql_fetch_array($result);
//echo $colles['Bank_Id'];
//echo $colles['Product_Id'];
//echo $colles['From_Member_Account_Id'];
mysql_query("DELETE FROM lyrics_post_master WHERE Member_Account_Id ='".$colles['From_Member_Account_Id']."' AND Product_Id ='".$colles['Product_Id']."' AND Type='Artist' ");
mysql_query("DELETE FROM lyrics_post_audio_master WHERE Member_Account_Id ='".$colles['From_Member_Account_Id']."' AND Product_Id ='".$colles['Product_Id']."' ");
mysql_query("DELETE FROM my_bank WHERE Bank_Id  ='".$colles['Bank_Id']."' AND Account_Type ='Artist' ");
}
					
?>