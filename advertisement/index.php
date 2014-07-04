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
.maintext1{font-size: 13px; color: #000000; font-family: verdana, arial, san-serif; padding:20px;}
.tab{font-family: arial, verdana, san-serif; font-size: 14px;}
.asd2{text-decoration: none; font-family: arial, verdana, san-serif; font-size: 13px; color: #b22222;}
.asd1{text-decoration: none; font-family: arial, verdana, san-serif; font-size: 13px; color: #000000;}
</style>

</head>

<body style="margin: 0px;">

<table width=790 height=100% bgcolor=#f0f0f0 cellpadding=0 cellspacing=0 align=left>
<tr><td align=center>

<?php include "heade.php" ?>

<!-- content row -->
<tr height=95%><td class=maintext align=left> 
<br>
<table width=95% algin=center border=0 cellpadding=2 cellspacing=4>
<tr height=50%>
<td width=50%>
		
		<table border=0 height=100% cellpadding=0 cellspacing=0 style="border:1px solid #0000ff;">
		<tr height=10%>
		<td bgcolor=#acbefa><img src="images/add.gif" border=0 align=right></td>
		<td class="maintext" bgcolor=#acbefa>

			<table class=tab>
			<td id=5 class="tab" align=center onmouseout=btnTimer() onmouseover=showLayer("Menu3",'5') style="color: #ffffff"> <b>Add Banner</b></td>
		</tr>
			</table>
		<div id=Menu3 style="position: absolute; border: 1px solid #000000; visibility: hidden; z-ndex: 1">		
		<table width=160 bgcolor=#e8eefa cellspacing=0 cellpadding=0 style="border-collapse: collapse;">
		<tr height=25 onmouseout=menuOut(this,'#e8eefa') onmouseover=menuOver(this,'#c3d9ff')>
		<td bgcolor=#acbef8>&nbsp;&nbsp;</td><td align=left>
		<a class=asd1 href="addban.php"> &nbsp;Add Image Banner &nbsp;</a> &nbsp;</td></tr>
		<tr height=25 onmouseout=menuOut(this,'#e8eefa') onmouseover=menuOver(this,'#c3d9ff')>
		<td bgcolor=#acbef8>&nbsp;&nbsp;</td><td align=left>
		<a class=asd1 href="addtext.php"> &nbsp;Add Text Banner &nbsp;</a> &nbsp;</td></tr>
		</table></div>
	
		<tr height=90%><td class="maintext1" colspan=2 bgcolor=e8eefa>  
		Click on to add new ad banners/text ad(google ad code) on your webpages. 
		You can have your own banner ad/ad code managing and tracking system.
		You can use it as as Banner Rotator or Random Ad Manager and also as a Image Rotator.
		</td></tr>
		</table>

</td>

<td width=50%>
		<table border=0 height=100% cellpadding=0 cellspacing=0 style="border:1px solid #0000ff;">
		<tr height=10%>
		<td bgcolor=#acbefa><img src="images/del.gif" border=0 align=right></td>
		<td class="maintext" bgcolor=#acbefa> 
		  <table class=tab>
                  <td id=6 class="tab" align=center onmouseout=btnTimer() onmouseover=showLayer("Menu4",'6') style="color: #ffffff"> <b>Edit/Delete Banner</b>
		  </td></tr>
                  </table> 

                  <div id=Menu4 style="position: absolute; border: 1px solid #000000;visibility:hidden; z-ndex: 1">
			<table bgcolor=#e8eefa cellspacing=0 cellpadding=0 style="border-collapse: collapse;">
	                <tr height=25 onmouseout=menuOut(this,'e8eefa') onmouseover=menuOver(this,'#c3d9ff')> 
	                <td bgcolor=#acbef8>&nbsp;&nbsp;</td>
			<td align=left>
			<a class=asd2 href="edit.php?adtype=banner"> &nbsp;Edit/Delete Image Banner &nbsp;</a> &nbsp; &nbsp;
			</td></tr>
			<tr height=25 onmouseout=menuOut(this,'e8eefa') onmouseover=menuOver(this,'#c3d9ff')>
			<td bgcolor=#acbef8>&nbsp;&nbsp;</td>
			<td align=left>
	                <a class=asd2 href="edit.php?adtype=TextAd"> &nbsp;Edit/Delete Text Banner &nbsp;</a> &nbsp; &nbsp;
			</td></tr>
			</table></div>      		


<!--a href=delban.php class=links>Delete Banner</a> </td></tr-->
		<tr><td class="maintext1" colspan=2 bgcolor=e8eefa> 
		Click on "Edit/Delete Banner" to Edit/Delete the banner/text ad.
		Edit the banner/text ad that should be updated. 
		Delete a banner/text ad that is not required any more.
		</td></tr></table>
</td>
</tr>

<tr height=50%>
<td height=100% valign=top>
		<table border=0 width=100% height=100% cellpadding=0 cellspacing=0 valign=top style="border:1px solid #0000ff;">
		<tr height=10%>
		<td bgcolor=#acbefa><img src="images/rot.gif" border=0 align=right></td>
		<td class="maintext" bgcolor=acbefa> 
		<a href=proper.php class=links><b>Campaign Properties</b></a> </td></tr>
		<tr height=90%><td class="maintext1" colspan=2 bgcolor=e8eefa>   
		a) Create and manage multiple campaigns.<br>
		b) set campaign properties (height and width).<br>
		c) dynamically include, exclude banners, get the campaign code.<br>
		</td></tr></table>
</td>

<td height=100%>
		<table border=0 width=100% height=100% cellpadding=0 cellspacing=0 style="border:1px solid #0000ff;">
		<tr height=10%>
		<td bgcolor=#acbefa align=right 
			style="font-size: 13px; font-weight:bold; color:red;">&nbsp; &nbsp; &nbsp;$</td>
		<td class="maintext" bgcolor=#acbefa> 
		<a href=stats.php class=links><b>View Statistics</b></a> </td></tr>
		<tr><td class="maintext1" colspan=2 bgcolor=e8eefa>  
		View stats on any selected dates/ day/ month.<br>
		View details of date, time and ip.<br>
		Delete older statistics.<br>
		</td></tr></table>
</td>
</tr>
</table>

</td></tr>
<!-- content row -->

<tr><td width=100% align=right>
a product by &copy; <a href="http://www.hscripts.com" 
style="font-size: 14px; color: blue; text-decoration:none;">hscripts.com</a> 
&nbsp; &nbsp; &nbsp; &nbsp;
</td></tr>
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
