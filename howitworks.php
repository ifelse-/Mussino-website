<?php 
require_once "config/functions.inc.php"; 
$pageName = basename($_SERVER['PHP_SELF']);

###############################
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>How Mussino works</title>
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
        
        <img src="http://www.mussino.com/products/title_image_fck/Image/Mussino_howitworks.jpg" />
        
       <div class="numberCircle">1</div><strong> You will need at least 1 Credit</strong>
      <div> <p>
       Credits are like currency on Mussino. You can use credits to create a session or record music. New Producer beat makers get 5 free credits to use for creating music sessions by uploading their original beats that last 1 - 7 days. A session can last up to 7 days; Songwriters can join at anytime increasing royalty value.

</p>
</div>
        
    <div class="numberCircle">2</div> <strong> You will need original Talent </strong> 
    <div><p>
    You must use original material in order to be a member on Mussino and earn credits. Producer beat makers can upload beats only with cleared or royality free samples. NO KAROKE or remake songs of another artist copyrighing music. You will be banned.
<!--New Producer beat makers get 5 free credits to use for creating music sessions by uploading their original beats that last 1 - 7 days. Songwriters lyricist can search instrumentals by genres and preview audio file before entering a session. Songwriters lyricist will need credits to enter a session, you get $1 Free. Session credits are set by the Producer beat makers and can range from $1 to $5. Credits packages are available. A session can last up to 7 days; Songwriters can join at anytime increasing royalty value. Songwriter’s will have 3 options to post to a session using written text; audio, or video file uploads. Once the songwriter has read and agreed to the terms they will have the option to download the musician’s audio file. songwriters | lyricist must use this downloaded audio file for current sessions. Upload file before the session’s end date. --></p></div>


<div class="numberCircle">3</div><strong>You will need Votes </strong><div>
<p>
Each music session start for 7 days but depending on what time you enter, session may end earlier. You can promote you recorded track on your favorite social media sharing website to help increase your Votes. (Optional) Once you're a member we will send an email every time a producer in your genre has create a recording session. 
<!--Example: 100 songwriters | lyricist enter a musician’s session paying $1 each. The royalty amount will value at $100. 

At the end of each session date, judges will vote on the most talented songwriter. A percentage is split between the Songwriter and the Musician with the most votes. Mussino will approve the final winner and receive a 5 percent for each session.
songwriters | lyricist with a paid membership have the option to sell the audio session track on their profile page if mutually agreed by the musician. A percentage of music sales will be discussed via email between the musician and the songwriter. Mussino will charge a small 1 percent fee per sale.

Mussino.com is offering an opportunity for each Songwriter and Musician to gain extra funds from their session material by using the Music store feature.  --></p></div>

<div class="numberCircle">4</div><strong>You want to Earn more Credits</strong>
<div>
<p>
The number of votes at the end of each session determine the winner. <br /> <b>A percentage of the credits are split between beat maker and the Top voted Lyricist</b>.<!--ussino.com works in the digital world like the industry works in the physical world. Any royalty income you earn will be paid to your Paypal account at the end of every week.
Welcome to the real deal.  Where it pays to play.
-->
        </p></div>
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
