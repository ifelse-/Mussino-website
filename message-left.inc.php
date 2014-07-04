<?php
$inboxQuery = "SELECT COUNT(1) AS inboxCount FROM message_master WHERE To_Id='".$_SESSION['SESS_ID']."' AND Sent=1 AND Read_Status=0 AND To_Temp!='".$_SESSION['SESS_ID']."'";
$resInboxQuery = mysql_query($inboxQuery);
$collesInboxQuery = mysql_fetch_array($resInboxQuery);

$sentQuery = "SELECT COUNT(1) AS sendCount FROM message_master WHERE From_Id 	='".$_SESSION['SESS_ID']."' AND Sent=1 AND From_Temp!='".$_SESSION['SESS_ID']."'";
$resSentQuery = mysql_query($sentQuery);
$collesSentQuery = mysql_fetch_array($resSentQuery);

$trashQuery = "SELECT COUNT(1) AS trashCount FROM message_master WHERE ( To_Id='".$_SESSION['SESS_ID']."' || From_Id='".$_SESSION['SESS_ID']."' ) AND Sent=1 AND ( From_Temp='".$_SESSION['SESS_ID']."' || To_Temp='".$_SESSION['SESS_ID']."' ) AND Temp_Del NOT LIKE '%".$_SESSION['SESS_ID']."%'";
$resTrashQuery = mysql_query($trashQuery);
$collesTrashQuery = mysql_fetch_array($resTrashQuery);
?>
<div class="lftPannel2 fl">
   <div class="user-list" style="margin-top:0px !important;">
    <h3>Messages</h3>
    <ul>
      <li><img src="<?=SITE_WS_PATH?>/images/icon/home.png" width="22" height="22" align="absmiddle" />&nbsp;&nbsp;<a href="<?=SITE_WS_PATH?>/inbox.php">Inbox <?php if($collesInboxQuery['inboxCount']>0) { ?>(<?=$collesInboxQuery['inboxCount']?>) <?php } ?></a></li>
      <li><img src="<?=SITE_WS_PATH?>/images/icon/message.png" width="22" height="22" align="absmiddle"/>&nbsp;&nbsp;<a href="<?=SITE_WS_PATH?>/message.php">New Message</a></li>
      <li><img src="<?=SITE_WS_PATH?>/images/icon/sent.png" width="22" height="22" align="absmiddle"/>&nbsp;&nbsp;<a href="<?=SITE_WS_PATH?>/sent.php">Sent <?php if($collesSentQuery['sendCount']>0) { ?>(<?=$collesSentQuery['sendCount']?>) <?php } ?></a></li>
      <li><img src="<?=SITE_WS_PATH?>/images/icon/trash.png" width="22" height="22" align="absmiddle"/>&nbsp;&nbsp;<a href="<?=SITE_WS_PATH?>/trash.php">Trash <?php if($collesTrashQuery['trashCount']>0) { ?>(<?=$collesTrashQuery['trashCount']?>) <?php } ?></a></li>
    </ul>
  </div>
</div>