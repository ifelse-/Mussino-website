<?php
if (!isset($included)) {
  chdir('..');
  include('settings.php');
}

// temporary directory settings
$temp_dir = function_exists('sys_get_temp_dir') ? sys_get_temp_dir() : '/tmp';
preg_match("~[\w\-]+(\.[a-z]{2})?(\.[a-z]{2,4})?$~", $_SERVER['HTTP_HOST'], $m);
$temp_sub = $temp_dir.'/'.$m[0].'_visitors/';

// detect country by IP
include('geo/geoipcity.inc');
session_start();
function get_location($ip) {
  if (isset($_SESSION[$ip]))
    return $_SESSION[$ip];
  global $geoip_filename;
  if (!@filesize($geoip_filename)) return null;
  $gi = geoip_open($geoip_filename, GEOIP_STANDARD);
  $res = geoip_record_by_addr($gi, $ip);
  geoip_close($gi);
  $_SESSION[$ip] = $res;
  return $res;
}

// detect browser by user-agent string
function get_browser_family($ua) {
  if (preg_match("~(^|\W)(chrome|safari|firefox|opera|msie)(/|\s)~i", $ua, $m))
    return strtolower($m[2]);
  return 'unknown';
}

// enumerate files in the directory
$res = array();
if (file_exists($temp_sub)) {
  $dh = opendir($temp_sub);
  while (($file = readdir($dh)) !== false) {
    $name = $temp_sub.$file;
    if (!is_file($name)) continue;
    $mtime = filemtime($name);
    if (time() - $mtime < $visit_expire) {
      $info = array_map('trim', file($name));
      $geo = get_location($info[0]);
      $res[$mtime.$file] = array(
        'hash' => $file,
        'ip' => $info[0],
        'location' => get_location($info[0]),
        'agent' => $info[1],
        'browser' => get_browser_family($info[1]),
        'user' => $info[2],
        'visits' => array_slice($info, 3),
      );
    } else
      @unlink($name);
  }
  closedir($dh);
}

// output sorted result
ksort($res);
if (!isset($included))
  header("Content-Type: application/json");
echo json_encode(array_values($res));
