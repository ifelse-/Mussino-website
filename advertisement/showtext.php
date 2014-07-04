
<?php
$str = $_GET['str'];
//$campaign = $_GET['campaign'];

require_once "auth/config.php";
$link = mysql_connect($hostname, $username,$password);
if($link)
{
	$dbcon = @mysql_select_db($dbname,$link);
}

$wid = 0;
$hei = 0;
$type = "";
$speed = 0;

$result = @mysql_query("select * from campaigns where name='$campaign'",$link);

if($line = @mysql_fetch_array($result, MYSQL_ASSOC))
{	
	$type = $line['tpye'];
	$speed = $line['speed'];
	if($speed == "" || $speed <= 0)
		$speed = "1000";
}

/* Random Add Rotator Code */
$quer = "select * from banners where campaign like '%#*_&$campaign&_*#%' order by rand() limit 1";
$resulta = mysql_query($quer,$link);
while($line = mysql_fetch_array($resulta, MYSQL_ASSOC))
{
	$bname = $line['name'];
	$imge = $line['image'];	
	$url = $line['url'];
	$txtt = trim($imge);	
}

echo "$txtt";

?>
