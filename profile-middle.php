<?php
if($_REQUEST['profile_id']=='')
{
$sql = "SELECT * FROM member_account_master WHERE Member_Account_Id='".$_SESSION['SESS_ID']."'";
$result = mysql_query($sql);
$colles = mysql_fetch_array($result);
$sqlCount = "SELECT count(*) as total FROM product_master WHERE Member_Account_Id='".$_SESSION['SESS_ID']."'";
$resultCount = mysql_query($sqlCount);
$collesCount = mysql_fetch_array($resultCount);
$totalPosts = $collesCount['total'];
$sql_collaboration = "SELECT * FROM member_account_master WHERE Status=1 AND Collaborate_Id ='".$_SESSION['SESS_ID']."' ORDER BY First_Name,Last_Name";
$result_collaboration = mysql_query($sql_collaboration) or die('<br>'.$sql_collaboration.'<br>'.mysql_error());
}
else
{
$sql = "SELECT * FROM member_account_master WHERE Member_Account_Id='".$_REQUEST['profile_id']."'";
$result = mysql_query($sql);
$colles = mysql_fetch_array($result);
$sqlCount = "SELECT count(*) as total FROM product_master WHERE Member_Account_Id='".$_REQUEST['profile_id']."'";
$resultCount = mysql_query($sqlCount);
$collesCount = mysql_fetch_array($resultCount);
$totalPosts = $collesCount['total'];
$sql_collaboration = "SELECT * FROM member_account_master WHERE Status=1 AND Collaborate_Id ='".$_REQUEST['profile_id']."' ORDER BY First_Name,Last_Name";
$result_collaboration = mysql_query($sql_collaboration) or die('<br>'.$sql_collaboration.'<br>'.mysql_error());
}
?>

