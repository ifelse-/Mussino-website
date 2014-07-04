<?php
$date = date('Y-m-d');
$collGetId = $_REQUEST['user'];
if(trim($_SESSION['SESS_ID'])==trim($collGetId)){ $profile_id = ''; } else { $profile_id = $collGetId; }

if($profile_id=='')
{
					#####################################################
					$sqlMusicianCount = "SELECT COUNT(*) AS CMusicianTotal FROM product_master WHERE Member_Account_Id='".$_SESSION['SESS_ID']."' ";
					$resMusicianCount = mysql_query($sqlMusicianCount);
					$collesMusicianCount = mysql_fetch_array($resMusicianCount);
					
					if($_SESSION['SESS_ACCOUNT_TYPE']=='Musician') {
					$sql_membership_check = "SELECT * FROM membership_upgrade_history_master WHERE Member_Account_Id='".$_SESSION['SESS_ID']."' AND Status=1";
					$result_membership_check = mysql_query($sql_membership_check);
					
					$sql_membership_check1 = "SELECT * FROM membership_upgrade_history_master WHERE Member_Account_Id='".$_SESSION['SESS_ID']."' AND Status=0";
					$result_membership_check1 = mysql_query($sql_membership_check1);
					
					if(mysql_num_rows($result_membership_check)>0)
					{
					
							$sql_credits = "SELECT sum(b.Membership_No+5) as notesTotal FROM membership_upgrade_master a JOIN membership_upgrade_history_master b ON (a.Membership_Upgrade_Id=b.Membership_Upgrade_Id) WHERE a.Status='1' AND b.Status='1' AND b.Member_Account_Id='".$_SESSION['SESS_ID']."'";
							$result_credits = mysql_query($sql_credits);
							$colles_credits = mysql_fetch_array($result_credits);
							$CREDITS_NOTES = $colles_credits['notesTotal'];
							if($CREDITS_NOTES=='')
							{
							$TOTAL_CREDITS_NOTES = 0;
							}
							else
							{
							$collesMusicianCount['CMusicianTotal'];
							$TOTAL_CREDITS_NOTES = $CREDITS_NOTES-$collesMusicianCount['CMusicianTotal'];
							}
					}
					elseif(mysql_num_rows($result_membership_check1)>0)
					{
					
							$sql_credits = "SELECT sum(b.Membership_No+5) as notesTotal FROM membership_upgrade_master a JOIN membership_upgrade_history_master b ON (a.Membership_Upgrade_Id=b.Membership_Upgrade_Id) WHERE a.Status='1' AND b.Status='1' AND b.Member_Account_Id='".$_SESSION['SESS_ID']."'";
							$result_credits = mysql_query($sql_credits);
							$colles_credits = mysql_fetch_array($result_credits);
							$CREDITS_NOTES = $colles_credits['notesTotal'];
							if($CREDITS_NOTES=='')
							{
							$TOTAL_CREDITS_NOTES = 0;
							}
							else
							{
							$collesMusicianCount['CMusicianTotal'];
							$TOTAL_CREDITS_NOTES = $CREDITS_NOTES-$collesMusicianCount['CMusicianTotal'];
							}
					}
					else
					{
					$TOTAL_CREDITS_NOTES = 5-$collesMusicianCount['CMusicianTotal'];;
					}
					
					
					###############################
					
					
					
					}elseif($_SESSION['SESS_ACCOUNT_TYPE']=='Artist') {
						
					$sql_artist_membership_check = "SELECT * FROM membership_artist_upgrade_history_master WHERE Member_Account_Id='".$_SESSION['SESS_ID']."' AND Status=1";
					$result_artist_membership_check = mysql_query($sql_artist_membership_check);
					
					$sql_artist_membership_check1 = "SELECT * FROM membership_artist_upgrade_history_master WHERE Member_Account_Id='".$_SESSION['SESS_ID']."' AND Status=0";
					$result_artist_membership_check1 = mysql_query($sql_artist_membership_check1);
					
						
					}
					
					###########################################################
}
else
{
					
					
					$sqlCheckCollabroate = "SELECT Collaborate_Id FROM member_account_master WHERE Member_Account_Id = '".$profile_id."'";
					$resultCheckCollabroate = mysql_query($sqlCheckCollabroate);
					$collesCheckCollabroate = mysql_fetch_array($resultCheckCollabroate);
					if($collesCheckCollabroate['Collaborate_Id']!='')
					{
					$ACFID = explode(',',$collesCheckCollabroate['Collaborate_Id']);
					}
					
					#####################################################
					$sqlMusicianCount = "SELECT COUNT(*) AS CMusicianTotal FROM product_master WHERE Member_Account_Id='".$profile_id."' ";
					$resMusicianCount = mysql_query($sqlMusicianCount);
					$collesMusicianCount = mysql_fetch_array($resMusicianCount);
					
					$sql_membership_check = "SELECT * FROM membership_upgrade_history_master WHERE Member_Account_Id='".$profile_id."' AND Status=1";
					$result_membership_check = mysql_query($sql_membership_check);
					
					$sql_membership_check1 = "SELECT * FROM membership_upgrade_history_master WHERE Member_Account_Id='".$profile_id."' AND Status=0";
					$result_membership_check1 = mysql_query($sql_membership_check1);
					
					if(mysql_num_rows($result_membership_check)>0)
					{
					
					$sql_credits = "SELECT sum(a.Membership_No+5) as notesTotal FROM membership_upgrade_master a JOIN membership_upgrade_history_master b ON (a.Membership_Upgrade_Id=b.Membership_Upgrade_Id) WHERE a.Status='1' AND b.Status='1' AND b.Member_Account_Id='".$profile_id."'";
					$result_credits = mysql_query($sql_credits);
					$colles_credits = mysql_fetch_array($result_credits);
					$CREDITS_NOTES = $colles_credits['notesTotal'];
					if($CREDITS_NOTES=='')
					{
					$TOTAL_CREDITS_NOTES = 0;
					}
					else
					{
					$collesMusicianCount['CMusicianTotal'];
					$TOTAL_CREDITS_NOTES = $CREDITS_NOTES-$collesMusicianCount['CMusicianTotal'];
					}
					}
					else
					{
					$TOTAL_CREDITS_NOTES = 5-$collesMusicianCount['CMusicianTotal'];;
					}
					###########################################################
	    
}


