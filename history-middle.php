<?php
$sql_product = "SELECT P.Product_Id, P.Member_Account_Id,	P.Title, P.Product_Notes, P.Sound, P.Type, P.Image_Name, P.Short_FIle_Name, P.Long_FIle_Name, P.Short_Desc, P.Long_Desc, P.Price,	P.Session_Start_Date, P.Session_End_Date, DATE_FORMAT(P.Session_Start_Date,'%m/%d/%Y %h:%i %p') as StartDate, DATE_FORMAT(P.Session_End_Date,'%m/%d/%Y %h:%i %p') as EndDate, P.Product_Date, P.Status, P.Jack_Pot, P.Jack_Pot_Status FROM product_master P WHERE P.Product_Id='".$_GET['id']."'";
$result_product = mysql_query($sql_product);
$colles_Product = mysql_fetch_array($result_product);
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
$typ = $_SESSION['SESS_ACCOUNT_TYPE'];
$sql = "SELECT * FROM member_account_master WHERE  Member_Account_Id='".$_SESSION['SESS_ID']."'";
$result = mysql_query($sql);
$colles = mysql_fetch_array($result);

$sql_history_post = "SELECT * FROM notebook_master WHERE Member_Account_Id 	='".$_SESSION['SESS_ID']."' AND Status='1'";
$result_history_post = mysql_query($sql_history_post);
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
	
	    $Email = Get_Single_Field("general_setting_master","Mails_Id","Gen_Set_Id","1");
		$SUBJECT = 'Soundslikecash Report';
		$from = Get_Single_Field("general_setting_master","Mails_Id","Gen_Set_Id","1");
		
		$BODY = "Report information is below. <br><br>";
		$BODY .= "Artist Name :". stripslashes($_POST['Artist_Name']) ."<br>";
		$BODY .= "Musician Name  : ". stripslashes($_POST['Musician_Name'])."<br>";
		$BODY .= "Sound Title : ". stripslashes($_POST['Sound_Title'])."<br>";
		$BODY .= "Details : ". stripslashes($_POST['Details'])."<br>";
		$BODY.= "<br><br>Thanks,";
		$BODY.= "<br>The Soundslikecash Team";

		$HEADER = "From: ".$from." <".$from."> \n";
		$HEADER .= "Reply-To: $Email <$Email>\n";
		$HEADER .= "Content-type: text/html\r\n"; 

	   
		$MAILSEND = @mail($Email, $SUBJECT, $BODY, $HEADER);
		$_SESSION['sess_mess'] =  "Report Added";
		header("location:".$_SERVER['HTTP_REFERER']);
		exit;
        }
		else
		{
		$_SESSION['sess_mess'] =  "Fields Required";
		header("location:".$_SERVER['HTTP_REFERER']);
		exit;
		}
}	
?>
<script language="javascript">
function trim(str) {
return str.replace(/^\s+|\s+$/g,"");
}
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



