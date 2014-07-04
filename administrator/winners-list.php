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
$sql=" FROM product_master WHERE 1=1 AND Type!='3'";
	
if($_REQUEST['alphabet']!='')
{
$sql.= " and Title like '". $_GET['alphabet'] ."%'";
}

if($_REQUEST['Title']!='')
{
$Title = addslashes($_REQUEST['Title']);
$sql.= " and Title like '%$Title%' ";
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
          <h2>Winners Management </h2>
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
              
              <th width="150" align="center" valign="top">Session Title  <?=sort_arrows('Title')?></th>
              <th width="100" align="center" valign="top">Member</th>
              <th width="150" align="center" valign="top">Session Start <?=sort_arrows('Session_Start_Date')?> </th>
              <th width="150" align="center" valign="top">Session End <?=sort_arrows('Session_End_Date')?></th>
              <th width="80" align="center" valign="top">Royalties</th>
              <th width="100" align="center" valign="top">Votes</th>
              <th width="50" align="center" valign="top">Status </th>
              <th width="100" align="center" valign="top">Mail </th>
              <th width="50" align="center" valign="top">Edit </th>
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
			
			$sql_votes = "SELECT COUNT(*) as totalVotes FROM my_bank WHERE Product_Id='".$row['Product_Id']."' AND Account_Type='Contest Judge' ";
			$result_votes = mysql_query($sql_votes);
			$colles_votes = mysql_fetch_array($result_votes);
			$TOTAL_VOTES = $colles_votes['totalVotes'];		
			?>
            <tr>
              
              <td width="150" align="center" valign="top"><?=stripslashes(trim($row['Title']));?></td>
              <td width="100" align="center" valign="top">
			  <?=stripslashes(Get_Single_Field("member_account_master","First_Name","Member_Account_Id","$row[Member_Account_Id]"));?>
              </td>
              <td width="150" align="center" valign="top"><?=$row['Session_Start_Date']!='0000-00-00 00:00:00'?$row['Session_Start_Date']:'';?></td>
              <td width="150" align="center" valign="top"><?=$row['Session_End_Date']!='0000-00-00 00:00:00'?$row['Session_End_Date']:'';?></td>
              
              <td width="80" align="center" valign="top">$<?=trim($TOTAL_ROYALTIES);?></td>
              <td width="100" align="center" valign="top"><?=trim($TOTAL_VOTES);?></td>
              <td width="50" align="left" valign="top" ><?php if($row['Jack_Pot_Status']!='') { ?>
              <?=($row['Jack_Pot_Status']=="Winner")? '<span style="font-size:12px; color:#006600">Winner</span>':'<span style="font-size:12px; color:#000000">Looser</span>';?>
              <?php } ?>
              </td>
               <td width="100" align="left" valign="top" ><?php if($row['Jack_Pot_Status']=="Winner") { ?><a href="compose.php?id=<?=$row['Product_Id']?>">Compose Mail</a><?php } else { ?> .......... <?php } ?></td>
               <td width="50" align="center" valign="top" ><a href="javascript:void(0);" title="Update Winner" onclick="window.open('jack-pot-popup.php?id=<?=$row['Product_Id']?>','Admin','width=570,height=400,top=243,left=250');"><img src="images/editrec.gif" width="12" height="12" border="0"></a></td>
            </tr>
			<?php } } ?>
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
