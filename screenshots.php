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
        <link href="css/general.css" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" href="css/showcase.css" />

<!-- JS SCRIPTS -->

<script type="text/javascript" src="javascript/js_functions.js"></script>

<script type="text/javascript" src="javascript/jquery.aw-showcase.min.js"></script>
<script type="text/javascript">

$(document).ready(function()
{
	$("#showcase").awShowcase(
	{
		content_width:			940,
		content_height:			490,
		fit_to_parent:			false,
		auto:					true,
		interval:				5000,
		continuous:				true,
		loading:				true,
		tooltip_width:			200,
		tooltip_icon_width:		32,
		tooltip_icon_height:	32,
		tooltip_offsetx:		18,
		tooltip_offsety:		0,
		arrows:					true,
		buttons:				true,
		btn_numbers:			true,
		keybord_keys:			true,
		mousetrace:				false, /* Trace x and y coordinates for the mouse */
		pauseonover:			true,
		stoponclick:			false,
		transition:				'hslide', /* hslide/vslide/fade */
		transition_delay:		0,
		transition_speed:		500,
		show_caption:			'onload', /* onload/onhover/show */
		thumbnails:				false,
		thumbnails_position:	'outside-last', /* outside-last/outside-first/inside-last/inside-first */
		thumbnails_direction:	'vertical', /* vertical/horizontal */
		thumbnails_slidex:		1, /* 0 = auto / 1 = slide one thumbnail / 2 = slide two thumbnails / etc. */
		dynamic_height:			false, /* For dynamic height to work in webkit you need to set the width and height of images in the source. Usually works to only set the dimension of the first slide in the showcase. */
		speed_change:			true, /* Set to true to prevent users from swithing more then one slide at once. */
		viewline:				false, /* If set to true content_width, thumbnails, transition and dynamic_height will be disabled. As for dynamic height you need to set the width and height of images in the source. */
		custom_function:		null /* Define a custom function that runs on content change */
	});
});

</script>

<style>
.slideshowBullets,.slideshowText {
	display:none;}
</style>

