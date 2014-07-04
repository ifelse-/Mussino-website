<?php
include "authheader.php";

if($block != true)
{
?>

<!-- Welcome to the scripts database of HIOX INDIA      -->
<!-- This tool is developed and a copyright             -->
<!-- product of HIOX INDIA.				        -->
<!-- For more information visit http://www.hscripts.com -->

<html>
<head>
<style>
.ta{background-color: ffff44;}
.rad{color:red; font-weight:bold; background-color: ffff44;}
.head{font-size: 17px; color: white; font-family: verdana, arial, san-serif;}
.links{font-size: 13px; color: white; font-family: verdana, arial, san-serif; text-decoration:none;}
.maintext{font-size: 13px; color: #fefefe; font-family: verdana, arial, san-serif; padding:20px;}
.ntext{font-size: 13px; color: #000000; font-family: verdana, arial, san-serif; padding:20px;}

</style>

<script language=javascript>
      function set()
      {
      	 document.adtyp.seloptt.value=document.adtyp.adty.selectedIndex;
         document.adtyp.submit();
      }
</script> 

</head>
<body style="margin: 0px;">

<table width=790 height=100% bgcolor=#f0f0f0 cellpadding=0 cellspacing=0 align=left>
<tr><td align=center>

<?php include "heade.php" ?>

<!-- content row -->
<tr><td class=maintext align=left> 
<br>
<table width=95% algin=center border=1 cellpadding=0 cellspacing=0 bgcolor=#dbdbdb>
<tr height=100%>
<td height=100% class=maintext align=center>

<?php
$adty = $_POST['adty'];
$sele = $_POST['seloptt'];

if(isset($adty)==0){
$adty = "all";
}

$asd = $_POST['addd'];
if($asd == "")
	$asd = $_GET['addd'];

//$name = $_GET['name'];

if($asd == "add")
{
	$height = $_POST['height'];
	$width = $_POST['width'];
	$name = $_POST['name'];
	$type = $_POST['typea'];
	$speed = $_POST['speed'];
	$radio = $_POST['adtype'];
	if($speed == "")
	$speed = 1000;

//Campaign properties

	if($radio=="TextAd" && $name!="" && $radio!=""){
	$result1 = @mysql_query("insert into campaigns values('$name','$width','$height','randomad','$speed','$radio')",$link);
                if($result1)
                        echo "<font color=green><b>New Campaign Successfully Created - Now you can add banners to this campaign</b></font><br><br>";

                else
                        echo "<font color=red><b>Unable to create the campaign.</b></font><br><br>";
        }
	else if($radio=="banner" && $height != "" && $width !="" && $name!="")
	{
                $result1 = @mysql_query("insert into campaigns values('$name','$width','$height','$type','$speed','$radio')",$link);
                if($result1)
                        echo "<font color=green><b>New Campaign Successfully Created - Now you can add banners to this campai
gn</b></font><br><br>";
                else
                        echo "<font color=red><b>Unable to create the campaign.</b></font><br><br>";
        }
	else if(intval($height) == 0 || intval($width)==0)
	{
		echo "<font color=red>Invalid argumnets passed. Please use proper integer values</font><br><br>";
	}
	else
	{
		echo "<font color=red>Empty Values Not allowed</font><br><br>";
	}
}
/* End of Campaign properties */

else{
?>
<table width=100% align=center class=maintext>
<tr>
<form name=adtyp action=proper.php  method=post>
<td width=30% align=right><font color=black><b>Select the Ad Type:&nbsp;</font></b></td>
<td align-left><select name=adty background=#efefef onchange=set()>
<option value=all>All Campaigns</option>
<option value=banner>BannerAd</option>
<option value=TextAd>TextAd</option>
<script language=javascript>
document.adtyp.adty.selectedIndex = <?php if($sele)
																						echo($sele);
																					else
																						echo("0");
 ?> </script>
</select>
<input name=selopt type=hidden value=adtype>
<input name=seloptt type=hidden value=0>
</td></tr></form>
</table>

<?php
	if($adty=='all'){
		$result = mysql_query("select name,adtype from campaigns",$link);
	}
	else{
		$result = mysql_query("select name,adtype from campaigns where adtype='$adty'",$link);
	}
	$count = mysql_num_rows($result);
	if($count <= 0)
		echo "<br><font color=red>NONE</font>";

	$aaa = true;
	echo "<table border=1 width=100% style=\"font-size: 14px; color:000000; border:1px solid #e6e6fa;\" align=center><br>
		<tr style=\"font-size: 13px;font-weight: bolder; color: 000000;\" align=left><font color=black>Currently Enabled Campaigns:</font></tr>";
	while ($line = @mysql_fetch_array($result, MYSQL_ASSOC))
	{	
		if($aaa == true){
			$col = "#f1f5f6";
			$aaa = false;}
		else{
			$col = "#f8f8ff";
			$aaa = true;}

		$name = $line['name'];
		$rad = $line['adtype'];
		echo "<tr align=center class=ntext bgcolor=$col><td><b>$name</b> -</td>"; 
		if($rad=="banner"){
			echo"<td><a class=atag href=\"cproper.php?name=$name&adtype=$rad&addd=prop\">properties</a></td>
			<td><a class=atag href=\"cproper.php?name=$name&adtype=$rad&addd=addb\">Include Banner</a></td>
			<td><a class=atag href=\"cproper.php?name=$name&adtype=$rad&addd=delb\">Exclude Banner</a></td>
			<td><a class=atag href=\"cproper.php?name=$name&adtype=$rad&addd=delc\">Delete Campaign</a></td>
			<td><a class=atag href=\"cproper.php?name=$name&adtype=$rad&addd=addcode\">Code</a></td></tr>";
		}
		else if($rad=="TextAd"){
			echo"<td><a class=atag href=\"tproper.php?name=$name&adtype=$rad&addd=prop\">properties</a></td>
                        <td><a class=atag href=\"tproper.php?name=$name&adtype=$rad&addd=addb\">Include TextAd</a></td>
                        <td><a class=atag href=\"tproper.php?name=$name&adtype=$rad&addd=delb\">Exclude TextAd</a></td>
                        <td><a class=atag href=\"tproper.php?name=$name&adtype=$rad&addd=delc\">Delete Campaign</a></td>
                        <td><a class=atag href=\"tproper.php?name=$name&adtype=$rad&addd=addcode\">Code</a></td></tr>";
                }

		
	}
	echo "</table>";

?>
<br>
<br>
<script language=javascript>
function des(xx)
{
	if(xx == "randomad"){
		document.addf.speed.value = "";
		document.addf.speed.disabled = true;
	}else{
		document.addf.speed.disabled = false;
	}
}

function selrandom(yy){
	if(yy == "TextAd"){
		document.addf.typea.selectedIndex = 0;
		document.addf.typea.disabled = true;
		document.addf.height.disabled = true;
		document.addf.width.disabled = true;
	}else if(yy == "banner"){
		document.addf.typea.disabled = false;
		document.addf.height.disabled = false;
		document.addf.width.disabled = false;
	}
}
</script>

<form name=addf action="<?php echo $PHP_SELF;?>" method=POST>
<input name=addd type=hidden value=add>
<table bgcolor=f5f5f5 style="color:000000; font-size:12px; font-face:tahoma; " cellpadding=2 cellspacing=0>
<tr width=100% align=center bgcolor=#e8eefa><td colspan=2 style='color:660000; font-size:14px;' >Add new Campaign: </td></tr>
  <tr width=100% bgcolor="#cccccc">
    <td><input name="adtype" type="radio" value="banner" onclick=selrandom(this.value)>Banner Ad.</td>
    <td><input name="adtype" type="radio" value="TextAd" onclick=selrandom(this.value)>Text Ad.</td>
  </tr><br>
<tr><td>Name</td><td><input name=name type=text size=10></td></tr>
<tr><td>Banner Height [e.g: 200]</td><td><input name=height type=text size=10></td></tr>
<tr><td>Banner Width [e.g: 200]</td><td><input name=width type=text size=10></td></tr>
<tr><td>Banner Type</td><td><select name=typea onchange=des(this.value)>
<option value="randomad" selected >Random Ad</option>
<option value="adrotator">Ad Rotator</option>
</select></td></tr>
<tr><td>Speed (in milliseconds)</td><td><input disabled name=speed type=text size=5></td></tr>
<tr><td></td><td><input type=submit value=Add></td></tr>
</table>
</form>

<?php
}
?>

</td>
</tr>
</table>

</td></tr>
<!-- content row -->

</table>
<!-- main table -->

</td></tr>

<tr><td width=100% align=right>
a product by &copy; <a href="http://www.hscripts.com" 
style="font-size: 14px; color: blue; text-decoration:none;">hscripts.com</a> 
&nbsp; &nbsp; &nbsp; &nbsp;
</td></tr></table>

</body>
</html>

<!-- Welcome to the scripts database of HIOX INDIA      -->
<!-- This tool is developed and a copyright             -->
<!-- product of HIOX INDIA.				        -->
<!-- For more information visit http://www.hscripts.com -->

<?php
}
?>
