<?php 
$sql_product = "SELECT P.Product_Id, P.Member_Account_Id, P.Category_Id, P.Title,P.Royalties,P.Posts, P.Product_Notes, P.Sound, P.Type, P.Image_Name, P.Short_FIle_Name, P.Long_FIle_Name, P.Short_Desc, P.Long_Desc, P.Price,	P.Session_Start_Date, P.Session_End_Date, DATE_FORMAT(P.Session_Start_Date,'%m/%d/%Y %h:%i %p') as StartDate, DATE_FORMAT(P.Session_End_Date,'%m/%d/%Y %h:%i %p') as EndDate, P.Product_Date, P.Status, P.Jack_Pot, P.Jack_Pot_Status FROM product_master P WHERE P.Product_Id='".$_GET['id']."'";
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

#################
$sql_history_post = "SELECT * FROM lyrics_post_master WHERE Status='1' AND Product_Id='".$_GET['id']."'";
$result_history_post = mysql_query($sql_history_post);

$sqlAudio = "SELECT * FROM lyrics_post_audio_master WHERE Status='1' AND Product_Id='".$_GET['id']."' AND Lyrics_Audio_Type='AUDIO'";
$resultAudio = mysql_query($sqlAudio);

$sqlVideo = "SELECT * FROM lyrics_post_audio_master WHERE Status='1' AND Product_Id='".$_GET['id']."' AND Lyrics_Audio_Type='VIDEO'";
$resultVideo = mysql_query($sqlVideo);
#################

$sqlAudioCount = "SELECT COUNT(*) AS CtotalAudio FROM lyrics_post_audio_master WHERE Product_Id='".$_GET['id']."' AND Lyrics_Audio_Type='AUDIO' AND Status=1";
$resAudioCount = mysql_query($sqlAudioCount);
$collesAudioCount = mysql_fetch_array($resAudioCount);
$sqlVideoCount = "SELECT COUNT(*) AS CtotalVideo FROM lyrics_post_audio_master WHERE Product_Id='".$_GET['id']."' AND Lyrics_Audio_Type='VIDEO' AND Status=1";
$resVideoCount = mysql_query($sqlVideoCount);
$collesVideoCount = mysql_fetch_array($resVideoCount);
$sqlTextCount = "SELECT COUNT(*) AS CtotalText FROM lyrics_post_master WHERE Product_Id='".$_GET['id']."' AND Status=1";
$resTextCount = mysql_query($sqlTextCount);
$collesTextCount = mysql_fetch_array($resTextCount);

$totalPosts = $collesAudioCount['CtotalAudio'] + $collesVideoCount['CtotalVideo'] + $collesTextCount['CtotalText'];


# $colles_Product['Member_Account_Id']

$sql_mix_other = "SELECT * FROM product_master WHERE Status='1' AND Type=1 AND Product_Id !='".$_GET['id']."' AND Member_Account_Id ='".$_SESSION['SESS_ID']."' AND Session_End_Date >= CURDATE() ORDER BY Product_Id DESC LIMIT 0,5";
$result_mix_other = mysql_query($sql_mix_other);

function get_time_difference( $start, $end )
{
    $uts['start']      =    strtotime( $start );
    $uts['end']        =    strtotime( $end );
    if( $uts['start']!==-1 && $uts['end']!==-1 )
    {
        if( $uts['end'] >= $uts['start'] )
        {
            $diff    =    $uts['end'] - $uts['start'];
            if( $days=intval((floor($diff/86400))) )
                $diff = $diff % 86400;
            if( $hours=intval((floor($diff/3600))) )
                $diff = $diff % 3600;
            if( $minutes=intval((floor($diff/60))) )
                $diff = $diff % 60;
            $diff    =    intval( $diff );            
            return( array('days'=>$days, 'hours'=>$hours, 'minutes'=>$minutes, 'seconds'=>$diff) );
        }
        else
        {
            trigger_error( "Ending date/time is earlier than the start date/time", E_USER_WARNING );
        }
    }
    else
    {
        trigger_error( "Invalid date/time data detected", E_USER_WARNING );
    }
    return( false );
}
$sql_notes = "SELECT sum(a.No_Of_Package) as notesTotal FROM package_master a LEFT JOIN package_history_master b ON (a.Package_Id=b.Package_Id)
              WHERE a.Status='1' AND b.Status='1' AND b.Member_Account_Id='".$_SESSION['SESS_ID']."'";
$result_notes = mysql_query($sql_notes);
if(mysql_num_rows($result_notes)>0)
{
    $colles_notes = mysql_fetch_array($result_notes);
	$NOTES = $colles_notes['notesTotal'];
	$sql_bank_notes = "SELECT sum(Notes_Value) as bankNotesTotal FROM my_bank WHERE From_Member_Account_Id='".$_SESSION['SESS_ID']."'";
	$result_bank_notes = mysql_query($sql_bank_notes);
	$colles_bank_notes = mysql_fetch_array($result_bank_notes);
	if(mysql_num_rows($result_bank_notes)>0)
	{
	$BANK_NOTES = $colles_bank_notes['bankNotesTotal'];
	}
	else
	{
	$BANK_NOTES = 0;
	}
	$TOTAL_NOTES = $NOTES-$BANK_NOTES;
}
else
{
   $TOTAL_NOTES = 0;
}
					  
$session_validate = "SELECT Member_Account_Id FROM product_master WHERE Status=1 AND Session_End_Date >= CURDATE() GROUP BY Member_Account_Id";
$result_validate = mysql_query($session_validate);
$session_num_validate = mysql_num_rows($result_validate);

### Audio File Submit