if($_SESSION['SESS_ACCOUNT_TYPE']=='Musician') 
{ 
$ACOUNT = 'Active Session'; 
} 
elseif($_SESSION['SESS_ACCOUNT_TYPE']=='Contest Judge') 
{ 
$ACOUNT = 'Judge'; 
}
elseif($_SESSION['SESS_ACCOUNT_TYPE']=='Artist') 
{ 
$ACOUNT = 'Enter Session'; 
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
if($profile_id=='')
{
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

	if($_SESSION['SESS_ACCOUNT_TYPE']=='Musician') {
	$sql_session = "SELECT P.Product_Id, P.Member_Account_Id,P.Royalties, P.Posts,	P.Title, P.Product_Notes, P.Sound, P.Type, P.Image_Name, P.Short_FIle_Name, P.Long_FIle_Name, P.Short_Desc, P.Long_Desc, P.Price,	P.Session_Start_Date, P.Session_End_Date, DATE_FORMAT(P.Session_Start_Date,'%m/%d/%Y %h:%i %p') as StartDate, DATE_FORMAT(P.Session_End_Date,'%m/%d/%Y %h:%i %p') as EndDate, P.Product_Date, P.Status, P.Jack_Pot, P.Jack_Pot_Status FROM product_master P WHERE P.Status=1 AND P.Type!=3  AND now() between P.Session_Start_Date AND P.Session_End_Date AND P.Member_Account_Id ='".$_SESSION['SESS_ID']."'";
	
	$result_session = mysql_query($sql_session);
	
	$sqlMemberShip = "SELECT * FROM membership_upgrade_history_master WHERE Member_Account_Id='".$_SESSION['SESS_ID']."' AND Status=1";
    $resultMemberShip = mysql_query($sqlMemberShip);
    $collesMemberShip = mysql_fetch_array($resultMemberShip);
	
	}
	elseif($_SESSION['SESS_ACCOUNT_TYPE']=='Artist')
	{
	$sql_session = "SELECT P.Product_Id, P.Member_Account_Id,P.Royalties, P.Posts,	P.Title, P.Product_Notes, P.Sound, P.Type, P.Image_Name, P.Short_FIle_Name, P.Long_FIle_Name, P.Short_Desc, P.Long_Desc, P.Price,	P.Session_Start_Date, P.Session_End_Date, DATE_FORMAT(P.Session_Start_Date,'%m/%d/%Y %h:%i %p') as StartDate, DATE_FORMAT(P.Session_End_Date,'%m/%d/%Y %h:%i %p') as EndDate, P.Product_Date, P.Status, P.Jack_Pot, P.Jack_Pot_Status FROM product_master P WHERE P.Status=1 AND P.Type!=3 AND now() between P.Session_Start_Date AND P.Session_End_Date ORDER BY RAND()";
	$result_session = mysql_query($sql_session);
	
	$sqlMemberShipArtist = "SELECT * FROM membership_artist_upgrade_history_master WHERE Member_Account_Id='".$_SESSION['SESS_ID']."' AND Status=1";
    $resultMemberShipArtist = mysql_query($sqlMemberShipArtist);
    $collesMemberShipArtist = mysql_fetch_array($resultMemberShipArtist);
	
	}
	elseif($_SESSION['SESS_ACCOUNT_TYPE']=='Contest Judge')
	{
	$sql_session = "SELECT P.Product_Id, P.Member_Account_Id, P.Royalties, P.Posts,	P.Title, P.Product_Notes, P.Sound, P.Type, P.Image_Name, P.Short_FIle_Name, P.Long_FIle_Name, P.Short_Desc, P.Long_Desc, P.Price,	P.Session_Start_Date, P.Session_End_Date, DATE_FORMAT(P.Session_Start_Date,'%m/%d/%Y %h:%i %p') as StartDate, DATE_FORMAT(P.Session_End_Date,'%m/%d/%Y %h:%i %p') as EndDate, P.Product_Date, P.Status, P.Jack_Pot, P.Jack_Pot_Status FROM product_master P WHERE P.Status=1 AND P.Type!=3 AND now() between P.Session_Start_Date AND P.Session_End_Date ORDER BY RAND()";
	$result_session = mysql_query($sql_session);
	
	$sql_session_close = "SELECT P.Product_Id, P.Member_Account_Id,	P.Title, P.Royalties, P.Posts, P.Product_Notes, P.Sound, P.Type, P.Image_Name, P.Short_FIle_Name, P.Long_FIle_Name, P.Short_Desc, P.Long_Desc, P.Price,	P.Session_Start_Date, P.Session_End_Date, DATE_FORMAT(P.Session_Start_Date,'%m/%d/%Y %h:%i %p') as StartDate, DATE_FORMAT(P.Session_End_Date,'%m/%d/%Y %h:%i %p') as EndDate, P.Product_Date, P.Status, P.Jack_Pot, P.Jack_Pot_Status FROM product_master P WHERE P.Status=1 AND P.Type!=3 AND  now() between P.Session_End_Date AND  DATE_ADD(P.Session_End_Date, INTERVAL +1 DAY) ORDER BY Session_End_Date";
	$result_session_close = mysql_query($sql_session_close);
	}

	if($_SESSION['SESS_ACCOUNT_TYPE']=='Musician') {
	$sql_session1 = "SELECT P.Product_Id, P.Member_Account_Id,	P.Title, P.Royalties, P.Posts, P.Product_Notes, P.Sound, P.Type, P.Image_Name, P.Short_FIle_Name, P.Long_FIle_Name, P.Short_Desc, P.Long_Desc, P.Price,	P.Session_Start_Date, P.Session_End_Date, DATE_FORMAT(P.Session_Start_Date,'%m/%d/%Y %h:%i %p') as StartDate, DATE_FORMAT(P.Session_End_Date,'%m/%d/%Y %h:%i %p') as EndDate, P.Product_Date, P.Status, P.Jack_Pot, P.Jack_Pot_Status FROM product_master P WHERE P.Status=1 AND P.Type=3 AND P.Member_Account_Id ='".$_SESSION['SESS_ID']."'  ORDER BY P.Product_Id";
	$result_session1 = mysql_query($sql_session1);
	
	$sql_session2 = "SELECT P.Product_Id, P.Member_Account_Id,	P.Title, P.Royalties, P.Posts, P.Product_Notes, P.Sound, P.Type, P.Image_Name, P.Short_FIle_Name, P.Long_FIle_Name, P.Short_Desc, P.Long_Desc, P.Price,	P.Session_Start_Date, P.Session_End_Date, DATE_FORMAT(P.Session_Start_Date,'%m/%d/%Y %h:%i %p') as StartDate, DATE_FORMAT(P.Session_End_Date,'%m/%d/%Y %h:%i %p') as EndDate, P.Product_Date, P.Status, P.Jack_Pot, P.Jack_Pot_Status FROM product_master P WHERE P.Status=1 AND P.Type=5  ORDER BY P.Product_Id";
	$result_session2 = mysql_query($sql_session2);
	
	}
	elseif($_SESSION['SESS_ACCOUNT_TYPE']=='Artist')
	{
	$sql_session1 = "SELECT P.Product_Id, P.Member_Account_Id, P.Royalties, P.Posts, P.Title, P.Product_Notes, P.Sound, P.Type, P.Image_Name, P.Short_FIle_Name, P.Long_FIle_Name, P.Short_Desc, P.Long_Desc, P.Price,	P.Session_Start_Date, P.Session_End_Date, DATE_FORMAT(P.Session_Start_Date,'%m/%d/%Y %h:%i %p') as StartDate, DATE_FORMAT(P.Session_End_Date,'%m/%d/%Y %h:%i %p') as EndDate, P.Product_Date, P.Status, P.Jack_Pot, P.Jack_Pot_Status FROM product_master P WHERE P.Status=1 AND P.Type=3  ORDER BY P.Product_Id";
	$result_session1 = mysql_query($sql_session1);
	
	
	$sql_session2 = "SELECT P.Product_Id, P.Member_Account_Id, P.Royalties, P.Posts, P.Title, P.Product_Notes, P.Sound, P.Type, P.Image_Name, P.Short_FIle_Name, P.Long_FIle_Name, P.Short_Desc, P.Long_Desc, P.Price,	P.Session_Start_Date, P.Session_End_Date, DATE_FORMAT(P.Session_Start_Date,'%m/%d/%Y %h:%i %p') as StartDate, DATE_FORMAT(P.Session_End_Date,'%m/%d/%Y %h:%i %p') as EndDate, P.Product_Date, P.Status, P.Jack_Pot, P.Jack_Pot_Status FROM product_master P WHERE P.Status=1 AND P.Type=5 AND P.Member_Account_Id ='".$_SESSION['SESS_ID']."' ORDER BY P.Product_Id";
	$result_session2 = mysql_query($sql_session2);
	
	
	$sql_session6 = "SELECT * FROM sell_session WHERE Status=1 AND Artist_Id ='".$_SESSION['SESS_ID']."' ORDER BY Date";
	$result_session6 = mysql_query($sql_session6);
	
	
	}

}
else
{
$sql = "SELECT * FROM member_account_master WHERE Member_Account_Id='".$profile_id."'";
$result = mysql_query($sql);
$colles = mysql_fetch_array($result);
$sqlCount = "SELECT count(*) as total FROM product_master WHERE Member_Account_Id='".$profile_id."'";
$resultCount = mysql_query($sqlCount);
$collesCount = mysql_fetch_array($resultCount);
$totalPosts = $collesCount['total'];

$sqlMemberShip = "SELECT * FROM membership_upgrade_history_master WHERE Member_Account_Id='".$profile_id."' AND Status=1";
$resultMemberShip = mysql_query($sqlMemberShip);
$collesMemberShip = mysql_fetch_array($resultMemberShip);

			
$sql_collaboration = "SELECT * FROM member_account_master WHERE Status=1 AND Collaborate_Id LIKE '%".$profile_id."%' ORDER BY First_Name,Last_Name";
$result_collaboration = mysql_query($sql_collaboration) or die('<br>'.$sql_collaboration.'<br>'.mysql_error());

$sql_session = "SELECT P.Product_Id, P.Member_Account_Id, P.Royalties, P.Posts,	P.Title, P.Product_Notes, P.Sound, P.Type, P.Image_Name, P.Short_FIle_Name, P.Long_FIle_Name, P.Short_Desc, P.Long_Desc, P.Price,	P.Session_Start_Date, P.Session_End_Date, DATE_FORMAT(P.Session_Start_Date,'%m/%d/%Y %h:%i %p') as StartDate, DATE_FORMAT(P.Session_End_Date,'%m/%d/%Y %h:%i %p') as EndDate, P.Product_Date, P.Status, P.Jack_Pot, P.Jack_Pot_Status FROM product_master P WHERE P.Status=1 AND P.Type!=3 AND P.Member_Account_Id='".$profile_id."' AND now() between P.Session_Start_Date AND P.Session_End_Date ORDER BY P.Title";
$result_session = mysql_query($sql_session);

$sql_session1 = "SELECT P.Product_Id, P.Member_Account_Id,P.Royalties, P.Posts,	P.Title, P.Product_Notes, P.Sound, P.Type, P.Image_Name, P.Short_FIle_Name, P.Long_FIle_Name, P.Short_Desc, P.Long_Desc, P.Price,	P.Session_Start_Date, P.Session_End_Date, DATE_FORMAT(P.Session_Start_Date,'%m/%d/%Y %h:%i %p') as StartDate, DATE_FORMAT(P.Session_End_Date,'%m/%d/%Y %h:%i %p') as EndDate, P.Product_Date, P.Status, P.Jack_Pot, P.Jack_Pot_Status FROM product_master P WHERE P.Status=1 AND P.Type=3 AND P.Member_Account_Id ='".$profile_id."'  ORDER BY P.Title";
$result_session1 = mysql_query($sql_session1);

$sql_session2 = "SELECT P.Product_Id, P.Member_Account_Id,P.Royalties, P.Posts,	P.Title, P.Product_Notes, P.Sound, P.Type, P.Image_Name, P.Short_FIle_Name, P.Long_FIle_Name, P.Short_Desc, P.Long_Desc, P.Price,	P.Session_Start_Date, P.Session_End_Date, DATE_FORMAT(P.Session_Start_Date,'%m/%d/%Y %h:%i %p') as StartDate, DATE_FORMAT(P.Session_End_Date,'%m/%d/%Y %h:%i %p') as EndDate, P.Product_Date, P.Status, P.Jack_Pot, P.Jack_Pot_Status FROM product_master P WHERE P.Status=1 AND P.Type=5 AND P.Member_Account_Id ='".$profile_id."'  ORDER BY P.Title";
$result_session2 = mysql_query($sql_session2);

$sql_session6 = "SELECT * FROM sell_session WHERE Status=1 AND Artist_Id ='".$profile_id."' ORDER BY Date";
$result_session6 = mysql_query($sql_session6);
}

function get_time_difference( $start, $end )
{
    $uts['start']      =    strtotime( $start );
    $uts['end']        =    strtotime( $end );
    if( $uts['start']!==-1 && $uts['end']!==-1 )
    {
        if( $uts['end'] >= $uts['start'] )
        {
            $diff    =    $uts['end'] - $uts['start'];
            if( $days=intval((floor($diff/86400))) )
                $diff = $diff % 86400;
            if( $hours=intval((floor($diff/3600))) )
                $diff = $diff % 3600;
            if( $minutes=intval((floor($diff/60))) )
                $diff = $diff % 60;
            $diff    =    intval( $diff );            
            return( array('days'=>$days, 'hours'=>$hours, 'minutes'=>$minutes, 'seconds'=>$diff) );
        }
        else
        {
            @trigger_error( "Ending date/time is earlier than the start date/time", E_USER_WARNING );
        }
    }
    else
    {
        @trigger_error( "Invalid date/time data detected", E_USER_WARNING );
    }
    return( false );
}
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
              <?=$colles['Account_Type']?>
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
						<li>Royalties: <span>$<? printf('%1.2f',$colles_my_bank['myTotalEarning']);?></span></li>
						<?php } else { ?>
						<li>My Points: <span><? printf('%1.0f',$colles_my_bank['myTotalEarning']);?></span></li>
						<?php } ?>
						<?php
						}
						else
						{
						?>
						<?php if($_SESSION['SESS_ACCOUNT_TYPE']!='Contest Judge') { ?><li>Royalties: <span>$0.00</span></li><?php } else { ?><li>My Points: <span>0</span></li><?php } ?>
						<?php } ?>
						<?php if($_SESSION['SESS_ACCOUNT_TYPE']!='Contest Judge') { ?><li>Posts: <span><?=$totalPosts?></span></li><?php } ?>
						<?php if($_SESSION['SESS_ACCOUNT_TYPE']=='Artist') { ?>
						<?php $profile_Member_Type = Get_Single_Field("member_account_master","Account_Type","Member_Account_Id","$profile_id");
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
							
							<?php if($profile_id!='' && $profile_Member_Type=='Artist') {?>
                            <li>Notes: <span><?=$TOTAL_NOTES_PP;?></span></li>
							<?php } elseif($profile_id=='') { ?>
							<li>Notes: <span><?=$TOTAL_NOTES_PP;?></span></li>
                            <?php } ?>
							
							<?php
                            }
                            else
                            {
                            ?>
                            <li>Notes: <span>0</span></li>
                            <?php 
							} 
							} 
							?>
                        <?php if($_SESSION['SESS_ACCOUNT_TYPE']=='Musician' || $profile_id!='') { ?>
                        <li>Credits: <span><?=$TOTAL_CREDITS_NOTES?></span></li>
                        <?php } ?>
                        
                        
                        <?php if($_SESSION['SESS_ACCOUNT_TYPE']!='Contest Judge') { ?>
						  <?php if($_SESSION['SESS_ID']!='') { ?>
                          <?php if(mysql_num_rows($result_membership_date)>0) { ?>
                          <li><div style="padding:3px 0 3px 0; font-weight:bold; font-size:9px;">Member Since <?=$cOL_mEM_dATE['sTpAYdATE'];?></div></li>
                          <li><div style="padding:0 0 3px 0; font-weight:bold; font-size:9px;">Next Renewal Date <?=$cOL_mEM_dATE['nEXTpAYrECdATE'];?> </div></li>
                          <?php } } }?>
                        
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
              <li><img src="../images/icon/edit_icon.jpg"/>&nbsp;&nbsp;<a href="<?=SITE_WS_PATH?>/edit-profile.php">Profile Edit</a></li>
              <?php } ?>
              <?php if($_SESSION['SESS_ACCOUNT_TYPE']!='Contest Judge') { ?>
              <?php if($_SESSION['SESS_ACCOUNT_TYPE']=='Musician' && $profile_id=='') { ?>
              <li><img src="../images/icon/history_icon.jpg" />&nbsp;&nbsp;<a href="<?=SITE_WS_PATH?>/product-list.php">My Session History</a></li>
              <li><img src="../images/icon/createsession_icon.jpg" />&nbsp;&nbsp;<a href="<?=SITE_WS_PATH?>/product.php">Create New Session </a></li>
              <li><img src="../images/icon/mystore_icon.jpg" />&nbsp;&nbsp;<a href="<?=SITE_WS_PATH?>/music-store-list.php">My Music Store</a></li>
              <li><img src="../images/icon/sellmusic_icon.jpg" />&nbsp;&nbsp;<a href="<?=SITE_WS_PATH?>/music-store.php">Create Music Store </a></li>
              <li><img src="../images/icon/upgrade_icon.jpg" />&nbsp;&nbsp;<a href="<?=SITE_WS_PATH?>/membership-upgrade.php">Membership Upgrade </a></li>
              <li><img src="../images/icon/money_bag.png" width="22" height="22" align="absmiddle" />&nbsp;&nbsp;<a href="<?=SITE_WS_PATH?>/musician-sell-session.php">Sell Session History</a></li>
              <?php }?>
              <?php if($_SESSION['SESS_ACCOUNT_TYPE']=='Artist' && $profile_id=='') { ?>
              <li> <img src="<?=SITE_WS_PATH?>/images/icon/history_icon.jpg" />&nbsp;&nbsp;<a href="<?=SITE_WS_PATH?>/my-history.php">History</a></li>
              <li> <img src="<?=SITE_WS_PATH?>/images/icon/history_icon.jpg" />&nbsp;&nbsp;<a href="<?=SITE_WS_PATH?>/my-archive-history.php">Archive History</a></li>
              <li><img src="../images/icon/mystore_icon.jpg" />&nbsp;&nbsp;<a href="<?=SITE_WS_PATH?>/artist-music-store-list.php">My Music Store</a></li>
              <li><img src="../images/icon/sellmusic_icon.jpg" />&nbsp;&nbsp;<a href="<?=SITE_WS_PATH?>/artist-music-store.php">Create Music Store </a></li>
              <li> <img src="../images/icon/notebook_icon.jpg" />&nbsp;&nbsp;<a id="variousNotebook" href="#requestNotebook">Notebook</a>
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
              <li><img src="../images/icon/upgrade_icon.jpg" />&nbsp;&nbsp;<a href="<?=SITE_WS_PATH?>/artist-membership-upgrade.php">Membership Upgrade </a></li>
              
              
              <?php  }?>
             
              <?php if(($_SESSION['SESS_ID']!='' && $profile_id=='') || ($_SESSION['SESS_ID']!='' && $profile_id==$_SESSION['SESS_ID'])) { ?>
              <li><img src="<?=SITE_WS_PATH?>/images/icon/zip.png" width="22" height="22" />&nbsp;&nbsp;<a href="<?=SITE_WS_PATH?>/download.php">Music Download </a></li>
              <?php } ?>
               
              <?php } ?>
             <?php if(($_SESSION['SESS_ID']!='' && $profile_id=='') || ($_SESSION['SESS_ID']!='' && $profile_id==$_SESSION['SESS_ID'])) { ?>
              <li><img src="../images/icon/viewChart_icon.jpg" />&nbsp;&nbsp;<a href="<?=SITE_WS_PATH?>/chart.php">View Chart</a></li>
              
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
          <?php
		  }
		  ?>
          
          
          <?php 
		  $pro_msg = Get_Single_Field("member_account_master","Personal_Msg","Member_Account_Id","$_SESSION[SESS_ID]");
		  
		  if($_SESSION['SESS_ID']!='' && $profile_id=='') 
		  { 
			  if($pro_msg==0)
			  {
			  ?>
			   		<?php
					if(mysql_num_rows($result_collaboration)>0)
		            {
					?> 
                    <div class="blue-btn-4" style="padding:10px 0 10px 0;"> <span> <span> <span> <a href="<?=SITE_WS_PATH?>/message.php?uid=<?=md5($_SESSION['SESS_ID'])?>" >Send Message</a> </span> </span> </span> </div>
                    <?php
					}
					else
					{
					?>
                    <div class="blue-btn-4" style="padding:10px 0 10px 0;"> <span> <span> <span> <a href="<?=SITE_WS_PATH?>/message.php?ubid=<?=md5($_SESSION['SESS_ID'])?>" >Send Message</a> </span> </span> </span> </div>
                    <?php
					}
					?>
			  <?php 
			  } 
		  } 
		  elseif($_SESSION['SESS_ID']=='' && $profile_id!='')
		  {
			  if($pro_msg==0)
			  {
			  ?>
              <div class="blue-btn-4" style="padding:10px 0 10px 0;"> <span> <span> <span> <a href="<?=SITE_WS_PATH?>/login.php" >Send Message</a> </span> </span> </span> </div>
			   
			  <?php
			  }
		  }
		  elseif($_SESSION['SESS_ID']!='' && $profile_id!='')
		  {
		  ?>
          <div class="blue-btn-4" style="padding:10px 0 10px 0;"> <span><span><span> <a id="variousCollaborateMsg" href="#requestCollaborateMsg">Send Message</a>
                <div style="display: none;">
                <div id="requestCollaborateMsg" style="width:600px;height:350px;">
                <div style="padding: 5px 0 0 100px;">
                <form id="frmCollaborateMsg" name="frmCollaborateMsg" method="post" action="">
                <ul>
                <li>
                <ul class="login">
                <li>
                <h1>Message To Collaborate Friend </h1>
                </li>
                <li></li>
                </ul>
                </li>
                <li id="collaborate_friend_msg_id" style="padding: 5px 0 5px 0;"></li>
                
                 <li>
                <ul class="login">
                <li>Subject</li>
                <li><input type="text" name="Subject" onkeypress="if(event.keyCode==13) {return CollaborateFriendMsg('<?=$profile_id?>');}"></li>
                </ul>
                </li>
                
                
                <li>
                <ul class="login">
                <li>Message</li>
                <li><textarea name="Message" cols="57" rows="6" onkeypress="if(event.keyCode==13) {return CollaborateFriendMsg('<?=$profile_id?>');}"></textarea></li>
                </ul>
                </li>
                <li>
                <ul class="login">
                <li>&nbsp;</li>
                <li>
                <input class="button" name="buttonSubmit" type="button" value="Submit" onclick="return CollaborateFriendMsg('<?=$profile_id?>');" onkeypress="if(event.keyCode==13) {return CollaborateFriendMsg('<?=$profile_id?>');}">
                </li>
                </ul>
                </li>
                </ul>
                </form>
                </div>
                </div>
                </div>
                </span> </span> </span> </div>   
          <?php
          }
		  ?>
          
          
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
        <div class="rgtPannel2 fr">
        
        
