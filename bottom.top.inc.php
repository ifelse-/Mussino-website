<div id="slider1">
<h1 class="rfExample renderedFont">Latest Musician's</h1> 
<p>With the latest music news and artist news from Mussino, fans won't miss a beat. Be sure to check out new Musicians below, exclusive sessions, new beat instrumentals all genres.<br /> <strong>Are you Ready!!!</strong></p>

<br />
        <a class="buttons prev" href="#">left</a>
        <div class="inner-wrap">
          <div class="viewport">
        <ul class="overview">
        <?php
		  $sql_slider = "SELECT *  FROM member_account_master  WHERE Status=1 AND Account_Type='Musician' ORDER BY First_Name,Last_Name";
		  $result_slider = mysql_query($sql_slider);
		  while($colles_slider = mysql_fetch_array($result_slider)) {
		  if(file_exists("products/user_image/$colles_slider[Photo]") && $colles_slider['Photo']!='') { $fileName = "products/user_image/".$colles_slider['Photo']; } else { $fileName = "images/user_big.png"; }
		  ?>
          <li>
            <div class="product">
              <a title="<?=stripslashes($colles_slider['First_Name'].' '.$colles_slider['Last_Name'])?>" href="<?=SITE_WS_PATH?>/<?=trim($colles_slider['Member_Account_Id'])?>/<?=ucfirst(stripslashes($colles_slider['First_Name']))?>">
            <img src="<?=$fileName?>" alt="<?=stripslashes($colles_slider['Title'])?>" width="60" height="60">
            </a> 
            </div>
            <div class="pro-name">
              <a title="<?=stripslashes($colles_slider['First_Name'].' '.$colles_slider['Last_Name'])?>" href="<?=SITE_WS_PATH?>/<?=trim($colles_slider['Member_Account_Id'])?>/<?=ucfirst(stripslashes($colles_slider['First_Name']))?>"><?=stripslashes($colles_slider['First_Name'])?> </a>
            </div>
          </li>
          <?php } ?>
        </ul>
        <div class="cl"></div>
      </div>
        </div>
        <a class="buttons next" href="#">right</a>
      </div>