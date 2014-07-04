<?php 
$sql = "SELECT * FROM member_account_master WHERE Member_Account_Id='".$_SESSION['SESS_ID']."'";
$result = mysql_query($sql);
$colles = mysql_fetch_array($result);
?>

<div class="content-box-2">
      <div class="cor_1set-5"></div>
      <div class="cor_1set-6"></div>
      <div class="pro-wrapper full">
        <div class="title">
          <div class="title_wrap-1">
            <div class="title_wrap-2">
              <div class="blue-btn-1"> <span><span><a href="<?=SITE_WS_PATH?>/<?=trim($_SESSION['SESS_ID'])?>/<?=$_SESSION['SESS_FIRST_NAME']?>" >My Profile</a></span></span> </div>
              &raquo; History Lyrics
            </div>
          </div>
        </div>
        <div class="pro-content">
        <!--<form id="frmEditRegistration" name="frmEditRegistration"  method="post" action="">-->
          <div class="pro-left fl">
            <div class="user-img">
            <a href="<?=SITE_WS_PATH?>/<?=trim($_SESSION['SESS_ID'])?>/<?=$_SESSION['SESS_FIRST_NAME']?>" >
			<?php if(file_exists("products/user_image/$colles[Photo]") && $colles['Photo']!='') { ?>
              <img src="products/user_image/<?php echo $colles['Photo']; ?>" border="0" width="100" height="150" />
               <?php } else { ?>
              <img src="images/user_big.png" border="0" width="100" height="150" />
            <?php } ?>
            </a>
            <p><?=$colles['Account_Type']?></p>
            </div>
            <div class="pro-btn_row">
               <?php include "left-profile.inc.php"; ?>  
               
            </div>
          </div>
          <div class="pro-right">
             <div class="form-container">
              <div class="rgtPannel2 fr">
         
           <div class=" history">
          <h2>HISTORY POSTS :
            <?=mysql_num_rows($colles_history_result)?>  <span style="background-color: #5C9EF5; border-radius:10px; width:55px; padding:6px;  text-align: center; height:14px; float:right;"><a href="print-all-history.php" target="_blank" style="font-size:9px; font-weight:bold; color:#FFF;">Print All</a></span>
          </h2>
          
          <div class="scroller" style="margin-top:10px;">
			<?php
            $ct=1;
            $k=0;
            while($colles_history_post = mysql_fetch_array($colles_history_result)) {
            $m_name = Get_Single_Field("member_account_master","First_Name","Member_Account_Id","$colles_history_post[Member_Account_Id]");
            $bgcolor = ($k%2==0? '#FFDD92;': '#fffff0;');
			
			//$player_id = Get_Single_Field("lyrics_post_audio_master","Lyrics_Post_Audio_Id","Product_Id","$colles_history_post[Product_Id]");
			$player_id = $colles_history_post['Product_Id'];
            ?>
                    
              <div class="postBlock" style=" padding:5px 5px 10px 5px;background:<?=$bgcolor?>" >
              <h3><?=stripslashes(Get_Single_Field("product_master","Title","Product_Id","$colles_history_post[Product_Id]"))?> 
              
             
              <span style="background-color: #5C9EF5; border-radius:10px; width:55px; padding:6px;  text-align: center; height:14px; float:right;">
              <a href="message.php?id=<?=md5($colles_history_post['Lyrics_Post_Id'])?>" style="font-size:9px; font-weight:bold; color:#FFF;">Compose</a>
              </span>
              
              <span style="background-color: #5C9EF5; border-radius:10px; width:35px; padding:6px;  text-align: center; height:14px; float:right; margin-right:15px;">
              <a href="print-history.php?id=<?=md5($colles_history_post['Lyrics_Post_Id'])?>" target="_blank" style="font-size:9px; font-weight:bold; color:#FFF;">Print</a>
              </span>
              
              <span style="background-color: #5C9EF5; border-radius:10px; width:75px; padding:6px;  text-align: center; height:14px; float:right; margin-right:15px;">
              <a href="frm-sell-session.php?id=<?=$colles_history_post['Lyrics_Post_Id']?>" title="" style="font-size:9px; font-weight:bold; color:#FFF;" rel="gb_page_center[640, 360]" class="global-box">Sell Session</a>
              
              </span>
              
              </h3>
              <p>
               <?=stripslashes($colles_history_post['Lyrics']);?>
              </p>
              
			  
              
              <strong>
              <?=ucfirst($m_name)?>
              </strong> 
              <span>
              <?=$colles_history_post['historyDate'];?>
              </span>
              <?php if($player_id!='') { ?>
              <span style="background-color:#696969; border-radius:10px; width:85px; padding:0 6px 5px 6px;  text-align: center;">
              <a href="preview-history-player.php?id=<?=$player_id?>" title="<?=stripslashes($colles_history_post['Title'])?>" style="font-size:9px; font-weight:bold; color:#FFF;" rel="gb_page_center[640, 360]" class="global-box">Preview</a></span>
              <?php } ?>
              
            </div>
            <div style="padding:5px 0 0 0;"></div>
            
            <?php
			$ct++;
			$k++;
			}
			?>
          </div>
        </div> 
        <?php if(mysql_num_rows($colles_history_result)>0) { ?>
         <div><?php include "paging-in.inc.php";  ?></div> 
         <?php } ?>
        </div>
            
          </div>
          </div>
          <div class="cl"></div>
     <!--   </form>-->
        </div>
      </div>
      <div class="cor_1set-3"></div>
      <div class="cor_1set-4"></div>
    </div>
