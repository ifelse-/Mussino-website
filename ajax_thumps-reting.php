<?php
require_once "config/functions.inc.php";

   		
		
		
		$sql = "SELECT * FROM my_bank WHERE  Product_Id='".$_REQUEST['pid']."' AND From_Member_Account_Id='".$_REQUEST['fromid']."' AND To_Member_Account_Id='".$_REQUEST['toid']."' AND Account_Type='".$_REQUEST['type']."'";
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
		
		$TO = Get_Single_Field("general_setting_master","Mails_Id","Gen_Set_Id","1");
		$FROM = Get_Single_Field("member_account_master","Email","Member_Account_Id","$_REQUEST[fromid]");
		$SUBJECT = 'Mussino Judge Rating for '.stripslashes(Get_Single_Field("product_master","Title","Product_Id","$_REQUEST[pid]"));
		
		$BODY = "Judge rating information is below. <br><br>";
		$BODY .= "Product Name :". stripslashes(Get_Single_Field("product_master","Title","Product_Id","$_REQUEST[pid]")) ."<br>";
		$BODY .= "Rating : ". trim($_REQUEST['value'])."<br>";
		$BODY .= "Judge Name: ". stripslashes(Get_Single_Field("member_account_master","First_Name","Member_Account_Id","$_REQUEST[fromid]"))."<br>";
		
		$BODY.= "<br><br>Thanks,";
		$BODY.= "<br>The Soundslikecash Team";

		$HEADER = "From: ".$FROM." <".$FROM."> \n";
		$HEADER .= "Reply-To: $FROM <$FROM>\n";
		$HEADER .= "Content-type: text/html\r\n"; 

	   
		$MAILSEND = @mail($TO, $SUBJECT, $BODY, $HEADER);
			
		echo"<span style='color:#757575'>Vote successfully</span>";
		
		}
		else
		{
		echo "<span style='color:#757575'>You have already vote</span>";
		}
		

?>