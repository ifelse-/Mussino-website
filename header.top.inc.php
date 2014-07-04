<?php 
require_once "config/functions.inc.php";
$inboxMainQuery = "SELECT COUNT(1) AS inboxCount FROM message_master WHERE To_Id='".$_SESSION['SESS_ID']."' AND Sent=1 AND Read_Status=0 AND To_Temp!='".$_SESSION['SESS_ID']."'";
$resInboxMainQuery = mysql_query($inboxMainQuery);
$collesInboxMainQuery = mysql_fetch_array($resInboxMainQuery);

$collGetId = $_REQUEST['user'];
if(trim($_SESSION['SESS_ID']))
{
$userID = trim($_SESSION['SESS_ID']);
$userName = $_SESSION['SESS_FIRST_NAME'];
}
else
{
$userID = trim(Get_Single_Field("member_account_master","Member_Account_Id","Member_Account_Id","$collGetId"));
$userName = ucfirst(stripslashes(Get_Single_Field("member_account_master","First_Name","Member_Account_Id","$collGetId")));
} 
?>
<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">

<div id="siteBG">

<div class="rit_small-link">

<div class="socialNetwork">
<!--<a href="/registration.php" target="_blank"><img src="<?=SITE_WS_PATH?>/images/mussinoNetwork_tag.png" /></a>&nbsp;&nbsp;-->
<a href="http://www.youtube.com/user/MussinoNetwork" target="_blank"><img src="<?=SITE_WS_PATH?>/images/youtube.png" /></a>&nbsp;&nbsp;
<a href="http://www.facebook.com/Mussino.Music.Industry" target="_blank"><img src="<?=SITE_WS_PATH?>/images/facebook.png" /></a>
&nbsp;&nbsp;
<a href="http://www.myspace.com/mussino" target="_blank"><img src="<?=SITE_WS_PATH?>/images/myspace.png" /></a>&nbsp;&nbsp;

<a href="https://twitter.com/#!/MussinoNetwork" target="_blank"><img src="<?=SITE_WS_PATH?>/images/twitter-2.png" /></a>
&nbsp;&nbsp;
<span class="socialtxt">Follow us</span>
</div>

  <ul>
    <li><?php if($_SESSION['SESS_EMAIL']!='') { ?><strong>Hey <i class="fa fa-user"></i>  <?=$_SESSION['SESS_FIRST_NAME']?>! <img src="<?=SITE_WS_PATH?>/images/lock_open.png" align="absmiddle" /></strong><?php } ?></li>
    <li><?php if($_SESSION['SESS_ID']=='' && $collGetId=='') { ?><a href="login.php" title="My Account"><?php /*?><img src="<?=SITE_WS_PATH?>/images/lock.png" align="absmiddle" /> <?php */?><!--<span style="color: #F60"><strong>Studio Account</strong></span>--></a><?php } else { ?> <a href="<?=SITE_WS_PATH?>/<?=$userID?>/<?=$userName?>" title="My Account"><i class="fa fa-caret-square-o-right"></i> <span><strong>My Studio Account</strong></span></a>  <?php } ?></li>      
    
    <?php if($_SESSION['SESS_EMAIL']!='') { ?>
   <li><a href="<?=SITE_WS_PATH?>/favorite-musician.php" title="Favorite Musician"><!--<img src="<?=SITE_WS_PATH?>/images/user_check(1).png" align="absmiddle" width="20" /> -->Favorite Musician</a></li>   
    <?php } ?>
    
    <?php 
		  if($_SESSION['SESS_ACCOUNT_TYPE']=='Artist') 
		  { 
		  
		  if($_SESSION['SESS_ID']!='') 
		  { 
		  
          $sql_notes_pp = "SELECT sum(a.No_Of_Package) as notesTotalPP FROM package_master a LEFT JOIN package_history_master b ON (a.Package_Id=b.Package_Id)
                        WHERE a.Status='1' AND b.Status='1' AND b.Member_Account_Id='".$_SESSION['SESS_ID']."'";
          $result_notes_pp = mysql_query($sql_notes_pp);
		  
		  $sql_notes_upgrade = "SELECT sum(a.Membership_No) as notesTotalUP FROM membership_artist_upgrade_master a LEFT JOIN membership_artist_upgrade_history_master b ON (a.Membership_Upgrade_Id=b.Membership_Upgrade_Id)
						WHERE a.Status='1' AND b.Status='1' AND b.Member_Account_Id='".$_SESSION['SESS_ID']."'";
		  $result_notes_up = mysql_query($sql_notes_upgrade);
		  
		  			
			if(mysql_num_rows($result_notes_pp)>0 || mysql_num_rows($result_notes_up)>0)
			{
				$colles_notes_pp = mysql_fetch_array($result_notes_pp);
				$NOTES_PP = $colles_notes_pp['notesTotalPP'];
				$colles_notes_up = mysql_fetch_array($result_notes_up);
				$NOTES_UP = $colles_notes_up['notesTotalUP'];
								
				$sql_bank_notes_pp = "SELECT sum(Notes_Value) as bankNotesTotalPP FROM my_bank WHERE From_Member_Account_Id='".$_SESSION['SESS_ID']."'";
				$result_bank_notes_pp = mysql_query($sql_bank_notes_pp);
				$colles_bank_notes_pp = mysql_fetch_array($result_bank_notes_pp);
				if(mysql_num_rows($result_bank_notes_pp)>0)
				{
				$BANK_NOTES_PP = $colles_bank_notes_pp['bankNotesTotalPP'];
				}
				else
				{
				$BANK_NOTES_PP = 0;
				}
				$TOTAL_NOTES_PP = $NOTES_PP+$NOTES_UP-$BANK_NOTES_PP;
			?>
            <li><a href="javascript:void(0);" title="My Notes" style="cursor:text;">Credits: <?=$TOTAL_NOTES_PP;?></a></li>   
            <?php
            }
            else
            {
            ?>
            <li><a href="javascript:void(0);" title="My Notes" style="cursor:text;">Credits: 0</a></li>
            <?php } } } ?>
            <?php if($_SESSION['SESS_ACCOUNT_TYPE']=='Artist') { ?> 
            <li><a href="<?=SITE_WS_PATH?>/notes-plan.php" title="Notes">Get Credits</a></li>
            <?php } ?>
            <?php if($_SESSION['SESS_ID']!='') { ?><li><a href="<?=SITE_WS_PATH?>/inbox.php" title="Message">Messages <?php if($collesInboxMainQuery['inboxCount']>0) { ?>(<?=$collesInboxMainQuery['inboxCount']?>) <?php } ?></a></li>  <?php } ?> 
            
            <?php if($pageName!='my-cart.php' && $_SESSION['SESS_ID']!='') { ?>
          <li><i class="fa fa-shopping-cart"></i> &nbsp;<a href="<?=SITE_WS_PATH?>/my-cart.php" title="Cart">Cart</a></li>
            <?php } ?>
              
  </ul>
  <div class="cl"></div>
</div>




