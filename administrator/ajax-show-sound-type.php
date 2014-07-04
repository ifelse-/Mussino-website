<?php
include("../config/functions.inc.php");
include("session.inc.php");
if($_REQUEST['Type']=='4')
{
$types = 'Songwriter';
}
elseif($_REQUEST['Type']=='1')
{
$types = 'Musician';
}
$sql_type_master = "SELECT * FROM sound_type_master WHERE Status='1' AND Sound_Type LIKE '%".$types."%'";
$result_type_master = mysql_query($sql_type_master);
?>
 <select name="Sound" size="1" class="input-text" style="width:213px;">
<option value="">Select</option>
 <?php
while($colles_type_master = mysql_fetch_array($result_type_master))
{
?>
<option value="<?=$colles_type_master['Sound_Type_Id']?>" <? if($dataColles['Sound']==$colles_type_master['Sound_Type_Id']) { echo "SELECTED";}?>><?=stripslashes($colles_type_master['Sound_Type_Name'])?></option>
<?php
}
?>
</select> 