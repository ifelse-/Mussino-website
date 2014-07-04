<?php
require_once "config/functions.inc.php";
$sql = "SELECT * FROM product_master WHERE Product_Id='".$_REQUEST['id']."'";
$result = mysql_query($sql);
$colles = mysql_fetch_array($result);
?>
<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0" width="165" height="38" id="niftyPlayer1" align="">
<param name=movie value="niftyplayer.swf?file=http://mussino.com/products/small_video/<?=$colles['Short_FIle_Name']?>&as=1">
<param name=quality value=high>
<param name=bgcolor value=#FFFFFF>
<embed src="niftyplayer.swf?file=http://mussino.com/products/small_video/<?=$colles['Short_FIle_Name']?>&as=1" quality=high bgcolor=#FFFFFF width="165" height="38" name="niftyPlayer1" align="" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer">
</embed>
</object>