<!--  <a href="javascript:animatedcollapse.toggle('jason')"><img src="http://www.mussino.com/images/letmeseebtn2.png" border="0" /></a> 

<div id="jason" style="width: 770px; display:none; ">-->

<div class="rgtPannel-col first">
          
 <h3>About
              <?=$colles['First_Name'].' '.$colles['Last_Name']?>
            </h3>
            <p>
              <?=stripslashes($colles['About_Me'])?>
            </p>
            </div>
            
            
<!--          </div>
 <div class="clear"></div>  -->       
          
          <div class="profilecollapsesec">
         <a href="javascript:animatedcollapse.toggle('jason')"> Active session</a>
          </div>
          
<!--  Active session collapse start  -->          
      <div id="jason" style="width: 770px; display:none">    
          <div class="rgtPannel-col second">
            <h3> Active session <span>The Active Session section showcase Musician latest active sessions. </span> </h3>
            <div id="slider2"> <a class="buttons prev" href="javascript:void(0);">left</a>
              <div class="inner-wrap">
                <div class="viewport">
                  <div class="overview" style="width:770px;">
                    <?php
					$t=1;
					if(mysql_num_rows($result_session)>0)
					{
					while($colles_session = mysql_fetch_array($result_session))
					{
					$sqlAudioCount = "SELECT COUNT(*) AS CtotalAudio FROM lyrics_post_audio_master WHERE Product_Id='".$colles_session['Product_Id']."' AND Lyrics_Audio_Type='AUDIO' AND Status=1";
					$resAudioCount = mysql_query($sqlAudioCount);
					$collesAudioCount = mysql_fetch_array($resAudioCount);
					$sqlVideoCount = "SELECT COUNT(*) AS CtotalVideo FROM lyrics_post_audio_master WHERE Product_Id='".$colles_session['Product_Id']."' AND Lyrics_Audio_Type='VIDEO' AND Status=1";
					$resVideoCount = mysql_query($sqlVideoCount);
					$collesVideoCount = mysql_fetch_array($resVideoCount);
					$sqlTextCount = "SELECT COUNT(*) AS CtotalText FROM lyrics_post_master WHERE Product_Id='".$colles_session['Product_Id']."' AND Status=1";
					$resTextCount = mysql_query($sqlTextCount);
					$collesTextCount = mysql_fetch_array($resTextCount);
					
					$totalPosts = $collesAudioCount['CtotalAudio'] + $collesVideoCount['CtotalVideo'] + $collesTextCount['CtotalText'];
					?>
                    <div class="session-loop">
                      <?php if(file_exists("products/product_image/$colles_session[Image_Name]") && $colles_session['Image_Name']!='') { ?>
                      <img src="<?=SITE_WS_PATH?>/products/product_image/<?php echo $colles_session['Image_Name']; ?>" border="0" width="100" height="100" alt="<?=stripslashes($colles_session['Title'])?>"/>
                      <?php } else { ?>
                      <img src="<?=SITE_WS_PATH?>/images/no-image.gif" border="0" width="100" height="100" alt="<?=stripslashes($colles_session['Title'])?>"/>
                      <?php } ?>
                      <ul>
                        <?php if($colles_session['Type']!='3') { ?>
                        <li>
                        <?php 
						$cctime= date("Y-m-d h:i:s");
						$sstime= $colles_session['Session_Start_Date'];
						$eetime= $colles_session['Session_End_Date'];
						$ddiff=get_time_difference( $sstime, $eetime );
						$ccdiff=get_time_difference( $cctime, $eetime );
						
						if(($ddiff['days']<=0 && $ddiff['hours']<=0 && $ddiff['minutes']<=0 && $ddiff['seconds']<=0) || ($ccdiff['days']<=0 && $ccdiff['hours']<=0 && $ccdiff['minutes']<=0 && $ccdiff['seconds']<=0) || (empty($ccdiff['days']) && empty($ccdiff['hours']) && empty($ccdiff['minutes']) && empty($ccdiff['seconds'])))
						{
						?>
						Close
						<?php
						}
						else
						{
						?>
						<script language="JavaScript">
						// This short script gets the date/time from the server and prints it
						var deltaD = (servertimeOBJ.getTime())-(new Date().getTime());
						var clientDate = new Date();
						var serverdate = new Date(clientDate.getTime()+deltaD);
						// At this point serverdate can be used for all date/time references in the rest of the script.
						// The math above corrects its value for the the client's local time offset.
						var hours=serverdate.getHours();
						var minutes=serverdate.getMinutes();
						var seconds=serverdate.getSeconds();
						var dn="AM";
						if (hours>=12){dn="PM";}
						if (hours>12){hours=hours-12;}
						if (hours==0){hours=12;}
						if (minutes<=9){minutes="0"+minutes;}
						var cdate=hours+":"+minutes+" "+dn;
						//document.write(cdate);
						
						///alert(serverdate);
                        TargetDate<?=$t?> = "<?=$colles_session['EndDate'];?>";
                        BackColor<?=$t?> = "#FFFFFF";
                        ForeColor<?=$t?> = "#47B3D5";
                        CountActive<?=$t?> = true;
                        CountStepper<?=$t?> = -1;
                        LeadingZero<?=$t?> = true;
                        DisplayFormat<?=$t?> = "%%D%% Days, %%H%% : %%M%% : %%S%% ";
                        FinishMessage<?=$t?> = "Close";
                        
                        function calcage<?=$t?>(secs<?=$t?>, num1<?=$t?>, num2<?=$t?>) {
                        s<?=$t?> = ((Math.floor(secs<?=$t?>/num1<?=$t?>))%num2<?=$t?>).toString();
                        if (LeadingZero<?=$t?> && s<?=$t?>.length < 2)
                        s<?=$t?> = "0" + s<?=$t?>;
                        return "<b>" + s<?=$t?> + "</b>";
                        }
                        
                        function CountBack<?=$t?>(secs<?=$t?>) {
                        if (secs<?=$t?> < 0) {
                        document.getElementById("cntdwn<?=$t?>").innerHTML = FinishMessage<?=$t?>;
                        
                        return;
                        }
                        DisplayStr<?=$t?> = DisplayFormat<?=$t?>.replace(/%%D%%/g, calcage<?=$t?>(secs<?=$t?>,86400,100000));
                        DisplayStr<?=$t?> = DisplayStr<?=$t?>.replace(/%%H%%/g, calcage<?=$t?>(secs<?=$t?>,3600,24));
                        DisplayStr<?=$t?> = DisplayStr<?=$t?>.replace(/%%M%%/g, calcage<?=$t?>(secs<?=$t?>,60,60));
                        DisplayStr<?=$t?> = DisplayStr<?=$t?>.replace(/%%S%%/g, calcage<?=$t?>(secs<?=$t?>,1,60));
                        
                        document.getElementById("cntdwn<?=$t?>").innerHTML = DisplayStr<?=$t?>;
                        if (CountActive<?=$t?>)
                        setTimeout("CountBack<?=$t?>(" + (secs<?=$t?>+CountStepper<?=$t?>) + ")", SetTimeOutPeriod<?=$t?>);
                        }
                        
                        function putspan<?=$t?>(backcolor<?=$t?>, forecolor<?=$t?>) {
                        document.write("<span class='cntsize' id='cntdwn<?=$t?>' style='background-color:" + backcolor<?=$t?> + 
                        "; color:" + forecolor<?=$t?> + "'></span>");
                        }
                        
                        if (typeof(BackColor<?=$t?>)=="undefined")
                        BackColor<?=$t?> = "white";
                        if (typeof(ForeColor<?=$t?>)=="undefined")
                        ForeColor<?=$t?>= "black";
                        if (typeof(TargetDate<?=$t?>)=="undefined")
                        TargetDate<?=$t?> = "12/31/2020 5:00 AM";
                        if (typeof(StartDate<?=$t?>)=="undefined")
                        //StartDate<?=$t?> = new Date();
						StartDate<?=$t?> = new Date(clientDate.getTime()+deltaD);
                        if (typeof(DisplayFormat<?=$t?>)=="undefined")
                        DisplayFormat<?=$t?> = "%%D%% Days, %%H%% Hours, %%M%% Minutes, %%S%% Seconds.";
                        if (typeof(CountActive<?=$t?>)=="undefined")
                        CountActive<?=$t?> = true;
                        if (typeof(FinishMessage<?=$t?>)=="undefined")
                        FinishMessage<?=$t?> = "";
                        if (typeof(CountStepper<?=$t?>)!="number")
                        CountStepper<?=$t?> = -1;
                        if (typeof(LeadingZero<?=$t?>)=="undefined")
                        LeadingZero<?=$t?> = true;
                        
                        CountStepper<?=$t?> = Math.ceil(CountStepper<?=$t?>);
                        if (CountStepper<?=$t?> == 0)
                        CountActive<?=$t?> = false;
                        var SetTimeOutPeriod<?=$t?> = (Math.abs(CountStepper<?=$t?>)-1)*1000 + 990;
                        putspan<?=$t?>(BackColor<?=$t?>, ForeColor<?=$t?>);
                        var dthen<?=$t?> = new Date(TargetDate<?=$t?>);
                        //var dnow<?=$t?> = new Date();
						var dnow<?=$t?> = new Date(clientDate.getTime()+deltaD);
                        if(CountStepper<?=$t?>>0)
                        ddiff<?=$t?> = new Date(dnow<?=$t?>-dthen<?=$t?>);
                        else
                        ddiff<?=$t?> = new Date(dthen<?=$t?>-dnow<?=$t?>);
                        gsecs<?=$t?> = Math.floor(ddiff<?=$t?>.valueOf()/1000);
                        CountBack<?=$t?>(gsecs<?=$t?>);
                        </script>
                        <?php
				        }
				        ?>
                        </li>
                        <?php } ?>
                        <li>Notes: <span>
                          <?=$colles_session['Product_Notes']?>
                          </span></li>
						<?php $TOTAL_ROYALTIES = ($colles_session['Product_Notes']*$totalPosts)+$colles_session['Royalties']; ?>
                        <li>Royalties: <span>$<?=number_format($TOTAL_ROYALTIES, 2, '.', ' ')?>
                          </span></li>
                        <li class="play-btn"><a href="<?=SITE_WS_PATH?>/preview-player.php?id=<?=$colles_session['Product_Id']?>" title="<?=stripslashes($colles_sound_type['Title'])?>" rel="gb_page_center[640, 360]" class="global-box">Play</a></li>
                      </ul>
                      <?php
					  $sql_bank_artist = "SELECT * FROM my_bank WHERE Product_Id='".$colles_session['Product_Id']."' AND Account_Type LIKE '%Artist%'";
					  $result_bank_artist = mysql_query($sql_bank_artist);
					  ?>
                      
                      <!-- Enter Session -->
                      <?php if($TOTAL_NOTES>=$colles_session['Product_Notes'] || $_SESSION['SESS_ACCOUNT_TYPE']=='Contest Judge') { ?>
                      
					  <?php if($_SESSION['SESS_ACCOUNT_TYPE']=='Artist') { ?>
                      <div class="square-btn"> <a href="<?=SITE_WS_PATH?>/create-session.php?id=<?=$colles_session['Product_Id']?>">
                        <?=$ACOUNT?>
                        </a> </div>
                      <?php  } elseif($_SESSION['SESS_ACCOUNT_TYPE']=='Contest Judge') { ?>
                      <?php if(mysql_num_rows($result_bank_artist)>=2 && $colles_session['Judges_Vote']==0) { ?>
                      <!--<div class="square-btn"> <a href="<?=SITE_WS_PATH?>/contest-juge-history.php?id=<?=$colles_session['Product_Id']?>">-->
                       <div class="square-btn"> <a href="javascript:void(0);" onmouseover="Tip('You can not enter active session or inactive to enter this session by administration')" onmouseout="UnTip()">
                        <?=$ACOUNT?>
                        </a> </div>
                      <?php } else { ?>
                      <div class="square-btn"> <a href="javascript:void(0);" onmouseover="Tip('Still not active session or inactive to enter this session by administration')" onmouseout="UnTip()">
                        <?=$ACOUNT?>
                        </a> </div>
                      <?php } ?>
                      <?php  } elseif($_SESSION['SESS_ACCOUNT_TYPE']=='Musician') { ?>
                      <div class="square-btn"> <a href="javascript:void(0);" onmouseover="Tip('Musician member can not enter active session')" onmouseout="UnTip()">
                        <?=$ACOUNT?>
                        </a> </div>
                      <?php } ?>
                      <?php } else { ?>
                      <div class="square-btn"> <a href="javascript:void(0);" onmouseover="Tip('You have less notes for enter session')" onmouseout="UnTip()" >
                        <?=$ACOUNT?>
                        </a> </div>
                      <?php } ?>
                    </div>
                    <?php
			 $t++;
			 }
			 }
			 else
			 {
			 echo'<div style="padding:20px 0 0 50px; font-size:16px; font-weight:bold; color:#47B3D5;">You have no current session</div>';
			 }
			 ?>
                    <div class="cl" ></div>
                  </div>
                </div>
              </div>
              <a class="buttons next" href="javascript:void(0);">right</a> </div>
          </div>
          
     </div>
