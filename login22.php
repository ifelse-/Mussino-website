<?php 
require_once "config/functions.inc.php"; 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>Home page</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="description" content="Default Description">
<meta name="keywords" content="">
<meta name="robots" content="">
<?php include "common.inc.php"; ?>
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

function login_request_result(){ 
	
    document.getElementById('view_login_result').innerHTML ='<img src="images/loading.gif" alt="" />';

	var Email = document.frmLogin.Email.value;    
	var Password = document.frmLogin.Password.value;
	
	httpobj.open('get',"ajax-login-request.php?Email="+Email+"&Password="+Password);
	httpobj.onreadystatechange	= handleLoginRequestResponse;
	httpobj.send("");

}
function handleLoginRequestResponse(){

	 if(httpobj.readyState==4)
	 {
		 var text = httpobj.responseText;
		 if(text=='Go Welcome')
		 {
		 location.replace('my-profile.php');
		 }
		 else if(text=='Go Cart')
		 {
		 location.replace('my-cart.php');
		 }
		 else
		 {
		 document.getElementById('view_login_result').innerHTML = text;
		 }
	 }
}
</script>
</head>

<body id="bd" class=" cms-index-index cms-home fs3">

<!-- HEADER -->
<?php include "header.middle.inc.php"; ?>
</div>
</div>
<?php include "header.top.inc.php"; ?>
<!-- TOP SPOTLIGHT 1 -->
<div id="ja-topsl" class="wrap">
    <div class="main">
		<div class="inner">
			<div class="jm-product-list latest clearfix">
				<div class="headInner">
					<h4><span>Login</span></h4>
     			</div>
				<div class="form-container form">
					<!--<form id="frmLogin" name="frmLogin" method="post" action="<?=$url?>">
						<ul>
							<li>
								<ul class="login">
									<li>&nbsp;</li>
									<li id="view_login_result" class="error"></li>
								</ul>
							</li>
							
							<li>
								<ul class="login">
									<li>Email ID</li>
									<li><input type="text" name="Email" size="30" class="input-text"  /></li>
								</ul>
							</li>
							<li>
								<ul class="login">
									<li>Password</li>
									<li><input type="password" name="Password" size="30" class="input-text" /></li>
								</ul>
							</li>
							<li>
								<ul class="login">
									<li>&nbsp;</li>
									<li><input class="button" name="buttonSubmit" type="submit" value="Submit" ></li>
								</ul>
							</li>
						</ul>
					</form>-->
                    <a href="http://174.132.28.185/~rohitco/music_site/login1.php">Login with your Google Account</a>
				</div> 
			</div>
		</div><!-- .inner -->
    </div><!-- .main -->
</div>


<!-- BOTTOM SPOTLIGHT 2 -->
<?php include "bottom.footer.inc.php"; ?>
<!-- //BOTTOM SPOTLIGHT 2--> 

<!-- FOOTER -->
<?php include "footer.inc.php"; ?>
<!-- //FOOTER -->

</body>
</html>