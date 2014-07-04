<?php
include("../config/functions.inc.php");

			$Thumbnail_Name="";
			if($_FILES['imagefile']['name']!="")
			{
			$Thumbnail_Name=time()+1;
			$Thumbnail_Name.=basename($_FILES['imagefile']['name']);
			$uploadfile = "../products/product_image/" .$Thumbnail_Name;
			$img_path=$_FILES['imagefile']['name'];
		
		    if(move_uploaded_file($_FILES['imagefile']['tmp_name'], $uploadfile))
			{  
				list($width, $height, $type, $attr) = @getimagesize($uploadfile);
				if($width>$small_image_width || $height>$small_image_height)
					{
			 				resize_image($small_image_width,$small_image_height,"$uploadfile","$uploadfile");
					}
				echo $Thumbnail_Name."|".$uploadfile."|"."success";
			}else{
					echo "error";
				 }	 
			}
?>