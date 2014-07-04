<?php
require_once "config/functions.inc.php";
	if($_REQUEST['Artist_Name']=='')
	{
	echo "<span style='color:#ff0000'>Please Enter Artist Name</span>";
	}
	elseif($_REQUEST['Musician_Name']=='')
	{
	echo "<span style='color:#ff0000'>Please Enter Musician Name</span>";
	}
	elseif($_REQUEST['Sound_Title']=='')
	{
	echo "<span style='color:#ff0000'>Please Enter Sound Title</span>";	
	}
	elseif($_REQUEST['Details']=='')
	{
	echo "<span style='color:#ff0000'>Please Enter Details</span>";	
	}
	else
	{
		
		
		$sql_insert = "INSERT INTO report_master SET 
				   Artist_Name = '".addslashes($_REQUEST['Artist_Name'])."', 
				   Musician_Name = '".addslashes($_REQUEST['Musician_Name'])."', 
				   Sound_Title ='".addslashes($_REQUEST['Sound_Title'])."',
				   Details='".addslashes($_REQUEST['Details'])."'"; 
	    mysql_query($sql_insert);
	
	    $Email = "vishwas@worldwebsoftware.com";
		$SUBJECT = 'Soundslikecash Report';
		$from = "prashant@worldwebsoftware.com";
		
		$BODY = "Report information is below. <br><br>";
		$BODY .= "Artist Name :". stripslashes($_REQUEST['Artist_Name']) ."<br>";
		$BODY .= "Musician Name  : ". stripslashes($_REQUEST['Musician_Name'])."<br>";
		$BODY .= "Sound Title : ". stripslashes($_REQUEST['Sound_Title'])."<br>";
		$BODY .= "Details : ". stripslashes($_REQUEST['Details'])."<br>";
		$BODY.= "<br><br>Thanks,";
		$BODY.= "<br>The Soundslikecash Team";

		$HEADER = "From: ".$from." <".$from."> \n";
		$HEADER .= "Reply-To: $Email <$Email>\n";
		$HEADER .= "Content-type: text/html\r\n"; 

	   
		$MAILSEND = @mail($Email, $SUBJECT, $BODY, $HEADER);
		if($MAILSEND)
		{
		echo"<span style='color:#00FF00'>Report Added.</span>";
		}
		else
		{
		echo "<span style='color:#ff0000'>Error.</span>";
		}
	}
?>