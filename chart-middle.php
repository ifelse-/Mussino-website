<?php
$date = date('Y-m-d');
$current_year = date('Y');
$collGetId = $_REQUEST['user'];
if(trim($_SESSION['SESS_ID'])==trim($collGetId))
{
$profile_id = '';
}
else
{
$profile_id = $collGetId;
}

if($profile_id!='')
{
	$sqlCheckCollabroate = "SELECT Collaborate_Id FROM member_account_master WHERE Member_Account_Id = '".$profile_id."'";
	$resultCheckCollabroate = mysql_query($sqlCheckCollabroate);
	$collesCheckCollabroate = mysql_fetch_array($resultCheckCollabroate);
	if($collesCheckCollabroate['Collaborate_Id']!='')
	{
	$ACFID = explode(',',$collesCheckCollabroate['Collaborate_Id']);
	}
}




$sql_notes = "SELECT sum(a.No_Of_Package) as notesTotal FROM package_master a LEFT JOIN package_history_master b ON (a.Package_Id=b.Package_Id)
              WHERE a.Status='1' AND b.Status='1' AND b.Member_Account_Id='".$_SESSION['SESS_ID']."'";
$result_notes = mysql_query($sql_notes);
if(mysql_num_rows($result_notes)>0)
{
    $colles_notes = mysql_fetch_array($result_notes);
	$NOTES = $colles_notes['notesTotal'];
	$sql_bank_notes = "SELECT sum(Notes_Value) as bankNotesTotal FROM my_bank WHERE From_Member_Account_Id='".$_SESSION['SESS_ID']."'";
	$result_bank_notes = mysql_query($sql_bank_notes);
	$colles_bank_notes = mysql_fetch_array($result_bank_notes);
	if(mysql_num_rows($result_bank_notes)>0)
	{
	$BANK_NOTES = $colles_bank_notes['bankNotesTotal'];
	}
	else
	{
	$BANK_NOTES = 0;
	}
	$TOTAL_NOTES = $NOTES-$BANK_NOTES;
}
else
{
   $TOTAL_NOTES = 0;
}

$sql = "SELECT * FROM member_account_master WHERE Member_Account_Id='".$_SESSION['SESS_ID']."'";
$result = mysql_query($sql);
$colles = mysql_fetch_array($result);

if($_SESSION['SESS_ACCOUNT_TYPE']=='Musician') 
{ 
$sqlCount = "SELECT count(*) as total FROM product_master WHERE Member_Account_Id='".$_SESSION['SESS_ID']."'";
$resultCount = mysql_query($sqlCount);
$collesCount = mysql_fetch_array($resultCount);
$totalPosts = $collesCount['total'];
}
elseif($_SESSION['SESS_ACCOUNT_TYPE']=='Artist') 
{
$sqlAudioCount = "SELECT COUNT(*) AS CtotalAudio FROM lyrics_post_audio_master WHERE Member_Account_Id='".$_SESSION['SESS_ID']."' AND Lyrics_Audio_Type='AUDIO' AND Status=1";
$resAudioCount = mysql_query($sqlAudioCount);
$collesAudioCount = mysql_fetch_array($resAudioCount);
$sqlVideoCount = "SELECT COUNT(*) AS CtotalVideo FROM lyrics_post_audio_master WHERE Member_Account_Id='".$_SESSION['SESS_ID']."' AND Lyrics_Audio_Type='VIDEO' AND Status=1";
$resVideoCount = mysql_query($sqlVideoCount);
$collesVideoCount = mysql_fetch_array($resVideoCount);
$sqlTextCount = "SELECT COUNT(*) AS CtotalText FROM lyrics_post_master WHERE Member_Account_Id='".$_SESSION['SESS_ID']."' AND Status=1";
$resTextCount = mysql_query($sqlTextCount);
$collesTextCount = mysql_fetch_array($resTextCount);
$totalPosts = $collesAudioCount['CtotalAudio'] + $collesVideoCount['CtotalVideo'] + $collesTextCount['CtotalText'];
}

