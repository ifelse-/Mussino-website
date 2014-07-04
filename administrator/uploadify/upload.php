<?php
include("../config/functions.inc.php");
include("session.inc.php");
// JQuery File Upload Plugin v1.4.1 by RonnieSan - (C)2009 Ronnie Garcia
if (!empty($_FILES)) {
	$tempFile = $_FILES['Filedata']['tmp_name'];
	$Thumbnail_Name=time()+1;
	$Thumbnail_Name.=basename($_FILES['Filedata']['name']);
	$targetPath = $_SERVER['DOCUMENT_ROOT'] . $_GET['folder'] . '/';
	$targetFile =  str_replace('//','/',$targetPath) . $Thumbnail_Name;
	
	// Uncomment the following line if you want to make the directory if it doesn't exist
	// mkdir(str_replace('//','/',$targetPath), 0755, true);
	
	move_uploaded_file($tempFile,$targetFile);
	
	list($width, $height, $type, $attr) = @getimagesize($uploadfile);
			if($width>$small_image_width || $height>$small_image_height)
			{
			 resize_image($small_image_width,$small_image_height,"$targetFile","$targetFile");
			} 
	
	
}
	
echo '1';

?>