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

$start=0;
if(isset($_GET['start'])) $start=$_GET['start'];
$pagesize=18;
if($_GET['order_by']=='') { $order_by="Product_Id"; } else { $order_by=$_REQUEST['order_by'];}
if($_GET['order_by2']=='') { $order_by2="DESC"; } else { $order_by2=$_REQUEST['order_by2'];}


$column_sound_type1 = "SELECT * ";
$sql_sound_type1 = " FROM product_master  WHERE Status=1  AND Type=5 AND New_Music_Releases!=1";


$sql1_sound_type1 = "SELECT count(*) as total ".$sql_sound_type1;
$sql_sound_type1 = $column_sound_type1.$sql_sound_type1;
$sql_sound_type1 .= " order by $order_by $order_by2 ";
$sql_sound_type1 .= " limit $start, $pagesize";
#echo $sql_sound_type1;
$result_sound_type1 = executequery($sql_sound_type1);
$reccnt_sound_type1 = getSingleResult($sql1_sound_type1);



?>
<link href="css/rating_style.css" rel="stylesheet" type="text/css" media="all">
<link href="styles.css" rel="stylesheet" type="text/css" media="all">
<script type="text/javascript" src="js/rating_update.js"></script>

<div id="page-wrapper">
  <div class="layoutArea">
    <div class="contentArea">
    <div class="content-box-2">
        <div class="cor_1set-5"></div>
        <div class="cor_1set-6"></div>
        
        <div class="dark-gray_wrap">
          <h3>Top Artists Latest Singles</h3>
          
          <div class="fl">
          <?php
		    $new_cn =0;
			$sql_sound_type = "SELECT * FROM product_master WHERE Status=1 AND Type=5 AND New_Music_Releases=1 ORDER BY rand() LIMIT 0,4";
			$result_sound_type = mysql_query($sql_sound_type);
			while($colles_sound_type = mysql_fetch_array($result_sound_type))
			{
			
			$todaydate = date("Y-m-d H:i:s");
			$ago = strtotime($todaydate) - strtotime($colles_sound_type['Product_Date']);
			
			  if ($ago >= 86400) { 
			
				$diff = floor($ago/86400).' days ago'; 
			
			  } elseif ($ago >= 3600) { 
			
				$diff = floor($ago/3600).' hours ago'; 
			
			  } elseif ($ago >= 60) { 
			
				$diff = floor($ago/60).' minutes ago'; 
			
			  } else { 
			
				$diff = $ago.' seconds ago'; 
			
			  }
			 			
			?>
            <div class="new-albm">
              <a href="#"> <?php if(file_exists("products/product_image/$colles_sound_type[Image_Name]") && $colles_sound_type['Image_Name']!='') { ?>
                <img src="products/product_image/<?php echo $colles_sound_type['Image_Name']; ?>" border="0" width="128px;" height="128px;"  alt="<?=stripslashes($colles_sound_type['Title'])?>"/>
                <?php } else { ?>
                <img src="images/no-image.png" border="0" width="128px;" height="128px" alt="<?=stripslashes($colles_sound_type['Title'])?>"/>
                <?php } ?> </a>
              <ul class="albm-detail">
                <li><?=substr(stripslashes($colles_sound_type['Short_Desc']),0,15)?></li>
                <li><?=$diff?></li>
                <li class="title"><?=stripslashes($colles_sound_type['Title'])?></li>
                <li>Release: $<?=trim($colles_sound_type['Price'])?></li>
              </ul>
               
             
              <div class="black-btn">
              <span><span>
              <a href="preview-player.php?id=<?=$colles_sound_type['Product_Id']?>" title="<?=stripslashes($colles_sound_type['Title'])?>" rel="gb_page_center[640, 360]" class="global-box">Preview</a></span></span>
              </div>
              
              
              
              
              <?php if($_SESSION['SESS_ACCOUNT_TYPE']!='Contest Judge') { ?>
              <?php if($_SESSION['SESS_ID']==$colles_sound_type['Member_Account_Id']) { ?>
              <div class="gray-btn-2">
                <a href="artist-music-store.php?id=<?=$colles_sound_type['Product_Id']?>">Edit Me</a>
              </div>
              <?php } else { ?>
              <div class="gray-btn-2">
                <a href="buy-music-store-to-cart.php?id=<?=$colles_sound_type['Product_Id']?>">Download Now</a>
              </div>
              <?php } } ?>
            </div>
            
            <?php
			$new_cn++;
			}
			?>
            <div class="cl" ></div>
          </div>
          <div class="fr">
          <div class="adBox">
          <img src="images/adblk.png" alt="" />
          <p>Advertisement</p>
          </div>
          </div>
          <div class="cl"></div>
        </div>
        <div class="genre-wrap">
        
          <div class="genre-col">
            <h3>Latest Music Store Releases</h3>
             <div class="newReleaseTxt">
     Instrumentals in this section has not been enter into any of Mussino sessions. These are new releases from Musician around the world. Once you purchase a non-exclusive beat you are instantly able to print and download a written licensing agreement for your beat which will license you to use the beat for your demo, mix tape, album etc. Be sure to see terms and conditions if you are interested in more details or sent an e-mail to customer service if you have any questions beyond the list terms.
            </div>
            <br />
            
            <?php if($reccnt_sound_type1>0) { include "releases-hiphop-paging.inc.php"; } ?>
            <?php
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
                <div class="rating-wrap"><? echo pullRating($colles_sound_type1['Product_Id'],false,true,true); ?></div>
                
               
              </div>
              <div class="black-btn">
              <span><span>
              <a href="preview-player.php?id=<?=$colles_sound_type1['Product_Id']?>" title="<?=stripslashes($colles_sound_type1['Title'])?>" rel="gb_page_center[640, 360]" class="global-box">Preview</a></span></span>
              </div>
              <?php if($_SESSION['SESS_ACCOUNT_TYPE']!='Contest Judge') { ?>
              <?php if($_SESSION['SESS_ID']==$colles_sound_type1['Member_Account_Id']) { ?>
              <div class="gray-btn-2">
                <a href="artist-music-store.php?id=<?=$colles_sound_type1['Product_Id']?>">Edit Me</a>
              </div>
              <?php } else { ?>
              
              
              
              <div class="gray-btn-2">
                <a href="buy-music-store-to-cart.php?id=<?=$colles_sound_type1['Product_Id']?>">Download Now</a>
              </div>
              <?php } } ?>
              <div class="cl"></div>
            </div>
            <?php } ?>
          </div>
          <div class="cl"></div>
         
        </div>
        <div class="genre-cat">
        <div class="catTitle">Categories</div>
          <ul>
          	<?php
			$cu=1;
			$j=1;
			$sql_cat = "SELECT * FROM category_master WHERE Status=1 AND Parent_Id=0";
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
			$j++;
			}
			?>
           
          </ul>
        </div>
        <div class="cl"></div>
        <div class="cor_1set-3"></div>
        <div class="cor_1set-4"></div>
      </div>
      <!--<div class="content-box-2 m-top">
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
      </div>-->
      
    </div>
  </div>
</div>
