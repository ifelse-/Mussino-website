<?php
require_once "config/functions.inc.php"; 
require_once "session.inc.php";

$sql = "SELECT * FROM product_master WHERE Product_Id = '".$_REQUEST['id']."'";
$result = mysql_query($sql);
$colles = mysql_fetch_array($result);
$fileName = $colles['Short_FIle_Name'];
$filePath = "products/small_video/";
$path = $filePath.$fileName;

if ($fd = @fopen ($path, "rb")) 
{ 
    $fsize = filesize($path); 
    $path_parts = pathinfo($path); 
    $ext = strtolower($path_parts["extension"]); 
	
	if(mysql_num_rows($result)>0)
	{
	$sql_log = "INSERT INTO new_release_file_download_log SET 
				Product_Id = '".$_REQUEST['id']."', 
				Download_Member_Account_Id = '".$_SESSION['SESS_ID']."', 
				Account_Type ='".$_SESSION['SESS_ACCOUNT_TYPE']."',
				Download_File_Size = '".$fsize."',
				Download_Date = now(),
				Status='1'"; 
	mysql_query($sql_log);
	}
	
	
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




