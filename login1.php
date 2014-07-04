<?php
include"GoogleOpenID.php";
  $googleLogin = GoogleOpenID::createRequest("http://174.132.28.185/~rohitco/music_site/return.php");
  $googleLogin->redirect();
?>