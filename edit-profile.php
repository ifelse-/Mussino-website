<?php 
require_once "config/functions.inc.php"; 
require_once "session.inc.php"; 
$pageName = basename($_SERVER['PHP_SELF']);
$sql = "SELECT * FROM member_account_master WHERE Member_Account_Id='".$_SESSION['SESS_ID']."'";
$result = mysql_query($sql);
$colles = mysql_fetch_array($result);
$sql_country = "SELECT Country_Id, Country_Name FROM country_master WHERE Status=1 ORDER BY Country_Name";
$result_country = mysql_query($sql_country) or die('<br>'.$sql_country.'<br>'.mysql_error());
$sql_state = "SELECT State_Id, State_Name  FROM state_master WHERE Status=1 AND Country_Id='".$colles['Country_Id']."'";
$result_state = mysql_query($sql_state) or die('<br>'.$sql_state.'<br>'.mysql_error());
$sql_city = "SELECT City_Id, City_Name FROM city_master WHERE Status=1 AND State_Id='".$colles['State_Id']."'";
$result_city = mysql_query($sql_city) or die('<br>'.$sql_city.'<br>'.mysql_error());
#####################################################

if($_SESSION['SESS_ACCOUNT_TYPE']=='Artist')
{
$sql_artist_membership_check = "SELECT * FROM membership_artist_upgrade_history_master WHERE Member_Account_Id='".$_SESSION['SESS_ID']."' AND Status=1";
$result_artist_membership_check = mysql_query($sql_artist_membership_check);
					
$sql_artist_membership_check1 = "SELECT * FROM membership_artist_upgrade_history_master WHERE Member_Account_Id='".$_SESSION['SESS_ID']."' AND Status=0";
$result_artist_membership_check1 = mysql_query($sql_artist_membership_check1);
}

if($_SESSION['SESS_ACCOUNT_TYPE']=='Musician')
{
$sqlMusicianCount = "SELECT COUNT(*) AS CMusicianTotal FROM product_master WHERE Member_Account_Id='".$_SESSION['SESS_ID']."' ";
$resMusicianCount = mysql_query($sqlMusicianCount);
$collesMusicianCount = mysql_fetch_array($resMusicianCount);

if($_SESSION['SESS_ACCOUNT_TYPE']=='Musician') {
$sql_membership_check = "SELECT * FROM membership_upgrade_history_master WHERE Member_Account_Id='".$_SESSION['SESS_ID']."' AND Status=1";
$result_membership_check = mysql_query($sql_membership_check);

$sql_membership_check1 = "SELECT * FROM membership_upgrade_history_master WHERE Member_Account_Id='".$_SESSION['SESS_ID']."' AND Status=0";
$result_membership_check1 = mysql_query($sql_membership_check1);

if(mysql_num_rows($result_membership_check)>0)
{

		$sql_credits = "SELECT sum(b.Membership_No+5) as notesTotal FROM membership_upgrade_master a JOIN membership_upgrade_history_master b ON (a.Membership_Upgrade_Id=b.Membership_Upgrade_Id) WHERE a.Status='1' AND b.Status='1' AND b.Member_Account_Id='".$_SESSION['SESS_ID']."'";
		$result_credits = mysql_query($sql_credits);
		$colles_credits = mysql_fetch_array($result_credits);
		$CREDITS_NOTES = $colles_credits['notesTotal'];
		if($CREDITS_NOTES=='')
		{
		$TOTAL_CREDITS_NOTES = 0;
		}
		else
		{
		$collesMusicianCount['CMusicianTotal'];
		$TOTAL_CREDITS_NOTES = $CREDITS_NOTES-$collesMusicianCount['CMusicianTotal'];
		}
}
elseif(mysql_num_rows($result_membership_check1)>0)
{

		$sql_credits = "SELECT sum(b.Membership_No+5) as notesTotal FROM membership_upgrade_master a JOIN membership_upgrade_history_master b ON (a.Membership_Upgrade_Id=b.Membership_Upgrade_Id) WHERE a.Status='1' AND b.Status='1' AND b.Member_Account_Id='".$_SESSION['SESS_ID']."'";
		$result_credits = mysql_query($sql_credits);
		$colles_credits = mysql_fetch_array($result_credits);
		$CREDITS_NOTES = $colles_credits['notesTotal'];
		if($CREDITS_NOTES=='')
		{
		$TOTAL_CREDITS_NOTES = 0;
		}
		else
		{
		$collesMusicianCount['CMusicianTotal'];
		$TOTAL_CREDITS_NOTES = $CREDITS_NOTES-$collesMusicianCount['CMusicianTotal'];
		}
}
else
{
$TOTAL_CREDITS_NOTES = 5-$collesMusicianCount['CMusicianTotal'];;
}
}
}
###############################
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>Profile</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="description" content="Default Description">
<meta name="keywords" content="">
<meta name="robots" content="">
<?php include "common.inc.php"; ?>
<script language="javascript">
	
