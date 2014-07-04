<?php 
require_once "config/functions.inc.php";
require_once "session.inc.php"; 
$sql = "SELECT *, DATE_FORMAT(Lyrics_Date,'%m/%d/%Y %h:%i %p') as historyDate FROM lyrics_post_master WHERE md5(Lyrics_Post_Id) LIKE '%".$_REQUEST['id']."%' ";
$result = mysql_query($sql);
$colles_history_post = mysql_fetch_array($result);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>Print Lyrics</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="description" content="Default Description">
<meta name="keywords" content="">
<meta name="robots" content="">
<?php include "common.inc.php"; ?>
</head>

<body>
<div id="wrapper">
<?php include "header.middle.inc.php"; ?>
<div class="content-container">
<?php include "header.top.inc.php"; ?>
<?php include "print-history-middle.php"; ?>
</div>
</div>
<?php include "footer.inc.php"; ?>
</body>
</html>