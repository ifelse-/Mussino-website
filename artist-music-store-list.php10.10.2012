<?php 
require_once "config/functions.inc.php";
require_once "session.inc.php"; 
$pageName = basename($_SERVER['PHP_SELF']); 
$sql = "SELECT * FROM member_account_master WHERE Member_Account_Id='".$_SESSION['SESS_ID']."'";
$result = mysql_query($sql);
$colles = mysql_fetch_array($result);

$start=0;
if(isset($_GET['start'])) $start=$_GET['start'];
if($_SESSION['PAGESIZE']!='')
{
$pagesize=$_SESSION['PAGESIZE'];
}
else
{
$pagesize=10;
}

if($_GET['order_by']=='') { $order_by="Product_Id"; } else { $order_by=$_REQUEST['order_by'];}
if($_GET['order_by2']=='') { $order_by2="DESC"; } else { $order_by2=$_REQUEST['order_by2'];}
$column="select * ";
$sql=" FROM product_master where  Status=1 AND Member_Account_Id ='".$_SESSION['SESS_ID']."' AND Type=5 ";

$sql1="select count(*) as total ".$sql;
$sql=$column.$sql;
$sql.=" order by $order_by $order_by2 ";
$sql.=" limit $start, $pagesize";
//echo $sql;
$result=executequery($sql);
$reccnt=getSingleResult($sql1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>My Music Store</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="description" content="Default Description">
<meta name="keywords" content="">
<meta name="robots" content="">
<?php include "common.inc.php"; ?>
<script>
function checkall(form1)
{
len = form1.elements.length;
var i=0;
for( i=0 ; i<len ; i++)
{
if (form1.elements[i].type=='checkbox') form1.elements[i].checked=form1.check_all.checked;
}
}
function del_prompt(wish_form,comb)
{
	if(comb=='Delete')
	{
		if(confirm ("Are you sure you want to delete Record(s)"))
		{
			wish_form.action = "music-store-del.php";
			wish_form.submit();
		}
		else
		{ 
		return false;
		}
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
              <div class="blue-btn-1"> <span><span><a href="<?=SITE_WS_PATH?>/<?=trim($_SESSION['SESS_ID'])?>/<?=$_SESSION['SESS_FIRST_NAME']?>" >My Profile</a></span></span> </div>
              &raquo; My Music Store
            </div>
          </div>
        </div>
        <div class="pro-content">
        <form name="form1" method="form1" action="">
          <div class="pro-left fl">
            <div class="user-img">
            <a href="<?=SITE_WS_PATH?>/<?=trim($_SESSION['SESS_ID'])?>/<?=$_SESSION['SESS_FIRST_NAME']?>" >
			<?php if(file_exists("products/user_image/$colles[Photo]") && $colles['Photo']!='') { ?>
              <img src="products/user_image/<?php echo $colles['Photo']; ?>" border="0" width="100" height="150" />
               <?php } else { ?>
              <img src="images/user_big.png" border="0" width="100" height="150" />
            <?php } ?>
            </a>
            <p><?=$colles['Account_Type']?></p>
            </div>
            <div class="pro-btn_row">
               <?php include "left-profile.inc.php"; ?>  
            </div>
          </div>
          <div class="pro-right">
            <table width="100%" border="0" cellpadding="1" cellspacing="1">
		
          <tr>
            <td>
            <form name="wish_form" method="post" action="">
            <table width="100%" border="0" cellpadding="1" cellspacing="1">
            <?php if($_SESSION['sess_messs']!='') { ?>
            <tr height="32">
            	<td colspan="3" align="center" style="color:#000000;"><?=$_SESSION['sess_messs'];?> <?php $_SESSION['sess_messs']=''; ?></td>            
            </tr>
            <?php } ?>
            <tr bgcolor="#CCCCCC" height="30">
            <td width="10%" align="center"><input name="check_all" type="checkbox" onclick="checkall(this.form)" value="check_all"  id="check_all" /></td>
            <td width="30%" align="center"><strong>Product</strong></td>
            <td width="15%" align="center"><strong>Date</strong></td>
            <td width="15%" align="center"><strong>Status</strong></td>
            <td align="center" width="15%" ><strong>Edit</strong></td>
            </tr>
            <?php
			$ct=0;
			if($reccnt>0) 
			{ 
            while($line=mysql_fetch_array($result))
            {
			$bgcolor = ($ct%2==0? '#E8F3FE': '#eeeeee');
            ?>
            <tr bgcolor="<?=$bgcolor?>">	
            <td width="10%" align="center"><input name="ids[]" type="checkbox" value="<?=$line['Product_Id']?>" /></td>			
            <td align="center" width="30%" title="<?=stripslashes($line['Title']);?>">
            
            <?php
            if(file_exists("products/product_image/$line[Image_Name]") && $line['Image_Name']!='')
            {
            ?>
            <img src="products/product_image/<?=$line['Image_Name']?>" class="img_border"  width="90" height="100" border="0" alt="<?=stripslashes($line['Title']);?>">
            <?
            }
            else
            {
            ?>
            <img src="images/no-image.gif" width="90" class="img_border"  height="100" border="0" alt="<?=stripslashes($line['Title']);?>">
            <?php
            }
            ?>
           	 <br />
             <?=stripslashes($line['Title']);?>
             <br /> 
             <?=stripslashes($line['Price']);?>
            </td>
           
            <td  width="15%" align="center" valign="middle"> <?=get_date_format($line['Product_Date']);?></td>
            <td  width="15%" align="center" valign="middle"> <?=$line['Status']==1?'Active ':'Inactive';?></td>
            <td  width="15%" align="center" valign="middle"> <a href="artist-music-store.php?id=<?=$line['Product_Id']?>"><img src="administrator/images/editrec.gif" width="12" height="12" border="0"> Edit</a></td>
            </tr> 
            
            <?php
			$ct++;
            }
			}else
			{
			echo' <tr bgcolor="#CCCCCC" height="30" align="center"><td colspan=6>No Products</td></tr>';
			}
            ?>
            
            </table>	 
            
            </td>
              </tr>
             
             <?php if($reccnt>10) { ?>
               <tr>
                <td colspan="6" align="center">
                <?php require_once("paging.inc.php"); ?>						
                </td>
              </tr>
               <?php } if($reccnt>0) {?>
              <tr>
             <td colspan="6" align="left">
			 <input name="Submit" type="submit" class="buttons" value="Delete" onClick="return del_prompt(this.form,this.value)" />	
             </td>
             </tr>
              <?php } ?>
             
            </table>
          </div>
          <div class="cl"></div>
        </form>
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