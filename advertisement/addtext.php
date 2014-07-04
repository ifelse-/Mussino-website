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
.maintext{font-size: 13px; color: #fefefe; font-family: verdana, arial, san-serif; padding:10px;}
.maintext1{font-size: 13px; color: #fefefe; font-family: verdana, arial, san-serif;}

</style>
</head>
<body style="margin: 0px;">

<table width=790 height=100% bgcolor=#f0f0f0 cellpadding=0 cellspacing=0 align=left>
<tr><td align=center>

<?php include "heade.php" ?>

<!-- content row -->
<tr><td class=maintext align=left> 
<br>
<table width=95% algin=center style="border:1px solid #e6e6fa;" cellpadding=0 cellspacing=0 bgcolor=#dbdbdb>
<tr height=100%>
<td class=maintext align=center>

<?php

$asd = $_POST['addd'];

if($asd == "addd")
{
$tname = $_POST['name'];
$txtad = $_POST['text'];
$linkur = $_POST['linksrc'];

	if($txtad == "")
	{
		echo "<font color=red>Empty Values Not allowed</font><br><br>";
	}
	else
	{
		$result1 = mysql_query("insert into banners values('$tname','$txtad','$linkur','TextAd','')",$link);
		if($result1)
			echo "<font color=green><b>New Banner Successfully added</b></font><br><br>";
		else
			echo "<font color=red><b>Unable to add the banner in to database.</b></font><br><br>";
	}

}

if($asd != "view"){
?>

<form name=addf action="<?php echo $PHP_SELF;?>" method=POST>
<input name=addd type=hidden value=addd>
<font color=black><b>Use this form to add new ad code.</b></font>
<table width=90% cellpadding=0 cellspacing=0 class=maintext1 bgcolor='#fcfcfc' style="padding:2px; color:000000; margin:5px">
<tr><td>Name</td><td><input name=name type=text size=10></td></tr>
<tr><td>&nbsp; </td><td> </td></tr>
<tr><td>Enter Text</td><td><textarea name=text rows=5 cols=40>
</textarea>
<tr><td></td><td>Ex: Google ad code </td></tr>
</td></tr>
<!--tr><td></td><td>Ex.HIOX INDIA &nbsp;&nbsp;&nbsp;&nbsp;</td></tr>
<tr><td>Link Src</td><td><input name=linksrc type=text size=33></td></tr>
<tr><td></td><td>Ex: http://www.hioxindia.com </td></tr-->

<tr><td></td><td><input type=submit value=add></td></tr>
</table>
</form>

<form name=addf action="edit.php?adtype=TextAd" method=POST>
<input name=addd type=hidden value="view">
<table class=maintext1 style="color:000000;">
<tr><td></td><td><input type=submit value="View all banners"></td></tr>
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
