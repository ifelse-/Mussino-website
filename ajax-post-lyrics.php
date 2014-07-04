<?php
require_once "config/functions.inc.php";

	if($_REQUEST['Lyrics']=='')
	{
	echo "<span style='color:#990000;'>PLEASE ENTER THE TEXT</span>";
	}
	elseif($_REQUEST['type']=='' && $_REQUEST['pid']=='' && $_REQUEST['mid']=='')
	{
	echo "<span style='color:#990000;'>ERROR ...</span>";	
	} 
	else
	{
			$sql_check_duplicate = "SELECT * FROM other_site_lyrics WHERE LEFT(Lyrics,20) LIKE '".substr(trim(addslashes($_REQUEST['Lyrics'])),0,20)."%' ";
			$result_check_duplicate = mysql_query($sql_check_duplicate);
			
			
			if(mysql_num_rows($result_check_duplicate)==0)
			{
				####################
						
				$sql_notes = "SELECT sum(b.Membership_No) as postTotal, a.Membership_Upgrade_Id, Membership_Package_Name FROM membership_artist_upgrade_master a LEFT JOIN membership_artist_upgrade_history_master b ON (a.Membership_Upgrade_Id=b.Membership_Upgrade_Id)
				WHERE a.Status='1' AND b.Status='1' AND b.Member_Account_Id='".$_SESSION['SESS_ID']."'";
				$result_notes = mysql_query($sql_notes);
				if(mysql_num_rows($result_notes)>0)
				{
				$colles_notes = mysql_fetch_array($result_notes);
				$PACKAGE = $colles_notes['Membership_Package_Name'];
				$PACKAGE_ID = $colles_notes['Membership_Upgrade_Id'];
				$POST_TOTAL = $colles_notes['postTotal'];
				$TOTAL_POST = $POST_TOTAL;
				}
				else
				{
				$PACKAGE = 0;
				$PACKAGE_ID = 0;
				$TOTAL_POST = 0;
				}
				
				$sqlTextCount = "SELECT COUNT(*) AS CtotalText FROM lyrics_post_master WHERE Member_Account_Id='".$_SESSION['SESS_ID']."' AND Status=1";
				$resTextCount = mysql_query($sqlTextCount);
				$collesTextCount = mysql_fetch_array($resTextCount);
				
				
				####################
					
				$sql = "SELECT * FROM lyrics_post_master WHERE  Product_Id='".$_REQUEST['pid']."' AND Member_Account_Id='".$_REQUEST['mid']."'";
			
				 $result = executeQuery($sql);
	
				 if(mysql_num_rows($result)==0)
				 {
				
				
				$sql_insert = "INSERT INTO lyrics_post_master SET
							   Lyrics = '".addslashes($_REQUEST['Lyrics'])."',
							   Type = '".$_REQUEST['type']."',
							   Member_Account_Id = '".$_REQUEST['mid']."',
							   Product_Id = '".$_REQUEST['pid']."',
							   Lyrics_Date = now(),
							   Status = '1'";
					executeQuery($sql_insert);
					echo "<span style='color:#006600;'>POST TEXT ADDED</span>";
					
					# Email To Admin About New Artist post
				
					$SUBJECT = "New artist post notification at Mussino.com";
					$TO  = Get_Single_Field("general_setting_master","Mails_Id","Gen_Set_Id","1");
					
								
					$BODY  = "Title : ".stripslashes(Get_Single_Field("product_master","Title","Product_Id","$_REQUEST[pid]"))." \n";
					$BODY .= "Notes : ".stripslashes(Get_Single_Field("product_master","Product_Notes","Product_Id","$_REQUEST[pid]"))." \n";
					$BODY .= "Session Start : ".stripslashes(Get_Single_Field("product_master","Session_Start_Date","Product_Id","$_REQUEST[pid]"))." \n";
					$BODY .= "Session End : ".stripslashes(Get_Single_Field("product_master","Session_End_Date","Product_Id","$_REQUEST[pid]"))." \n";
					$BODY1  = "Artist Name ".trim($_SESSION['SESS_FIRST_NAME'].' '. $_SESSION['SESS_LAST_NAME']).",\n\n";
					$BODY .= "Post Details : ".stripslashes($_REQUEST['Lyrics'])." \n";
								
			
					$HEADER = "From: ".addslashes(trim($_SESSION['SESS_FIRST_NAME'].' '. $_SESSION['SESS_LAST_NAME']))." <".addslashes(trim($_SESSION['SESS_EMAIL']))."> \n";
					$HEADER .= "Reply-To: $TO <$TO>\n";
					$HEADER .= "X-Mailer: PHP/" . phpversion() . "\n";
					$HEADER .= "X-Priority: 1";
				   
					$MAILSEND = @mail($TO, $SUBJECT, $BODY, $HEADER);
					
					$artistValue = Get_Single_Field("member_account_master","Session_Email","Member_Account_Id","$_SESSION[SESS_ID]");
				    if($artistValue==0)
					{
					# Email To User About New Artist post
					
					$SUBJECT1 = "New Post at Mussino.com";
					$TO1   = trim($_SESSION['SESS_EMAIL']);
					
					$BODY1  = "Dear ".trim($_SESSION['SESS_FIRST_NAME'].' '. $_SESSION['SESS_LAST_NAME']).",\n\n";
					$BODY1 .= "Title : ".stripslashes(Get_Single_Field("product_master","Title","Product_Id","$_REQUEST[pid]"))." \n";
					$BODY1 .= "Notes : ".stripslashes(Get_Single_Field("product_master","Product_Notes","Product_Id","$_REQUEST[pid]"))." \n";
					$BODY1 .= "Session Start : ".stripslashes(Get_Single_Field("product_master","Session_Start_Date","Product_Id","$_REQUEST[pid]"))." \n";
					$BODY1 .= "Session End : ".stripslashes(Get_Single_Field("product_master","Session_End_Date","Product_Id","$_REQUEST[pid]"))." \n\n";
					$BODY1 .= "Post Details : ".stripslashes($_REQUEST['Lyrics'])." \n";
					
					
					$HEADER1 = "From: ".$TO." \n";
					$HEADER1 .= "X-Mailer: PHP/" . phpversion() . "\n";
					$HEADER1 .= "X-Priority: 1";
					
					$MAILSEND1 = @mail($TO1, $SUBJECT1, $BODY1, $HEADER1);
					}
					
					$musicianValue = Get_Single_Field("member_account_master","Session_Email","Member_Account_Id","$_REQUEST[pid]");
					if($musicianValue==0)
					{
					# Email To Musician About New Artist post
					
					$SUBJECT2 = "New Post Artist at Mussino.com";
					$TO2   = trim(Get_Single_Field("product_master","Member_Account_Id","Product_Id","$_REQUEST[pid]"));
					
					$BODY2  = "Dear ".trim(stripslashes(Get_Single_Field("member_account_master","First_Name","Member_Account_Id","$TO2").' '. Get_Single_Field("member_account_master","Last_Name","Member_Account_Id","$TO2"))).",\n\n";
					$BODY2 .= "Title : ".stripslashes(Get_Single_Field("product_master","Title","Product_Id","$_REQUEST[pid]"))." \n";
					$BODY2 .= "Notes : ".stripslashes(Get_Single_Field("product_master","Product_Notes","Product_Id","$_REQUEST[pid]"))." \n";
					$BODY2 .= "Session Start : ".stripslashes(Get_Single_Field("product_master","Session_Start_Date","Product_Id","$_REQUEST[pid]"))." \n";
					$BODY2 .= "Session End : ".stripslashes(Get_Single_Field("product_master","Session_End_Date","Product_Id","$_REQUEST[pid]"))." \n\n";
					$BODY2 .= "Post Details : ".stripslashes($_REQUEST['Lyrics'])." \n";
					
					
					$HEADER2 = "From: ".$TO." \n";
					$HEADER2 .= "X-Mailer: PHP/" . phpversion() . "\n";
					$HEADER2 .= "X-Priority: 1";
					
					$MAILSEND2 = @mail($TO2, $SUBJECT2, $BODY2, $HEADER2);
					}
					###################################
					if($_SESSION['SESS_ACCOUNT_TYPE']=='Artist')
					{
						$to_member_id = Get_Single_Field("product_master","Member_Account_Id","Product_Id","$_REQUEST[pid]");
						$to_notes = Get_Single_Field("product_master","Product_Notes","Product_Id","$_REQUEST[pid]");
						
						$sql = "SELECT * FROM my_bank WHERE  Product_Id='".$_REQUEST['pid']."' AND From_Member_Account_Id='".$_SESSION['SESS_ID']."' AND To_Member_Account_Id='".$to_member_id."' AND Account_Type='Artist'";
							$result = mysql_query($sql);
						if(mysql_num_rows($result)==0)
							{
							$sql_bank ="INSERT INTO my_bank SET
										Product_Id ='".trim($_REQUEST['pid'])."',
										Notes_Value ='".trim($to_notes)."',
										To_Member_Account_Id ='".trim($to_member_id)."',
										From_Member_Account_Id ='".trim($_SESSION['SESS_ID'])."',
										Account_Type ='Artist'";
							mysql_query($sql_bank);
							}
					}
					
				}
				else
				{
				echo "<span style='color:#990000;'>POST ALREADY EXIST</span>";
				}
			}
			else
			{
				echo "<span style='color:#990000;'>POST LYRICS HAVE BEEN ALREADY USE BY SOMEBODY.</span>";
			}

	}

?>