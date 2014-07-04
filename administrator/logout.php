<?php
require_once("../config/functions.inc.php");
session_destroy();
header("Location:index.php");
?>