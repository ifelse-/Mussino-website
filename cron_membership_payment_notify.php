<?php
        require_once("config/functions.inc.php");
		
		## FOR Musician
				
		$sql = "SELECT a.O_Id, u.Member_Account_Id, u.Email, u.First_Name, u.Last_Name, c.Membership_Package_Name, b.Membership_No, c.Membership_Upgrade_Id, a.Grand_Amount  
		        FROM member_account_master u JOIN orders a ON (u.Member_Account_Id=a.Member_Account_Id)
		        JOIN membership_upgrade_history_master b ON (a.Member_Account_Id=b.Member_Account_Id and a.O_Id=b.O_Id) 
				JOIN membership_upgrade_master c ON (b.Member_Account_Id=a.Member_Account_Id and b.Membership_Upgrade_Id=c.Membership_Upgrade_Id) 
		        WHERE 
				u.Status=1 AND 
				a.Status=1 AND 
				b.Status=1 AND 
				c.Status=1 AND 
				DATE_FORMAT(a.Next_Order_Date,'%Y-%m-%d') = CURDATE() AND
				(a.Next_Order_Date !='' || a.Next_Order_Date !='0000-00-00')
				group by u.Member_Account_Id";
        $result = mysql_query($sql) or die('<br>'.$sql.'<br>'.mysql_error());
       
		
	    if(mysql_num_rows($result)>0)
		{
			
			
			while($colles=mysql_fetch_array($result))
			{		
			
			#### payment query
			
			include "authorize-config.php";
			 
			 
             $result2 = mysql_query("SELECT * FROM tab_cim_bill_id_master WHERE Member_Account_Id= '".$colles['Member_Account_Id']."'");
             $getColles = mysql_fetch_array($result2);
       
	         $customerProfileId = $getColles['Profile_Id'];
             $customerPaymentProfileId = $getColles['Payment_Profile_Id'];
			 
			 			
			 $cim->setParameter('transaction_amount', number_format($colles['Grand_Amount'], 2, '.', ' ')); 
		     $cim->setParameter('transactionType', 'profileTransAuthCapture');
		     $cim->setParameter('customerProfileId', $customerProfileId); 
		     $cim->setParameter('customerPaymentProfileId', $customerPaymentProfileId); 
		     $cim->createCustomerProfileTransactionRequest();
			 
			 if ($cim->isSuccessful())
		     {
				$membership_start_musician_no = Get_Single_Field("membership_upgrade_master","Membership_No","Membership_Upgrade_Id","$colles[Membership_Upgrade_Id]");	
				$membership_current_musician_status = $colles['Membership_No']+$membership_start_musician_no;			
				mysql_query("UPDATE membership_upgrade_history_master SET Membership_No='".$membership_current_musician_status."' WHERE Member_Account_Id='".$colles['Member_Account_Id']."'");
				list($YY,$MM,$DD) = explode('-',date('Y-m-d'));
				$nextOneMonth = mktime(0,0,0,$MM+1,$DD,$YY);
				$nextOneMonthDate = date("Y-m-d", $nextOneMonth);
				mysql_query("UPDATE orders SET Next_Order_Date='".$nextOneMonthDate."' WHERE O_Id='".$colles['O_Id']."'");
				
				@$to = $colles['Email'];
				$from  = Get_Single_Field("general_setting_master","Mails_Id","Gen_Set_Id","1");
				$subject = "Musician Membership Update @ Mussino.com";		
				$message= 'Dear '.ucfirst(@$colles[First_Name]).' '.ucfirst(@$colles[Last_Name]).', </br></br>';		
				$message.= 'Your '.stripslashes(@$colles[Membership_Package_Name]).', has charged $'.@$colles[Grand_Amount].' </br></br>';
				$message.= 'Thanks</br>';
				$message.= 'Mussino Team';
				$header = "From: ".$from." \r\n";
				$header .= "Content-type: text/html\r\n"; 
				@mail($to, $subject, $message, $header);
				
				@$To = $from;
				$Subject = "Musician Membership Update @ Mussino.com";		
				$Message= 'Dear Mussino, </br></br>';		
				$Message.= ucfirst(@$colles[First_Name]).' '.ucfirst(@$colles[Last_Name]).' '.stripslashes(@$colles[Membership_Package_Name]).'  has charged $'.@$colles[Grand_Amount].' </br>';
				$Message.= 'Thanks</br>';
				
				$Header = "From: ".$from." \r\n";
				$Header .= "Content-type: text/html\r\n"; 
				@mail($To, $Subject, $Message, $Header);
			    //echo 'successs';
			 }
			 else
			 {
			 			 
			 @$To = Get_Single_Field("general_setting_master","Mails_Id","Gen_Set_Id","1");
			 @$Subject = "Musician Membership Decline @ Mussino.com";		
			 $Message= 'Dear Mussino, </br></br>';		
			 $Message.= 'Transaction has decline for '.ucfirst(@$colles[First_Name]).' '.ucfirst(@$colles[Last_Name]).' subscription member, his/her membership plan  '.stripslashes(stripslashes(@$colles[Membership_Package_Name])).'  and amount $'.@$colles[Grand_Amount].' amount. </br>';
			 $Message.= 'Thanks</br>';
			
			 $Header = "From: ".$To." \r\n";
			 $Header .= "Content-type: text/html\r\n"; 
			 @mail($To, $Subject, $Message, $Header);
			 //echo 'no done';
			 }
		    			
			#### end payment query
			
			
			
			
			
			} // end while		
		}	// end if		
		
		
		
		
		## FOR Artist
				
		$sql3 = "SELECT a.O_Id,u.Member_Account_Id, u.Email, u.First_Name, u.Last_Name, c.Membership_Package_Name, b.Membership_No, c.Membership_Upgrade_Id, a.Grand_Amount  
		        FROM member_account_master u JOIN orders a ON (u.Member_Account_Id=a.Member_Account_Id)
		        JOIN membership_artist_upgrade_history_master b ON (a.Member_Account_Id=b.Member_Account_Id and a.O_Id=b.O_Id) 
				JOIN membership_artist_upgrade_master c ON (b.Member_Account_Id=a.Member_Account_Id and b.Membership_Upgrade_Id=c.Membership_Upgrade_Id) 
		        WHERE 
				u.Status=1 AND 
				a.Status=1 AND
				b.Status=1 AND 
				c.Status=1 AND  
				DATE_FORMAT(a.Next_Order_Date,'%Y-%m-%d') = CURDATE() AND
				(a.Next_Order_Date !='' || a.Next_Order_Date !='0000-00-00')
				group by u.Member_Account_Id";
        $result3 = mysql_query($sql3) or die('<br>'.$sql3.'<br>'.mysql_error());
       
		
	    if(mysql_num_rows($result3)>0)
		{
			
			
			while($colles3=mysql_fetch_array($result3))
			{		
			
			#### payment query
			
			include "authorize-config.php";
			 
			 
             $result4 = mysql_query("SELECT * FROM tab_cim_bill_id_master WHERE Member_Account_Id= '".$colles3['Member_Account_Id']."'");
             $getColles3 = mysql_fetch_array($result4);
       
	         $customerProfileId3 = $getColles3['Profile_Id'];
             $customerPaymentProfileId3 = $getColles3['Payment_Profile_Id'];
			 
			 			
			 $cim->setParameter('transaction_amount', number_format($colles3['Grand_Amount'], 2, '.', ' ')); 
		     $cim->setParameter('transactionType', 'profileTransAuthCapture');
		     $cim->setParameter('customerProfileId', $customerProfileId3); 
		     $cim->setParameter('customerPaymentProfileId', $customerPaymentProfileId3); 
		     $cim->createCustomerProfileTransactionRequest();
			 
			 if ($cim->isSuccessful())
		     {
								
				$membership_start_artist_no = Get_Single_Field("membership_artist_upgrade_master","Membership_No","Membership_Upgrade_Id","$colles3[Membership_Upgrade_Id]");	
				$membership_current_artist_status = $colles3['Membership_No']+$membership_start_artist_no;			
				mysql_query("UPDATE membership_artist_upgrade_history_master SET Membership_No='".$membership_current_artist_status."' WHERE Member_Account_Id='".$colles3['Member_Account_Id']."'");
				
				list($YY,$MM,$DD) = explode('-',date('Y-m-d'));
				$nextOneMonth = mktime(0,0,0,$MM+1,$DD,$YY);
				$nextOneMonthDate = date("Y-m-d", $nextOneMonth);
				mysql_query("UPDATE orders SET Next_Order_Date='".$nextOneMonthDate."' WHERE O_Id='".$colles3['O_Id']."'");
				
				@$to = $colles3['Email'];
				$from  = Get_Single_Field("general_setting_master","Mails_Id","Gen_Set_Id","1");
				$subject = "Artist Membership Update @ Mussino.com";		
				$message= 'Dear '.ucfirst(@$colles3[First_Name]).' '.ucfirst(@$colles3[Last_Name]).', </br></br>';		
				$message.= 'Your '.stripslashes(@$colles3[Membership_Package_Name]).', has charged $'.@$colles3[Grand_Amount].' </br></br>';
				$message.= 'Thanks</br>';
				$message.= 'Mussino Team';
				$header = "From: ".$from." \r\n";
				$header .= "Content-type: text/html\r\n"; 
				@mail($to, $subject, $message, $header);
				
				@$To = $from;
				$Subject = "Artist Membership Update @ Mussino.com";		
				$Message= 'Dear Mussino, </br></br>';		
				$Message.= ucfirst(@$colles3[First_Name]).' '.ucfirst(@$colles3[Last_Name]).' '.stripslashes(@$colles3[Membership_Package_Name]).'  has charged $'.@$colles3[Grand_Amount].' </br>';
				$Message.= 'Thanks</br>';
				
				$Header = "From: ".$from." \r\n";
				$Header .= "Content-type: text/html\r\n"; 
				@mail($To, $Subject, $Message, $Header);
			    //echo 'successs';
			 }
			 else
			 {
			 			 
			 @$To = Get_Single_Field("general_setting_master","Mails_Id","Gen_Set_Id","1");
			 @$Subject = "Artist Membership Decline @ Mussino.com";		
			 $Message= 'Dear Mussino, </br></br>';		
			 $Message.= 'Transaction has decline for '.ucfirst(@$colles3[First_Name]).' '.ucfirst(@$colles3[Last_Name]).' subscription member, his/her membership plan  '.stripslashes(stripslashes(@$colles3[Membership_Package_Name])).'  and amount $'.@$colles3[Grand_Amount].' amount. </br>';
			 $Message.= 'Thanks</br>';
			
			 $Header = "From: ".$To." \r\n";
			 $Header .= "Content-type: text/html\r\n"; 
			 @mail($To, $Subject, $Message, $Header);
			 //echo 'no done';
			 }
		    			
			#### end payment query
			
			
			
			
			
			} // end while		
		}	// end if		
		
					
						
?>