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
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<style>
.ta{background-color: ffff44;}
.rad{color:red; font-weight:bold; background-color: ffff44;}
.head{font-size: 17px; color: white; font-family: verdana, arial, san-serif;}
.links{font-size: 13px; color: white; font-family: verdana, arial, san-serif; text-decoration:none;}
.maintext{font-size: 13px; color: #fefefe; font-family: verdana, arial, san-serif; padding:10px;}
</style>
</head>
<body style="margin: 0px;">

<script language=javascript>
function sub(xyz)
{
var frm= document.getElementById(xyz).newurl.value;
 if(frm==''){
  alert("Empty Values not allowed");
  return false;
  }
}

function conf()
{
 var df = confirm("This Data will be Deleted");
if(df)
        return true;
else
        return false;
}

</script>

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
/* To delete banners */
$tdo = $_GET['tdo'];
if($tdo == "delete")
{
        $deln = $_GET['delname'];

        if($deln == "")
        {
                echo "<font color=red>Empty Values Not deleted</font><br><br>";
        }
        else
        {
                $result = mysql_query("delete from banners where name like '$deln'",$link);
                if($result)
                        echo "<font color=red><b>Banner Successfully Deleted</b></font><br><br>";
                else
                        echo "<font color=red><b>Banner not Deleted</b></font><br><br>";
        }
}
/* End to delete banner */

/*Update for banner Ad */
$adty = $_GET['adtype'];
$todo = $_POST['todo'];

if($adty=="banner"){
if($todo == "update")
{
	$upna = $_POST['upname'];
	$nameup = $_POST['newname']; 
	$imgup =  $_POST['newimage'];
	$urlup = $_POST['newurl'];

	if($upna == "" || $imgup == "")
	{
		echo "<font color=red>Empty Values Will Not be Updated</font><br><br>";
	}
	else
	{
		$result = mysql_query("update banners set image='$imgup',url='$urlup' where name like '$upna'",$link);
		if($result)
			echo "<font color=Green><b>Banner Successfully Updated</b></font><br><br>";
		else
			echo "<font color=red><b>Banner not Updated</b></font><br><br>";
	}
}

?>
<font color=black>
<b>Use this form to Edit old banners.</b></font><br><br>
<?php
	$result = mysql_query("select * from banners where adtype='$adty'",$link);
	$d = mysql_num_fields($result);
	echo "<table border=1 width=100% style=\"font-size: 14px; color:000000;\" > <tr>";
        for($j=0;$j<3;$j++)
        {
             $fname = mysql_field_name($result, $j);
             echo "<td align=center>".ucfirst($fname)."</td>";
        }
     	echo "</tr>";
	
	while ($line = @mysql_fetch_array($result, MYSQL_ASSOC))
	{	
		$name = $line['name'];
		$image = $line['image'];
		$url = $line['url'];
	
		if(strlen($image) > 50)
			$image1 = substr($image,0,50)."....";
		else
			$image1 = $image;
		if(strlen($url) > 25)
			$url1 = substr($url,0,25)."....";
		else
			$url1 = $url;


		if($vv === true){
	  		$col='#e8eefa';
		$vv = false;
		}
		else{
	   		$col='#f0f8ff';
			$vv = true;
		}
                echo "<form id=$name name=xx$name method=POST action='edit.php?id=$name&adtype=$adty'><tr bgcolor=$col><td align=center>";
                echo "<input size=7 name=newname readonly value=$name><td align=center>
		<input size=34 name=newimage value='$image'></td> <td align=center>
		<input size=35 name=newurl value='$url'>
                <input type=hidden value='$name' name='upname'><br>
		<input type=hidden value=update name='todo'></td>
                <td align=center> 
		<input type=submit value=Update style=\"border:0px solid; color:green; background-color:$col;cursor:pointer;text-decoration:none;\"></td>";
		echo "</td></form>";
		echo "<td><a onclick='return conf()' style=\"text-decoration: none; color:red;\" href=\"$PHP_SELF?tdo=delete&delname=$name&adtype=$adty\">Delete</a></td>\n";
		echo "</tr>";
	}
	echo "</table>";
}

/*Update for TextAd */

else if($adty=="TextAd"){
if($todo == "update")
{
	$upna = $_POST['upname'];
	$nameup = $_POST['newname']; 
	$imgup =  $_POST['newimage'];
	$urlup = $_POST['newurl'];

	if($upna == "" || $imgup == "")
	{
		echo "<font color=red>Empty Values Will Not be Updated</font><br><br>";
	}
	else
	{
		$result = mysql_query("update banners set image='$imgup' where name like '$upna'",$link);
		if($result)
			echo "<font color=Green><b>Banner Successfully Updated</b></font><br><br>";
		else
			echo "<font color=red><b>Banner not Updated</b></font><br><br>";
	}
}

?>
<font color=black>
<b>Use this form to Edit old TEXTAd.</b></font><br><br>
<?php
	$result = mysql_query("select * from banners where adtype='$adty'",$link);
	$d = mysql_num_fields($result);
	echo "<table border=1 width=70% style=\"font-size: 14px; color:000000; \">
				<tr>";
        
	$fname = mysql_field_name($result, $j);
        echo "<td align=center>Name</td>";
				echo "<td align=center>TextAd</td>";
      	echo "</tr>";
	
	while ($line = @mysql_fetch_array($result, MYSQL_ASSOC))
	{	
		$name = $line['name'];
		$image = $line['image'];
		$url = $line['url'];		
		
		if(strlen($image) >40)
			$image1 = substr($image,0,40)."....";
		else
			$image1 = $image;
		if(strlen($url) > 25)
			$url1 = substr($url,0,25)."....";
		else
			$url1 = $url;


		if($vv === true){
	  		$col='#fcfcfc';
		$vv = false;
		}
		else{
	   		$col='#f5f5f5';
			$vv = true;
		}
                echo "<form id=$name onsubmit='sub(this.id)' name=xx$name method=POST action='edit.php?id=$name&adtype=$adty'><tr bgcolor=$col>";
                echo "<td align=center><input size=10 name=newname readonly value=$name style=\"border:0px solid; color:green; background-color:$col;\"></td>";
								echo "<td align=center><textarea name=newimage rows=10 cols=40 wrap=soft>$image</textarea></td>";
								echo "<input type=hidden value='$name' name='upname'>
								<input type=hidden value=update name='todo'>
                <td align=center> 
								<input type=submit value=Update style=\"border:0px solid; color:green; background-color:$col;cursor:pointer;text-decoration:none;\"></td>";
		echo "</td></form>";
		echo "<td><a onclick='return conf()' style=\"text-decoration: none; color:red;\" href=\"$PHP_SELF?tdo=delete&delname=$name&adtype=$adty\">&nbsp;Delete&nbsp;</a></td>\n";
		echo "</tr>";
	}
	echo "</table>";
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
