<?php 
require_once "config/functions.inc.php"; 
if($_SESSION['SESS_ACCOUNT_TYPE']=='Musician') {
$sql_membership_date = "SELECT DATE_FORMAT(a.Order_Date,'%b %Y') as sTpAYdATE, DATE_FORMAT(a.Next_Order_Date,'%m-%d-%Y') as nEXTpAYrECdATE
		                FROM member_account_master u JOIN orders a ON (u.Member_Account_Id=a.Member_Account_Id)
		                JOIN membership_upgrade_history_master b ON (a.Member_Account_Id=b.Member_Account_Id and a.O_Id=b.O_Id) 
				        JOIN membership_upgrade_master c ON (b.Member_Account_Id=a.Member_Account_Id and b.Membership_Upgrade_Id=c.Membership_Upgrade_Id) 
		                WHERE 
						u.Status=1 AND 
						a.Status=1 AND 
						b.Status=1 AND 
						c.Status=1 AND 
						a.Member_Account_Id='".$_SESSION['SESS_ID']."' AND
						(a.Next_Order_Date !='' || a.Next_Order_Date !='0000-00-00')
						group by a.Member_Account_Id";
$result_membership_date = mysql_query($sql_membership_date) or die('<br>'.$sql_membership_date.'<br>'.mysql_error());
$cOL_mEM_dATE = mysql_fetch_array($result_membership_date);
}elseif($_SESSION['SESS_ACCOUNT_TYPE']=='Artist') {

$sql_membership_date = "SELECT DATE_FORMAT(a.Order_Date,'%b %Y') as sTpAYdATE, DATE_FORMAT(a.Next_Order_Date,'%m-%d-%Y') as nEXTpAYrECdATE  
						FROM member_account_master u JOIN orders a ON (u.Member_Account_Id=a.Member_Account_Id)
						JOIN membership_artist_upgrade_history_master b ON (a.Member_Account_Id=b.Member_Account_Id and a.O_Id=b.O_Id) 
						JOIN membership_artist_upgrade_master c ON (b.Member_Account_Id=a.Member_Account_Id and b.Membership_Upgrade_Id=c.Membership_Upgrade_Id) 
						WHERE 
						u.Status=1 AND 
						a.Status=1 AND
						b.Status=1 AND 
						c.Status=1 AND  
						a.Member_Account_Id='".$_SESSION['SESS_ID']."' AND
						(a.Next_Order_Date !='' || a.Next_Order_Date !='0000-00-00')
						group by u.Member_Account_Id";
$result_membership_date = mysql_query($sql_membership_date) or die('<br>'.$sql_membership_date.'<br>'.mysql_error());
$cOL_mEM_dATE = mysql_fetch_array($result_membership_date);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>Profile</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="description" content="Default Description">
<meta name="keywords" content="">
<meta name="robots" content="">
<?php include "common.inc.php"; ?>
<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
<script type="text/javascript" src="<?=SITE_WS_PATH?>/script/jquery.tinycarousel.min.js"></script>
<script type="text/javascript" src="<?=SITE_WS_PATH?>/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="<?=SITE_WS_PATH?>/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="<?=SITE_WS_PATH?>/fancybox/jquery.fancybox-1.3.4.css" media="screen" />



<script type="text/javascript">

function showHowTo(){
	 $("#howtoSlides").show();
	}
	
	
function seeprofile() {
	$.fancybox.close();
	}	
	
  $(document).ready(function(){
	  
	 $("#fancybox-closeme").click(function(){
    //Name is alerted
    //code to close fancy box(Not working)
    $.fancybox.close();
    });
	
	
$("#about-user").mouseover(function() {	
  $(".aboutslide").animate({"top": "+=520px"}, "fast").animate({opacity: 1,}, 1500 );
});

$("#about-user").mouseout(function() {
  $(".aboutslide").animate({opacity: 0,}, 1500 ).animate({"top": "-=520px"}, "fast");
});



	  
	$('#slider2').tinycarousel({ display: 2 });
	$('#slider3').tinycarousel({ display: 2 });
	$('#slider4').tinycarousel({ display: 2 });
	$('#slider5').tinycarousel({ display: 2 });
	$('#slider6').tinycarousel({ display: 2 });
	$("#variousCollaborate").fancybox({
				'overlayShow'	: true,
				'transitionIn'	: 'elastic',
				'padding'		: 0,
				'transitionOut'	: 'elastic'
			});
	$("#variousNotebook").fancybox({
				'overlayShow'	: true,
				'transitionIn'	: 'elastic',
				'padding'		: 0,
				'transitionOut'	: 'elastic'
			});
	$("#variousCollaborateMsg").fancybox({
				'overlayShow'	: true,
				'transitionIn'	: 'elastic',
				'padding'		: 0,
				'transitionOut'	: 'elastic'
			});
	$("#variousMembershipUpgrade").fancybox({
				'overlayShow'	: true,
				'transitionIn'	: 'elastic',
				'padding'		: 0,
				'transitionOut'	: 'elastic'
			});
	$("#upgradeaccount").fancybox({
				'overlayShow'	: true,
				'transitionIn'	: 'elastic',
				'padding'		: 0,
				'transitionOut'	: 'elastic'
			})	
			
		
		if (!showdash_popup) {
				$("#songwriter_dashboard").fancybox({
				'overlayShow'	: true,
				'transitionIn'	: 'elastic',
				'padding'		: 0,
				'transitionOut'	: 'elastic'
			})
	}
			
			$("#songwriter_dashboard").fancybox({
				'overlayShow'	: true,
				'transitionIn'	: 'elastic',
				'padding'		: 0,
				'transitionOut'	: 'elastic'
			})	
			
});

</script>

<!-- HOW TO PACKAGE -->
<link rel="stylesheet" type="text/css" href="<?=SITE_WS_PATH?>/howto/css/howto.css" />
<script language="JavaScript" src="http://mussino.com/servertime.php"></script>
<script src="<?=SITE_WS_PATH?>/howto/js/jquery.scrollTo-min.js"></script>
<script src="<?=SITE_WS_PATH?>/howto/js/jquery.scrollTo.js"></script>
<script src="<?=SITE_WS_PATH?>/howto/js/howto.js"></script>
<!-- / HOW TO PACKAGE -->



<!-- Animated collapse -->
<script type="text/javascript" src="http://www.mussino.com/javascript/animatedcollapse.js"></script>

<script type="text/javascript">

animatedcollapse.addDiv('active_session', 'fade=1')
animatedcollapse.addDiv('instrumental_store', 'fade=1')
animatedcollapse.addDiv('sell_session', 'fade=1')
animatedcollapse.addDiv('music_store', 'fade=1')

animatedcollapse.ontoggle=function($, divobj, state){ //fires each time a DIV is expanded/contracted
	//$: Access to jQuery
	//divobj: DOM reference to DIV being expanded/ collapsed. Use "divobj.id" to get its ID
	//state: "block" or "none", depending on state
}

animatedcollapse.init()
</script>
<!-- Animated collapse -->
  <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
</head>

<body>

<script type="text/javascript" src="<?=SITE_WS_PATH?>/wz_tooltip.js"></script>
<?php include "header.middle.inc.php"; ?>
<div id="wrapper">

<!-- HOW TO INCLUDE IN DOCUMENTS include_once("howto/musician_howto_a.php");-->
<?#php if($_SESSION['SESS_ACCOUNT_TYPE']=='Musician') {  
 include_once("howto/musician_howto_a.php");
 ?>
<!-- Dashboard Content 
  <a id="songwriter_dashboard" href="#songwriter_dashboardrun"><img src="http://mussino.com/images/info.png" align="absmiddle" width="25" /> My Dashboard</a>  

<?#php  include "dashboard_musician.php"; ?>
<!-- / Dashboard Content --> 
   <?#php }?>
    
    
<?#php if($_SESSION['SESS_ACCOUNT_TYPE']=='Artist') {
include_once("howto/artist_howto_a.php");
?>
<!-- Dashboard Content 
  <a id="songwriter_dashboard" href="#songwriter_dashboardrun"><img src="http://mussino.com/images/info.png" align="absmiddle" width="25"/> My Dashboard</a>  
<?#php   include "dashboard_artist.php"; ?>
<!-- / Dashboard Content -->
<?#php }?>
<!-- /  HOW TO INCLUDE IN DOCUMENTS -->


<div class="content-container">
<?php include "header.top.inc.php"; ?>
    


<?php include "profile-middle2.php"; ?>
</div>
</div>
</div>

<?php include "footer.inc.php"; ?>
</body>
</html>