$sql_collaboration = "SELECT * FROM member_account_master WHERE Status=1 AND Collaborate_Id  LIKE '%".$_SESSION['SESS_ID']."%' ORDER BY First_Name,Last_Name";
$result_collaboration = mysql_query($sql_collaboration) or die('<br>'.$sql_collaboration.'<br>'.mysql_error());
if($_SESSION['SESS_ACCOUNT_TYPE']=='Artist')
{
$sql_royalties_amount = "SELECT * FROM royality WHERE Artist_Id = '".$_SESSION['SESS_ID']."'";
$result_royalties_amount = mysql_query($sql_royalties_amount);
}
elseif($_SESSION['SESS_ACCOUNT_TYPE']=='Musician')
{
$sql_royalties_amount = "SELECT * FROM royality WHERE Musician_Id = '".$_SESSION['SESS_ID']."'";
$result_royalties_amount = mysql_query($sql_royalties_amount);
}

if($_SESSION['SESS_ACCOUNT_TYPE']=='Artist')
{
$sql_royalties_amount_chart = "SELECT * FROM royality WHERE Artist_Id = '".$_SESSION['SESS_ID']."'";
$result_royalties_amount = mysql_query($sql_royalties_amount);
}
elseif($_SESSION['SESS_ACCOUNT_TYPE']=='Musician')
{
$sql_royalties_amount = "SELECT * FROM royality WHERE Musician_Id = '".$_SESSION['SESS_ID']."'";
$result_royalties_amount = mysql_query($sql_royalties_amount);
}


	$sql_session = "SELECT P.Product_Id, P.Member_Account_Id,	P.Title, P.Product_Notes, P.Sound, P.Type, P.Image_Name, P.Short_FIle_Name, P.Long_FIle_Name, P.Short_Desc, P.Long_Desc, P.Price,	P.Session_Start_Date, P.Session_End_Date, DATE_FORMAT(P.Session_Start_Date,'%m/%d/%Y %h:%i %p') as StartDate, DATE_FORMAT(P.Session_End_Date,'%m/%d/%Y %h:%i %p') as EndDate, P.Product_Date, P.Status, P.Jack_Pot, P.Jack_Pot_Status FROM product_master P WHERE P.Status=1 AND P.Type!=3  ORDER BY StartDate";
	$result_session = mysql_query($sql_session);
	
	
$arrayMonths = array('01','02','03','04','05','06','07','08','09','10','11','12');

if($_SESSION['SESS_ACCOUNT_TYPE']=='Artist')
{
$sql_royalties_amount_chart = "SELECT * FROM royality WHERE Month(Date) = '".$_SESSION['SESS_ID']."'";
$result_royalties_amount = mysql_query($sql_royalties_amount);
}
elseif($_SESSION['SESS_ACCOUNT_TYPE']=='Musician')
{
$sql_royalties_amount = "SELECT * FROM royality WHERE Musician_Id = '".$_SESSION['SESS_ID']."'";
$result_royalties_amount = mysql_query($sql_royalties_amount);
}

