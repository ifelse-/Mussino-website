<?php
require_once "config/functions.inc.php"; 
require_once "session.inc.php";

$sql = "SELECT * FROM lyrics_post_audio_master WHERE Member_Account_Id = '".$_REQUEST['id']."'";
$result = mysql_query($sql);
$colles = mysql_fetch_array($result);
$fileName = $colles['Audio_Lyrics_File'];
$filePath = "products/lyrics_file/";
$path = $filePath.$fileName;

if ($fd = @fopen ($path, "rb")) 
{ 
    $fsize = filesize($path); 
    $path_parts = pathinfo($path); 
    $ext = strtolower($path_parts["extension"]); 
	
		
	switch ($ext) { 
	
        case "mp3": $ctype="audio/mpeg";
       		 header("Content-type: audio/mpeg"); 
       		 header("Content-Disposition: attachment; filename=\"".$path_parts["basename"]."\"");
		     break;
		
  		
  		case "wav": $ctype="audio/x-wav";
			header("Content-type: audio/x-wav"); 
			header("Content-Disposition: attachment; filename=\"".$path_parts["basename"]."\"");
			break;
			
	   case "mpeg": $ctype="video/mpeg";
			header("Content-type: video/mpeg"); 
			header("Content-Disposition: attachment; filename=\"".$path_parts["basename"]."\"");
			break;
  		
  		
  		case "mpg": $ctype="video/mpeg"; 
			header("Content-type: video/mpeg");
			header("Content-Disposition: attachment; filename=\"".$path_parts["basename"]."\"");
			break;
  		
		case "mpe": $ctype="video/mpeg";
			header("Content-type: video/mpeg"); 
			header("Content-Disposition: attachment; filename=\"".$path_parts["basename"]."\"");
			break;
		case "mov": $ctype="video/quicktime";
			header("Content-type: video/quicktime"); 
			header("Content-Disposition: attachment; filename=\"".$path_parts["basename"]."\"");
			break;
			
		case "avi": $ctype="video/x-msvideo";
			header("Content-type: video/x-msvideo"); 
			header("Content-Disposition: attachment; filename=\"".$path_parts["basename"]."\"");
			break;
		case "flv": $ctype="video/flv";
			header("Content-type: video/flv"); 
			header("Content-Disposition: attachment; filename=\"".$path_parts["basename"]."\"");
			break;
 		
        default; exit;
        
    } 
	header("Content-type: $type");
	header("Content-length: $fsize"); 
    header("Cache-control: private"); 
    while(!feof($fd)) 
	{ 
        $buffer = fread($fd, 1024*8); 
        echo $buffer; 
    } 

	
}


?>




