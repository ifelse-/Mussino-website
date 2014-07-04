<table align=center height=100% width=100%>
<tr><td>

<?php
$file = "auth/config.php"; 
if(!is_readable($file) or !is_writeable($file))
{
    echo " <span class=\"errortext\">Incorrect file permissions for config.php! <br>
		Must be in read,write mode during installaton</span>";
}
?>

<table bgcolor=adeade align=center style="border: 1px #266266 solid;">
<tr width=400 height=20><td align=center bgcolor="266266" 
style="color: ffffff; font-family: arial,verdana,san-serif; font-size:13px;">
 Enter Amin Login Details </td></tr>
<tr width=400 height=20><td>
 <form name=setf method=POST action=<?php echo $PHP_SELF;?>>
	<table style="color:#121212; font-family: arial,verdana,san-serif; font-size:13px;">
	<tr><td>User NAME </td><td><input class="ta" name="usern"  type=text value=<?php echo "$un";?> ></td></tr>
	<tr><td>Password </td><td><input class="ta" name="passw"  type=password value=<?php echo "$pw";?> ></td></tr>
	<input name="type" type=hidden value="auth"></td></tr>
	<tr><td></td><td><input type=submit value="Enter"></td></tr>
	</table>
 </form>
</td></tr></table>

</td></tr></table>
