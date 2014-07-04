<?php
require_once "auth/config.php";

$link = @mysql_connect($hostname, $username,$password);
if($link)
{
	$dbcon = @mysql_select_db($dbname,$link);
}


$name = $_GET['name'];
$url = $_GET['url'];

$rip = $_SERVER['REMOTE_ADDR'];
$today = getdate();
//Time of the visit
$time = $today['hours'].":".$today['minutes'].":".$today['seconds'];
//Date of the Visit
$day = $today['year']."-".$today['mon']."-".$today['mday'];

$sss = "insert into stats values('$name','$day','$time','$rip')";
@mysql_query($sss,$link);

?>

<script language=javascript>
document.location.href="<?php echo($url); ?>";
</script>