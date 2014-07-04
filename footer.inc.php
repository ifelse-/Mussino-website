<div class="clear"></div>
<div class="footer-container">
    <div class="footer-wrapper">
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
      
      <p>Mussino &copy; <?php echo date("Y") ?> All Rights Reserved </p>
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