function getCommentValueNewPost()
{
var commentedNewPostValue = document.chFrm2.Lyrics.value;
document.getElementById('Lyrics').value = trim(commentedNewPostValue);
document.getElementById('post_button').disabled=false;
$('#post_button').css({'color' : '#FFF', 'cursor' : 'pointer'});
}
</script>
<div id="page-wrapper">
  <div class="layoutArea">
    <div class="contentArea">
      <div class="content-box-2">
        <div class="cor_1set-5"></div>
        <div class="cor_1set-6"></div>
        <div class="lftPannel user">
          <div class="vedioPrt">
            <h1>
           
             <a href="<?=SITE_WS_PATH?>/<?=$_SESSION['SESS_ID']?>/<?=$_SESSION['SESS_FIRST_NAME']?>">
              <?php if(file_exists("products/user_image/$colles[Photo]") && $colles['Photo']!='') { ?>
              <img src="products/user_image/<?php echo $colles['Photo']; ?>" border="0" width="33" height="33" />
              <?php } else { ?>
              <img src="images/user_big.png" border="0" width="33" height="33" />
              <?php } ?>
              </a>
              <span>
              <?=ucfirst($colles['First_Name'])?>
              sounds overview</span> </h1>
             
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
                flashvars.settingsXmlPath = "settings<?=$p_id?>.xml";
                flashvars.contentXmlPath = "content<?=$p_id?>.xml";
                
                // change here below the width and height of the player. It must match the width and height you have set in the xml file
                var embedWidth = "640";
                var embedHeight = "360";
                
                swfobject.embedSWF("player.swf", "flashAlternativeContent", embedWidth, embedHeight, "9.0.0", "js/expressInstall.swf", flashvars, params, attributes);
                </script>
                <a href="http://www.adobe.com/go/getflashplayer">
                <img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" />
                </a>
                </div>
                <?php  } elseif(strtolower($pext)=='avi' || strtolower($pext)=='3gp' || strtolower($pext)=='flv' || strtolower($pext)=='mkv' || strtolower($pext)=='mov' || strtolower($pext)=='mp4' || strtolower($pext)=='mpeg' || strtolower($pext)=='wmv' ) { ?>
                <div class="player">
                <script type="text/javascript">
                AC_FL_RunContent( 'codebase','http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0','width','640','height','360','src','pro_video_player1.2.2','quality','high','bgcolor','#000000','allowscriptaccess','sameDomain','allowfullscreen','true','pluginspage','http://www.macromedia.com/go/getflashplayer','flashvars','xmlPath=video<?=$p_id?>.xml','movie','pro_video_player1.2.2' ); //end AC code
                </script><noscript><object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="640" height="360">
                <param name="allowScriptAccess" value="sameDomain" />
                <param name="allowFullScreen" value="true" />
                <param name="movie" value="pro_video_player1.2.2.swf" />
                <param name="quality" value="high" />
                <param name="bgcolor" value="#000000" />
                <param name="flashvars" value="xmlPath=video<?=$p_id?>.xml">
                <embed src="pro_video_player1.2.2.swf" width="640" height="360" quality="high" bgcolor="#000000" allowScriptAccess="sameDomain" allowFullScreen="true" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" flashvars="xmlPath=video<?=$p_id?>.xml" />          
                </object></noscript>
                
                </div>
                <?php }  ?>
              
            
          </div>
         
          <div class="rgtPannel history">
          <h1>HISTORY POSTS :
            <?=mysql_num_rows($result_history_post)?>
          </h1>
          <div class="scroller">
            <?php
					$ct=1;
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
                   
					
					function getCommentValue<?=$ct?>()
					{
					var commentedValue = document.getElementById('lyrics_value<?=$ct?>').innerHTML;
					document.getElementById('Lyrics').value = trim(commentedValue);
					document.getElementById('post_button').disabled=false;
	                $('#post_button').css({'color' : '#FFF', 'cursor' : 'pointer'});
					}
                                       
                    </script>
            <div class="postBlock" >
              <p id="lyrics_value<?=$ct?>">
               <?=stripslashes($colles_history_post['Lyrics']);?>
              </p>
              <strong>
              <?=ucfirst($m_name)?>
              </strong> <span>
              <?=$diff;?>
              </span>
              <p> <b>use this</b> <span >
              
                <input type="button" name="yes" value="yes" class="yesBtn" onclick="return getCommentValue<?=$ct?>();" />
                </span> </p>
            </div>
            
            <div class="popupConfirm scroll" style="display:none;"  id="view_post_lyrics_thumb_result2<?=$ct?>">
            <div id="view_post_lyrics_thumb_result<?=$ct?>"></div>
			</div>
            <?php
					$ct++;
					}
					?>
          </div>
        </div>
        
         <div class="popupConfirm" style="display:none;" id="report">
				<div>
                    <span  align="center">
					<h2>Report</h2>
					<p></p>
					<form id="frmReport" name="frmReport"  method="post" action="">
                    <table width="90%" cellspacing="2" cellpadding="2">
                    
                    
                    
                    <?php if($_SESSION["sess_mess"]!='') { ?>
                    <div style="color:#757575; padding: 0 0 0 26%;"><?=$_SESSION["sess_mess"]?> <? $_SESSION["sess_mess"]='';?></div>
                    <?php } ?>
                    
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
                    <td width="40%"><input type="hidden" name="id" value="<?=$_REQUEST['id']?>" /> </td>
                    <td width="60%"><input name="buttonSubmit" type="submit" value="Report" class="form-button" > <input name="buttonSubmit" type="button" value="Close" class="form-button" onclick="hideStuff('report');showStuff('report_id');" ></td>
                    </tr>
                    
                    </table>  
                    </form>
                    </span>
				</div>
			</div>
         
        <div class="popupConfirm scroll" style="display:none;" id="confirm_id">
            
				<div>
                    <span  align="center" id="view_post_lyrics_result">
					<h2>Wait Confirmation</h2>
					<p>Are you sure you are ready to post your lyrics? You can not edit anymore durning this session.<br />
					   Choose below</p>
					<a href="javascript:void(0);" onclick="return post_lyrics('<?=$typ?>','<?=$_REQUEST['id']?>','<?=$_SESSION['SESS_ID']?>');"><strong>Yes!</strong></a>
					<a href="javascript:void(0);" onclick="hideStuff('confirm_id');" ><span>No! I'm not Ready</span></a>
                    </span>
				</div>
			</div>
        </div>
        <div class="rgtPannel history">
        <?php if($_SESSION['sess_mess']!='') { ?>
        <div><?=$_SESSION['sess_mess']?> <?php $_SESSION['sess_mess']='';?></div>
        <?php } ?>
        <div class="fr">
        <SCRIPT LANGUAGE="JavaScript">
            function textCounter(field,cntfield,maxlimit) {
            if (field.value.length > maxlimit) // if too long...trim it!
            field.value = field.value.substring(0, maxlimit);
            else
            cntfield.value = maxlimit - field.value.length;
            }
            </script>
                <form name="chFrm" method="post" action="">
                
				<h3>Character limit:<span><input readonly type="text" name="remLen1" size="3" maxlength="3" value="1200"> max</span></h3>
				<p style="background:none;">
					
					<textarea rows="2" cols="20" name="Lyrics" style="width:266px; height: 350px; border:1px solid #CCC;"  id="Lyrics" onkeypress="do_active();" onKeyDown="textCounter(document.chFrm.Lyrics,document.chFrm.remLen1,1200)"
