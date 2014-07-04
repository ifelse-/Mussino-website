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
</style>
</head>
<body style="margin: 0px;">

<table width=790 height=100% bgcolor=#f0f0f0 cellpadding=0 cellspacing=0 align=left valign=top>
<tr><td align=center valign=top>

<?php include "heade.php" ?>

<!-- content row -->
<tr><td class=maintext align=left valign=top> 
<br>
<table width=95% algin=center border=1 cellpadding=0 cellspacing=0 bgcolor=cdcdcd>
<tr height=100%>
<td height=100% class=maintext align=center>
<?php
$del = $_GET['del'];
if($del == true)
{
	$time = $_GET['time'];
	$date = date("Y-m-d",mktime(0, 0, 0, date("m")-$time, date("d"), date("Y")));
	
	$qu = "delete from stats where date < '$date'";
	if(mysql_query($qu,$link))
	{
		echo "<br><br><br><br><br><br>
			<font color=green>Data Deleted Succesfully</font>
			<br><br><br><br><br><br>";
	}
}
else
{
?>
<br><br><br><br><b>
Delete stats older than</b><br><br>
<a class=atag href="del-stats.php?del=true&time=3">Three Months</a><br><br>
<a class=atag href="del-stats.php?del=true&time=6">Six Months</a><br><br>
<a class=atag href="del-stats.php?del=true&time=12">One Year</a><br><br>
<font color=red>Note: Stats deleted can not be retrived</font>
<br><br><br><br>
<?php
}
?>

</td></tr></table>
</td></tr>
<!-- content row -->

</table>
<!-- main table -->

</td></tr>
</table>

</body>
</html>

<!-- Welcome to the scripts database of HIOX INDIA      -->
<!-- This tool is developed and a copyright             -->
<!-- product of HIOX INDIA.				        -->
<!-- For more information visit http://www.hscripts.com -->

<?php
}
?>