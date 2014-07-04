<?php 
require_once "config/functions.inc.php"; 
require_once "session.inc.php"; 
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
<strong>Music Producer </strong>
Would you like to convert your ideas into money? Here at Mussino, you have the power to reach millions of lyricists anywhere in the world!! Mussino gives you the freedom to create and produce music sessions, and sell your beats to earn profit. We also allow you to find an artist to work in partnership with you in making songs for the upcoming competitions.</p>
<p>
<strong>Music Artist</strong>
When you sign up as a music artist, you can enter the music sessions created by the music producers, record the lyrics of the newest beats, get votes, and the chance to make and earn money just like the music producers. You can also collaborate with the music producers anywhere in the world. Here at Mussino, you can start competing with other music artists and begin earning money. 
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
