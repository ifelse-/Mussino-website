<?php 
require_once "config/functions.inc.php"; 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>Mussino.com Register Page</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="description" content="Default Description">
<meta name="keywords" content="">
<meta name="robots" content="">
<?php include "common.inc.php"; ?>

<script type="text/javascript" src="fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<!--<script type="text/javascript" src="fancybox/jquery.fancybox-1.3.4.pack.js"></script>
--><link rel="stylesheet" type="text/css" href="fancybox/jquery.fancybox-1.3.4.css" media="screen" />
<script type="text/javascript">
  $(document).ready(function(){
				
	/*$(".global-box").fancybox({
				'overlayShow'	: true,
				'transitionIn'	: 'elastic',
				'transitionOut'	: 'elastic'
			});
	
$("#variousRegister").fancybox({
				'overlayShow'	: true,
				'transitionIn'	: 'elastic',
				'transitionOut'	: 'elastic'
			});*/


$('#sites input:radio').addClass('input_hidden');
$('#sites label').click(function() {
    $(this).addClass('selected').siblings().removeClass('selected');
});

});

$(".musicianbtn").click(function() {
alert( "Handler for .click() called." );
});

</script>
<script type="text/javascript">
  function reloadCaptcha(imageName)
  {
    var randomnumber=Math.floor(Math.random()*1001); // generate a random number to add to image url to prevent caching
    document.images[imageName].src = document.images[imageName].src + '&amp;rand=' + randomnumber; // change image src to the same url but with the random number on the end
  }
  </script>
  
  <style>
  .input_hidden {
position: absolute;
    left: -9999px;
}

#sites .selected {
    background-color: #8CB5B7;
}

#sites label {
    display: inline-block;
    cursor: pointer;
}

#sites label:hover {
    background-color: #C1DFF1;
}

