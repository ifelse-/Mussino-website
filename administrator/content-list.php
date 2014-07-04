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



if($_GET['order_by']=='') { $order_by="Con_Title"; } else { $order_by=$_REQUEST['order_by'];}
if($_GET['order_by2']=='') { $order_by2="DESC"; } else { $order_by2=$_REQUEST['order_by2'];}


$column="SELECT * ";
$sql=" FROM content_master WHERE 1=1 ";
	
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
          <h2>Content Management</h2>
          
          <form  name="form1" id="form1" method="post" action="">
          <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table-1">
            
            
         <tr align="right">
          <?php if($_SESSION['sess_mess']!='') { ?>
            <td height="29" colspan="5" align="center" class="h12" ><?=$_SESSION['sess_mess'];?> <?php $_SESSION['sess_mess']=='';?></td>
            <?php } ?>
				</tr>
        <tr align="right">
          
           <? if($reccnt<=0) { ?>
		  </tr>
        
            <tr align="center">
            <td height="27" colspan="5">
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
              
              <th width="350" align="center" valign="top">Title </th>
              <th width="100" align="center" valign="top">Display Order</th>
              <th width="50" align="center" valign="top">Status <?=sort_arrows('Status')?></th>
              <th width="50" align="center" valign="top">Edit</th>
              
            </tr>
            <?
			while($row=mysql_fetch_array($result))
			{
		
			?>
            <tr>
              
              <td width="350" align="center" valign="top"><?=stripslashes(trim($row['Con_Title']));?></td>
              <td width="100" align="center" valign="top"><?=trim($row['display_order']);?></td>
              <td width="50" align="left" valign="top" class="<?=($row['Status']=='1')? 'enable-1':'disable-1';?>">
              <?=($row['Status']=="1")? 'Active':'Inactive';?>
              </td>
            
              <td width="50" align="center" valign="top"><a href="content.php?id=<?=$row['Id']?>"><img src="images/editrec.gif" width="12" height="12" border="0"></a>  </td>
              
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
