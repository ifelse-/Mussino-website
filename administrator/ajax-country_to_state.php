<?php
include("../config/functions.inc.php");
include("session.inc.php");
$sql_state= "SELECT State_Id, State_Name FROM state_master WHERE Status=1 AND Country_Id='".$_REQUEST['Country_Id']."'";
$result_state = mysql_query($sql_state) or die('<br>'.$sql_state.'<br>'.mysql_error());
?>
<select name="State_Id">
<option value="">Select</option>
<?php
if(mysql_num_rows($result_state)>0)
{
while($colles_state = mysql_fetch_array($result_state))
{
?>
<option value="<?=$colles_state['State_Id']?>" <?php if($colles_state['State_Id']==$dataColles['State_Id']) { echo 'selected'; } ?>><?=stripslashes($colles_state['State_Name'])?></option>
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
</select>