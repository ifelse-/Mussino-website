<?php
require_once "config/functions.inc.php";

   
	
	$sql_notes = "SELECT sum(a.No_Of_Package) as notesTotal FROM package_master a LEFT JOIN package_history_master b ON (a.Package_Id=b.Package_Id)
              WHERE a.Status='1' AND b.Member_Account_Id='".$_REQUEST['fromid']."'";
	$result_notes = mysql_query($sql_notes);
	if(mysql_num_rows($result_notes)>0)
	{
		$colles_notes = mysql_fetch_array($result_notes);
		$NOTES = $colles_notes['notesTotal'];
		$sql_bank_notes = "SELECT sum(Notes_Value) as bankNotesTotal FROM my_bank WHERE From_Member_Account_Id='".$_REQUEST['fromid']."'";
		$result_bank_notes = mysql_query($sql_bank_notes);
		$colles_bank_notes = mysql_fetch_array($result_bank_notes);
		if(mysql_num_rows($result_bank_notes)>0)
		{
		$BANK_NOTES = $colles_bank_notes['bankNotesTotal'];
		}
		else
		{
		$BANK_NOTES = 0;
		}
		$TOTAL_NOTES = $NOTES-$BANK_NOTES;
	}
	else
	{
	   $TOTAL_NOTES = 0;
	}
	
  	if($_REQUEST['toid']==$_REQUEST['fromid'])
	{
	echo "<span style='color:#757575'>You cannot enter yorself session</span>";	
	} 
	elseif($TOTAL_NOTES<$_REQUEST['value']) 
	{
	echo "<span style='color:#757575'>You have less notes for enter session</span>";	
	}
	else
	{
	
		
		$sql = "SELECT * FROM my_bank WHERE  Product_Id='".$_REQUEST['pid']."' AND From_Member_Account_Id='".$_REQUEST['fromid']."' AND To_Member_Account_Id='".$_REQUEST['toid']."' AND Account_Type='".$_REQUEST['type']."' AND Notes_Value='".$_REQUEST['value']."'";
		$result = mysql_query($sql);
		
		
		
		if(mysql_num_rows($result)==0)
		{
		$sql_bank ="INSERT INTO my_bank SET
                    Product_Id ='".trim($_REQUEST['pid'])."',
					Notes_Value ='".trim($_REQUEST['value'])."',
					To_Member_Account_Id ='".trim($_REQUEST['toid'])."',
					From_Member_Account_Id ='".trim($_REQUEST['fromid'])."',
				    Account_Type ='".trim($_REQUEST['type'])."'";
        mysql_query($sql_bank);
			
		echo"<span style='color:#757575'>Enter session successfully</span>";
		
		}
		else
		{
		echo "<span style='color:#757575'>You have already enter session</span>";
		}
			
		
		
	}

?>