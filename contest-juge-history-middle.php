<?php
$sql_product = "SELECT P.Product_Id, P.Member_Account_Id,	P.Title, P.Product_Notes, P.Sound, P.Type, P.Image_Name, P.Short_FIle_Name, P.Long_FIle_Name, P.Short_Desc, P.Long_Desc, P.Price,	P.Session_Start_Date, P.Session_End_Date, DATE_FORMAT(P.Session_Start_Date,'%m/%d/%Y %h:%i %p') as StartDate, DATE_FORMAT(P.Session_End_Date,'%m/%d/%Y %h:%i %p') as EndDate, P.Product_Date, P.Status, P.Jack_Pot, P.Jack_Pot_Status FROM product_master P WHERE P.Product_Id='".$_GET['id']."'";
$result_product = mysql_query($sql_product);
$colles_Product = mysql_fetch_array($result_product);

$sql_SC = "SELECT P.Product_Id FROM product_master P WHERE P.Product_Id='".$_GET['id']."' AND P.Status=1 AND P.Type!=3 AND  now() between P.Session_End_Date AND  DATE_ADD(P.Session_End_Date, INTERVAL +1 DAY) ORDER BY Session_End_Date";
$result_SC = mysql_query($sql_SC);




if(!empty($colles_Product['Short_FIle_Name']))
{
list($pname,$pext) = explode('.',$colles_Product['Short_FIle_Name']);
$pfileName = $colles_Product['Short_FIle_Name'];
if(strtolower($pext)=='mp3' || strtolower($pext)=='wma' || strtolower($pext)=='wav') 
{
$xml_paudio = simplexml_load_file('settings.xml');
$xml_paudio->no_playlist_mp3_source['value'] = 'products/small_video/'.$pfileName;
file_put_contents('settings.xml', $xml_paudio->asXML());
$xml_paudio = simplexml_load_file('content.xml');
$xml_paudio->sound['source'] = 'products/small_video/'.$pfileName;
file_put_contents('content.xml', $xml_paudio->asXML());
}
elseif(strtolower($pext)=='avi' || strtolower($pext)=='3gp' || strtolower($pext)=='flv' || strtolower($pext)=='mkv' || strtolower($pext)=='mov' || strtolower($pext)=='mp4' || strtolower($pext)=='mpeg' || strtolower($pext)=='wmv' )
{
$xml_pvideo = simplexml_load_file('video.xml');
$xml_pvideo->video_item->hd_video_path = 'products/small_video/'.$pfileName;
$xml_pvideo->video_item->sd_video_path = 'products/small_video/'.$pfileName;
file_put_contents('video.xml', $xml_pvideo->asXML());
}
}
else
{
list($pname,$pext) = explode('.',$colles_default['Video_File']);
$pfileName = $colles_default['Video_File'];
if(strtolower($pext)=='mp3' || strtolower($pext)=='wma' || strtolower($pext)=='wav') 
{
$xml_paudio = simplexml_load_file('settings.xml');
$xml_paudio->no_playlist_mp3_source['value'] = 'products/default_video/'.$pfileName;
file_put_contents('settings.xml', $xml_paudio->asXML());
$xml_paudio = simplexml_load_file('content.xml');
$xml_paudio->sound['source'] = 'products/default_video/'.$pfileName;
file_put_contents('content.xml', $xml_paudio->asXML());
}
elseif(strtolower($pext)=='avi' || strtolower($pext)=='3gp' || strtolower($pext)=='flv' || strtolower($pext)=='mkv' || strtolower($pext)=='mov' || strtolower($pext)=='mp4' || strtolower($pext)=='mpeg' || strtolower($pext)=='wmv' )
{
$xml_pvideo = simplexml_load_file('video.xml');
$xml_pvideo->video_item->hd_video_path = 'products/default_video/'.$pfileName;
$xml_pvideo->video_item->sd_video_path = 'products/default_video/'.$pfileName;
file_put_contents('video.xml', $xml_pvideo->asXML());
}
}
$iName = Get_Single_Field("member_account_master","Photo","Member_Account_Id","$_SESSION[SESS_ID]");
$sql = "SELECT * FROM member_account_master WHERE Member_Account_Id='".$_SESSION['SESS_ID']."'";
$result = mysql_query($sql);
$colles = mysql_fetch_array($result);

$sql_history_post = "SELECT * FROM lyrics_post_master WHERE Status='1' AND Product_Id='".$_GET['id']."'";
$result_history_post = mysql_query($sql_history_post);

$sqlAudio = "SELECT * FROM lyrics_post_audio_master WHERE Status='1' AND Product_Id='".$_GET['id']."' AND Lyrics_Audio_Type='AUDIO'";
$resultAudio = mysql_query($sqlAudio);

$sqlVideo = "SELECT * FROM lyrics_post_audio_master WHERE Status='1' AND Product_Id='".$_GET['id']."' AND Lyrics_Audio_Type='VIDEO'";
$resultVideo = mysql_query($sqlVideo);


$sqlButton = "SELECT * FROM lyrics_post_comment_master WHERE  Product_Id='".$_REQUEST['id']."' AND Member_Account_Id='".$_SESSION['SESS_ID']."'";
$resultButton = mysql_query($sqlButton);
$collesButton = mysql_fetch_array($resultButton);

