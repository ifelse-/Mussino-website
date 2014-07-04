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



if($_GET['order_by']=='') { $order_by="Royality_Id"; } else { $order_by=$_REQUEST['order_by'];}
if($_GET['order_by2']=='') { $order_by2="DESC"; } else { $order_by2=$_REQUEST['order_by2'];}


$column="SELECT * ";
$sql=" FROM royality WHERE 1=1 ";

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
          <h2>Winners History</h2>
          
          <form  name="form1" id="form1" method="post" action="">
          <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table-1">
           
         <tr align="right">
          <?
			  if($_SESSION['sess_mess'])
			  {
			  ?>
                      <td height="29" colspan="8" align="center" class="h12" ><?=$_SESSION['sess_mess'];?>
                          <? session_unregister(sess_mess);	?></td>
                      <?
				}
				?>
			  </tr>
        <tr align="right">
          
           <? if($reccnt<=0) { ?>
		  </tr>
        
            <tr align="center">
            <td height="27" colspan="8">
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
              
              <th width="150" align="center" valign="top">Session Title</th>
              <th width="150" align="center" valign="top">Session Start</th>
              <th width="150" align="center" valign="top">Session End</th>
              <th width="100" align="center" valign="top">Admin Royalties</th>
              <th width="100" align="center" valign="top">Musician </th>
              <th width="100" align="center" valign="top">Musician Royalties</th>
              <th width="100" align="center" valign="top">Artist </th>
              <th width="100" align="center" valign="top">Artist Royalties</th>
              
            </tr>
            <?
			while($row=mysql_fetch_array($result))
			{
		    
			?>
            <tr>
              
              <td width="150" align="center" valign="top"><?=stripslashes(Get_Single_Field("product_master","Title","Product_Id","$row[Product_Id]"))?></td>
              <td width="150" align="center" valign="top"><?=date('F d, Y',strtotime(Get_Single_Field("product_master","Session_Start_Date","Product_Id","$row[Product_Id]")));?></td>
              <td width="150" align="center" valign="top"><?=date('F d, Y',strtotime(Get_Single_Field("product_master","Session_End_Date","Product_Id","$colles_royalties_amount[Product_Id]")));?></td>
              <td width="100" align="center" valign="top">$<?=$row['Admin_Amount'];?></td>
              
              <td width="100" align="center" valign="top"><?=stripslashes(Get_Single_Field("member_account_master","First_Name","Member_Account_Id","$row[Musician_Id]").' '.Get_Single_Field("member_account_master","Last_Name","Member_Account_Id","$row[Musician_Id]"))?></td>
              <td width="100" align="center" valign="top">$<?=$row['Musician_Amount'];?></td>
              <td width="100" align="left" valign="top" ><?=stripslashes(Get_Single_Field("member_account_master","First_Name","Member_Account_Id","$row[Artist_Id]").' '.Get_Single_Field("member_account_master","Last_Name","Member_Account_Id","$row[Artist_Id]"))?></td>
              <td width="100" align="left" valign="top" >$<?=$row['Artist_Amount'];?></td>
             </tr>
			<?php 
			$admin_total_amount += $row['Admin_Amount'];
			$musician_total_amount += $row['Musician_Amount'];
			$artist_total_amount += $row['Artist_Amount'];
			} 
			?>
           <!-- <tr>
            
            <td align="right" valign="top" colspan="3"><strong>Total</strong></td>
            <td width="150" align="center" valign="top"><strong>$<?=$admin_total_amount?></strong></td>
            <td width="150" align="center" valign="top"></td>
            <td width="150" align="center" valign="top"><strong>$<?=$musician_total_amount?></strong></td>
            <td width="150" align="center" valign="top"></td>
            <td width="150" align="center" valign="top"><strong>$<?=$artist_total_amount?></strong></td>
            </tr>-->
            <?php } ?>
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