include "libchart/classes/libchart.php";

	$chart = new VerticalBarChart(730, 400);

	$dataSet = new XYDataSet();
	
		foreach($arrayMonths as $value)
		{
			if($_SESSION['SESS_ACCOUNT_TYPE']=='Artist')
			{
			$sql_royalties_amount_chart = "SELECT sum(Artist_Amount) As royaltyAmount FROM royality WHERE 1=1 AND Month(Date) = '".$value."' AND YEAR(Date)='".$current_year."' AND  Artist_Id 	='".$_SESSION['SESS_ID']."' GROUP BY Month(Date)";
			$result_royalties_amount_chart = mysql_query($sql_royalties_amount_chart);
			}
			elseif($_SESSION['SESS_ACCOUNT_TYPE']=='Musician')
			{
			$sql_royalties_amount_chart = "SELECT sum(Musician_Amount) As royaltyAmount FROM royality WHERE 1=1 AND Month(Date) = '".$value."' AND YEAR(Date)='".$current_year."' AND Musician_Id='".$_SESSION['SESS_ID']."' GROUP BY Month(Date)";
			$result_royalties_amount_chart = mysql_query($sql_royalties_amount_chart);
			}
			elseif($_SESSION['SESS_ACCOUNT_TYPE']=='Contest Judge')
			{
			$sql_royalties_amount_chart = "SELECT count(*) As royaltyAmount FROM my_bank WHERE 1=1 AND Month(Date) = '".$value."' AND YEAR(Date)='".$current_year."' AND Account_Type ='Contest Judge' AND From_Member_Account_Id='".$_SESSION['SESS_ID']."' GROUP BY Month(Date)";
			$result_royalties_amount_chart = mysql_query($sql_royalties_amount_chart);
			}
			
			while($colles_royalties_amount_chart[] = mysql_fetch_array($result_royalties_amount_chart));
						
		}
			
			   if($_SESSION['SESS_ACCOUNT_TYPE']=='Contest Judge')
			   {
			   $dataSet->addPoint(new Point('Jan', trim($colles_royalties_amount_chart['0']['royaltyAmount'])));
			   $dataSet->addPoint(new Point('Feb', trim($colles_royalties_amount_chart['1']['royaltyAmount'])));
			   $dataSet->addPoint(new Point('Mar', trim($colles_royalties_amount_chart['2']['royaltyAmount'])));
			   $dataSet->addPoint(new Point('Apr', trim($colles_royalties_amount_chart['3']['royaltyAmount'])));
			   $dataSet->addPoint(new Point('May', trim($colles_royalties_amount_chart['4']['royaltyAmount'])));
			   $dataSet->addPoint(new Point('Jun', trim($colles_royalties_amount_chart['5']['royaltyAmount'])));
			   $dataSet->addPoint(new Point('Jul', trim($colles_royalties_amount_chart['6']['royaltyAmount'])));
			   $dataSet->addPoint(new Point('Aug', trim($colles_royalties_amount_chart['7']['royaltyAmount'])));
			   $dataSet->addPoint(new Point('Sep', trim($colles_royalties_amount_chart['8']['royaltyAmount'])));
			   $dataSet->addPoint(new Point('Oct', trim($colles_royalties_amount_chart['9']['royaltyAmount'])));
			   $dataSet->addPoint(new Point('Nov', trim($colles_royalties_amount_chart['10']['royaltyAmount'])));
			   $dataSet->addPoint(new Point('Dec', trim($colles_royalties_amount_chart['11']['royaltyAmount'])));
			   }
			   else
			   {
			   $dataSet->addPoint(new Point('Jan', number_format($colles_royalties_amount_chart['0']['royaltyAmount'], 2, '.', ' ')));
			   $dataSet->addPoint(new Point('Feb', number_format($colles_royalties_amount_chart['1']['royaltyAmount'], 2, '.', ' ')));
			   $dataSet->addPoint(new Point('Mar', number_format($colles_royalties_amount_chart['2']['royaltyAmount'], 2, '.', ' ')));
			   $dataSet->addPoint(new Point('Apr', number_format($colles_royalties_amount_chart['3']['royaltyAmount'], 2, '.', ' ')));
			   $dataSet->addPoint(new Point('May', number_format($colles_royalties_amount_chart['4']['royaltyAmount'], 2, '.', ' ')));
			   $dataSet->addPoint(new Point('Jun', number_format($colles_royalties_amount_chart['5']['royaltyAmount'], 2, '.', ' ')));
			   $dataSet->addPoint(new Point('Jul', number_format($colles_royalties_amount_chart['6']['royaltyAmount'], 2, '.', ' ')));
			   $dataSet->addPoint(new Point('Aug', number_format($colles_royalties_amount_chart['7']['royaltyAmount'], 2, '.', ' ')));
			   $dataSet->addPoint(new Point('Sep', number_format($colles_royalties_amount_chart['8']['royaltyAmount'], 2, '.', ' ')));
			   $dataSet->addPoint(new Point('Oct', number_format($colles_royalties_amount_chart['9']['royaltyAmount'], 2, '.', ' ')));
			   $dataSet->addPoint(new Point('Nov', number_format($colles_royalties_amount_chart['10']['royaltyAmount'], 2, '.', ' ')));
			   $dataSet->addPoint(new Point('Dec', number_format($colles_royalties_amount_chart['11']['royaltyAmount'], 2, '.', ' ')));
			   
			   }
		
	
	$chart->setDataSet($dataSet);
	if($_SESSION['SESS_ACCOUNT_TYPE']=='Contest Judge')
	{
	$chart->setTitle("Year ".$current_year." Points");
	}
	else
	{
	$chart->setTitle("Year ".$current_year." Royalties");
	}
	$chart->render("generated/demo1.png");
