<?php
require_once "auth/config.php";

$link = mysql_connect($hostname, $username,$password);
if($link)
{
	$dbcon = mysql_select_db($dbname,$link);
}

?>

<!-- main table -->
<table width=100% height=100% align=center valign=top cellpadding=0 cellspacing=0 border=0>
<!-- header row -->
<tr height=70 width=100%><td>
<table width=100%><tr><td width=70><img height=70 src="images/logo.gif"></td>
<td class=head align=left>
<a href="http://www.hscripts.com"><img src="./images/head.gif" border=0></a> 
</td>
<td align=right>rav1.5 &nbsp; &nbsp; &nbsp; &nbsp; </td>
</tr></table>
</td></tr>
<!-- header row -->

<!-- links row -->
<tr height=1><td bgcolor=white> 
</td></tr>
<tr height=1%><td bgcolor='#bababa' align=center class=links> 
<!-- Menu Builder  -->
<style>
.tab{font-family: verdana, arial, san-serif; font-size: 12px;}
.asd{text-decoration: none; font-family: arial, verdana, san-serif; font-size: 13px; color: #000000;}
.fmet{font-size: 13px;font-weight: bolder; color: 000000;}
.atag{font-size:13px; color:black; text-decoration:none;}
.atag:hover{text-decoration:underline;}
</style>

<script language=javascript>
window.onerror = null;
var bName = navigator.appName;
var bVer = parseInt(navigator.appVersion);
var IE4 = (bName == "Microsoft Internet Explorer" && bVer >= 4);
var menuActive = 0;
var menuOn = 0;
var onLayer;
var timeOn = null;

function showLayer(layerName,aa){
var x =document.getElementById(aa);
var tt =findPosX(x);
var ww =findPosY(x)+20;

if (timeOn != null) {
clearTimeout(timeOn);
hideLayer(onLayer);
}
if (IE4) {
var layers = eval('document.all["'+layerName+'"].style');
layers.left = tt;
eval('document.all["'+layerName+'"].style.visibility="visible"');
}
else {
if(document.getElementById){
var elementRef = document.getElementById(layerName);
if((elementRef.style)&& (elementRef.style.visibility!=null)){
elementRef.style.visibility = 'visible';
elementRef.style.left = tt;
elementRef.style.top = ww;
}
}
}
onLayer = layerName
}

function hideLayer(layerName){
if (menuActive == 0)
{
if (IE4){
eval('document.all["'+layerName+'"].style.visibility="hidden"');
}
else{
if(document.getElementById){
var elementRef = document.getElementById(layerName);
if((elementRef.style)&& (elementRef.style.visibility!=null)){
elementRef.style.visibility = 'hidden';
}
}
}
}
}

function btnTimer() {
timeOn = setTimeout("btnOut()",600)
}

function btnOut(layerName){
if (menuActive == 0){
hideLayer(onLayer)
}
}

var item;
function menuOver(itemName,ocolor){
item=itemName;
itemName.style.backgroundColor = ocolor; //background color change on mouse over
clearTimeout(timeOn);
menuActive = 1
}

function menuOut(itemName,ocolor){
if(item)
itemName.style.backgroundColor = ocolor;
menuActive = 0
timeOn = setTimeout("hideLayer(onLayer)", 100)
}

function findPosX(obj)
{
var curleft = 0;
if (obj.offsetParent)
{
while (obj.offsetParent)
{
curleft += obj.offsetLeft
obj = obj.offsetParent;
}
}
else if (obj.x)
curleft += obj.x;
return curleft;
}

function findPosY(obj)
{
var curtop = 0;
if (obj.offsetParent)
{
while (obj.offsetParent)
{
curtop += obj.offsetTop
obj = obj.offsetParent;
}
}
else if (obj.y)
curtop += obj.y;
return curtop;
}

</script>

<table valign=top cellpadding=0 cellspacing=0 width=650 border=0>
<tr><td bgcolor=#bababa>
<table align=center class=tab><tr>
<td id=0 align=center> <a href=index.php style='text-decoration:none;color: #ffffff;' ><b>Home</b></a></td>
<td style="color: #ffffff;"> &nbsp; || &nbsp; </td>

<td id=1 align=center onmouseout=btnTimer() onmouseover=showLayer("Menu1",'1') style="color: #ffffff"><b>Banner</b></td>
<td style="color: #ffffff;"> &nbsp; || &nbsp; </td>
<td id=2 align=center onmouseout=btnTimer() onmouseover=showLayer("Menu2",'2') style="color: #ffffff"><b>Text Ad.</b></td>
<td style="color: #ffffff;"> &nbsp; || &nbsp; </td>

<td id=3 align=center> <a href=proper.php style='text-decoration:none;color: #ffffff;' ><b>Campaign</b></a></td>
<td style="color: #ffffff;"> &nbsp; || &nbsp; </td>
<td id=4 align=center> <a href=stats.php style='text-decoration:none;color: #ffffff;' ><b>Ad Statistics</b></a></td>

</tr></table>


<div id=Menu1 style="position: absolute; border: 1px solid #000000; visibility:hidden; z-ndex: 1">
<table bgcolor=#cdcdcd cellspacing=0 cellpadding=0 style="border-collapse: collapse;">
<tr height=25 onmouseout=menuOut(this,'#cdcdcd') onmouseover=menuOver(this,'#bfbfbf')>
<td bgcolor=#7f7f7f>&nbsp; </td><td align=left>
<a class=asd href="addban.php"> &nbsp;Add &nbsp;</a> &nbsp; &nbsp;</td></tr>
<tr height=25 onmouseout=menuOut(this,'#cdcdcd') onmouseover=menuOver(this,'#bfbfbf')>
<td bgcolor=#707070>&nbsp; </td><td align=left>
<a class=asd href="edit.php?adtype=banner"> &nbsp;Edit/Delete &nbsp;</a> &nbsp; &nbsp;</td></tr>
</table></div>

<div id=Menu2 style="position: absolute; border: 1px solid #000000; visibility:hidden; z-ndex: 1">
<table bgcolor=#cdcdcd cellspacing=0 cellpadding=0 style="border-collapse: collapse;">
<tr height=25 onmouseout=menuOut(this,'#cdcdcd') onmouseover=menuOver(this,'#bfbfbf')>
<td bgcolor=#7f7f7f>&nbsp;</td><td align=left>
<a class=asd href="addtext.php"> &nbsp;Add &nbsp;</a> &nbsp; &nbsp;</td></tr>
<tr height=25 onmouseout=menuOut(this,'#cdcdcd') onmouseover=menuOver(this,'#bfbfbf')>
<td bgcolor=#7f7f7f>&nbsp;</td><td align=left>
<a class=asd href="edit.php?adtype=TextAd"> &nbsp;Edit/Delete &nbsp;</a> &nbsp; &nbsp;</td></tr>
</table></div>

</td></tr></table>
<!-- End of Menu Builder  -->

</td></tr>
<tr height=1><td bgcolor=white> 
</td></tr>
<!-- header row -->
