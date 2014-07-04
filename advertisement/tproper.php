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
.texmain{text-decoration: none; font-size: 14px;}
</style>

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
	$adty = $_GET['adtype'];
	$asd = $_GET['addd'];
	$name = $_GET['name'];
	$radio = "TextAd";
	/* Update Campaign Properties  */
	if($asd == "prop")
	{
	?>

		<font color=black><b>Campaign Properites:</b></font>
		<form name=addf action="<?php echo($PHP_SELF);?>" method=GET>
		<input name=addd type=hidden value=uprop>
		<table bgcolor=f8f8ff style="color:000000; font-size: 13px; font-family: verdana, arial, san-serif; padding:0px;" cellspacing=0>
		<tr><td> </td>   <td> </td></tr>
		<tr><td>Ad.&nbsp;Type</td><td><input name=adtype readonly value="<?php echo($radio);?>" size=10>
		<tr><td>Name</td><td><input name=name type=hidden value="<?php echo($name);?>" size=10>
		<input name=uname type=text value="<?php echo($name);?>" size=10></td></tr>
					
		<tr><td></td><td><input type=submit value=Update></td></tr>
		</table>
		</form>
	
	<?php 
	}
	else if($asd == "uprop")
	{
		$name = $_GET['name'];
		$uname = $_GET['uname'];
				
		if($uname=="")
		{
			echo "<font color=red>Empty Values Not allowed</font><br><br>
						<a href=\"proper.php\">Back</a></font><br><br><br><br>";
		}
		else
		{
			$ssd = "update campaigns set name='$uname' where name='$name'";

			$result1 = mysql_query($ssd,$link);
			if($result1)
				echo "<br><br><br><font color=green><b>Campaign Successfully Updated<br>
					 Now you can add Text to this campaign</b><br><br><br>
					<a href=\"proper.php\">Back</a></font><br><br><br><br><br><br>";
			else
				echo "<br><br><br><br><br><font color=red><b>Unable to create the campaign.</b></font><br><br><br><br><br>";
		}
	}
/*End of UPDATE Campaign properties */
/*To Include Text-Ad */
	else if($asd == "addb")
	{
		echo "<font color=black>Banners that can be added in to the campaign - <b>$name</b></font>";
		$result = mysql_query("select * from banners where campaign not like '%#*_&$name&_*#%' && adtype='$adty'",$link);
		echo "<table border=1 style=\"font-size: 14px; color:000000; border:1px solid#c3d9ff;\" width=100%>";
		while ($line = @mysql_fetch_array($result, MYSQL_ASSOC))
		{	
			$bname = $line['name'];
			$txt = $line['image'];
			$url = $line['url'];
						
			if(strlen($txt) > 40)
							$txt1 = substr($txt,10,40)."....";
			else
				$txt1 = $txt;
	
			if($vv === true){
		  		echo "<tr align=center bgcolor=#e8e8e8>\n";
			$vv = false;
			}
			else{
		   		echo "<tr align=center bgcolor=#f7f7f7>\n";
				$vv = true;
			}
      		echo "<td width=20%>$bname</td>";
			echo "<td class=texmain>$txt1</td>";
			echo "<td width=10%><a style=\"text-decoration: none; font-size: 14px;\" href=\"$PHP_SELF?name=$name&addd=uaddb&bname=$bname&adtype=$adty \">Include</a></td>\n";

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
			echo "<br><br><br><br><font color=green><b>Text-Ad added in to the campaign<br></b><br><br><br>
				<a href=\"$PHP_SELF?addd=addb&adtype=$adty&name=$name\">Add another Text-Ad</a></font><br><br><br><br><br>";
		else
			echo "<br><br><br><br><font color=red><b>Unable to add the Text-Ad.</b></font><br><br><br><br><br>";
	}
/*To Exclude Text-Ad */
	else if($asd == "delb")
	{
		echo "<font color=black>Text-Ad. in the campaign - <b>$name</b></font>";
		$result = mysql_query("select * from banners where campaign like '%#*_&$name&_*#%'",$link);
		echo "<table border=1 style=\"font-size: 14px; color:000000;\" width=100%>";
		while ($line = @mysql_fetch_array($result, MYSQL_ASSOC))
		{	
			$bname = $line['name'];
			$txt = $line['image'];
			$url = $line['url'];
		
			if(strlen($txt) > 40)
				$txt1 = substr($txt,20,40)."....";
			else
				$txt1 = $txt;
	
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

      		echo "<td> $bname</td>";
      		echo "<td class=texmain>$txt1</td>";
		echo "<td><a style=\"text-decoration: none; font-size: 14px;\" href=\"$PHP_SELF?name=$name&addd=udelb&bname=$bname&adtype='$adty'\">Exclude</a></td>\n";

			echo "</tr>\n";
		}
		echo "</table>";
	}
	
/*After exclude perform update in table*/

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
			echo "<font color=green><b>Text-Ad. removed from this campaign<br></b><br><br><br>
				<a href=\"$PHP_SELF?addd=delb&name=$name\">Remove another Text-Ad.</a></font><br><br>";
		else
			echo "<font color=red><b>Unable to remove the Text-Ad.</b></font><br><br>";
	}
/* Delete Campaign */
	else if($asd == "delc")
	{
		$result = mysql_query("select * from banners where campaign like '%#*_&$name&_*#%' && adtype='$adty'",$link);
		$cc = mysql_num_rows($result);
		if($cc > 0)
		{
			echo "<br><br><br>This campaign <b>\"$name\"</b> is not empty. <br>Please remove all the 
			Text-Ad. from this campaign before trying to delete the campaign.<br><br><br><br>
			To remove Text-Ad.- <a href=\"$PHP_SELF?name=$name&adtype=$adty&addd=delb\">Exclude Text-Ad.</a><br><br><br><br><br><br>";
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
		echo "<font color=black><b>Add code that you have to insert in to your pages.</font></b>";

		$man = $_SERVER['PHP_SELF'];
		$ss = strrpos($man,"/");
		$str = substr($man, 0, $ss);
		$hoost = $_SERVER['HTTP_HOST'];
		$str = "http://".$hoost.$str."/";
		
		echo "<br><br><textarea rows=10 cols=80 style=\"background-color: #f5f5f5;\">";
		echo "&lt;?php\n";
		echo "$"."campaign = \"$name\"; \n";
		echo "include \"."."/HAdd/showtext.php\";\n";
		echo "?&gt;\n";
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
