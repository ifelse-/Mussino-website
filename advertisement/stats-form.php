<tr height=100>
<td height=100 class=maintext1 align=center>
<table align=center bgcolor='#e8eefa' cellpadding=0 cellspacing=1 style="font-size: 14px; margin:5px">
<tr><td align=left>
<script language=javascript>
function addd(sd)
{
  if(sd == 1)
	{
		document.xc.d1.disabled = true;
		document.xc.d2.disabled = true;
		document.xc.m1.disabled = true;
		document.xc.m2.disabled = true;
		document.xc.y1.disabled = true;
		document.xc.y2.disabled = true;
		document.xc.when.disabled = false;
		document.xc.opt.value = "op1";
	}
   else
	{
		document.xc.d1.disabled = false;
		document.xc.d2.disabled = false;
		document.xc.m1.disabled = false;
		document.xc.m2.disabled = false;
		document.xc.y1.disabled = false;
		document.xc.y2.disabled = false;
		document.xc.when.disabled = true;
		document.xc.opt.value = "op2";
	}
}
</script>

<?php
 $option = $_POST['opt'];
 $when = $_POST['when'];
 $d1 = $_POST['d1'];
 $m1 = $_POST['m1'];
 $y1 = $_POST['y1'];
 $d2 = $_POST['d2'];
 $m2 = $_POST['m2'];
 $y2 = $_POST['y2'];
 if($option == "")
	$option = "op1";
?>

<form name=xc action="stats.php" method=POST>
<?php
if($option != "op2")
{
	echo "<input type=radio name=myradio value=1 checked onchange=addd('1')>";
	echo "<select name=when>";
}
else
{
	echo "<input type=radio name=myradio value=1 onchange=addd('1')>";
	echo "<select name=when disabled>";
}

if($when == "today")
	echo "<option value=today selected>today</option>";
else
	echo "<option value=today>today</option>";
if($when == "yesterday")
	echo "<option value=yesterday selected>yesterday</option>";
else
	echo "<option value=yesterday>yesterday</option>";
if($when == "ago2")
	echo "<option value=ago2 selected>2 days ago</option>";
else
	echo "<option value=ago2>2 days ago</option>";
if($when == "week")
	echo "<option value=week selected>this week</option>";
else
	echo "<option value=week>this week</option>";
if($when == "month")
	echo "<option value=month selected>this month</option>";
else
	echo "<option value=month>this month</option>";
?>
</select><br>


<!-- option two starts here -->
<?php
if($option == "op2")
{
	echo "<input type=radio name=myradio value=2 checked onchange=addd('2')>";
	echo "<select name=m1>";
}
else
{
	echo "<input type=radio name=myradio value=2 onchange=addd('2')>";
	echo "<select name=m1 disabled>";
}

for($j=1; $j<13; $j++)
{
	if($m1 == $j)
		echo "<option value=$j selected>$j</option>";
	else
		echo "<option value=$j>$j</option>";
}
?>
</select>

<?php
if($option == "op2")
	echo "<select name=d1>";
else
	echo "<select name=d1 disabled>";

for($j=1; $j<32; $j++)
{
	if($d1 == $j)
		echo "<option value=$j selected>$j</option>";
	else
		echo "<option value=$j>$j</option>";
}
?>
</select>

<?php
if($option == "op2")
	echo "<select name=y1>";
else
	echo "<select name=y1 disabled>";

$year = date("Y");
echo "<option value=2005>2005</option>";
for($j=2006; $j<=$year; $j++)
{
	if($y1 == $j)
		echo "<option value=$j selected>$j</option>";
	else
		echo "<option value=$j>$j</option>";
}
?>
</select>

to

<?php
if($option == "op2")
	echo "<select name=m2>";
else
	echo "<select name=m2 disabled>";

for($j=1; $j<13; $j++)
{
	if($m2 == $j)
		echo "<option value=$j selected>$j</option>";
	else
		echo "<option value=$j>$j</option>";
}
?>
</select>

<?php
if($option == "op2")
	echo "<select name=d2>";
else
	echo "<select name=d2 disabled>";

for($j=1; $j<32; $j++)
{
	if($d2 == $j)
		echo "<option value=$j selected>$j</option>";
	else
		echo "<option value=$j>$j</option>";
}
?>
</select>

<?php
if($option == "op2")
	echo "<select name=y2>";
else
	echo "<select name=y2 disabled>";

$year = date("Y");
echo "<option value=2005>2005</option>";
for($j=2006; $j<=$year; $j++)
{
	if($y2 == $j)
		echo "<option value=$j selected>$j</option>";
	else
		echo "<option value=$j>$j</option>";
}

echo "</select><br>";
echo "<input type=hidden name=opt value=$option>";
?>
<input type=submit value="view stats">
</form>

</td></tr></table>

<table width=100% style="font-size: 14px;" align=center><tr><td align=right>
<a href="del-stats.php" style="text-decoration: none;">delete old stat</a>
</td></tr></table>

</td></tr>
