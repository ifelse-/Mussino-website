<?php 
include("../config/functions.inc.php");
include("session.inc.php");

$list_page ='member-list.php';
$head_page ='member.php';

$sql_country = "SELECT Country_Id, Country_Name FROM country_master WHERE Status=1 ORDER BY Country_Name";
$result_country = mysql_query($sql_country) or die('<br>'.$sql_country.'<br>'.mysql_error());

$sql = "SELECT * FROM member_account_master WHERE Member_Account_Id='".$_GET['id']."'";
$result = mysql_query($sql);
$colles = mysql_fetch_array($result);
if($_POST['buttonSubmit']=='Submit')
{
	$imageStatus = Get_Single_Field("member_account_master","Photo","Member_Account_Id","$_GET[id]");
	
		
	
	if(!empty($_FILES['Photo']['name']))
	{
	
	if($imageStatus!='')
	{
	$image_name = $imageStatus;
	$path = "../products/user_image/";
	$target_path = $path.$image_name;
	unlink($target_path);
	}
	
	
	
	list($getname,$getext) = explode(".",$_FILES['Photo']['name']);
	$lastId = $_GET['id'];
	$create_name = "Image_".$lastId;
	$new_filename = $create_name.".".$getext;
	$upload_path = "../products/user_image/".$new_filename;
	
	
	move_uploaded_file($_FILES['Photo']['tmp_name'],$upload_path);
	
	
	$sql_update = "UPDATE member_account_master SET Photo = '$new_filename' WHERE Member_Account_Id = '".$_GET['id']."' "; 
	mysql_query($sql_update);
		
	
	$_SESSION['sess_mess1'] =  "Photo Updated";
	header("location:".$_SERVER['HTTP_REFERER']);
	exit;
	}
	else
	{
	$_SESSION['sess_mess1'] =  "Photo Field Empty";
	header("location: ".$_SERVER['HTTP_REFERER']);
	exit;
	}
	
	

}


