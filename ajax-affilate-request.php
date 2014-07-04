<?php
require_once "config/functions.inc.php";

 
  	
	if($_REQUEST['Agentname']=='')
	{
	echo "<span style='color:#ff0000'>Please Enter Agent Name</span>";
	}
	else
	{
	
		
		$query = "SELECT * FROM addagent WHERE Status='1' AND Agentname='".$_REQUEST['Agentname']."'";
		$result = executeQuery($query);
		if(mysql_num_rows($result )==0)
		{
		echo "<span style='color:#ff0000'>Agent name is not found our database</span>";
		}
		else
		{
		$colles = mysql_fetch_array($result);
		?>
        <form id="frmAffilateInsert" name="frmAffilateInsert"  method="post" action=" " >
       <table width="80%" border="0" cellspacing="2" cellpadding="0">
      
       <tr>
            <td width="200" align="left" valign="middle"></td>
            <td align="left" valign="top" class="input-1" id="view_affilate_insert_result"></td>
       </tr>
       
       <tr>
            <td width="200" align="left" valign="middle">Order Id</td>
            <td align="left" valign="top" class="input-1"><input type="text" name="OrderId" id="OrderId" size="30" class="input-text" onkeypress="if(event.keyCode==13) {return affilate_result_insert();}" /></td>
       </tr>
       
       <tr>
            <td width="200" align="left" valign="middle">Order Amount</td>
            <td align="left" valign="top" class="input-1"><input type="text" name="OrderAmount" id="OrderAmount" size="30" class="input-text" onkeypress="if(event.keyCode==13) {return affilate_result_insert();}" /></td>
       </tr>
       
       <tr>
            <td width="200" align="left" valign="middle"><input type="hidden" name="AgentId" id="AgentId" value="<?=$colles['Id']?>"></td>
            <td align="left" valign="top" class="input-1"><input class="submit" name="buttonSubmit" type="button" value="Submit" onclick="return affilate_result_insert();" onkeypress="if(event.keyCode==13) {return affilate_result_insert();}" ></td>
       </tr>
       
                  
       </table>
        
        </form>
        
        <?php
        }
			
		
		
	}

?>