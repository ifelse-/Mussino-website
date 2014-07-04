<?php
require_once "config/functions.inc.php";
include("session.inc.php");
$pageName = basename($_SERVER['PHP_SELF']);
$start=0;
if(isset($_GET['start'])) $start=$_GET['start'];
$pagesize=20;


if($_GET['order_by']=='') { $order_by="Inbox_Id"; } else { $order_by=$_REQUEST['order_by'];}
if($_GET['order_by2']=='') { $order_by2="DESC"; } else { $order_by2=$_REQUEST['order_by2'];}
$column="SELECT * ";
$sql=" FROM message_master  WHERE  From_Id 	='".$_SESSION['SESS_ID']."' AND Sent=1 AND From_Temp!='".$_SESSION['SESS_ID']."'	";

$sql1="SELECT count(*) as total ".$sql;
$sql=$column.$sql;
$sql.=" order by $order_by $order_by2 ";
$sql.=" limit $start, $pagesize";
# echo $sql;
$result=executequery($sql);
$reccnt=getSingleResult($sql1);
if($_POST['btnSubmit']== 'Delete')
{
	@extract($_POST);
	$arr_id = $_REQUEST['arr_id'];
    if(is_array($arr_id))
	{
		$str_id = implode(',', $arr_id);
	}

	if(count($arr_id)>0)
	{
		
		$sql = "UPDATE message_master SET From_Temp='".$_SESSION['SESS_ID']."' WHERE Inbox_Id in ($str_id)";
		mysql_query($sql);
		$_SESSION['MSG'] = count($arr_id). ' messages temp deleted';
		header("Location: sent.php");
		exit;
	}
}
?>
<script language="javascript">

function checkall(objForm)
{
	len = objForm.elements.length;
	var i=0;
	for( i=0 ; i<len ; i++) 
	{
		if (objForm.elements[i].type=='checkbox') 
		{
			objForm.elements[i].checked=objForm.check_all.checked;
		}
	}
}

function doDeleteAction(form,acurl)
{
	var xx =eval("document."+form);
	var flag=0;
	for (i=0;i<xx.length;i++)
	{
		var el = xx.elements[i];
		if (el.name == "arr_id[]")
			{
				if(el.checked==true)
				{
					flag=10;
				}
			}
	}
	if (flag==10)
	{
		if(confirm("Are you sure you wants to temp delete messages ?"))
		{
			xx.action=acurl;
			xx.submit();
		}	
	}
	else
	{
		alert("Please select at least one checkbox");
		return false;
	}
}
</script>
<div id="page-wrapper">
  <div class="layoutArea">
    <div class="contentArea">
      <div class="content-box-2">
        <div class="cor_1set-5"></div>
        <div class="cor_1set-6"></div>
        <?php include "message-left.inc.php"; ?>
            
        <div class="rgtPannel2 fr">
          <div class="rgtPannel-col first">
            <img src="images/icon/sent.png" width="30" height="30"  align="absmiddle"  /><span style=" font-size:16px; font-weight:bold; padding-left:7px; top:5px; position:relative;">Sent</span>
            <div style="padding:10px 0 0 0;"><form action="" method="POST"  name="form1">
                  <table width="100%" border="0" cellspacing="2" cellpadding="2" >
                    <?php if(mysql_num_rows($result)>0) { ?>
                    <tr bgcolor="#fff" height="30">
                      <td width="50"><input name="check_all" type="checkbox" id="check_all" value="check_all" onClick="checkall(this.form)"></td>
                      <td width="150"><strong>To</strong></td>
                      <td width="400"><strong>Subject</strong></td>
                      <td width="100"><strong>Date</strong></td>
                      
                    </tr>
                    <?php
					}
					$k=0;
					if(mysql_num_rows($result)>0)
					{
					while($line=mysql_fetch_array($result))
					{
					$bgcolor = ($k%2==0? '#E8F3FE': '#fffff0');
					?>
                    <tr bgcolor="<?=$bgcolor?>">
                      <td><input type="checkbox" name="arr_id[]" id="arr_id" value="<?php echo $line['Inbox_Id']?>"></td>
                      <td class="title-2" title="Show Message"><a href="message-sent-detail.php?id=<?=$line['Inbox_Id']?>"><?=ucwords(strtolower(stripslashes(Get_Single_Field("member_account_master","First_Name","Member_Account_Id","$line[To_Id]").' '.Get_Single_Field("member_account_master","Last_Name","Member_Account_Id","$line[To_Id]"))));?></a></td>
                      <td class="title-2" title="Show Message"><a href="message-sent-detail.php?id=<?=$line['Inbox_Id']?>"><?=stripslashes($line['Subject']);?></a></td>
                      <td class="date"><div><?=date('m-d-Y',strtotime($line['Date']))?></div></td>
                    </tr>
                    <?php
					$k++;
					}
					}
					else
					{ 
					echo "<td colspan='4' height='250'  align='center'>No messages</td>";
					}
					?>
                    <?php if(mysql_num_rows($result)>0) { ?>
                    
                    <tr>
                      <td colspan="4" style="padding:10px 0 0 0;"><?php include "paging-in.inc.php";  ?></td>
                    </tr>
                    <tr>

                    <td colspan="4" style="padding:10px 0 0 0;">
                    <input name="btnClick" type="button" value="Delete" onClick="return doDeleteAction('form1','sent.php');" style="background-color:#438EEB;  color:#fff;"/><input type="hidden" name="btnSubmit" value="Delete" >
                     
                  </td>
                    </tr>
                    <?php } ?>
                  </table>
                </form></div>
          </div>
          
        </div>
        <div class="cl"></div>
        <div class="cor_1set-3"></div>
        <div class="cor_1set-4"></div>
      </div>
      <?php if($_SESSION['SESS_ID']!='') { ?>
      <?php include"footer-div.inc.php"; ?>
      <?php } ?>
    </div>
  </div>
</div>
