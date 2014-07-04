<?php 
require_once "config/functions.inc.php"; 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>Forgot Password</title>
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

	

	function forgot_password_request_result(){ 

	

    document.getElementById('view_forgot_password_request_error').innerHTML ='<img src=\"images/loading.gif\">';

	

	var Email = document.frmForgotPassword.Email.value;

	var security_code = document.frmForgotPassword.security_code.value;

		

	httpobj.open('get',"ajax-forgot-password-request.php?Email="+Email+"&security_code="+security_code);

	httpobj.onreadystatechange	= handleForgotPasswordRequestResponse;

	httpobj.send("");



}

function handleForgotPasswordRequestResponse(){



	 if(httpobj.readyState==4){

		 var text = httpobj.responseText;

		 

		 document.getElementById('view_forgot_password_request_error').innerHTML = text;

		

	 }

}

</script>
</head>
<body>
<div id="wrapper">
  <!-- HEADER -->
  <?php include "header.middle.inc.php"; ?>
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
              <div class="blue-btn-1"> <span><span>Forgot Password</span></span> </div>
            </div>
          </div>
        </div>
        <div class="pro-content">
          <div class="form-container">
            <form id="frmForgotPassword" name="frmForgotPassword" method="post" action="">
            <ul>
            
            <li>
            <div id="view_forgot_password_request_error" class="error" style="padding-left:50px;"></div>
            </li>
            
            <li>
            <div class="caption-2">Email Address</div>
            <div class="input-2">
            <img class="inputCorner" src="images/input_left.gif">
            <input type="text" name="Email" size="30" class="input-text textinput" onKeyPress="if(event.keyCode==13) {return forgot_password_request_result();}" />
            <img class="inputCorner" src="images/input_right.gif">
            </div>
            <div class="cl"></div>
            </li>
            
            <li>
            <div class="caption-2">Type the code shown</div>
            <div class="input-2">
            <img class="inputCorner" src="images/input_left.gif">
            <input type="text" name="security_code" id="security_code" class="input-text textinput" onKeyPress="if(event.keyCode==13) {return forgot_password_request_result();}">
            <img class="inputCorner" src="images/input_right.gif">
            </div>
            <div class="cl"></div>
            </li>
            
            <li>
            <div class="caption-2">&nbsp;</div>
            <div class="input-2"><img src="php_captcha.php?hash=<?php echo $hash; ?>&width=150&height=43&characters=8" alt="captcha" name="captchaImage"></div>
            <div class="cl"></div>      
            </li>
            
            <li>
            <div class="input-2" style="padding: 0 0 0 50px;"> <input class="button" name="buttonSubmit" type="button" value="Forgot Password"  onclick="return forgot_password_request_result();" onKeyPress="if(event.keyCode==13) {return forgot_password_request_result();}" ></div>
            <div class="cl"></div>   
            </li>
            </ul>
            </form>
          </div>
        </div>
      </div>
      <div class="cor_1set-3"></div>
      <div class="cor_1set-4"></div>
    </div>
    <!-- BOTTOM SPOTLIGHT 2 -->
    <?php //include "bottom.footer.inc.php"; ?>
    <!-- //BOTTOM SPOTLIGHT 2-->
  </div>
</div>
<!-- FOOTER -->
<?php include "footer.inc.php"; ?>
<!-- //FOOTER -->
</body>
</html>
