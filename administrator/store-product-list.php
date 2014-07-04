<?php 
include("../config/functions.inc.php");
include("session.inc.php");

$start=0;
if(isset($_GET['start'])) $start=$_GET['start'];

if($_SESSION['PAGESIZE']!='')
{
$pagesize=$_SESSION['PAGESIZE'];
}
else
{
$pagesize=50;
}

if($_GET['order_by']=='') { $order_by="Title"; } else { $order_by=$_REQUEST['order_by'];}
if($_GET['order_by2']=='') { $order_by2="DESC"; } else { $order_by2=$_REQUEST['order_by2'];}

$column="SELECT * ";
$sql=" FROM product_master WHERE 1=1 AND Type=5";
	
if($_REQUEST['alphabet']!='')
{
$sql.= " and Title like '". $_GET['alphabet'] ."%'";
}

if($_REQUEST['Title']!='')
{
$Title = addslashes($_REQUEST['Title']);
$sql.= " and Title like '%$Title%' ";
}


if($_REQUEST['Member_Account_Id']!='')
{
$Member_Account_Id = addslashes($_REQUEST['Member_Account_Id']);
$sql.= " and Member_Account_Id = '".$Member_Account_Id."' ";
}


if($_REQUEST['Status']!="")
{
$sql.= " and Status ='".$_REQUEST['Status']."'";
}
$sql1="select count(*) as total ".$sql;
$sql=$column.$sql;
$sql.=" order by $order_by $order_by2 ";
$sql.=" limit $start, $pagesize";
//echo $sql;
$result=executequery($sql);
$reccnt=getSingleResult($sql1);