<div id="page-wrapper">
  <div class="layoutArea">
    <div class="contentArea">
    <div class="content-box-2">
        <div class="cor_1set-5"></div>
        <div class="cor_1set-6"></div>
      <div class="lftPannel profile">
        <div class="userPrt">
          <h1>
            <?=$colles['First_Name']?>
            Sounds</h1>
          <?php if(file_exists("products/user_image/$colles[Photo]") && $colles['Photo']!='') { ?>
          <img src="products/user_image/<?php echo $colles['Photo']; ?>" border="0" width="181" height="171" />
          <?php } else { ?>
          <img src="images/user_big.png" border="0" width="181" height="171" />
          <?php } ?>
          
          <ul>
			<?php
            if($_REQUEST['profile_id']=='') {
            $sql_my_bank = "SELECT sum(Notes_Value) as myTotalEarning FROM my_bank WHERE To_Member_Account_Id='".$_SESSION['SESS_ID']."' AND Jack_Pot_Status='End'";
            }
            else
            {
            $sql_my_bank = "SELECT sum(Notes_Value) as myTotalEarning FROM my_bank WHERE To_Member_Account_Id='".$_REQUEST['profile_id']."' AND Jack_Pot_Status='End'";
            }
            
            $result_my_bank = mysql_query($sql_my_bank);
            if(mysql_num_rows($result_my_bank)>0)
            {
            $colles_my_bank = mysql_fetch_array($result_my_bank);
            ?>
            <li><strong>My Bank: </strong><span>$<? printf('%1.2f',$colles_my_bank['myTotalEarning']);?></span></li>
            <?php
            }
            else
            {
            ?>
            <li><strong>My Bank: </strong><span>$0.00</span></li>
            <?php } ?>
            <li><strong>Posts: </strong>
              <span><?=$totalPosts?></span>
            </li>
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
            <li><strong>Notes: </strong>
              <span><?=$TOTAL_NOTES_PP;?></span>
            </li>
            <?php
                        }
                        else
                        {
                        ?>
            <li><strong>Notes: </strong>0</li>
            <?php }  ?>
          </ul>
        </div>
        <div style="padding: 5px 0 5px 50px;"><?=$colles['Account_Type']?></div>
        <?php if($_REQUEST['profile_id']=='') { ?>
        <div style="padding: 5px 0 5px 50px;"><a href="change-image.php" title="Sample link">Change Image</a></div>
        <div style="padding: 2px 0 2px 50px;"><a href="edit-profile.php" title="Sample link">Profile Edit</a></div>
        <div style="padding: 2px 0 2px 50px;"><a href="change-password.php" title="Sample link">Changes Password</a></div>
        <div style="padding: 2px 0 2px 50px;"><a href="product-list.php" title="Sample link">My Product Queue</a></div>
        <?php } ?>
        <div class="aboutMe">
          <h1>About Me</h1>
          <p> <?=stripslashes($colles['About_Me'])?> </p>
        </div>
        <?php if($_REQUEST['profile_id']=='') { ?>
        <div class="s_btn"><a href="#">Favorite Musician</a><span></span></div>
        <br style="clear:both;"/>
        <div class="s_btn"><a href="#">View History</a><span></span></div>
        <br style="clear:both;"/>
        <div class="s_btn"><a href="profile-action.php?st=<?=$colles['Show_Profile']?>">
          <?=ucfirst($colles['Show_Profile'])?>
          Profile</a><span></span></div>
          <br style="clear:both;"/>
          <?php if($_SESSION['SESS_ACCOUNT_TYPE']!='Contest Judge') { ?>
        	<div class="s_btn"><a href="collaborate.php">Add Collaborate </a><span></span></div>
        <?php } }?>
      </div>
      <div class="midPannel progressMeter">
      <?php if($_SESSION['SESS_ACCOUNT_TYPE']!='Contest Judge') { ?>
        <h1>Progress Meter</h1>
        <p>This shows how many posts you win and lose</p>
        <h2><span>Win : 20</span><span>Loss : 15</span></h2>
        <div class="progressBar"> <img src="images/progress_img.png" /> </div>
        <?php } ?>
        <?php if($_SESSION['SESS_ACCOUNT_TYPE']!='Contest Judge') { ?>
        <h3>Collaboration</h3>
        <ul class="frnd_block">
          <?php
		  while($collesCollaboration = mysql_fetch_array($result_collaboration))
		  {
		  ?>
          <li><?php if(file_exists("products/user_image/$collesCollaboration[Photo]") && $collesCollaboration['Photo']!='') { ?>
            <img src="products/user_image/<?php echo $collesCollaboration['Photo']; ?>" border="0" width="60" height="60"  />
            <?php } else { ?>
            <img src="images/no-image.gif" border="0" width="60" height="60" />
            <?php } ?>
        </li>
          <?php
		  }
		  ?>
        </ul>
        <?php } ?>
      </div>
      <div class="rgtPannel ad">
        <h3>Advertisement Here:</h3>
        <img src="images/advertisement1.png" /> <img src="images/advertisement2.png" />
        <h3>Advertisement Here:</h3>
      </div>
      <div class="cl"></div>
      <div class="cor_1set-3"></div>
        <div class="cor_1set-4"></div>
      </div>
      <div class="bottomPannel"> <a href="#">
        <?php if(file_exists("products/user_image/$colles[Photo]") && $colles['Photo']!='') { ?>
        <img src="products/user_image/<?php echo $colles['Photo']; ?>" border="0" width="28" height="27" />
        <?php } else { ?>
        <img src="images/user_small.png" border="0" width="28" height="27" />
        <?php } ?>
        </a>
        <ul>
          <li>
            <?php if($_SESSION['SESS_EMAIL']!='') { ?>
            <a href="my-profile.php">User:
            <?=ucfirst($colles['First_Name'])?>
            </a>
            <?php } ?>
          </li>
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
          <li><a href="#">Notes:
            <?=$TOTAL_NOTES_PP;?>
            </a></li>
          <?php
					}
					else
					{
					?>
          <li><a href="#">Notes: 0 </a></li>
          <?php }  ?>
          <?php
					if($_REQUEST['profile_id']=='') {
					  $sql_my_bank = "SELECT sum(Notes_Value) as myTotalEarning FROM my_bank WHERE To_Member_Account_Id='".$_SESSION['SESS_ID']."' AND Jack_Pot_Status='End'";
					  }
					  else
					  {
					  $sql_my_bank = "SELECT sum(Notes_Value) as myTotalEarning FROM my_bank WHERE To_Member_Account_Id='".$_REQUEST['profile_id']."' AND Jack_Pot_Status='End'";
					  }
					  $result_my_bank = mysql_query($sql_my_bank);
					  if(mysql_num_rows($result_my_bank)>0)
					  {
					  $colles_my_bank = mysql_fetch_array($result_my_bank);
					  /*if($colles_my_bank['myTotalEarning']>0 && $colles_my_bank['myTotalEarning']<25)
					  {
					  $MYBANK = $colles_my_bank['myTotalEarning'];
					  }
					  elseif($colles_my_bank['myTotalEarning']>=25 && $colles_my_bank['myTotalEarning']<50)
					  {
					  $MYBANK = '$15.00';
					  }
					  elseif($colles_my_bank['myTotalEarning']>=50 && $colles_my_bank['myTotalEarning']<100)
					  {
					  $MYBANK = '$40.00';
					  }
					  elseif($colles_my_bank['myTotalEarning']>=100 )
					  {
					  $MYBANK = '$85.00';
					  }*/
					  ?>
          <li><a href="#">Bank: $<? printf('%1.2f',$colles_my_bank['myTotalEarning']);?></a></li>
          <?php
					}
					else
					{
					?>
          <li><a href="#">$0.00</a></li>
          <?php } ?>
        </ul>
        <span><a href="notes-plan.php">Buy Notes</a></span> </div>
    </div>
  </div>
</div>
