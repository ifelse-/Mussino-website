<?php 
require_once "config/functions.inc.php";
require_once "session.inc.php"; 
$pageName = basename($_SERVER['PHP_SELF']); 
$sql = "SELECT * FROM membership_artist_upgrade_master WHERE Status=1 ORDER BY Membership_Package_Amount";
$result = mysql_query($sql);
$sqlAudioCount = "SELECT COUNT(*) AS CtotalAudio FROM lyrics_post_audio_master WHERE Member_Account_Id='".$_SESSION['SESS_ID']."' AND Lyrics_Audio_Type='AUDIO' AND Status=1";
$resAudioCount = mysql_query($sqlAudioCount);
$collesAudioCount = mysql_fetch_array($resAudioCount);
$sqlVideoCount = "SELECT COUNT(*) AS CtotalVideo FROM lyrics_post_audio_master WHERE Member_Account_Id='".$_SESSION['SESS_ID']."' AND Lyrics_Audio_Type='VIDEO' AND Status=1";
$resVideoCount = mysql_query($sqlVideoCount);
$collesVideoCount = mysql_fetch_array($resVideoCount);
$sqlTextCount = "SELECT COUNT(*) AS CtotalText FROM lyrics_post_master WHERE Member_Account_Id='".$_SESSION['SESS_ID']."' AND Status=1";
$resTextCount = mysql_query($sqlTextCount);
$collesTextCount = mysql_fetch_array($resTextCount);

$totalPost = $collesAudioCount['CtotalAudio'] + $collesVideoCount['CtotalVideo'] + $collesTextCount['CtotalText'];

$sqlMemberShip = "SELECT * FROM membership_artist_upgrade_history_master WHERE Member_Account_Id='".$_SESSION['SESS_ID']."' AND Status=1";
$resultMemberShip = mysql_query($sqlMemberShip);
$collesMemberShip = mysql_fetch_array($resultMemberShip);
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
#tiptip_content {font-size: 15px; color: #fff;  padding: 9px 8px;	border: 1px solid rgba(255,255,255,0.25); background: #069; border-radius: 3px;	-webkit-border-radius: 3px;	-moz-border-radius: 3px;	box-shadow: 0 0 3px #555;	-webkit-box-shadow: 0 0 3px #555;	-moz-box-shadow: 0 0 3px #555;	margin:3px 0 0 0; width:300px;}
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
 window.location.href = "artist-upgrade-membership-to-cart.php?id="+id;
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
<div id="wrapper">

   <!-- 	Remove This after website launch -->
<a id="upgradeaccount.." href="#upgradeaccount-run" style="display:none"></a>
<div style="display:none;"><div id="upgradeaccount-run" style="width:822px;height:596px; padding:0 0px; color:#000; background:url(../images/mussino_songwriter_membership_popup.jpg)">
<!--<div class="upgradebtn">
<a href="http://mussino.com/artist-membership-upgrade.php"><img src="../images/upgradebtn.png" /></a>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a id="fancybox-closeme" style="display: inline;"><img src="../images/notnowbtn.png" /></a>
</div>
--></div></div>
<!-- /Remove This after website launch -->

<?php include "header.middle.inc.php"; ?>
<div class="content-container">
<?php include "header.top.inc.php"; ?>
<div class="content-box-2">
      <div class="cor_1set-5"></div>
      <div class="cor_1set-6"></div>
      <div class="account-wrapper">
      <h3 class="fl"><img src="images/member_card.png" width="30" align="absmiddle" /> <strong>Membership</strong> Upgrade </h3>
      <p class="dis">By upgrading your membership, you’ll get access to upload audio or video session files. You will get a member badge on your account. This is a way to <strong>highlight your performance</strong>.<br /> <br />Judges will view all submitted sessions to determine a winner. You will receive an email once session closed.</p>
      <?php if($_SESSION['sess_mess']!=''){ ?>
      <div style="padding:40px 0 0 234px;"><?=$_SESSION['sess_mess']?> <?php $_SESSION['sess_mess']='';?></div>
      <?php } ?>
      <div class="cl"></div>
        <div class="account-widget">
          <div class="post-box">
            <div class="img">
            <div style="padding: 0 0 15px 0;"><?php if(mysql_num_rows($resultMemberShip)>0) { ?> <?=stripslashes(Get_Single_Field("membership_artist_upgrade_master","Membership_Package_Desc","Membership_Upgrade_Id","$collesMemberShip[Membership_Upgrade_Id]"))?> <?php } else { echo "Free Account"; } ?></div>
            <a href="<?=SITE_WS_PATH?>/<?=trim($collesMemberShip['Member_Account_Id'])?>/<?=ucfirst(stripslashes(Get_Single_Field("member_account_master","First_Name","Member_Account_Id","$collesMemberShip[Member_Account_Id]")))?>" ></a>
            <?php $photo = Get_Single_Field("member_account_master","Photo","Member_Account_Id","$collesMemberShip[Member_Account_Id]"); ?>
			<?php if(file_exists("products/user_image/$photo") && $photo!='') { ?>
            <img src="products/user_image/<?php echo $photo; ?>" border="0" width="60" height="60"  />
            <?php } else { ?>
            <img src="images/user_big.png" border="0" width="60" height="60" />
            <?php } ?> Your current posts: <?=$totalPost?> </div>
           
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
                  <p>$<?=trim($colles['Membership_Package_Amount'])?><?php if($colles['Membership_Upgrade_Id']!='1') { ?>/month<?php } ?></p>
                </div>
                <div class="right">
                  <h4 class="fl"><?=stripslashes($colles['Membership_Package_Desc'])?></h4>
                  <?php if($colles['Membership_Upgrade_Id']!=1) { ?>
                  <div class="grn-btn fr">
                    <a href="javascript:void(0);" onclick="upgrade_prompt('<?=$colles['Membership_Upgrade_Id']?>');"><span>Buy Now</span></a>
                  </div>
                  <?php } ?>
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
<?php include "footer.inc.php"; ?>
</body>
</html>>