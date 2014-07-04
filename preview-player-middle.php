<?php
$sql_product = "SELECT * FROM product_master WHERE Product_Id='".$_GET['id']."'";
$result_product = mysql_query($sql_product);
$colles_Product = mysql_fetch_array($result_product);
if(!empty($colles_Product['Short_FIle_Name']))
{

	list($pname,$pext) = explode('.',$colles_Product['Short_FIle_Name']);
	$pfileName = $colles_Product['Short_FIle_Name'];
	$videofile = 'products/small_video/'.$pfileName;
	$vid_tp = "";
	switch ($pext) {
	   case "mp3":
			 $vid_tp = "audio/mp3";
			 break;
		case "wma":
			 $vid_tp = "audio/x-ms-wma";
			 break;
		case "wav":
			 $vid_tp = "audio/wav";
			 break;
			 		 
		
		case 'avi':
			$vid_tp = "video/avi";
			break;
		case '3gp':
			$vid_tp = "video/3gpp";
			break;
		case 'flv':
			$vid_tp = "video/x-flv";
			break;
		case 'mkv':
			$vid_tp = "video/x-matroxka";
			break;
		case 'mov':
			$vid_tp = "video/quicktime";
			break;
		case 'mp4':
			$vid_tp = "video/mp4";
			break;
		case 'mpeg':
			$vid_tp = "video/mpeg";
			break;
		case 'wmv':
			$vid_tp = "video/x-ms-wmv";
			break;
	}
}
else
{
	list($pname,$pext) = explode('.',$colles_default['Video_File']);
	$pfileName = $colles_default['Video_File'];
	$videofile = 'products/default_video/'.$pfileName;
	$vid_tp = "";
	switch ($pext) {
	   case "mp3":
			 $vid_tp = "audio/mp3";
			 break;
		case "wma":
			 $vid_tp = "audio/x-ms-wma";
			 break;
		case "wav":
			 $vid_tp = "audio/wav";
			 break;
			 		 
		
		case 'avi':
			$vid_tp = "video/avi";
			break;
		case '3gp':
			$vid_tp = "video/3gpp";
			break;
		case 'flv':
			$vid_tp = "video/x-flv";
			break;
		case 'mkv':
			$vid_tp = "video/x-matroxka";
			break;
		case 'mov':
			$vid_tp = "video/quicktime";
			break;
		case 'mp4':
			$vid_tp = "video/mp4";
			break;
		case 'mpeg':
			$vid_tp = "video/mpeg";
			break;
		case 'wmv':
			$vid_tp = "video/x-ms-wmv";
			break;
	}
}
/*
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
          <?php }  
		  */
		  ?>

<div class="player-record-button">Record Now </div>

<script src="html5player/mediaelement-and-player.min.js"></script>
<link rel="stylesheet" href="html5player/mediaelementplayer.min.css" />
<audio id="player2" src="<?php echo $videofile;?>" type="<?php echo $vid_tp;?>" controls="controls" width="640"> 
<script>
$('audio,video').mediaelementplayer();
</script>