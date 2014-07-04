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



if($_GET['order_by']=='') { $order_by="Product_History_Id"; } else { $order_by=$_REQUEST['order_by'];}
if($_GET['order_by2']=='') { $order_by2="DESC"; } else { $order_by2=$_REQUEST['order_by2'];}


$column="SELECT a.Payment_Amount, a.Payment_Date, b.Title, c.First_Name, c.Last_Name ";
$sql=" FROM product_history_master a LEFT JOIN product_master b ON(a.Product_Id=b.Product_Id) LEFT JOIN member_account_master c ON(a.Member_Account_Id=c.Member_Account_Id) WHERE 1=1  AND a.Mode=1 ";
	
if($_REQUEST['alphabet']!='')
{
$sql.= " and c.First_Name like '". $_GET['alphabet'] ."%'";
}

if($_REQUEST['Name']!='')
{
$Name = addslashes($_REQUEST['Name']);
$sql.= " and (b.Title  like '%$Name%' || c.First_Name  like '%$Name%' || c.Last_Name like '%$Name%')";
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
          <h2>Unreleased Music History</h2>
          <form  name="search" id="search" method="get" action="">
          <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table-1">
            <tr>
              <th colspan="3" align="left" valign="top">Search</th>
            </tr>
            <tr>
              <td width="150" align="left" valign="middle">Member Name:</td>
              <td align="left" valign="top" class="input-1">
              <input type="text" name="Name" size="40"  value="<?=stripslashes($_REQUEST['Name'])?>" class="textbox"/>              </td>
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
          <?
			  if($_SESSION['sess_mess'])
			  {
			  ?>
                      <td height="29" colspan="4" align="center" class="h12" ><?=$_SESSION['sess_mess'];?>
                          <? session_unregister(sess_mess);	?></td>
                      <?
				}
				?>
				</tr>
        <tr align="right">
          <td height="29" colspan="4" align="right" >&nbsp;
		 
          </td>
           <? if($reccnt<=0) { ?>
		  </tr>
        
            <tr align="center">
            <td height="27" colspan="4">
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
              <th width="100" align="center" valign="top">Member</th>
              <th width="200" align="center" valign="top">Product</th>
              <th width="100" align="center" valign="top">Amount</th>
              <th width="100" align="center" valign="top">Date</th>
            </tr>
            <?
			while($row=mysql_fetch_array($result))
			{
		
			?>
            <tr>
              <td width="100" align="center" valign="top"><?=stripslashes(ucfirst($row['First_Name']).' '.ucfirst($row['Last_Name']));?></td>
              <td width="200" align="center" valign="top"><?=stripslashes(trim($row['Title']));?></td>
              <td width="100" align="center" valign="top"><?=$row['Payment_Amount'];?></td>
              <td width="100" align="center" valign="top"><?=get_date_format($row['Payment_Date']);?> </td>
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
