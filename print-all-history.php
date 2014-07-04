<?php 
require_once "config/functions.inc.php";
require_once "session.inc.php"; 
$pageName = basename($_SERVER['PHP_SELF']);
//$start=0;
//if(isset($_GET['start'])) $start=$_GET['start'];
//$pagesize=20;


if($_GET['order_by']=='') { $order_by="Lyrics_Post_Id"; } else { $order_by=$_REQUEST['order_by'];}
if($_GET['order_by2']=='') { $order_by2="DESC"; } else { $order_by2=$_REQUEST['order_by2'];}
$column="SELECT *,  DATE_FORMAT(Lyrics_Date,'%m/%d/%Y %h:%i %p') as historyDate ";
$sql=" FROM lyrics_post_master  WHERE  Member_Account_Id='".$_SESSION['SESS_ID']."' ";

$sql1="SELECT count(*) as total ".$sql;
$sql=$column.$sql;
$sql.=" order by $order_by $order_by2 ";
//$sql.=" limit $start, $pagesize";
# echo $sql;
$colles_history_result=executequery($sql);
$reccnt=getSingleResult($sql1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>Print All</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="description" content="Default Description">
<meta name="keywords" content="">
<meta name="robots" content="">
<?php include "common.inc.php"; ?>
</head>

<body>
<div id="wrapper">
<script type="text/javascript" src="<?=SITE_WS_PATH?>/wz_tooltip.js"></script>
<?php include "header.middle.inc.php"; ?>
<div class="content-container">
<?php include "header.top.inc.php"; ?>
<?php include "print-all-history-middle.php"; ?>
</div>
</div>
<?php include "footer.inc.php"; ?>
</body>
</html>