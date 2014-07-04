<?php 
require_once "config/functions.inc.php"; 
require_once "session.inc.php"; 
$pageName = basename($_SERVER['PHP_SELF']);
$sql = "SELECT * FROM member_account_master WHERE Member_Account_Id='".$_SESSION['SESS_ID']."'";
$result = mysql_query($sql);
$colles = mysql_fetch_array($result);
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
	

function changepassword_request_result(){ 
	
    document.getElementById('view_changepassword_result').innerHTML ='<img src="images/loading.gif" alt="" />';
	
	
	var oldpassword = document.frmChangePassword.oldpassword.value;    
	var Password = document.frmChangePassword.Password.value;
	var re_password = document.frmChangePassword.re_password.value;	
	httpobj.open('get',"ajax-changepassword-request.php?oldpassword="+oldpassword+"&Password="+Password+"&re_password="+re_password);
	httpobj.onreadystatechange	= handleChangePasswordRequestResponse;
	httpobj.send("");

}
function handleChangePasswordRequestResponse(){

	 if(httpobj.readyState==4)
	 {
		 var text = httpobj.responseText;
		 
		 document.getElementById('view_changepassword_result').innerHTML = text;
		 
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
              <div class="blue-btn-1"> <span><span><a href="<?=SITE_WS_PATH?>/<?=trim($_SESSION['SESS_ID'])?>/<?=$_SESSION['SESS_FIRST_NAME']?>" >My Profile</a></span></span> </div>
              &raquo; Change Password
            </div>
          </div>
        </div>
        <div class="pro-content">
        <form id="frmChangePassword" name="frmChangePassword"  method="post" action="">
          <div class="pro-left fl">
            <div class="user-img">
            <a href="<?=SITE_WS_PATH?>/<?=trim($_SESSION['SESS_ID'])?>/<?=$_SESSION['SESS_FIRST_NAME']?>" >
			<?php if(file_exists("products/user_image/$colles[Photo]") && $colles['Photo']!='') { ?>
              <img src="products/user_image/<?php echo $colles['Photo']; ?>" border="0" width="100" height="150" />
               <?php } else { ?>
              <img src="images/user_big.png" border="0" width="100" height="150" />
            <?php } ?>
            </a>
            <p><?=$colles['Account_Type']?></p>
            </div>
            <div class="pro-btn_row">
              <?php include "left-profile.inc.php"; ?>  
            </div>
          </div>
          <div class="pro-right">
             <div class="form-container">
                 <?php if($_SESSION["sess_mess"]!='') { ?>
                    <div class="succes"><?=$_SESSION["sess_mess"]?> <? $_SESSION["sess_mess"]='';?></div>
                  <?php } ?>
              <ul>
                <li>
                  <div id="view_changepassword_result" class="error"></div>
                </li>
                <li>
                  <div class="caption-2">Old Password</div>
                  <div class="input-2">
                    <input type="password" name="oldpassword" size="30" class="input-text" onkeypress="if(event.keyCode==13) {return changepassword_request_result();}" >
                  </div>
                  <div class="cl"></div>
                </li>
                <li>
                  <div class="caption-2">New Password</div>
                  <div class="input-2">
                    <input type="password" name="Password" size="30" class="input-text" onkeypress="if(event.keyCode==13) {return changepassword_request_result();}" >
                  </div>
                  <div class="cl"></div>
                </li>
                <li>
                  <div class="caption-2">Confirm Password </div>
                  <div class="input-2">
                    <input type="password" name="re_password" size="30" class="input-text" onkeypress="if(event.keyCode==13) {return changepassword_request_result();}" >
                  </div>
                  <div class="cl"></div>
                </li>
                <li>
                  <div class="input-2">
                    <input name="buttonSubmit" type="button" value="Submit" class="button" onclick="return changepassword_request_result();" onkeypress="if(event.keyCode==13) {return changepassword_request_result();}" >
                  </div>
                  <div class="cl"></div>
                </li>
                
              </ul>
            
          </div>
          </div>
          <div class="cl"></div>
        </form>
        </div>
      </div>
      <div class="cor_1set-3"></div>
      <div class="cor_1set-4"></div>
    </div>


<?php if($_SESSION['SESS_ID']!='') { ?>
<?php include"footer-div.inc.php"; ?>
<?php } ?>
</div>
</div>
<!-- FOOTER -->
<?php include "footer.inc.php"; ?>
<!-- //FOOTER -->

</body>
</html>