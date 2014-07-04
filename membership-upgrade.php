<?php 
require_once "config/functions.inc.php";
require_once "session.inc.php"; 
$pageName = basename($_SERVER['PHP_SELF']); 
$sql = "SELECT * FROM membership_upgrade_master WHERE Status=1 ORDER BY Membership_Package_Amount";
$result = mysql_query($sql);

/*$sqlCount = "SELECT COUNT(*) AS Ctotal FROM product_master WHERE Member_Account_Id='".$_SESSION['SESS_ID']."' AND Type='3'";
$resCount = mysql_query($sqlCount);
$collesCount = mysql_fetch_array($resCount);*/
 $sqlMusicianCount = "SELECT COUNT(*) AS CMusicianTotal FROM product_master WHERE Member_Account_Id='".$_SESSION['SESS_ID']."' ";
 $resMusicianCount = mysql_query($sqlMusicianCount);
 $collesMusicianCount = mysql_fetch_array($resMusicianCount);

 $sql_membership_check = "SELECT * FROM membership_upgrade_history_master WHERE Member_Account_Id='".$_SESSION['SESS_ID']."' AND Status=1";
 $result_membership_check = mysql_query($sql_membership_check);
 
 $sql_membership_check1 = "SELECT * FROM membership_upgrade_history_master WHERE Member_Account_Id='".$_SESSION['SESS_ID']."' AND Status=0";
 $result_membership_check1 = mysql_query($sql_membership_check1);
 
if(mysql_num_rows($result_membership_check)>0)
{
$sql_notes = "SELECT sum(b.Membership_No+5) as notesTotal FROM membership_upgrade_master a JOIN membership_upgrade_history_master b ON (a.Membership_Upgrade_Id=b.Membership_Upgrade_Id) WHERE a.Status='1' AND b.Status='1' AND b.Member_Account_Id='".$_SESSION['SESS_ID']."'";
$result_notes = mysql_query($sql_notes);
$colles_notes = mysql_fetch_array($result_notes);
 $NOTES = $colles_notes['notesTotal'];
	if($NOTES=='')
	{
	$TOTAL_NOTES = 0;
	}
	else
	{
	$collesMusicianCount['CMusicianTotal'];
	$TOTAL_NOTES = $NOTES-$collesMusicianCount['CMusicianTotal'];
	}
}
elseif(mysql_num_rows($result_membership_check1)>0)
{

		 $sql_notes = "SELECT sum(b.Membership_No+5) as notesTotal FROM membership_upgrade_master a JOIN membership_upgrade_history_master b ON (a.Membership_Upgrade_Id=b.Membership_Upgrade_Id) WHERE a.Status='1' AND b.Status='1' AND b.Member_Account_Id='".$_SESSION['SESS_ID']."'";
        $result_notes = mysql_query($sql_notes);
        $colles_notes = mysql_fetch_array($result_notes);
        $NOTES = $colles_notes['notesTotal'];
		if($NOTES=='')
		{
		$TOTAL_NOTES = 0;
		$TOTAL_VALUE = 0;
		}
		else
		{
		$collesMusicianCount['CMusicianTotal'];
		$TOTAL_NOTES = $NOTES-$collesMusicianCount['CMusicianTotal'];
		}
}
else
{
$TOTAL_NOTES = 5-$collesMusicianCount['CMusicianTotal'];
}