if(isset($_REQUEST['submit']) && $_POST['buttonSubmit']=='')
{ 

  @extract($_POST);
  @extract($_REQUEST);
  $Email = addslashes($Email);
    
  if($_REQUEST['id']!='')
	{
		        
			
			    if($_REQUEST['Email']=='')
				{
				$_SESSION['sess_mess'] = "Please Enter Email ID";
				}
				elseif(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$",$_REQUEST['Email']))
				{
				$_SESSION['sess_mess'] = "Invalid Email ID";
				}
				elseif($_REQUEST['Password']=='')
				{
				$_SESSION['sess_mess'] = "Please Enter Password";	
				} 
				elseif($_REQUEST['ConfirmPassword']=='')
				{
				$_SESSION['sess_mess'] = "Please Enter Confirm Password";	
				}	
				elseif($_REQUEST['Password']!=$_REQUEST['ConfirmPassword'])
				{
				$_SESSION['sess_mess'] = "Password Mis-Match";	
				}
				elseif($_REQUEST['First_Name']=='')
				{
				$_SESSION['sess_mess'] = "Please Enter First Name";	
				}
				elseif($_REQUEST['Account_Type']=='')
				{
				$_SESSION['sess_mess'] = "Please Select Member Type";	
				}
				
				else
				{
				$sql = "SELECT * FROM member_account_master WHERE Email = '$Email'  AND Member_Account_Id !='".$_REQUEST['id']."'";
				$result = mysql_query($sql) or die('<br>'.$sql.'<br>'.mysql_error());
				if(mysql_num_rows($result)>0)
				{
					$_SESSION['sess_mess'] = "Member email already exist";
					header("location: ". $head_page."?id=".$_REQUEST['id']);
					exit;
				}
				else
				{	
			     
				if($_REQUEST['City_Id']=='999999') { $city = $_REQUEST['City']; } else { $city = '';}
				 
				$sql = "UPDATE member_account_master SET 
						Email = '".addslashes(trim($_REQUEST['Email']))."',
						Paypal_Email = '".addslashes(trim($_REQUEST['Paypal_Email']))."',
						Password = '".base64_encode(addslashes(trim($_REQUEST['Password'])))."',
						First_Name = '".addslashes(trim($_REQUEST['First_Name']))."',
						Last_Name = '".addslashes(trim($_REQUEST['Last_Name']))."',
						Address = '".addslashes(trim($_REQUEST['Address']))."',
						Country_Id = '".trim($_REQUEST['Country_Id'])."',
						State_Id = '".trim($_REQUEST['State_Id'])."',
						City_Id = '".trim($_REQUEST['City_Id'])."',
						Other_City = '".trim($city)."',
						Phone = '".trim($_REQUEST['Phone'])."',
						Zip = '".trim($_REQUEST['Zip'])."',
						Account_Type = '".trim($_REQUEST['Account_Type'])."',
						Status = '$Status'
						WHERE Member_Account_Id = '".$_REQUEST['id']."'";
				$result = mysql_query($sql) or die('<br>'.$sql.'<br>'.mysql_error());
				$_SESSION['sess_mess'] = "Member email updated successfully.";
				header("location: ". $list_page);
				exit;
				}
		}
	}
	else
	{
		
			    
			
				if($_REQUEST['Email']=='')
				{
				$_SESSION['sess_mess'] = "Please Enter Email ID";
				}
				elseif(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$",$_REQUEST['Email']))
				{
				$_SESSION['sess_mess'] = "Invalid Email ID";
				}
				elseif($_REQUEST['Password']=='')
				{
				$_SESSION['sess_mess'] = "Please Enter Password";	
				} 
				elseif($_REQUEST['ConfirmPassword']=='')
				{
				$_SESSION['sess_mess'] = "Please Enter Confirm Password";	
				}	
				elseif($_REQUEST['Password']!=$_REQUEST['ConfirmPassword'])
				{
				$_SESSION['sess_mess'] = "Password Mis-Match";	
				}
				elseif($_REQUEST['First_Name']=='')
				{
				$_SESSION['sess_mess'] = "Please Enter First Name";	
				}
				elseif($_REQUEST['Account_Type']=='')
				{
				$_SESSION['sess_mess'] = "Please Select Member Type";	
				}
								
				else
				{
				$sql = "SELECT * FROM member_account_master WHERE Email = '$Email'  ";
				$result = mysql_query($sql) or die('<br>'.$sql.'<br>'.mysql_error());
				if(mysql_num_rows($result)>0)
				{
					$_SESSION['sess_mess'] = "Member email already exist";
					header("location: ". $head_page);
					exit;
				}
				else
				{
				$sql = "INSERT INTO member_account_master SET
						Email = '".addslashes(trim($_REQUEST['Email']))."',
						Paypal_Email = '".addslashes(trim($_REQUEST['Paypal_Email']))."',
						Password = '".base64_encode(addslashes(trim($_REQUEST['Password'])))."',
						First_Name = '".addslashes(trim($_REQUEST['First_Name']))."',
						Last_Name = '".addslashes(trim($_REQUEST['Last_Name']))."',
						Address = '".addslashes(trim($_REQUEST['Address']))."',
						Country_Id = '".trim($_REQUEST['Country_Id'])."',
						State_Id = '".trim($_REQUEST['State_Id'])."',
						City_Id = '".trim($_REQUEST['City_Id'])."',
						Other_City = '".addslashes($City)."',
						Phone = '".trim($_REQUEST['Phone'])."',
						Zip = '".trim($_REQUEST['Zip'])."',
						Account_Type = '".trim($_REQUEST['Account_Type'])."',
						Date = now(),
						Status = '$Status'";
				$result = mysql_query($sql) or die('<br>'.$sql.'<br>'.mysql_error());
				
				if($City_Id==999999 && $City!='')
				{
					$sql_city = "SELECT * FROM city_master WHERE Country_Id='".$Country_Id."' AND State_Id = '".$State_Id."' AND City_Name LIKE '%".$City."%'";
					$result_city = mysql_query($sql_city);
					if(mysql_num_rows($result_city)==0)
					{
							$sql_ins_city = "INSERT INTO city_master SET
											 Country_Id = '".trim($Country_Id)."',
											 State_Id = '".trim($State_Id)."',
											 City_Name = '".addslashes($City)."',
											 Status = '1'";
						
							$result_ins_city = mysql_query($sql_ins_city) or die('<br>'.$sql_ins_city.'<br>'.mysql_error());
					}
				}
				
				
				$_SESSION['sess_mess'] =  "Member record successfully added";
				
				header("location: ". $list_page);
				exit;
				}
			}
		
	}
  
	
}


if($_GET['id']!='')
{
$sql = "SELECT * FROM member_account_master WHERE Member_Account_Id ='".$_GET['id']."'";
$result = mysql_query($sql) or die('<br>'.$sql.'<br>'.mysql_error());
$dataColles = mysql_fetch_array($result);
$sql_state = "SELECT State_Id, State_Name  FROM state_master WHERE Status=1 AND Country_Id='".$dataColles['Country_Id']."'";
$result_state = mysql_query($sql_state) or die('<br>'.$sql_state.'<br>'.mysql_error());
$sql_city = "SELECT City_Id, City_Name FROM city_master WHERE Status=1 AND State_Id='".$dataColles['State_Id']."'";
$result_city = mysql_query($sql_city) or die('<br>'.$sql_city.'<br>'.mysql_error());
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Administrator</title>
<link href="css/layout-admin.css" rel="stylesheet" type="text/css" />
<link href="css/css.css" rel="stylesheet" type="text/css">
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
	 
	var Country_Id = document.frmRegistration.Country_Id.value;
	
	httpobj.open('get',"ajax-country_to_state_main.php?Country_Id="+Country_Id);
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
	 
	var State_Id = document.frmRegistration.State_Id.value;
	
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


</script>
<script language="javascript">
function validateFileExtension1234(fld) 
	{

		if(!/(\.png|\.gif|\.jpg|\.jpeg)$/i.test(fld.value)) 
		{
		alert("Invalid image file type.");
		fld.form.reset();
		fld.focus();
		return false;
		}
		return true;
	}
function show_other_city_box(id)
{
	
	if(id=='other_city_id')
	{
	document.getElementById('other_city_id').style.visibility = 'visible';
	}
	else
	{
	document.getElementById('other_city_id').style.visibility = 'hidden';
	}

}  
</script>
</head>

<body>
<div id="wrapper">
  <div class="header-container">
   <? include"header.inc.php"?> 
  
  </div>
  <div class="content-container">
    <div class="left-navigation fl">
      <div class="left-navigation_inner">
        <? require_once "left.inc.php"; ?>
      </div>
    </div>
    <div class="detail-col fr">
      <div class="detail-col_inner">
       
       <div class="box-1">
       <h2> Member <?=$_GET['id']!='' ? 'Edit' : 'Add';?></h2>
       <?php if($_GET['id']!='') { ?>
       <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table-1">
      
        
       	<tr>
            <td width="200" align="center">
			<?php if(file_exists("../products/user_image/$colles[Photo]") && $colles['Photo']!='') { ?>
            <img src="../products/user_image/<?php echo $colles['Photo']; ?>" border="0" width="100" height="150" />
            <?php } else { ?>
            <img src="../images/no-image.gif" border="0" width="100" height="150" />
            <?php } ?>
            </td>  
            <td valign="middle" align="center"><table width="100%" cellspacing="0" cellpadding="0">
                    <form id="frmChangeImage" name="frmChangeImage" enctype="multipart/form-data" method="post" action="">
                    <table width="60%" cellspacing="2" cellpadding="2">
                    
                    
                    
                    <?php if($_SESSION["sess_mess1"]!='') { ?>
                    <tr valign="top">
                    <td colspan="2"><?=$_SESSION["sess_mess1"]?> <? $_SESSION["sess_mess1"]='';?></td>
                    </tr>
                    <?php } ?>
                    
                    <tr valign="top">
                    <td width="40%">Photo </td>
                    <td width="60%"><input type="file" name="Photo" id="Photo" class="input-text" size="30" onChange="validateFileExtension1234(this)"><br /><span style="font-family:Arial, Helvetica, sans-serif; font-size:11px; color:#25A6D5">[ only upload png, gif, jpg, jpeg ]</span></td>
                    </tr>
                    
                                        
                    <tr>
                    <td width="40%">&nbsp; </td>
                    <td width="60%"><input name="buttonSubmit" type="submit" value="Submit" class="form-button" ></td>
                    </tr>
                    
                    </table>  
                    </form>	
                   
                  </table></td>      
        </tr>
       </table>
       <?php } ?>
       <form name="frmRegistration" id="frmRegistration" action="<?=$PHP_SELF?>" method="POST" >
       <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table-1">
          <?
          if($_SESSION['sess_mess']!='') {
          ?>
          <tr>
            <td align="left" valign="middle" colspan="2" >
             <?=$_SESSION['sess_mess']?><? $_SESSION['sess_mess']="";?>         
            </td>
            </tr>
        <? } ?>
          <tr>
            <td width="200" align="left" valign="middle">Email ID </td>
            <td align="left" valign="top" class="input-1"><input type="text" name="Email" value="<?=stripslashes(trim($dataColles['Email']));?>"  size="50" class="textbox"></td>
          </tr>
          
          <tr>
            <td width="200" align="left" valign="middle">Password</td>
            <td align="left" valign="top" class="input-1"><input type="<?=$_GET['id']==''?'password':'text';?>" name="Password" value="<?=base64_decode($dataColles['Password']);?>"  size="50" class="textbox"></td>
          </tr>
          
          <tr>
            <td width="200" align="left" valign="middle">Confirm Password</td>
            <td align="left" valign="top" class="input-1"><input type="<?=$_GET['id']==''?password:text;?>" name="ConfirmPassword" value="<?=base64_decode($dataColles['Password']);?>"  size="50" class="textbox"></td>
          </tr>
          
          <tr>
            <td width="200" align="left" valign="middle">First Name </td>
            <td align="left" valign="top" class="input-1"><input type="text" name="First_Name" value="<?=stripslashes(trim($dataColles['First_Name']));?>"  size="50" class="textbox"></td>
          </tr>
          
          <tr>
            <td width="200" align="left" valign="middle">Last Name  </td>
            <td align="left" valign="top" class="input-1"><input type="text" name="Last_Name" value="<?=stripslashes(trim($dataColles['Last_Name']));?>"  size="50" class="textbox"></td>
          </tr>
          
          <tr>
            <td width="200" align="left" valign="middle">Address </td>
            <td align="left" valign="top" class="input-1"><textarea name="Address" rows="4" cols="27"  class="input-text" ><?=stripslashes(trim($dataColles['Address']));?></textarea></td>
          </tr>
          
          <tr>
            <td width="200" align="left" valign="middle">Country </td>
            <td align="left" valign="top" class="input-1"><select name="Country_Id" style="width:210px;" onchange="show_country_to_state()" class="input-text" >
                <option value="">Select</option>
                <?php
				while($colles_country = mysql_fetch_array($result_country))
				{
				?>
				<option value="<?=$colles_country['Country_Id']?>" <?php if($colles_country['Country_Id']==$dataColles['Country_Id']) { echo 'selected'; } ?>><?=stripslashes($colles_country['Country_Name'])?></option>
				<?php
				}
				?>
                </select></td>
          </tr>
          
          <tr>
            <td width="200" align="left" valign="middle">State </td>
            <td align="left" valign="top" class="input-1" id="view_state_result"><select name="State_Id" style="width:210px;" class="input-text">
                <option value="">Select</option>
                 <?php
					if($dataColles['Country_Id']!='')
					{
                    while($colles_state = mysql_fetch_array($result_state))
                    {
                    ?>
                    <option value="<?=$colles_state['State_Id']?>" <?php if($colles_state['State_Id']==$dataColles['State_Id']) { echo 'selected'; } ?> ><?=stripslashes($colles_state['State_Name'])?></option>
                    <?php
                    }
					}
                    ?>
                    
                </select></td>
          </tr>
          
          <tr>
            <td width="200" align="left" valign="middle">City </td>
            <td align="left" valign="top" class="input-1" id="view_city_result"><select name="City_Id" style="width:210px;" class="input-text" >
                <option value="">Select</option>
                <?php
					if($dataColles['State_Id']!='')
					{
                    while($colles_city = mysql_fetch_array($result_city))
                    {
                    ?>
                    <option onClick="return show_other_city_box('<?=$colles_city['City_Id']?>');" value="<?=$colles_city['City_Id']?>" <?php if($colles_city['City_Id']==$dataColles['City_Id']) { echo 'selected'; } ?> ><?=stripslashes($colles_city['City_Name'])?></option>
                    <?php
                    }
					}
                    ?>
                    <option value="999999" onClick="return show_other_city_box('other_city_id');" <?php if('999999'==$dataColles['City_Id']) { echo 'selected'; } ?>>Other City</option>
                </select></td>
          </tr>
          
          <tr id="other_city_id" <?php if('999999'!=$dataColles['City_Id']) { ?> style=" visibility:hidden;" <?php } ?>>
            <td width="200" align="left" valign="middle">Other City</td>
            <td align="left" valign="top" class="input-1"><input type="text" name="City" value="<?=trim($dataColles['Other_City']);?>"  size="50" class="textbox"></td>
          </tr>
          
          <tr>
            <td width="200" align="left" valign="middle">Zip Code </td>
            <td align="left" valign="top" class="input-1"><input type="text" name="Zip" value="<?=trim($dataColles['Zip']);?>"  size="50" class="textbox"></td>
          </tr>
          
           <tr>
            <td width="200" align="left" valign="middle">Phone </td>
            <td align="left" valign="top" class="input-1"><input type="text" name="Phone" value="<?=trim($dataColles['Phone']);?>"  size="50" class="textbox"></td>
          </tr>
          
           <tr>
            <td width="200" align="left" valign="middle">Member Type </td>
            <td align="left" valign="top" class="input-1">
             <select name="Account_Type" style="width:210px;" class="input-text" >
                <option value="">Select</option>
                <option value="Artist" <? if($dataColles['Account_Type']=='Artist') { echo "SELECTED";}?>>Artist</option>
                <option value="Contest Judge" <? if($dataColles['Account_Type']=='Contest Judge') { echo "SELECTED";}?>>Contest Judge</option>
                <option value="Musician" <? if($dataColles['Account_Type']=='Musician') { echo "SELECTED";}?>>Musician</option>
                </select>
            </td>
          </tr>
          
          <tr>
            <td width="200" align="left" valign="middle">Paypal Email </td>
            <td align="left" valign="top" class="input-1"><input type="text" name="Paypal_Email" value="<?=trim($dataColles['Paypal_Email']);?>"  size="50" class="textbox"></td>
          </tr>
          
          <tr>
            <td align="left" valign="middle">Status</td>
            <td align="left" valign="top" class="input-1">
              <select name="Status" size="1" class="textbox">
                  <option value="1" <? if($dataColles['Status']=='1') { echo "SELECTED";}?>>Active</option>
                  <option value="0" <? if($dataColles['Status']=='0') { echo "SELECTED";}?>>Inactive</option>
                </select>
            </td>
          </tr>
          <tr>
            <td align="left" valign="middle"><input type="hidden" name="id" value="<?=$dataColles['Member_Account_Id'];?>" /></td>
            <td align="left" valign="top" class="input-2"><input type="submit" name="submit" value="<?php if($_REQUEST['id']!='') { echo 'Update'; } else { echo'Insert Record'; }?>"  class="buttons" /></td>
          </tr>
        </table>
       
       
        </form></div>
      </div>
    </div>
    <div class="cl"></div>
  </div>
  <? include"footer.inc.php"?>
</div>

</body>
</html>