if($_POST['AudioButtonSubmit']=='Submit')
{
	
	$sql_file = "SELECT * FROM lyrics_post_audio_master WHERE Member_Account_Id='".$_SESSION['SESS_ID']."' AND Product_Id ='".$_REQUEST['id']."'";
	$result_file = mysql_query($sql_file);
    $colles_file = mysql_fetch_array($result_file);
	
	####################
					
	$sql_notes = "SELECT sum(b.Membership_No) as postTotal, a.Membership_Upgrade_Id, Membership_Package_Name FROM membership_artist_upgrade_master a LEFT JOIN membership_artist_upgrade_history_master b ON (a.Membership_Upgrade_Id=b.Membership_Upgrade_Id)
	WHERE a.Status='1' AND b.Status='1' AND b.Member_Account_Id='".$_SESSION['SESS_ID']."'";
	$result_notes = mysql_query($sql_notes);
	if(mysql_num_rows($result_notes)>0)
	{
	$colles_notes = mysql_fetch_array($result_notes);
	$PACKAGE = $colles_notes['Membership_Package_Name'];
	$PACKAGE_ID = $colles_notes['Membership_Upgrade_Id'];
	$POST_TOTAL = $colles_notes['postTotal'];
	$TOTAL_POST = $POST_TOTAL;
	}
	else
	{
	$PACKAGE = 0;
	$PACKAGE_ID = 0;
	$TOTAL_POST = 0;
	}
	
				
	$sqlAudioCount = "SELECT COUNT(*) AS CtotalAudio FROM lyrics_post_audio_master WHERE Member_Account_Id='".$_SESSION['SESS_ID']."' AND Lyrics_Audio_Type='AUDIO' AND Status=1";
	$resAudioCount = mysql_query($sqlAudioCount);
	$collesAudioCount = mysql_fetch_array($resAudioCount);
	
	####################
	
	if(mysql_num_rows($result_file)>0)
	{
	
	        if(!empty($_FILES['Audio_File']['name']))
			{
	        list($getname,$getext) = explode(".",$_FILES['Audio_File']['name']);
			}
	        if(trim($PACKAGE_ID)=='2' && $collesAudioCount['CtotalAudio'] < $TOTAL_POST && (strtolower($getext)=='mp3' || strtolower($getext)=='wma'))
			{
				//die(a);
				if(!empty($_FILES['Audio_File']['name']))
				{
				
					if($colles_file['Audio_Lyrics_File']!='')
					{
					$image_name = $colles_file['Audio_Lyrics_File'];
					$path = "products/lyrics_file/";
					$target_path = $path.$image_name;
					unlink($target_path);
					}
				
				
				
					list($getname,$getext) = explode(".",$_FILES['Audio_File']['name']);
					$lastId = $_REQUEST['id'];
					$create_name = "Audio_Lyrics_".$lastId;
					$new_filename = $create_name.".".$getext;
					$upload_path = "products/lyrics_file/".$new_filename;
					
				
					move_uploaded_file($_FILES['Audio_File']['tmp_name'],$upload_path);
				
				
					$sql_update = "UPDATE lyrics_post_audio_master SET Audio_Lyrics_File = '$new_filename', Archive_Content='".addslashes($_REQUEST['Archive_Content'])."', Lyrics_Audio_Type = 'AUDIO' WHERE Member_Account_Id = '".$_SESSION['SESS_ID']."'  AND Product_Id ='".$_REQUEST['id']."' "; 
					mysql_query($sql_update);
						
				}
				$_SESSION['sess_mess'] =  "<span style='#006600;'>AUDIO FILE UPDATED SUCCESSFULLY</span>";
				header("location:".$_SERVER['HTTP_REFERER']);
				exit;
				}
			elseif(trim($PACKAGE_ID)=='4')
			{
				if(!empty($_FILES['Audio_File']['name']))
				{
				
					if($colles_file['Audio_Lyrics_File']!='')
					{
					$image_name = $colles_file['Audio_Lyrics_File'];
					$path = "products/lyrics_file/";
					$target_path = $path.$image_name;
					unlink($target_path);
					}
				
				
				
					list($getname,$getext) = explode(".",$_FILES['Audio_File']['name']);
					$lastId = $_REQUEST['id'];
					$create_name = "Audio_Lyrics_".$lastId;
					$new_filename = $create_name.".".$getext;
					$upload_path = "products/lyrics_file/".$new_filename;
					
					
					move_uploaded_file($_FILES['Audio_File']['tmp_name'],$upload_path);
					
				
					$sql_update = "UPDATE lyrics_post_audio_master SET Audio_Lyrics_File = '$new_filename', Archive_Content='".addslashes($_REQUEST['Archive_Content'])."', Lyrics_Audio_Type = 'AUDIO' WHERE Member_Account_Id = '".$_SESSION['SESS_ID']."'  AND Product_Id ='".$_REQUEST['id']."' "; 
					mysql_query($sql_update);
						
				}
				$_SESSION['sess_mess'] =  "<span style='#006600;'>AUDIO FILE UPDATED SUCCESSFULLY</span>";
				header("location:".$_SERVER['HTTP_REFERER']);
				exit;
			}
			else
			{
				$_SESSION['sess_mess'] =  "<span style='color:#990000;'>YOU HAVE NOT AUTHORISE TO ADDED AUDIO FILES PLEASE UPGRADE YOUR PLAN.</span>";
				header("location: artist-membership-upgrade.php");
				exit;
			}
	}
	else
	{
			
	        if(!empty($_FILES['Audio_File']['name']))
			{
					list($getname,$getext) = explode(".",$_FILES['Audio_File']['name']);
					$lastId = $_REQUEST['id'];
					$create_name = "Audio_Lyrics_".$lastId;
					$new_filename = $create_name.".".$getext;
					$upload_path = "products/lyrics_file/".$new_filename;
			
					if(trim($PACKAGE_ID)=='2'  && $collesAudioCount['CtotalAudio'] < $TOTAL_POST && (strtolower($getext)=='mp3' || strtolower($getext)=='wma' || strtolower($getext)=='wav'))
					{
						move_uploaded_file($_FILES['Audio_File']['tmp_name'],$upload_path);
					$sql_insert = "INSERT INTO lyrics_post_audio_master SET 
								   Audio_Lyrics_File = '$new_filename', 
								   Member_Account_Id = '".$_SESSION['SESS_ID']."', 
								   Product_Id ='".$_REQUEST['id']."',
								   Archive_Content='".addslashes($_REQUEST['Archive_Content'])."',
								   Lyrics_Audio_Type = 'AUDIO',
								   Lyrics_Audio_Date=now(),
								   Status='1'"; 
					mysql_query($sql_insert);
					$_SESSION['sess_mess'] =  "<span style='#006600;'>AUDIO FILE ADDED SUCCESSFULLY</span>";
					header("location:".$_SERVER['HTTP_REFERER']);
					exit;
					}
					elseif(trim($PACKAGE_ID)=='4')
					{
						move_uploaded_file($_FILES['Audio_File']['tmp_name'],$upload_path);
					$sql_insert = "INSERT INTO lyrics_post_audio_master SET 
								   Audio_Lyrics_File = '$new_filename', 
								   Member_Account_Id = '".$_SESSION['SESS_ID']."', 
								   Product_Id ='".$_REQUEST['id']."',
								   Archive_Content='".addslashes($_REQUEST['Archive_Content'])."',
								   Lyrics_Audio_Type = 'AUDIO',
								   Lyrics_Audio_Date=now(),
								   Status='1'"; 
					mysql_query($sql_insert);
					$_SESSION['sess_mess'] =  "<span style='#006600;'>FILE ADDED SUCCESSFULLY</span>";
					header("location:".$_SERVER['HTTP_REFERER']);
						exit;
					}
					else
					{
						$_SESSION['sess_mess'] =  "<span style='color:#990000;'>YOU HAVE NOT AUTHORISE TO ADDED AUDIO FILES PLEASE UPGRADE YOUR PLAN.</span>";
						header("location: artist-membership-upgrade.php");
						exit;
					}
			}
			else
			{
			$_SESSION['sess_mess'] =  "<span style='color:#990000;'>FILE IS EMPTY</span>";
			header("location:".$_SERVER['HTTP_REFERER']);
			exit;
			}
			
	}
	
	

}

