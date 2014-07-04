<?php 
require_once "config/functions.inc.php";
$sql = "SELECT * FROM temp_order WHERE Sess_Id ='".$sess_id."'";
$result = mysql_query($sql);
if($_SESSION['SESS_ID']=="")
{
$_SESSION['go']="checkout.php";
}
$sql_member = "SELECT * FROM member_account_master WHERE Member_Account_Id='".$_SESSION['SESS_ID']."'";
$result_member = mysql_query($sql_member);
$colles_member = mysql_fetch_array($result_member);
$sql_country = "SELECT Country_Id, Country_Name FROM country_master WHERE Status=1 ORDER BY Country_Name";
$result_country = mysql_query($sql_country) or die('<br>'.$sql_country.'<br>'.mysql_error());
$sql_state = "SELECT State_Id, State_Name  FROM state_master WHERE Status=1 AND Country_Id='".$colles_member['Country_Id']."'";
$result_state = mysql_query($sql_state) or die('<br>'.$sql_state.'<br>'.mysql_error());
$sql_city = "SELECT City_Id, City_Name FROM city_master WHERE Status=1 AND State_Id='".$colles_member['State_Id']."'";
$result_city = mysql_query($sql_city) or die('<br>'.$sql_city.'<br>'.mysql_error());
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>Checkout</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="description" content="Default Description">
<meta name="keywords" content="">
<meta name="robots" content="">
<?php include "common.inc.php"; ?>
<script type="text/javascript" src="fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="fancybox/jquery.fancybox-1.3.4.css" media="screen" />
<link type="text/css" rel="stylesheet" href="http://mussino.com/css/layout.css">
<script type="text/javascript">
  $(document).ready(function(){
				
		
$("#variousRegister").fancybox({
				'overlayShow'	: true,
				'transitionIn'	: 'elastic',
				'transitionOut'	: 'elastic'
			});
$("#variousLogin").fancybox({
				'overlayShow'	: true,
				'transitionIn'	: 'elastic',
				'transitionOut'	: 'elastic'
			});


});

function trim(str) {
        return str.replace(/^\s+|\s+$/g,"");
    }
function createObject(){
  if(window.XMLHttpRequest){
    var obj	= new XMLHttpRequest();
  }else{
    var obj	= new ActiveXObject('Microsoft.XMLHTTP');
  }
 return obj;
}  
var httpobj	= createObject();

function login_request_result(){ 
	
    document.getElementById('checkout_login_result').innerHTML ='<img src="images/loading.gif" alt="" />';

	var Email = document.frmLogin.Email.value;    
	var Password = document.frmLogin.Password.value;
	
	httpobj.open('get',"ajax-login-request.php?Email="+Email+"&Password="+Password);
	httpobj.onreadystatechange	= handleLoginResponse;
	httpobj.send("");

}

function show_country_to_state(){ 
	
	 document.getElementById('view_state_result').innerHTML ='<img src="images/loading.gif" alt="" />'; 
	 
	var Country_Id = document.frmCheckoutRegister.Country_Id.value;
	
	httpobj.open('get',"ajax-country_to_state.php?Country_Id="+Country_Id);
	httpobj.onreadystatechange	= handleCountryToStateResponse;
	httpobj.send("");

}
function handleCountryToStateResponse(){

	 if(httpobj.readyState==4){
		 var text = httpobj.responseText;
		document.getElementById('view_state_result').innerHTML = text;
		
	 }
}  

function show_state_to_city(){ 
	
	 document.getElementById('view_city_result').innerHTML ='<img src="images/loading.gif" alt="" />'; 
	 
	var State_Id = document.getElementById('State_Id').value;
	
	httpobj.open('get',"ajax-state_to_city.php?State_Id="+State_Id);
	httpobj.onreadystatechange	= handleStateToCityResponse;
	httpobj.send("");

}
function handleStateToCityResponse(){

	 if(httpobj.readyState==4){
		 var text = httpobj.responseText;
		 document.getElementById('view_city_result').innerHTML = text;
		
	 }
}  
function handleLoginResponse(){

	 if(httpobj.readyState==4)
	 {
		 var text = httpobj.responseText;
		 
		 if(text=='Go Welcome')
		 {
		 location.replace('action.php');
		 }
		 else if(text=='Go Cart')
		 {
		 location.replace('my-cart.php');
		 }
		 else if(text=='Go Checkout')
		 {
		 location.replace('checkout.php');
		 }
		 else if(text=='Go Unreleased')
		 {
		 location.replace('unreleased-music.php');
		 }
		 else
		 {
		 document.getElementById('checkout_login_result').innerHTML = text;
		 }
	 }
}