function createObject(){
  if(window.XMLHttpRequest){
    var obj	= new XMLHttpRequest();
  }else{
    var obj	= new ActiveXObject('Microsoft.XMLHTTP');
  }
 return obj;
}  
var httpobj	= createObject();

function show_country_to_state(){ 
	
	 document.getElementById('view_state_result').innerHTML ='<img src="images/loading.gif" alt="" />'; 
	 
	var Country_Id = document.getElementById('Country_Id').value;
	
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

function edit_registration(){ 
	
    document.getElementById('view_edit_registration_id').innerHTML ='<img src="images/loading.gif" alt="" />';
	
	
	var Email = document.frmEditRegistration.Email.value;    
	var First_Name = document.frmEditRegistration.First_Name.value;
	var Last_Name = document.frmEditRegistration.Last_Name.value;
	var Country_Id = document.frmEditRegistration.Country_Id.value;
	var State_Id = document.getElementById('State_Id').value;
	var City_Id = document.frmEditRegistration.City_Id.value;
	var City = document.frmEditRegistration.City.value;
	var Address = document.frmEditRegistration.Address.value;
		Address = Address.replace('#',"");
		Address = Address.replace('&',"");
	var Paypal_Email = document.frmEditRegistration.Paypal_Email.value;		
	var	About_Me = document.frmEditRegistration.About_Me.value;
	    About_Me = About_Me.replace('#',"");
		About_Me = About_Me.replace('&',"");
	var Zip = document.frmEditRegistration.Zip.value;
	var Phone = document.frmEditRegistration.Phone.value;
	
	var map_location = $("#map_location_id").val();
	var map_location_city = $("#map_location_city_id").val();
	var map_location_city_lat = $("#map_location_city_lat_id").val();
	var map_location_city_lng = $("#map_location_city_lng_id").val();
	
	
	if(document.getElementById('Personal_Msg').checked== true)
	{
	var Personal_Msg = 1;
	}
	else
	{
	var Personal_Msg = 0;
	}
	
	if(document.getElementById('Session_Email').checked== true)
	{
	var Session_Email = 1;
	}
	else
	{
	var Session_Email = 0;
	}
	if(document.getElementById('News_Letter').checked== true)
	{
	var News_Letter = 1;
	}
	else
	{
	var News_Letter = 0;
	}
	
	var locationstr = "&map_location="+map_location+"&map_location_city="+map_location_city+"&map_location_city_lat="+map_location_city_lat+"&map_location_city_lng="+map_location_city_lng;
	httpobj.open('get',"ajax-profile-request.php?Email="+Email+"&First_Name="+First_Name+"&Last_Name="+Last_Name+"&Country_Id="+Country_Id+"&State_Id="+State_Id+"&City_Id="+City_Id+"&Address="+Address+"&Zip="+Zip+"&Phone="+Phone+"&About_Me="+About_Me+"&Paypal_Email="+Paypal_Email+"&City="+City+"&Personal_Msg="+Personal_Msg+"&Session_Email="+Session_Email+"&News_Letter="+News_Letter+locationstr);
	httpobj.onreadystatechange	= handleEditRegistrationResponse;
	httpobj.send("");

}
function handleEditRegistrationResponse(){

	 if(httpobj.readyState==4)
	 {
		 var text = httpobj.responseText;
		 
		 if(text=="<span style='color:#00FF00'>Profile Updated</span>")
		 {
		 location.replace('my-profile.php');
		 }
		 else
		 {
		 document.getElementById('view_edit_registration_id').innerHTML = text;
		 }
		 
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
<!-- HEADER -->
<?php include "header.middle.inc.php"; ?>
<div id="wrapper">
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
                            <div class="blue-btn-1"> <span><span><a href="<?=SITE_WS_PATH?>/<?=trim($_SESSION['SESS_ID'])?>/<?=$_SESSION['SESS_FIRST_NAME']?>" >My Profile</a></span></span> </div>
                            &raquo; Edit Profile </div>
                    </div>
                </div>
                <div class="pro-content">
                    <form id="frmEditRegistration" name="frmEditRegistration"  method="post" action="">
                        <div class="pro-left fl">
                            <div class="user-img"> <a href="<?=SITE_WS_PATH?>/<?=trim($_SESSION['SESS_ID'])?>/<?=$_SESSION['SESS_FIRST_NAME']?>" >
                                <?php if(file_exists("products/user_image/$colles[Photo]") && $colles['Photo']!='') { ?>
                                <img src="products/user_image/<?php echo $colles['Photo']; ?>" border="0" width="100" height="150" />
                                <?php } else { ?>
                                <img src="images/user_big.png" border="0" width="100" height="150" />
                                <?php } ?>
                                </a>
                                <p>
                                    <?=$colles['Account_Type']?>
                                </p>
                            </div>
                            <div class="pro-btn_row">
                                <?php include "left-profile.inc.php"; ?>
                                <?php if($_SESSION['SESS_ACCOUNT_TYPE']=='Musician') { ?>
                                <?php if(mysql_num_rows($result_membership_check)>0) { ?>
                                <div class="nor-btn"><a href="<?=SITE_WS_PATH?>/musician-close-membership.php?st=0"><span>Cancel Membership</span></a></div>
                                <?php } elseif(mysql_num_rows($result_membership_check1)>0) { ?>
                                <div class="nor-btn"><a href="<?=SITE_WS_PATH?>/musician-close-membership.php?st=1"><span>Start Membership</span></a></div>
                                <?php } } ?>
                                <?php if($_SESSION['SESS_ACCOUNT_TYPE']=='Artist') { ?>
                                <?php if(mysql_num_rows($result_artist_membership_check)>0) { ?>
                                <div class="nor-btn"><a href="<?=SITE_WS_PATH?>/artist-close-membership.php?st=0"><span>Cancel Membership</span></a></div>
                                <?php } elseif(mysql_num_rows($result_artist_membership_check1)>0) { ?>
                                <div class="nor-btn"><a href="<?=SITE_WS_PATH?>/artist-close-membership.php?st=1"><span>Start Membership</span></a></div>
                                <?php } } ?>
                            </div>
                        </div>
                        <div class="pro-right3">
                            <div class="form-container">
                                <ul>
                                    <li>
                                        <div id="view_edit_registration_id" class="error"></div>
                                    </li>
                                    <li >
                                        <div class="caption-2">Email Address <font style="color:#FF0000;">*</font></div>
                                        <div class="input-2">
                                            <input type="text" name="Email" size="30" class="input-text textinput"  value="<?=stripslashes($colles['Email'])?>" onkeypress="if(event.keyCode==13) {return edit_registration();}" />
                                        </div>
                                        <div class="cl"></div>
                                    </li>
                                    <li>
                                        <div class="caption-2">Stagename <font style="color:#FF0000;">*</font></div>
                                        <div class="input-2">
                                            <input type="text" name="First_Name" size="30" value="<?=stripslashes($colles['First_Name'])?>" class="input-text textinput"  onkeypress="if(event.keyCode==13) {return edit_registration();}" />
                                        </div>
                                        <div class="cl"></div>
                                    </li>
                                    <li >
                                        <div class="caption-2">Full Name</div>
                                        <div class="input-2">
                                            <input type="text" name="Last_Name" size="30" value="<?=stripslashes($colles['Last_Name'])?>" class="input-text textinput"  onkeypress="if(event.keyCode==13) {return edit_registration();}" />
                                        </div>
                                        <div class="cl"></div>
                                    </li>
                                    <li>
                                        <div class="caption-2">Address</div>
                                        <div class="input-2">
                                            <textarea name="Address" rows="4" cols="27"  class="input-text"  onkeypress="if(event.keyCode==13) {return edit_registration();}"><?=stripslashes($colles['Address'])?>
</textarea>
                                        </div>
                                        <div class="cl"></div>
                                    </li>
                                    <li>
                                        <div class="caption-2">Country</div>
                                        <div class="input-2">
                                            <select name="Country_Id" id="Country_Id"  onchange="show_country_to_state()" class="input-text"  onkeypress="if(event.keyCode==13) {return edit_registration();}">
                                                <option value="">Select</option>
                                                <?php
                    while($colles_country = mysql_fetch_array($result_country))
                    {
                    ?>
                                                <option value="<?=$colles_country['Country_Id']?>" <?php if($colles_country['Country_Id']==$colles['Country_Id']) { echo 'selected'; } ?> >
                                                <?=stripslashes($colles_country['Country_Name'])?>
                                                </option>
                                                <?php
                    }
                    ?>
                                            </select>
                                        </div>
                                        <div class="cl"></div>
                                    </li>
                                    <li>
                                        <div class="caption-2">State</div>
                                        <div class="input-2" id="view_state_result">
                                            <select name="State_Id" id="State_Id"  class="input-text" onkeypress="if(event.keyCode==13) {return edit_registration();}">
                                                <option value="">Select</option>
                                                <?php
					if($colles['Country_Id']!='')
					{
                    while($colles_state = mysql_fetch_array($result_state))
                    {
                    ?>
                                                <option value="<?=$colles_state['State_Id']?>" <?php if($colles_state['State_Id']==$colles['State_Id']) { echo 'selected'; } ?> >
                                                <?=stripslashes($colles_state['State_Name'])?>
                                                </option>
                                                <?php
                    }
					}
                    ?>
                                            </select>
                                        </div>
                                        <div class="cl"></div>
                                    </li>
                                    <li>
                                        <div class="caption-2">City</div>
                                        <div class="input-2" id="view_city_result">
                                            <select name="City_Id" id="City_Id"  class="input-text" onkeypress="if(event.keyCode==13) {return edit_registration();}">
                                                <option value="">Select</option>
                                                <?php
					if($colles['State_Id']!='')
					{
                    while($colles_city = mysql_fetch_array($result_city))
                    {
                    ?>
                                                <option onClick="return show_other_city_box('<?=$colles_city['City_Id']?>');" value="<?=$colles_city['City_Id']?>" <?php if($colles_city['City_Id']==$colles['City_Id']) { echo 'selected'; } ?> >
                                                <?=stripslashes($colles_city['City_Name'])?>
                                                </option>
                                                <?php
                    }
					}
                    ?>
                                                <option value="999999" onClick="return show_other_city_box('other_city_id');" <?php if('999999'==$colles['City_Id']) { echo 'selected'; } ?>>Other City</option>
                                            </select>
                                        </div>
                                        <div class="cl"></div>
                                    </li>
                                    <li  id="other_city_id" <?php if('999999'!=$colles['City_Id']) { ?> style=" display:none" <?php } ?>>
                                        <div class="caption-2">Other City</div>
                                        <div class="input-2">
                                            <input type="text" name="City" value="<?=trim($colles['Other_City']);?>"  size="30" class="input-text textinput" onkeypress="if(event.keyCode==13) {return edit_registration();}">
                                        </div>
                                        <div class="cl"></div>
                                    </li>
                                    <li>
                                        <div class="caption-2">Zip Code</div>
                                        <div class="input-2">
                                            <input type="text" name="Zip" size="30" value="<?=$colles['Zip']?>"  class="input-text textinput" onkeypress="if(event.keyCode==13) {return edit_registration();}"/>
                                        </div>
                                        <div class="cl"></div>
                                    </li>
                                    <li >
                                        <div class="caption-2">Phone</div>
                                        <div class="input-2">
                                            <input type="text" name="Phone" size="30"  value="<?=$colles['Phone']?>" class="input-text textinput" onkeypress="if(event.keyCode==13) {return edit_registration();}"/>
                                        </div>
                                        <div class="cl"></div>
                                    </li>
                                    <li>
                                        <input name="Personal_Msg" id="Personal_Msg"   type="checkbox" <?php if($colles['Personal_Msg']==1) { echo'checked'; } ?>>
                                        &nbsp;Disable personal message &nbsp;
                                        <input name="Session_Email" id="Session_Email"  type="checkbox" <?php if($colles['Session_Email']==1) { echo'checked'; } ?>>
                                        &nbsp;Disable session emails &nbsp;
                                        <input name="News_Letter" id="News_Letter"  type="checkbox" <?php if($colles['News_Letter']==1) { echo'checked'; } ?>>
                                        &nbsp;Disable Subscribe New Letters &nbsp; </li>
                                    <li>
                                        <div class="caption-2">About Me</div>
                                        <div class="input-2">
                                            <textarea name="About_Me"   class="input-text" ><?=stripslashes($colles['About_Me'])?>
</textarea>
                                        </div>
                                        <div class="cl"></div>
                                    </li>
                                    <br />
                                    <div style="font-size:18px; font-weight:bold; color: #F90; padding:15px 0 15px 0;">Mussino can deposit earnings into your paypal account</div>
                                    <li>
                                        <div class="caption-2">Paypal Email</div>
                                        <div class="input-2">
                                            <input type="text" name="Paypal_Email" size="30"  value="<?=$colles['Paypal_Email']?>" class="input-text textinput"  onkeypress="if(event.keyCode==13) {return edit_registration();}"/>
                                        </div>
                                        <div class="cl"></div>
                                    </li>
                                    <br />
                                    <div style="font-size:14px; font-weight:bold; color: #F90; padding:15px 0 15px 0;">Would you like to display your location on homepage google map?</div>
                                    <li>
                                        <div class="caption-2">Your location</div>
                                        <div class="input-2">
											<input id="map_location_id" name="map_location" type="text" size="50" placeholder="<?php echo ($colles['map_location'] == '') ? "Enter a location" : $colles['map_location'];?>" autocomplete="on" runat="server" class="input-text textinput" />  
											<input type="hidden" id="map_location_city_id" name="map_location_city" />
											<input type="hidden" id="map_location_city_lat_id" name="map_location_city_lat" />
											<input type="hidden" id="map_location_city_lng_id" name="map_location_city_lng" />  
										</div>
                                        <div class="cl"></div>
                                    </li>
                                    <li> <br />
                                        <div class="input">
                                            <input name="buttonSubmit" type="button" value="Submit" class="button" onclick="return edit_registration();" onkeypress="if(event.keyCode==13) {return edit_registration();}">
                                        </div>
                                        <div class="cl"></div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="cl"></div>
                    </form>
                </div>
            </div>
            <div class="cor_1set-3"></div>
            <div class="cor_1set-4"></div>
        </div>
    </div>
    <script type="text/javascript">
    function initialize() {
        var input = document.getElementById('map_location_id');
        var autocomplete = new google.maps.places.Autocomplete(input);
        google.maps.event.addListener(autocomplete, 'place_changed', function () {
            var place = autocomplete.getPlace();
            document.getElementById('map_location_city_id').value = place.name;
            document.getElementById('map_location_city_lat_id').value = place.geometry.location.lat();
            document.getElementById('map_location_city_lng_id').value = place.geometry.location.lng();
            //alert("This function is working!");
            //alert(place.name);
           // alert(place.address_components[0].long_name);

        });
    }
    google.maps.event.addDomListener(window, 'load', initialize); 
</script>
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
