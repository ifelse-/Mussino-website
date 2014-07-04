<?php
chdir('..');
include('settings.php');

// temporary directory settings
$temp_dir = function_exists('sys_get_temp_dir') ? sys_get_temp_dir() : '/tmp';
$temp_name = $temp_dir.'/'.$_SERVER['HTTP_HOST'].'_geoip.gz';
if (!file_exists($temp_name)) exit;

// return total and downloaded size
session_start();
$size_total = @$_SESSION['geoip_bytes'];
$size_downloaded = filesize($temp_name);
echo $size_downloaded,' ',$size_total;