# Video file submit

if($_POST['VideoButtonSubmit']=='Submit')
{
	
	$sql_file = "SELECT * FROM lyrics_post_audio_master WHERE Member_Account_Id='".$_SESSION['SESS_ID']."' AND Product_Id ='".$_REQUEST['id']."'";
	$result_file = mysql_query($sql_file);
    $colles_file = mysql_fetch_array($result_file);
	
	####################
					
	$sql_notes = "SELECT sum(b.Membership_No) as postTotal, a.Membership_Upgrade_Id, Membership_Package_Name FROM membership_artist_upgrade_master a LEFT JOIN membership_artist_upgrade_history_master b ON (a.Membership_Upgrade_Id=b.Membership_Upgrade_Id)
	WHERE a.Status='1' AND b.Status='1' AND b.Member_Account_Id='".$_SESSION['SESS_ID']."'";
	$result_notes = mysql_query($sql_notes);
	if(mysql_num_rows($result_notes)>0)
	{
	$colles_notes = mysql_fetch_array($result_notes);
	$PACKAGE = $colles_notes['Membership_Package_Name'];
	$PACKAGE_ID = $colles_notes['Membership_Upgrade_Id'];
	$POST_TOTAL = $colles_notes['postTotal'];
	$TOTAL_POST = $POST_TOTAL;
	}
	else
	{
	$PACKAGE = 0;
	$PACKAGE_ID = 0;
	$TOTAL_POST = 0;
	}
	
	$sqlVideoCount = "SELECT COUNT(*) AS CtotalVideo FROM lyrics_post_audio_master WHERE Member_Account_Id='".$_SESSION['SESS_ID']."' AND Lyrics_Audio_Type='VIDEO' AND Status=1";
	$resVideoCount = mysql_query($sqlVideoCount);
	$collesVideoCount = mysql_fetch_array($resVideoCount);
			
	####################
	
	if(mysql_num_rows($result_file)>0)
	{
			if(!empty($_FILES['Video_File']['name']))
			{
	        list($getname,$getext) = explode(".",$_FILES['Video_File']['name']);
			}
			
			if(trim($PACKAGE_ID)=='3' && $collesVideoCount['CtotalVideo'] < $TOTAL_POST && (strtolower($getext)=='flv' || strtolower($getext)=='avi' || strtolower($getext)=='3gp' || strtolower($getext)=='mkv' || strtolower($getext)=='mov' || strtolower($getext)=='mp4' || strtolower($getext)=='wmv' || strtolower($getext)=='mpeg'))
			{
			
			
			if(!empty($_FILES['Video_File']['name']))
			{
			
			if($colles_file['Audio_Lyrics_File']!='')
			{
			$image_name = $colles_file['Audio_Lyrics_File'];
			$path = "products/lyrics_file/";
			$target_path = $path.$image_name;
			unlink($target_path);
			}
			
			
			
			list($getname,$getext) = explode(".",$_FILES['Video_File']['name']);
			$lastId = $_REQUEST['id'];
			$create_name = "Video_Lyrics_".$lastId;
			$new_filename = $create_name.".".$getext;
			$upload_path = "products/lyrics_file/".$new_filename;
			
			
			move_uploaded_file($_FILES['Video_File']['tmp_name'],$upload_path);
			
			
			$sql_update = "UPDATE lyrics_post_audio_master SET Audio_Lyrics_File = '$new_filename', Archive_Content='".addslashes($_REQUEST['Archive_Content'])."', Lyrics_Audio_Type = 'VIDEO' WHERE Member_Account_Id = '".$_SESSION['SESS_ID']."'  AND Product_Id ='".$_REQUEST['id']."' "; 
			mysql_query($sql_update);
			$_SESSION['sess_mess'] =  "<span style='#006600;'>VIDEO FILE UPDATED SUCCESSFULLY</span>";
			header("location:".$_SERVER['HTTP_REFERER']);
			exit;
			}
			}
			elseif(trim($PACKAGE_ID)=='4')
			{
			if(!empty($_FILES['Video_File']['name']))
			{
			
			if($colles_file['Audio_Lyrics_File']!='')
			{
			$image_name = $colles_file['Audio_Lyrics_File'];
			$path = "products/lyrics_file/";
			$target_path = $path.$image_name;
			unlink($target_path);
			}
			
			
			
			list($getname,$getext) = explode(".",$_FILES['Video_File']['name']);
			$lastId = $_REQUEST['id'];
			$create_name = "Video_Lyrics_".$lastId;
			$new_filename = $create_name.".".$getext;
			$upload_path = "products/lyrics_file/".$new_filename;
			
			
			move_uploaded_file($_FILES['Video_File']['tmp_name'],$upload_path);
			
			
			$sql_update = "UPDATE lyrics_post_audio_master SET Audio_Lyrics_File = '$new_filename', Archive_Content='".addslashes($_REQUEST['Archive_Content'])."', Lyrics_Audio_Type = 'VIDEO' WHERE Member_Account_Id = '".$_SESSION['SESS_ID']."'  AND Product_Id ='".$_REQUEST['id']."' "; 
			mysql_query($sql_update);
			$_SESSION['sess_mess'] =  "<span style='#006600;'>VIDEO FILE UPDATED SUCCESSFULLY</span>";
			header("location:".$_SERVER['HTTP_REFERER']);
			exit;
			}
			
			}
			else
			{
			$_SESSION['sess_mess'] =  "<span style='color:#990000;'>YOU HAVE NOT AUTHORISE TO ADDED VIDEO FILES PLEASE UPGRADE YOUR PLAN.</span>";
			header("location:artist-membership-upgrade.php");
			exit;
			}	
			
	}
	else
	{
			if(!empty($_FILES['Video_File']['name']))
			{
			list($getname,$getext) = explode(".",$_FILES['Video_File']['name']);
			$lastId = $_REQUEST['id'];
			$create_name = "Video_Lyrics_".$lastId;
			$new_filename = $create_name.".".$getext;
			$upload_path = "products/lyrics_file/".$new_filename;
			
			if(trim($PACKAGE_ID)=='3'  && $collesVideoCount['CtotalVideo'] < $TOTAL_POST && (strtolower($getext)=='flv' || strtolower($getext)=='avi' || strtolower($getext)=='3gp' || strtolower($getext)=='mkv' || strtolower($getext)=='mov' || strtolower($getext)=='mp4' || strtolower($getext)=='wmv' || strtolower($getext)=='mpeg'))
			{
			
			move_uploaded_file($_FILES['Video_File']['tmp_name'],$upload_path);
			$sql_insert = "INSERT INTO lyrics_post_audio_master SET 
			               Audio_Lyrics_File = '$new_filename', 
						   Member_Account_Id = '".$_SESSION['SESS_ID']."', 
						   Product_Id ='".$_REQUEST['id']."',
						   Archive_Content='".addslashes($_REQUEST['Archive_Content'])."',
						   Lyrics_Audio_Type = 'VIDEO',
						   Lyrics_Audio_Date=now(),
						   Status='1'"; 
			mysql_query($sql_insert);
			$_SESSION['sess_mess'] =  "<span style='#006600;'>VIDEO FILE ADDED SUCCESSFULLY</span>";
			header("location:".$_SERVER['HTTP_REFERER']);
			exit;
			}
			elseif(trim($PACKAGE_ID)=='4')
			{
			move_uploaded_file($_FILES['Video_File']['tmp_name'],$upload_path);
			$sql_insert = "INSERT INTO lyrics_post_audio_master SET 
			               Audio_Lyrics_File = '$new_filename', 
						   Member_Account_Id = '".$_SESSION['SESS_ID']."', 
						   Product_Id ='".$_REQUEST['id']."',
						   Archive_Content='".addslashes($_REQUEST['Archive_Content'])."',
						   Lyrics_Audio_Type = 'VIDEO',
						   Lyrics_Audio_Date=now(),
						   Status='1'"; 
			mysql_query($sql_insert);
			$_SESSION['sess_mess'] =  "<span style='#006600;'>FILE ADDED SUCCESSFULLY</span>";
			header("location:".$_SERVER['HTTP_REFERER']);
			exit;
			}
			else
			{
			$_SESSION['sess_mess'] =  "<span style='color:#990000;'>YOU HAVE NOT AUTHORISE TO ADDED VIDEO FILES PLEASE UPGRADE YOUR PLAN.</span>";
			header("location:artist-membership-upgrade.php");
			exit;
			}
			}
			else
			{
			$_SESSION['sess_mess'] =  "<span style='color:#990000;'>FILE IS EMPTY</span>";
			header("location:".$_SERVER['HTTP_REFERER']);
			exit;
			}
			
	}
	
	

}

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
		//$HEADER .= "Reply-To: $Email <$Email>\n";
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
function validateFileExtensionAudio(fld) 
	{

		if(!/(\.wma|\.mp3|\.WMA|\.MP3|\.WAV|\.wav)$/i.test(fld.value)) 
		{
		alert("Invalid Audio File Type.");
		fld.form.reset();
		fld.focus();
		return false;
		}
		return true;
	}
	
