<?php
chdir('..');
include('settings.php');

$url = 'http://geolite.maxmind.com/download/geoip/database/GeoLiteCity.dat.gz';
set_time_limit(600);
if (@filesize($geoip_filename)) exit;

// temporary directory settings
$temp_dir = function_exists('sys_get_temp_dir') ? sys_get_temp_dir() : '/tmp';
$temp_name = $temp_dir.'/'.$_SERVER['HTTP_HOST'].'_geoip.gz';
$temp_file = @fopen($temp_name, 'wb');
if (!$temp_file) die('Error creating temporary file');

// download using sockets (write to disk without loading into memory)
$url_info = parse_url($url);
$fp = @fsockopen($url_info['host'], ($_ = $url_info['port']) ? $_ : 80);
if (!$fp) die('Error connecting to remove host');
fwrite($fp, "GET {$url_info['path']} HTTP/1.1\r\n".
  "Host: {$url_info['host']}\r\n".
  "\r\n");

// fetch response headers
$headers = array();
while ($line = fgets($fp)) {
  if (!trim($line)) break;
  if ($p = strpos($line, ':'))
    $headers[strtolower(substr($line, 0, $p))] = trim(substr($line, $p + 1));
}

// save total file size
session_start();
$size = $headers['content-length'];
$_SESSION['geoip_bytes'] = $size;
session_commit();

// download binary content
while (!feof($fp) && $size) {
  $chunk = fread($fp, min($size, 16384));
  fwrite($temp_file, $chunk);
}
fclose($fp);
fclose($temp_file);

// unpack archive
system("gzip -q -d {$temp_name}");
$temp_name = str_replace('.gz', '', $temp_name);
if (!file_exists($temp_name)) die('Error unpacking the archive');

// move to script directory
copy($temp_name, $geoip_filename);
unlink($temp_name);
echo "OK";
