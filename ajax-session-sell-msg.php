<?php
require_once "config/functions.inc.php";

	if($_REQUEST['Message']=='' )
	{
	echo "<span style='color:#ff0000'>Please Enter Message</span>";
	}
    elseif($_REQUEST['Action']=='' )
	{
	echo "<span style='color:#ff0000'>Please Select Action</span>";	
	}
	else
	{
		
		mysql_query("UPDATE sell_session SET Status='".$_REQUEST['Action']."' WHERE S_S_Id='".$_REQUEST['lpi']."'");
		
		if($_REQUEST['Action']==1) { $act = 'Accept'; } else { $act = 'Decline'; }
		
		$artistid = Get_Single_Field("sell_session","Artist_Id","S_S_Id","$_REQUEST[ssid]");
		$artistname = Get_Single_Field("member_account_master","First_Name","Member_Account_Id","$artistid");
		$artistemail = Get_Single_Field("member_account_master","Email","Member_Account_Id","$artistid");
		$musicianname = Get_Single_Field("member_account_master","First_Name","Member_Account_Id","$_SESSION[SESS_ID]");
		$musicianemail = Get_Single_Field("member_account_master","First_Name","Member_Account_Id","$_SESSION[SESS_ID]");		
		
		$subject = "Sell Session ".$act." At Mussino.com";	
		
		$message= 'Dear '.$artistname.',</br></br>';		
		$message.= '</br></br>Your sell session reques '.$act.' by '.$musicianname.'</br></br>';
		$message.= '</br></br>'.stripslashes($_REQUEST['Message']).'</br></br>';
		$message.= 'Thanks </br>';
		$message.= $musicianname;
			
		$header = "From: ".$musicianemail." \r\n";
		$header .= "Content-type: text/html\r\n";
			
			
		@mail($artistemail, $subject, $message, $header);
		
		echo"<span style='color:#000'>Message sent successfully</span>";
	
		
	}

?>