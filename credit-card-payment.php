<?php
ob_start();
require_once("config/functions.inc.php");
        /////////////////////////////////////////////////////////////////////////////////////////////////
		// Created By : Vishwas Kumar Niranjan 
		// CIM API : Authorise.net                                                          
		// Page Name : credit-card-payment.php                                                   
		// include files : config/functions.inc.php, authorize-config.php, authorizenet.cim.class.php  
		// Creation Date : 09.01.2012
		// Functionality : Created customer Info, Billing Info, Shipping Info 
		////////////////////////////////////////////////////////////////////////////////////////////////
		
		

        $sqlMember = "SELECT * FROM member_account_master WHERE Member_Account_Id='".$_SESSION['SESS_ID']."'";
        $resultMember = mysql_query($sqlMember);
        $collesMember = mysql_fetch_array($resultMember);

        include "authorize-config.php";

		$cardNumber = trim($_SESSION['SESS_CARD_NUMBER']);
	    $expirationDate = trim($_SESSION['SESS_EXPIRY_DATE']);
		
        $completeExpirationDate = $_SESSION['SESS_EXPIRY_DATE'].'-'.'30';
		
		if($collesMember['City_Id']=='999999') { $city = $collesMember['Other_City']; } else { $city = Get_Single_Field("city_master","City_Name","City_Id","$collesMember[City_Id]");}

        $cim->setParameter('paymentType', 'creditCard');
	    $cim->setParameter('cardNumber', $cardNumber);
	    $cim->setParameter('expirationDate', $expirationDate); 
		$cim->setParameter('billTo_firstName', addslashes(trim($collesMember['First_Name']))); 
		$cim->setParameter('billTo_lastName', addslashes(trim($collesMember['Last_Name']))); 
		$cim->setParameter('billTo_address', addslashes(trim($collesMember['Address']))); 
		$cim->setParameter('billTo_city', stripslashes($city)); 
		$cim->setParameter('billTo_state', stripslashes(Get_Single_Field("state_master","State_Name","State_Id","$collesMember[State_Id]"))); 
		$cim->setParameter('billTo_zip', trim($collesMember['Zip'])); 
		$cim->setParameter('billTo_country', stripslashes(Get_Single_Field("country_master","Country_Name","Country_Id","$collesMember[Country_Id]"))); 
		$cim->setParameter('billTo_phoneNumber', trim($collesMember['Phone']));
		
		$cim->setParameter('shipTo_firstName', addslashes(trim($collesMember['First_Name'])));
		$cim->setParameter('shipTo_lastName', addslashes(trim($collesMember['Last_Name']))); 
		$cim->setParameter('shipTo_address', addslashes(trim($collesMember['Address'])));
		$cim->setParameter('shipTo_city', stripslashes($city)); 
		$cim->setParameter('shipTo_state', stripslashes(Get_Single_Field("state_master","State_Name","State_Id","$collesMember[State_Id]"))); 
		$cim->setParameter('shipTo_zip',trim($collesMember['Zip'])); 
		$cim->setParameter('shipTo_country', stripslashes(Get_Single_Field("country_master","Country_Name","Country_Id","$collesMember[Country_Id]"))); 
		$cim->setParameter('shipTo_phoneNumber', trim($collesMember['Phone']));  

	    $cim->setParameter('merchantCustomerId', trim($_SESSION['SESS_ID'])); 
		$cim->setParameter('description', 'Create Customer Profile'); 
		$cim->setParameter('email', addslashes(trim($collesMember['Email']))); 
		$cim->setParameter('customerType', 'individual'); 
		
		$cim->createCustomerProfileRequest();
		
				
		$sql_customer_payment_profile_id = "SELECT * FROM tab_cim_bill_id_master WHERE Member_Account_Id = '".$_SESSION['SESS_ID']."'";
		$result_customer_payment_profile_id = mysql_query($sql_customer_payment_profile_id);
		if(mysql_num_rows($result_customer_payment_profile_id)==0)
		{
				if($cim->isSuccessful())
				{
				$cim->setParameter('customerProfileId', $cim->customerProfileId); 
				$cim->getCustomerProfileRequest();
				$customerProfileId = $cim->customerProfileId;
				$customerPaymentProfileId = $cim->customerPaymentProfileId;
				$customerAddressId = $cim->customerAddressId;
				
				
				$sql_insert_cim = "INSERT INTO tab_cim_id_master SET Member_Account_Id = '".$_SESSION['SESS_ID']."', Profile_Id='".$customerProfileId."'";
				mysql_query($sql_insert_cim);
				
				$sql_insert_cim_bill = "INSERT INTO tab_cim_bill_id_master SET Member_Account_Id = '".$_SESSION['SESS_ID']."', Profile_Id='".$customerProfileId."', Payment_Profile_Id='".$customerPaymentProfileId."', ExpirationDate='2012-12-12' ";
				mysql_query($sql_insert_cim_bill);
				
				$sql_insert_cim_ship = "INSERT INTO tab_cim_ship_id_master SET Member_Account_Id = '".$_SESSION['SESS_ID']."', Profile_Id='".$customerProfileId."',  Shipping_Address_Id='".$customerAddressId."'";
				mysql_query($sql_insert_cim_ship);
				}
		}
		else
		{
		$getCustomerPaymentProfileId = mysql_fetch_array($result_customer_payment_profile_id);
		$customerProfileId = $getCustomerPaymentProfileId['Profile_Id'];
		$customerPaymentProfileId = $getCustomerPaymentProfileId['Payment_Profile_Id'];
		}
		
	    
	   $cim->setParameter('customerProfileId', $customerProfileId); 
	   $cim->setParameter('customerPaymentProfileId', $customerPaymentProfileId); 
	   $cim->updateCustomerPaymentProfileRequest();
	
	
	   $cim->setParameter('transaction_amount', number_format($_SESSION['Grand_Full_Amount'], 2, '.', ' '));
	   $cim->setParameter('transactionType', 'profileTransAuthCapture');
	   $cim->setParameter('customerProfileId', $customerProfileId); 
	   $cim->setParameter('customerPaymentProfileId', $customerPaymentProfileId); 
	
      $cim->createCustomerProfileTransactionRequest();
	  
	 /* if ($cim->isSuccessful())
		{
			echo "<br>".$cim->response;
			echo "YES<br>".$cim->directResponse;
			echo "<br>".$cim->validationDirectResponse;
			echo "<br>".$cim->resultCode;
			echo "<br>".$cim->code;
			echo "<br>".$cim->text;
			echo "<br>".$cim->refId;
			echo "<br>".$cim->customerProfileId;
			echo "<br>".$cim->customerPaymentProfileId;
			echo "<br>".$cim->customerAddressId;
		}
		else
		{
			echo "NO<br>".$cim->directResponse;
			echo "<br>".$cim->validationDirectResponse;
			echo "<br>".$cim->resultCode;
			echo "<br>".$cim->code;
			echo "<br>".$cim->text;
			echo "<br><pre>";
			print_r($cim->error_messages);
			echo "</pre>";
			
		}	  
	 die(A);*/
	  if ($cim->isSuccessful())
	  {
	  executeQuery("UPDATE  tab_cim_bill_id_master SET ExpirationDate = '".$completeExpirationDate."' WHERE Member_Account_Id='".$_SESSION['SESS_ID']."'");
	  include("order.php");
	  }
	  else
	  {
	  $_SESSION['SESS_MSG']="Declined: Your order has been declined please check your credit card number or expiry date.";
	  header("location: error.php");
	  exit();
	  }
		
?>

