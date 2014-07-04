<?php
require_once "config/functions.inc.php";
require_once "session.inc.php"; 
$name = 'Image_'.$_SESSION['SESS_ID'];
$createname = $name.".jpg";
$newname="products/user_image/".$name.".jpg";
$file = file_put_contents( $newname, file_get_contents('php://input') );
if (!$file) {
	print "ERROR: Failed to write data to $filename, check permissions\n";
	exit();
}
else
{
    $sql = "UPDATE member_account_master SET Photo = '".$createname."' WHERE Member_Account_Id ='".$_SESSION['SESS_ID']."'";
    $result = mysql_query($sql);
    $value = mysql_insert_id();
    $_SESSION["myvalue"]=$value;
}
$url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']) . '/' . $newname;
print "$url\n";
?>