#sites label img {
    padding: 3px;
    
}

  </style>
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
              <div class="date no-img">Already have an account? <div class="blue-btn-1"> <span><span><a href="<?=SITE_WS_PATH?>/login.php">Login</a></span></span> </div></div>
              <h3>Start making music Today! <!--<span style="color: #069">Free trial, all access available limited time.</span>--></h3>
              
            </div>
          </div>
        </div>
        <div class="pro-content" style="width:773px; margin:0 auto;">
          <div class="form-container full">
            <form id="frmRegistration" name="frmRegistration" method="post" action="">
              <ul class="fl">
                <li>
                  <div id="view_registration_result" class="error" style="padding-left:50px; font-weight:bold;"></div>
                  
                </li>
                <li>
                <br />
                  <div class="caption-4"><h3>Choose Account Type</h3></div>
                  <div id="sites" style="width:813px;">
                  <div class="input-3">
                    <input name="Account_Type" type="radio" value="Musician" id="so" class="hide-me"  />
                   <label for="so"><img src="images/mussino-register-btn.png" class="musicianbtn" alt="Musician Account" /></label>
               
               
                  <input name="Account_Type"  type="radio" value="Artist" id="sf" class="hide-me" /> <label  for="sf"><img src="images/lyricistbtn.png" alt="Lyricist account" /></label>
                    
                 
                  
                   <input name="Account_Type"  type="radio" value="Contest Judge" id="su" class="hide-me" /> <label name="Account_Type" for="su"><img src="images/judgebtn.png" alt="Listen to music" /></label>
                   
                   
                  </div>
                  <!--<div class="input-3">
                    <input name="Account_Type" type="radio" value="Artist" />
                    &nbsp;&nbsp;<img src="http://www.mussino.com/images/icon/notebook_icon.jpg" align="absbottom" /> &nbsp;&nbsp; <strong class="color1a">Songwriter | Lyricist  Get 1 Free Credit to enter a session</strong>  
               
               
                   <br /><br /><input name="Account_Type" type="radio" value="Musician" />&nbsp;&nbsp; <img src="http://www.mussino.com/images/piano2.png" width="20" align="absbottom" /> &nbsp;&nbsp; <strong class="color1a">Producer | Beat Maker Get 5 free Credits to create sessions</strong> 
                    
                  
                  <br /> <br /> <input name="Account_Type" type="radio" value="Contest Judge" />&nbsp;&nbsp; <img src="http://www.mussino.com/images/usersjudge.png" width="20" align="absbottom" /> &nbsp;&nbsp; <strong class="color1a">Judge | Fan discover new talent and earn points!</strong> 
                   
                   
                  </div>-->
                  </div>
                  <div class="cl"></div>
                </li>
                <br />
                
                <li>
                  <div class="caption-3">Stage Name:</div>
                  <div class="input-2">
                  
                  
                  <input type="text" style="width:500px;" name="First_Name" size="30" class="input-text textinput" onkeypress="if(event.keyCode==13) {return registration_request_result();}" />
                  
                  
                  </div>
                  <div class="cl"></div>
                </li>
                <li>
                  <div class="caption-3">Email:</div>
                  <div class="input-2">
                  
                  
                  <input type="text" style="width:500px;" name="Email" size="30" class="input-text textinput" onkeypress="if(event.keyCode==13) {return registration_request_result();}" />
                  
                  
                  </div>
                  <div class="cl"></div>
                </li>
                <li>
                  <div class="caption-3">Password:</div>
                  <div class="input-2">
                  
                  <input type="password" style="width:500px;" name="Password" size="30"  class="input-text textinput" onkeypress="if(event.keyCode==13) {return registration_request_result();}"/>
                  
                  </div>
                  <div class="cl"></div>
                </li>
                <li>
                  <div class="caption-3">&nbsp;</div>
                  <div class="captcha">
                  <img src="<?=SITE_WS_PATH?>/php_captcha.php?hash=<?php echo $hash; ?>&width=200&height=60&characters=8" alt="captcha" name="captchaImage" />
                  <div class="gray-btn-1">
                    <span>
                      <span><a href="#" onclick="reloadCaptcha('captchaImage'); return false;">Refresh</a></span>
                    </span>
                  </div>
          <br /><br />
                  <p class="paddingTop"><strong>Please enter the text from the image above:</strong></p>
                  <p>The letters are case-sensitive.</p>
                  <p>Do not type spaces between the numbers and letters.</p>
                  
                   <input type="text" name="security_code" class="input-text textinput" id="security_code" size="30" onkeypress="if(event.keyCode==13) {return registration_request_result();}">
                 
                  </div>
                  <div class="cl"></div>
                  
                </li>
                <br />
                <li>
                  <div class="caption-3">&nbsp;</div>
                  <div style="width:640px; font-size:12px;" >
                   <input name="terms" type="checkbox" value="1" />  By clicking Sign up free, you agree to Mussino <a href="main-page.php?id=5">terms of service</a> and <a href="main-page.php?id=14">privacy policy</a>. 
                  </div>
                  <div class="cl"></div>
                  
                </li>
                
                <li>
                  <div class="input-2" style="padding-left:7em;">
                 <input class="button" name="buttonSubmit" type="button" value="Let me in NOW!" onClick="return registration_request_result();" onKeyPress="if(event.keyCode==13) {return registration_request_result();}">
                  </div>
                  <div class="cl"></div>
                </li>
                
              </ul>
              
            </form>
            <!--<div class="fr">
            <div>
            <img src="images/advertisement2.png" />
            </div>
            <div style=" padding-top:20px;"></div>
            <div>
            <iframe width="279" height="250" src="http://www.youtube.com/v/GTVYsh6lgEY?modestbranding=1&autoplay=1&rel=0&border=0" frameborder="0" allowfullscreen></iframe>
            
            </div>
            </div>-->
            <div class="cl"></div>
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
</div>

<!-- FOOTER -->
<?php include "footer.inc.php"; ?>
<!-- //FOOTER -->
</body>
</html>
