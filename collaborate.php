<?php 
require_once "config/functions.inc.php";
require_once "session.inc.php"; 
$pageName = basename($_SERVER['PHP_SELF']); 

if($_POST['Submit']== 'Save')
{
	@extract($_POST);
	$sql = "SELECT * FROM member_account_master WHERE Email = '$Email' AND Collaborate_Id ='".$_SESSION['SESS_ID']."'";
	$result = mysql_query($sql) or die('<br>'.$sql.'<br>'.mysql_error());
	if($Email=='' && $First_Name=='')
	{
	$_SESSION['SESS_MSG'] =  "Email, First Name is Required.";
	header("Location: ". $_SERVER['HTTP_REFERER']);
	exit;
	}
	else
	{
	if(mysql_num_rows($result)>0)
	{
		$_SESSION['SESS_MSG'] = "Eamil Already Exist.";
	}
	else
	{
		$password = range("Z", "A", 2).substr(rand(1, 1000000),0,4);
		
		$sql = "INSERT INTO member_account_master SET
				Collaborate_Id = '".$_SESSION['SESS_ID']."', 
				Email = '".addslashes(trim($Email))."',
				Password = '".base64_encode(addslashes(trim($password)))."',
				First_Name = '".addslashes(trim($First_Name))."',
				Last_Name = '".addslashes(trim($Last_Name))."',
				Show_Profile = 'show',
				Date = now(),
				Account_Type ='Collaborate',
				Status = 1";
		$result = mysql_query($sql) or die('<br>'.$sql.'<br>'.mysql_error());
		
		
		$SUBJECT = 'Soundslikecash Temporary Password Login';
		$from = "vishwas@worldwebsoftware.com";
		
		$BODY = "Your account information is below. <br><br>Email ID : ".$Email."<br>";
		$BODY = "Temporary Password : ".$password;
		$BODY.= "<br><br>Thanks,";
		$BODY.= "<br>The Soundslikecash Team";

		$HEADER = "From: ".$from." <".$from."> \n";
		$HEADER .= "Reply-To: $Email <$Email>\n";
		$HEADER .= "Content-type: text/html\r\n"; 

	   
		$MAILSEND = @mail($Email, $SUBJECT, $BODY, $HEADER);
	
		
		if(!empty($_FILES['Photo']['name']))
		{
		
			
		list($getname,$getext) = explode(".",$_FILES['Photo']['name']);
		$lastId = mysql_insert_id();
		$create_name = "Image_".$lastId;
		$new_filename = $create_name.".".$getext;
		$upload_path = "products/user_image/".$new_filename;
	
	
		move_uploaded_file($_FILES['Photo']['tmp_name'],$upload_path);
		
		
		$sql_update = "UPDATE member_account_master SET Photo = '$new_filename' WHERE Member_Account_Id = '".$lastId."' AND Collaborate_Id ='".$_SESSION['SESS_ID']."' "; 
		mysql_query($sql_update);
		}
		
		
		$_SESSION['SESS_MSG'] =  "Collaborate has been added.";
		header("Location: ". $_SERVER['HTTP_REFERER']);
		exit;
	}
	}
}


