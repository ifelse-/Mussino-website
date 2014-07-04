<?php
require_once("../config/functions.inc.php");


if(isset($_POST['buttonSubmit']) && $_POST['buttonSubmit']=='Update') 
{
	@extract($_POST);
	
	        $sql = "SELECT * FROM royality WHERE Product_Id = '".$_REQUEST['id']."'  ";
			$result = mysql_query($sql) or die('<br>'.$sql.'<br>'.mysql_error());
			if(mysql_num_rows($result)>0)
			{
				$_SESSION['msg'] = "Royality already exist";
				
			}
			else
			{
				
				$sql_insert = "INSERT INTO royality SET
								Product_Id = '".$_REQUEST['id']."',
								Royality_Amount = '".$Royality_Amount."',
								Admin_Amount = '".$Admin_Amount."',
								Musician_Amount = '".$Musician_Amount."',
								Artist_Amount = '".$Artist_Amount."',
								Musician_Id = '".$Musician_Id."',
								Artist_Id = '".$Artist_Id."',
								Date = '".date('Y-m-d')."'";
				$result_insert = mysql_query($sql_insert) or die('<br>'.$sql_insert.'<br>'.mysql_error());
				
				mysql_query("UPDATE product_master SET  Jack_Pot_Status='".$Jack_Pot_Status."' WHERE Product_Id='".$_REQUEST['id']."'");
			    mysql_query("UPDATE my_bank SET  Jack_Pot_Status='".$Jack_Pot_Status."', Date = '".date('Y-m-d')."' WHERE Product_Id='".$_REQUEST['id']."'");
	            $_SESSION['msg'] = 'Record successfully updated';
				?>
    <script>
      window.opener.location.reload(); // this does not work
      self.close();
    </script>
<?php  
			}
		
    
    
}


$sql="SELECT * FROM product_master WHERE Product_Id='".$_REQUEST['id']."'";
$result=executeQuery($sql);
$line=mysql_fetch_array($result);
@extract($line);

$sql_royalties = "SELECT count(*) as totalRoyalties FROM lyrics_post_master WHERE Product_Id='".$_REQUEST['id']."' ";
$result_royalties = mysql_query($sql_royalties);
$colles_royalties = mysql_fetch_array($result_royalties);

if($colles_royalties['totalRoyalties']>0)
{
$TOTAL_ROYALTIES = $Product_Notes*$colles_royalties['totalRoyalties'];
}
else
{
$TOTAL_ROYALTIES = 0.00;
}

$sql_votes = "SELECT * FROM my_bank WHERE Product_Id='".$_REQUEST['id']."' AND Account_Type='Contest Judge' GROUP BY To_Member_Account_Id ";
$result_votes = mysql_query($sql_votes);

$sql_royality = "SELECT * FROM royality WHERE Product_Id='".$_REQUEST['id']."'";
$result_royality = executeQuery($sql_royality);
$line_royality = mysql_fetch_array($result_royality);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<title>Winner && Royality</title>
<script language="javascript">

function validateFormOnSubmit(theForm) {
var reason = "";

	reason += validateEmpty(theForm.Artist_Id);
	
	
  if (reason != "") {
    alert("You must fill out the following field : \n\n" + reason);
    return false;
  } else
	{ return true; }
}

function trim(s)
{
  return s.replace(/^\s+|\s+$/, '');
}



function validateEmpty(fld) {
    var error = "";
 
    if (fld.value.length == 0) {
        fld.style.background = 'Yellow'; 
        error = "Choose a winner artist? \n"
    } else {
        fld.style.background = 'White';
    }
    return error;  
}


</script>
</head>

