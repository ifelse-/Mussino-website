
<link href="css/rating_style.css" rel="stylesheet" type="text/css" media="all">
	<script type="text/javascript" src="js/rating_update.js"></script>	
<div class="content-box-2">
  <div class="cor_1set-5"></div>
  <div class="cor_1set-6"></div>
   <div class="pro-wrapper fl" style="width:965px;">
          <div class="title">
            <div class="title_wrap-1">
              <div class="title_wrap-2">
                <div class="blue-btn-1">
                  <span><span><?=ucwords($Content_Array[0])?></span></span>
                </div>
              </div>
            </div>
          </div>
          <div class="pro-content"><?=$Content_Array[1]?></div>
        </div>
        <!--<div class="right-col fr">
          <div class="right-col_wrapper">
            <div class="title">
              <div class="gray-btn-1">
                <span><span>Popular</span></span>
              </div>
              Tags
            </div>
            <div class="content">
              <?php
				$sqlCloud = "SELECT * FROM tags ORDER BY tag_name";
				$resultCloud = mysql_query($sqlCloud);
				
				if(mysql_num_rows($resultCloud)>0)
				{
				?>
                <ul class="tags-list">
					<style type="text/css">
					.tag_cloud {padding: 5px; text-decoration: none; font-family: verdana; }
					.tag_cloud:link { color: #9FCCF5; }
					.tag_cloud:visited { color: #9FCCF5; }
					.tag_cloud:hover { color: #fff; background: #1E3E64; }
					.tag_cloud:active { color: #9FCCF5; background: #1E3E64; }
					</style>
					<?php 
					
					function tag_info() {
					$resultCloudes = mysql_query("SELECT COUNT(*) as tagcount, tag_name FROM tags GROUP BY tag_name ORDER BY RAND(),tagcount DESC LIMIT 0,150");
					while($rowCloudes = mysql_fetch_array($resultCloudes)) {
					
					$arr[$rowCloudes['tag_name']] = $rowCloudes['tagcount'];
					}
					ksort($arr);
					return $arr;
					}
					
					function tag_cloud() {
					$min_size = 10;
					$max_size = 20;
					
					$tags = tag_info();
					
					$minimum_count = min(array_values($tags));
					$maximum_count = max(array_values($tags));
					
					$spread = $maximum_count - $minimum_count;
					
					if($spread == 0) {
					$spread = 1;
					}
					
					$cloud_html = '';
					$cloud_tags = array();
					
					foreach ($tags as $tag => $count) {
					$size = $min_size + ($count - $minimum_count)
					* ($max_size - $min_size) / $spread;
					
					$cloud_tags[] = '<li><a style="font-size: '. floor($size) . 'px'
					. '" class="tag_cloud" href="http://www.mussino.com/search.php?q=' . str_replace('%20','',$tag)
					. '" title="\'' . str_replace('%20','',$tag) . '\' returned a count of ' . $count . '">'
					. htmlspecialchars(stripslashes(str_replace('%20','',$tag))) . '</a></li>';
				   
					}
					$cloud_html = join("\n", $cloud_tags) . "\n";
					return $cloud_html;
					
					}
					
					?>
					<div>
					<?php 
					if(mysql_num_rows($resultCloud)>0)
					{
					echo tag_cloud(); 
					}
					?>
					</div>
				</ul>
				<?php } ?>
                <div class="actions"> <a href="tagclouds.php">View All Tags</a> </div>
            </div>
          </div>
          <div class="right-col_wrapper">
            <div class="title">
              <div class="gray-btn-1">
                <span><span>Invite Friends</span></span>
              </div>
            </div>
            <div class="content">
              <a id="variousTellaFriend" href="#requestTellaFriend">To invite friends click here</a>
              <div style="display: none;">
                            <div id="requestTellaFriend" style="width:450px;height:350px;">
                                <div style="padding: 5px 0 0 100px;">
                                <form id="frmTellaFriend" name="frmTellaFriend"  method="post" action="">
                                <ul>
                                    
                                    
                                    <li>
                                        <ul class="login">
                                            <li><h1>Invite Your Friends</h1></li>
                                            <li></li>
                                        </ul>
                                    </li>
                                    
                                    <li  id="tell_a_friend_id" style="padding: 5px 0 5px 0;"></li>
                                    
                                    <li>
                                        <ul class="login">
                                            <li>Email ID</li>
                                            <li><input type="text" name="Email" size="30" class="input-text" onkeypress="if(event.keyCode==13) {return tellaFriendRequest();}" /></li>
                                        </ul>
                                    </li>
                                    
                                    
                                    <li>
                                        <ul class="login">
                                            <li>Message</li>
                                            <li><textarea name="Message" cols="40" rows="6" onkeypress="if(event.keyCode==13) {return tellaFriendRequest();}"></textarea></li>
                                        </ul>
                                    </li>
                                    
                                    
                                   
                                    
                                    
                                    <li>
                                        <ul class="login">
                                            <li>&nbsp;</li>
                                            <li><input class="button" name="buttonSubmit" type="button" value="Submit" onclick="return tellaFriendRequest();" onkeypress="if(event.keyCode==13) {return tellaFriendRequest();}"></li>
                                        </ul>
                                    </li>
                                </ul>
                            </form>
                                </div>
                            </div>
                       </div>
            </div>
          </div>
          <div class="right-col_wrapper">
            <div class="title">
              <div class="gray-btn-1">
                <span><span>Sign Up for Our Newsletter</span></span>
              </div>
            </div>
            <div class="content">
            <form action="" method="post" id="frmNewsletter" name="frmNewsletter">
            <div class="block-content">
              <div id="view_newsletter"></div>
              <div>
                <strong>Name</strong> <input name="Name" id="newsletter" title="Sign up for our newsletter"  type="text" class="input-text" onkeypress="if(event.keyCode==13) {return ajaxNewsLetter();}">
              </div>
              <div style="margin-top:5px;">
                <strong>Email</strong>&nbsp;<input name="Email" id="newsletter" title="Sign up for our newsletter"  type="text" class="input-text" onkeypress="if(event.keyCode==13) {return ajaxNewsLetter();}">
              </div>
              <div class="actions">
                <input type="button" name="submit" value="Subscribe" class="button" onclick="return ajaxNewsLetter();" onkeypress="if(event.keyCode==13) {return ajaxNewsLetter();}">
              </div>
            </div>
          </form>
            </div>
          </div>
          <?php if($_SESSION['SESS_ID']!='') { ?>
          <div class="right-col_wrapper">
            <div class="title">
              <div class="gray-btn-1">
                <span><span>Royalty</span></span> 
              </div>
              Statue
            </div>
            <div class="content">
              <?php
		  $sql_my_bank = "SELECT sum(Notes_Value) as myTotalEarning FROM my_bank WHERE To_Member_Account_Id='".$_SESSION['SESS_ID']."' AND Jack_Pot_Status='End'";
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
            <p class="empty"><strong>My Royalties $<? printf('%1.2f',$colles_my_bank['myTotalEarning']);?></strong></p>
            <?php
			}
			else
			{
			?>
             <p class="empty"><strong>$0.00</strong></p>
            <?php } ?>
            </div>
          </div>
          <?php } ?>
          
          <script type="text/javascript">
			//<![CDATA[
				function validatePollAnswerIsSelected()
				{
					var options = $$('input.poll_vote');
					for( i in options ) {
						if( options[i].checked == true ) {
							return true;
						}
					}
					return false;
				}
			//]]>
		</script>
          <div class="right-col_wrapper">
            <div class="title">
              <div class="gray-btn-1">
                <span><span>Community</span></span> 
              </div>
              Poll
            </div>
            <div class="content">
              <?php /*?><?php include"poll-view.php";?><?php */?>
            </div>
          </div>
           <div class="paypal-logo"> <a href="#" title="Additional Options" onclick="javascript:window.open('#'); return false;"><img src="images/bnr_nowAccepting_150x60.gif" alt="Additional Options"></a> </div>
        </div>-->
   <div class="cl"></div>
  <div class="cor_1set-3"></div>
  <div class="cor_1set-4"></div>
</div>
        