if($_POST['btnSubmit']== 'Delete')
{
	@extract($_POST);
	$arr_id = $_REQUEST['arr_id'];
	
	if(is_array($arr_id))
	{
		$str_id = implode(',', $arr_id);
	}
	if(count($arr_id)>0)
	{
		
		$sql = "SELECT * FROM member_account_master WHERE Member_Account_Id in ($str_id)";
		$result = mysql_query($sql);
		$colles = mysql_fetch_array($result);
		
		
		if($colles['Photo']!='')
		{
		$image_name = $colles['Photo'];
		$path = "products/user_image/";
		$target_path = $path.$image_name;
		unlink($target_path);
		}
		
		$sql = "DELETE FROM member_account_master where Member_Account_Id in ($str_id)";
		mysql_query($sql);
		$_SESSION['MSG'] = count($arr_id). ' Collaborate Deleted';
		header("Location: ". $_SERVER['HTTP_REFERER']);
		exit;
	}
	
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>Collaborate</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="description" content="Default Description">
<meta name="keywords" content="">
<meta name="robots" content="">
<?php include "common.inc.php"; ?>
<script language="javascript">
function checkall(objForm)
{
	len = objForm.elements.length;
	var i=0;
	for( i=0 ; i<len ; i++) 
	{
		if (objForm.elements[i].type=='checkbox') 
		{
			objForm.elements[i].checked=objForm.check_all.checked;
		}
	}
}
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
function showStuff(id) {
		document.getElementById(id).style.display = 'block';
	}
	function hideStuff(id) {
		document.getElementById(id).style.display = 'none';
	}
	
	function doAction()
{
document.form2.action="collaborate.php";
document.form2.submit();
}

function doDeleteAction(form,acurl)
{
	var xx =eval("document."+form);
	var flag=0;
	for (i=0;i<xx.length;i++)
	{
		var el = xx.elements[i];

			if (el.name == "arr_id[]")
			{
				if(el.checked==true)
				{
					flag=10;
				}
			}
	}
	if (flag==10)
	{
		if(confirm("Are you sure you wants to delete contact ?"))
		{
			xx.action=acurl;
			xx.submit();
		}	
	}
	else
	{
		alert("Please select at least one contact.");
		return false;
	}
}
</script>
</head>

<body>
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
              <div class="blue-btn-1"> <span><span><a href="my-profile.php" >My Profile</a></span></span> </div>
              &raquo; Add Collaborate
            </div>
          </div>
        </div>
        <div class="pro-content">
        
        
          
<table width="100%" bgcolor="#ffffff" border="0" bordercolor="#ffffff" cellpadding="1" cellspacing="1">

<tr bgcolor="#151515">
	<td colspan="2" height="26" align='left'><b><a href="#" onclick="return showStuff('ttt');" style="color:#ffffff; cursor:pointer">Add Collaborate</a></b></td>
</tr>
<? if($_SESSION['SESS_MSG']!=''){?>
	<tr>
	<td colspan="2" align="center" class="linksmall-txt-line"><font color="#CC3300"><?=$_SESSION['SESS_MSG']?><? $_SESSION['SESS_MSG'] = '';?></font></td>
	</tr>
	<? }?>
<tr>
	<td colspan="2" align='left' ><table cellpadding="1" cellspacing="1" border="0" width="100%">
	<tr>
	<td colspan="2" align="left" id="ttt"  style="display:none;">
    <form name="form2" id="form2" method="post" action="" enctype="multipart/form-data" onSubmit="return validate_form()">
	
	  <table cellspacing="1" cellpadding="1" border="0" width="100%">
	  
	  
		<tr bgcolor="#eeeeee" height="26">
			<td width="40%" align="left" class="linksmall-txt-line">Email</td>
			<td width="3%" align="left" class="linksmall-txt-line">:</td>
			<td width="57%" align="left"><input type="text" name="Email" id="Email" class="list-box"></td>
			
		  </tr>
		<tr bgcolor="#eeeeee" height="26">
			<td width="40%" align="left" class="linksmall-txt-line">First Name</td>
			<td width="3%" align="left" class="linksmall-txt-line">:</td>
			<td width="57%" align="left"><input type="text" name="First_Name" id="First_Name" class="list-box"></td>
			
		  </tr>
		<tr bgcolor="#eeeeee" height="26">
			<td width="40%" align="left" class="linksmall-txt-line">Last Name</td>
			<td width="3%" align="left" class="linksmall-txt-line">:</td>
			<td width="57%" align="left"><input type="text" name="Last_Name" id="Last_Name" class="list-box"></td>
			
		  </tr>
          
          
		  <tr bgcolor="#eeeeee" height="26">
			<td width="40%" align="left" class="linksmall-txt-line">Photo</td>
			<td width="3%" align="left" class="linksmall-txt-line">:</td>
           <td width="57%" align="left"><input type="file" name="Photo" id="Photo" class="input-text" size="30" onChange="validateFileExtension1234(this)"><br /><span style="font-family:Arial, Helvetica, sans-serif; font-size:11px; color:#25A6D5">[ only upload png, gif, jpg, jpeg ]</span></td>
			
		  </tr>
		  
		  		
		<tr height="26">
			<td width="40%" align="left">&nbsp;</td>
			<td width="3%" align="left">&nbsp;</td>
			<td width="57%" align="left" valign="bottom"><a href="#" onClick="return doAction();" class="linksmall-txt"><img src="images/save.jpg" width="41" height="18" border="0"></a>
			
			<input type="hidden" name="Submit" value="Save" class="bot-box4">
			&nbsp;
			<a href="#" onClick="return hideStuff('ttt');" class="linksmall-txt"><img src="images/cancel.jpg" width="72" height="18" border="0"></a>
			 </td>
			
		  </tr>
          
	</table>
	</form></td>
</tr>
	</table></td>
</tr>


<tr bgcolor="#151515">
	<td colspan="2" height="26" align='center' class="linksmall-txt-line" style="color:#ffffff;"><b>Collaborate List &raquo;</b></td>
</tr>


<tr>
	<td colspan="2" align='left'>
	<form action="<?php echo $_SERVER['PHP_SELF']?>" method="POST"  name="form1">
	<table cellspacing="1" cellpadding="1" border="0" width="100%">
	
	<? if($_SESSION['MSG']!=''){?>
	<tr>
	<td colspan="3" align="center" class="collecton-txt"><font color="#CC3300"><?=$_SESSION['MSG']?><? $_SESSION['MSG'] = '';?></font></td>
	</tr>
	<? }?>
	
	<tr height="26" bgcolor="#151515">
	<td width="10%"  style="color:#ffffff;"><b><input name="check_all" type="checkbox" id="check_all" value="check_all" onClick="checkall(this.form)">All</b></td>
    <td width="20%"  style="color:#ffffff;"><b>Photo</b></td>
	<td width="20%" style="color:#ffffff;"><b>First Name</b></td>
	<td width="20%"  style="color:#ffffff;"><b>Last Name</b></td>
	<td width="30%" style="color:#ffffff;"><b>Email</b></td>
	</tr>
	<?php
	$k=0;
	$sql = "SELECT * FROM member_account_master WHERE Status=1 AND Collaborate_Id ='".$_SESSION['SESS_ID']."' AND Account_Type='Collaborate' ORDER BY First_Name,Last_Name";
	$res = mysql_query($sql) or die('<br>'.$sql.'<br>'.mysql_error());
	if(mysql_num_rows($res)>0)
	{
	while($line=mysql_fetch_array($res))
	{
	$bgcolor = ($k%2==0? '#FFFFFF': '#FFFFFF');
	?>
	<tr bgcolor="<?php echo $bgcolor?>">
	<td width="10%"><input type="checkbox" name="arr_id[]" id="arr_id" value="<?php echo $line['Member_Account_Id']?>"></td>
    <td width="20%" class="linksmall-txt-line">
    <?php if(file_exists("products/user_image/$line[Photo]") && $line['Photo']!='') { ?>
    <img src="products/user_image/<?php echo $line['Photo']; ?>" border="0" width="60" height="60"  />
    <?php } else { ?>
    <img src="images/no-image.gif" border="0" width="60" height="60" />
    <?php } ?>
    </td>
	<td width="20%" class="linksmall-txt-line"><?php echo $line['First_Name']; ?></td>
	<td width="20%" class="linksmall-txt-line"><?php echo $line['Last_Name']; ?></td>
	<td width="30%" class="linksmall-txt-line"><?php echo $line['Email']; ?></td>
	</tr>
	<?php
	$k++;
	}
	}
	else
	{ 
	echo "<td colspan='3' class='linksmall-txt-line' align='center'>sorry, no record(s).</td>";
	}
	?>
	
	<?php if(mysql_num_rows($res)>0) { ?>
	<tr height="26">
	
	<td width="40%" colspan="4" align="left"><a href="#" onClick="return doDeleteAction('form1','collaborate.php');" class="linksmall-txt"><img src="images/delete.jpg" width="72" height="18" border="0"></a><input type="hidden" name="btnSubmit" value="Delete" class="bot-box4">			
	
	</td>
	</tr>
	<?php } ?>
	</table>
	</form>
	</td>
</tr>
</table>
                  
            
          
          </div>
       <div class="cl"></div>
       
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