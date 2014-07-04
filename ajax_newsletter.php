<?php
require_once "config/functions.inc.php";

 
  	if($_REQUEST['Name']=='')
	{
	echo "<span style='color:#ff0000'>Please Enter Name</span>";	
	} 
	elseif($_REQUEST['Email']=='')
	{
	echo "<span style='color:#ff0000'>Please Enter Email ID</span>";
	
	}
	elseif(!preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i",$_REQUEST['Email']))
	{
	echo "<span style='color:#ff0000'>Invalid Email ID</span>";
	}
	else
	{
	
		
		$sql = "SELECT * FROM newsletter_users WHERE  Email='".$_REQUEST['Email']."'";
		$result = mysql_query($sql);
		
		
		
		if(mysql_num_rows($result )==0)
		{
		$sql_newsletter ="INSERT INTO newsletter_users SET
                  Name ='".trim(addslashes($_REQUEST['Name']))."',
				  Email ='".trim(addslashes($_REQUEST['Email']))."',
				  Status ='1'";
        mysql_query($sql_newsletter);
			
		echo"<span style='color:#00FF00'>Sign Up Completed</span>";
		
		}
		else
		{
		echo "<span style='color:#ff0000'>This Email Already Use For Our Newsletter</span>";
		}
			
		
		
	}

?>