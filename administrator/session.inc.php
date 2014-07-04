<?php
if($_SESSION['ADMIN']=="")
{
header("location:index.php");
exit();
}
?>