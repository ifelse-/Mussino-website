<div id="ja-botsl2" class="wrap">
  <div class="main clearfix">
  
    <div class="ja-box-center" style="width: 25%;">
      <div class="box green">
        <div class="inner">
          <div class="head">
            <h4><span class="first-word"><span>Resource</span></span> Link</h4>
          </div>
          <div class="content">
            <ul class="menu">
              <li> <a href="index.php">Home</a> </li>
				<?php
                $sql_source = "SELECT Source_Id, Source_Name, Source_Link FROM source_link_master WHERE Status='1' ORDER BY Source_Name DESC  LIMIT 0,5";
                $result_source = mysql_query($sql_source);
                while($colles_source = mysql_fetch_array($result_source))
                {
                ?>
                <li> <a href="<?=$colles_source['Source_Link']?>"><?=stripslashes($colles_source['Source_Name'])?></a> </li>
                <?php
                }
                ?>
            </ul>
          </div>
        </div>
      </div>
    </div>
    
    <div class="ja-box-left" style="width: 25%;">
      <div class="box orange">
        <div class="inner">
          <div class="head">
            <h4><span class="first-word"><span>Lastest</span></span> Musician</h4>
          </div>
          <div class="content">
            <ul>
            <?php
			$sql_news_latest = "SELECT News_Id,	Title, Type, DATE_FORMAT(Date,'%b %d, %Y') as fDate FROM news_master WHERE Type='Latest Musician' AND Status='1' ORDER BY News_Id DESC  LIMIT 0,4";
			$result_news_latest = mysql_query($sql_news_latest);
			while($colles_news_latest = mysql_fetch_array($result_news_latest))
			{
			?>
              <li>
                <h4><a href="news-deatil.php?id=<?=$colles_news_latest['News_Id'];?>"><?=$colles_news_latest['Title'];?> </a></h4>
                <small><?=$colles_news_latest['fDate'];?></small> </li>
             <?php } ?>
            </ul>
          </div>
        </div>
      </div>
    </div>
    
    <div class="ja-box-center" style="width: 25%;">
      <div class="box blue">
        <div class="inner">
          <div class="head">
            <h4><span class="first-word"><span>Latest</span></span> Artist</h4>
          </div>
          <div class="content">
            <ul>
              <?php
			$sql_news_popular = "SELECT News_Id, Title, Type, DATE_FORMAT(Date,'%b %d, %Y') as fDate FROM news_master WHERE Type='Latest Artist' AND Status='1' ORDER BY News_Id DESC  LIMIT 0,4";
			$result_news_popular = mysql_query($sql_news_popular);
			while($colles_news_popular = mysql_fetch_array($result_news_popular))
			{
			?>
              <li>
                <h4><a href="news-deatil.php?id=<?=$colles_news_popular['News_Id'];?>"><?=$colles_news_popular['Title'];?> </a></h4>
                <small><?=$colles_news_popular['fDate'];?></small> </li>
             <?php } ?>
            </ul>
          </div>
        </div>
      </div>
    </div>
    
    
    
    <div class="ja-box-right" style="width: 25%;">
      <div class="box">
        <div class="inner">
          <div class="head">
            <h4><span class="first-word"><span>Support</span></span> Center</h4>
          </div>
          <div class="content">
            <?=stripslashes(Get_Single_Field("support_master","Support_Desc","Support_Id","1"));?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>