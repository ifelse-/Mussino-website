<div class="header-container">
  <div class="logo-area">
    <div class="logo fl">
  <a href="http://www.mussino.com"><img src="http://www.mussino.com/images/logo_lg_light.png" width="150" /></a>
    </div>
    <div class="search-wrapper fr">
      <div class="search fl">
        <form id="search_mini_form" action="<?=SITE_WS_PATH?>/search.php" method="get">
         <!-- <span class="search-caption"><strong>Search for Musician, Artist, and Unreleased instrumentals</strong></span>-->
          <div class="search-row">
            <div class="fl">
              <input type="text" name="q" value="SEARCH MUSIC" onfocus="if(this.value=='SEARCH MUSIC') { this.value='';}" onblur="if(this.value==''){ this.value='SEARCH MUSIC' }"/>
            </div>
            <div class="fr">
              <?php /*?><select name="pid">
                <option value="">All Files</option>
                <?php
				$sql_all_files = "SELECT * FROM product_master WHERE Status='1' AND Type !='3' AND now() between Session_Start_Date AND Session_End_Date ORDER BY Title";
				$result_all_files = mysql_query($sql_all_files);
				while($colles_all_files = mysql_fetch_array($result_all_files))
				{
				?>
                <option value="<?=$colles_all_files['Product_Id']?>" <?php if($colles_all_files['Product_Id']==$_REQUEST['pid']) { echo'selected';}?>>
                <?=stripslashes($colles_all_files['Title'])?>
                </option>
                <?php
				}
				?>
              </select><?php */?>
            </div>
            <div class="cl"></div>
          </div>
          <!--<div class="search-btn">
            <input type="image" name="search" src="<?=SITE_WS_PATH?>/images/spacer.gif" />
            <p>SEARCH</p>
          </div>-->
          <div class="cl"></div>
        </form>
      </div>
      <div class="login-area">
        <div class="lang-col">
         <!--<div style="position:absolute; right:200px; top:3px;">
            <div id="google_translate_element"></div><script>
			function googleTranslateElementInit() {
			  new google.translate.TranslateElement({
				pageLanguage: 'en',
				includedLanguages: 'ar,zh-CN,nl,fr,de,it,ja,pt,ru,es',
				layout: google.translate.TranslateElement.InlineLayout.SIMPLE
			  }, 'google_translate_element');
			}
