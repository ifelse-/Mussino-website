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
<table width=95% algin=center border=1 cellpadding=0 cellspacing=0 bgcolor=dbdbdb>
<?php
include "stats-form.php";
?>

<tr height=100%>
<td height=100% class=maintext align=center>
<?php
$ss = $_GET['s'];
$date1 = $_GET['date1'];
$date2 = $_GET['date2'];
$name = $_GET['name'];

function addz($sd)
{
	if($sd < 9)
		$sd = "0".$sd;
	return $sd;
}

if($ss == "details")
	{
		if($date2 == "")
			$qq = "select * from stats where bname like '$name' and date like '$date1' order by date desc,time desc";
		else
			$qq = "select * from stats where bname like '$name' and date between '$date2' and '$date1' order by date desc,time desc";
	
		echo "<b><font color=black>Details of banner $name</font></b>";
		$result = mysql_query($qq,$link);
		
	$cout = 0;
	echo "<table style=\"font-size: 14px; color:000000;\" width=100%>";
     	echo "<tr bgcolor=acbef8 align=center><td> S.No </td><td> Banner Name </td> <td> Date </td> <td> Time </td> <td> IpAddress </td></tr>\n";
	while ($line = @mysql_fetch_array($result, MYSQL_ASSOC))
	{	
		$name = $line['bname'];
		$date = $line['date'];
		$time = $line['time'];
		$ip = $line['ip'];

		if($vv === true){
	  		echo "<tr align=center bgcolor=#e8eefa>\n";
		$vv = false;
		}
		else{
	   		echo "<tr align=center bgcolor=#f5f5f5>\n";
			$vv = true;
		}

		$cout = $cout+1;
      	echo "<td>$cout</td><td> $name </td> <td> $date </td> <td> $time </td> <td> $ip </td></tr>\n";
	}
	echo "</table>";
	
	}
else
{	
?>

<?php
	$dd = 0;

	echo "<font color=black>Ad Statistics on/from </black>";

	if($option != "op2")
	{
		if($when=="today"){$dd = 0;}
		else if($when=="yesterday"){$dd = -1;}
		else if($when=="ago2"){$dd = -2;}
		else if($when=="week"){
			$dfs = "two";
			$dd1 = 0;
			$dd2 = -7;
		}
		else if($when=="week"){
			$dfs = "two";
			$dd1 = 0; $dd2 = -6; $mm1 = 0; $mm2 = 0;
		}
		else if($when=="month"){
			$dfs = "two";
			$dd1 = 0; $dd2 = -(date("d")-1); $mm1 = 0; $mm2 = 0;
		}
	}
	else
	{
		$dfs = "three";
	}

	if($dfs == "two")
	{
		$date1 = date("Y-m-d",mktime(0, 0, 0, date("m")+$mm1, date("d")+$dd1, date("Y")));
		$date2 = date("Y-m-d",mktime(0, 0, 0, date("m")+$mm2, date("d")+$dd2, date("Y")));
		$syy = "select bname,count(*) as ss from stats where date between '$date2' and '$date1' group by bname order by ss desc";
			echo "<font color=black><b>$date2 to $date1</b></font>";
	}
	else if($dfs == "three")
	{
		if(checkdate($m1,$d1,$y1) == true && checkdate($m2,$d2,$y2) ==  true)
		{
			$t1 = mktime(0, 0, 0, $m1, $d1, $y1);
			$t2 = mktime(0, 0, 0, $m2, $d2, $y2);
			if($t1 > $t2)
			{
				echo "<br><br><font color=red>Invalid date range</font><br><br>";
			}
			else
			{
				$date2 = date("Y-m-d",mktime(0, 0, 0, $m1, $d1, $y1));	
				$date1 = date("Y-m-d",mktime(0, 0, 0, $m2, $d2, $y2));	
				$syy = "select bname,count(*) as ss from stats where date between '$date2' and '$date1' group by bname order by ss desc";
				echo "<font color=black><b>$date2 to $date1</b></font>";
			}
		}
		else
		{
			echo "<br><br><font color=red>Invalid date [you might have selected date as 31 for month 2]</font><br><br>";
		}
	}
	else
	{
		$date1 = date("Y-m-d",mktime(0, 0, 0, date("m"), date("d")+$dd, date("Y")));
		$syy = "select bname,count(*) as ss from stats where date like '$date1' group by bname order by ss desc";
		echo "$date1";
	}

	$result = @mysql_query($syy,$link);
		
	$cout = 0;
	echo "<table style=\"font-size: 14px; color:000000;\" width=100%>";
     	echo "<tr bgcolor=acbef8 align=center><td> S.No </td><td> Banner Name </td> <td> Hits </td></tr>\n";
	while ($line = @mysql_fetch_array($result, MYSQL_ASSOC))
	{	
		$name = $line['bname'];
		$cou = $line['ss'];

		if($vv === true){
	  		echo "<tr align=center bgcolor=#f5f5f5>\n";
		$vv = false;
		}
		else{
	   		echo "<tr align=center bgcolor=#e8eefa>\n";
			$vv = true;
		}

		$cout = $cout+1;
      	echo "<td>$cout</td><td> $name </td> <td> <a href=\"stats.php?s=details&name=$name&date1=$date1&
		date2=$date2\">$cou</a> </td></tr>\n";
	}
		
?>
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