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



if($_GET['order_by']=='') { $order_by="id"; } else { $order_by=$_REQUEST['order_by'];}
if($_GET['order_by2']=='') { $order_by2="DESC"; } else { $order_by2=$_REQUEST['order_by2'];}


$column="SELECT * ";
$sql=" FROM questions WHERE 1=1 ";
	
if($_REQUEST['alphabet']!='')
{
$sql.= " and ques like '". $_GET['alphabet'] ."%'";
}

if($_REQUEST['ques']!='')
{
$Country_Name = addslashes($_REQUEST['ques']);
$sql.= " and ques like '%$ques%'";
}

if($_REQUEST['Action']=='ST')
{
$Status = $_REQUEST['Status'];
$ID = $_REQUEST['id'];
if($Status==1)
{
$sql = "UPDATE questions  SET Status='0' WHERE id = '".$ID."'";
executeQuery($sql);
$sql2 = "UPDATE questions  SET Status='0' WHERE id != '".$ID."'";
executeQuery($sql2);
}
if($Status==0)
{
$sql = "UPDATE questions  SET Status='1' WHERE id = '".$ID."'";
executeQuery($sql);
$sql2 = "UPDATE questions  SET Status='0' WHERE id != '".$ID."'";
executeQuery($sql2);
}
header("location:question-list.php");
exit();
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
		form1.action = "question-del.php";
		form1.submit();
	}
	else{ 
	return false;
	}
}
else if(comb=='Inactive'){
form1.action = "question-del.php";
form1.submit();
}
else if(comb=='Active'){
form1.action = "question-del.php";
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
          <h2>Poll Questions</h2>
          <form  name="search" id="search" method="get" action="">
          <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table-1">
            <tr>
              <th colspan="3" align="left" valign="top">Search</th>
            </tr>
            <tr>
              <td width="150" align="left" valign="middle">Question :</td>
              <td align="left" valign="top" class="input-1">
              <input type="text" name="ques" size="40"  value="<?=stripslashes($_REQUEST['ques'])?>" class="textbox"/>              </td>
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
            <?php } ?>	</tr>
        <tr align="right">
          <td height="29" colspan="5" align="right" >
		 
		 <a href="question.php" class="lin2">Add New Question</a>
          </td>
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
              <th width="50" align="center" valign="top"><input name="check_all" type="checkbox" onclick="checkall(this.form)" value="check_all"  id="check_all" /></th>
              <th width="200" align="center" valign="top">Question  </th>
              <th width="150" align="left" valign="top">Options  </th>
              <th width="50" align="center" valign="top">Status <?=sort_arrows('Status')?></th>
              <th width="150" align="center" valign="top">Show On Poll </th>
              <th width="50" align="center" valign="top">Edit</th>
              
            </tr>
            <?
			
			while($row=mysql_fetch_array($result))
			{
		    $sql_op ="SELECT * FROM options WHERE ques_id='".$row['id']."'";
			$result_op = mysql_query($sql_op);
			$str='';
			$cn=A;
			while($colles_op = mysql_fetch_array($result_op))
			{
			$str.=$cn.'. '.$colles_op['value'].'<br>';
			$cn++;
			}
			$str = substr($str,0,-1);
			?>
            <tr>
              <td width="50" align="center" valign="top"><input name="ids[]" type="checkbox" value="<?=$row['id']?>" />  </td>
              <td width="200" align="center" valign="top"><?=stripslashes(trim($row['ques']));?></td>
               <td width="150" align="left" valign="top"><?=$str;?></td>
              <td width="50" align="left" valign="top" class="<?=($row['Status']=='1')? 'enable-1':'disable-1';?>">
              <?=($row['Status']=="1")? 'Active':'Inactive';?>
              </td>
              <td width="150" align="center" valign="top">
              <?php if($row['Status']==1) { ?>
              <a href="javascript:void(0);"><img src="images/<?=($row['Status']=="1")? 'green.gif':'red.gif';?>" width="16" height="16" border="0" align="absmiddle">Currently Show On Poll</a>  
              <?php } else { ?>
              <a href="question-list.php?id=<?=$row['id']?>&Status=<?=$row['Status']?>&Action=ST"><img src="images/<?=($row['Status']=="1")? 'green.gif':'red.gif';?>" width="16" height="16" border="0" align="absmiddle">Click To Show On Poll</a> 
              <?php } ?>
              </td>
              <td width="50" align="center" valign="top"><a href="question.php?id=<?=$row['id']?>"><img src="images/editrec.gif" width="12" height="12" border="0"></a>  </td>
              
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
