<?php 
require_once "config/functions.inc.php"; 
$pageName = basename($_SERVER['PHP_SELF']);

###############################
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>Profile</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="description" content="Default Description">
<meta name="keywords" content="">
<meta name="robots" content="">
<link href="http://www.mussino.com/css/layout.css" rel="stylesheet" type="text/css" />
</head>
<body>
<!-- HEADER -->
<?php include "header.middle.inc.php"; ?>
<div id="wrapper">
    <div class="content-container">
        <?php include "header.top.inc.php"; ?>
        <!-- TOP SPOTLIGHT 1 -->
        <div class="content-info-copy">
        <h1> About <span>Mussino</span> </h1>
        <p>
        Mussino is here to provide you the most exciting way to share your artistic ideas to other music lovers! We have the best platform designed for all songwriters, musicians, lyricists and other people with creative minds who are seeking for a very special opportunity to offer important input by giving and judging new melodic creations. It’s simply because Mussino is for people who have the strong passion and love for music.</p>
        <p>
Mussino is not only geared towards bringing all music lovers together but our service will enable all music arts to make and earn money while they enjoy unlimited connectivity that they can only find and experience here at Mussino. Signing up here is free and you can choose to be a musician or an artist. Anyone who has the interest in promoting the most popular musicians of today’s generation may also sign up and become a judge.</p>
<p>
<p>
<strong>The Science behind Mussino</strong>
If you been to a recording studio or have recorded music before Mussino should be easy for you to understand. Credits are used to enter a recording session. A recording session is a mini contest that other Artist over the world will enter 
</p>
<p>
<strong>Mussino Recording Studio</strong>
Mussino has been regarded as one of the best online studios with easy to use recording interface. New members will get free  credits for free that they can use in creating and producing music sessions through uploading their original beats that would last for up to a week. Songwriters and lyricists can search for instrumentals with the help of genres and they can preview the audio file prior they enter a session.</p>
<p>
The songwriters are also in need of credits so that they can enter the sessions. The session credits are typically set by the producer beat creators and that can range from one to five dollars. We also provide credit packages that you can avail anytime. The songwriters can join the sessions anytime they want. The more sessions they join the higher royalty value they will get.
Moreover, the songwriters will also have three choices to post a session. They can choose to post it by using written text, video or audio file upload. When the songwriters have read and </p>
        </p>
        </div>
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
