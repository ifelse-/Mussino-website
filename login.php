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
<script type="text/javascript" src="fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="fancybox/jquery.fancybox-1.3.4.css" media="screen" />
<script type="text/javascript">
  $(document).ready(function(){
				
	$(".global-box").fancybox({
				'overlayShow'	: true,
				'transitionIn'	: 'elastic',
				'transitionOut'	: 'elastic'
			});
	
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
function trim(str) {
        return str.replace(/^\s+|\s+$/g,"");
    }
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
		 		 
		 if(trim(text)=='Go Welcome')
		 {
		 location.replace('action.php');
		 }
		 else
		 {
		 document.getElementById('view_login_result').innerHTML = text;
		 }
	 }
}
</script>
</head>
<body>
 <!-- HEADER -->
  <?php include "header.middle.inc.php"; ?>
<div id="wrapper">
  <div class="content-container">
    <?php include "header.top.inc.php"; ?>
    <!-- TOP SPOTLIGHT 1 -->
    <div class="content-box-2">
      <div class="cor_1set-5"></div>
      <div class="cor_1set-6"></div>
      <div class="pro-wrapper full">
        <div class="title">
          <div class="title_wrap-1">
            <div class="title_wrap-2">
              <div class="blue-btn-1"> <span><span>Login</span></span> </div>
              Need an account? <strong>Should take no less than 60 seconds.</strong> <a href="registration.php"><strong>Register Here</strong></a>
            </div>
          </div>
        </div>
        <div class="pro-content">
          <div class="form-container">
            <form id="frmLogin" name="frmLogin" method="post" action="">
              <ul class="fl w550" style="margin-top:10px;">
              
                   <h2>  Not a Member? <a href="http://mussino.com/registration.php" style=" color:#333">New Talent Register</a></h2>
<p>
By creating a free account with Mussino you will be able to create or enter session for paid royalties. You will get access to more features inside. <a href="http://mussino.com/registration.php"><strong>Register here</strong></a>.</p>
              
                <li>
                  <div id="view_login_result" class="error" style="padding-left:50px; margin-top:20px;"></div>
                </li>
              
                <li>
        <h2>Login</h2>
        <br />
                  <div class="caption-3" style=" width:150px;">Email Address</div>
                  <div class="input-2">
                  
                  <input type="text" name="Email" size="30" class="textinput" onKeyPress="if(event.keyCode==13) {return login_request_result();}" />
                  
                  </div>
                  <div class="cl"></div>
                </li>
                <li>
                  <div class="caption-3" style=" width:150px;">Password</div>
                  <div class="input-2">
                  
                  <input type="password" name="Password" size="30" class="input-text textinput" onKeyPress="if(event.keyCode==13) {return login_request_result();}" />
                  
                  </div>
                  <div class="cl"></div>
                </li>
                <li>
                  <div class="caption-2" ><a href="forgot-password.php">Forgot Password </a></div>
                  <div class="input-2">
                 <input class="button" name="buttonSubmit" type="button" value="Let me in NOW!" onClick="return login_request_result();" onKeyPress="if(event.keyCode==13) {return login_request_result();}">
                  </div>
                  <div class="cl"></div>
                </li>
                
              </ul>
              
            </form>
            <div class="fr">
            <div>
            <img src="images/mussino-playnow.png" />
            </div>
            <div style=" padding-top:10px;"></div>
            <div><img src="images/schoolad.gif" /></div>
            </div>
            <div class="cl"></div>
          </div>
          
        </div>
      </div>
      <div class="cor_1set-3"></div>
      <div class="cor_1set-4"></div>
    </div>
  </div>
  </div>
</div>


<!-- FOOTER -->
<?php include "footer.inc.php"; ?>
<!-- //FOOTER -->
</body>
</html>
