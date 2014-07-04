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
</style>

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
</script>

</head>

<body style="margin: 0px;">

<table width=790 height=100% bgcolor=#f0f0f0 cellpadding=0 cellspacing=0 align=left>
<tr><td align=center>

<?php include "heade.php" ?>

<!-- content row -->
<tr><td class=maintext align=left> 
<br>
<table width=95% algin=center border=1 cellpadding=0 cellspacing=0 bgcolor=dbdbdb>
<tr height=100%>
<td height=100% class=maintext align=center>

	<?php
	$asd = $_GET['addd'];
	$name = $_GET['name'];
	$adty = $_GET['adtype'];
/* Update Campaign Properties  */
	if($asd == "prop")
	{
		$result = @mysql_query("select * from campaigns where name like '$name'",$link);
		while ($line = @mysql_fetch_array($result, MYSQL_ASSOC))
		{	
			$wid = $line['width'];
			$hig = $line['height'];
			$type = $line['tpye'];
			$radio= $line['adtype'];
			$speed = $line['speed'];
			
				if($speed == "" || $speed <= 0)
					$speed = "1000";
		}
	?>

		<font color=black><b>Campaign Properites:<b></font>
		<form name=addf action="<?php echo($PHP_SELF);?>" method=GET>
		<input name=addd type=hidden value=uprop>
		<table bgcolor=f8f8ff style="color:000000; font-size: 13px; font-family: verdana, arial, san-serif; padding:0px;">
		<tr><td>Ad.&nbsp;Type</td><td><input name=adtype readonly value="<?php echo($radio);?>" size=10></td></tr>
		<tr><td>Name</td><td><input name=name type=hidden value="<?php echo($name);?>" size=10>
		<input name=uname type=text value="<?php echo($name);?>" size=10></td></tr>
		<tr><td>Banner Height [e.g: 200]</td><td><input name=height type=text value="<?php echo($hig);?>" size=10></td></tr>
		<tr><td>Banner Width [e.g: 200]</td><td><input name=width type=text value="<?php echo($wid);?>" size=10></td></tr>
		<tr><td>Banner Type</td><td>
		<?php
			if($type == "randomad"){
		?>
				<select name=typea onchange=des(this.value)>
				<option value="randomad">Random Ad</option>
				<option value="adrotator">Ad Rotator</option>
				</select>
				</td></tr>
				<tr><td>Speed (in milliseconds)</td><td><input disabled name=speed type=text size=5></td></tr>
		<?php	}else{ ?>
				<select name=typea onchange=des(this.value)>
				<option value="randomad">Random Ad</option>
				<option value="adrotator" selected>Ad Rotator</option>
				</select>
				</td></tr>
				<tr><td>Speed (in milliseconds)</td><td><input name=speed type=text value="<?php echo($speed); ?>" size=5></td></tr>
		<?php	} ?>
		<tr><td></td><td><input type=submit value=Update></td></tr>
		</table>
		</form>
	
	<?php if($radio=="TextAd"){
                echo '<script language=javascript>
		document.addf.typea.selectedIndex = 0;
                document.addf.typea.disabled = true;
                document.addf.height.disabled = true;
                document.addf.width.disabled = true;
		</script>';
        	}
	}
	else if($asd == "uprop")
	{
		$name = $_GET['name'];
		$uname = $_GET['uname'];
		$width = $_GET['width'];
		$height = $_GET['height'];
		$typea = $_GET['typea'];
		$speed = $_GET['speed'];
		if($speed == "" || $speed <= 0)
			$speed = "1000";

		if($height == "" || $width=="" || $uname=="")
		{
			echo "<font color=red>Empty Values Not allowed</font><br><br>";
		}
		else if(intval($height) == 0 || intval($width)==0)
		{
			echo "<font color=red>Invalid argumnets passed. Please use proper integer values</font><br><br>";
		}
		else
		{
			$ssd = "update campaigns set name='$uname', width='$width', height='$height',tpye='$typea',speed='$speed' where name='$name'";

			$result1 = mysql_query($ssd,$link);
			if($result1)
				echo "<br><br><br><font color=green><b>Campaign Successfully Updated<br>
					 Now you can add banners to this campaign</b><br><br><br>
					<a href=\"proper.php\">Back</a></font><br><br><br><br><br><br>";
			else
				echo "<br><br><br><br><br><font color=red><b>Unable to create the campaign.</b></font><br><br><br><br><br>";
		}
	}