//print_r($_SESSION);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Administrator</title>
<link href="css/layout-admin.css" rel="stylesheet" type="text/css" />
<link href="css/css.css" rel="stylesheet" type="text/css">
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
function del_prompt(form1,comb)
{
if(comb=='Delete'){
	if(confirm ("Are you sure you want to delete Record(s)"))
	{
		form1.action = "product-del.php";
		form1.submit();
	}
	else{ 
	return false;
	}
}
else if(comb=='Inactive'){
form1.action = "product-del.php";
form1.submit();
}
else if(comb=='Active'){
form1.action = "product-del.php";
form1.submit();
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
          <h2>Music Store Products</h2>
          <form  name="search" id="search" method="get" action="">
          <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table-1">
            <tr>
              <th colspan="3" align="left" valign="top">Search</th>
            </tr>
            <tr>
              <td width="150" align="left" valign="middle">Title :</td>
              <td align="left" valign="top" class="input-1">
              <input type="text" name="Title" size="40"  value="<?=stripslashes($_REQUEST['Title'])?>" class="textbox"/>              </td>
            </tr>
            
             <tr>
              <td align="left" valign="middle">Member :</td>
              <td align="left" valign="top" class="input-1">
                <select name="Member_Account_Id"  class="textbox">
                    <option value="">Select</option>
                    <?php
					$sql_mem = "SELECT Member_Account_Id, First_Name, Last_Name FROM member_account_master WHERE Account_Type!='ADMIN' AND Status='1' ORDER BY First_Name,Last_Name";
					$result_mem = mysql_query($sql_mem);
					while($colles_mem = mysql_fetch_array($result_mem))
					{
					?>
                    <option value="<?=$colles_mem['Member_Account_Id']?>" <?php if($_REQUEST['Member_Account_Id']==$colles_mem['Member_Account_Id']) { echo "SELECTED"; }?>><?=stripslashes($colles_mem['First_Name'].' '.$colles_mem['Last_Name'])?></option>
                    <?php } ?>
                </select>              
             </td>
            </tr>
            
            
            
             
            
            <tr>
              <td align="left" valign="middle">Status :</td>
              <td align="left" valign="top" class="input-1">
                <select name="Status"  class="textbox">
                    <option value="">All</option>
                    <option value="1" <?php if($_REQUEST['Status']=='1') { echo "SELECTED"; }?>>Active</option>
                    <option value="0" <?php if($_REQUEST['Status']=='0') { echo "SELECTED"; }?>>Inactive</option>
                </select>              
             </td>
            </tr>
            <tr>
              <td align="left" valign="middle">&nbsp;</td>
              <td align="left" valign="top" class="input-2">
                <input type="submit" name="Submit2" value="Search" class="buttons" />
              </td>
            </tr>
          </table>
          </form>
          <form  name="form1" id="form1" method="post" action="">
          <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table-1">
            <tr>
              <th align="left" valign="top">Search by Alphabet</th>
            </tr>
            <tr>
              <td align="left" valign="top">
                <ul class="list-1">
                <?php
                for ($i=65;$i<91;$i++) 
                {
                ?>
                <li><a href="<?=$_SERVER[PHP_SELF]?>?alphabet=<?=chr($i)?>"><?=chr($i)?></a></li>
                <?php
                }
                ?>
                </ul>
              </td>
            </tr>
         
         <tr align="right">
         <?php if($_SESSION['sess_mess']!='') { ?>
            <td height="29" colspan="5" align="center" class="h12" ><?=$_SESSION['sess_mess'];?> <?php $_SESSION['sess_mess']=='';?></td>
            <?php } ?>
         </tr>
        <tr align="right">
          <td height="29" colspan="7" align="right" >
		 
		 <a href="store-product.php" class="lin2">Add New Music Store Product</a>
          </td>
           <? if($reccnt<=0) { ?>
		  </tr>
        
            <tr align="center">
            <td height="27" colspan="7">
            <span class="click">
            <?
            echo "<br><br><center> <font class='orange11'>
            Sorry: Currently no record found. </font><br></center>" ;
            ?>
            </span>
            </td>
            </tr>
            
            <tr>
            <?	
			}
            else
            {
            ?>
            </tr>
          </table>
          
          <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table-1">
            <tr>
              <th width="50" align="center" valign="top"><input name="check_all" type="checkbox" onclick="checkall(this.form)" value="check_all"  id="check_all" /></th>
              <th width="150" align="center" valign="top">Title  <?=sort_arrows('Email')?></th>
              <th width="150" align="center" valign="top">Member</th>
              <th width="100" align="center" valign="top">Price </th>
             <th width="100" align="center" valign="top">Date  <?=sort_arrows('Product_Date')?></th>
              <th width="50" align="center" valign="top">Status <?=sort_arrows('Status')?></th>
              <th width="50" align="center" valign="top">Edit</th>
              
            </tr>
            <?
			while($row=mysql_fetch_array($result))
			{
		    
			$sql_royalties = "SELECT count(*) as totalRoyalties FROM lyrics_post_master WHERE Product_Id='".$row['Product_Id']."' ";
			$result_royalties = mysql_query($sql_royalties);
			$colles_royalties = mysql_fetch_array($result_royalties);
			
			if($colles_royalties['totalRoyalties']>0)
			{
			$TOTAL_ROYALTIES = $row['Product_Notes']*$colles_royalties['totalRoyalties'];
			}
			else
			{
			$TOTAL_ROYALTIES = 0.00;
			}
					
			?>
            <tr>
              <td width="50" align="center" valign="top"><input name="ids[]" type="checkbox" value="<?=$row['Product_Id']?>" />  </td>
              <td width="150" align="center" valign="top"><?=stripslashes(trim($row['Title']));?></td>
              <td width="150" align="center" valign="top"><?=stripslashes(Get_Single_Field("member_account_master","First_Name","Member_Account_Id","$row[Member_Account_Id]").' '.Get_Single_Field("member_account_master","Last_Name","Member_Account_Id","$row[Member_Account_Id]"));?>
              </td>
              <td width="100" align="center" valign="top">$<?=trim($row['Price']);?></td>
              <td width="100" align="center" valign="top"><?=get_date_format($row['Product_Date']);?></td>
              <td width="50" align="left" valign="top" class="<?=($row['Status']=='1')? 'enable-1':'disable-1';?>">
              <?=($row['Status']=="1")? 'Active':'Inactive';?>
              </td>
            
              <td width="50" align="center" valign="top"><a href="store-product.php?id=<?=$row['Product_Id']?>"><img src="images/editrec.gif" width="12" height="12" border="0"></a>  </td>
              
               <?
			  }
              }
			  ?>
            </tr>
          </table>
          <?php if($reccnt>0) { ?>
          <div>
            <?php require_once("paging.inc.php"); ?>
          </div>
          <div>
            <input name="Submit" type="submit" class="buttons" value="Active" onClick="return del_prompt(this.form,this.value)" />
			  &nbsp;
            <input name="Submit" type="submit" class="buttons" value="Inactive" onClick="return del_prompt(this.form,this.value)" />
        
            &nbsp;
			<input name="Submit" type="submit" class="buttons" value="Delete" onClick="return del_prompt(this.form,this.value)" />	
          </div>
           <?php } ?>
          </form>
          
      </div>
        
              </form></td>
          </tr>
        </table></td>
      </tr>
      </table>
      </div>
    </div>
    <div class="cl"></div>
  </div>
  <? include"footer.inc.php"?>
</div>

</body>
</html>