function do_billing_info(){ 
	
    document.getElementById('registration_id').innerHTML ='<img src="images/loading.gif" alt="" />';
	
	
	var Email = document.frmCheckoutRegister.Email.value;    
	var First_Name = document.frmCheckoutRegister.First_Name.value;
	var Last_Name = document.frmCheckoutRegister.Last_Name.value;
	var Address = document.frmCheckoutRegister.Address.value;
	    Address = Address.replace('#',"");
	    Address = Address.replace('&',"");
	var Country_Id = document.frmCheckoutRegister.Country_Id.value;
	var State_Id = document.getElementById('State_Id').value;
	var City_Id = document.frmCheckoutRegister.City_Id.value;
	var City = document.frmCheckoutRegister.City.value;
	var Zip = document.frmCheckoutRegister.Zip.value;
	var Phone = document.frmCheckoutRegister.Phone.value;
	var security_code = document.frmCheckoutRegister.security_code.value;
	
	
	httpobj.open('get',"ajax-billing-checkout.php?Email="+Email+"&First_Name="+First_Name+"&Last_Name="+Last_Name+"&Address="+Address+"&Country_Id="+Country_Id+"&State_Id="+State_Id+"&City_Id="+City_Id+"&Zip="+Zip+"&Phone="+Phone+"&security_code="+security_code+"&City="+City);
	httpobj.onreadystatechange	= handleDoRegistrationResponse;
	httpobj.send("");

}
function handleDoRegistrationResponse(){

	 if(httpobj.readyState==4)
	 {
		 var text = httpobj.responseText;
		 
		 if(trim(text)=='Go Checkout')
		 {
		 location.replace('checkout.php');
		 }
		 else
		 {
		 document.getElementById('registration_id').innerHTML = text;
		 }
	 }
}
function order_checkout_result(){ 

		document.getElementById('view_order_checkout').innerHTML ='<img src="images/loading.gif" alt="" />';
		
		/*for (var i=0; i < document.frm2.orderType.length; i++)
		{
			if(document.frm2.orderType[i].checked)
			{
			var orderType = document.frm2.orderType[i].value;
			}
		}*/
		
		
		var Credit_Card_Number = document.frm2.Credit_Card_Number.value;
		var Month = document.frm2.Month.value;
		var Year = document.frm2.Year.value;
		
		
		//alert("apply-order-checkout.php?orderType="+orderType+"&Credit_Card_Number="+Credit_Card_Number+"&Month="+Month+"&Year="+Year);
		httpobj.open('get',"apply-order-checkout.php?Credit_Card_Number="+Credit_Card_Number+"&Month="+Month+"&Year="+Year);
		httpobj.onreadystatechange	= handleOrderCheckOutResponse;
		httpobj.send("");
	
	}
	function handleOrderCheckOutResponse(){
	
		 if(httpobj.readyState==4){
			 var text = httpobj.responseText;
			  
				if(trim(text)=='Please Select Payment Option')
				{
				document.getElementById('view_order_checkout').innerHTML =text;
				}
				else if(trim(text)=='Credit Card')
				{
				location.replace('credit-card-payment.php');
				}
				else if(trim(text)=='Pay Pal')
				{
				location.replace('paypall-payment.php');
				}
				else
				{
				document.getElementById('view_order_checkout').innerHTML = text;
				}
				
		 }
	}
function checkall(notesFrm)

{

len = notesFrm.elements.length;

var i=0;

for( i=0 ; i<len ; i++)

{

if (notesFrm.elements[i].type=='checkbox') notesFrm.elements[i].checked=notesFrm.check_all.checked;

}

}

function show_other_city_box(id)
{
	
	if(id=='other_city_id')
	{
	document.getElementById('other_city_id').style.display = 'block';
	}
	else
	{
	document.getElementById('other_city_id').style.display = 'none';
	}

}  

