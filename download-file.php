<?php
require_once "config/functions.inc.php"; 
//require_once "session.inc.php";



$sql = "SELECT * FROM product_master WHERE md5(Product_Id) = '".$_REQUEST['id']."'";
$result = mysql_query($sql);
$colles = mysql_fetch_array($result);
$fileName = $colles['Short_FIle_Name'];
$filePath = "products/small_video/";
$path = $filePath.$fileName;

if ($fd = fopen ($path, "r")) 
{ 
    $fsize = filesize($path); 
    $path_parts = pathinfo($path); 
    $ext = strtolower($path_parts["extension"]); 
	switch ($ext) { 
	
        case "pdf": 
       		 header("Content-type: application/pdf"); 
       		 header("Content-Disposition: attachment; filename=\"".$path_parts["basename"]."\"");
		     break;
		
  		
  		case "doc": $ctype="application/msword";
			header("Content-type: application/msword"); 
			header("Content-Disposition: attachment; filename=\"".$path_parts["basename"]."\"");
			break;
			
	   case "docx": $ctype="application/msword";
			header("Content-type: application/msword"); 
			header("Content-Disposition: attachment; filename=\"".$path_parts["basename"]."\"");
			break;
  		
  		
  		case "gif": $ctype="image/gif"; 
			header("Content-type: application/gif");
			header("Content-Disposition: attachment; filename=\"".$path_parts["basename"]."\"");
			break;
  		
		case "jpg": $ctype="image/jpg";
			header("Content-type: application/jpg"); 
			header("Content-Disposition: attachment; filename=\"".$path_parts["basename"]."\"");
			break;
		case "txt": $ctype="application/txt";
			header("Content-type: application/txt"); 
			header("Content-Disposition: attachment; filename=\"".$path_parts["basename"]."\"");
			break;
 		
        default; exit;
        
    } 
	header("Content-type: $type");
	header("Content-length: $fsize"); 
    header("Cache-control: private"); 
    while(!feof($fd)) 
	{ 
        $buffer = fread($fd, 2048); 
        echo $buffer; 
    } 

	
}


?>