<!--  Active session collapse end  -->   
          
          
          
          <?php if($_SESSION['SESS_ACCOUNT_TYPE']!='Contest Judge') { ?>
          <div class="rgtPannel-col second">
            <h3> Instrumental Store <span>The section displays Random Musician New releases you can also <a href="http://mussino.com/unreleased-music.php" target="_blank">check out here</a>.</span> </h3>
            <div id="slider3"> <a class="buttons prev" href="javascript:void(0);">left</a>
              <div class="inner-wrap">
                <div class="viewport">
                  <div class="overview">
                    <?php
					$tt=1;
					if(mysql_num_rows($result_session1)>0)
					{
					while($colles_session1 = mysql_fetch_array($result_session1))
					{
					?>
                    <div class="session-loop">
                      <?php if(file_exists("products/product_image/$colles_session1[Image_Name]") && $colles_session1['Image_Name']!='') { ?>
                      <img src="<?=SITE_WS_PATH?>/products/product_image/<?php echo $colles_session1['Image_Name']; ?>" border="0" width="100" height="100" alt="<?=stripslashes($colles_session1['Title'])?>"/>
                      <?php } else { ?>
                      <img src="<?=SITE_WS_PATH?>/images/no-image.gif" border="0" width="100" height="100" alt="<?=stripslashes($colles_session1['Title'])?>"/>
                      <?php } ?>
                      <ul>
                        <li>
                          <?=stripslashes(ucfirst(Get_Single_Field("member_account_master","First_Name","Member_Account_Id","$colles_session1[Member_Account_Id]")))?>
                        </li>
                        <li>Title: <span>
                          <?=substr($colles_session1['Title'],0,12)?>
                          <?php if(strlen(ms_stripslashes($colles_session1['Title']))>=12){ echo ".."; }?>
                          </span></li>
                        <li>Release: <span>$
                          <?=$colles_session1['Price']?>
                          </span></li>
                        <li class="play-btn"><a href="<?=SITE_WS_PATH?>/preview-player.php?id=<?=$colles_session1['Product_Id']?>" title="<?=stripslashes($colles_sound_type['Title'])?>" rel="gb_page_center[640, 360]" class="global-box">Play</a></li>
                      </ul>
                      <?php if($_SESSION['SESS_ID']==$colles_session1['Member_Account_Id'] && $_SESSION['SESS_ACCOUNT_TYPE']=='Musician') { ?>
                      <div class="square-btn"> <a href="<?=SITE_WS_PATH?>/music-store.php?id=<?=$colles_session1['Product_Id']?>">Edit Me</a> </div>
                      <?php } else { ?>
                      <div class="square-btn"> <a href="<?=SITE_WS_PATH?>/buy-unreleased-music-to-cart.php?id=<?=$colles_session1['Product_Id']?>">Download Now</a> </div>
                      <?php } ?>
                    </div>
                    <?php
			 $tt++;
			 }
			 }
			 else
			 {
			 echo'<div style="padding:20px 0 0 50px; font-size:16px; font-weight:bold; color:#47B3D5;">Store Closed</div>';
			 }
			 ?>
                    <div class="cl" ></div>
                  </div>
                </div>
              </div>
              <a class="buttons next" href="javascript:void(0);">right</a> </div>
            <div class="cl"></div>
          </div>
          
          <div class="rgtPannel-col sixth">
            <h3> Sell Session Music <span></h3>
            <div id="slider6"> <a class="buttons prev" href="javascript:void(0);">left</a>
              <div class="inner-wrap">
                <div class="viewport">
                  <div class="overview">
                    <?php
					$tt=1;
					if(mysql_num_rows($result_session6)>0)
					{
					while($colles_session6 = mysql_fetch_array($result_session6))
					{
					$lyrics = Get_Single_Field("lyrics_post_master","Lyrics","Lyrics_Post_Id","$colles_session6[Lyrics_Post_Id]");
					$pro_id = Get_Single_Field("lyrics_post_master","Product_Id","Lyrics_Post_Id","$colles_session6[Lyrics_Post_Id]");
					$player_id = Get_Single_Field("lyrics_post_audio_master","Lyrics_Post_Audio_Id","Product_Id","$pro_id");
					?>
                    <div class="session-loop">
                      <span style="text-align:justify; min-height:50px;"><?=stripslashes(substr($lyrics,0,50))?> <?php if(strlen(ms_stripslashes($lyrics))>50){ echo ".."; }?></span>
                      <ul style="padding-bottom:15px;">
                        <li>
                          <?=stripslashes(ucfirst(Get_Single_Field("member_account_master","First_Name","Member_Account_Id","$colles_session6[Artist_Id]")))?>
                        </li>
                        
                        <li>Release: <span>$
                          <?=$colles_session6['Price']?>
                          </span></li>
                         <?php if($player_id!='') { ?> 
                        <li class="play-btn"><a href="<?=SITE_WS_PATH?>/preview-history-player.php?id=<?=$player_id?>" title="" rel="gb_page_center[640, 360]" class="global-box">Play</a></li>
                        <?php } ?>
                      </ul>
                      <?php if($player_id!='') { ?>
                      <?php if($_SESSION['SESS_ID']==$colles_session6['Artist_Id'] && $_SESSION['SESS_ACCOUNT_TYPE']=='Artist') { ?>
                      <!--div class="square-btn"> <a href="<?=SITE_WS_PATH?>/create-session.php?id=<?=$player_id?>">Edit Me</a> </div-->
                      <?php } else { ?>
                      <div class="square-btn"> <a href="<?=SITE_WS_PATH?>/buy-artist-sell-session-music-to-cart.php?id=<?=$colles_session6['S_S_Id']?>">Download Now</a> </div>
                      <?php } } ?>
                    </div>
                    <?php
					 $tt++;
					 }
					 }
					 else
					 {
					 echo'<div style="padding:20px 0 0 50px; font-size:16px; font-weight:bold; color:#47B3D5;">Store Closed</div>';
					 }
					 ?>
                    <div class="cl" ></div>
                  </div>
                </div>
              </div>
              <a class="buttons next" href="javascript:void(0);">right</a> </div>
            <div class="cl"></div>
          </div>
          
          <div class="rgtPannel-col second">
            <h3> Music Store <span>The section displays Random Artist New releases you can also <a href="http://mussino.com/store.php" target="_blank">check out here</a>.</span> </h3>
            <div id="slider4"> <a class="buttons prev" href="javascript:void(0);">left</a>
              <div class="inner-wrap">
                <div class="viewport">
                  <div class="overview">
                    <?php
					$tt=1;
					if(mysql_num_rows($result_session2)>0)
					{
					while($colles_session2 = mysql_fetch_array($result_session2))
					{
					?>
                    <div class="session-loop">
                      <?php if(file_exists("products/product_image/$colles_session2[Image_Name]") && $colles_session2['Image_Name']!='') { ?>
                      <img src="<?=SITE_WS_PATH?>/products/product_image/<?php echo $colles_session2['Image_Name']; ?>" border="0" width="100" height="100" alt="<?=stripslashes($colles_session2['Title'])?>"/>
                      <?php } else { ?>
                      <img src="<?=SITE_WS_PATH?>/images/no-image.gif" border="0" width="100" height="100" alt="<?=stripslashes($colles_session2['Title'])?>"/>
                      <?php } ?>
                      <ul>
                        <li>
                          <?=stripslashes(ucfirst(Get_Single_Field("member_account_master","First_Name","Member_Account_Id","$colles_session2[Member_Account_Id]")))?>
                        </li>
                        <li>Title: <span>
                          <?=substr($colles_session2['Title'],0,12)?>
                          <?php if(strlen(ms_stripslashes($colles_session2['Title']))>=12){ echo ".."; }?>
                          </span></li>
                        <li>Release: <span>$
                          <?=$colles_session2['Price']?>
                          </span></li>
                        <li class="play-btn"><a href="<?=SITE_WS_PATH?>/preview-player.php?id=<?=$colles_session2['Product_Id']?>" title="<?=stripslashes($colles_sound_type['Title'])?>" rel="gb_page_center[640, 360]" class="global-box">Play</a></li>
                      </ul>
                      <?php if($_SESSION['SESS_ID']==$colles_session2['Member_Account_Id'] && $_SESSION['SESS_ACCOUNT_TYPE']=='Artist') { ?>
                      <div class="square-btn"> <a href="<?=SITE_WS_PATH?>/artist-music-store.php?id=<?=$colles_session2['Product_Id']?>">Edit Me</a> </div>
                      <?php } else { ?>
                      <div class="square-btn"> <a href="<?=SITE_WS_PATH?>/buy-artist-music-to-cart.php?id=<?=$colles_session2['Product_Id']?>">Download Now</a> </div>
                      <?php } ?>
                    </div>
                    <?php
					 $tt++;
					 }
					 }
					 else
					 {
					 echo'<div style="padding:20px 0 0 50px; font-size:16px; font-weight:bold; color:#47B3D5;">Store Closed</div>';
					 }
					 ?>
                    <div class="cl" ></div>
                  </div>
                </div>
              </div>
              <a class="buttons next" href="javascript:void(0);">right</a> </div>
            <div class="cl"></div>
          </div>
          
          <?php } else { ?>
          <div class="rgtPannel-col second">
            <h3> Close session <span>The Close Session section showcase Musician latest close sessions. </span> </h3>
            <div id="slider5"> <a class="buttons prev" href="javascript:void(0);">left</a>
              <div class="inner-wrap">
                <div class="viewport">
                  <div class="overview">
                    <?php
					$t=1;
					if(mysql_num_rows($result_session_close)>0)
					{
					while($colles_session_close = mysql_fetch_array($result_session_close))
					{
					$sqlAudioCount = "SELECT COUNT(*) AS CtotalAudio FROM lyrics_post_audio_master WHERE Product_Id='".$colles_session_close['Product_Id']."' AND Lyrics_Audio_Type='AUDIO' AND Status=1";
					$resAudioCount = mysql_query($sqlAudioCount);
					$collesAudioCount = mysql_fetch_array($resAudioCount);
					$sqlVideoCount = "SELECT COUNT(*) AS CtotalVideo FROM lyrics_post_audio_master WHERE Product_Id='".$colles_session_close['Product_Id']."' AND Lyrics_Audio_Type='VIDEO' AND Status=1";
					$resVideoCount = mysql_query($sqlVideoCount);
					$collesVideoCount = mysql_fetch_array($resVideoCount);
					$sqlTextCount = "SELECT COUNT(*) AS CtotalText FROM lyrics_post_master WHERE Product_Id='".$colles_session_close['Product_Id']."' AND Status=1";
					$resTextCount = mysql_query($sqlTextCount);
					$collesTextCount = mysql_fetch_array($resTextCount);
					
					$totalPosts = $collesAudioCount['CtotalAudio'] + $collesVideoCount['CtotalVideo'] + $collesTextCount['CtotalText'];
					?>
                    <div class="session-loop">
                      <?php if(file_exists("products/product_image/$colles_session[Image_Name]") && $colles_session_close['Image_Name']!='') { ?>
                      <img src="<?=SITE_WS_PATH?>/products/product_image/<?php echo $colles_session_close['Image_Name']; ?>" border="0" width="100" height="100" alt="<?=stripslashes($colles_session['Title'])?>"/>
                      <?php } else { ?>
                      <img src="<?=SITE_WS_PATH?>/images/no-image.gif" border="0" width="100" height="100" alt="<?=stripslashes($colles_session_close['Title'])?>"/>
                      <?php } ?>
                      <ul>
                        <?php if($colles_session_close['Type']!='3') { ?>
                        <li style="height:16px;">
                       <?php 
                    $cctime= date("Y-m-d h:i:s");
                    $sstime= $colles_session_close['Session_Start_Date'];
                    $eetime= $colles_session_close['Session_End_Date'];
                    $ddiffc=get_time_difference( $sstime, $eetime );
                    $ccdiffc=get_time_difference( $cctime, $eetime );
					
                    if(($ddiffc['days']<=0 && $ddiffc['hours']<=0 && $ddiffc['minutes']<=0 && $ddiffc['seconds']<=0) || ($ccdiffc['days']<=0 && $ccdiffc['hours']<=0 && $ccdiffc['minutes']<=0 && $ccdiffc['seconds']<=0) || (empty($ccdiffc['days']) && empty($ccdiffc['hours']) && empty($ccdiffc['minutes']) && empty($ccdiffc['seconds'])))
                    {
                    ?>
                     Close
                    <?php
                    }
                    else
                    {
                    ?>
					<script language="JavaScript">
                    // This short script gets the date/time from the server and prints it
                    var deltaD = (servertimeOBJ.getTime())-(new Date().getTime());
                    var clientDate = new Date();
                    var serverdate = new Date(clientDate.getTime()+deltaD);
                    // At this point serverdate can be used for all date/time references in the rest of the script.
                    // The math above corrects its value for the the client's local time offset.
                    var hours=serverdate.getHours();
                    var minutes=serverdate.getMinutes();
                    var seconds=serverdate.getSeconds();
                    var dn="AM";
                    if (hours>=12){dn="PM";}
                    if (hours>12){hours=hours-12;}
                    if (hours==0){hours=12;}
                    if (minutes<=9){minutes="0"+minutes;}
                    var cdate=hours+":"+minutes+" "+dn;
                    //document.write(cdate);
                    
                    ///alert(serverdate);
                    TargetDate<?=$t?> = "<?=$colles_session_close['EndDate'];?>";
                    BackColor<?=$t?> = "#FFFFFF";
                    ForeColor<?=$t?> = "#47B3D5";
                    CountActive<?=$t?> = true;
                    CountStepper<?=$t?> = -1;
                    LeadingZero<?=$t?> = true;
                    DisplayFormat<?=$t?> = "%%D%% Days, %%H%% : %%M%% : %%S%% ";
                    FinishMessage<?=$t?> = "Close";
                    
                    function calcage<?=$t?>(secs<?=$t?>, num1<?=$t?>, num2<?=$t?>) {
                    s<?=$t?> = ((Math.floor(secs<?=$t?>/num1<?=$t?>))%num2<?=$t?>).toString();
                    if (LeadingZero<?=$t?> && s<?=$t?>.length < 2)
                    s<?=$t?> = "0" + s<?=$t?>;
                    return "<b>" + s<?=$t?> + "</b>";
                    }
                    
                    function CountBack<?=$t?>(secs<?=$t?>) {
                    if (secs<?=$t?> < 0) {
                    document.getElementById("cntdwn<?=$t?>").innerHTML = FinishMessage<?=$t?>;
                    
                    return;
                    }
                    DisplayStr<?=$t?> = DisplayFormat<?=$t?>.replace(/%%D%%/g, calcage<?=$t?>(secs<?=$t?>,86400,100000));
                    DisplayStr<?=$t?> = DisplayStr<?=$t?>.replace(/%%H%%/g, calcage<?=$t?>(secs<?=$t?>,3600,24));
                    DisplayStr<?=$t?> = DisplayStr<?=$t?>.replace(/%%M%%/g, calcage<?=$t?>(secs<?=$t?>,60,60));
                    DisplayStr<?=$t?> = DisplayStr<?=$t?>.replace(/%%S%%/g, calcage<?=$t?>(secs<?=$t?>,1,60));
                    
                    document.getElementById("cntdwn<?=$t?>").innerHTML = DisplayStr<?=$t?>;
                    if (CountActive<?=$t?>)
                    setTimeout("CountBack<?=$t?>(" + (secs<?=$t?>+CountStepper<?=$t?>) + ")", SetTimeOutPeriod<?=$t?>);
                    }
                    
                    function putspan<?=$t?>(backcolor<?=$t?>, forecolor<?=$t?>) {
                    document.write("<span class='cntsize' id='cntdwn<?=$t?>' style='background-color:" + backcolor<?=$t?> + 
                    "; color:" + forecolor<?=$t?> + "'></span>");
                    }
                    
                    if (typeof(BackColor<?=$t?>)=="undefined")
                    BackColor<?=$t?> = "white";
                    if (typeof(ForeColor<?=$t?>)=="undefined")
                    ForeColor<?=$t?>= "black";
                    if (typeof(TargetDate<?=$t?>)=="undefined")
                    TargetDate<?=$t?> = "12/31/2020 5:00 AM";
                    if (typeof(StartDate<?=$t?>)=="undefined")
                    //StartDate<?=$t?> = new Date();
                    StartDate<?=$t?> = new Date(clientDate.getTime()+deltaD);
                    if (typeof(DisplayFormat<?=$t?>)=="undefined")
                    DisplayFormat<?=$t?> = "%%D%% Days, %%H%% Hours, %%M%% Minutes, %%S%% Seconds.";
                    if (typeof(CountActive<?=$t?>)=="undefined")
                    CountActive<?=$t?> = true;
                    if (typeof(FinishMessage<?=$t?>)=="undefined")
                    FinishMessage<?=$t?> = "";
                    if (typeof(CountStepper<?=$t?>)!="number")
                    CountStepper<?=$t?> = -1;
                    if (typeof(LeadingZero<?=$t?>)=="undefined")
                    LeadingZero<?=$t?> = true;
                    
                    CountStepper<?=$t?> = Math.ceil(CountStepper<?=$t?>);
                    if (CountStepper<?=$t?> == 0)
                    CountActive<?=$t?> = false;
                    var SetTimeOutPeriod<?=$t?> = (Math.abs(CountStepper<?=$t?>)-1)*1000 + 990;
                    putspan<?=$t?>(BackColor<?=$t?>, ForeColor<?=$t?>);
                    var dthen<?=$t?> = new Date(TargetDate<?=$t?>);
                    //var dnow<?=$t?> = new Date();
                    var dnow<?=$t?> = new Date(clientDate.getTime()+deltaD);
                    if(CountStepper<?=$t?>>0)
                    ddiff<?=$t?> = new Date(dnow<?=$t?>-dthen<?=$t?>);
                    else
                    ddiff<?=$t?> = new Date(dthen<?=$t?>-dnow<?=$t?>);
                    gsecs<?=$t?> = Math.floor(ddiff<?=$t?>.valueOf()/1000);
                    CountBack<?=$t?>(gsecs<?=$t?>);
                    </script>
                    <?php
				   }
				   ?>
                        </li>
                        <?php } ?>
                        <li>Notes: <span>
                          <?=$colles_session_close['Product_Notes']?>
                          </span></li>
                        <?php $TOTAL_ROYALTIES = ($colles_session_close['Product_Notes']*$totalPosts)+$colles_session_close['Royalties']; ?>
                        <li>Royalties: <span>$ <?=$TOTAL_ROYALTIES;?> </span></li>
                        <li class="play-btn"><a href="<?=SITE_WS_PATH?>/preview-player.php?id=<?=$colles_session_close['Product_Id']?>" title="<?=stripslashes($colles_sound_type['Title'])?>" rel="gb_page_center[640, 360]" class="global-box">Play</a></li>
                      </ul>
                      <?php
					  $sql_bank_artist = "SELECT * FROM my_bank WHERE Product_Id='".$colles_session_close['Product_Id']."' AND Account_Type LIKE '%Artist%'";
					  $result_bank_artist = mysql_query($sql_bank_artist);
					  ?>
                      
                      <!-- Enter Session -->
                      <?php if($TOTAL_NOTES>=$colles_session_close['Product_Notes'] || $_SESSION['SESS_ACCOUNT_TYPE']=='Contest Judge') { ?>
                      <?php if($_SESSION['SESS_ACCOUNT_TYPE']=='Artist') { ?>
                      <div class="square-btn"> <a href="<?=SITE_WS_PATH?>/create-session.php?id=<?=$colles_session_close['Product_Id']?>">
                        <?=$ACOUNT?>
                        </a> </div>
                      <?php  } elseif($_SESSION['SESS_ACCOUNT_TYPE']=='Contest Judge') { ?>
                      <?php if(mysql_num_rows($result_bank_artist)>=2 && $colles_session_close['Judges_Vote']==0) { ?>
                      <div class="square-btn"> <a href="<?=SITE_WS_PATH?>/contest-juge-history.php?id=<?=$colles_session_close['Product_Id']?>">
                        <?=$ACOUNT?>
                        </a> </div>
                      <?php } else { ?>
                      <div class="square-btn"> <a href="javascript:void(0);" onmouseover="Tip('Still not active session or inactive to enter this session by administration')" onmouseout="UnTip()">
                        <?=$ACOUNT?>
                        </a> </div>
                      <?php } ?>
                      <?php  } elseif($_SESSION['SESS_ACCOUNT_TYPE']=='Musician') { ?>
                      <div class="square-btn"> <a href="javascript:void(0);" onmouseover="Tip('Musician Member Can Not Enter Active Session')" onmouseout="UnTip()">
                        <?=$ACOUNT?>
                        </a> </div>
                      <?php } ?>
                      <?php } else { ?>
                      <div class="square-btn"> <a href="javascript:void(0);" onmouseover="Tip('You Have Less Notes For Enter Session')" onmouseout="UnTip()" >
                        <?=$ACOUNT?>
                        </a> </div>
                      <?php } ?>
                    </div>
                    <?php
			 $t++;
			 }
			 }
			 else
			 {
			 echo'<div style="padding:20px 0 0 50px; font-size:16px; font-weight:bold; color:#47B3D5;">You have no close session</div>';
			 }
			 ?>
                    <div class="cl" ></div>
                  </div>
                </div>
              </div>
              <a class="buttons next" href="javascript:void(0);">right</a> </div>
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