$sqlMemberShip = "SELECT * FROM membership_upgrade_history_master WHERE Member_Account_Id='".$_SESSION['SESS_ID']."' AND Status=1";
$resultMemberShip = mysql_query($sqlMemberShip);
$collesMemberShip = mysql_fetch_array($resultMemberShip);
$sqlMemberShip1 = "SELECT * FROM membership_upgrade_history_master WHERE Member_Account_Id='".$_SESSION['SESS_ID']."' AND Status=0";
$resultMemberShip1 = mysql_query($sqlMemberShip1);
$collesMemberShip1 = mysql_fetch_array($resultMemberShip1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>Upgrade Membership</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="description" content="Default Description">
<meta name="keywords" content="">
<meta name="robots" content="">
<?php include "common.inc.php"; ?>
<style type="text/css">
/*=== <<< TIP TIP >>> ===*/
#tiptip_holder {display: none; position: absolute;	top: 0;	left: 0; z-index: 99999; /*background:url(images/arrow-1.png) center top no-repeat;*/}
#tiptip_holder.tip_top {padding-bottom: 5px;}
#tiptip_holder.tip_bottom {padding-top: 5px;}
#tiptip_holder.tip_right {padding-left: 5px;}
#tiptip_holder.tip_left {padding-right: 5px;}
#tiptip_content {font-size: 11px; color: #000;  padding: 4px 8px;	border: 1px solid rgba(255,255,255,0.25); background:#FFFFFF; border-radius: 3px;	-webkit-border-radius: 3px;	-moz-border-radius: 3px;	box-shadow: 0 0 3px #555;	-webkit-box-shadow: 0 0 3px #555;	-moz-box-shadow: 0 0 3px #555;	margin:3px 0 0 0;}
#tiptip_arrow, #tiptip_arrow_inner { position: absolute;	border-color: transparent;	border-style: solid;	border-width: 6px;	height: 0;	width: 0;}
#tiptip_holder.tip_top #tiptip_arrow {	border-top-color: #fff;	border-top-color: #FFF;}
#tiptip_holder.tip_bottom #tiptip_arrow {	border-bottom-color: #fff;	border-bottom-color: #FFF;}
#tiptip_holder.tip_right #tiptip_arrow {	border-right-color: #fff;	border-right-color: #FFF;}
#tiptip_holder.tip_left #tiptip_arrow {	border-left-color: #fff;	border-left-color: #FFF;}
#tiptip_holder.tip_top #tiptip_arrow_inner {	margin-top: -7px;	margin-left: -6px;	border-top-color:#FFF;	border-top-color: #FFF;}
#tiptip_holder.tip_bottom #tiptip_arrow_inner {	margin-top: -5px;	margin-left: -6px;	border-bottom-color: #FFF;	border-bottom-color: #FFF;}
#tiptip_holder.tip_right #tiptip_arrow_inner {	margin-top: -6px;	margin-left: -5px;	border-right-color: #FFF;	border-right-color: #FFF;}
#tiptip_holder.tip_left #tiptip_arrow_inner {	margin-top: -6px;	margin-left: -7px;	border-left-color: #FFF;	border-left-color: #FFF;}
</style>
<script type="text/javascript" src="javascript/jquery.tipTip.js"></script>
<script type="text/javascript" src="javascript/jquery.tipTip.minified.js"></script>

<script type="text/javascript" src="<?=SITE_WS_PATH?>/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="<?=SITE_WS_PATH?>/fancybox/jquery.fancybox-1.3.4.css" media="screen" />


<script language="javascript">
function upgrade_prompt(id)
{
 window.location.href = "upgrade-membership-to-cart.php?id="+id;
}

$(function(){
    $(".trigger").tipTip({maxWidth: "auto", edgeOffset: 10});
  });
</script>


<script type="text/javascript">
  $(document).ready(function(){
	 $("#fancybox-closeme").click(function(){
    //Name is alerted
    //code to close fancy box(Not working)
    $.fancybox.close();
    });

	  

	$("#upgradeaccount").fancybox({
				'overlayShow'	: true,
				'transitionIn'	: 'elastic',
				'padding'		: 0,
				'transitionOut'	: 'elastic'
			}).trigger("click");		
});




</script>


</head>

<body>
<?php include "header.middle.inc.php"; ?>
<div id="wrapper">

     <!-- 	Remove This after website launch -->
<a id="upgradeaccount.." href="#upgradeaccount-run" style="display:none"></a>
<div style="display:none;"><div id="upgradeaccount-run" style="width:951px;height:596px; padding:0 0px; color:#000; background:url(../images/mussino_membership_popup.jpg)">
<!--<div class="upgradebtn">
<a href="http://mussino.com/membership-upgrade.php"><img src="../images/upgradebtn.png" /></a>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a id="fancybox-closeme" style="display: inline;"><img src="../images/notnowbtn.png" /></a>
</div>-->
</div></div>
<!-- /Remove This after website launch -->

<div class="content-container">
<?php include "header.top.inc.php"; ?>
<div class="content-box-2">
      <div class="cor_1set-5"></div>
      <div class="cor_1set-6"></div>
      <div class="account-wrapper">
      <h3 class="fl"><img src="images/member_card.png" width="30" align="absmiddle" /> <strong>Membership</strong> Upgrade </h3>
      <p class="dis">By upgrading your membership, you can <strong>create more sessions and use your music store to sell Instrumentals</strong>. Mussino starts your account with 5 free credits. Once you run out of credits, you will need to upgrade your account. See Mussino New Releases section <a href="unreleased-music.php" target="_blank">click here</a>. </p>
      <?php if($_SESSION['sess_mess']!=''){ ?>
      <div style="padding:40px 0 0 234px; color:#FF0000; font-weight:bold;"><?=$_SESSION['sess_mess']?> <?php $_SESSION['sess_mess']='';?></div>
      <?php } ?>
      <div class="cl"></div>
        <div class="account-widget">
          <div class="post-box">
            <div class="img">
            <div style="padding: 0 0 15px 0;">
			<?php if(mysql_num_rows($resultMemberShip)>0) { ?> 
			<?=stripslashes(Get_Single_Field("membership_upgrade_master","Membership_Package_Desc","Membership_Upgrade_Id","$collesMemberShip[Membership_Upgrade_Id]"))?>
            <?php } elseif(mysql_num_rows($resultMemberShip1)>0) { ?> 
            <?php  echo "0 Free Credits"; ?>
			<?php } else { echo "5 Free Credits"; } ?>
            </div>
            <a href="<?=SITE_WS_PATH?>/<?=trim($collesMemberShip['Member_Account_Id'])?>/<?=ucfirst(stripslashes(Get_Single_Field("member_account_master","First_Name","Member_Account_Id","$collesMemberShip[Member_Account_Id]")))?>" >
            <?php $photo = Get_Single_Field("member_account_master","Photo","Member_Account_Id","$collesMemberShip[Member_Account_Id]"); ?>
			<?php if(file_exists("products/user_image/$photo") && $photo!='') { ?>
            <img src="products/user_image/<?php echo $photo; ?>" border="0" width="60" height="60"  />
            <?php } else { ?>
            <img src="images/user_big.png" border="0" width="60" height="60" />
            <?php } ?>
            </a> Current Credits Left: <?=$TOTAL_NOTES?> </div>
            
            <div class="cl"></div>
          </div>
          <div class="package-box">
            <ul>
              <?php
			  if(mysql_num_rows($result)>0)
			  {
			  while($colles = mysql_fetch_array($result))
			  {
			  ?>
              <li>
                <div class="left">
                  <h4><?=stripslashes($colles['Membership_Package_Name'])?> <img src="images/question.png" width="20" height="20" align="absmiddle" title="<?=stripslashes($colles['Help_Desc'])?>" class="trigger" /></h4>
                  <p>$<?=trim($colles['Membership_Package_Amount'])?>/month</p>
                </div>
                <div class="right">
                  <h4 class="fl"><?=stripslashes($colles['Membership_Package_Desc'])?></h4>
                   
                  <div class="grn-btn fr">
                    <a href="javascript:void(0);" onclick="upgrade_prompt('<?=$colles['Membership_Upgrade_Id']?>');"><span>Buy Now</span></a>
                  </div>
                  
                  <div class="cl"></div>
                </div>
                <div class="cl"></div>
              </li>
              <?php
			  }
			  }
			  else
			  {
			  echo '<li>
                <div class="left">
                  <h4>No records</h4></div>
                <div class="cl"></div>
              </li>';
			  }
			  ?>
              
            </ul>
          </div>
          <div class="cl"></div>
        </div>
      </div>
      <div class="cor_1set-3"></div>
      <div class="cor_1set-4"></div>
    </div>

<?php if($_SESSION['SESS_ID']!='') { ?>
<?php include"footer-div.inc.php"; ?>
<?php } ?>
</div>
</div>
</div>
<?php include "footer.inc.php"; ?>
</body>
</html>