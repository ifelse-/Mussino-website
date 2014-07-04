<?php
require_once("config/functions.inc.php");
   		$sql33= "SELECT * FROM temp_order  WHERE  Sess_Id='".$sess_id."' ORDER BY T_Id ASC ";
		$result33=mysql_query($sql33);
		
		#if($_REQUEST['orderType']=='CreditCardPayment')
		#{
		
			if($_REQUEST['Credit_Card_Number']=='')
			{
			echo "Please Enter Credit Card Number";
			}	
			elseif($_REQUEST['Month']=='')
			{
			echo "Please Select Month";
			}
			elseif($_REQUEST['Year']=='')
			{
			echo "Please Select Year";
			}
			else
			{
			$_SESSION['SESS_CARD_NUMBER'] = trim($_REQUEST['Credit_Card_Number']);
			$_SESSION['SESS_EXPIRY_DATE'] = '20'.trim($_REQUEST['Year']).'-'.trim($_REQUEST['Month']);
			$_SESSION['SESS_TYPE'] = 'Credit Card';
			echo 'Credit Card';
			}
		#}
		/*elseif($_REQUEST['orderType']=='PayPallPayment')
		{
		
			if($_REQUEST['Credit_Card_Number']=='')
			{
			echo "Please Enter Credit Card Number";
			}	
			elseif($_REQUEST['Month']=='')
			{
			echo "Please Select Month";
			}
			elseif($_REQUEST['Year']=='')
			{
			echo "Please Select Year";
			}
			else
			{
			$_SESSION['SESS_CARD_NUMBER'] = trim($_REQUEST['Credit_Card_Number']);
			$_SESSION['SESS_EXPIRY_DATE'] = trim($_REQUEST['Month']).trim($_REQUEST['Year']);
			$_SESSION['SESS_TYPE'] = 'PayPal';
			echo 'Pay Pal';
			}
		}*/
		
	  
   
?>