</script>
</head>
<body>
<script type="text/javascript" src="wz_tooltip.js"></script>
<div id="wrapper">
  <!-- HEADER -->
  <?php include "header.middle.inc.php"; ?>
  <div class="content-container">
    <?php include "header.top.inc.php"; ?>
    <!-- TOP SPOTLIGHT 1 -->
    <div class="content-box-2">
      <div class="cor_1set-5"></div>
      <div class="cor_1set-6"></div>
      <div class="pro-wrapper full">
        <div class="title">
          <div class="title_wrap-1">
            <div class="title_wrap-2">
              <div class="blue-btn-1"> <span><span>
                Checkout
                </span></span> </div>
            </div>
          </div>
        </div>
        <div class="pro-content">
          <div class="notes">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="grid">
             
			 <?php if(empty($_SESSION['SESS_ID'])) { ?>
              <div class="sml-info" style="padding: 0 0 10px 0;">If you already have an account please <a id="variousLogin" href="#requestLogin">sign in</a> 
              <div style="display: none;">
                            <div id="requestLogin" style="width:400px;height:150px;">
                                
                                <div class="form-container">
                                 <form id="frmLogin" name="frmLogin" method="post" action="">
                                <ul class="fl">
                                
                                   <li></li>
                                    
                                    <li>
                                        <div  id="checkout_login_result" style="padding: 5px 0 5px 160px;"></div>
                                        <div class="cl"></div>
                                    </li>
                                    
                                    <li>
                                        <div class="caption-2">Email ID</div>
                                        <div class="input-2"><input type="text" name="Email" size="30" class="input-text" onkeypress="if(event.keyCode==13) {return login_request_result();}" /></div>
                                        <div class="cl"></div>
                                    </li>
                                    <li>
                                       <div class="caption-2">Password</div>
                                       <div class="input-2"><input type="password" name="Password" size="30"  class="input-text" onkeypress="if(event.keyCode==13) {return login_request_result();}"/></div>
                                       <div class="cl"></div>
                                    </li>
                                    
                                    
                                    <li>
                                       
                                       <div class="input-2"  style="padding-left:50px;"><input class="button" name="buttonSubmit" type="button" value="Submit" onclick="return login_request_result();" onkeypress="if(event.keyCode==13) {return login_request_result();}"></div>
                                        <div class="cl"></div>
                                    </li>
                                </ul>
                            </form>
                                 </div>
                                
                            </div>
                       </div>
              </div>
			  <?php } ?>
            
            <tr valign="top">
            <?php if($_SESSION['SESS_ID']!='' && (empty($colles_member['Email']) || empty($colles_member['First_Name']) || empty($colles_member['Last_Name']) || empty($colles_member['Address'])  || empty($colles_member['State_Id']) || empty($colles_member['City_Id']) || empty($colles_member['Zip']) || empty($colles_member['Country_Id']) || empty($colles_member['Phone']) )) { ?>
            <td width="50%">
            <!--<div class="white-box">-->
            <form id="frmCheckoutRegister" name="frmCheckoutRegister"  method="post" action="">
            	<h2><span><span>Your Billing Contact Information</span></span></h2>
                
                <!--<div id="registration_id" class="msg-row full"></div>-->
                
                <div class="form-container">
                
                <ul>
                 <li>
                  <div id="registration_id" class="error" style="padding:5px 0 5px 50px;"></div>
                </li>
               <li>
              <div class="caption-2">Email ID <font style="color:#FF0000;">*</font></div>
              <div class="input-2">
                <input type="text" name="Email" value="<?=stripslashes($colles_member['Email'])?>" size="30" class="input-text" onkeypress="if(event.keyCode==13) {return do_billing_info();}" />
              </div>
              <div class="cl"></div>
            </li>
            
            <li>
              <div class="caption-2">First Name <font style="color:#FF0000;">*</font></div>
              <div class="input-2">
                <input type="text" name="First_Name" id="First_Name"  value="<?=stripslashes($colles_member['First_Name'])?>" onkeypress="if(event.keyCode==13) {return do_billing_info();}" />
              </div>
              <div class="cl"></div>
            </li>
            
            <li>
              <div class="caption-2">Last Name <font style="color:#FF0000;">*</font></div>
              <div class="input-2">
                <input type="text" name="Last_Name" id="Last_Name"  value="<?=stripslashes($colles_member['Last_Name'])?>" onkeypress="if(event.keyCode==13) {return do_billing_info();}" />
              </div>
              <div class="cl"></div>
            </li>
            
            <li>
                  <div class="caption-2">Address <font style="color:#FF0000;">*</font></div>
                  <div class="input-2">
                    <textarea name="Address" rows="4" cols="27"  class="input-text" onkeypress="if(event.keyCode==13) {return do_billing_info();}"><?=stripslashes($colles_member['Address'])?></textarea>
                  </div>
                  <div class="cl"></div>
                </li>
             <li>
                  <div class="caption-2">Country <font style="color:#FF0000;">*</font></div>
                  <div class="input-2">
                    <select name="Country_Id" id="Country_Id" style="width:210px;" onchange="show_country_to_state()" class="input-text" onkeypress="if(event.keyCode==13) {return do_billing_info();}">
                    <option value="">Select</option>
                    <?php
                    while($colles_country = mysql_fetch_array($result_country))
                    {
                    ?>
                    <option value="<?=$colles_country['Country_Id']?>" <?php if($colles_country['Country_Id']==$colles_member['Country_Id']) { echo 'selected'; } ?> ><?=stripslashes($colles_country['Country_Name'])?></option>
                    <?php
                    }
                    ?>
                    </select>
                  </div>
                  <div class="cl"></div>
                </li>
             <li>
                  <div class="caption-2">State <font style="color:#FF0000;">*</font></div>
                  <div class="input-2" id="view_state_result">
                    <select name="State_Id" id="State_Id" style="width:210px;" class="input-text" onkeypress="if(event.keyCode==13) {return do_billing_info();}">
                    <option value="">Select</option>
                    <?php
					if($colles_member['Country_Id']!='')
					{
                    while($colles_state = mysql_fetch_array($result_state))
                    {
                    ?>
                    <option value="<?=$colles_state['State_Id']?>" <?php if($colles_state['State_Id']==$colles_member['State_Id']) { echo 'selected'; } ?> ><?=stripslashes($colles_state['State_Name'])?></option>
                    <?php
                    }
					}
                    ?>
                    </select>
                  </div>
                  <div class="cl"></div>
                </li>
             <li>
                  <div class="caption-2">City <font style="color:#FF0000;">*</font></div>
                  <div class="input-2" id="view_city_result">
                    <select name="City_Id" id="City_Id" style="width:210px;" class="input-text" onkeypress="if(event.keyCode==13) {return do_billing_info();}">
                    <option value="">Select</option>
                    <?php
					if($colles_member['State_Id']!='')
					{
                    while($colles_city = mysql_fetch_array($result_city))
                    {
                    ?>
                    <option onClick="return show_other_city_box('<?=$colles_city['City_Id']?>');" value="<?=$colles_city['City_Id']?>" <?php if($colles_city['City_Id']==$colles_member['City_Id']) { echo 'selected'; } ?> ><?=stripslashes($colles_city['City_Name'])?></option>
                    <?php
                    }
					}
                    ?>
                    <option value="999999" onClick="return show_other_city_box('other_city_id');" <?php if('999999'==$colles_member['City_Id']) { echo 'selected'; } ?>>My City</option>
                    </select>
                  </div>
                  <div class="cl"></div>
                </li>
                
                
                <li id="other_city_id" <?php if('999999'!=$colles_member['City_Id']) { ?> style=" display:none;" <?php } ?>>
                  <div class="caption-2">My City <font style="color:#FF0000;">*</font></div>
                  <div class="input-2">
                    <input type="text" name="City" size="30" value="<?=$colles_member['Other_City']?>"  class="input-text" onkeypress="if(event.keyCode==13) {return do_billing_info();}"/>
                  </div>
                  <div class="cl"></div>
                </li>
                
                
                
             <li>
                  <div class="caption-2">Zip Code <font style="color:#FF0000;">*</font></div>
                  <div class="input-2">
                    <input type="text" name="Zip" size="30" value="<?=$colles_member['Zip']?>"  class="input-text" onkeypress="if(event.keyCode==13) {return do_billing_info();}"/>
                  </div>
                  <div class="cl"></div>
                </li>
             
             <li>
                  <div class="caption-2">Phone <font style="color:#FF0000;">*</font></div>
                  <div class="input-2">
                    <input type="text" name="Phone" size="30" value="<?=$colles_member['Phone']?>"  class="input-text" onkeypress="if(event.keyCode==13) {return do_billing_info();}"/>
                  </div>
                  <div class="cl"></div>
                </li>
            
            
            
            <li>
              <div class="caption-2">Type the code shown <font style="color:#FF0000;">*</font></div>
              <div class="input-2">
              <div class="captcha" style="padding-bottom:8px;">
               <img src="php_captcha.php?hash=<?php echo $hash; ?>&width=90&height=35&characters=6" alt="captcha" name="captchaImage">
              </div>               
               <input type="text" name="security_code" id="security_code"  onkeypress="if(event.keyCode==13) {return do_billing_info();}">
              </div>
              <div class="cl"></div>
            </li>
            
            <li>
                  <div class="input-field2">
                  
                  <div class="submit-btn fl" style="padding:5px 0 5px 160px;">
                      <span>
                        <span>
                         <input class="button" name="buttonSubmit" type="button" value="Submit" onClick="return do_billing_info();" onKeyPress="if(event.keyCode==13) {return do_billing_info();}">
                        </span>
                      </span> 
                    </div>
                  
                  </div>
                  <div class="cl"></div>
                </li>
          </ul>
                </div>
            </form>
            <!--</div>-->
            </td>
            <?php } elseif($_SESSION['SESS_ID']!='' && !empty($colles_member['Email'])  && !empty($colles_member['First_Name']) && !empty($colles_member['Last_Name']) && !empty($colles_member['Address']) && !empty($colles_member['State_Id']) && !empty($colles_member['City_Id']) && !empty($colles_member['Zip']) && !empty($colles_member['Country_Id']) && !empty($colles_member['Phone'])) { ?>
            <td width="50%">
            <table width="100%" border="0" cellspacing="2" cellpadding="2">
                <tr height="26">
                <td><h2>Your Billing Contact Information</h2></td>
                </tr>
              <tr>
                <td><?=stripslashes($colles_member['First_Name'].' '.$colles_member['Last_Name'])?></td>
              </tr>
              <tr>
                <td><?=stripslashes($colles_member['Address'])?></td>
              </tr>
              <tr>
              <?php if($colles_member['City_Id']=='999999') { $city = $colles_member['Other_City']; } else { $city = Get_Single_Field("city_master","City_Name","City_Id","$colles_member[City_Id]");} ?>
                <td><?=stripslashes($city.' '.Get_Single_Field("state_master","State_Name","State_Id","$colles_member[State_Id]").' '.$colles_member['Zip'].' '.Get_Single_Field("country_master","Country_Name","Country_Id","$colles_member[Country_Id]"))?></td>
              </tr>
              <tr>
                <td><?=stripslashes($colles_member['Phone'])?></td>
              </tr>
              
            </table>

            </td>
            <?php } ?>
            <td width="5%"></td>
            
            <td width="45%">
                <table cellspacing="1" cellpadding="1" border="0" width="100%">
                
                
                
                <tr height="26">
                <th width="200" align="center"><b>Name</b></th>
                <th width="300" align="center"><b>Notes/Quantity</b></th>
                <th width="100" align="center"><b>Amount</b></th>
               
                </tr>
                <?php
                $k=0;
				$Total =0;
                if(mysql_num_rows($result)>0)
                {
                while($line=mysql_fetch_array($result))
                {
                if($line['Mode']==0)
				{
				$NAME = stripslashes(Get_Single_Field("package_master","Package_Name","Package_Id","$line[Id]"));
				$NOTES = Get_Single_Field("package_master","No_Of_Package","Package_Id","$line[Id]");
				$PRICE = Get_Single_Field("package_master","Package_Amount","Package_Id","$line[Id]");
				}
				elseif($line['Mode']==1)
				{
				$NAME =  stripslashes(Get_Single_Field("product_master","Title","Product_Id","$line[Id]"));
				$NOTES = 1;
				$PRICE = Get_Single_Field("product_master","Price","Product_Id","$line[Id]");
				}
				elseif($line['Mode']==2)
				{
				$NAME =  stripslashes(Get_Single_Field("membership_upgrade_master","Membership_Package_Name","Membership_Upgrade_Id","$line[Id]"));
				$NOTES = 1;
				$PRICE = Get_Single_Field("membership_upgrade_master","Membership_Package_Amount","Membership_Upgrade_Id","$line[Id]");
				}
				elseif($line['Mode']==3)
				{
				$NAME =  stripslashes(Get_Single_Field("membership_artist_upgrade_master","Membership_Package_Name","Membership_Upgrade_Id","$line[Id]"));
				$NOTES = 1;
				$PRICE = Get_Single_Field("membership_artist_upgrade_master","Membership_Package_Amount","Membership_Upgrade_Id","$line[Id]");
				}
				elseif($line['Mode']==4)
				{
				$NAME =  stripslashes(Get_Single_Field("product_master","Title","Product_Id","$line[Id]"));
				$NOTES = 1;
				$PRICE = Get_Single_Field("product_master","Price","Product_Id","$line[Id]");
				}
				elseif($line['Mode']==5)
				{
				$lp_id =  Get_Single_Field("sell_session","Lyrics_Post_Id","S_S_Id","$line[Id]");
				$NAME =  stripslashes(substr(Get_Single_Field("lyrics_post_master","Lyrics","Lyrics_Post_Id","$lp_id"),0,50));
				$NOTES = 1;
				$PRICE = Get_Single_Field("sell_session","Price","S_S_Id","$line[Id]");
				}
                ?>
                <tr height="30">
                <td width="200" align="center" class="linksmall-txt-line"><?=$NAME?></td>
                <td width="300" align="center" class="linksmall-txt-line"><?=$NOTES?></td>
                <td width="100" align="center" class="linksmall-txt-line">$<?=$PRICE?></td>
                </tr>
                <?php
                $Total += $PRICE;
                $k++;
                }
                }
                else
                { 
                echo "<td colspan='5' class='linksmall-txt-line' align='center'>Cart is empty</td>";
                }
                ?>
                
                <?php if(mysql_num_rows($result)>0) { ?>
                
                
                
                <tr height="26" >
                <td></td>
                <td width="120" align="right"><strong>Total :</strong></td>
                <td width="120" align="center" ><strong>$<? printf('%1.2f',$Total);?></strong></td>
                </tr>
                <?php $_SESSION['Grand_Full_Amount'] = $Total; ?>
                
               
                <?php } ?>
                </table>
            </td>
            
            </tr>
            
            <tr height="26"><td colspan="3"></td></tr>
            
            <form id="frm2" name="frm2" method="post" action="">
            <tr valign="top">
            <td width="40%">
            <table width="100%" border="0" cellspacing="10" cellpadding="10" >
                <tr height="26">
                <td colspan="2"><h2>Payment Information</h2></td>
                </tr>
                
                
                
                <tr>
                <td colspan="2"> <img src="images/paypal.jpg" alt="" align="absmiddle"; /></td>
               </tr>
               
               <tr>
                <td colspan="2" id="view_order_checkout" style="color:#FF0000;"></td>
                </tr>
               <!--tr>
                <td width="50%"><input type="radio" name="orderType" id="orderType" value="CreditCardPayment" checked="checked"/><strong>Pay Using Authorize</strong></td>
                <td width="50%"><input type="radio" name="orderType" id="orderType" value="PayPallPayment" /> <strong>Pay Using Paypal</strong></td>
               </tr-->
                
                <tr>
                <td width="30%">Credit Card Number </td>
                <td width="70%"><input name="Credit_Card_Number" type="text" style="background:none repeat scroll 0 0 #fff; width:165px;border:1px #9C9B9B solid; padding:3px 2px 3px 2px;" /></td>
                </tr>
                
                <tr>
                <td>Exp. Date </td>
                <td>
                <span> 
                                            
                <select name="Month" id="Month" style="background:none repeat scroll 0 0 #fff; width:65px;border:1px #9C9B9B solid; padding:2px 2px 2px 2px;">
                 <option value="">Month</option>
                <?php
                for($m=1;$m<=12;$m++)
                {
                if($m<10){ $m="0".$m; }
                ?>
                <option value="<?=$m?>" <?php if($m==$_REQUEST['m']) { echo 'selected'; } ?>><?=$m?></option>
                <?php
                }
                ?>
                </select> 
               </span>
               
                <span style="padding: 5px 0 0 10px;">      
                <select name="Year" id="Year" style="background:none repeat scroll 0 0 #fff; width:60px;border:1px #9C9B9B solid; padding:2px 2px 2px 2px;">
                 <option value="">Year</option>
                <?php
                for($y=date('y');$y<=date('y')+10;$y++)
                {
                if(strlen($y)==1){$y="0".$y;}
                ?>
                <option value="<?=$y?>" <?php if($y==$_REQUEST['y']) { echo 'selected'; } ?>><?=$y?></option>
                <?php
                }
                ?>
                </select> 
               </span>
                </td>
                </tr>
                
                
                
                <tr><td colspan="2" style="padding: 10px 0 10px 0;"></td></tr>
                
                <?php if($_SESSION['SESS_ID']=='') { ?>
                <tr valign="top">
                <td colspan="2">
                <ul class="list-2">
                  <li>
                  <div class="input-field2">
                  <div class="submit-btn fl">
                      <span>
                        <span>
                        <a href="javascript:void(0);" onmouseover="Tip('Please Login')" onmouseout="UnTip()">
                        <img src="images/checkout.jpg" /></a>
                        
                        </span>
                      </span> 
                    </div>
                   
                  </div>
                  <div class="cl"></div>
                </li>
                </ul>
                
                </td>
                </tr>
                <?php } elseif(empty($_SESSION['Grand_Full_Amount'])) { ?>
                <tr valign="top">
                <td colspan="2">
                <ul class="list-2">
                  <li>
                  <div class="input-field2">
                  <div class="submit-btn fl">
                      <span>
                        <span>
                        <a href="javascript:void(0);" onmouseover="Tip('Cart is Empty')" onmouseout="UnTip()">
                        <img src="images/checkout.jpg" /></a>
                        
                        </span>
                      </span> 
                    </div>
                   
                  </div>
                  <div class="cl"></div>
                </li>
                </ul>
                
                </td>
                </tr>
                <?php } elseif($_SESSION['SESS_ID']!='' && (empty($colles_member['Email']) || empty($colles_member['First_Name']) || empty($colles_member['Last_Name']) || empty($colles_member['Address'])  || empty($colles_member['State_Id']) || empty($colles_member['City_Id']) || empty($colles_member['Zip']) || empty($colles_member['Country_Id']) || empty($colles_member['Phone'])))  { ?>
                <tr valign="top">
                <td colspan="2">
                <ul class="list-2">
                  <li>
                  <div class="input-field2">
                  <div class="submit-btn fl">
                      <span>
                        <span>
                        <a href="javascript:void(0);" onmouseover="Tip('Fill Out Your Billing Contact Information')" onmouseout="UnTip()">
                        <img src="images/checkout.jpg" /></a>
                        
                        </span>
                      </span> 
                    </div>
                   
                  </div>
                  <div class="cl"></div>
                </li>
                </ul>
                
                </td>
                </tr>
                <?php } else { ?>
                <tr valign="top">
                <td colspan="2">
                
                <ul class="list-2">
                  <li>
                  <div class="input-field2">
                  <div class="submit-btn fl">
                      <span>
                        <span>
                        <a href="javascript:void(0);" onClick="return order_checkout_result();"><img src="images/checkout.jpg" /></a>
                        
                        </span>
                      </span> 
                    </div>
                   
                  </div>
                  <div class="cl"></div>
                </li>
                </ul>
                </td>
                </tr>
                <?php } ?>
                   
            </table>
            </td>
           
            <td width="5%"></td>
            
            <td width="45%"></td>
            </tr>
            </form>
            
            </table>
          </div>
        </div>
      </div>
      <div class="cor_1set-3"></div>
      <div class="cor_1set-4"></div>
    </div>
    <?php if($_SESSION['SESS_ID']!='') { ?>
<?php include"footer-div.inc.php"; ?>
<?php } ?>
  </div>
</div>
<!-- FOOTER -->
<?php include "footer.inc.php"; ?>
<!-- //FOOTER -->
</body>
</html>
