<?php
require_once "config/functions.inc.php";
	if($_REQUEST['rights']=='' || $_REQUEST['rights']=='0')
	{
	echo "<span style='color:#ff0000'>Please accept to legal rights</span>";
	}
	else
	{
	echo "done";
	}
?>