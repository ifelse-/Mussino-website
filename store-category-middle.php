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
        <div  id="view_songs" style="padding:2px 0 5px 400px; height:50px;"></div>
        
        <div class="genre-wrap full">
          <div class="genre-col">
            <h3><?=ucfirst(stripslashes(Get_Single_Field("category_master","Category_Name","Category_Id","$_REQUEST[id]")));?> Music Releases</h3>
            <?php
			$sql_sound_type1 = "SELECT * FROM product_master WHERE Category_Id='".$_REQUEST['id']."' AND Type=5";
			$result_sound_type1 = mysql_query($sql_sound_type1);
			if(mysql_num_rows($result_sound_type1)>0)
			{
			while($colles_sound_type1 = mysql_fetch_array($result_sound_type1))
			{
			?>
            <div class="genre-block">
              <div class="genre-img">
                <a href="<?=SITE_WS_PATH?>/<?=trim($colles_sound_type1['Member_Account_Id'])?>/<?=ucfirst(stripslashes(Get_Single_Field("member_account_master","First_Name","Member_Account_Id","$colles_sound_type1[Member_Account_Id]")))?>" >
                 <?php if(file_exists("products/product_image/$colles_sound_type1[Image_Name]") && $colles_sound_type1['Image_Name']!='') { ?>
                <img src="products/product_image/<?php echo $colles_sound_type1['Image_Name']; ?>" border="0"  alt="<?=stripslashes($colles_sound_type1['Title'])?>"/>
                <?php } else { ?>
                <img src="images/no-image.gif" border="0"  alt="<?=stripslashes($colles_sound_type1['Title'])?>"/>
                <?php } ?> 
                </a>
                <?php if($_SESSION['SESS_EMAIL']=='') { ?>
                <div class="add-btn"><a href="login.php">Fav</a></div>
                <?php } else { ?>
                <div class="add-btn"><a href="add-favorite.php?fav_id=<?=$colles_sound_type1['Member_Account_Id']?>">Fav</a></div>
                <?php } ?>
              </div>
              <div class="genre-info">
                <ul>
                  <li><?=stripslashes(ucfirst(Get_Single_Field("member_account_master","First_Name","Member_Account_Id","$colles_sound_type1[Member_Account_Id]")).' '.ucfirst(Get_Single_Field("member_account_master","Last_Name","Member_Account_Id","$colles_sound_type1[Member_Account_Id]")))?></li>
                  <li><?=stripslashes($colles_sound_type1['Title'])?></li>
                  <li>Release: $<?=trim($colles_sound_type1['Price'])?></li>
                </ul>
                <div><? echo pullRating($colles_sound_type1['Product_Id'],false,true,true); ?></div>
                <div class="black-btn">
              <span><span>
              <a href="preview-player.php?id=<?=$colles_sound_type1['Product_Id']?>" title="<?=stripslashes($colles_sound_type1['Title'])?>" rel="gb_page_center[640, 360]" class="global-box">Preview</a></span></span>
              </div>
              </div>
              <?php if($_SESSION['SESS_EMAIL']=='') { ?>
              <div class="gray-btn-2">
                <a href="login.php">Download Now</a>
              </div>
              <?php } else { ?>
              <?php if($_SESSION['SESS_ACCOUNT_TYPE']!='Contest Judge') { ?>
              <?php if($_SESSION['SESS_ID']==$colles_sound_type1['Member_Account_Id']) { ?>
              <div class="gray-btn-2">
                <a href="artist-music-store.php?id=<?=$colles_sound_type1['Product_Id']?>">Edit Me</a>
              </div>
              <?php } else { ?>
              <div class="gray-btn-2">
                <a href="buy-music-store-to-cart.php?id=<?=$colles_sound_type1['Product_Id']?>">Download Now</a>
              </div>
              <?php } } }?>
              <div class="cl"></div>
            </div>
            <?php } } else { echo'<div class="genre-block">No Record</div>'; }?>
            <div class="cl"></div>
          </div>
          
          
          <div class="cl"></div>
        </div>
        <div class="genre-cat">
          <ul>
          	<?php
			$cu=1;
			$sql_cat = "SELECT * FROM category_master WHERE Category_Id !='".$_GET['id']."' AND Status=1 AND Parent_Id=0 ";
			$result_cat = mysql_query($sql_cat);
			while($colles_cat = mysql_fetch_array($result_cat))
			{
			if($cu==1)
			{
			$class = 'first';
			}
			elseif($cu==2)
			{
			$class = 'second';
			}
			elseif($cu==3)
			{
			$class = 'third';
			}
			elseif($cu==4)
			{
			$class = 'first';
			}
			elseif($cu==5)
			{
			$class = 'second';
			}
			elseif($cu==6)
			{
			$class = 'third';
			}
			elseif($cu==7)
			{
			$class = 'first';
			}
			elseif($cu==8)
			{
			$class = 'second';
			}
			elseif($cu==9)
			{
			$class = 'third';
			}
			elseif($cu==10)
			{
			$class = 'first';
			}
			elseif($cu==11)
			{
			$class = 'second';
			}
			elseif($cu==12)
			{
			$class = 'third';
			}
			elseif($cu==13)
			{
			$class = 'first';
			}
			elseif($cu==14)
			{
			$class = 'second';
			}
			elseif($cu==15)
			{
			$class = 'third';
			}
			?>
            <li class="<?=$class?>"><a href="store-category.php?id=<?=$colles_cat['Category_Id']?>"><?=ucfirst($colles_cat['Category_Name'])?></a></li>
            <?php
			$cu++;
			}
			?>
           
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
      
    </div>
  </div>
</div>
