<?php
require_once "config/functions.inc.php";

 
  	
	if($_REQUEST['Agentname']=='')
	{
	echo "<span style='color:#ff0000'>Please Enter Agent Name</span>";
	}
	else if($_REQUEST['URL']=='')
	{
	echo "<span style='color:#ff0000'>Please Enter URL</span>";
	}
	else if($_REQUEST['EmailId']=='')
	{
	echo "<span style='color:#ff0000'>Please Enter Email ID</span>";
	}
	elseif(!preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i",$_REQUEST['EmailId']))
	{
	echo "<span style='color:#ff0000'>Invalid Email ID</span>";
	}
	else if($_REQUEST['Phoneno']=='')
	{
	echo "<span style='color:#ff0000'>Please Enter Phone</span>";
	}
	else
	{
	 
	        $sql = "SELECT * FROM addagent WHERE Agentname = '".$_REQUEST['Agentname']."'  ";
			$result = mysql_query($sql) or die('<br>'.$sql.'<br>'.mysql_error());
			if(mysql_num_rows($result)>0)
			{
				echo "<span style='color:#ff0000'>Agent already exist</span>";
			}
			else
			{
			
				
				$sql = "INSERT INTO addagent SET
						Agentname = '".addslashes($_REQUEST['Agentname'])."',
						URL = '".$_REQUEST['URL']."',
						Address = '".addslashes($_REQUEST['Address'])."',
						EmailId = '".$_REQUEST['EmailId']."',
						Company = '".$_REQUEST['Company']."',
						Country = '".addslashes($_REQUEST['Country'])."',
						State = '".addslashes($_REQUEST['State'])."',
						Commision = '".$_REQUEST['Commision']."',
						Phoneno = '".$_REQUEST['Phoneno']."',
						DATE = now(),
						Status = '1'";
				$result = mysql_query($sql) or die('<br>'.$sql.'<br>'.mysql_error());
				echo "<span style='color:#00FF00'>Agent successfully added</span>";
				
			}
	
		
		
	}

?>