<?php 
require_once "config/functions.inc.php"; 
$_SESSION['go_dir']='unreleased';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>Profile</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="description" content="Default Description">
<meta name="keywords" content="">
<meta name="robots" content="">
<?php include "common.inc.php"; ?>
<link rel="stylesheet" type="text/css" href="main.css" />
<script type="text/javascript" src="fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="fancybox/jquery.fancybox-1.3.4.css" media="screen" />
<script type="text/javascript">
  $(document).ready(function(){
				
		
			
         $("#variousRegister").fancybox({
				'overlayShow'	: true,
				'transitionIn'	: 'elastic',
				'transitionOut'	: 'elastic'
			});


});
</script>
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
	
function songs_request_result(id){ 
	
    document.getElementById('view_songs').innerHTML ='<img src=\"images/loading.gif\">';
	
	httpobj.open('get',"ajax-songs-request.php?id="+id);
	httpobj.onreadystatechange	= handleSongsRequestResponse;
	httpobj.send("");

}
function handleSongsRequestResponse(){

	 if(httpobj.readyState==4){
		 var text = httpobj.responseText;
		// alert(text);
		 document.getElementById('view_songs').innerHTML = text;
		 
	 }
}
</script>
</head>

<body>
<div id="wrapper">
<script type="text/javascript" src="wz_tooltip.js"></script>
<?php include "header.middle.inc.php"; ?>
<div class="content-container">
<?php include "header.top.inc.php"; ?>
<?php include "category-middle.php"; ?>
<?php if($_SESSION['SESS_ID']!='') { ?>
<?php include"footer-div.inc.php"; ?>
<?php } ?>
</div>
</div>
<?php include "footer.inc.php"; ?>
</body>
</html>