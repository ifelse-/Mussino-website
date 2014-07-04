<?php
ob_start(); ob_clean();
session_start(); //start session
mysql_connect('mussinodbnew.db.9195406.hostedresource.com', 'mussinodbnew', 'Musicsite2011') or die(mysql_error());
mysql_query("SET NAMES UTF8");//this is needed for UTF 8 characters - multilanguage
mysql_select_db('mussinodbnew') or die(mysql_error());
?>