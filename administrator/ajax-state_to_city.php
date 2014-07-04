<?php
include("../config/functions.inc.php");
include("session.inc.php");
$sql_city= "SELECT City_Id, City_Name FROM city_master WHERE Status=1 AND State_Id='".$_REQUEST['State_Id']."'";
$result_city = mysql_query($sql_city) or die('<br>'.$sql_city.'<br>'.mysql_error());
?>
<select name="City_Id"  style="width:210px;">
<option value="">Select</option>
<?php
if(mysql_num_rows($result_city)>0)
{
while($colles_city = mysql_fetch_array($result_city))
{
?>
<option value="<?=$colles_city['City_Id']?>" onclick="return show_other_city_box('<?=$colles_city['City_Id']?>');" ><?=stripslashes($colles_city['City_Name'])?></option>
<?php
}
}
else
{
?>
<option value="">No Record (s)</option>
<?php
}
?>
<option value="999999" onclick="return show_other_city_box('other_city_id');">Other City</option>
</select>