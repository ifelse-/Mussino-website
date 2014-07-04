<?php 
$gd2=checkgd();



//$pics=directory("pics","jpg,JPG,JPEG,jpeg,png,PNG");
//$pics=ditchtn($pics,"tn_");
//if ($pics[0]!=""){
//	foreach ($pics as $p){
//		createthumb($p,"tn_".$p,150,150);
//	}
//}

/*
	Function checkgd()
	checks the version of gd, and returns "yes" when it's higher than 2
*/
function checkgd(){
	$gd2="";
	ob_start();
	phpinfo(8);
	$phpinfo=ob_get_contents();
	ob_end_clean();
	$phpinfo=strip_tags($phpinfo);
	$phpinfo=stristr($phpinfo,"gd version");
	$phpinfo=stristr($phpinfo,"version");
	preg_match('/\d/',$phpinfo,$gd);
	if ($gd[0]=='2'){$gd2="yes";}
	return $gd2;
}

/*
	Function ditchtn($arr,$thumbname)
	filters out thumbnails
*/
function ditchtn($arr,$thumbname){
	foreach ($arr as $item){
		if (!preg_match("/^".$thumbname."/",$item)){$tmparr[]=$item;}
	}
	return $tmparr;
}

/*
	Function createSmallthumb($name,$filename,$new_w,$new_h)
	creates a resized image
	variables:
	$name		Original filename
	$filename	Filename of the resized image
	$new_w		width of resized image
	$new_h		height of resized image
*/	
//function resize_image($resize_width,$resize_height,$temp_path,$target_path)
function resize_image($width,$height,$name,$filename){ //,$new_w,$new_h){

	
	global $gd2;
	$system=explode(".",$name);
	$img_ext=strrchr($name, ".");
//	print_r($system);
//	exit;

	if (preg_match("/(jpg)/i",$img_ext)){
		$src_img=imagecreatefromjpeg($name);
		
	} else	if (preg_match("/(jpeg)/i",$img_ext)){
		$src_img=imagecreatefromjpeg($name);
		
	}else if (preg_match("/png/i",$img_ext)){
		$src_img=imagecreatefrompng($name);
		
	}else if (preg_match("/gif/i",$img_ext)){
		$src_img=imagecreatefromgif($name);
	}
	else
	{
		return "default.jpg";
	}

	

	$new_w = "";
	$new_h = "";

	// find the new image width
	$w=imageSX($src_img);
    $h=imageSY($src_img);
	
	$tx = $w;
	$ty = $h;

	$Ratio=$tx/$ty;

	while ($tx>$width || $ty > $height)
	{
	        
		$tx=$tx-1;
		$ty = $tx/$Ratio;
	
	}
	
	$new_w=$tx;
        $new_h=$ty;

	
	
	if ($gd2==""){
		$dst_img=ImageCreate($new_w,$new_h);
		imagecopyresized($dst_img,$src_img,0,0,0,0,$new_w,$new_h,imageSX($src_img),imageSY($src_img)); 
	}else{
		$dst_img=ImageCreateTrueColor($new_w,$new_h);
		imagecopyresampled($dst_img,$src_img,0,0,0,0,$new_w,$new_h,imageSX($src_img),imageSY($src_img)); 
	}
	if (preg_match("/png/i",$img_ext)){
		imagepng($dst_img,$filename); 
	} else if (preg_match("/jpeg/i",$img_ext)){
		imagejpeg($dst_img,$filename); 
	}else if (preg_match("/jpg/i",$img_ext)){
		imagejpeg($dst_img,$filename); 
	}else if (preg_match("/gif/i",$img_ext)){
		imagegif($dst_img,$filename); 
	}

	imagedestroy($dst_img); 
	imagedestroy($src_img); 
	return($filename);
	
}


/*
	Function createthumb($name,$filename,$new_w,$new_h)
	creates a resized image
	variables:
	$name		Original filename
	$filename	Filename of the resized image
	$new_w		width of resized image
	$new_h		height of resized image
*/	

function createthumb($name,$filename,$width,$height){ //,$new_w,$new_h){

	global $gd2;
	$system=explode(".",$name);
	$img_ext=strrchr($name, ".");

	if (preg_match("/(jpg)/i",$img_ext)){
		$src_img=imagecreatefromjpeg($name);
		
	} else	if (preg_match("/(jpeg)/i",$img_ext)){
		$src_img=imagecreatefromjpeg($name);
		
	}else if (preg_match("/png/i",$img_ext)){
		$src_img=imagecreatefrompng($name);
		
	}else if (preg_match("/gif/i",$img_ext)){
		$src_img=imagecreatefromgif($name);
		
	}
	else
	{
		return "default.jpg";
	}

	

	$new_w = "";
	$new_h = "";

	// find the new image width
	$w=imageSX($src_img);
    $h=imageSY($src_img);
	
	$tx = $w;
	$ty = $h;

	$Ratio=$tx/$ty;

	while ($tx>$width || $ty > $height)
	{
	        
		$tx=$tx-1;
		$ty = $tx/$Ratio;
	
	}
	
	$new_w=$tx;
        $new_h=$ty;

	
	
	if ($gd2==""){
		$dst_img=ImageCreate($new_w,$new_h);
		imagecopyresized($dst_img,$src_img,0,0,0,0,$new_w,$new_h,imageSX($src_img),imageSY($src_img)); 
	}else{
		$dst_img=ImageCreateTrueColor($new_w,$new_h);
		imagecopyresampled($dst_img,$src_img,0,0,0,0,$new_w,$new_h,imageSX($src_img),imageSY($src_img)); 
	}
	if (preg_match("/png/i",$img_ext)){
		imagepng($dst_img,$filename); 
	} else if (preg_match("/jpeg/i",$img_ext)){
		imagejpeg($dst_img,$filename); 
	}else if (preg_match("/jpg/i",$img_ext)){
		imagejpeg($dst_img,$filename); 
	}else if (preg_match("/gif/i",$img_ext)){
		imagegif($dst_img,$filename); 
	}

	imagedestroy($dst_img); 
	imagedestroy($src_img); 
	return($filename);
	
}