/* End of UPDATE properties of campaign */
	
	else if($asd == "addb")
	{
		echo "<font color=black>Banners that can be added in to the campaign - <b>$name</b></font>";

		$result = mysql_query("select * from banners where campaign not like '%#*_&$name&_*#%' && adtype='$adty'",$link);
		
		echo "<table border=1 style=\"font-size: 14px; color:000000;\" width=100%>";
		while ($line = @mysql_fetch_array($result, MYSQL_ASSOC))
		{	
			$bname = $line['name'];
			$image = $line['image'];
			$url = $line['url'];
		
			if(strlen($image) > 40)
				$image1 = substr($image,0,40)."....";
			else
				$image1 = $image;
	
			if(strlen($url) > 25)
				$url1 = substr($url,0,25)."....";
			else
				$url1 = $url;

			if($vv === true){
		  		echo "<tr align=center bgcolor=#e8e8e8>\n";
			$vv = false;
			}
			else{
		   		echo "<tr align=center bgcolor=#f7f7f7>\n";
				$vv = true;
			}

      		echo "<td>$bname</td><td><a style=\"text-decoration: none; font-size: 14px;\" target=_blank href=\"$image\">$image1</a></td>
				<td><a style=\"text-decoration: none; font-size: 14px;\" target=_blank href=$url>$url1</a></td>
				<td><a style=\"text-decoration: none; font-size: 14px;\" href=\"$PHP_SELF?name=$name&addd=uaddb&adtype=$adty&bname=$bname\">Include</a></td>\n";

			echo "</tr>\n";
		}
		echo "</table>";
	}
	else if($asd == "uaddb")
	{
		$bname = $_GET['bname'];
		$result = mysql_query("select campaign from banners where name like '$bname' && adtype='$adty'",$link);
		$camp = "";

		while ($line = @mysql_fetch_array($result, MYSQL_ASSOC))
		{	
			$camp = $line['campaign'];
		}
		
		$camp = $camp."#*_&"."$name"."&_*#";

		$result = mysql_query("update banners set campaign='$camp' where name like '$bname'",$link);
		if($result)
			echo "<br><br><br><br><font color=green><b>Banner added in to the campaign<br></b><br><br><br>
				<a href=\"$PHP_SELF?addd=addb&adtype=$adty&name=$name\">Add another banner</a></font><br><br><br><br><br>";
		else
			echo "<br><br><br><br><font color=red><b>Unable to add the banner.</b></font><br><br><br><br><br>";
	}
	else if($asd == "delb")
	{
		echo "Banners in the campaign - <b>$name</b>";
		$result = mysql_query("select * from banners where campaign like '%#*_&$name&_*#%'",$link);

		echo "<table border=1 style=\"font-size: 14px; color:000000;\" width=100%>";
		while ($line = @mysql_fetch_array($result, MYSQL_ASSOC))
		{	
			$bname = $line['name'];
			$image = $line['image'];
			$url = $line['url'];
		
			if(strlen($image) > 40)
				$image1 = substr($image,0,40)."....";
			else
				$image1 = $image;
	
			if(strlen($url) > 25)
				$url1 = substr($url,0,25)."....";
			else
				$url1 = $url;

			if($vv === true){
		  		echo "<tr align=center bgcolor=#e8e8e8>\n";
			$vv = false;
			}
			else{
		   		echo "<tr align=center bgcolor=#f7f7f7>\n";
				$vv = true;
			}

      		echo "<td> $bname</td><td><a style=\"text-decoration: none; font-size: 14px;\" target=_blank href=\"$image\">$image1</a></td>
				<td><a style=\"text-decoration: none; font-size: 14px;\" target=_blank href=$url>$url1</a></td>
				<td><a style=\"text-decoration: none; font-size: 14px;\" href=\"$PHP_SELF?name=$name&addd=udelb&bname=$bname\">Exclude</a></td>\n";

			echo "</tr>\n";
		}
		echo "</table>";
	}
	else if($asd == "udelb")
	{
		$bname = $_GET['bname'];
		$result = mysql_query("select campaign from banners where name like '$bname'",$link);
		$camp = "";

		while ($line = @mysql_fetch_array($result, MYSQL_ASSOC))
		{	
			$camp = $line['campaign'];
		}
		
		$sss = str_replace("#*_&".$name."&_*#","",$camp);

		$result = mysql_query("update banners set campaign='$sss' where name like '$bname'",$link);
		if($result)
			echo "<font color=green><b>Banner removed from this campaign<br></b><br><br><br>
				<a href=\"$PHP_SELF?addd=delb&name=$name\">Remove another banner</a></font><br><br>";
		else
			echo "<font color=red><b>Unable to remove the banner.</b></font><br><br>";
	}
	else if($asd == "delc")
	{
		$result = mysql_query("select * from banners where campaign like '%#*_&$name&_*#%' && adtype='$adty'",$link);
		$cc = mysql_num_rows($result);
		if($cc > 0)
		{
			echo "<br><br><br>This campaign <b>\"$name\"</b> is not empty. <br>Please remove all the 
			banners from this campaign before trying to delete the campaign.<br><br><br><br>
			To remove banners - <a href=\"$PHP_SELF?name=$name&adtype=$adty&addd=delb\">Exclude Banner</a><br><br><br><br><br><br>";
		}
		else
		{
			$result = mysql_query("delete from campaigns where name like '$name'",$link);
			if($result)
				echo "<br><br><br><b>Campaign \"$name\" is successfuly deleted.</b><br><br><br>";
			else
				echo "<br><br><br><br><b>Campaign \"$name\" is successfuly deleted.</b><br><br><br><br>";
		}
	}

/* GET CODE  */	
	else if($asd == "addcode")
	{
		echo "<font color=black><b>Add code that you have to insert in to your pages.</b></font>";
		$result = @mysql_query("select * from campaigns where name like '$name'",$link);
		while ($line = @mysql_fetch_array($result, MYSQL_ASSOC))
		{	
			$wid = $line['width'];
			$hig = $line['height'];
			$type = $line['tpye'];
			$speed = $line['speed'];
		}

		$man = $_SERVER['PHP_SELF'];
		$ss = strrpos($man,"/");
		$str = substr($man, 0, $ss);
		$hoost = $_SERVER['HTTP_HOST'];
		$str = "http://".$hoost.$str."/";
		
		echo "<br><br><textarea rows=10 cols=80 style=\"background-color: #f5f5f5;\">";
		echo "&lt;script language=javascript&gt;\n";
		echo "var width = $wid;\n";
		echo "var height = $hig;\n";
		echo "var campaign = \"$name\";\n";
		echo "var path = \"$str\";\n";
		echo "&lt;/script&gt;\n";
		echo "&lt;script type=\"text/javascript\" src=\"$str"."hadd.js\"&gt;\n";
		echo "&lt;/script&gt;\n";
		echo "</textarea>";
	}
/* END OF GET CODE */
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
