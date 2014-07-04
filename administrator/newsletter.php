<?php 
include("../config/functions.inc.php");
include("session.inc.php");
$list_page ='newsletter-list.php';
$head_page ='newsletter.php';
if(isset($_REQUEST['submit']))
{ 

  @extract($_POST);
  @extract($_REQUEST);
  $Subject = addslashes($Subject);
  $Message = addslashes($Message);
    
  if($_REQUEST['id']!='')
	{
		$sql = "SELECT * FROM newsletter WHERE Subject = '$Subject'  AND N_Id !='".$_REQUEST['id']."'";
		$result = mysql_query($sql) or die('<br>'.$sql.'<br>'.mysql_error());
		if(mysql_num_rows($result)>0)
		{
			$_SESSION['sess_mess'] = "Newsletter already exist";
			header("location: ". $head_page."?id=".$_REQUEST['id']);
		    exit;
		}
		else
		{	
			$sql = "UPDATE newsletter SET 
					Subject = '$Subject',
					From_Mail = '$From_Mail',
					Message = '$Message',
					Status = '$Status'
					WHERE N_Id = '".$_REQUEST['id']."'";
			$result = mysql_query($sql) or die('<br>'.$sql.'<br>'.mysql_error());
			$_SESSION['sess_mess'] = "Newsletter updated successfully.";
			header("location: ". $list_page);
			exit;
		}
	}
	else
	{
		
			$sql = "SELECT * FROM newsletter WHERE Subject = '$Subject'  ";
			$result = mysql_query($sql) or die('<br>'.$sql.'<br>'.mysql_error());
			if(mysql_num_rows($result)>0)
			{
				$_SESSION['sess_mess'] = "Newsletter already exist";
				header("location: ". $head_page);
		        exit;
			}
			else
			{
			
				
				$sql = "INSERT INTO newsletter SET
						Subject = '$Subject',
						From_Mail = '$From_Mail',
						Message = '$Message',
						Status = '$Status'";
				$result = mysql_query($sql) or die('<br>'.$sql.'<br>'.mysql_error());
				$_SESSION['sess_mess'] =  "Newsletter successfully added";
				
				header("location: ". $list_page);
				exit;
			}
		
	}
  
	
}


if($_GET['id']!='')
{
$sql = "SELECT * FROM newsletter WHERE N_Id ='".$_GET['id']."'";
$result = mysql_query($sql) or die('<br>'.$sql.'<br>'.mysql_error());
$dataColles = mysql_fetch_array($result);
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Administrator</title>
<link href="css/layout-admin.css" rel="stylesheet" type="text/css" />
<link href="css/css.css" rel="stylesheet" type="text/css">
<script>
function validate_submitsite_form(placeadd) 
{
	if (placeadd.Subject.value == "") 
	{
		alert("\nPlease enter subject.")
		placeadd.Subject.focus();
		return false;
	}
	else if (placeadd.From_Mail.value == "") 
	{
		alert("\nPlease enter From.")
		placeadd.From_Mail.focus();
		return false;
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
       <form name="placeadd" id="placeadd" action="<?=$PHP_SELF?>" method="POST"  onSubmit="return validate_submitsite_form(placeadd)">
       <div class="box-1">
       <h2> Newsletter <?=$_GET['id']!='' ? 'Edit' : 'Add';?></h2>
       <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table-1">
          <?
          if($_SESSION['sess_mess']!='') {
          ?>
          <tr>
            <td align="left" valign="middle" colspan="2" style="padding: 5px 0 5px 210px; font-weight:bolder; color:#666666; font-size:14px;">
             <?=$_SESSION['sess_mess']?><? $_SESSION['sess_mess']="";?>         
            </td>
            </tr>
        <? } ?>
          <tr>
            <td width="200" align="left" valign="middle">Subject</td>
            <td align="left" valign="top" class="input-1"><input type="text" name="Subject" value="<?=stripslashes(trim($dataColles['Subject']));?>"  size="50" class="textbox"></td>
          </tr>
          
          <tr>
            <td width="200" align="left" valign="middle">From</td>
            <td align="left" valign="top" class="input-1"><input type="text" name="From_Mail" value="<?=stripslashes(trim($dataColles['From_Mail']));?>"  size="50" class="textbox"></td>
          </tr>
          
          
           <tr>
            <td width="200" align="left" valign="middle">Message</td>
            <td align="left" valign="top" class="input-1">
			<?php
            include("../FCKeditor/fckeditor.php") ;
            $sBasePath = $_SERVER['PHP_SELF'] ;
            $sBasePath="../FCKeditor/";
            $oFCKeditor = new FCKeditor('Message') ;
            $oFCKeditor->BasePath	= $sBasePath ;
            $oFCKeditor->Height	= 300 ;
            $oFCKeditor->Value		= $dataColles['Message'];
            $oFCKeditor->Create() ;
            ?>     
            
            </td>
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
            <td align="left" valign="middle"><input type="hidden" name="id" value="<?=$dataColles['N_Id'];?>" /></td>
            <td align="left" valign="top" class="input-2"><input type="submit" name="submit" value="<?php if($_REQUEST['id']!='') { echo 'Update'; } else { echo'Insert Record'; }?>"  class="buttons" /></td>
          </tr>
        </table>
       </div>
       
        </form>
      </div>
    </div>
    <div class="cl"></div>
  </div>
  <? include"footer.inc.php"?>
</div>

</body>
</html>
