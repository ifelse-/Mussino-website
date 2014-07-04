<?php
chdir('..');
include('settings.php');

// temporary directory settings
$temp_dir = function_exists('sys_get_temp_dir') ? sys_get_temp_dir() : '/tmp';
$temp_sub = $temp_dir.'/'.str_replace('www.', '', $_SERVER['HTTP_HOST']).'_visitors/';
if (!file_exists($temp_sub)) exit;

// display raw content
header("Content-Type: text/plain");
@readfile($temp_sub.$_GET['uid']);
