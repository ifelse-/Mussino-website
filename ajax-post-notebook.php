<?php
require_once "config/functions.inc.php";
if($_REQUEST['Lyrics']=='')
{
echo "<span style='color:#990000;'>PLEASE ENTER THE LYRICS</span>";
}
else
{
$sql_insert = " INSERT INTO notebook_master SET
				Lyrics = '".addslashes($_REQUEST['Lyrics'])."',
				Member_Account_Id = '".$_SESSION['SESS_ID']."',
				Lyrics_Date = now(),
				Status = '1'";
executeQuery($sql_insert);
echo "<span style='color:#006600;'>POST LYRICS ADDED</span>";
}
?>