/*
        Function directory($directory,$filters)
        reads the content of $directory, takes the files that apply to $filter 
		and returns an array of the filenames.
        You can specify which files to read, for example
        $files = directory(".","jpg,gif");
                gets all jpg and gif files in this directory.
        $files = directory(".","all");
                gets all files.
*/
function directory($dir,$filters){
	$handle=opendir($dir);
	$files=array();
	if ($filters == "all"){while(($file = readdir($handle))!==false){$files[] = $file;}}
	if ($filters != "all"){
		$filters=explode(",",$filters);
		while (($file = readdir($handle))!==false) {
			for ($f=0;$f<sizeof($filters);$f++):
				$system=explode(".",$file);
				if ($system[3] == $filters[$f]){$files[] = $file;}
			endfor;
		}
	}
	closedir($handle);
	return $files;
}

/* function to get the file path from the path stores in the data base 


*/

function getFilePath($dir,$filename)
{
	
	
	$dirs = trim($dir,"\\\/.");
	$dirarr = explode("\\",$dirs);
	$temp = "";
		
	foreach($dirarr as $direle)
	{
	
		$temp =$temp.$direle."/";
	
	}
	
	preg_match("/(.*?)(\.)(.*)/i",$filename,$match1);	
	$extn  = $match1[3];
	$extnL = strtolower($extn);
	$extnU = strtoupper($extn);

	$dirurl = "./".$temp.$match1[1] . "." . $extnL;
	$alterurl = "./".$temp.$match1[1] . "." . $extnU;
	
	if(file_exists($dirurl))
	{
		return ($dirurl);
	}else if(file_exists($alterurl))
	{
		return ($alterurl);
	}
	return "";

	
}
function getThumbFlName($dir,$filename)
{
	
	$dirs = trim($dir,"\\\/.");
	$dirarr = explode("\\",$dirs);
	$temp = "";
		
	foreach($dirarr as $direle)
	{
	
		$temp =$temp.$direle."/";
	
	}
	
	preg_match("/(.*?)(\.)(.*)/i",$filename,$match1);	
	$extn  = $match1[3];
	$extnL = strtolower($extn);
	
	$dirurl = "./".$temp. "thumbnails/thumb_" .$match1[1] . "." . $extnL;
	
	return($dirurl);
}
/****** FUNCTIONS START ***********/
	
	function remove_edit($document)
	{
		$search = array('@<span class="editsection[^>]*?>.*?</span>@si');
		$text = preg_replace($search, '', $document);
        return $text;
	}
		function remove_image_link($document)
	{
        $search = array('@<a href="/wiki/Image:[^>]*?>@si');
		$text = preg_replace($search, '', $document);
		return $text;
	}



	function remove_javascript($document)
	{
		$search = array('@<script[^>]*?>.*?</script>@si');
		$text = preg_replace($search, '', $document);
		return $text;
	}
	

	function html2txt($document)
	{
		$search = array('@<script[^>]*?>.*?</script>@si',  // Strip out javascript
					   '@<[\/\!]*?[^<>]*?>@si',            // Strip out HTML tags
					   '@<style[^>]*?>.*?</style>@siU',    // Strip style tags properly
					   '@<![\s\S]*?--[ \t\n\r]*>@'        // Strip multi-line comments including CDATA
						);
		$text = preg_replace($search, '', $document);
		return $text;
	}
	
	function html2txt2($document)
	{
		$search = array('@<div[^>]*?>.*?</div>@si',  // Strip out javascript
					   '@<span[^>]*?>.*?</span>@si',            // Strip out HTML tags
					   
						);
		$text = preg_replace($search, '', $document);
		return $text;
	}
	


	
	function removeEvilTags($source,$allowedTags = '')
	{   
	   $source = strip_tags(stripslashes($source), $allowedTags);
	   return trim(preg_replace('/<(.*?)>/ie', "'<'.removeEvilStyles('\\1').'>'", $source));
	}
	
	function removeEvilStyles($tagSource)
	{
	   // this will leave everything else, but:
	   $evilStyles = array('font', 'font-family', 'font-face', 'font-size', 'font-size-adjust', 'font-stretch', 'font-variant');
	
	   $find = array();
	   $replace = array();
	   
	   foreach ($evilStyles as $v)
	   {
		   $find[]    = "/$v:.*?;/";
		   $replace[] = '';
	   }
	   
	   return preg_replace($find, $replace, $tagSource);
	}
	
	/****** FUNCTIONS END ***********/
?>
