<?php
require_once "config/functions.inc.php";
	
	
		if(isset($_POST['queryString'])) {
			$queryString = trim($_POST['queryString']);
			
			if(strlen($queryString) >0) {
				
				if($_SESSION['SESS_ACCOUNT_TYPE']=='Artist') {
				$query = mysql_query("SELECT Member_Account_Id, Email, First_Name, Last_Name FROM member_account_master WHERE Status=1 AND (First_Name LIKE '$queryString%' || Last_Name LIKE '$queryString%')  AND Account_Type='Musician' AND Member_Account_Id!='".$_SESSION['SESS_ID']."' AND Personal_Msg=0 ");
				}
				elseif($_SESSION['SESS_ACCOUNT_TYPE']=='Musician')
				{
				$query = mysql_query("SELECT Member_Account_Id, Email, First_Name, Last_Name FROM member_account_master WHERE Status=1 AND (First_Name LIKE '$queryString%' || Last_Name LIKE '$queryString%')  AND Account_Type = 'Artist' AND Member_Account_Id!='".$_SESSION['SESS_ID']."' AND Personal_Msg=0 ");
				}
				if($query) {
					
					while ($result = mysql_fetch_array($query)) {
						
	         			echo '<li onClick="fillCity(\''.$result[Email].'\');">'.ucwords(strtolower($result[First_Name].' '.$result[Last_Name])).'</li>';
	         		}
				} else {
					echo 'ERROR: There was a problem with the query.';
				}
			} else {
				
			} 
		} else {
			echo 'There should be no direct access to this script!';
		}
	
?>