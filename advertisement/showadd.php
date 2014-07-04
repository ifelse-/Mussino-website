<?php

$str = $_GET['str'];
$campaign = $_GET['campaign'];
require_once "auth/config.php";
$link = mysql_connect($hostname, $username,$password);
if($link)
{
	$dbcon = @mysql_select_db($dbname,$link);
}

$wid = 0;
$hei = 0;
$type = "";
$speed = 0;

$result = @mysql_query("select * from campaigns where name='$campaign'",$link);
if($line = @mysql_fetch_array($result, MYSQL_ASSOC))
{	
	$wid = $line['width'];
	$hei = $line['height'];
	$type = $line['tpye'];
	$speed = $line['speed'];
	if($speed == "" || $speed <= 0)
		$speed = "1000";
}

if($type == "randomad"){
/* Random Add Rotator Code */
$quer = "select * from banners where campaign like '%#*_&$campaign&_*#%' order by rand() limit 1";
//echo "$str <br> $quer<br>";
$resulta = mysql_query($quer,$link);

while($line = mysql_fetch_array($resulta, MYSQL_ASSOC))
{
	$bname = $line['name'];
	$imge = $line['image'];	
	$url = $line['url'];	
}

if($url == "")
echo "<img src=\"$imge\" width=\"$wid\" height=\"$hei\" border=0>";
else
echo "<a target=\"_blank\" href=\"$str"."had.php?name=$bname&url=$url\" style=\"border:0px;\"><img src=\"$imge\" width=\"$wid\" height=\"$hei\" border=0></a>";
/* Random Add Rotator Code */

}else if($type=="adrotator"){

/*Dynamic Image Rotator*/
$quer = "select * from banners where campaign like '%#*_&$campaign&_*#%'";
//echo "$quer";
$resulta = mysql_query($quer,$link);

$ii=0;
while($line = mysql_fetch_array($resulta, MYSQL_ASSOC))
{
	$bname[$ii] = $line['name'];
	$imge[$ii] = $line['image'];	
	$urla[$ii] = $line['url'];	
	$ii++;
}
?>

<script language="javascript">
imgAr = new Array();
linkAr = new Array();

<?php
$width = $wid;
$height = $hei;
$bcolor = "red";

$i=0;
$url=false;

for($xx=0; $xx<count($imge); $xx++){
	echo "imgAr[$xx] = \"$imge[$xx]\";";
	if($urla[$xx] != "")
	echo "linkAr[$xx] = \"$str"."had.php?name=$bname[$xx]&url=$urla[$xx]\";";
	else 
        echo "linkAr[$xx] = \"\";";

}
?>
</script>

<script language="javascript">
var k = 0;
var wid12 = <?php echo($width); ?>;
var hig12 = <?php echo($height); ?>;

if (document.images)
{
	var rImg = new Array();
	for (var i=0; i<imgAr.length; i++)
	{
		rImg[i] = new Image(wid12,hig12);
	        rImg[i].src = imgAr[i];
	}
}

var k = 0;
function rotater()
{

document["test"].src = rImg[k].src;

if(linkAr[0] != ""){
var ss = document.getElementById("sds");
ss.setAttribute("href",linkAr[k]);
}
else if(linkAr[0] == ""){
var ssss = document.getElementById("sd");
ssss.setAttribute("href",linkAr[k]);
}

if( k < (imgAr.length-1))
{
 	k= k+1;
}
else
{
	k = 0;
}

//alert(k);
rTimer = setTimeout('rotater()', <?php echo($speed); ?> );

 }
</script>

<table align=center cellpadding=0 cellspacing=0 border=0>
<tr><td>
<script language=javascript>
//for(i=0;i<imgAr.length-1;i++)

if(linkAr[0] == "")
 document.write("<img id=sd name=test width="+wid12+" height="+hig12+" src="+imgAr[0]+" border=0>");
else if(linkAr[i] != "")
 document.write("<a id=sds target=_blank href='"+linkAr[0]+"'><img name=test width="+wid12+" height="+hig12+" src="+imgAr[0]+" border=0></a>");

</script>
</td></tr>
<tr><td bgcolor=white><a style="text-decoration: none; font-size: 11px; color: white;" href=""> hscripts </a></td></tr>
</table>

<script language="javascript">
rotater();
</script>
<!-- Image Rotator Code -->

<?php
}
?>