</script><script src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
		</div>-->
        </div>
        <?php if($_SESSION['SESS_EMAIL']=='') { ?>
        
        <ul class="small-link">
          <li><a href="<?=SITE_WS_MPATH?>/login.php">Log in</a> &nbsp;</li>
          <li><a href="<?=SITE_WS_MPATH?>/registration.php">Join us</a></li>
        </ul>
        <?php } else { ?>
        <ul class="small-link">
           <li><a href="<?=SITE_WS_MPATH?>/logout.php">Log out</a></li>

        </ul>
        <?php } ?>
      </div>
      <div class="cl"></div>
    </div>
    <div class="cl"></div>
  </div>
  
   <?php if($_SESSION['SESS_EMAIL']=='') { ?>
   
  <div class="top-nav">
    <div class="top-nav-wrapper">
    <ul>
      <li <?php if($pageName=='index.php') { ?>class="selected" <?php } ?>><a href="<?=SITE_WS_MPATH?>/index.php">Home</a></li>
      <li <?php if($pageName=='session.php') { ?>class="selected" <?php } ?>><a href="<?=SITE_WS_MPATH?>/login.php">New Sessions</a>
              
       </li>
        <?php
		$sql_footer = "SELECT * FROM content_master WHERE Status=1 AND Id != 5 AND  Id != 7 AND  Id != 13 AND  Id != 14 ORDER BY display_order ASC";
		$result_footer = mysql_query($sql_footer) or die('<br>'.$sql_footer.'<br>');
		while($colles_footer = mysql_fetch_array($result_footer )) { 
		?>
      <li <?php if($colles_footer['Id']==$_REQUEST['id']  && $pageName!='registration.php' && $pageName!='registration.php' && $pageName!='registration.php' && $pageName!='registration.php'  && $pageName!='registration.php') { ?>class="selected" <?php } ?>><a href="<?=SITE_WS_MPATH?>/main-page.php?id=<?=$colles_footer['Id']?>" title="Site Map"><?=stripslashes($colles_footer['Con_Title'])?></a></li> 
      <?php } ?>
      
 <li <?php if($pageName=='registration.php') { ?>class="selected" <?php } ?>><a href="<?=SITE_WS_MPATH?>/registration.php">Join Us</a></li>  
      <li <?php if($pageName=='unreleased-music.php') { ?>class="selected" <?php } ?>><a href="<?=SITE_WS_MPATH?>/login.php">Instrumental Store</a></li>
   <?php /*?>   <li <?php if($pageName=='store.php') { ?>class="selected" <?php } ?>><a href="<?=SITE_WS_MPATH?>/registration.php">Music Store</a></li><?php */?>
      
    </ul>
    <div class="cl"></div>
  </div>
 </div> 
  
  
  <?php } else { ?>
  
  <div class="top-nav">
    <ul>
      <li <?php if($pageName=='index.php') { ?>class="selected" <?php } ?>><a href="<?=SITE_WS_MPATH?>/index.php">Home</a></li>
      <li <?php if($pageName=='session.php') { ?>class="selected" <?php } ?>><a href="<?=SITE_WS_MPATH?>/session.php">New Sessions</a>
              
       <div class="sub-nav">
       <ul>
      <?php
		$sql_cat = "SELECT * FROM category_master WHERE Status=1";
		$result_cat = mysql_query($sql_cat);
		while($colles_cat = mysql_fetch_array($result_cat))
		{
		?>
		<li <?php if($colles_cat['Category_Id']==$_REQUEST['id'] && $pageName!='contest-juge-history.php' && $pageName!='create-session.php' && $pageName!='history.php' && $pageName!='main-page.php' && $pageName!='category.php') { ?>class="selected" <?php } ?>><a href="<?=SITE_WS_MPATH?>/session.php?id=<?=$colles_cat['Category_Id']?>"><?=ucfirst($colles_cat['Category_Name'])?></a></li>
		<?php
		}
		?>
        </ul>
        </div></li>
        <?php
		$sql_footer = "SELECT * FROM content_master WHERE Status=1 AND Id != 5 AND  Id != 7 AND  Id != 13 AND  Id != 14 ORDER BY display_order ASC";
		$result_footer = mysql_query($sql_footer) or die('<br>'.$sql_footer.'<br>');
		while($colles_footer = mysql_fetch_array($result_footer )) { 
		?>
      <li <?php if($colles_footer['Id']==$_REQUEST['id']  && $pageName!='session.php' && $pageName!='contest-juge-history.php' && $pageName!='create-session.php' && $pageName!='history.php'  && $pageName!='category.php') { ?>class="selected" <?php } ?>><a href="<?=SITE_WS_MPATH?>/main-page.php?id=<?=$colles_footer['Id']?>" title="Site Map"><?=stripslashes($colles_footer['Con_Title'])?></a></li> 
      <?php } ?>
      
      <li <?php if($pageName=='registration.php') { ?>class="selected" <?php } ?>><a href="<?=SITE_WS_MPATH?>/registration.php">Join Us</a></li>  
      <li <?php if($pageName=='unreleased-music.php') { ?>class="selected" <?php } ?>><a href="<?=SITE_WS_MPATH?>/unreleased-music.php">Instrumental Store</a></li>
    <?php /*?>  <li <?php if($pageName=='store.php') { ?>class="selected" <?php } ?>><a href="<?=SITE_WS_MPATH?>/store.php">Music Store</a></li><?php */?>
      
    </ul>
    <div class="cl"></div>
  </div>
  
  <?php } ?>
</div>