</head>
<body>

 
    
  

	<!-- Start CONTENT CONTAINER -->
    <div id="contentContainer">
    
    <!-- Start SHOWCASE CONTAINER -->
	<div id="showcaseContainer">
	
	<h2>Powerful Features</h2>
	<h3>Learn Mussino and get the most out of our tools</h3>
	
	<div id="showcase" class="showcase">
    
    <!-- SHOWCASE 0 -->
		<div class="showcase-slide">
			<div class="showcase-content">
				<div class="slideshowtexttl">
					<h4>Welcome to Mussino.com</h4>
					<p class="slideshowText">Registered users have access to their own control area where they can...</p>
					<ul class="slideshowBullets">
						<li>Edit their profile info</li>
						<li>Change password</li>
						<li>Upgrade to full membership (if user is a free member)</li>
						<li>Invite friends to write a comment for them</li>
						<li>Approve what a friend has written about them</li>
						<li>See if their friends have recommended other users as a match</li>
					</ul>
				</div>
				<div class="slideshowtexttr">
					<h4>Overview</h4>
					<ul class="slideshowBullets">
						<li>View and remove their favourites</li>
						<li>See who likes them and if they've received any virtual gifts</li>
						<li>Paid members get full access to the MyMatch message centre for sending and receiving messages</li>
						<li>See which members match their requirements or search through all members</li>
					</ul>
				</div>
				<img src="../images/screen/homepage.png" />
				<img src="images/showcase-screen-shadow.png" />
			</div>
			<div class="showcase-tooltips">
				<a href="#" coords="300,100">
					<img src="../images/screen/homepage-top.png" />
					<p class="featureWhiteText">Users can edit their profiles and upload new images to be approved by the site admin.</p>
				</a>
				<a href="#" coords="300,350">
					<img src="../images/screen/homepage-down.png" />
					<p class="featureWhiteText">Free users have the opportunity to easily upgrade their membership based on the admin settings.</p>
				</a>
			</div>
		</div>
    
    
		<!-- SHOWCASE 1 -->
		<div class="showcase-slide">
			<div class="showcase-content">
				<div class="slideshowtexttl">
					<h4>Login area</h4>
					<p class="slideshowText">MyMatch dating software is a white label social dating platform for you to create your own incredible and profitable dating business.</p>
					<p class="slideshowText">The MyMatch system allows users to invite friends to help them find that perfect match by writing comments about their friend and recommending other users to their friend.</p>
				</div>
				<div class="slideshowtexttr">
					<h4>Take control...</h4>
					<p class="slideshowText">MyMatch software comes with the complete and unencrypted source code files, full documentation and layered Photoshop files, and free lifetime access to all version updates and upgrades.</p>
					<p class="slideshowText">With MyMatch dating software you are ready to start your own online dating business, with unlimited earning potential.<p>
				</div>
				<img src="../images/screen/login.png" />
				<img src="images/showcase-screen-shadow.png" />
			</div>
			<div class="showcase-tooltips">
				<a href="#" coords="600,20">
					<img src="../images/screen/login-top.png" />
					<p class="featureWhiteText">Login or Signup for Mussino.com.</p>
				</a>
				<a href="#" coords="370,200">
					<img src="../images/screen/login-mid.png" />
					<p class="featureWhiteText">Enter Login information.</p>
				</a>
				<!--<a href="#" coords="550, 255">
					<img src="images/feature-closeup-1-3.png" />
					<p class="featureWhiteText">Stylish drop-down panel for logging in and registering users.</p>-->
				</a>
			</div>
		</div>
		
		<!-- SHOWCASE 2 -->
		<div class="showcase-slide">
			<div class="showcase-content">
				<div class="slideshowtexttl">
					<h4>Create a<br /> Free account</h4>
					<p class="slideshowText">Registered users have access to their own control area where they can...</p>
					<ul class="slideshowBullets">
						<li>Edit their profile info</li>
						<li>Change password</li>
						<li>Upgrade to full membership (if user is a free member)</li>
						<li>Invite friends to write a comment for them</li>
						<li>Approve what a friend has written about them</li>
						<li>See if their friends have recommended other users as a match</li>
					</ul>
				</div>
				<div class="slideshowtexttr">
					<h4>Musician, Artist, or Judge | Fan account.</h4>
					<ul class="slideshowBullets">
						<li>View and remove their favourites</li>
						<li>See who likes them and if they've received any virtual gifts</li>
						<li>Paid members get full access to the MyMatch message centre for sending and receiving messages</li>
						<li>See which members match their requirements or search through all members</li>
					</ul>
				</div>
				<img src="../images/screen/register.png" />
				<img src="images/showcase-screen-shadow.png" />
			</div>
			<div class="showcase-tooltips">
				<a href="#" coords="300,130">
					<img src="../images/screen/register-mid.png" />
					<p class="featureWhiteText">Users can edit their profiles and upload new images to be approved by the site admin.</p>
				</a>
				<!--<a href="#" coords="550,240">
					<img src="images/feature-closeup-2-2.png" />
					<p class="featureWhiteText">Free users have the opportunity to easily upgrade their membership based on the admin settings.</p>
				</a>-->
			</div>
		</div>
		
		<!-- SHOWCASE 3 -->
		<div class="showcase-slide">
			<div class="showcase-content">
				<div class="slideshowtexttl">
					<h4>Easy Dashboard</h4>
					<p class="slideshowText">Users can see at a glance how many people have added them as a favourite and if they have received any virtual gifts from anyone.</p>
					<p class="slideshowText">From here users can view the profiles of those who like them.</p>
				</div>
				<div class="slideshowtexttr">
					<h4>Quick access main features</h4>
					<p class="slideshowText">Virtual gifts can be sent and received by any users (free or paid) and show up on the 'Who likes you' page.</p>
					<p class="slideshowText">Users select from a range of virtual gifts which are selected by the website administrator.<p>
				</div>
				<img src="../images/screen/dash.png" />
				<img src="images/showcase-screen-shadow.png" />
			</div>
			<div class="showcase-tooltips">
				<a href="#" coords="300,120">
					<img src="../images/screen/dash-top.png" />
					<p class="featureWhiteText">Moving the mouse over any received gifts shows who sent it.</p>
				</a>
				<a href="#" coords="300,230">
					<img src="../images/screen/dash-down.png" />
					<p class="featureWhiteText">Easily see people who like you or remove them from your list.</p>
				</a>
			</div>
		</div>
		
		<!-- SHOWCASE 4 -->
		<div class="showcase-slide">
			<div class="showcase-content">
				<div class="slideshowtexttl">
					<h4>Studio detailed profile</h4>
					<p class="slideshowText">MyMatch dating software colour codes male and female search results for easy-on-the-eye quick reference.</p>
					<p class="slideshowText">From the quick search results you get a brief idea of what users are looking for and whether they have any friend's comments.</p>
				</div>
				<div class="slideshowtexttr">
					<h4>Create or Enter sessions</h4>
					<p class="slideshowText">The MyMatch system only uses first names throughout the website and doesn't display users email addresses, so your users will be kept safe.</p>
					<p class="slideshowText">From the 'View Profile' pages your users can add favourites, send virtual gifts and full paid members can send messages.<p>
				</div>
				<img src="../images/screen/songwriter-profile.png" alt="my match screenshots" />
				<img src="images/showcase-screen-shadow.png" />
			</div>
			<div class="showcase-tooltips">
				<a href="#" coords="270,180">
					<img src="../images/screen/profile-royalty.png" />
					<p class="featureWhiteText">Stylish drop-down panel for logging in and registering users.</p>
				</a>
				<a href="#" coords="515,195">
					<img src="../images/screen/profile-sessions.png" />
					<p class="featureWhiteText">Quick search facility on all pages for registered users.</p>
				</a>
			</div>
		</div>
        
         <!-- SHOWCASE 6 -->
		<div class="showcase-slide">
			<div class="showcase-content">
				<div class="slideshowtexttl">
					<h4>Enter a session for earn royalties</h4>
					<p class="slideshowText">Registered users have access to their own control area where they can...</p>
					<ul class="slideshowBullets">
						<li>Edit their profile info</li>
						<li>Change password</li>
						<li>Upgrade to full membership (if user is a free member)</li>
						<li>Invite friends to write a comment for them</li>
						<li>Approve what a friend has written about them</li>
						<li>See if their friends have recommended other users as a match</li>
					</ul>
				</div>
				<div class="slideshowtexttr">
					<h4>Text, Audio, Video, and session.</h4>
					<ul class="slideshowBullets">
						<li>View and remove their favourites</li>
						<li>See who likes them and if they've received any virtual gifts</li>
						<li>Paid members get full access to the MyMatch message centre for sending and receiving messages</li>
						<li>See which members match their requirements or search through all members</li>
					</ul>
				</div>
				<img src="../images/screen/createsession.png" />
				<img src="images/showcase-screen-shadow.png" />
			</div>
			<div class="showcase-tooltips">
				<a href="#" coords="590,100">
					<img src="../images/screen/createsession-top.png" />
					<p class="featureWhiteText">Users can edit their profiles and upload new images to be approved by the site admin.</p>
				</a>
				<a href="#" coords="300,350">
					<img src="../images/screen/createsession-mid.png" />
					<p class="featureWhiteText">Free users have the opportunity to easily upgrade their membership based on the admin settings.</p>
				</a>
			</div>
		</div>
    
		
	</div>
	</div>
	<!-- End SHOWCASE CONTAINER -->
			
		
	</div>
	<!-- End CONTENT CONTAINER -->
    
    
    
    
        <div class="clear"></div>
        <div style="height:50px"></div>
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
