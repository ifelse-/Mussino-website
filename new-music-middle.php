<?php
include("includes/rating_functions.php"); 
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
<link href="css/rating_style.css" rel="stylesheet" type="text/css" media="all">
<script type="text/javascript" src="js/rating_update.js"></script>
<div id="page-wrapper">
  <div class="layoutArea">
    <div class="contentArea">
    <div class="content-box-2">
        <div class="cor_1set-5"></div>
        <div class="cor_1set-6"></div>
        <div class="dark-gray_wrap">
          <h3>Top New Music Releases</h3>
          <div class="fl">
            <div class="new-albm">
              <a href="#"><img class="cover" src="images/albm-cover.jpg" alt="" /></a>
              <ul class="albm-detail">
                <li>Del The</li>
                <li>1 day ago</li>
                <li class="title">Song Title</li>
                <li>Price: $15.00</li>
              </ul>
              <div class="black-btn">
                <span>
                  <span><a href="#">Preveiw</a></span>
                </span>
              </div>
              <div class="gray-btn-2">
                <a href="#">Download Now</a>
              </div>
            </div>
            <div class="new-albm">
              <a href="#"><img class="cover" src="images/albm-cover.jpg" alt="" /></a>
              <ul class="albm-detail">
                <li>Del The</li>
                <li>1 day ago</li>
                <li class="title">Song Title</li>
                <li>Price: $15.00</li>
              </ul>
              <div class="black-btn">
                <span>
                  <span><a href="#">Preveiw</a></span>
                </span>
              </div>
              <div class="gray-btn-2">
                <a href="#">Download Now</a>
              </div>
            </div>
            <div class="new-albm">
              <a href="#"><img class="cover" src="images/albm-cover.jpg" alt="" /></a>
              <ul class="albm-detail">
                <li>Del The</li>
                <li>1 day ago</li>
                <li class="title">Song Title</li>
                <li>Price: $15.00</li>
              </ul>
              <div class="black-btn">
                <span>
                  <span><a href="#">Preveiw</a></span>
                </span>
              </div>
              <div class="gray-btn-2">
                <a href="#">Download Now</a>
              </div>
            </div>
            <div class="new-albm">
              <a href="#"><img class="cover" src="images/albm-cover.jpg" alt="" /></a>
              <ul class="albm-detail">
                <li>Del The</li>
                <li>1 day ago</li>
                <li class="title">Song Title</li>
                <li>Price: $15.00</li>
              </ul>
              <div class="black-btn">
                <span>
                  <span><a href="#">Preveiw</a></span>
                </span>
              </div>
              <div class="gray-btn-2">
                <a href="#">Download Now</a>
              </div>
            </div>
            <div class="cl"></div>
          </div>
          <div class="fr"><img src="images/ad.jpg" alt="" /></div>
          <div class="cl"></div>
        </div>
        <div class="genre-wrap">
          <div class="genre-col">
            <h3><?=ucfirst(stripslashes(Get_Single_Field("sound_type_master","Sound_Type_Name","Sound_Type_Id","1")));?></h3>
            <?php
			$sql_sound_type1 = "SELECT * FROM product_master WHERE Sound=1";
			$result_sound_type1 = mysql_query($sql_sound_type1);
			while($colles_sound_type1 = mysql_fetch_array($result_sound_type1))
			{
			?>
            <div class="genre-block">
              <div class="genre-img">
                <a href="javascript:void(0);" style="cursor:text;">
                 <?php if(file_exists("products/product_image/$colles_sound_type1[Image_Name]") && $colles_sound_type1['Image_Name']!='') { ?>
                <img src="products/product_image/<?php echo $colles_sound_type1['Image_Name']; ?>" border="0"  alt="<?=stripslashes($colles_sound_type1['Title'])?>"/>
                <?php } else { ?>
                <img src="images/no-image.gif" border="0"  alt="<?=stripslashes($colles_sound_type1['Title'])?>"/>
                <?php } ?> 
                </a>
                <div class="add-btn"><a href="buy-unreleased-music-to-cart.php?id=<?=$colles_sound_type1['Product_Id']?>">Fav</a></div>
              </div>
              <div class="genre-info">
                <ul>
                  <li><?=stripslashes(ucfirst(Get_Single_Field("member_account_master","First_Name","Member_Account_Id","$colles_sound_type1[Member_Account_Id]")).' '.ucfirst(Get_Single_Field("member_account_master","Last_Name","Member_Account_Id","$colles_sound_type1[Member_Account_Id]")))?></li>
                  <li><?=stripslashes($colles_sound_type1['Title'])?></li>
                  <li>Price: $<?=trim($colles_sound_type1['Price'])?></li>
                </ul>
                <div><? echo pullRating($colles_sound_type1['Product_Id'],false,true,true); ?></div>
                <div class="black-btn2">
                  <!--<span>
                    <span><a href="#">Preview</a></span>
                  </span>-->
                </div>
              </div>
              <div class="cl"></div>
            </div>
            <?php } ?>
          </div>
          <div class="genre-col">
            <h3><?=ucfirst(stripslashes(Get_Single_Field("sound_type_master","Sound_Type_Name","Sound_Type_Id","2")));?></h3>
           <?php
			$sql_sound_type2 = "SELECT * FROM product_master WHERE Sound=2";
			$result_sound_type2 = mysql_query($sql_sound_type2);
			while($colles_sound_type2 = mysql_fetch_array($result_sound_type2))
			{
			?>
            <div class="genre-block">
              <div class="genre-img">
                <a href="javascript:void(0);" style="cursor:text;">
                 <?php if(file_exists("products/product_image/$colles_sound_type2[Image_Name]") && $colles_sound_type2['Image_Name']!='') { ?>
                <img src="products/product_image/<?php echo $colles_sound_type2['Image_Name']; ?>" border="0"  alt="<?=stripslashes($colles_sound_type2['Title'])?>"/>
                <?php } else { ?>
                <img src="images/no-image.gif" border="0"  alt="<?=stripslashes($colles_sound_type2['Title'])?>"/>
                <?php } ?> 
                </a>
                <div class="add-btn"><a href="buy-unreleased-music-to-cart.php?id=<?=$colles_sound_type2['Product_Id']?>">Fav</a></div>
              </div>
              <div class="genre-info">
                <ul>
                  <li><?=stripslashes(ucfirst(Get_Single_Field("member_account_master","First_Name","Member_Account_Id","$colles_sound_type2[Member_Account_Id]")).' '.ucfirst(Get_Single_Field("member_account_master","Last_Name","Member_Account_Id","$colles_sound_type2[Member_Account_Id]")))?></li>
                  <li><?=stripslashes($colles_sound_type2['Title'])?></li>
                  <li>Price: $<?=trim($colles_sound_type2['Price'])?></li>
                </ul>
                <div><? echo pullRating($colles_sound_type2['Product_Id'],false,true,true); ?></div>
                <div class="black-btn2">
                  <!--<span>
                    <span><a href="#">Preview</a></span>
                  </span>-->
                </div>
              </div>
              <div class="cl"></div>
            </div>
            <?php } ?>
            
          </div>
          <div class="genre-col">
            <h3><?=ucfirst(stripslashes(Get_Single_Field("sound_type_master","Sound_Type_Name","Sound_Type_Id","3")));?></h3>
            <?php
			$sql_sound_type3 = "SELECT * FROM product_master WHERE Sound=3";
			$result_sound_type3 = mysql_query($sql_sound_type3);
			while($colles_sound_type3 = mysql_fetch_array($result_sound_type3))
			{
			?>
            <div class="genre-block">
              <div class="genre-img">
                <a href="javascript:void(0);" style="cursor:text;">
                 <?php if(file_exists("products/product_image/$colles_sound_type3[Image_Name]") && $colles_sound_type3['Image_Name']!='') { ?>
                <img src="products/product_image/<?php echo $colles_sound_type3['Image_Name']; ?>" border="0"  alt="<?=stripslashes($colles_sound_type3['Title'])?>"/>
                <?php } else { ?>
                <img src="images/no-image.gif" border="0"  alt="<?=stripslashes($colles_sound_type3['Title'])?>"/>
                <?php } ?> 
                </a>
                <div class="add-btn"><a href="buy-unreleased-music-to-cart.php?id=<?=$colles_sound_type3['Product_Id']?>">Fav</a></div>
              </div>
              <div class="genre-info">
                <ul>
                  <li><?=stripslashes(ucfirst(Get_Single_Field("member_account_master","First_Name","Member_Account_Id","$colles_sound_type3[Member_Account_Id]")).' '.ucfirst(Get_Single_Field("member_account_master","Last_Name","Member_Account_Id","$colles_sound_type3[Member_Account_Id]")))?></li>
                  <li><?=stripslashes($colles_sound_type3['Title'])?></li>
                  <li>Price: $<?=trim($colles_sound_type3['Price'])?></li>
                </ul>
                <div><? echo pullRating($colles_sound_type3['Product_Id'],false,true,true); ?></div>
                <div class="black-btn2">
                  <!--<span>
                    <span><a href="#">Preview</a></span>
                  </span>-->
                </div>
              </div>
              <div class="cl"></div>
            </div>
            <?php } ?>
            
            
          </div>
          <div class="cl"></div>
        </div>
        <div class="genre-cat">
          <ul>
            <li class="first"><a href="#">Hiphop</a></li>
            <li class="second"><a href="#">Rnb</a></li>
            <li class="third"><a href="#">Pop</a></li>
            <li class="forth"><a href="#">Create a genre</a></li>
          </ul>
        </div>
        <div class="cl"></div>
        <div class="cor_1set-3"></div>
        <div class="cor_1set-4"></div>
      </div>
      <div class="content-box-2 m-top">
        <div class="cor_1set-5"></div>
        <div class="cor_1set-6"></div>
        <div class="link-list">
          <h4>More in Music</h4>
          <ul>
            <li><a href="#">Music Home</a></li>
            <li><a href="#">My Playlist</a></li>
            <li><a href="#">Music Video</a></li>
          </ul>
        </div>
        <div class="link-list">
          <h4>More in Curators</h4>
          <ul>
            <li><a href="#">Indle Rock with Noah</a></li>
            <li><a href="#">Drawing with Nathan</a></li>
            <li><a href="#">Celebri-Shizz with Erin</a></li>
          </ul>
        </div>
        <div class="link-list">
          <h4>More in Music</h4>
          <ul>
            <li><a href="#">Bad Teacher</a></li>
            <li><a href="#">Summer Movies</a></li>
            <li><a href="#">Crystal Harris</a></li>
          </ul>
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
