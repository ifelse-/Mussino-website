<?php
include('settings.php');

$geoip_available = file_exists($geoip_filename) && filesize($geoip_filename);
if (!$geoip_available) {
  $fp = @fopen($geoip_filename, 'w');
  $geoip_writable = !!$fp;
  if ($fp) fclose($fp);
}

ob_start();
$included = true;
include('ajax/visitors.php');
$output = ob_get_clean();
$visitors = json_decode($output);
?>
<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-type" content="text/html; charset=utf-8"/>
  <title>Visitor tracking</title>
  <script src="http://www.google.com/jsapi?key=<?php echo $google_api_key ?>"></script>
  <script> google.load("jquery", "1.4.1"); </script>
  <script src="media/main.js"></script>
  <link rel="stylesheet" href="media/main.css"/>
</head>
<body>
<div id="container">
<?php if ($geoip_available) { ?>
  <script> google.load("maps", "2"); </script>
  <div id="map">
  </div>
  <div id="regions">
    <a href="#" onclick="return set_view(center_global);">Overview</a>
    &bull; <a href="#" onclick="return set_view(center_us);">US</a>
    &bull; <a href="#" onclick="return set_view(center_eu);">EU</a>
  </div>
<?php } else { ?>
  <div class="setup">
    <div class="download">
      <button type="button" <?php if (!$geoip_writable) echo "disabled='disabled'" ?>>Download</button>
      <div class="progress"><span></span></div>
    </div>
    In order to view your site visitors on the map, you should download the geolocation
    database file from <a href="http://www.maxmind.com/app/geolitecity">MaxMind</a>.<br/>
    You can do this manually or automatically using the &quot;Download&quot; button.<br/>
    <p class="note">Note: The file size is about 30Mb</p>
    <?php if (!$geoip_writable) { ?>
      <div class="warning">
        File <b><?php echo $geoip_filename ?></b> is not writable.<br/>
        Please update the file permissions (typically <i>0777</i> helps), or download manually.
      </div>
    <?php } ?>
  </div>
<?php } ?>

<table id="grid">
  <thead>
    <tr>
      <th>#</th>
      <th>Info</th>
      <th>IP</th>
      <th>User</th>
      <th>Page</th>
      <th>Timestamp</th>
      <th>Visit&nbsp;duration</th>
      <th>Visit&nbsp;pages</th>
    </tr>
  </thead>
  <tbody>
<?php
  function parse_time($str) {
    if (preg_match("~^\d{4}\-\d{2}\-\d{2} \d{2}:\d{2}:\d{2}~", $str, $m))
      return strtotime($m[0]) + date('Z');
  }
  foreach ($visitors as $k => $rec) {
    $loc = $rec->location;
    $cc = $loc ? strtolower($loc->country_code) : null;
    $last = $rec->visits[sizeof($rec->visits) - 1];
    $mins = (parse_time($last) - parse_time($rec->visits[0])) / 60;
    echo "<tr>", // (no ID, to initialize map markers)
      "<td class='number'>",($k + 1),".</td>",
      "<td class='info'>",
      ($loc ? " <div class='country {$loc->country_code}' title='{$loc->country_name}'".
      " style='background-position: -".((ord($cc[0]) - 96) * 16)."px -".((ord($cc[1]) - 96) * 11)."px;'></div>" :
      " <div class='country' title='(local)'></div>"),
      " <div class='agent {$rec->browser}' title='{$rec->agent}'></div>",
      "</td>",
      "<td class='ip'>{$rec->ip}</td>",
      "<td class='user'{$rec->user}></td>",
      "<td class='page'>",preg_replace("~^\S+ \S+ ~", '', $last),"</td>",
      "<td class='time'>",date('H:i:s', parse_time($last)),"<sup title='server time'>#</sup></td>",
      "<td class='duration'>",($mins ? ($mins >= 1 ? floor($mins)." minute".($mins >= 2 ? 's' : '') : "&lt; 1 minute") : ""),"</td>",
      "<td class='trace'>",sizeof($rec->visits)," <a href='ajax/raw.php?uid={$rec->hash}' target='_blank'>view</a></td>",
      "</tr>";
  }
?>
  </tbody>
</table>
<p class="note">
  <script> var reload_time = <?php echo $reload_time ?>; </script>
  The table content refreshes automatically every <?php echo $reload_time ?> seconds.
</p>
</div>
</body>
</html>