<body>
<form name="frmJackPot" id="frmJackPot" action="" method="post" onSubmit="return validateFormOnSubmit(this)">
                <div style="padding: 5px 0 5px 0; font-weight:bold; font-size:14px;" align="center"> Winner && Royality </div>    
                
                <div>
                <table border="0" width="100%"cellspacing="3" cellpadding="3">
                <?php if($_SESSION['msg']!='') { ?>
                <tr>
                <td align="center" style="color:red; font:Arial, Helvetica, sans-serif; font-weight:12px; padding:15px 0 0 0" colspan="2">
                  <strong><?php echo $_SESSION['msg']; $_SESSION['msg']=''; ?></strong>
                </td>
                </tr>
                <?php } ?>
               
               <tr>
                <td align="left" valign="middle" height="25">Session Title</td>
                <td align="left" valign="middle" height="25"> <?=stripslashes(Get_Single_Field("product_master","Title","Product_Id","$_REQUEST[id]"));?></td>
               </tr> 
               
               <tr>
                <td align="left" valign="middle" height="25">Royalties</td>
                <td align="left" valign="middle" height="25"> <?=$TOTAL_ROYALTIES?></td>
               </tr>  
               
               <?php
			   $adminTax = Get_Single_Field("tax_percentage","Tax_Admin","Tax_Percentage_Id ","1");
			   $musicianTax = Get_Single_Field("tax_percentage","Tax_Musician","Tax_Percentage_Id ","1");
			   $ADMIN = ($TOTAL_ROYALTIES*$adminTax)/100;
			   $SUB_ROYALITY = $TOTAL_ROYALTIES-$ADMIN;
			   $MUSICIAN = ($SUB_ROYALITY*$musicianTax)/100;
			   $ARTIST = $TOTAL_ROYALTIES-$ADMIN-$MUSICIAN;
			   ?>
               
               <tr>
                <td align="left" valign="middle" height="25">Admin Royalties</td>
                <td align="left" valign="middle" height="25"> <input type="text" name="Admin_Amount" value="<?=number_format($ADMIN, 2, '.', ' ')?>" readonly="readonly" /></td>
               </tr>  
               
               <tr>
                <td align="left" valign="middle" height="25">Musician Royalties</td>
                <td align="left" valign="middle" height="25"><input type="text" name="Musician_Amount" value="<?=number_format($MUSICIAN, 2, '.', ' ')?>" readonly="readonly" /></td>
               </tr> 
               
               <tr>
                <td align="left" valign="middle" height="25">Artist Royalties</td>
                <td align="left" valign="middle" height="25"><input type="text" name="Artist_Amount" value="<?=number_format($ARTIST, 2, '.', ' ')?>" readonly="readonly" /></td>
               </tr> 
               
               
                
               <tr>
                <td align="left" valign="middle" height="25">Choose a winner artist ?</td>
                <td align="left" valign="middle" height="25">
                <select name="Artist_Id" id="Artist_Id">
                <option value="">Select a winner artist</option>
                <?php
				while($colles_votes = mysql_fetch_array($result_votes))
				{
				$sql_123 = "SELECT COUNT(*) as maxCount FROM my_bank WHERE To_Member_Account_Id='".$colles_votes['To_Member_Account_Id']."'";
				$result_123 = mysql_query($sql_123);
				$colles_123 = mysql_fetch_array($result_123);
				?>
                <option value="<?=$colles_votes['To_Member_Account_Id']?>" <?php if($colles_votes['To_Member_Account_Id']==$line_royality['Artist_Id']) { ?> selected <?php } ?>><?=stripslashes(Get_Single_Field("member_account_master","First_Name","Member_Account_Id","$colles_votes[To_Member_Account_Id]").' '.Get_Single_Field("member_account_master","Last_Name","Member_Account_Id","$colles_votes[To_Member_Account_Id]").' Vote ('.$colles_123['maxCount'].')');?></option>
                <?php
				}
				?>
                </select>	
                </td>
               </tr>  
               
               <tr>
                <td align="left" valign="middle" height="25">Status</td>
                <td align="left" valign="middle" height="25">
                <select name="Jack_Pot_Status" id="Jack_Pot_Status">
                <option value="Winner" <?php if($Jack_Pot_Status=='Winner') { ?> selected <?php } ?>>Winner</option>
                </select>	
                </td>
               </tr>  
               
                
                <tr>
                    <td align="left" valign="middle" height="25"></td>
                    <td align="left" valign="middle" height="25">
                    <input name="buttonSubmit" type="submit" value="Update">  &nbsp;&nbsp;
                    <input type="Submit" name="btnClose" value="Close" onClick="javascript:self.close();" />
                    <input name="id" type="hidden" value="<?=$_REQUEST['id']?>">
                    <input name="Musician_Id" type="hidden" value="<?=$Member_Account_Id?>">
                    <input name="Royality_Amount" type="hidden" value="<?=$TOTAL_ROYALTIES?>">
                    </td>
                </tr>
                </table>
                </div>
  </form> 
</body>
</html>
