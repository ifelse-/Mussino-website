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
 Enter Database Details </td></tr>
<tr width=400 height=20><td>
 <form name=setf method=POST action=<?php echo $PHP_SELF;?>>
	<table style="color:#121212; font-family: arial,verdana,san-serif; font-size:13px;">
	<tr><td>HOST NAME </td><td><input class="ta" name="hostname"  type=text value=<?php echo "$hostname";?> ></td></tr>
	<tr><td>DB NAME </td><td><input class="ta" name="dbname"  type=text value=<?php echo "$dbname";?> ></td></tr>
	<tr><td>User NAME </td><td><input class="ta" name="username"  type=text value=<?php echo "$username";?> ></td></tr>
	<tr><td>Password </td><td><input class="ta" name="pass"  type=text value=<?php echo "$password";?> ></td></tr>
	<input name="type" type=hidden value="updatedb"></td></tr>
	<tr><td></td><td><input type=submit value="Install"></td></tr>
	</table>
 </form>
</td></tr></table>

</td></tr></table>
