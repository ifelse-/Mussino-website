<?php
include("config/functions.inc.php");

$Thumbnail_Name="";
			if($_FILES['small_video_uploadfile']['name']!="")
			{
			$Thumbnail_Name=time()+1;
			$Thumbnail_Name.=basename($_FILES['small_video_uploadfile']['name']);
			$uploadfile = "products/small_video/" .$Thumbnail_Name;
			$img_path=$_FILES['small_video_uploadfile']['name'];
		
		    if(move_uploaded_file($_FILES['small_video_uploadfile']['tmp_name'], $uploadfile))
			{  
			
				echo $Thumbnail_Name."|".$uploadfile."|"."success";
			}else{
					echo "error";
				 }	 
			}
?>