<?php 
require_once "config/functions.inc.php";
if($_SESSION['SESS_ACCOUNT_TYPE']!='Artist') { $_SESSION["SESS_MSG"]='You have not access this page'; header("location:error.php"); exit(0); }
$start=0;
if(isset($_GET['start'])) $start=$_GET['start'];
if($_SESSION['PAGESIZE']!='')
{
$pagesize=$_SESSION['PAGESIZE'];
}
else
{
$pagesize=20;
}

if($_GET['order_by']=='') { $order_by="No_Of_Package"; } else { $order_by=$_REQUEST['order_by'];}

if($_GET['order_by2']=='') { $order_by2="ASC"; } else { $order_by2=$_REQUEST['order_by2'];}

$column="select * ";

$sql=" FROM package_master where  Status=1  ";



$sql1="select count(*) as total ".$sql;

$sql=$column.$sql;

$sql.=" order by $order_by $order_by2 ";

$sql.=" limit $start, $pagesize";

$result=executequery($sql);

$reccnt=getSingleResult($sql1);

$sql_member = "SELECT * FROM member_account_master WHERE Member_Account_Id='".$_SESSION['SESS_ID']."'";
$result_member = mysql_query($sql_member);
$colles_member = mysql_fetch_array($result_member);



if($_REQUEST['status']!='' && $_REQUEST['u_no']!='')
{
$sql_status= " UPDATE invite_feiends_log SET Status = '".trim($_REQUEST['status'])."'	WHERE	U_No = '".$_REQUEST['u_no']."'";
mysql_query($sql_status);
header('location:notes-plan.php');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>Home page</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="description" content="Default Description">
<meta name="keywords" content="">
<meta name="robots" content="">
<?php include "common.inc.php"; ?>

<script type="text/javascript" src="fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="fancybox/jquery.fancybox-1.3.4.css" media="screen" />
<script language="javascript">
$(document).ready(function(){
$("#variousInviteFriends").fancybox({
				'overlayShow'	: true,
				'transitionIn'	: 'elastic',
				'transitionOut'	: 'elastic'
			});
			
$("#variousActiveLogs").fancybox({
				'overlayShow'	: true,
				'transitionIn'	: 'elastic',
				'transitionOut'	: 'elastic'
			});
$("#variousRegister").fancybox({
				'overlayShow'	: true,
				'transitionIn'	: 'elastic',
				'transitionOut'	: 'elastic'
			});
			});
function buy_prompt(id)
{
 window.location.href = "buy-notes-to-cart.php?id="+id;
}


function searchRequest(id)
{
 
  for (i=0;i<document.frmSearch.action.length;i++) 
	{ 
			if (document.frmSearch.action[i].checked==true) 
			{
			var action = document.frmSearch.action[i].value;
			}
			
	}
	
	var Reason = document.getElementById('Reason'+id).value;
	
	
		
 window.location.href = "search-request.php?id="+id+"&action="+action+"&Reason="+Reason;
}
</script>
</head>
<body>
<script type="text/javascript" src="wz_tooltip.js"></script>
<div id="wrapper">
  <!-- HEADER -->
  <?php include "header.middle.inc.php"; ?>
  <div class="content-container">
    <?php include "header.top.inc.php"; ?>
    <!-- TOP SPOTLIGHT 1 -->
    <div class="content-box-2">
      <div class="cor_1set-5"></div>
      <div class="cor_1set-6"></div>
      <div class="pro-wrapper full">
        <div class="title">
          <div class="title_wrap-1">
            <div class="title_wrap-2">
              <div class="blue-btn-1"> <span><span>Buy Credits</span></span> </div>
            </div>
          </div>
        </div>
        <div class="pro-content notes-nw">
          <h2>Stack up your Credits <span>You need Credits in order to<strong> copyright and enter a session to earn royalties</strong></span></h2>
          <p class="small-txt">Here's the deal. There is no limit to the amount of Credits you can purchase. Sessions can range from 1 to 5 Credits. Sessions that require 5 or more Credits are higher in value.The more Credits you accumulate, the more sessions you can enter, the more money you can make. Each time you enter a session and post lyrics your material will be copywritten and dated in your Archive History. Mussino is not limited to a specific audience, all genres of music is available giving every artist a chance to experience diversity. <strong>  </strong> </p>
          <div class="notes-wrapper fl">
          
          	<?php
			$ct=0;
			while($line=mysql_fetch_array($result))
			{
			$bgcolor = ($ct%2==0? '#E8F3FE': '#eeeeee');
			?>
            <div class="notes-info">
              <h3><img src="images/currency_dollar_red.png" width="20" align="absbottom" /> <?=stripslashes($line['Package_Name']);?> <?php /*?><?=$line['No_Of_Package'];?> <?php */?><span class="add-btn">$<?=$line['Package_Amount'];?> <span><a href="javascript:void(0);" onclick="buy_prompt('<?=$line['Package_Id']?>');">Add</a></span></span></h3>
              <p><?=stripslashes($line['Package_Desc']);?></p>
            </div>
           <?php
			$ct++;
			}
			?>
          </div>
          
          <?php if($_SESSION['SESS_ACCOUNT_TYPE']=='Artist' || $_SESSION['SESS_ACCOUNT_TYPE']=='Musician')	{ ?>
          <div class="blue-block fr">
            <div class="cor_4set-1"></div>
            <h4><?=$colles_member['First_Name']?></h4>
            <div class="blue-block-wrap-1">
              <div class="user-img fl">
              <a href="<?=SITE_WS_PATH?>/<?=$_SESSION['SESS_ID']?>/<?=$_SESSION['SESS_FIRST_NAME']?>">
			  <?php if(file_exists("products/user_image/$colles_member[Photo]") && $colles_member['Photo']!='') { ?>
              <img src="products/user_image/<?php echo $colles_member['Photo']; ?>" border="0"  />
              <?php } else { ?>
              <img src="images/user_big.png" border="0" />
              <?php } ?>
              </a>
              </div>
              <div class="user-info">
                <ul>
					<?php  
                    if($_REQUEST['profile_id']=='') {
                    $sql_notes_pp = "SELECT sum(a.No_Of_Package) as notesTotalPP FROM package_master a LEFT JOIN package_history_master b ON (a.Package_Id=b.Package_Id)
                    WHERE a.Status='1' AND b.Status='1' AND b.Member_Account_Id='".$_SESSION['SESS_ID']."'";
                    }
                    else
                    {
                    $sql_notes_pp = "SELECT sum(a.No_Of_Package) as notesTotalPP FROM package_master a LEFT JOIN package_history_master b ON (a.Package_Id=b.Package_Id)
                    WHERE a.Status='1' AND b.Status='1' AND b.Member_Account_Id='".$_REQUEST['profile_id']."'";
                    }
                    $result_notes_pp = mysql_query($sql_notes_pp);
                    if(mysql_num_rows($result_notes_pp)>0)
                    {
                    $colles_notes_pp = mysql_fetch_array($result_notes_pp);
                    $NOTES_PP = $colles_notes_pp['notesTotalPP'];
                    if($_REQUEST['profile_id']=='') {
                    $sql_bank_notes_pp = "SELECT sum(Notes_Value) as bankNotesTotalPP FROM my_bank WHERE From_Member_Account_Id='".$_SESSION['SESS_ID']."'";
                    }
                    else
                    {
                    $sql_bank_notes_pp = "SELECT sum(Notes_Value) as bankNotesTotalPP FROM my_bank WHERE From_Member_Account_Id='".$_REQUEST['profile_id']."'";
                    }
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
                    $TOTAL_NOTES_PP = $NOTES_PP-$BANK_NOTES_PP;
                    ?>

                  <li>
                    <span class="head"><strong>Current Credits:</strong> </span>
                    <span class="head-info"><?=$TOTAL_NOTES_PP;?></span>
                  </li>
                  <?php } else { ?>
                  <li>
                    <span class="head"><strong>Current Credits:</strong> </span>
                    <span class="head-info">0</span>
                  </li>
                  <?php } ?>
                  
                  
                  <?php
					if($_REQUEST['profile_id']=='') {
					$sql_my_bank = "SELECT sum(Artist_Amount) as myTotalEarning FROM royality WHERE Artist_Id ='".$_SESSION['SESS_ID']."' ";	
					}
					else
					{
					$sql_my_bank = "SELECT sum(Artist_Amount) as myTotalEarning FROM royality WHERE Artist_Id ='".$_REQUEST['profile_id']."' ";	
					}
					
					$result_my_bank = mysql_query($sql_my_bank);
					if(mysql_num_rows($result_my_bank)>0)
					{
					$colles_my_bank = mysql_fetch_array($result_my_bank);
					?>
                  <li>
                    <span class="head"><strong>Royalties:</strong> </span>
                    <span class="head-info">$<? printf('%1.2f',$colles_my_bank['myTotalEarning']);?></span>
                  </li>
                  <?php } else { ?>
                  <li>
                    <span class="head"><strong>Royalties:</strong> </span>
                    <span class="head-info">$0.00</span>
                  </li>
                  
                  <?php } ?>
                  
                  
                  
                  <li>
                    <?php if($TOTAL_NOTES_PP>=0) { ?>
                    <div class="blue-btn-3"><a id="variousInviteFriends" href="#inviteFriends">Invite Friends</a>
                    <div style="display: none;">
                            <div id="inviteFriends" style="width:600px;height:440px;">
                                <div style="padding: 5px 0 0 100px;">
                                <form id="frmInviteFriend" name="frmInviteFriend" method="post" action="">
                                <ul>
                                
                                
                                <li>
                                        <ul class="login">
                                            <li><h1>Invite Your Friends</h1></li>
                                            <li></li>
                                        </ul>
                                    </li>
                                    
                                    <li  id="invite_friend_id" style="padding: 5px 0 5px 0;"></li>
                                    
                                    <li>
                                        <ul class="login">
                                            <li>Friend Name </li>
                                            <li><input type="text" name="Name" size="30" class="input-text" onkeypress="if(event.keyCode==13) {return InviteFriendRequest();}" /></li>
                                        </ul>
                                    </li>
                                    
                                    <li>
                                        <ul class="login">
                                            <li>Friend Email ID </li>
                                            <li><input type="text" name="Email" size="30" class="input-text" onkeypress="if(event.keyCode==13) {return InviteFriendRequest();}" /></li>
                                        </ul>
                                    </li>
                                    
                                    <li>
                                        <ul class="login">
                                            <li>Email Message</span></li>
                                            <li><textarea name="Message" cols="57" rows="6" onkeypress="if(event.keyCode==13) {return InviteFriendRequest();}"></textarea></li>
                                        </ul>
                                    </li>
                                    
                                    
                                    
                                    <li>
                                        <ul class="login">
                                            <li>Type the code shown</li>
                                            <li><input type="text" name="security_code" class="input-text" id="security_code" size="30" onkeypress="if(event.keyCode==13) {return InviteFriendRequest();}"></li>
                                        </ul>
                                    </li>
                                    <li>
                                        <ul class="login">
                                            <li>&nbsp;</li>
                                            <li><img src="php_captcha.php?hash=<?php echo $hash; ?>&width=130&height=37&characters=8" alt="captcha" name="captchaImage" /></li>
                                        </ul>
                                    </li>
                                    <li>
                                        <ul class="login">
                                            <li>&nbsp;</li>
                                            <li><input class="button" name="buttonSubmit" type="button" value="Submit" onclick="return InviteFriendRequest();" onkeypress="if(event.keyCode==13) {return InviteFriendRequest();}"></li>
                                        </ul>
                                    </li>
                                </ul>
                            </form>
                                </div>
                            </div>
                       </div>
                    </div>
                    <?php } else { ?>
                    <!-- <div class="blue-btn-3"><a href="javascript:void(0);" onmouseover="Tip('Atleast You have 25 notes for invite friend(s).')" onmouseout="UnTip()" >Invite Friends</a></div>-->
                    <?php } ?>
                  </li>
                  
                  <li>
                  <!--<div class="blue-btn-3"><a id="variousActiveLogs" href="#activeLogs">Active Log</a>
                  <div style="display: none;">
                            <div id="activeLogs" style="width:600px;height:410px;">
                                <div style="padding: 5px 0 0 10px;">
                                
                                <table cellpadding="1" cellspacing="1" border="0" width="580">
                                
                                <tr bgcolor="#151515" height="26">
                                    <td width="50" style="color:#ffffff;" align="center">SL. No.</td>
                                    <td width="50" style="color:#ffffff;" align="center">Photo</td>
                                	<td width="200" style="color:#ffffff;" align="center">Friend Name</td>
                                    <td width="200" style="color:#ffffff;" align="center">Date</td>
                                    <td width="80" style="color:#ffffff;" align="center">Status</td>
                                </tr>
                                <?php
								$cn=1;
								$sql_active_log = "SELECT * FROM invite_feiends_log WHERE Member_Account_Id='".$_SESSION['SESS_ID']."'";
								$result_active_log = mysql_query($sql_active_log); 
								while($colles_active_log = mysql_fetch_array($result_active_log))
								{
								$ImageName = Get_Single_Field("member_account_master","Photo","Member_Account_Id","$colles_active_log[Collaborate_Id]");
								?>
                                <tr height="26" bgcolor="eeeeee">
                                    <td width="50" align="center" ><?=$cn?></td>
                                    <td width="50" align="center" >
                                    <a href="<?=SITE_WS_PATH?>/<?=trim($colles_active_log['Collaborate_Id'])?>/<?=ucfirst(stripslashes(Get_Single_Field("member_account_master","First_Name","Member_Account_Id","$colles_active_log[Collaborate_Id]")))?>" >
                                         <?php if(file_exists("products/user_image/$ImageName") && $ImageName!='') { ?>
                                        <img src="products/user_image/<?php echo $ImageName; ?>" border="0" width="60" height="60"  />
                                        <?php } else { ?>
                                        <img src="images/user_big.png" border="0" width="60" height="60" />
                                        <?php } ?>
                                        </a>
                                    </td>
                                	<td width="200" align="center"><?=stripslashes(Get_Single_Field("member_account_master","First_Name","Member_Account_Id","$colles_active_log[Collaborate_Id]").' '.Get_Single_Field("member_account_master","Last_Name","Member_Account_Id","$colles_active_log[Collaborate_Id]"))?></td>
                                    <td width="200" align="center"><?=$colles_active_log['Invitation_Date'];?></td>
                                    <td width="80" align="center"><?=$colles_active_log['Action']?></td>
                                </tr>
                                <?php
								$cn++;
								}
								?>
                                </table>
                            
                                </div>
                            </div>
                       </div>
                  </div>-->
                  </li>
                  
                </ul>
              </div>
              <div class="cl"></div>
            </div>
            
            <div class="notes_howto">
            <h4>Need credits to enter a session</h4>
            <!--<img src="images/note_holder.png" />-->
             <!-- EMBED CODE -->
		<script type="text/javascript" src="Videopt/js/swfobject.js"></script>
		<script type="text/javascript">
			var flashvars = {};
			var params = {};
			var attributes = {};			
			attributes.id = "oxylusflash";
			
			// allow _self target for links
			params.allowScriptAccess = "always";
			
			// allow fullscreen
			params.allowFullScreen = "true";
			
			// stop movie
			params.play = "false";
			
			// scale an align
			params.scale = "noscale";
			params.salign = "tl";
			
			// optionally set xml file here (only if available)
			//flashvars.xmlFile = "data.xml";			
			
			// flash object HTML background color
			params.bgColor = "#000000";
			
			// set here below the path to resolve all the relative paths in the player if you want to store it in a different folder
			params.base = "Videopt";
			
			// change here below the width and height
			var embedWidth = "420";
			var embedHeight = "300";
			
			// swf name here
			var swfName = "Videopt/main.swf";
			
			swfobject.embedSWF(swfName, "flashAlternativeContent", embedWidth, embedHeight, "9.0.0", "js/expressInstall.swf", flashvars, params, attributes);
		</script>
        <!-- end of EMBED CODE -->
        
	</head>

    
    	<!-- Here is the flash container -->
		<div id="flashAlternativeContent">
			<a href="http://www.adobe.com/go/getflashplayer">
				<img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" />
			</a>
		</div>
        <!-- End of the flash container -->
            </div>
            
            
            <!--<div class="blue-block-wrap-2">
              <h5><span>Low on notes?</span> Search collabration to request notes.</h5>
              <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen </p>
            </div>-->
            <!--<div class="blue-block-wrap-3">
              <div class="top">
                <form name="frmSearch" method="get" action="">
                <div class="bottom">
                  <div class="search-box">
                    <div class="search-box_wrap1">
                      <div class="fl"><input name="q" type="text" value="<?=$_GET['q']?>" /></div>
                      <div class="search-btn2 fr"><input name="search" type="submit" value="Search" /></div>
                      <div class="cl"></div>
                    </div>
                  </div>
                  <ul class="frnd-list">
                    <?php
					if($_REQUEST['q']!='')
					{
					$sql_search = "SELECT * FROM member_account_master WHERE Status=1 AND Collaborate_Id='".$_SESSION['SESS_ID']."' AND (First_Name LIKE '%".$_REQUEST['q']."%' || Last_Name LIKE '%".$_REQUEST['q']."%' || Email LIKE '%".$_REQUEST['q']."%')";
					$result_search = mysql_query($sql_search);
					if(mysql_num_rows($result_search)>0)
					{
					while($colles_search=mysql_fetch_array($result_search))
					{
					?>
                    
                    <li>
                     <?php if($_SESSION['sess_msg']!='') { ?>
                    <div style="padding: 2px 0 5px 70px; color:#FF0000;"><?=$_SESSION['sess_msg']?> <?php $_SESSION['sess_msg']=''; ?></div>
                    <?php } ?>
                    
                      <div class="frnd-img fl">
                      <a href="<?=SITE_WS_PATH?>/<?=trim($colles_search['Member_Account_Id'])?>/<?=ucfirst(stripslashes($colles_search['First_Name']))?>" >
					  <?php if(file_exists("products/user_image/$colles_search[Photo]") && $colles_search['Photo']!='') { ?>
                    <img src="products/user_image/<?php echo $colles_search['Photo']; ?>" border="0" width="60" height="60"  />
                    <?php } else { ?>
                    <img src="images/user_big.png" border="0" width="60" height="60" />
                    <?php } ?>
                    </a>
                    </div>
                    
					                    
                      <div class="frnd-row fl">
                        
                        <h3><?=$colles_search['First_Name'].' '.$colles_search['Last_Name']?> </h3>
                        <div class="info-1 fl"> Ask for <input name="action" type="radio" value="Ask For" /></div>
                        <div class="info-2 fl"> Give back <input name="action" type="radio" value="Give Back" />
                        <select name="Reason" id="Reason<?=$colles_search['Member_Account_Id']?>">
                        <option value="">Reason</option>
                        <?php 
						$sql_reason = "SELECT * FROM reason_master WHERE status='1' ORDER BY Reason_Name";
						$result_reason = mysql_query($sql_reason);
						while($colles_reason = mysql_fetch_array($result_reason)) 
						{ 
						?>
                        <option value="<?=$colles_reason['Reason_Id']?>"><?=stripslashes($colles_reason['Reason_Name'])?></option>
                        <?php } ?>
                        </select>
                        </div>
                        <div class="info-3 fl"><a href="javascript:void(0);" onclick="searchRequest('<?=$colles_search['Member_Account_Id']?>');">Request</a></div>
                        <div class="cl"></div>
                      </div>
                      <div class="cl"></div>
                    </li>
                    <?php
					}
					}
					else
					{
					echo '<li><div style="padding: 8px 0 8px 150px; color:#000000;">No Result(s)</div></li>';
					}
					}
					?>
                    
                  </ul>
                </div>
                </form>
                
              </div>
            </div>-->
            <div class="cor_4set-2"></div>
          </div>
          <?php } ?>
          <div class="cl"></div>
        </div>
      </div>
      <div class="cor_1set-3"></div>
      <div class="cor_1set-4"></div>
    </div>
    </div>
  <?php if($_SESSION['SESS_ID']!='') { ?>
<?php include"footer-div.inc.php"; ?>
<?php } ?>
  </div>
</div>
<!-- FOOTER -->
<?php include "footer.inc.php"; ?>
<!-- //FOOTER -->
</body>
</html>
