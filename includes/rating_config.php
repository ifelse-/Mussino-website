<?
//error_reporting(E_ALL);
$server = 'mussinodbnew.db.9195406.hostedresource.com';
$dbuser = 'mussinodbnew';
$dbpass = 'Musicsite2011';
$dbname = 'mussinodbnew';

$x = mysql_connect($server,$dbuser,$dbpass) or die(mysql_error());
mysql_select_db($dbname,$x);
?>