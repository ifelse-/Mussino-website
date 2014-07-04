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



if($_GET['order_by']=='') { $order_by="Video_Name"; } else { $order_by=$_REQUEST['order_by'];}
if($_GET['order_by2']=='') { $order_by2="DESC"; } else { $order_by2=$_REQUEST['order_by2'];}


$column="SELECT * ";
$sql=" FROM video_master WHERE 1=1 ";
	
if($_REQUEST['alphabet']!='')
{
$sql.= " and Video_Name like '". $_GET['alphabet'] ."%'";
}

if($_REQUEST['Video_Name']!='')
{
$Video_Name = addslashes($_REQUEST['Video_Name']);
$sql.= " and Video_Name like '%$Video_Name%'";
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
if(comb=='Inactive'){
form1.action = "video-del.php";
form1.submit();
}
else if(comb=='Active'){
form1.action = "video-del.php";
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
  <div class="content-container-2">
<div class="content-container">
    <div class="left-navigation fl">
      <div class="left-navigation_inner">
        <? require_once "left.inc.php"; ?>
      </div>
    </div>
    <div class="detail-col fr">
      <div class="detail-col_inner">
        <div class="box-1">
          <h2>Index Top Audio Or Video</h2>
          
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
              <th width="50" align="center" valign="top"><input name="check_all" type="checkbox" onclick="checkall(this.form)" value="check_all"  id="check_all" /></th>
              <th width="200" align="center" valign="top">Audio Or Video Name<?=sort_arrows('Video_Name')?></th>
              <th width="200" align="center" valign="top">Audio Or Video File</th>
              <th width="50" align="center" valign="top">Status <?=sort_arrows('Status')?></th>
              <th width="50" align="center" valign="top">Edit</th>
              
            </tr>
            <?
			while($row=mysql_fetch_array($result))
			{
		
			?>
            <tr>
              <td width="50" align="center" valign="middle"><input name="ids[]" type="checkbox" value="<?=$row['Video_Id']?>" />  </td>
              <td width="200" align="center" valign="middle"><?=stripslashes(trim($row['Video_Name']));?></td>
              <td width="200" align="center" valign="middle"><?=stripslashes(trim($row['Video_File']));?></td>
              <td width="50" align="left" valign="middle" class="<?=($row['Status']=='1')? 'enable-1':'disable-1';?>">
              <?=($row['Status']=="1")? 'Active':'Inactive';?>
              </td>
            
              <td width="50" align="center" valign="middle"><a href="video.php?id=<?=$row['Video_Id']?>"><img src="images/editrec.gif" width="12" height="12" border="0"></a>  </td>
              
               <?
			  }
              }
			  ?>
            </tr>
          </table>
          <?php if($reccnt>0) { ?>
          
          <div>
            <input name="Submit" type="submit" class="buttons" value="Active" onClick="return del_prompt(this.form,this.value)" />
			  &nbsp;
            <input name="Submit" type="submit" class="buttons" value="Inactive" onClick="return del_prompt(this.form,this.value)" />
        
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
  </div></div>
  <? include"footer.inc.php"?>
</div>

</body>
</html>
