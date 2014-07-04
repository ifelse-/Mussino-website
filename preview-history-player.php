<?php
require_once "config/functions.inc.php";

$sql_product = "SELECT * FROM lyrics_post_audio_master WHERE  Lyrics_Post_Audio_Id ='".$_REQUEST['id']."'";
$result_product = mysql_query($sql_product);
$colles_Product = mysql_fetch_array($result_product);
if(!empty($colles_Product['Audio_Lyrics_File']))
{

list($pname,$pext) = explode('.',$colles_Product['Audio_Lyrics_File']);
$pfileName = $colles_Product['Audio_Lyrics_File'];
	if(strtolower($pext)=='mp3' || strtolower($pext)=='wma' || strtolower($pext)=='wav') 
	{
	
	$xml_paudio = simplexml_load_file('settings.xml');
	$xml_paudio->no_playlist_mp3_source['value'] = 'products/lyrics_file/'.$pfileName;
	file_put_contents('settings.xml', $xml_paudio->asXML());
	$xml_paudio = simplexml_load_file('content.xml');
	$xml_paudio->sound['source'] = 'products/lyrics_file/'.$pfileName;
	file_put_contents('content.xml', $xml_paudio->asXML());
	}
	elseif(strtolower($pext)=='avi' || strtolower($pext)=='3gp' || strtolower($pext)=='flv' || strtolower($pext)=='mkv' || strtolower($pext)=='mov' || strtolower($pext)=='mp4' || strtolower($pext)=='mpeg' || strtolower($pext)=='wmv' )
	{
	
	$xml_pvideo = simplexml_load_file('video.xml');
	$xml_pvideo->video_item->hd_video_path = 'products/lyrics_file/'.$pfileName;
	$xml_pvideo->video_item->sd_video_path = 'products/lyrics_file/'.$pfileName;
	file_put_contents('video.xml', $xml_pvideo->asXML());
	}
}
?>


          
          <?php  if(strtolower($pext)=='mp3' || strtolower($pext)=='wma' || strtolower($pext)=='wav') { ?>
          <div id="flashAlternativeContent">
          <script type="text/javascript" src="src/swfobject.js"></script>
          <script type="text/javascript">
			var flashvars = {};
			var params = {};
			var attributes = {};
			attributes.id = "oxylusflash";
			params.allowFullScreen = "true";
			params.allowScriptAccess = "always";
			params.bgColor = "#101010";
			
			// set here below the path to resolve all the relative paths in the video player if you want to store it in a different folder
			params.base = "";
			
			// specify here the path to the xml file (default is "xml/video_config.xml")
			flashvars.settingsXmlPath = "settings.xml";
			flashvars.contentXmlPath = "content.xml";
			
			// change here below the width and height of the player. It must match the width and height you have set in the xml file
			var embedWidth = "640";
			var embedHeight = "360";
			
			swfobject.embedSWF("player.swf", "flashAlternativeContent", embedWidth, embedHeight, "9.0.0", "js/expressInstall.swf", flashvars, params, attributes);
		</script>
        <!-- end of EMBED CODE -->
            <a href="http://www.adobe.com/go/getflashplayer">
				<img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" />
			</a>
          </div>
          <?php  } elseif(strtolower($pext)=='avi' || strtolower($pext)=='3gp' || strtolower($pext)=='flv' || strtolower($pext)=='mkv' || strtolower($pext)=='mov' || strtolower($pext)=='mp4' || strtolower($pext)=='mpeg' || strtolower($pext)=='wmv' ) { ?>
          <div >
          <script type="text/javascript">
AC_FL_RunContent( 'codebase','http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0','width','640','height','360','src','pro_video_player1.2.2','quality','high','bgcolor','#000000','allowscriptaccess','sameDomain','allowfullscreen','true','pluginspage','http://www.macromedia.com/go/getflashplayer','flashvars','xmlPath=video.xml','movie','pro_video_player1.2.2' ); //end AC code
</script><noscript><object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="640" height="360">
          <param name="allowScriptAccess" value="sameDomain" />
          <param name="allowFullScreen" value="true" />
          <param name="movie" value="pro_video_player1.2.2.swf" />
          <param name="quality" value="high" />
          <param name="bgcolor" value="#000000" />
          <param name="flashvars" value="xmlPath=video.xml">
          <embed src="pro_video_player1.2.2.swf" width="640" height="360" quality="high" bgcolor="#000000" allowScriptAccess="sameDomain" allowFullScreen="true" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" flashvars="xmlPath=video.xml" />          
        </object></noscript>
    
          </div>
          <?php }  ?>
          
       