onKeyUp="textCounter(document.chFrm.Lyrics,document.chFrm.remLen1,1200)"><?=stripslashes($collesTextLyrics['Lyrics'])?></textarea>
				</p>
				
                   <div class="alignR" style="margin-bottom: 10px;margin-top: 47px;"> 
				   
                    <?php  if($_SESSION['SESS_ACCOUNT_TYPE']=='Artist') { ?>
                    
                    <div class="music-Btn4 scroll1" id="report_id" onclick="showStuff('report');hideStuff('report_id');" >
                       Report
                    </div>
                    <?php } ?>
					<div class="music-Btn4 scroll" name="post" id="post_button" value="Post" onclick="showStuff('confirm_id');" disabled="disabled" style=" color:#999; cursor:text;">
                      
                       <!-- <input type="button" class="scroll" name="post" id="post_button" value="Post" onclick="showStuff('confirm_id');" disabled="disabled" style=" color:#999; cursor:text;" />-->
                       Post Lyrics
                       
                    </div>
                    
                    <div class="music-Btn4"  name="Back" value="Back" onclick="window.location.href='create-session.php?id=<?=$_REQUEST['id']?>'" >
                      
                        Back
                       
                    </div></div>
                    
                    
				
                </form>
        </div>
        
        
        <div class="cl"></div>
        <!--<div class="ads fr"><img src="images/advertisement1.png" alt="" /></div>
        <div class="cl"></div>-->
        <div class="ads fr"><img src="images/advertisement2.png" alt="" /></div>
        <div class="cl"></div>
        </div>
        <div class="cl"></div>
        <div class="cor_1set-3"></div>
        <div class="cor_1set-4"></div>
      </div>
      
    </div>
  </div>
</div>
