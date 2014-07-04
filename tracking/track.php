<?php
/**
 * Track visit information
 * @param $userinfo - visitor info (e.g. email)
 * @return true if successful
 * @example
 *   include('script_path/track.php');
 *   track_visitor();         // track guest, OR
 *   track_visitor('jsmith'); // track user (replace parameter with username or email)
 */
function track_visitor($userinfo = '')
{
  // temporary directory settings
  $temp_dir = function_exists('sys_get_temp_dir') ? sys_get_temp_dir() : '/tmp';
  preg_match("~[\w\-]+(\.[a-z]{2})?(\.[a-z]{2,4})?$~", $_SERVER['HTTP_HOST'], $m);
  $temp_sub = $temp_dir.'/'.$m[0].'_visitors/';
  if (!file_exists($temp_sub))
    @mkdir($temp_sub);
  $temp_name = $temp_sub.md5($_SERVER['REMOTE_ADDR'].'~'.$_SERVER['HTTP_USER_AGENT'].'~'.$userinfo);
  $temp_file = @fopen($temp_name, 'a');
  if (!$temp_file) return false;

  // write visit information
  if (!filesize($temp_name)) {
    fwrite($temp_file, $_SERVER['REMOTE_ADDR']."\n");
    fwrite($temp_file, $_SERVER['HTTP_USER_AGENT']."\n");
    fwrite($temp_file, $userinfo."\n");
  }
  fwrite($temp_file, gmdate("Y-m-d H:i:s")." ".$_SERVER['REQUEST_URI']."\n");
  fclose($temp_file);
}
