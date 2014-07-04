<?php 
include("../config/functions.inc.php");
include("session.inc.php");
$list_page ='newsletter-list.php';
$head_page ='newsletter.php';
if($_POST['Submit']=='Send Mail')
{
  
    $arrayCustomer = $_POST['Member_Account_Id'];
  
  
	if(count($arrayCustomer)>0)
	{
	$TO = implode(',',$arrayCustomer);
	
	$n_id=$_POST['Newsletter'];
	$nsql="select * from newsletter where N_Id='".$N_Id."'";
	
	$nresult=mysql_query($nsql);
	$nline=mysql_fetch_array($nresult);
	$subject = ms_stripslashes($nline['Subject']);
	// message
	$message = ms_stripslashes($nline['Message']);
	
	
	$SUBJECT = $subject;
	$BODY = $message;
	$HEADER = "From: ".$nline['From_Mail']." \n";
	$HEADER .= "Reply-To: $TO <$TO>\n";
	$HEADER .= "X-Mailer: PHP/" . phpversion() . "\n";
	$HEADER .= "X-Priority: 1";
   
    @mail($TO, $SUBJECT, $BODY, $HEADER);
	$_SESSION['sess_mess']='Mail has been send';
	header("Location:newsletter-list.php");
    exit();
    }
	else
	{
	$_SESSION['sess_mess']='ERROR : Please select at least one Customer or Teacher';
	header("Location:newsletter-mail.php");
    exit();
	}
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
	if (placeadd.Newsletter.value == "") 
	{
		alert("\nPlease select newsletter.")
		placeadd.Newsletter.focus();
		return false;
	}
	else if (placeadd.Member_Account_Id.value == "") 
	{
		alert("\nPlease select customer.")
		placeadd.Member_Account_Id.focus();
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
       <h2> Send Newsletter </h2>
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
            <td width="200" align="left" valign="middle">Select Newsletter</td>
            <td align="left" valign="top" class="input-1">
            <select name="Newsletter" id="Newsletter">
            <option value="">Select</option>
            <?php
            $news_sql="SELECT * FROM newsletter WHERE Status=1 ORDER BY Subject ";
            $news_result=executeQuery($news_sql);
            while($news_line=mysql_fetch_array($news_result))
            {
            ?>
            <option value="<?=$news_line['N_Id']?>"><?=ms_stripslashes($news_line['Subject'])?></option>
            <?php
            }
            ?>
            </select>
            </td>
          </tr>
          
          <tr>
            <td width="200" align="left" valign="middle">Select Customer</td>
            <td align="left" valign="top">
            <select name="Member_Account_Id[]" id="Member_Account_Id" multiple="multiple" size="10" style="width:210px;">
            <option value="">Select</option>
            <?php
            $sql_member="SELECT Name, Email FROM newsletter_users WHERE Status=1 ORDER BY Name ";
            $result_member = mysql_query($sql_member);
            while($colles_member = mysql_fetch_array($result_member))
            {
            ?>
            <option value="<?=$colles_member['Email']?>"><?=trim($colles_member['Name'])?></option>
            <?php
            }
            ?>
            </select>
            </td>
          </tr>
          
          <tr>
            <td align="left" valign="middle"></td>
            <td align="left" valign="top" class="input-2"><input type="submit" name="Submit" value="Send Mail" class="buttons" /></td>
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