?>

<div id="page-wrapper">
  <div class="layoutArea">
    <div class="contentArea">
      <div class="content-box-2">
        <div class="cor_1set-5"></div>
        <div class="cor_1set-6"></div>
        <div class="lftPannel2 fl">
          <h2>
            <?=$colles['First_Name']?>
          </h2>
          <div class="user-img">
            <?php if(file_exists("products/user_image/$colles[Photo]") && $colles['Photo']!='') { ?>
            <img src="<?=SITE_WS_PATH?>/products/user_image/<?php echo $colles['Photo']; ?>" border="0" width="181" height="171" />
            <?php } else { ?>
            <img src="<?=SITE_WS_PATH?>/images/user_big.png" border="0" width="181" height="171" />
            <?php } ?>
          </div>
          <div class="user-act">
             <h3>
             <img src="<?=SITE_WS_PATH?>/images/userprofile.png" border="0" align="absbottom"/> <?php if($colles['Account_Type'] == 'Contest Judge'){echo'Judge';} elseif($colles['Account_Type'] == 'Artist'){echo'Songwriter';} else {echo $colles['Account_Type'];} ?>
            </h3>
            <ul>
              <?php
				if($profile_id=='') 
				{
					 if($_SESSION['SESS_ACCOUNT_TYPE']=='Contest Judge') 
					 {
					 $sql_my_bank = "SELECT count(*) as myTotalEarning FROM my_bank WHERE From_Member_Account_Id='".$_SESSION['SESS_ID']."' ";
					 }
					 elseif($_SESSION['SESS_ACCOUNT_TYPE']=='Artist')
					 {
			         $sql_my_bank = "SELECT sum(Artist_Amount) as myTotalEarning FROM royality WHERE Artist_Id ='".$_SESSION['SESS_ID']."' ";		
					 }
					 elseif($_SESSION['SESS_ACCOUNT_TYPE']=='Musician')
					 {
			         $sql_my_bank = "SELECT sum(Musician_Amount) as myTotalEarning FROM royality WHERE 	Musician_Id ='".$_SESSION['SESS_ID']."' ";		
					 }
				}
				else
				{
				$sql_my_bank = "SELECT sum(Musician_Amount) as myTotalEarning FROM royality WHERE Musician_Id='".$profile_id."' ";
				}
				
				        $result_my_bank = mysql_query($sql_my_bank);
						if(mysql_num_rows($result_my_bank)>0)
						{
						$colles_my_bank = mysql_fetch_array($result_my_bank);
						?>
						<?php if($_SESSION['SESS_ACCOUNT_TYPE']!='Contest Judge') { ?>
						<li><span>$<? printf('%1.2f',$colles_my_bank['myTotalEarning']);?></span> <p>Royalties</p></li>
						<?php } else { ?>
						<li><span><? printf('%1.0f',$colles_my_bank['myTotalEarning']);?></span> <p>My Points</p></li>
						<?php } ?>
						<?php
						}
						else
						{
						?>
						<?php if($_SESSION['SESS_ACCOUNT_TYPE']!='Contest Judge') { ?><li><span>$0.00</span> <p>Royalties</p></li><?php } else { ?><li>My Points: <span>0</span></li><?php } ?>
						<?php } ?>
						<?php if($_SESSION['SESS_ACCOUNT_TYPE']!='Contest Judge') { ?><li><span><?=$totalPosts?></span> <p>Posts</p></li><?php } ?>
						<?php if($_SESSION['SESS_ACCOUNT_TYPE']=='Artist') { ?>
						<?php  
						if($profile_id=='') {
						$sql_notes_pp = "SELECT sum(a.No_Of_Package) as notesTotalPP FROM package_master a LEFT JOIN package_history_master b ON (a.Package_Id=b.Package_Id)
						WHERE a.Status='1' AND b.Status='1' AND b.Member_Account_Id='".$_SESSION['SESS_ID']."'";
						}
						else
						{
						$sql_notes_pp = "SELECT sum(a.No_Of_Package) as notesTotalPP FROM package_master a LEFT JOIN package_history_master b ON (a.Package_Id=b.Package_Id)
						WHERE a.Status='1' AND b.Status='1' AND b.Member_Account_Id='".$profile_id."'";
						}
						$result_notes_pp = mysql_query($sql_notes_pp);
						if(mysql_num_rows($result_notes_pp)>0)
						{
						$colles_notes_pp = mysql_fetch_array($result_notes_pp);
						$NOTES_PP = $colles_notes_pp['notesTotalPP'];
						if($profile_id=='') 
						{
						$sql_bank_notes_pp = "SELECT sum(Notes_Value) as bankNotesTotalPP FROM my_bank WHERE From_Member_Account_Id='".$_SESSION['SESS_ID']."'";
						}
						else
						{
						$sql_bank_notes_pp = "SELECT sum(Notes_Value) as bankNotesTotalPP FROM my_bank WHERE From_Member_Account_Id='".$profile_id."'";
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
						<li><span>
						<?=$TOTAL_NOTES_PP;?>
						</span> <p>Notes</p></li>
						<?php
						}
						else
                        {
                        ?>
                        <li><span>0</span> <p>Notes</p></li>
                        <?php } } ?>
            </ul>
          </div>
          <?php if($_SESSION['SESS_ACCOUNT_TYPE']!='Contest Judge') { ?>
          <?php if(($_SESSION['SESS_ID']!='' && $profile_id=='') || ($_SESSION['SESS_ID']!='' && $profile_id==$_SESSION['SESS_ID'])) { ?>
          <div class="blue-btn-4" style="display:none;"> <span> <span> <span><a href="collaborate.php">Collaborate</a></span> </span> </span> </div>
          <?php } elseif($profile_id!='' && $profile_id!=$_SESSION['SESS_ID']) { ?>
          <?php  if(count($ACFID)>0) { if(in_array($_SESSION['SESS_ID'],$ACFID)) { ?>
          <div class="blue-btn-4"> <span> <span> <span> <a href="javascript:void(0);" onmouseover="Tip('Already Collaborating')" onmouseout="UnTip()">Collaborate</a> </span> </span> </span> </div>
          <?php } } else { ?>
          <div class="blue-btn-4"> <span> <span> <span> <a id="variousCollaborate" href="#requestCollaborate">Collaborate</a>
            <div style="display: none;">
              <div id="requestCollaborate" style="width:600px;height:200px;">
                <div style="padding: 5px 0 0 100px;">
                  <form id="frmCollaborateFriend" name="frmCollaborateFriend" method="post" action="">
                    <ul>
                      <li>
                        <ul class="login">
                          <li>
                            <h1>Collaborate Friend Request</h1>
                          </li>
                          <li></li>
                        </ul>
                      </li>
                      <li  id="collaborate_friend_id" style="padding: 5px 0 5px 0;"></li>
                      <li>
                        <ul class="login">
                          <li>&nbsp;</li>
                          <li>Are you sure you want to make collaborate friend request ?</li>
                        </ul>
                      </li>
                      <li>
                        <ul class="login">
                          <li>&nbsp;</li>
                          <li>
                            <input class="button" name="buttonSubmit" type="button" value="Submit" onclick="return CollaborateFriendRequest('<?=$profile_id?>');" onkeypress="if(event.keyCode==13) {return CollaborateFriendRequest('<?=$profile_id?>');}">
                          </li>
                        </ul>
                      </li>
                    </ul>
                  </form>
                </div>
              </div>
            </div>
            </span> </span> </span> </div>
          <?php } //} ?>
          <?php } ?>
          <?php } ?>
          <div class="user-list">
            <h3>NAVIGATION</h3>
            <ul>
              <?php if(($_SESSION['SESS_ID']!='' && $profile_id=='') || ($_SESSION['SESS_ID']!='' && $profile_id==$_SESSION['SESS_ID'])) { ?>
              <li><img src="<?=SITE_WS_PATH?>/images/icon/edit_icon.jpg"/>&nbsp;&nbsp;<a href="<?=SITE_WS_PATH?>/edit-profile.php">Profile Edit</a></li>
              <?php } ?>
              <?php if($_SESSION['SESS_ACCOUNT_TYPE']!='Contest Judge') { ?>
              <?php if($_SESSION['SESS_ACCOUNT_TYPE']=='Musician' && $profile_id=='') { ?>
              <li><img src="<?=SITE_WS_PATH?>/images/icon/history_icon.jpg" />&nbsp;&nbsp;<a href="<?=SITE_WS_PATH?>/product-list.php">My Session History</a></li>
              <li><img src="<?=SITE_WS_PATH?>/images/icon/createsession_icon.jpg" />&nbsp;&nbsp;<a href="<?=SITE_WS_PATH?>/product.php">Create New Session </a></li>
              <li><img src="<?=SITE_WS_PATH?>/images/icon/mystore_icon.jpg" />&nbsp;&nbsp;<a href="<?=SITE_WS_PATH?>/music-store-list.php">My Music Store</a></li>
              <li><img src="<?=SITE_WS_PATH?>/images/icon/sellmusic_icon.jpg" />&nbsp;&nbsp;<a href="<?=SITE_WS_PATH?>/music-store.php">Create Music Store </a></li>
              <li><img src="<?=SITE_WS_PATH?>/images/icon/upgrade_icon.jpg" />&nbsp;&nbsp;<a href="<?=SITE_WS_PATH?>/membership-upgrade.php">Membership Upgrade </a></li>
              <li><img src="<?=SITE_WS_PATH?>/images/icon/money_bag.png" width="22" height="22" align="absmiddle" />&nbsp;&nbsp;<a href="<?=SITE_WS_PATH?>/musician-sell-session.php">Sell Session History</a></li>
              <li> </li>
              <?php } ?>
              <?php if($_SESSION['SESS_ACCOUNT_TYPE']=='Artist' && $profile_id=='') { ?>
              <li> <img src="<?=SITE_WS_PATH?>/images/icon/history_icon.jpg" />&nbsp;&nbsp;<a href="<?=SITE_WS_PATH?>/my-history.php">History</a></li>
              <li> <img src="<?=SITE_WS_PATH?>/images/icon/history_icon.jpg" />&nbsp;&nbsp;<a href="<?=SITE_WS_PATH?>/my-archive-history.php">Archive History</a></li>
              <li> <img src="<?=SITE_WS_PATH?>/images/icon/notebook_icon.jpg" />&nbsp;&nbsp;<a id="variousNotebook" href="#requestNotebook">Notebook</a>
                <div style="display: none;">
                  <div id="requestNotebook" style="width:535px;height:460px;">
                    <div class="lightbox-msg"> 
                      <script type="text/javascript">
					function textCounter(field,cntfield,maxlimit) {
					if (field.value.length > maxlimit) // if too long...trim it!
					field.value = field.value.substring(0, maxlimit);
					else
					cntfield.value = maxlimit - field.value.length;
					}
					</script>
                      <form id="frmNotebook" name="frmNotebook" method="post" action="">
                        <ul>
                        <li>
                        <div class="date">
                        <span><strong>Date :</strong> <?=date('m-d-Y')?></span>
                        <span><strong>Time :</strong> <?=date('h:i a')?></span>
                        </div>
                        <div class="char">Character limit:<input readonly type="text" name="remLen1" size="3" maxlength="3" value="1200"><span>max</span></div>
                        <div class="cl"></div>
                        </li>
                          <li  id="notebook_id" style="padding: 10px 0 0 0; font-size:14px; font-weight:bold;"></li>
                          <li id="notebook_id1" class="notebook">
                            <textarea rows="13" cols="60" name="Lyrics" id="Lyrics" onKeyDown="textCounter(document.frmNotebook.Lyrics,document.frmNotebook.remLen1,1200)"
        onKeyUp="textCounter(document.frmNotebook.Lyrics,document.frmNotebook.remLen1,1200)"></textarea>
                          </li>
                          
                          <li class="alignR paddingTop" id="notebook_id2">
                            <input class="button" name="buttonSubmit" type="button" value="Submit" onclick="return NotebookRequest();" onkeypress="if(event.keyCode==13) {return NotebookRequest();}">
                          </li>
                        </ul>
                      </form>
                    </div>
                  </div>
                </div>
              </li>
              <li><img src="<?=SITE_WS_PATH?>/images/icon/upgrade_icon.jpg" />&nbsp;&nbsp;<a href="<?=SITE_WS_PATH?>/artist-membership-upgrade.php">Membership Upgrade </a></li>
              <?php } ?>
              <?php if(($_SESSION['SESS_ID']!='' && $profile_id=='') || ($_SESSION['SESS_ID']!='' && $profile_id==$_SESSION['SESS_ID'])) { ?>
              <li><img src="<?=SITE_WS_PATH?>/images/icon/zip.png" width="22" height="22" />&nbsp;&nbsp;<a href="<?=SITE_WS_PATH?>/download.php">Music Download </a></li>
              <?php } ?>
              <?php } ?>
              
              <?php if(($_SESSION['SESS_ID']!='' && $profile_id=='') || ($_SESSION['SESS_ID']!='' && $profile_id==$_SESSION['SESS_ID'])) { ?>
              <li><img src="<?=SITE_WS_PATH?>/images/icon/viewChart_icon.jpg" />&nbsp;&nbsp;<a href="<?=SITE_WS_PATH?>/chart.php">View Chart</a></li>
              
              <?php } ?>
              <!-- <li><a href="profile-action.php?st=<?=$colles['Show_Profile']?>"><?=ucfirst($colles['Show_Profile'])?> Profile</a></li>-->
              
            </ul>
          </div>
          <?php if($_SESSION['SESS_ACCOUNT_TYPE']!='Contest Judge') { ?>
          <div class="user-list2">
            <h3>Collaboration</h3>
            <?php 
			if(mysql_num_rows($result_collaboration)>0)
			{
			while($collesCollaboration = mysql_fetch_array($result_collaboration))
			{
			?>
            <div class="user-img2"> <a href="<?=SITE_WS_PATH?>/<?=trim($collesCollaboration['Member_Account_Id'])?>/<?=ucfirst(stripslashes($collesCollaboration['First_Name']))?>" >
              <?php if(file_exists("products/user_image/$collesCollaboration[Photo]") && $collesCollaboration['Photo']!='') { ?>
              <img src="<?=SITE_WS_PATH?>/products/user_image/<?php echo $collesCollaboration['Photo']; ?>" border="0" width="60" height="60"  />
              <?php } else { ?>
              <img src="<?=SITE_WS_PATH?>/images/user_big.png" border="0" width="60" height="60" />
              <?php } ?>
              </a> </div>
            <?php } } else { echo '<div style="padding: 2px 0 2px 2px;">No Network</div>'; } ?>

            <div class="cl"></div>
          </div>
          <?php } ?>
          <?php if(($_SESSION['SESS_ID']!='' && $profile_id=='') || ($_SESSION['SESS_ID']!='' && $profile_id==$_SESSION['SESS_ID'])) { ?>
          <?php if($collesMemberShip['Membership_Upgrade_Id']==1) { ?>
          <div style="padding-top:10px;"><img src="<?=SITE_WS_PATH?>/images/business_account_badge.jpg" width="177" height="141" /></div>
          <?php } elseif($collesMemberShip['Membership_Upgrade_Id']==2) { ?>
          <div style="padding-top:10px;"><img src="<?=SITE_WS_PATH?>/images/silver-img.jpg" width="177" height="141" /></div>
          <?php } elseif($collesMemberShip['Membership_Upgrade_Id']==3) { ?>
          <div style="padding-top:10px;"><img src="<?=SITE_WS_PATH?>/images/gold-img.jpg" width="177" height="141" /></div>
          <?php } elseif($collesMemberShip['Membership_Upgrade_Id']==4) { ?>
          <div style="padding-top:10px;"><img src="<?=SITE_WS_PATH?>/images/platinum-img.jpg" width="177" height="141" /></div>
          <?php } ?>
          <?php } elseif($profile_id!='' && $profile_id!=$_SESSION['SESS_ID']) { ?>
          <?php if($collesMemberShip['Membership_Upgrade_Id']==1) { ?>
          <div style="padding-top:10px;"><img src="<?=SITE_WS_PATH?>/images/business_account_badge.jpg" width="177" height="141" /></div>
          <?php } elseif($collesMemberShip['Membership_Upgrade_Id']==2) { ?>
          <div style="padding-top:10px;"><img src="<?=SITE_WS_PATH?>/images/silver-img.jpg" width="177" height="141" /></div>
          <?php } elseif($collesMemberShip['Membership_Upgrade_Id']==3) { ?>
          <div style="padding-top:10px;"><img src="<?=SITE_WS_PATH?>/images/gold-img.jpg" width="177" height="141" /></div>
          <?php } elseif($collesMemberShip['Membership_Upgrade_Id']==4) { ?>
          <div style="padding-top:10px;"><img src="<?=SITE_WS_PATH?>/images/platinum-img.jpg" width="177" height="141" /></div>
          <?php } }?>
          
          
          <?php if($_SESSION['SESS_ID']!='') { ?>
          <?php if($collesMemberShipArtist['Membership_Upgrade_Id']==1) { ?>
          <div style="padding-top:10px;"></div>
          <?php } elseif($collesMemberShipArtist['Membership_Upgrade_Id']==2) { ?>
          <div style="padding-top:10px;"><img src="<?=SITE_WS_PATH?>/images/silver-img.jpg" width="177" height="141" /></div>
          <?php } elseif($collesMemberShipArtist['Membership_Upgrade_Id']==3) { ?>
          <div style="padding-top:10px;"><img src="<?=SITE_WS_PATH?>/images/gold-img.jpg" width="177" height="141" /></div>
          <?php } elseif($collesMemberShipArtist['Membership_Upgrade_Id']==4) { ?>
          <div style="padding-top:10px;"><img src="<?=SITE_WS_PATH?>/images/platinum-img.jpg" width="177" height="141" /></div>
          <?php } ?>
          <?php } ?>
        </div>
        
       <?php //if($_SESSION['SESS_ACCOUNT_TYPE']!='Contest Judge') { ?>
        <div class="rgtPannel2 fr">
          <div class="rgtPannel-col first">
            <h3>Chart Status </h3>
            <div><img alt="Vertical bars chart" src="<?=SITE_WS_PATH?>/generated/demo1.png" style="border: 1px solid gray;"/></div>
          </div>
          <?php if($_SESSION['SESS_ACCOUNT_TYPE']!='Contest Judge') { ?>
          <div class="rgtPannel-col second">
            <h3> Royalties Status session <span>My royalties amount show website overall status. </span> </h3>
            <div>
            <table width="100%" border="0">
              <tr bgcolor="#eeeeee" height="30">
                <td width="25%" align="center"><span style="color:#0099FF; font-weight:bold;">Session Title</span></td>
                <td width="25%" align="center"><span style="color:#0099FF; font-weight:bold;">Session Started</span></td>
                <td width="25%" align="center"><span style="color:#0099FF; font-weight:bold;">Session End Date</span></td>
                <td width="25%" align="center"><span style="color:#0099FF; font-weight:bold;">Royalties Amount</span></td>
              </tr>
              <?php
			  $ct=0;
			  if(mysql_num_rows($result_royalties_amount)>0)
			  {
			  while($colles_royalties_amount = mysql_fetch_array($result_royalties_amount))
			  {
			  $bgcolor = ($ct%2==0? '#E8F3FE': '#eeeeee');
			  ?>
              <tr bgcolor="<?=$bgcolor?>" height="30">
                <td width="25%" align="center"><?=stripslashes(Get_Single_Field("product_master","Title","Product_Id","$colles_royalties_amount[Product_Id]"))?></td>
                <td width="25%" align="center"><?=get_date_format(Get_Single_Field("product_master","Session_Start_Date","Product_Id","$colles_royalties_amount[Product_Id]"));?></td>
                <td width="25%" align="center"><?=get_date_format(Get_Single_Field("product_master","Session_End_Date","Product_Id","$colles_royalties_amount[Product_Id]"));?></td>
                <td width="25%" align="center">$ <?=number_format($colles_royalties_amount['Artist_Amount'], 2, '.', ' ')?></td>
              </tr>
              <?php
			  $ct++;
			  }
			  }
			  else
			  {
			  echo"<tr><td colspan='4' align='center' height='40'><strong>No Royalties</strong></td></tr>";
			  }
			  ?>
            </table>

            </div>
          </div>
          <?php } ?>
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