if($_POST['buttonSubmit']=='Report')
{

	if($_POST['Sound_Title']!='' && ($_POST['Artist_Name'] || $_POST['Musician_Name']))
	{
	$sql_insert = "INSERT INTO report_master SET 
				   Artist_Name = '".addslashes($_POST['Artist_Name'])."', 
				   Musician_Name = '".addslashes($_POST['Musician_Name'])."', 
				   Sound_Title ='".addslashes($_POST['Sound_Title'])."',
				   Details='".addslashes($_POST['Details'])."'"; 
	mysql_query($sql_insert);
	
	    $TO = Get_Single_Field("general_setting_master","Mails_Id","Gen_Set_Id","1");
		$SUBJECT = 'Soundslikecash Report';
		
		$BODY = "Report information is below. <br><br>";
		$BODY .= "Artist Name :". stripslashes($_POST['Artist_Name']) ."<br>";
		$BODY .= "Musician Name  : ". stripslashes($_POST['Musician_Name'])."<br>";
		$BODY .= "Sound Title : ". stripslashes($_POST['Sound_Title'])."<br>";
		$BODY .= "Details : ". stripslashes($_POST['Details'])."<br>";
		$BODY.= "<br><br>Thanks,";
		$BODY.= "<br>The Soundslikecash Team";

		$HEADER = "From: ".$TO." <".$TO."> \n";
		$HEADER .= "Reply-To: $Email <$Email>\n";
		$HEADER .= "Content-type: text/html\r\n"; 

	   
		$MAILSEND = @mail($TO, $SUBJECT, $BODY, $HEADER);
		$_SESSION['sess_mess'] =  "Report Added";
		header("location:".$urls);
		exit;
        }
		else
		{
		$_SESSION['sess_mess'] =  "Fields Required";
		header("location:".$urls);
		exit;
		}
}	
?>
<script language="javascript">
function do_active()
{
	if(document.getElementById('Lyrics').value=='')
	{
	document.getElementById('post_button').disabled=true;
	}
	else
	{
	document.getElementById('post_button').disabled=false;
	$('#post_button').css({'color' : '#FFF', 'cursor' : 'pointer'});
	}
}
</script>
<div id="page-wrapper">
  <div class="layoutArea">
    <div class="contentArea">
      <div class="content-box-2">
        <div class="cor_1set-5"></div>
        <div class="cor_1set-6"></div>
        <div class="lftPannel user lft-col">
          <div class="vedioPrt">
            <h1> <a href="<?=SITE_WS_PATH?>/<?=$_SESSION['SESS_ID']?>/<?=$_SESSION['SESS_FIRST_NAME']?>">
              <?php if(file_exists("products/user_image/$iName") && $iName!='') { ?>
              <img src="products/user_image/<?php echo $iName; ?>" border="0" width="33" height="33" />
              <?php } else { ?>
              <img src="images/user_big.png" border="0" width="33" height="33" />
              <?php } ?>
              </a><span>
              <?=$_SESSION['SESS_FIRST_NAME']?>
              Contest Judge</span> </h1>
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
              <a href="http://www.adobe.com/go/getflashplayer"> <img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" /> </a> </div>
            <?php  } elseif(strtolower($pext)=='avi' || strtolower($pext)=='3gp' || strtolower($pext)=='flv' || strtolower($pext)=='mkv' || strtolower($pext)=='mov' || strtolower($pext)=='mp4' || strtolower($pext)=='mpeg' || strtolower($pext)=='wmv' ) { ?>
            <div class="player"> 
              <script type="text/javascript">
                        AC_FL_RunContent( 'codebase','http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0','width','640','height','360','src','pro_video_player1.2.2','quality','high','bgcolor','#000000','allowscriptaccess','sameDomain','allowfullscreen','true','pluginspage','http://www.macromedia.com/go/getflashplayer','flashvars','xmlPath=video<?=$p_id?>.xml','movie','pro_video_player1.2.2' ); //end AC code
                        </script>
              <noscript>
              <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="640" height="360">
                <param name="allowScriptAccess" value="sameDomain" />
                <param name="allowFullScreen" value="true" />
                <param name="movie" value="pro_video_player1.2.2.swf" />
                <param name="quality" value="high" />
                <param name="bgcolor" value="#000000" />
                <param name="flashvars" value="xmlPath=video.xml">
                <embed src="pro_video_player1.2.2.swf" width="640" height="360" quality="high" bgcolor="#000000" allowScriptAccess="sameDomain" allowFullScreen="true" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" flashvars="xmlPath=video.xml" />
              </object>
              </noscript>
            </div>
            <?php }  ?>
          </div>
          <div class="postNew">
            <form name="chCommentFrm" method="post" action="">
              <p>
                <textarea rows="2" cols="20" name="Lyrics_Comment" id="Lyrics_Comment"  ></textarea>
              </p>
              <?php if(mysql_num_rows($resultButton)==0) {  ?>
              <input type="button" name="post new" value="post new" class="postNewBtn"  onclick="showStuff('confirm_id');"/>
              <?php } else { ?>
              <input type="button" name="post new" value="Posted"  style="cursor:text; background: #6BB701; border: medium none; float: left;height: 21px;margin: 15px 0;color:#990000;width: 103px;" />
              <div style="padding-left:110px;"><a id="viewComments" href="#displayComment">
                <input type="button" name="post new" value="View Comment"  style="cursor:pointer; background: #6BB701; border: medium none; float: left;height: 21px;margin: 15px 0;color:#ccc;width: 135px;" />
                </a>
                <div style="display: none;">
                  <div id="displayComment" style="width:500px;height:100px;">
                    <div style="padding: 5px 0 0 10px;" align="justify">
                      <?=stripslashes($collesButton['Lyrics_Comment'])?>
                    </div>
                  </div>
                </div>
              </div>
              <?php } ?>
            </form>
          </div>
          <div class="popupConfirm" style="display:none;" id="report">
            <div> <span  align="center">
              <h2>Report</h2>
              <p></p>
              <form id="frmReport" name="frmReport"  method="post" action="">
                <table width="90%" cellspacing="2" cellpadding="2">
                  <tr valign="top">
                    <td width="40%">Artist Name </td>
                    <td width="60%"><input type="text" name="Artist_Name" id="Artist_Name"  size="20"></td>
                  </tr>
                  <tr valign="top">
                    <td width="40%">Musician Name </td>
                    <td width="60%"><input type="text" name="Musician_Name" id="Musician_Name"  size="20" ></td>
                  </tr>
                  <tr valign="top">
                    <td width="40%">Sound Title</td>
                    <td width="60%"><input type="text" name="Sound_Title" id="Sound_Title"  size="20" ></td>
                  </tr>
                  <tr valign="top">
                    <td width="40%">Details</td>
                    <td width="60%"><textarea name="Details" cols="27" rows="3"></textarea></td>
                  </tr>
                  <tr>
                    <td width="40%"><input type="hidden" name="id" value="<?=$_REQUEST['id']?>" /></td>
                    <td width="60%"><input name="buttonSubmit" type="submit" value="Report" class="form-button" >
                      <input name="buttonSubmit" type="button" value="Close" class="form-button" onclick="hideStuff('report');showStuff('report_id');" ></td>
                  </tr>
                </table>
              </form>
              </span> </div>
          </div>
          <div class="popupConfirm scroll" style="display:none;" id="confirm_id">
            <div> <span  align="center" id="view_post_judge_comment_result">
              <h2>Wait Confirmation</h2>
              <p>Are you sure you are ready to post your lyrics? You can not edit anymore durning this session.<br />
                Choose below</p>
              <a href="javascript:void(0);" onclick="return post_judge_comment('<?=$_REQUEST['id']?>','<?=$_SESSION['SESS_ID']?>');"><strong>Yes!</strong></a> <a href="javascript:void(0);" onclick="hideStuff('confirm_id');" ><span>No! I'm not Ready</span></a> </span> </div>
          </div>
          
        </div>
        <div class="rgtPannel history judge">
            <div class="ads"><img src="images/advertisement1.png" alt="" /></div>
            <div class="ads"><img src="images/advertisement2.png" alt="" /></div>
        </div>
        <div class="cl"></div>
        <div class="rgtPannel history info">
            
          <h1>POSTS :
            <?=mysql_num_rows($result_history_post)?>
          </h1>
          <div class="links">
            <ul>
              <li class="session"><a href="<?=$urls?>&display=F">All Sessions</a></li>
              <li class="text"><a href="<?=$urls?>&display=T">Text Sessions</a></li>
              <li class="audio"><a href="<?=$urls?>&display=A">Audio Sessions</a></li>
              <li class="video"><a href="<?=$urls?>&display=V">Video Sessions</a></li>
            </ul>
            <div class="cl"></div>
          </div>
          <div class="scroller">
            <?php if($_GET['display']=='' || $_GET['display']=='F') { ?>
			<?php
			$ct=1;
			if(mysql_num_rows($result_history_post)>0)
			{
            while($colles_history_post = mysql_fetch_array($result_history_post)) {
            $todaydate = date("Y-m-d H:i:s");
            $ago = strtotime($todaydate) - strtotime($colles_history_post['Lyrics_Date']);
            if ($ago >= 86400) { 
            $diff = floor($ago/86400).' days ago'; 
            } elseif ($ago >= 3600) { 
            $diff = floor($ago/3600).' hours ago'; 
            } elseif ($ago >= 60) { 
            $diff = floor($ago/60).' minutes ago'; 
            } else { 
            $diff = $ago.' seconds ago'; 
            }
            $m_name = Get_Single_Field("member_account_master","First_Name","Member_Account_Id","$colles_history_post[Member_Account_Id]");
            ?>
            <script language="javascript">
                    function createObject(){
                    if(window.XMLHttpRequest){
                    var obj	= new XMLHttpRequest();
                    }else{
                    var obj	= new ActiveXObject('Microsoft.XMLHTTP');
                    }
                    return obj;
                    }
                    var httpobj	= createObject();
                    function ajaxThumpsRating<?=$ct?>(toid,fromid,pid,type,value){
                    
                    document.getElementById('view_thumps_rating<?=$ct?>').innerHTML ='<img src="images/loading.gif" alt="" />';
                    //alert("ajax_thumps-reting.php?toid="+toid+"&fromid="+fromid+"&pid="+pid+"&type="+type+"&value="+value);
                    httpobj.open('get',"ajax_thumps-reting.php?toid="+toid+"&fromid="+fromid+"&pid="+pid+"&type="+type+"&value="+value);
                    httpobj.onreadystatechange	= handleThumpsRatingResponse<?=$ct?>;
                    httpobj.send("");
                    }
                    function handleThumpsRatingResponse<?=$ct?>()
                    {
                    if(httpobj.readyState==4){
                    var text = httpobj.responseText;
					 document.getElementById('view_thumps_rating2<?=$ct?>').style.display = 'block';
                    document.getElementById('view_thumps_rating<?=$ct?>').innerHTML = text;
                    
                   // document.getElementById('view_thumps_rating<?=$ct?>').style.display = 'block';
                    var sharedLoader1 = document.getElementById('view_thumps_rating2<?=$ct?>'); //div auto hide made by vishwas just chill
                    var timeoutLoader1 = window.setTimeout(function(){sharedLoader1.style.display = 'none'; location.replace('<?=$urls?>');}, 3000);
                    }
                    }
                    </script>
            <div class="postBlock">
              <p>
                <?=stripslashes($colles_history_post['Lyrics']);?>
              </p>
              
              
              <div class="user"> <strong>
                <?=ucfirst($m_name)?>
                </strong> <span>
                <?=$diff;?>
                </span>
                <?php $userImage = Get_Single_Field("member_account_master","Photo","Member_Account_Id","$colles_history_post[Member_Account_Id]"); ?>
                <a class="block fl" href="<?=SITE_WS_PATH?>/<?=trim($colles_history_post['Member_Account_Id'])?>/<?=ucfirst(stripslashes(Get_Single_Field("member_account_master","First_Name","Member_Account_Id","$colles_history_post[Member_Account_Id]")))?>">
                <?php if(file_exists("products/user_image/$userImage") && $userImage!='') { ?>
                <img src="products/user_image/<?php echo $userImage; ?>" border="0" width="33" height="33" />
                <?php } else { ?>
                <img src="images/user_big.png" border="0" width="33" height="33" />
                <?php } ?>
                </a> <span>
                <?php if(mysql_num_rows($result_SC)>0) { ?>
                <input type="submit" name="yes" value="yes" class="yesBtn" onclick="ajaxThumpsRating<?=$ct?>('<?=$colles_history_post['Member_Account_Id']?>','<?=$_SESSION['SESS_ID']?>','<?=$colles_history_post['Product_Id']?>','<?=$_SESSION['SESS_ACCOUNT_TYPE']?>','1')" />
                <input type="submit" name="no" value="no" class="noBtn" onclick="ajaxThumpsRating<?=$ct?>('<?=$colles_history_post['Member_Account_Id']?>','<?=$_SESSION['SESS_ID']?>','<?=$colles_history_post['Product_Id']?>','<?=$_SESSION['SESS_ACCOUNT_TYPE']?>','-1')" />
                <?php } else { ?>
                <input type="submit" name="yes" value="yes" class="yesBtn" style="cursor:text;" onmouseover="Tip('You can vote after session close. valid for 1 day interval after closing.')" onmouseout="UnTip()" />
                <input type="submit" name="no" value="no" class="noBtn" style="cursor:text;" onmouseover="Tip('You can vote after session close. valid for 1 day interval after closing.')" onmouseout="UnTip()" />
                <?php } ?>
                </span>
                <div class="cl"></div>
              </div>
              <div class="cl"></div>
            </div>
            <div class="popupConfirm scroll" align="left" style="display:none; top:570px; position:absolute;" id="view_thumps_rating2<?=$ct?>">
              <div id="view_thumps_rating<?=$ct?>"></div>
            </div>
            <?php
			$ct++;
			}
			}
			?>
            
            <?php
			$v=0;
			if(mysql_num_rows($resultAudio)>0)
			{
			while($collesAudio = mysql_fetch_array($resultAudio))
			{
			$todaydate = date("Y-m-d H:i:s");
			$ago = strtotime($todaydate) - strtotime($collesAudio['Lyrics_Audio_Date']);
			if ($ago >= 86400) { 
			$diff = floor($ago/86400).' days ago'; 
			} elseif ($ago >= 3600) { 
			$diff = floor($ago/3600).' hours ago'; 
			} elseif ($ago >= 60) { 
			$diff = floor($ago/60).' minutes ago'; 
			} else { 
			$diff = $ago.' seconds ago'; 
			}
			$m_name = Get_Single_Field("member_account_master","First_Name","Member_Account_Id","$collesAudio[Member_Account_Id]");
			?>
            <script language="javascript">
			function createObject(){
			if(window.XMLHttpRequest){
			var obj	= new XMLHttpRequest();
			}else{
			var obj	= new ActiveXObject('Microsoft.XMLHTTP');
			}
			return obj;
			}
			var httpobj	= createObject();
			function ajaxThumpsRatingAudio<?=$v?>(toid,fromid,pid,type,value){
			
			document.getElementById('view_thumps_rating_audio<?=$v?>').innerHTML ='<img src="images/loading.gif" alt="" />';
			//alert("ajax_thumps-reting.php?toid="+toid+"&fromid="+fromid+"&pid="+pid+"&type="+type+"&value="+value);
			httpobj.open('get',"ajax_thumps-reting.php?toid="+toid+"&fromid="+fromid+"&pid="+pid+"&type="+type+"&value="+value);
			httpobj.onreadystatechange	= handleThumpsRatingAudioResponse<?=$v?>;
			httpobj.send("");
			}
			function handleThumpsRatingAudioResponse<?=$v?>()
			{
			if(httpobj.readyState==4){
			var text = httpobj.responseText;
			 document.getElementById('view_thumps_rating_audio2<?=$v?>').style.display = 'block';
			document.getElementById('view_thumps_rating_audio<?=$v?>').innerHTML = text;
			
		   // document.getElementById('view_thumps_rating<?=$v?>').style.display = 'block';
			var sharedLoader1 = document.getElementById('view_thumps_rating_audio2<?=$v?>'); //div auto hide made by vishwas just chill
			var timeoutLoader1 = window.setTimeout(function(){sharedLoader1.style.display = 'none'; location.replace('<?=$urls?>');}, 3000);
			}
			}
			</script>
            <div class="postBlock"> 
            <a href="artist-preview-player.php?id=<?=$collesAudio['Lyrics_Post_Audio_Id']?>" title="<?='Artist '.ucfirst($m_name).' '.ucfirst(strtolower($collesAudio['Lyrics_Audio_Type'])) .' File'?>" rel="gb_page_center[640, 360]" class="global-box"><img src="images/audio-thumb.png" alt="" /></a>
            <div class="caption">
              <h3>Video Session</h3>
              <span><?='Artist '.ucfirst($m_name).' '.ucfirst(strtolower($collesAudio['Lyrics_Audio_Type'])) .' File'?></span>
            </div>
              <div class="user"> 
              <strong> <?=ucfirst($m_name)?></strong> 
                <span>  <?=$diff;?> </span> 
                <?php $userImage = Get_Single_Field("member_account_master","Photo","Member_Account_Id","$collesAudio[Member_Account_Id]"); ?>
                <a class="block fl" href="<?=SITE_WS_PATH?>/<?=trim($collesAudio['Member_Account_Id'])?>/<?=ucfirst(stripslashes(Get_Single_Field("member_account_master","First_Name","Member_Account_Id","$collesAudio[Member_Account_Id]")))?>">
                <?php if(file_exists("products/user_image/$userImage") && $userImage!='') { ?>
                <img src="products/user_image/<?php echo $userImage; ?>" border="0" width="33" height="33" />
                <?php } else { ?>
                <img src="images/user_big.png" border="0" width="33" height="33" />
                <?php } ?>
                </a>
                <span>
                <input type="submit" name="yes" value="yes" class="yesBtn" onclick="ajaxThumpsRatingAudio<?=$v?>('<?=$collesAudio['Member_Account_Id']?>','<?=$_SESSION['SESS_ID']?>','<?=$collesAudio['Product_Id']?>','<?=$_SESSION['SESS_ACCOUNT_TYPE']?>','1')" />
                <input type="submit" name="no" value="no" class="noBtn" onclick="ajaxThumpsRatingAudio<?=$v?>('<?=$collesAudio['Member_Account_Id']?>','<?=$_SESSION['SESS_ID']?>','<?=$collesAudio['Product_Id']?>','<?=$_SESSION['SESS_ACCOUNT_TYPE']?>','-1')" />
                </span>
                <div class="cl"></div>
              </div>
              <div class="cl"></div>
            </div>
            <div class="popupConfirm scroll" style="display:none; top:570px; position:absolute;" align="left" id="view_thumps_rating_audio2<?=$v?>">
              <div id="view_thumps_rating_audio<?=$v?>"></div>
            </div>
            <?php $v++; } } ?>
            
            <?php
			$t=0;
			if(mysql_num_rows($resultVideo)>0)
			{
			while($collesVideo = mysql_fetch_array($resultVideo))
			{
			$todaydate = date("Y-m-d H:i:s");
			$ago = strtotime($todaydate) - strtotime($collesVideo['Lyrics_Audio_Date']);
			if ($ago >= 86400) { 
			$diff = floor($ago/86400).' days ago'; 
			} elseif ($ago >= 3600) { 
			$diff = floor($ago/3600).' hours ago'; 
			} elseif ($ago >= 60) { 
			$diff = floor($ago/60).' minutes ago'; 
			} else { 
			$diff = $ago.' seconds ago'; 
			}
			$m_name = Get_Single_Field("member_account_master","First_Name","Member_Account_Id","$collesVideo[Member_Account_Id]");
			?>
            <script language="javascript">
			function createObject(){
			if(window.XMLHttpRequest){
			var obj	= new XMLHttpRequest();
			}else{
			var obj	= new ActiveXObject('Microsoft.XMLHTTP');
			}
			return obj;
			}
			var httpobj	= createObject();
			function ajaxThumpsRatingVideo<?=$t?>(toid,fromid,pid,type,value){
			
			document.getElementById('view_thumps_rating_video<?=$t?>').innerHTML ='<img src="images/loading.gif" alt="" />';
			//alert("ajax_thumps-reting.php?toid="+toid+"&fromid="+fromid+"&pid="+pid+"&type="+type+"&value="+value);
			httpobj.open('get',"ajax_thumps-reting.php?toid="+toid+"&fromid="+fromid+"&pid="+pid+"&type="+type+"&value="+value);
			httpobj.onreadystatechange	= handleThumpsRatingVideoResponse<?=$t?>;
			httpobj.send("");
			}
			function handleThumpsRatingVideoResponse<?=$t?>()
			{
			if(httpobj.readyState==4){
			var text = httpobj.responseText;
			 document.getElementById('view_thumps_rating_video2<?=$t?>').style.display = 'block';
			document.getElementById('view_thumps_rating_video<?=$t?>').innerHTML = text;
			
		   // document.getElementById('view_thumps_rating<?=$t?>').style.display = 'block';
			var sharedLoader1 = document.getElementById('view_thumps_rating_video2<?=$t?>'); //div auto hide made by vishwas just chill
			var timeoutLoader1 = window.setTimeout(function(){sharedLoader1.style.display = 'none'; location.replace('<?=$urls?>');}, 3000);
			}
			}
			</script>
            <div class="postBlock"> 
            <a href="artist-preview-player.php?id=<?=$collesVideo['Lyrics_Post_Audio_Id']?>" title="<?='Artist '.ucfirst($m_name).' '.ucfirst(strtolower($collesVideo['Lyrics_Audio_Type'])) .' File'?>" rel="gb_page_center[640, 360]" class="global-box"><img src="images/video-thumb2.png" alt="" /></a>
            <div class="caption">
              <h3>Video Session</h3>
              <span><?='Artist '.ucfirst($m_name).' '.ucfirst(strtolower($collesVideo['Lyrics_Audio_Type'])) .' File'?></span>
            </div>
              <div class="user"> 
              <strong> <?=ucfirst($m_name)?></strong> 
                <span>  <?=$diff;?> </span> 
                <?php $userImage = Get_Single_Field("member_account_master","Photo","Member_Account_Id","$collesVideo[Member_Account_Id]"); ?>
                <a class="block fl" href="<?=SITE_WS_PATH?>/<?=trim($collesVideo['Member_Account_Id'])?>/<?=ucfirst(stripslashes(Get_Single_Field("member_account_master","First_Name","Member_Account_Id","$collesVideo[Member_Account_Id]")))?>">
                <?php if(file_exists("products/user_image/$userImage") && $userImage!='') { ?>
                <img src="products/user_image/<?php echo $userImage; ?>" border="0" width="33" height="33" />
                <?php } else { ?>
                <img src="images/user_big.png" border="0" width="33" height="33" />
                <?php } ?>
                </a>
                <span>
                <input type="submit" name="yes" value="yes" class="yesBtn" onclick="ajaxThumpsRatingVideo<?=$t?>('<?=$collesVideo['Member_Account_Id']?>','<?=$_SESSION['SESS_ID']?>','<?=$collesVideo['Product_Id']?>','<?=$_SESSION['SESS_ACCOUNT_TYPE']?>','1')" />
                <input type="submit" name="no" value="no" class="noBtn" onclick="ajaxThumpsRatingVideo<?=$t?>('<?=$collesVideo['Member_Account_Id']?>','<?=$_SESSION['SESS_ID']?>','<?=$collesVideo['Product_Id']?>','<?=$_SESSION['SESS_ACCOUNT_TYPE']?>','-1')" />
                </span>
                <div class="cl"></div>
              </div>
			  <div class="cl"></div>
            </div>
            <div class="popupConfirm scroll" style="display:none; top:570px; position:absolute;" align="left" id="view_thumps_rating_video2<?=$t?>">
              <div id="view_thumps_rating_video<?=$t?>"></div>
            </div>
            <?php $t++; } }?>
            <?php } else { ?>
            
            <?php if($_GET['display']=='T') { ?>
            
            
            <?php
			$ct=1;
			if(mysql_num_rows($result_history_post)>0)
			{
            while($colles_history_post = mysql_fetch_array($result_history_post)) {
            $todaydate = date("Y-m-d H:i:s");
            $ago = strtotime($todaydate) - strtotime($colles_history_post['Lyrics_Date']);
            if ($ago >= 86400) { 
            $diff = floor($ago/86400).' days ago'; 
            } elseif ($ago >= 3600) { 
            $diff = floor($ago/3600).' hours ago'; 
            } elseif ($ago >= 60) { 
            $diff = floor($ago/60).' minutes ago'; 
            } else { 
            $diff = $ago.' seconds ago'; 
            }
            $m_name = Get_Single_Field("member_account_master","First_Name","Member_Account_Id","$colles_history_post[Member_Account_Id]");
            ?>
            <script language="javascript">
                    function createObject(){
                    if(window.XMLHttpRequest){
                    var obj	= new XMLHttpRequest();
                    }else{
                    var obj	= new ActiveXObject('Microsoft.XMLHTTP');
                    }
                    return obj;
                    }
                    var httpobj	= createObject();
                    function ajaxThumpsRating<?=$ct?>(toid,fromid,pid,type,value){
                    
                    document.getElementById('view_thumps_rating<?=$ct?>').innerHTML ='<img src="images/loading.gif" alt="" />';
                    //alert("ajax_thumps-reting.php?toid="+toid+"&fromid="+fromid+"&pid="+pid+"&type="+type+"&value="+value);
                    httpobj.open('get',"ajax_thumps-reting.php?toid="+toid+"&fromid="+fromid+"&pid="+pid+"&type="+type+"&value="+value);
                    httpobj.onreadystatechange	= handleThumpsRatingResponse<?=$ct?>;
                    httpobj.send("");
                    }
                    function handleThumpsRatingResponse<?=$ct?>()
                    {
                    if(httpobj.readyState==4){
                    var text = httpobj.responseText;
					 document.getElementById('view_thumps_rating2<?=$ct?>').style.display = 'block';
                    document.getElementById('view_thumps_rating<?=$ct?>').innerHTML = text;
                    
                   // document.getElementById('view_thumps_rating<?=$ct?>').style.display = 'block';
                    var sharedLoader1 = document.getElementById('view_thumps_rating2<?=$ct?>'); //div auto hide made by vishwas just chill
                    var timeoutLoader1 = window.setTimeout(function(){sharedLoader1.style.display = 'none'; location.replace('<?=$urls?>');}, 3000);
                    }
                    }
                    </script>
            <div class="postBlock">
              <p>
                <?=stripslashes($colles_history_post['Lyrics']);?>
              </p>
              
              <div class="cl"></div>
              <div class="user"> <strong>
                <?=ucfirst($m_name)?>
                </strong> <span>
                <?=$diff;?>
                </span>
                <?php $userImage = Get_Single_Field("member_account_master","Photo","Member_Account_Id","$colles_history_post[Member_Account_Id]"); ?>
                <a class="block fl" href="<?=SITE_WS_PATH?>/<?=trim($colles_history_post['Member_Account_Id'])?>/<?=ucfirst(stripslashes(Get_Single_Field("member_account_master","First_Name","Member_Account_Id","$colles_history_post[Member_Account_Id]")))?>">
                <?php if(file_exists("products/user_image/$userImage") && $userImage!='') { ?>
                <img src="products/user_image/<?php echo $userImage; ?>" border="0" width="33" height="33" />
                <?php } else { ?>
                <img src="images/user_big.png" border="0" width="33" height="33" />
                <?php } ?>
                </a> <span>
                <input type="submit" name="yes" value="yes" class="yesBtn" onclick="ajaxThumpsRating<?=$ct?>('<?=$colles_history_post['Member_Account_Id']?>','<?=$_SESSION['SESS_ID']?>','<?=$colles_history_post['Product_Id']?>','<?=$_SESSION['SESS_ACCOUNT_TYPE']?>','1')" />
                <input type="submit" name="no" value="no" class="noBtn" onclick="ajaxThumpsRating<?=$ct?>('<?=$colles_history_post['Member_Account_Id']?>','<?=$_SESSION['SESS_ID']?>','<?=$colles_history_post['Product_Id']?>','<?=$_SESSION['SESS_ACCOUNT_TYPE']?>','-1')" />
                </span>
                <div class="cl"></div>
              </div>
            </div>
            <div class="popupConfirm scroll" style="display:none; top:570px; position:absolute;" align="left" id="view_thumps_rating2<?=$ct?>">
              <div id="view_thumps_rating<?=$ct?>"></div>
            </div>
            <?php
			$ct++;
			}
			}
			?>
            
            
            <?php } elseif($_GET['display']=='A') { ?>
            
            <?php
			$v=0;
			if(mysql_num_rows($resultAudio)>0)
			{
			while($collesAudio = mysql_fetch_array($resultAudio))
			{
			$todaydate = date("Y-m-d H:i:s");
			$ago = strtotime($todaydate) - strtotime($collesAudio['Lyrics_Audio_Date']);
			if ($ago >= 86400) { 
			$diff = floor($ago/86400).' days ago'; 
			} elseif ($ago >= 3600) { 
			$diff = floor($ago/3600).' hours ago'; 
			} elseif ($ago >= 60) { 
			$diff = floor($ago/60).' minutes ago'; 
			} else { 
			$diff = $ago.' seconds ago'; 
			}
			$m_name = Get_Single_Field("member_account_master","First_Name","Member_Account_Id","$collesAudio[Member_Account_Id]");
			?>
            <script language="javascript">
			function createObject(){
			if(window.XMLHttpRequest){
			var obj	= new XMLHttpRequest();
			}else{
			var obj	= new ActiveXObject('Microsoft.XMLHTTP');
			}
			return obj;
			}
			var httpobj	= createObject();
			function ajaxThumpsRatingAudio<?=$v?>(toid,fromid,pid,type,value){
			
			document.getElementById('view_thumps_rating_audio<?=$v?>').innerHTML ='<img src="images/loading.gif" alt="" />';
			//alert("ajax_thumps-reting.php?toid="+toid+"&fromid="+fromid+"&pid="+pid+"&type="+type+"&value="+value);
			httpobj.open('get',"ajax_thumps-reting.php?toid="+toid+"&fromid="+fromid+"&pid="+pid+"&type="+type+"&value="+value);
			httpobj.onreadystatechange	= handleThumpsRatingAudioResponse<?=$v?>;
			httpobj.send("");
			}
			function handleThumpsRatingAudioResponse<?=$v?>()
			{
			if(httpobj.readyState==4){
			var text = httpobj.responseText;
			 document.getElementById('view_thumps_rating_audio2<?=$v?>').style.display = 'block';
			document.getElementById('view_thumps_rating_audio<?=$v?>').innerHTML = text;
			
		   // document.getElementById('view_thumps_rating<?=$v?>').style.display = 'block';
			var sharedLoader1 = document.getElementById('view_thumps_rating_audio2<?=$v?>'); //div auto hide made by vishwas just chill
			var timeoutLoader1 = window.setTimeout(function(){sharedLoader1.style.display = 'none'; location.replace('<?=$urls?>');}, 3000);
			}
			}
			</script>
            <div class="postBlock"> 
            <a href="artist-preview-player.php?id=<?=$collesAudio['Lyrics_Post_Audio_Id']?>" title="<?='Artist '.ucfirst($m_name).' '.ucfirst(strtolower($collesAudio['Lyrics_Audio_Type'])) .' File'?>" rel="gb_page_center[640, 360]" class="global-box"><img src="images/audio-thumb.png" alt="" /></a>
            <div class="caption">
              <h3>Video Session</h3>
              <span><?='Artist '.ucfirst($m_name).' '.ucfirst(strtolower($collesAudio['Lyrics_Audio_Type'])) .' File'?></span>
            </div>
              <div class="user"> 
              <strong> <?=ucfirst($m_name)?></strong> 
                <span>  <?=$diff;?> </span> 
                <?php $userImage = Get_Single_Field("member_account_master","Photo","Member_Account_Id","$collesAudio[Member_Account_Id]"); ?>
                <a class="block fl" href="<?=SITE_WS_PATH?>/<?=trim($collesAudio['Member_Account_Id'])?>/<?=ucfirst(stripslashes(Get_Single_Field("member_account_master","First_Name","Member_Account_Id","$collesAudio[Member_Account_Id]")))?>">
                <?php if(file_exists("products/user_image/$userImage") && $userImage!='') { ?>
                <img src="products/user_image/<?php echo $userImage; ?>" border="0" width="33" height="33" />
                <?php } else { ?>
                <img src="images/user_big.png" border="0" width="33" height="33" />
                <?php } ?>
                </a>
                <span>
                <input type="submit" name="yes" value="yes" class="yesBtn" onclick="ajaxThumpsRatingAudio<?=$v?>('<?=$collesAudio['Member_Account_Id']?>','<?=$_SESSION['SESS_ID']?>','<?=$collesAudio['Product_Id']?>','<?=$_SESSION['SESS_ACCOUNT_TYPE']?>','1')" />
                <input type="submit" name="no" value="no" class="noBtn" onclick="ajaxThumpsRatingAudio<?=$v?>('<?=$collesAudio['Member_Account_Id']?>','<?=$_SESSION['SESS_ID']?>','<?=$collesAudio['Product_Id']?>','<?=$_SESSION['SESS_ACCOUNT_TYPE']?>','-1')" />
                </span>
                <div class="cl"></div>
              </div>
              <div class="cl"></div>
            </div>
            <div class="popupConfirm scroll" style="display:none; top:570px; position:absolute;" align="left" id="view_thumps_rating_audio2<?=$v?>">
              <div id="view_thumps_rating_audio<?=$v?>"></div>
            </div>
            <?php $v++; } } ?>
            
            <?php } elseif($_GET['display']=='V') { ?>
            
            <?php
			$t=0;
			if(mysql_num_rows($resultVideo)>0)
			{
			while($collesVideo = mysql_fetch_array($resultVideo))
			{
			$todaydate = date("Y-m-d H:i:s");
			$ago = strtotime($todaydate) - strtotime($collesVideo['Lyrics_Audio_Date']);
			if ($ago >= 86400) { 
			$diff = floor($ago/86400).' days ago'; 
			} elseif ($ago >= 3600) { 
			$diff = floor($ago/3600).' hours ago'; 
			} elseif ($ago >= 60) { 
			$diff = floor($ago/60).' minutes ago'; 
			} else { 
			$diff = $ago.' seconds ago'; 
			}
			$m_name = Get_Single_Field("member_account_master","First_Name","Member_Account_Id","$collesVideo[Member_Account_Id]");
			?>
            <script language="javascript">
			function createObject(){
			if(window.XMLHttpRequest){
			var obj	= new XMLHttpRequest();
			}else{
			var obj	= new ActiveXObject('Microsoft.XMLHTTP');
			}
			return obj;
			}
			var httpobj	= createObject();
			function ajaxThumpsRatingVideo<?=$t?>(toid,fromid,pid,type,value){
			
			document.getElementById('view_thumps_rating_video<?=$t?>').innerHTML ='<img src="images/loading.gif" alt="" />';
			//alert("ajax_thumps-reting.php?toid="+toid+"&fromid="+fromid+"&pid="+pid+"&type="+type+"&value="+value);
			httpobj.open('get',"ajax_thumps-reting.php?toid="+toid+"&fromid="+fromid+"&pid="+pid+"&type="+type+"&value="+value);
			httpobj.onreadystatechange	= handleThumpsRatingVideoResponse<?=$t?>;
			httpobj.send("");
			}
			function handleThumpsRatingVideoResponse<?=$t?>()
			{
			if(httpobj.readyState==4){
			var text = httpobj.responseText;
			 document.getElementById('view_thumps_rating_video2<?=$t?>').style.display = 'block';
			document.getElementById('view_thumps_rating_video<?=$t?>').innerHTML = text;
			
		   // document.getElementById('view_thumps_rating<?=$t?>').style.display = 'block';
			var sharedLoader1 = document.getElementById('view_thumps_rating_video2<?=$t?>'); //div auto hide made by vishwas just chill
			var timeoutLoader1 = window.setTimeout(function(){sharedLoader1.style.display = 'none'; location.replace('<?=$urls?>');}, 3000);
			}
			}
			</script>
            <div class="postBlock"> 
            <a href="artist-preview-player.php?id=<?=$collesVideo['Lyrics_Post_Audio_Id']?>" title="<?='Artist '.ucfirst($m_name).' '.ucfirst(strtolower($collesVideo['Lyrics_Audio_Type'])) .' File'?>" rel="gb_page_center[640, 360]" class="global-box"><img src="images/video-thumb2.png" alt="" /></a>
            <div class="caption">
              <h3>Video Session</h3>
              <span><?='Artist '.ucfirst($m_name).' '.ucfirst(strtolower($collesVideo['Lyrics_Audio_Type'])) .' File'?></span>
            </div>
            <div class="user"> 
              <strong> <?=ucfirst($m_name)?></strong> 
                <span>  <?=$diff;?> </span> 
                <?php $userImage = Get_Single_Field("member_account_master","Photo","Member_Account_Id","$collesVideo[Member_Account_Id]"); ?>
                <a class="block fl" href="<?=SITE_WS_PATH?>/<?=trim($collesVideo['Member_Account_Id'])?>/<?=ucfirst(stripslashes(Get_Single_Field("member_account_master","First_Name","Member_Account_Id","$collesVideo[Member_Account_Id]")))?>">
                <?php if(file_exists("products/user_image/$userImage") && $userImage!='') { ?>
                <img src="products/user_image/<?php echo $userImage; ?>" border="0" width="33" height="33" />
                <?php } else { ?>
                <img src="images/user_big.png" border="0" width="33" height="33" />
                <?php } ?>
                </a>
                <span>
                <input type="submit" name="yes" value="yes" class="yesBtn" onclick="ajaxThumpsRatingVideo<?=$t?>('<?=$collesVideo['Member_Account_Id']?>','<?=$_SESSION['SESS_ID']?>','<?=$collesVideo['Product_Id']?>','<?=$_SESSION['SESS_ACCOUNT_TYPE']?>','1')" />
                <input type="submit" name="no" value="no" class="noBtn" onclick="ajaxThumpsRatingVideo<?=$t?>('<?=$collesVideo['Member_Account_Id']?>','<?=$_SESSION['SESS_ID']?>','<?=$collesVideo['Product_Id']?>','<?=$_SESSION['SESS_ACCOUNT_TYPE']?>','-1')" />
                </span>
                <div class="cl"></div>
              </div>
			<div class="cl"></div>
            </div>
            <div class="popupConfirm scroll" style="display:none; top:570px; position:absolute;" align="left" id="view_thumps_rating_video2<?=$t?>">
              <div id="view_thumps_rating_video<?=$t?>"></div>
            </div>
            <?php $t++; } }?>
            
            <?php } }?>
            
            
          </div>
          <?php if($_SESSION['sess_mess']!='') { ?>
          <div>
            <?=$_SESSION['sess_mess']?>
            <?php $_SESSION['sess_mess']='';?>
          </div>
          <?php } ?>
          <div class="fr post" style=" display:none;">
            <h3>Comment About Session</h3>
            <SCRIPT LANGUAGE="JavaScript">
			function textCounter(field,cntfield,maxlimit) {
			if (field.value.length > maxlimit) // if too long...trim it!
			field.value = field.value.substring(0, maxlimit);
			else
			cntfield.value = maxlimit - field.value.length;
			}
			</script>
            <form name="chFrm" method="post" action="">
              <h3>Character limit:<span>
                <input readonly type="text" name="remLen1" size="3" maxlength="3" value="500">
                max</span></h3>
              <p>
                <textarea rows="2" cols="20" name="Lyrics_Comment"  id="Lyrics" onkeypress="do_active();" onKeyDown="textCounter(document.chFrm.Lyrics,document.chFrm.remLen1,500)"
        onKeyUp="textCounter(document.chFrm.Lyrics,document.chFrm.remLen1,500)"></textarea>
              </p>
              <div class="alignR">
                <div class="gray-btn-1"> <span> <span>
                  <input type="button" class="scroll1" value="Report" id="report_id" onclick="showStuff('report');hideStuff('report_id');" />
                  </span> </span> </div>
                <div class="gray-btn-1"> <span> <span>
                  <input type="button" class="scroll" name="post" id="post_button" value="Post" onclick="showStuff('confirm_id');"  disabled="disabled" style=" color:#999; cursor:text;" />
                  </span> </span> </div>
              </div>
            </form>
          </div>
          <div class="cl"></div>
        </div>
        <div class="cor_1set-3"></div>
        <div class="cor_1set-4"></div>
      </div>
      <div class="bottomPannel">
        <?php include"footer-div.inc.php"; ?>
      </div>
    </div>
  </div>
</div>
