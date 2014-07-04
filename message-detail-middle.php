<?php
require_once "config/functions.inc.php";
include("session.inc.php");
if($_REQUEST['id']!='')
{
	mysql_query("UPDATE message_master SET Read_Status='1' WHERE Inbox_Id='".$_REQUEST['id']."'");
}
$inboxDetailQuery = "SELECT * FROM message_master WHERE Inbox_Id='".$_REQUEST['id']."' ";
$resInboxDetailQuery = mysql_query($inboxDetailQuery);
$collesInboxDetailQuery = mysql_fetch_array($resInboxDetailQuery);
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
            <img src="images/icon/home.png" width="30" height="30"  align="absmiddle"  /><span style=" font-size:16px; font-weight:bold; padding-left:7px; top:5px; position:relative;">Inbox</span>
            <div style="padding:10px 0 0 0;"><div class="tab-info">
              <div class="title">
                <h2 style="color:#8C6843;"><?php echo stripslashes($collesInboxDetailQuery['Subject']); ?></h2><div style="top:63px; position:absolute; padding-left:620px; color:#8C6843;"><?=date('m-d-Y A h:i',strtotime($collesInboxDetailQuery['Date']))?></div>
                <div style="color:#8C6843; padding: 5px 0 3px 0;">From: <?=ucwords(strtolower(stripslashes(Get_Single_Field("member_account_master","First_Name","Member_Account_Id","$collesInboxDetailQuery[From_Id]").' '.Get_Single_Field("member_account_master","Last_Name","Member_Account_Id","$collesInboxDetailQuery[From_Id]"))));?></div>
                <div style="color:#8C6843; padding: 0 0 5px 0;"> To: <?=ucwords(strtolower(stripslashes(Get_Single_Field("member_account_master","First_Name","Member_Account_Id","$collesInboxDetailQuery[To_Id]").' '.Get_Single_Field("member_account_master","Last_Name","Member_Account_Id","$collesInboxDetailQuery[To_Id]"))));?></div>
              </div>
              <div class="white-box" align="justify" style="min-height:250px;">
              <?php echo stripslashes($collesInboxDetailQuery['Message']); ?>
              </div>
			</div></div>
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
