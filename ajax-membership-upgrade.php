<?php
include("config/functions.inc.php");
if($_REQUEST['Amount']=='')
{
$_SESSION['up_amount'] ='';
echo "<span style='color:#757575'>Please Enter Amount</span>";
}
else
{
$_SESSION['up_amount'] = $_REQUEST['Amount'];
echo 'Done';
}
?>