function validateFileExtensionVideo(fld) 
	{

		if(!/(\.avi|\.AVI|\.3gp|\.3GB|\.flv|\.FLV|\.mkv|\.MKV|\.mov|\.MOV|\.mp4|\.MP4|\.wmv|\.mpeg|\.MPEG|\.WMV|\.WAV|\.wav)$/i.test(fld.value)) 
		{
		alert("Invalid Video File Type.");
		fld.form.reset();
		fld.focus();
		return false;
		}
		return true;
	}
	
function Audio_Submitsite_Form(frmUploadAudio) 
{
	if(frmUploadAudio.Audio_File.value == "") 
	{
		alert("\n PLEASE SELECT AUDIO FILE")
		frmUploadAudio.Audio_File.focus();
		return false;
	}
	else if(frmUploadAudio.Archive_Content.value == "")
	{
		alert("\n PLEASE ENTER LYRICS")
		frmUploadAudio.Archive_Content.focus();
		return false;
	}
		
	
} 
	
function Video_Submitsite_Form(frmUploadVideo) 
{
	if (frmUploadVideo.Video_File.value == "") 
	{
		alert("\n PLEASE SELECT VIDEO FILE")
		frmUploadVideo.Video_File.focus();
		return false;
	}
	else if(frmUploadVideo.Archive_Content.value == "")
	{
		alert("\n PLEASE ENTER LYRICS")
		frmUploadVideo.Archive_Content.focus();
		return false;
	}
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

</script>
<?php /*?><?php include_once("howto/artist_howto_b.php")?><?php */?>
<div id="page-wrapper">
	<div class="layoutArea">
		
		<div class="contentArea">
        <div class="content-box-2">
        <div class="cor_1set-5"></div>
        <div class="cor_1set-6"></div>
			<div class="lftPannel">
				<div class="vedioPrt">
					<h1><?=stripslashes($colles_Product['Title'])?></h1>
                    <?php  if(strtolower($pext)=='mp3' || strtolower($pext)=='wma') { ?>
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
                    flashvars.settingsXmlPath = "settings_sm.xml";
                    flashvars.contentXmlPath = "content.xml";
                    
                    // change here below the width and height of the player. It must match the width and height you have set in the xml file
                    var embedWidth = "360";
                    var embedHeight = "270";
                    
                    swfobject.embedSWF("player.swf", "flashAlternativeContent", embedWidth, embedHeight, "9.0.0", "js/expressInstall.swf", flashvars, params, attributes);
                    </script>
                     <a href="http://www.adobe.com/go/getflashplayer">
				     <img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" />
			         </a>
                     </div>
                     <?php  } elseif(strtolower($pext)=='avi' || strtolower($pext)=='3gp' || strtolower($pext)=='flv' || strtolower($pext)=='mkv' || strtolower($pext)=='mov' || strtolower($pext)=='mp4' || strtolower($pext)=='mpeg' || strtolower($pext)=='wmv' ) { ?>
                    <div class="player">
                    <script type="text/javascript">
                    AC_FL_RunContent( 'codebase','http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0','width','360','height','270','src','pro_video_player1.2.2','quality','high','bgcolor','#000000','allowscriptaccess','sameDomain','allowfullscreen','true','pluginspage','http://www.macromedia.com/go/getflashplayer','flashvars','xmlPath=video.xml','movie','pro_video_player1.2.2' ); //end AC code
                    </script><noscript><object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="360" height="270">
                    <param name="allowScriptAccess" value="sameDomain" />
                    <param name="allowFullScreen" value="true" />
                    <param name="movie" value="pro_video_player1.2.2.swf" />
                    <param name="quality" value="high" />
                    <param name="bgcolor" value="#000000" />
                    <param name="flashvars" value="xmlPath=video.xml">
                    <embed src="pro_video_player1.2.2.swf" width="360" height="270"  quality="high" bgcolor="#000000" allowScriptAccess="sameDomain" allowFullScreen="true" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" flashvars="xmlPath=video.xml" />          
                    </object></noscript>
                    
                    </div>
                     <?php }  ?>
				</div>
				<div class="cl"></div>
                
                
                <div class="">
                <strong>Studio Booth:</strong> Welcome to the recording session area. Above you will see a media player with the track and details below. All lyrics posted in the notebook on the right, will be copywriting and dated under you profile account.
                </div>
                
                <?php if(mysql_num_rows($result_mix_other)>0) { ?>
                <div class="moreMix">
					<h3>More Form <?=stripslashes(ucfirst(Get_Single_Field("member_account_master","First_Name","Member_Account_Id","$colles_Product[Member_Account_Id]")))?></h3>
					<ul>
                    
						<?php
						while($colles_mix_master = mysql_fetch_array($result_mix_other))
						{
						?>
                        <?php if(file_exists("products/product_image/$colles_mix_master[Image_Name]") && $colles_mix_master['Image_Name']!='') { ?>
						<li>
                        <a href="<?=SITE_WS_PATH?>/<?=trim($colles_Product['Member_Account_Id'])?>/<?=ucfirst(stripslashes(Get_Single_Field("member_account_master","First_Name","Member_Account_Id","$colles_Product[Member_Account_Id]")))?>" target="_blank"><img src="products/product_image/<?php echo $colles_mix_master['Image_Name']; ?>" border="0" width="54" height="41" alt="<?=stripslashes($colles_mix_master['Title'])?>"/></a></li>
                        <?php } else { ?>
                        <li><a href="<?=SITE_WS_PATH?>/<?=trim($colles_Product['Member_Account_Id'])?>/<?=ucfirst(stripslashes(Get_Single_Field("member_account_master","First_Name","Member_Account_Id","$colles_Product[Member_Account_Id]")))?>" target="_blank"><img src="images/no-image.gif" border="0" width="54" height="41" alt="<?=stripslashes($colles['Title'])?>"/> </a></li>
						<?php
						}
						}
						?>
                        <?php
						/*while($colles_mix_master = mysql_fetch_array($result_mix_other))
						{
						?>
                        <?php if(file_exists("products/product_image/$colles_mix_master[Image_Name]") && $colles_mix_master['Image_Name']!='') { ?>
						<li><a href="create-session.php?id=<?=$colles_mix_master['Product_Id']?>"><img src="products/product_image/<?php echo $colles_mix_master['Image_Name']; ?>" border="0" width="54" height="41" alt="<?=stripslashes($colles_mix_master['Title'])?>"/></a></li>
                        <?php } else { ?>
                        <li><a href="create-session.php?id=<?=$colles_mix_master['Product_Id']?>"><img src="images/no-image.gif" border="0" width="54" height="41" alt="<?=stripslashes($colles['Title'])?>"/> </a></li>
						<?php
						}
						}*/
						?>
                       
					</ul>
                    <div class="cl"></div>
                    
				</div>
                <div class="cl"></div>
                <?php } ?>
                
               
                
                
                <div style="padding-left:518px; top:465px; position:absolute;">
               
                 <?php if(mysql_num_rows($resultMemberShip)==0) { ?>
                <div class="gray-btn-2">
                <a href="artist-membership-upgrade.php">Download Now</a>
                </div>
                <?php } else { ?>
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
                function downloadRequest(){ 
	
                 document.getElementById('download_frm_id').innerHTML ='<img src="<?=SITE_WS_PATH?>/images/loading.gif" alt="" />';
		         if(document.frmDownload.rights.checked==true)
				 {
	             var rights = document.frmDownload.rights.value;
				 }
				 else
				 {
				  var rights = 0;
				 } 
	
	
				
				httpobj.open('get',"<?=SITE_WS_PATH?>/ajax-download.php?rights="+rights);
				httpobj.onreadystatechange	= handleDownloadResponse;
				httpobj.send("");

				}
				function handleDownloadResponse(){
				
					 if(httpobj.readyState==4)
					 {
						 var text = httpobj.responseText;
						 if(text=='done')
						 {
						 location.replace("session-download.php?id=<?=$colles_Product['Product_Id']?>");
						 window.setTimeout(function(){location.replace('<?=$urls?>');}, 2000);
						 }
						 else
						 {
						 document.getElementById('download_frm_id').innerHTML = text;
						 }
					 }
				}
				</script>
                <div class="gray-btn-2">
                <a id="variousDownload" href="#download_id">Download Now</a>
                <div style="display: none;">
                    <div id="download_id" style="width:300px;height:76px;">
                        <div style="padding: 5px 0 0 76px; background-color:#FFF;">
                        <form id="frmDownload" name="frmDownload" method="post" action="">
                        <ul>
                            <li  id="download_frm_id" style="padding: 5px 0 5px 0;"></li>
                            <li>
                                <ul>
                                    <li><input type="checkbox" name="rights" value="1" class="input-text" onkeypress="if(event.keyCode==13) {return downloadRequest();}" /> I accept to legal rights</li>
                                </ul>
                            </li>
                            
                            <li>
                                <ul class="login">
                                    <li>&nbsp;</li>
                                    <li><input class="button" name="buttonSubmit" type="button" value="Download" onclick="return downloadRequest();" onkeypress="if(event.keyCode==13) {return downloadRequest();}"></li>
                                </ul>
                            </li>
                        </ul>
                    </form>
                        </div>
                    </div>
               </div>
                
                </div>
                <?php } ?>
                </div>
                
                
                <div class="midPannel">
                <?php if($_SESSION['sess_mess']!='') { ?>
                
                <div style="padding: 10px 0 10px 10px; color:#000000; font-size:14px; font-weight:bold;"><?=$_SESSION['sess_mess']?> <?php //$_SESSION['sess_mess']='';?></div>
                <?php } ?>
				<span class="heading timeLeftPro"><img width="27" src="http://mussino.com/images/timer.jpg" align="absmiddle"> <strong>Time Left :</strong></span>
				
				<span>
				<script language="JavaScript">
				
					// This short script gets the date/time from the server and prints it
					var deltaD = (servertimeOBJ.getTime())-(new Date().getTime());
					var clientDate = new Date();
					var serverdate = new Date(clientDate.getTime()+deltaD);
					// At this point serverdate can be used for all date/time references in the rest of the script.
					// The math above corrects its value for the the client's local time offset.
					var hours=serverdate.getHours();
					var minutes=serverdate.getMinutes();
					var seconds=serverdate.getSeconds();
					var dn="AM";
					if (hours>=12){dn="PM";}
					if (hours>12){hours=hours-12;}
					if (hours==0){hours=12;}
					if (minutes<=9){minutes="0"+minutes;}
					var cdate=hours+":"+minutes+" "+dn;
					//document.write(cdate);
				TargetDate<?=$t?> = "<?=$colles_Product['EndDate'];?>";
				
				BackColor<?=$t?> = "none";
				ForeColor<?=$t?> = "#000000";
				CountActive<?=$t?> = true;
				CountStepper<?=$t?> = -1;
				LeadingZero<?=$t?> = true;
				DisplayFormat<?=$t?> = "%%D%% Days, %%H%% Hrs: %%M%% Min: %%S%% Sec";
				FinishMessage<?=$t?> = "Session Closed &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
				
				function calcage<?=$t?>(secs<?=$t?>, num1<?=$t?>, num2<?=$t?>) {
				s<?=$t?> = ((Math.floor(secs<?=$t?>/num1<?=$t?>))%num2<?=$t?>).toString();
				if (LeadingZero<?=$t?> && s<?=$t?>.length < 2)
				s<?=$t?> = "0" + s<?=$t?>;
				return "<b>" + s<?=$t?> + "</b>";
				}
				
				function CountBack<?=$t?>(secs<?=$t?>) {
				if (secs<?=$t?> < 0) {
				document.getElementById("cntdwn<?=$t?>").innerHTML = FinishMessage<?=$t?>;
				
				return;
				}
				DisplayStr<?=$t?> = DisplayFormat<?=$t?>.replace(/%%D%%/g, calcage<?=$t?>(secs<?=$t?>,86400,100000));
				DisplayStr<?=$t?> = DisplayStr<?=$t?>.replace(/%%H%%/g, calcage<?=$t?>(secs<?=$t?>,3600,24));
				DisplayStr<?=$t?> = DisplayStr<?=$t?>.replace(/%%M%%/g, calcage<?=$t?>(secs<?=$t?>,60,60));
				DisplayStr<?=$t?> = DisplayStr<?=$t?>.replace(/%%S%%/g, calcage<?=$t?>(secs<?=$t?>,1,60));
				
				document.getElementById("cntdwn<?=$t?>").innerHTML = DisplayStr<?=$t?>;
				if (CountActive<?=$t?>)
				setTimeout("CountBack<?=$t?>(" + (secs<?=$t?>+CountStepper<?=$t?>) + ")", SetTimeOutPeriod<?=$t?>);
				}
				
				function putspan<?=$t?>(backcolor<?=$t?>, forecolor<?=$t?>) {
				document.write("<span id='cntdwn<?=$t?>' style='background-color:" + backcolor<?=$t?> + 
				"; color:" + forecolor<?=$t?> + "'></span>");
				}
				
				if (typeof(BackColor<?=$t?>)=="undefined")
				BackColor<?=$t?> = "white";
				if (typeof(ForeColor<?=$t?>)=="undefined")
				ForeColor<?=$t?>= "black";
				if (typeof(TargetDate<?=$t?>)=="undefined")
				TargetDate<?=$t?> = "12/31/2020 5:00 AM";
				if (typeof(StartDate<?=$t?>)=="undefined")
				StartDate<?=$t?> = new Date(clientDate.getTime()+deltaD);
				if (typeof(DisplayFormat<?=$t?>)=="undefined")
				DisplayFormat<?=$t?> = "%%D%% Days, %%H%% Hours, %%M%% Minutes, %%S%% Seconds.";
				if (typeof(CountActive<?=$t?>)=="undefined")
				CountActive<?=$t?> = true;
				if (typeof(FinishMessage<?=$t?>)=="undefined")
				FinishMessage<?=$t?> = "";
				if (typeof(CountStepper<?=$t?>)!="number")
				CountStepper<?=$t?> = -1;
				if (typeof(LeadingZero<?=$t?>)=="undefined")
				LeadingZero<?=$t?> = true;
				
				CountStepper<?=$t?> = Math.ceil(CountStepper<?=$t?>);
				if (CountStepper<?=$t?> == 0)
				CountActive<?=$t?> = false;
				var SetTimeOutPeriod<?=$t?> = (Math.abs(CountStepper<?=$t?>)-1)*1000 + 990;
				putspan<?=$t?>(BackColor<?=$t?>, ForeColor<?=$t?>);
				var dthen<?=$t?> = new Date(TargetDate<?=$t?>);
				var dnow<?=$t?> = new Date(clientDate.getTime()+deltaD);
				if(CountStepper<?=$t?>>0)
				ddiff<?=$t?> = new Date(dnow<?=$t?>-dthen<?=$t?>);
				else
				ddiff<?=$t?> = new Date(dthen<?=$t?>-dnow<?=$t?>);
				gsecs<?=$t?> = Math.floor(ddiff<?=$t?>.valueOf()/1000);
				CountBack<?=$t?>(gsecs<?=$t?>);
				</script>
				</span>
				<?php //} ?>
              
				<div class="product_info">
                <?php
					$sql_royalties = "SELECT count(*) as totalRoyalties FROM lyrics_post_master WHERE Product_Id='".$colles_Product['Product_Id']."' ";
					$result_royalties = mysql_query($sql_royalties);
					$colles_royalties = mysql_fetch_array($result_royalties);
					
					$TOTAL_ROYALTIES = ($colles_Product['Product_Notes']*$colles_royalties['totalRoyalties'])+$colles_Product['Royalties'];
					
					?>
					<p>
						<span class="heading"><strong>Royalties : </strong><b>$<?=$TOTAL_ROYALTIES;?></b> </span>
						<span class="heading"><strong>Posts : </strong><b><?=$totalPosts>0 ? $totalPosts : $colles_Product['Posts'];?></b></span>
                        <span class="small_heading"><strong>Producer : </strong><a href="<?=SITE_WS_PATH?>/<?=trim($colles_Product['Member_Account_Id'])?>/<?=ucfirst(stripslashes(Get_Single_Field("member_account_master","First_Name","Member_Account_Id","$colles_Product[Member_Account_Id]")))?>" >
						<?=stripslashes(ucfirst(Get_Single_Field("member_account_master","First_Name","Member_Account_Id","$colles_Product[Member_Account_Id]")))?>
                        </a></span>
						<span class="small_heading"><strong>Sound : </strong><a href="session.php?sound=<?=$colles_Product['Sound']?>"><?=Get_Single_Field("sound_type_master","Sound_Type_Name","Sound_Type_Id","$colles_Product[Sound]")?></a></span>
                        <span class="small_heading"><strong>Notes : </strong><?=$colles_Product['Product_Notes']?></span>
						<span class="small_heading"><strong>Genres : </strong><a title="<?=stripslashes(Get_Single_Field("category_master","Category_Name","Category_Id","$colles_Product[Category_Id]"))?>" href="session.php?id=<?=$colles_Product['Category_Id']?>"><?=stripslashes(Get_Single_Field("category_master","Category_Name","Category_Id","$colles_Product[Category_Id]"))?></a></span>
                        <?php $shortDesc = str_replace("<p>", "", $colles_Product['Short_Desc']);  $shortDesc = str_replace("</p>", "", $shortDesc); ?>
						<span class="small_heading"><strong>Sound Detail : </strong><?=stripslashes(substr($shortDesc,0,80)) ?></span>
						<span class="small_heading"><strong>Session Start : </strong><?=get_date_format($colles_Product['Session_Start_Date'])?></span>
                        <span class="small_heading"><strong>Session End : </strong><?=get_date_format($colles_Product['Session_End_Date'])?></span>
					</p>
				</div>
                <?php $typ = $_SESSION['SESS_ACCOUNT_TYPE'];?>
                
                <?php if($collesMemberShip['Membership_Upgrade_Id']=='2' || $collesMemberShip['Membership_Upgrade_Id']=='4') { ?>
                <?php if($typ=='Artist') { ?>
				<?php if(mysql_num_rows($resultMemberShip)==0) { ?>
                <div class="gray-btn-2">
                <a href="artist-membership-upgrade.php">Upload Audio</a>
                </div>
                <?php } else { ?>
               
                <div class="gray-btn-2">
                <a id="variousAudioUpload" href="#audio_upload_id">Upload Audio</a>
                <div style="display: none;">
                    <div id="audio_upload_id" style="width:400px;height:300px; background-color:#FFF;">
                        <div style="padding: 5px 0 0 10px;">
                        <form id="frmUploadAudio" name="frmUploadAudio" method="post" action="" enctype="multipart/form-data" onSubmit="return Audio_Submitsite_Form(frmUploadAudio)">
                        <ul>
                            
                            <li style="padding: 5px 0 5px 0;"></li>
                                    
                                <li>
                                    <ul class="login">
                                        <li><strong>Audio Fil</strong>e </li>
                                        <li><input type="file" name="Audio_File" id="Audio_File" class="input-text" size="30" onChange="validateFileExtensionAudio(this)"><br /><span style="font-family:Arial, Helvetica, sans-serif; font-size:11px; color:#25A6D5;" >[ Only upload mp3 ]</span></li>
                                    </ul>
                                </li>
                                
                                 <li>
                                 <br />
                                    <ul class="login">
                                        <li><strong>Write lyrics here</strong> (optional)</li>
                                        <li><textarea name="Archive_Content" cols="40" rows="6" ></textarea></li>
                                    </ul>
                                </li>
                            
                            <li>
                            <br />
                                <ul class="login">
                                    <li><input type="hidden" name="id" value="<?=$_REQUEST['id']?>" /></li>
                                    <li><input class="button" name="AudioButtonSubmit" type="submit" value="Submit" ></li>
                                </ul>
                            </li>
                        </ul>
                    </form>
                        </div>
                    </div>
               </div>
                
                </div>
                <?php } } }?>
               
                <?php if($collesMemberShip['Membership_Upgrade_Id']=='3' || $collesMemberShip['Membership_Upgrade_Id']=='4') { ?>
                 <?php if($typ=='Artist') { ?>
				<?php if(mysql_num_rows($resultMemberShip)==0) { ?>
                <div class="gray-btn-2">
                <a href="artist-membership-upgrade.php">Upload Video</a>
                </div>
                <?php } else { ?>
                 <div class="gray-btn-2">
                <a id="variousVideoUpload" href="#video_upload_id">Upload Video</a>
                <div style="display: none;">
                    <div id="video_upload_id" style="width:400px;height:300px; background-color:#FFF;">
                        <div style="padding: 5px 0 0 10px;">
                        <form id="frmUploadVideo" name="frmUploadVideo" method="post" action="" enctype="multipart/form-data" onSubmit="return Video_Submitsite_Form(frmUploadVideo)">
                        <ul>
                            
                            <li style="padding: 5px 0 5px 0;"></li>
                                    
                                <li>
                                    <ul class="login">
                                        <li><strong>Video File</strong> </li>
                                        <li><input type="file" name="Video_File" id="Video_File" class="input-text" size="30" onChange="validateFileExtensionVideo(this)"><br /><span style="font-family:Arial, Helvetica, sans-serif; font-size:11px; color:#25A6D5;" >[ Only upload avi, flv, 3gp, mkv, mov, mp4, mpeg, wmv, wav ]</span></li>
                                    </ul>
                                </li>
                                
                                 <li>
                                 <br />
                                    <ul class="login">
                                        <li><strong>Write lyrics here</strong> (optional)</li>
                                        <li><textarea name="Archive_Content" cols="40" rows="6" ></textarea></li>
                                    </ul>
                                </li>
                            <br />
                            <li>
                                <ul class="login">
                                    <li><input type="hidden" name="id" value="<?=$_REQUEST['id']?>" /></li>
                                    <li><input class="button" name="VideoButtonSubmit" type="submit" value="Submit" ></li>
                                </ul>
                            </li>
                        </ul>
                    </form>
                        </div>
                    </div>
               </div>
                
                </div>
                <?php }  } }?>
                              
             	
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
           
            
			<div class="rgtPannel">
            <script type="text/javascript">
            function textCounter(field,cntfield,maxlimit) {
            if (field.value.length > maxlimit) // if too long...trim it!
            field.value = field.value.substring(0, maxlimit);
            else
            cntfield.value = maxlimit - field.value.length;
            }
            </script>
            <form name="chFrm" method="post" action="">
            
            <h3>Character limit:<span><input readonly type="text" name="remLen1" size="3" maxlength="3" value="1600"> max</span>
            <br /><font style=" color:#333; font-size:12px;">Text session 8 - 16 bars only</font>
            </h3>
            
            <p>
                
                <textarea rows="2" cols="20" name="Lyrics" id="Lyrics" onkeypress="do_active();" onKeyDown="textCounter(document.chFrm.Lyrics,document.chFrm.remLen1,1200)"
onKeyUp="textCounter(document.chFrm.Lyrics,document.chFrm.remLen1,1200)"><?=stripslashes($collesTextLyrics['Lyrics'])?></textarea>
            </p>
            <div class="alignR"> 
               <?php if($_SESSION['SESS_ACCOUNT_TYPE']=='Contest Judge')  { ?>
                <div class="gray-btn-1">
                  <span>
                    <span>
                <input type="button" name="history" value="history" onclick="window.location.href='contest-juge-history.php?id=<?=$_REQUEST[id]?>'" />
                </span>
                  </span>
                </div>
                <?php } else if($_SESSION['SESS_ACCOUNT_TYPE']=='Artist') { ?>
                <div class="gray-btn-1">
                  <span>
                    <span>
                <input type="button" name="history" value="Notebook" onmouseover="showStuff('msg_confirm_id');" onmouseout="hideStuff('msg_confirm_id');" onclick="window.location.href='history.php?id=<?=$_REQUEST[id]?>'" />
                </span>
                  </span>
                </div>
                <div class="popupConfirm scroll" style="display:none;" id="msg_confirm_id">
        
                 <div>
                <span  align="left">
                <!--<h2>Info</h2>-->
                <p><?=stripslashes(Get_Single_Field("notebook_msg_master","Notebook_Msg_Details","Notebook_Msg_Id ","1"))?></p>
                
                </span>
            </div>
        </div>
                <div class="gray-btn-1">
                  <span>
                    <span>
                <input class="scroll1" type="button" value="Report" id="report_id" onclick="showStuff('report');hideStuff('report_id');" />
                </span>
                  </span>
                </div>
                <?php } else if($_SESSION['SESS_ACCOUNT_TYPE']=='Musician' || $_SESSION['SESS_ACCOUNT_TYPE']=='Friend') { ?>
               
                <?php } ?>
                <div class="gray-btn-1">
                  <span>
                    <span>
                    <input class="scroll" type="button" name="post" id="post_button" value="Post" onclick="showStuff('confirm_id');" disabled="disabled" style=" color:#999; cursor:text;"  />
                    </span>
                  </span>
                </div></div>
            </form>
            <div class="cl"></div>
            
            <div class="dicBox">
            <form class="fop-searchbox" id="formname" name="formname" method="get" style="border: 6px solid  #999; padding: 10px; width: 260px; font-family: Arial,Helvetica,sans-serif; text-align: center; -moz-border-radius: 15px;
border-radius: 15px;"><img class="fop-logo" src="http://www.macmillandictionary.com/license/default/external/images/macmillandictionary165.gif" alt="Macmillan Online Dictionary" title="Macmillan Online Dictionary" style="margin-bottom: 4px;" width="90"/>
            
            <br />
            <input class="fop-textbox" name="q" type="text" style="border: 1px solid #999; margin-top:5px; padding: 2px; width: 200px; height: 25px; font-size: 12px; color: #666; vertical-align: top;-moz-border-radius: 15px;
border-radius: 15px;"/>
            
            <br /><br />
            
            <input class="" value="Search" type="image" src="images/find.png" alt="Click here to start the search in Macmillan Online Dictionary" title="Click here to start the search in Macmillan Online Dictionary" style="cursor: pointer; vertical-align: top; width:30px; height:30px;"/></form>
            </div>
            
           <!-- <div class="ads fr"><img src="images/advertisement1.png" alt="" /></div>-->
           <!-- <div class="cl"></div>
            <div class="ads fr" style="padding-bottom:10px;"><img src="images/advertisement2.png" alt="" /></div>-->
            <div class="cl"></div>
            
            <div class="rgtPannel history info">
                      <div class="cs-titlehead"><h2><img src="http://mussino.com/images/icon/notebook_icon.jpg" align="absmiddle" /> Current lyricist posts</h2></div>
          <div class="scroller">
            
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
          
            <div class="postBlock" style="float:left; width:290px;">
             
              <div class="user" style="float:left;"> 
                <?php $userImage = Get_Single_Field("member_account_master","Photo","Member_Account_Id","$colles_history_post[Member_Account_Id]"); ?>
                <a class="block fl" href="<?=SITE_WS_PATH?>/<?=trim($colles_history_post['Member_Account_Id'])?>/<?=ucfirst(stripslashes(Get_Single_Field("member_account_master","First_Name","Member_Account_Id","$colles_history_post[Member_Account_Id]")))?>">
                <?php if(file_exists("products/user_image/$userImage") && $userImage!='') { ?>
                <img src="products/user_image/<?php echo $userImage; ?>" border="0" width="43" height="43" />
                <?php } else { ?>
                <img src="images/user_big.png" border="0" width="43" height="43" />
                <?php } ?>
                </a> 
                 </div>

                 <div style="padding-left:65px; padding-right:10px">
                  <?=stripslashes(substr($colles_history_post['Lyrics'],0,120));?> <?php if(strlen($colles_history_post['Lyrics'])>60) { echo '...'; } ?>
                  </div>
                  <div class="cl"></div>
                  <div style=" padding:15px 0 0 55px; font-size:13px; color:#CCC;">
                   <?=$diff;?>
                  </div>
                
              <div class="cl"></div>
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
            
            <div class="postBlock" style="float:left; width:290px;"> 
           
              <div class="user" style="float:left;"> 
                              
                <?php $userImage = Get_Single_Field("member_account_master","Photo","Member_Account_Id","$collesAudio[Member_Account_Id]"); ?>
                <a class="block fl" href="<?=SITE_WS_PATH?>/<?=trim($collesAudio['Member_Account_Id'])?>/<?=ucfirst(stripslashes(Get_Single_Field("member_account_master","First_Name","Member_Account_Id","$collesAudio[Member_Account_Id]")))?>">
                <?php if(file_exists("products/user_image/$userImage") && $userImage!='') { ?>
                <img src="products/user_image/<?php echo $userImage; ?>" border="0" width="43" height="43" />
                <?php } else { ?>
                <img src="images/user_big.png" border="0" width="43" height="43" />
                <?php } ?>
                </a>
                </div>
                
              	<div style="float:left; padding-left:10px;">
                  <a href="artist-preview-player.php?id=<?=$collesAudio['Lyrics_Post_Audio_Id']?>" title="<?='Artist '.ucfirst($m_name).' '.ucfirst(strtolower($collesAudio['Lyrics_Audio_Type'])) .' File'?>" rel="gb_page_center[640, 360]" class="global-box"><img src="images/play-btn.png" alt="" width="33" height="33" align="absmiddle" /> Play Audio</a>
                  </div>
                  <div class="cl"></div>
                  <div style=" padding:15px 0 0 55px; font-size:13px; color:#CCC;">
                   <?=$diff;?>
                  </div>
              <div class="cl"></div>
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
            
            <div class="postBlock" style="float:left; width:290px;"> 
           
              <div class="user" style="float:left;"> 
              
                <?php $userImage = Get_Single_Field("member_account_master","Photo","Member_Account_Id","$collesVideo[Member_Account_Id]"); ?>
                <a class="block fl" href="<?=SITE_WS_PATH?>/<?=trim($collesVideo['Member_Account_Id'])?>/<?=ucfirst(stripslashes(Get_Single_Field("member_account_master","First_Name","Member_Account_Id","$collesVideo[Member_Account_Id]")))?>">
                <?php if(file_exists("products/user_image/$userImage") && $userImage!='') { ?>
                <img src="products/user_image/<?php echo $userImage; ?>" border="0" width="43" height="43" />
                <?php } else { ?>
                <img src="images/user_big.png" border="0" width="43" height="43" />
                <?php } ?>
                </a>
                </div>
                
                <div style="float:left; padding-left:10px;">
                   <a href="artist-preview-player.php?id=<?=$collesVideo['Lyrics_Post_Audio_Id']?>" title="<?='Artist '.ucfirst($m_name).' '.ucfirst(strtolower($collesVideo['Lyrics_Audio_Type'])) .' File'?>" rel="gb_page_center[640, 360]" class="global-box"><img src="images/play-btn.png" alt="" width="33" height="33" align="absmiddle" /> Play Video</a>
                  </div>
                  <div class="cl"></div>
                  <div style=" padding:15px 0 0 55px; font-size:13px; color:#CCC;">
                   <?=$diff;?>
                  </div>
			  <div class="cl"></div>
            </div>
            
            <?php $t++; } }?>
            
            
            
          </div>
         
          
          <div class="cl"></div>
        </div>
			<div class="cl"></div>
			</div>
			<div class="cl"></div>
            <div class="cor_1set-3"></div>
        <div class="cor_1set-4"></div>
      </div>
		<?php include"footer-div.inc.php"; ?>
            
		</div>
	</div>
</div>


