<?php require_once "config/functions.inc.php"; ?>
<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="en"> <!--<![endif]-->
<head>
	<meta charset="utf-8" />
	
	<!-- Page Title -->
	<title>Mussino Music Beats and Lyrics</title>
	
	<meta name="keywords" content="onepage, single page, band template, retina ready, responsive, modern html5 template, bootstrap, css3, music, band" />
	<meta name="description" content="Beat - Responsive One-Page Music & Band HTML5 Template" />
	<meta name="author" content="Wisely Themes" />
	
	<!-- Mobile Meta Tag -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

	<!-- Fav and touch icons -->
	<link rel="shortcut icon" href="front_theme/img/fav_touch_icons/favicon.jpg" />
	<link rel="apple-touch-icon" href="front_theme/img/fav_touch_icons/apple-touch-icon.png" />
	<link rel="apple-touch-icon" sizes="72x72" href="front_theme/img/fav_touch_icons/apple-touch-icon-72x72.png" />
	<link rel="apple-touch-icon" sizes="114x114" href="front_theme/img/fav_touch_icons/apple-touch-icon-114x114.png" />
	
	<!-- IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
	  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script> 
	<![endif]-->
	
	<!-- Google Web Font -->
	<link href='http://fonts.googleapis.com/css?family=Lato:400,300,700' rel='stylesheet' type='text/css'>
	
	<!-- Bootstrap CSS -->
	<link href="front_theme/css/bootstrap.min.css" rel="stylesheet" />
	
    
	<!-- Custom CSS -->
	<link rel="stylesheet" type="text/css" href="front_theme/css/style.css" />
	<link rel="stylesheet" type="text/css" href="voting/css/style.css" />
	<script language="javascript">
	var netConnectionUrl_jvar = "<?php echo $rtmpserver;?>";
	</script>
	<!-- Modernizr -->
	<script src="front_theme/js/modernizr-2.6.2.min.js"></script>
	<script src="voting/js/vote_submit.js" type="text/javascript" language="javascript"></script>
</head>
<body>
	<!-- BEGIN HEADER -->
	<header id="header">
		<section class="nav-section">
			<div class="container">
				<div class="row">
					<div class="col-sm-12">
						<a href="#home" class="nav-logo"><img src="front_theme/img/logo_small.png" alt="" height="51" /></a>
						
						<nav id="nav"><!-- BEGIN MAIN MENU -->
							<ul>
								<li><a href="#theband">Music Producer</a></li>
                                <li><a href="#music_artist">Music Artist</a></li>
								<li><a href="#concerts">Music Sessions</a></li>
								<!--<li><a href="#gallery">Gallery</a></li>
								<li><a href="#store">Music Store</a></li>-->
								<li><a href="#contacts">Join Mussino</a></li>
							</ul>
						</nav><!-- END MAIN MENU -->
						
						<ul class="sn-icons"><!-- BEGIN SOCIAL ICONS -->
							<li><a href="//www.facebook.com/Mussino.Music.Industry" target="_blank"><i class="icon-facebook-sign"></i></a></li>
							<li><a href="//twitter.com/MussinoNetwork" target="_blank"><i class="icon-twitter-sign"></i></a></li>
							<!--<li><a href=""><i class="icon-instagram"></i></a></li>
							<li><a href=""><i class="icon-google-plus-sign"></i></a></li>
							<li><a href=""><i class="icon-pinterest-sign"></i></a></li>
							<li><a href=""><i class="icon-rss-sign"></i></a></li>-->
						</ul><!-- END SOCIAL ICONS -->
					</div>
				</div>
			</div>
		</section>
	</header>
	<!-- END HEADER -->
	
	<!-- BEGIN HOME SECTION -->
	<section id="home">
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<a href="#home" id="logo" class="nav-logo"><img src="front_theme/img/logo.png" alt="" width="379" height="205" /></a>
					
					<div id="social-stream">
						<ul id="social-stream-items">
                        
                        <li class="featured">
								<div class="icon"><i class="icon-expand"></i></div>
								<div class="title"><h3><a href="http://www.youtube.com/embed/b8e-4pw-RrU?iframe=true" data-gal="prettyPhoto">Watch VideoClip!</a></h3></div>
								<a href="http://www.youtube.com/embed/b8e-4pw-RrU?iframe=true" data-gal="prettyPhoto"><img src="front_theme/img/artist_account.jpg" alt="Music Artist" /></a>
							</li>
                        
				<li class="featured">
								<div class="icon"><i class="icon-expand"></i></div>
								<div class="title"><h3><a href="http://www.youtube.com/embed/GTVYsh6lgEY?iframe=true" data-gal="prettyPhoto">Watch VideoClip!</a></h3></div>
								<a href="http://www.youtube.com/embed/GTVYsh6lgEY?iframe=true" data-gal="prettyPhoto"><img src="front_theme/img/hiphopbeats_hip_hop_beats.png" alt="Hip Hop Beats" /></a>
							</li>
                            
							<li class="featured">
								<div class="icon"><i class="icon-expand"></i></div>
								<div class="title"><h3><a href="http://www.youtube.com/embed/UPnl140nGhc?iframe=true" data-gal="prettyPhoto">Watch the New VideoClip!</a></h3></div>
								<a href="http://www.youtube.com/embed/UPnl140nGhc?iframe=true" data-gal="prettyPhoto"><img src="front_theme/img/music_industry.png" alt="Music Industry" /></a>
							</li>
						<li>
								<div class="icon color"><i class="icon-file-text-alt"></i></div>
								<div class="title"><h3 class="color">How I Earn?</h3></div>
								<img src="front_theme/img/music_sounds_beats.jpg" alt="" />
								<div class="news" 
									data-news-details='[{
										"date":"24<br/>Sep",
										"title":"Lorem ipsum dolor sit amet",
										"img":"http://placehold.it/673x444",
										"txt":[
											{
												"txt":"Fusce imperdiet metus sit amet lorem pellentesque, et suscipit lectus tempus. Aliquam dui neque, venenatis a convallis eu, sodales vitae justo. Donec nec neque purus. Sed sed nisi vestibulum, mollis ligula vel sem nulla faucibus ante.<br/><br/>Morbi feugiat urna quis nulla sodales molestie ac vitae elit. Morbi risus lectus, volutpat nec sagittis vitae, mollis et nisi. Curabitur vel neque vitae diam dapibus semper a sit amet urna. Nullam cursus velit justo. Nullam euismod, arcu sit amet semper sagittis, sem nulla faucibus ante, vitae adipiscing mi metus faucibus sapien. Nulla dictum eget metus et gravida. Donec vulputate mi ac facilisis fringilla. Proin scelerisque lorem dictum tincidunt iaculis."
											},
											{
												"quote":"Vivamos odio augue, <span>aliquet eget</span> hendrerit nec, tempus sit amet lacus. Nunc suscipit nisl eu elit <span>mollis sit amet</span> fringilla elit eleifend.",
												"img":"http://placehold.it/281x239"
											},
											{
												"txt":"Fusce imperdiet metus sit amet lorem pellentesque, et suscipit lectus tempus. Aliquam dui neque, venenatis a convallis eu, sodales vitae justo. Donec nec neque purus. Sed sed nisi vestibulum, mollis ligula vel sem nulla faucibus ante.</p><p>Morbi feugiat urna quis nulla sodales molestie ac vitae elit. Morbi risus lectus, volutpat nec sagittis vitae, mollis et nisi. Curabitur vel neque vitae diam dapibus semper a sit amet urna. Nullam cursus velit justo. Nullam euismod, arcu sit amet semper sagittis, sem nulla faucibus ante, vitae adipiscing mi metus faucibus sapien. Nulla dictum eget metus et gravida. Donec vulputate mi ac facilisis fringilla. Proin scelerisque lorem dictum tincidunt iaculis."
											},
											{
												"title":"Watch the best moments from last night concert",
												"txt":"Example of Vimeo embed video",
												"vimeo":"http://player.vimeo.com/video/74972181"
											},
											{
												"title":"Watch the best moments from last night concert",
												"txt":"Example of YouTube embed video",
												"youtube":"http://www.youtube.com/embed/1iIZeIy7TqM"
											}]
								}]'>
									<button class="btn btn-dark btn-only-icon open-overlay" data-overlay-id="news-overlay"><i class="icon-chevron-right"></i></button>
									<a href="" class="open-overlay" data-overlay-id="news-overlay">Do you like to make music?</a>
									<div class="time">Enter or Create music recording sessions</div>
								</div>
							</li>
							<li>
								<div class="icon color"><i class="icon-file-text-alt"></i></div>
								<div class="title"><h3 class="color">How it works?</h3></div>
								<img src="front_theme/img/music_beats.jpg" alt="" />
								<div class="news" 
									data-news-details='[{
										"date":"24<br/>Sep",
										"title":"Lorem ipsum dolor sit amet",
										"img":"http://placehold.it/673x444",
										"txt":[
											{
												"txt":"Fusce imperdiet metus sit amet lorem pellentesque, et suscipit lectus tempus. Aliquam dui neque, venenatis a convallis eu, sodales vitae justo. Donec nec neque purus. Sed sed nisi vestibulum, mollis ligula vel sem nulla faucibus ante.<br/><br/>Morbi feugiat urna quis nulla sodales molestie ac vitae elit. Morbi risus lectus, volutpat nec sagittis vitae, mollis et nisi. Curabitur vel neque vitae diam dapibus semper a sit amet urna. Nullam cursus velit justo. Nullam euismod, arcu sit amet semper sagittis, sem nulla faucibus ante, vitae adipiscing mi metus faucibus sapien. Nulla dictum eget metus et gravida. Donec vulputate mi ac facilisis fringilla. Proin scelerisque lorem dictum tincidunt iaculis."
											},
											{
												"quote":"Vivamos odio augue, <span>aliquet eget</span> hendrerit nec, tempus sit amet lacus. Nunc suscipit nisl eu elit <span>mollis sit amet</span> fringilla elit eleifend.",
												"img":"http://placehold.it/281x239"
											},
											{
												"txt":"Fusce imperdiet metus sit amet lorem pellentesque, et suscipit lectus tempus. Aliquam dui neque, venenatis a convallis eu, sodales vitae justo. Donec nec neque purus. Sed sed nisi vestibulum, mollis ligula vel sem nulla faucibus ante.</p><p>Morbi feugiat urna quis nulla sodales molestie ac vitae elit. Morbi risus lectus, volutpat nec sagittis vitae, mollis et nisi. Curabitur vel neque vitae diam dapibus semper a sit amet urna. Nullam cursus velit justo. Nullam euismod, arcu sit amet semper sagittis, sem nulla faucibus ante, vitae adipiscing mi metus faucibus sapien. Nulla dictum eget metus et gravida. Donec vulputate mi ac facilisis fringilla. Proin scelerisque lorem dictum tincidunt iaculis."
											},
											{
												"title":"Watch the best moments from last night concert",
												"txt":"Example of Vimeo embed video",
												"vimeo":"http://player.vimeo.com/video/74972181"
											},
											{
												"title":"Watch the best moments from last night concert",
												"txt":"Example of YouTube embed video",
												"youtube":"http://www.youtube.com/embed/1iIZeIy7TqM"
											}]
								}]'>
									<button class="btn btn-dark btn-only-icon open-overlay" data-overlay-id="news-overlay"><i class="icon-chevron-right"></i></button>
									<a href="" class="open-overlay" data-overlay-id="news-overlay">Upload beats or Record music</a>
									<div class="time">7 days music contest</div>
								</div>
							</li>
							<li class="featured">
								<div class="icon color"><i class="icon-music"></i></div>
								<div class="title"><h3><a href="">Open Recording Sessions</a></h3></div>
								<div id="music-player"></div>
							</li>
							
						</ul>
					</div>
				</div>
			</div>
		</div>
		<div id="bottom-home"></div>
	</section>
	<!-- END HOME SECTION -->
	
	<!-- Begin News/Blog Page Overlay -->
	<!--<div class="page-overlay" id="news-overlay"> 
		<i class="icon-remove-circle close-overlay"></i>
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<h1 class="center">Last News</h1>
				</div>
				<div class="col-sm-7">
					<div id="news-img-wrap">
						<div class="date"></div>
						<div class="title"><h3 class="color"></h3></div>
					</div>
					<div id="news-txt">
						
					</div>
				</div>
				<div class="col-sm-4 col-sm-offset-1">
					<h3 class="color"><i class="icon-file-text-alt"></i> Other News:</h3>
					<div class="other-news-wrap">
						<ul id="other-news">
							<li data-news-details='[{
									"date":"30<br/>Sep",
									"title":"Suscipit lectus",
									"img":"http://placehold.it/673x444",
									"txt":[
										{
											"txt":"Fusce imperdiet metus sit amet lorem pellentesque, et suscipit lectus tempus. Aliquam dui neque, venenatis a convallis eu, sodales vitae justo. Donec nec neque purus. Sed sed nisi vestibulum, mollis ligula vel sem nulla faucibus ante.<br/><br/>Morbi feugiat urna quis nulla sodales molestie ac vitae elit. Morbi risus lectus, volutpat nec sagittis vitae, mollis et nisi. Curabitur vel neque vitae diam dapibus semper a sit amet urna. Nullam cursus velit justo. Nullam euismod, arcu sit amet semper sagittis, sem nulla faucibus ante, vitae adipiscing mi metus faucibus sapien. Nulla dictum eget metus et gravida. Donec vulputate mi ac facilisis fringilla. Proin scelerisque lorem dictum tincidunt iaculis."
										},
										{
											"quote":"Vivamos odio augue, <span>aliquet eget</span> hendrerit nec, tempus sit amet lacus. Nunc suscipit nisl eu elit <span>mollis sit amet</span> fringilla elit eleifend."
										},
										{
											"img":"http://placehold.it/281x239"
										},
										{
											"txt":"Fusce imperdiet metus sit amet lorem pellentesque, et suscipit lectus tempus. Aliquam dui neque, venenatis a convallis eu, sodales vitae justo. Donec nec neque purus. Sed sed nisi vestibulum, mollis ligula vel sem nulla faucibus ante.</p><p>Morbi feugiat urna quis nulla sodales molestie ac vitae elit. Morbi risus lectus, volutpat nec sagittis vitae, mollis et nisi. Curabitur vel neque vitae diam dapibus semper a sit amet urna. Nullam cursus velit justo. Nullam euismod, arcu sit amet semper sagittis, sem nulla faucibus ante, vitae adipiscing mi metus faucibus sapien. Nulla dictum eget metus et gravida. Donec vulputate mi ac facilisis fringilla. Proin scelerisque lorem dictum tincidunt iaculis."
										},
										{
											"title":"Watch the best moments from last night concert",
											"txt":"Example of Vimeo embed video",
											"vimeo":"http://player.vimeo.com/video/74972181"
										}]
							}]'>
								<div class="other-news-img-wrap">
									<div class="date">30<br/>Sep</div>
									<img src="http://placehold.it/146x146" alt="" />
								</div>
								<div class="other-news-details">
									<h4>Suscipit lectus</h4>
									<p>Fusce imperdiet metus sit amet lorem pellentesque, et suscipit lectus.</p>
								</div>
							</li>
							<li data-news-details='[{
									"date":"29<br/>Sep",
									"title":"Suscipit lectus",
									"img":"http://placehold.it/673x444",
									"txt":[
										{
											"txt":"Fusce imperdiet metus sit amet lorem pellentesque, et suscipit lectus tempus. Aliquam dui neque, venenatis a convallis eu, sodales vitae justo. Donec nec neque purus. Sed sed nisi vestibulum, mollis ligula vel sem nulla faucibus ante.<br/><br/>Morbi feugiat urna quis nulla sodales molestie ac vitae elit. Morbi risus lectus, volutpat nec sagittis vitae, mollis et nisi. Curabitur vel neque vitae diam dapibus semper a sit amet urna. Nullam cursus velit justo. Nullam euismod, arcu sit amet semper sagittis, sem nulla faucibus ante, vitae adipiscing mi metus faucibus sapien. Nulla dictum eget metus et gravida. Donec vulputate mi ac facilisis fringilla. Proin scelerisque lorem dictum tincidunt iaculis."
										},
										{
											"quote":"Vivamos odio augue, <span>aliquet eget</span> hendrerit nec, tempus sit amet lacus. Nunc suscipit nisl eu elit <span>mollis sit amet</span> fringilla elit eleifend."
										},
										{
											"txt":"Fusce imperdiet metus sit amet lorem pellentesque, et suscipit lectus tempus. Aliquam dui neque, venenatis a convallis eu, sodales vitae justo. Donec nec neque purus. Sed sed nisi vestibulum, mollis ligula vel sem nulla faucibus ante.</p><p>Morbi feugiat urna quis nulla sodales molestie ac vitae elit. Morbi risus lectus, volutpat nec sagittis vitae, mollis et nisi. Curabitur vel neque vitae diam dapibus semper a sit amet urna. Nullam cursus velit justo. Nullam euismod, arcu sit amet semper sagittis, sem nulla faucibus ante, vitae adipiscing mi metus faucibus sapien. Nulla dictum eget metus et gravida. Donec vulputate mi ac facilisis fringilla. Proin scelerisque lorem dictum tincidunt iaculis."
										},
										{
											"title":"Watch the best moments from last night concert",
											"txt":"Example of Vimeo embed video",
											"vimeo":"http://player.vimeo.com/video/74972181"
										}]
							}]'>
								<div class="other-news-img-wrap">
									<div class="date">29<br/>Sep</div>
									<img src="http://placehold.it/146x146" alt="" />
								</div>
								<div class="other-news-details">
									<h4>Lorem ipsum dolor sit amet</h4>
									<p>Metus sit amet lorem pellentesque, et suscipit lectus tempus aliquam dui neque venenatis.</p>
								</div>
							</li>
							<li data-news-details='[{
									"date":"28<br/>Sep",
									"title":"Lorem ipsum dolor sit amet",
									"img":"http://placehold.it/673x444",
									"txt":[
										{
											"txt":"Fusce imperdiet metus sit amet lorem pellentesque, et suscipit lectus tempus. Aliquam dui neque, venenatis a convallis eu, sodales vitae justo. Donec nec neque purus. Sed sed nisi vestibulum, mollis ligula vel sem nulla faucibus ante.<br/><br/>Morbi feugiat urna quis nulla sodales molestie ac vitae elit. Morbi risus lectus, volutpat nec sagittis vitae, mollis et nisi. Curabitur vel neque vitae diam dapibus semper a sit amet urna. Nullam cursus velit justo. Nullam euismod, arcu sit amet semper sagittis, sem nulla faucibus ante, vitae adipiscing mi metus faucibus sapien. Nulla dictum eget metus et gravida. Donec vulputate mi ac facilisis fringilla. Proin scelerisque lorem dictum tincidunt iaculis."
										},
										{
											"quote":"Vivamos odio augue, <span>aliquet eget</span> hendrerit nec, tempus sit amet lacus. Nunc suscipit nisl eu elit <span>mollis sit amet</span> fringilla elit eleifend.",
											"img":"http://placehold.it/281x239"
										},
										{
											"txt":"Fusce imperdiet metus sit amet lorem pellentesque, et suscipit lectus tempus. Aliquam dui neque, venenatis a convallis eu, sodales vitae justo. Donec nec neque purus. Sed sed nisi vestibulum, mollis ligula vel sem nulla faucibus ante.</p><p>Morbi feugiat urna quis nulla sodales molestie ac vitae elit. Morbi risus lectus, volutpat nec sagittis vitae, mollis et nisi. Curabitur vel neque vitae diam dapibus semper a sit amet urna. Nullam cursus velit justo. Nullam euismod, arcu sit amet semper sagittis, sem nulla faucibus ante, vitae adipiscing mi metus faucibus sapien. Nulla dictum eget metus et gravida. Donec vulputate mi ac facilisis fringilla. Proin scelerisque lorem dictum tincidunt iaculis."
										},
										{
											"title":"Watch the best moments from last night concert",
											"txt":"Example of Vimeo embed video",
											"vimeo":"http://player.vimeo.com/video/74972181"
										}]
							}]'>
								<div class="other-news-img-wrap">
									<div class="date">28<br/>Sep</div>
									<img src="http://placehold.it/146x146" alt="" />
								</div>
								<div class="other-news-details">
									<h4>Lorem ipsum dolor sit amet</h4>
									<p>Metus sit amet lorem pellentesque, et suscipit lectus tempus aliquam dui neque venenatis.</p>
								</div>
							</li>
							<li class="disabled"
								data-news-details='[{
									"date":"27<br/>Sep",
									"title":"Lorem ipsum dolor sit amet",
									"img":"http://placehold.it/673x444",
									"txt":[
										{
											"txt":"Fusce imperdiet metus sit amet lorem pellentesque, et suscipit lectus tempus. Aliquam dui neque, venenatis a convallis eu, sodales vitae justo. Donec nec neque purus. Sed sed nisi vestibulum, mollis ligula vel sem nulla faucibus ante.<br/><br/>Morbi feugiat urna quis nulla sodales molestie ac vitae elit. Morbi risus lectus, volutpat nec sagittis vitae, mollis et nisi. Curabitur vel neque vitae diam dapibus semper a sit amet urna. Nullam cursus velit justo. Nullam euismod, arcu sit amet semper sagittis, sem nulla faucibus ante, vitae adipiscing mi metus faucibus sapien. Nulla dictum eget metus et gravida. Donec vulputate mi ac facilisis fringilla. Proin scelerisque lorem dictum tincidunt iaculis."
										},
										{
											"quote":"Vivamos odio augue, <span>aliquet eget</span> hendrerit nec, tempus sit amet lacus. Nunc suscipit nisl eu elit <span>mollis sit amet</span> fringilla elit eleifend.",
											"img":"http://placehold.it/281x239"
										},
										{
											"txt":"Fusce imperdiet metus sit amet lorem pellentesque, et suscipit lectus tempus. Aliquam dui neque, venenatis a convallis eu, sodales vitae justo. Donec nec neque purus. Sed sed nisi vestibulum, mollis ligula vel sem nulla faucibus ante.</p><p>Morbi feugiat urna quis nulla sodales molestie ac vitae elit. Morbi risus lectus, volutpat nec sagittis vitae, mollis et nisi. Curabitur vel neque vitae diam dapibus semper a sit amet urna. Nullam cursus velit justo. Nullam euismod, arcu sit amet semper sagittis, sem nulla faucibus ante, vitae adipiscing mi metus faucibus sapien. Nulla dictum eget metus et gravida. Donec vulputate mi ac facilisis fringilla. Proin scelerisque lorem dictum tincidunt iaculis."
										},
										{
											"title":"Watch the best moments from last night concert",
											"txt":"Example of Vimeo embed video",
											"vimeo":"http://player.vimeo.com/video/74972181"
										}]
							}]'>
								<div class="other-news-img-wrap">
									<div class="date">27<br/>Sep</div>
									<img src="http://placehold.it/146x146" alt="" />
								</div>
								<div class="other-news-details">
									<h4>Lorem ipsum dolor sit amet</h4>
									<p>Metus sit amet lorem pellentesque, et suscipit lectus tempus aliquam dui neque venenatis.</p>
								</div>
							</li>
							<li class="disabled"
								data-news-details='[{
									"date":"26<br/>Sep",
									"title":"Lorem ipsum dolor sit amet",
									"img":"http://placehold.it/673x444",
									"txt":[
										{
											"txt":"Fusce imperdiet metus sit amet lorem pellentesque, et suscipit lectus tempus. Aliquam dui neque, venenatis a convallis eu, sodales vitae justo. Donec nec neque purus. Sed sed nisi vestibulum, mollis ligula vel sem nulla faucibus ante.<br/><br/>Morbi feugiat urna quis nulla sodales molestie ac vitae elit. Morbi risus lectus, volutpat nec sagittis vitae, mollis et nisi. Curabitur vel neque vitae diam dapibus semper a sit amet urna. Nullam cursus velit justo. Nullam euismod, arcu sit amet semper sagittis, sem nulla faucibus ante, vitae adipiscing mi metus faucibus sapien. Nulla dictum eget metus et gravida. Donec vulputate mi ac facilisis fringilla. Proin scelerisque lorem dictum tincidunt iaculis."
										},
										{
											"quote":"Vivamos odio augue, <span>aliquet eget</span> hendrerit nec, tempus sit amet lacus. Nunc suscipit nisl eu elit <span>mollis sit amet</span> fringilla elit eleifend.",
											"img":"news_img2.jpg"
										},
										{
											"txt":"Fusce imperdiet metus sit amet lorem pellentesque, et suscipit lectus tempus. Aliquam dui neque, venenatis a convallis eu, sodales vitae justo. Donec nec neque purus. Sed sed nisi vestibulum, mollis ligula vel sem nulla faucibus ante.</p><p>Morbi feugiat urna quis nulla sodales molestie ac vitae elit. Morbi risus lectus, volutpat nec sagittis vitae, mollis et nisi. Curabitur vel neque vitae diam dapibus semper a sit amet urna. Nullam cursus velit justo. Nullam euismod, arcu sit amet semper sagittis, sem nulla faucibus ante, vitae adipiscing mi metus faucibus sapien. Nulla dictum eget metus et gravida. Donec vulputate mi ac facilisis fringilla. Proin scelerisque lorem dictum tincidunt iaculis."
										},
										{
											"title":"Watch the best moments from last night concert",
											"txt":"Example of Vimeo embed video",
											"vimeo":"http://player.vimeo.com/video/74972181"
										}]
							}]'>
								<div class="other-news-img-wrap">
									<div class="date">26<br/>Sep</div>
									<img src="http://placehold.it/146x146" alt="" />
								</div>
								<div class="other-news-details">
									<h4>Lorem ipsum dolor sit amet</h4>
									<p>Metus sit amet lorem pellentesque, et suscipit lectus tempus aliquam dui neque venenatis.</p>
								</div>
							</li>
							<li class="disabled"
								data-news-details='[{
									"date":"25<br/>Sep",
									"title":"Lorem ipsum dolor sit amet",
									"img":"http://placehold.it/673x444",
									"txt":[
										{
											"txt":"Fusce imperdiet metus sit amet lorem pellentesque, et suscipit lectus tempus. Aliquam dui neque, venenatis a convallis eu, sodales vitae justo. Donec nec neque purus. Sed sed nisi vestibulum, mollis ligula vel sem nulla faucibus ante.<br/><br/>Morbi feugiat urna quis nulla sodales molestie ac vitae elit. Morbi risus lectus, volutpat nec sagittis vitae, mollis et nisi. Curabitur vel neque vitae diam dapibus semper a sit amet urna. Nullam cursus velit justo. Nullam euismod, arcu sit amet semper sagittis, sem nulla faucibus ante, vitae adipiscing mi metus faucibus sapien. Nulla dictum eget metus et gravida. Donec vulputate mi ac facilisis fringilla. Proin scelerisque lorem dictum tincidunt iaculis."
										},
										{
											"quote":"Vivamos odio augue, <span>aliquet eget</span> hendrerit nec, tempus sit amet lacus. Nunc suscipit nisl eu elit <span>mollis sit amet</span> fringilla elit eleifend.",
											"img":"news_img2.jpg"
										},
										{
											"txt":"Fusce imperdiet metus sit amet lorem pellentesque, et suscipit lectus tempus. Aliquam dui neque, venenatis a convallis eu, sodales vitae justo. Donec nec neque purus. Sed sed nisi vestibulum, mollis ligula vel sem nulla faucibus ante.</p><p>Morbi feugiat urna quis nulla sodales molestie ac vitae elit. Morbi risus lectus, volutpat nec sagittis vitae, mollis et nisi. Curabitur vel neque vitae diam dapibus semper a sit amet urna. Nullam cursus velit justo. Nullam euismod, arcu sit amet semper sagittis, sem nulla faucibus ante, vitae adipiscing mi metus faucibus sapien. Nulla dictum eget metus et gravida. Donec vulputate mi ac facilisis fringilla. Proin scelerisque lorem dictum tincidunt iaculis."
										},
										{
											"title":"Watch the best moments from last night concert",
											"txt":"Example of Vimeo embed video",
											"vimeo":"http://player.vimeo.com/video/74972181"
										}]
							}]'>
								<div class="other-news-img-wrap">
									<div class="date">25<br/>Sep</div>
									<img src="http://placehold.it/146x146" alt="" />
								</div>
								<div class="other-news-details">
									<h4>Lorem ipsum dolor sit amet</h4>
									<p>Metus sit amet lorem pellentesque, et suscipit lectus tempus aliquam dui neque venenatis.</p>
								</div>
							</li>
						</ul>
						<div class="center"><button id="load-more-btn" class="btn btn-dark2">Load More</button></div>
					</div>
				</div>
			</div>	
		</div>
		<div class="loading"></div>
		<div class="progress"></div>
	</div>-->
	<!-- End News/Blog Page Overlay -->
	
	<!-- BEGIN THE BAND SECTION -->
	<section id="theband">
		<div class="container">
			<div class="row">
				<div class="col-sm-4">
					<h1 class="section-title">Music Producer</h1>
					<p class="section-desc">
						Would you like to convert your ideas into money? Here at Mussino, you have the power to reach millions of lyricists anywhere in the world!! Mussino gives you the freedom to create and produce music sessions, and sell your beats to earn profit. We also allow you to find an artist to work in partnership with you in making songs for the upcoming competitions.
						<br/><br/><br/>
						<a href="http://www.mussino.com/registration.php" class="btn btn-dark btn-icon" data-overlay-id="theband-overlay"><i class="icon-file-text-alt"></i><span>I got Beats</span></a>					</p>
				</div>
				<img src="front_theme/img/music_producer.png" alt="" id="bandImage" class="col-sm-8"  />			</div>
		</div>
		<div id="bottom-theband" class="bg-color2"></div>
	</section>
	<!-- END THE BAND SECTION -->
    
    <!-- BEGIN THE BAND SECTION -->
	<section id="music_artist">
		<div class="container">
			<div class="row">
            				<img src="front_theme/img/rapper_mc.png" alt="" id="bandImage" class="col-sm-5"  />
				<div class="col-sm-7">
					<h1 class="section-title">Music Artist</h1>
					<p class="section-desc">
						When you sign up as a music artist, you can enter the music sessions created by the music producers, record the lyrics of the newest beats, get votes, and the chance to make and earn money just like the music producers. You can also collaborate with the music producers anywhere in the world. Here at Mussino, you can start competing with other music artists and begin earning money. 
						<br/><br/><br/>
						<a href="http://www.mussino.com/registration.php" class="btn btn-dark btn-icon" data-overlay-id="theband-overlay"><i class="icon-file-text-alt"></i><span>I got Rhymes</span></a>					</p>
                        
                        <div class="recording-studio">
                        <img src="front_theme/img/recording_studio.png" alt="music studio" class="col-md-11 col-sm-7">
                        </div>
                        
				</div>
			</div>
		</div>
		<div id="bottom-theband" class="bg-color2"></div>
	</section>
	<!-- END THE BAND SECTION -->
	
	<!-- Begin About Band Page Overlay -->
	<!--<div class="page-overlay" id="theband-overlay"> 
		<i class="icon-remove-circle close-overlay"></i>
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<h1 class="center">We are the Beat Band!</h1>
					
					<div class="band-elem col-sm-4">
						<div class="band-elem-img">
							<img src="http://placehold.it/372x371" alt="" />
							<h3>John Doe<span> - Lead vocalist</span></h3>
						</div>
						<p>Pellentesque elementum libero enim, eget gravida nunc laoreet et. Nullam ac enim auctor, fringilla risus at, imperdiet turpis. Mauris ut tristique odio. Aenean diam ipsum, ultricies sed consequat sed, faucibus et tellus. Nam ut sollicitudin lacus. Nulla id imperdiet purus, id tristique erat.</p>
					</div>
					<div class="band-elem col-sm-4">
						<div class="band-elem-img">
							<img src="http://placehold.it/372x371" alt="" />
							<h3>John Doe<span> - Lead vocalist</span></h3>
						</div>
						<p>Pellentesque elementum libero enim, eget gravida nunc laoreet et. Nullam ac enim auctor, fringilla risus at, imperdiet turpis. Mauris ut tristique odio. Aenean diam ipsum, ultricies sed consequat sed, faucibus et tellus. Nam ut sollicitudin lacus. Nulla id imperdiet purus, id tristique erat.</p>
					</div>
					<div class="band-elem col-sm-4">
						<div class="band-elem-img">
							<img src="http://placehold.it/372x371" alt="" />
							<h3>John Doe<span> - Lead vocalist</span></h3>
						</div>
						<p>Pellentesque elementum libero enim, eget gravida nunc laoreet et. Nullam ac enim auctor, fringilla risus at, imperdiet turpis. Mauris ut tristique odio. Aenean diam ipsum, ultricies sed consequat sed, faucibus et tellus. Nam ut sollicitudin lacus. Nulla id imperdiet purus, id tristique erat.</p>
					</div>
					
					<h1 class="center">Our Albuns</h1>
					
					<div class="album">
						<div class="album-img col-sm-4">
							<div class="album-img-wrap">
								<div class="title">New</div>
								<img src="http://placehold.it/305x305" alt="" />
							</div>
						</div>
						<div class="album-info col-sm-8">
							<h3 class="color">The New Album<br/><span>2013</span></h3>
							<p>Pellentesque elementum libero enim, eget gravida nunc laoreet et. Nullam ac enim auctor, fringilla risus at, imperdiet turpis. Mauris ut tristique odio. Aenean diam ipsum, ultricies sed consequat sed, faucibus et tellus. Nam ut sollicitudin lacus. Nulla id imperdiet purus, id tristique erat.</p>
							<ol>
								<li><span>Lorem Ipsum</span> <span class="time">02:20</span></li>
								<li class="darker"><span>Dolor Sit Amet</span> <span class="time">03:05</span></li>
								<li class="darker"><span>Sed Iaculis Lectus</span> <span class="time">02:45</span></li>
								<li><span>Sed Molestie</span> <span class="time">04:00</span></li>
								<li><span>Fusce</span> <span class="time">02:15</span></li>
								<li class="darker"><span>Cras Elit Tortor</span> <span class="time">03:00</span></li>
								<li class="darker"><span>Donec Est Risus Posuere</span> <span class="time">03:35</span></li>
								<li><span>Sed Lorem Est</span> <span class="time">04:20</span></li>
								<li><span>Elementum</span> <span class="time">02:50</span></li>
							</ol>
						</div>
					</div>
					
					<div class="album">
						<div class="album-img col-sm-4">
							<div class="album-img-wrap">
								<img src="http://placehold.it/305x305" alt="" />
							</div>
						</div>
						<div class="album-info col-sm-8">
							<h3 class="color">The First Album<br/><span>2011</span></h3>
							<p>Pellentesque elementum libero enim, eget gravida nunc laoreet et. Nullam ac enim auctor, fringilla risus at, imperdiet turpis. Mauris ut tristique odio. Aenean diam ipsum, ultricies sed consequat sed, faucibus et tellus. Nam ut sollicitudin lacus. Nulla id imperdiet purus, id tristique erat.</p>
							<ol>
								<li><span>Lorem Ipsum</span> <span class="time">02:20</span></li>
								<li class="darker"><span>Dolor Sit Amet</span> <span class="time">03:05</span></li>
								<li class="darker"><span>Sed Iaculis Lectus</span> <span class="time">02:45</span></li>
								<li><span>Sed Molestie</span> <span class="time">04:00</span></li>
								<li><span>Fusce</span> <span class="time">02:15</span></li>
								<li class="darker"><span>Cras Elit Tortor</span> <span class="time">03:00</span></li>
								<li class="darker"><span>Donec Est Risus Posuere</span> <span class="time">03:35</span></li>
								<li><span>Sed Lorem Est</span> <span class="time">04:20</span></li>
								<li><span>Elementum</span> <span class="time">02:50</span></li>
							</ol>
						</div>
					</div>
				</div>
			</div>	
		</div>	
	</div>-->
	<!-- End About Band Page Overlay -->

	<!-- BEGIN CONCERTS SECTION -->
	<section id="concerts">
		<div class="container">
			<div class="row">
				<div id="concerts-info" class="col-sm-12">
					<!--<h1 class="section-title center">Music Session</h1>
					
					
					<div id="counter-info">
						<div class="featured">
							<div class="icon"><i class="icon-calendar"></i></div>
							<h3>Last Session</h3>
						</div>
						
						<div class="ccounter">
							<div class="counter"><input class="knob days" data-readOnly="true" data-width="85" data-height="85" data-displayPrevious=true data-fgColor="#3f9f97" data-skin="beat" data-thickness=".15" data-min="0" data-max="365" value="75" /><span>DAYS</span></div>
							<div class="counter"><input class="knob hour" data-readOnly="true" data-width="85" data-height="85" data-min="0" data-max="24" data-displayPrevious=true data-fgColor="#3f9f97" data-skin="beat" data-thickness=".15" value="75" /><span>HOURS</span></div>
							<div class="counter"><input class="knob minute" data-readOnly="true" data-width="85" data-height="85" data-min="0" data-max="60" data-displayPrevious=true data-fgColor="#3f9f97" data-skin="beat" data-thickness=".15" value="75" /><span>MIN.</span></div>
							<div class="counter"><input class="knob second" data-readOnly="true" data-width="85" data-height="85" data-min="0" data-max="60" data-displayPrevious=true data-fgColor="#3f9f97" data-skin="beat" data-thickness=".15" value="75" /><span>SEC.</span></div>
						</div>
						
						<div class="date col-sm-12"></div>
						<div class="location col-sm-12"></div>
					</div>
					-->
					<div class="current_marker_info">

					</div>
					<div class="buttons-area col-sm-12">
                    
                    <p>Check Out music Performers around the world.</p><br>
                    <h2>Record Music</h2>
                    <h1 class="section-title">Today</h1>

						<a href="http://www.mussino.com/login.php" onClick="javascript:Beat.googleMap('Artist');return false;" class="btn btn-default btn-icon"><i class="icon-map-marker"></i><span>Artist</span></a>
						<!--<a href="" id="seeLocation" class="btn btn-dark btn-icon"><i class="icon-map-marker"></i><span>See Location</span></a>-->
                        
                        <a href="http://www.mussino.com/registration.php" onClick="javascript:Beat.googleMap('Musician');return false;"  class="btn btn-dark btn-icon"><i class="icon-map-marker"></i><span>Musician</span></a><br/>
						<button id="complete-list-btn" class="btn btn-dark2">View all markers</button>
					</div>
					
					<div id="complete-list">
						<i class="icon-remove-circle close-complete-list"></i>
						<div id="list"></div><!-- This div will be automatic populated with the complete list of concerts -->
					</div> 
				</div>
			</div>
		</div>
		
		<div id="map_canvas"></div>
	</section>
	<!-- END CONCERTS SECTION -->
	

	
	<!-- BEGIN STORE SECTION 
	<section id="store">
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<h1 class="section-title center">Beat Store</h1>
				</div>
			</div>
		</div>
		
		<div class="flexslider">
			<ul class="slides">
				<li>
					<img src="http://placehold.it/429x428" alt="" />
					<h3 class="color">Beat - New Album</h3>
					<h2>$29</h2>
					<a href="#" class="btn btn-default btn-icon"><i class="icon-shopping-cart"></i><span>Buy Now!</span></a>
				</li>
				<!--<li>
					<img src="http://placehold.it/429x428" alt="" />
					<h3 class="color">Beat T-Shirt - White Version</h3>
					<h2>$10</h2>
					<a href="#" class="btn btn-default btn-icon"><i class="icon-shopping-cart"></i><span>Buy Now!</span></a>
				</li>
				<li>
					<img src="http://placehold.it/504x428" alt="" />
					<h3 class="color">Beat Mug</h3>
					<h2>$7</h2>
					<a href="#" class="btn btn-default btn-icon"><i class="icon-shopping-cart"></i><span>Buy Now!</span></a>
				</li>
				<li>
					<img src="http://placehold.it/429x428" alt="" />
					<h3 class="color">Beat - First Album</h3>
					<h2>$19</h2>
					<a href="#" class="btn btn-default btn-icon"><i class="icon-shopping-cart"></i><span>Buy Now!</span></a>
				</li>
				<li>
					<img src="http://placehold.it/429x428" alt="" />
					<h3 class="color">Beat - DVD</h3>
					<h2>$39</h2>
					<a href="#" class="btn btn-default btn-icon"><i class="icon-shopping-cart"></i><span>Buy Now!</span></a>
				</li>
				<li>
					<img src="http://placehold.it/429x428" alt="" />
					<h3 class="color">Beat T-Shirt - Dark Version</h3>
					<h2>$10</h2>
					<a href="#" class="btn btn-default btn-icon"><i class="icon-shopping-cart"></i><span>Buy Now!</span></a>
				</li>-->
			</ul>
		</div>
	</section>
	<!-- END STORE SECTION -->
		
	<!-- BEGIN CONTACTS SECTION -->
	<section id="contacts" class="bg-color2">
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<h1 class="section-title center">Join Mussino</h1>
					
					<!--<div id="form-wrap" class="col-sm-5 center">
						<form id="form-contact" method="post" action="#" class="bg-color1">
							<input type="text" placeholder="Name" name="contact_name" id="contact_name" />
							<input type="email" placeholder="Email" name="contact_email" id="contact_email" />
							<input type="text" placeholder="Subject" name="contact_subject" id="contact_subject" />
							<textarea cols="6" rows="4" placeholder="Message" name="contact_message" id="contact_message"></textarea>
							<a href="" id="contact_send" class="btn btn-dark btn-icon"><i class="icon-envelope"></i><span>Send</span></a>
						</form>
					</div>-->
                    <div class="col-sm-5 center">
                    <br>
                    <a href="http://www.mussino.com/registration.php" class="btn btn-dark btn-icon"><i class="icon-envelope"></i><span>Join Today</span></a>
                    </div>
				</div>
			</div>
		</div>
	</section>	
	<!-- END CONTACTS SECTION -->
	
	<!-- BEGIN FOOTER -->
	<footer id="footer" class="bg-color2">
		<ul class="sn-icons"><!-- BEGIN SOCIAL ICONS -->
			<li><a href="//www.facebook.com/Mussino.Music.Industry"><i class="icon-facebook-sign"></i></a></li>
		    <li><a href="//twitter.com/MussinoNetwork"><i class="icon-twitter-sign"></i></a></li>
		<!--	<li><a href=""><i class="icon-instagram"></i></a></li>
			<li><a href=""><i class="icon-google-plus-sign"></i></a></li>
			<li><a href=""><i class="icon-pinterest-sign"></i></a></li>
			<li><a href=""><i class="icon-rss-sign"></i></a></li>-->
		</ul><!-- END SOCIAL ICONS -->
		<p>Copyright &copy; 2014 Mussino.com. All rights reserved.</p>
	</footer>
	<!-- END FOOTER -->
	<script language="javascript">
	var myConcerts = [
		<?php
		define("auth", true);
		include_once 'voting/config/config.php';
		include('voting/vote-system.php');

		$first="yes";
		$get_all_users = mysql_query("select * from member_account_master where map_location_city_lat <> ''");
		while($all_users = mysql_fetch_array($get_all_users))
		{
			if($first=="no")
			{
				echo ",";
			}
			$first="no";
			$totalPosts = 0;
			
			if($all_users['Account_Type']=='Musician') 
			{ 
				$sqlCount = "SELECT count(*) as total FROM product_master WHERE Member_Account_Id='".$all_users['Member_Account_Id']."'";
				$resultCount = mysql_query($sqlCount);
				$collesCount = mysql_fetch_array($resultCount);
				$totalPosts = $collesCount['total'];
				//==== If user is musician then we will have to find out latest session which one have recorded video.
				$get_latest_recording_info = mysql_query("
					select nrc.*,DATEDIFF( now( ) , nrc.record_date ) AS dtdiff,pm.Title
					from 	
					new_recording_cam nrc,
					product_master pm					
					where 
					pm.Product_Id = nrc.ses_id And
					pm.Member_Account_Id='".$all_users['Member_Account_Id']."' order by nrc.id desc limit 0,1
				");
			}
			elseif($all_users['Account_Type']=='Artist') 
			{
				$sqlAudioCount = "SELECT COUNT(*) AS CtotalAudio FROM lyrics_post_audio_master WHERE Member_Account_Id='".$all_users['Member_Account_Id']."' AND Lyrics_Audio_Type='AUDIO' AND Status=1";
				$resAudioCount = mysql_query($sqlAudioCount);
				$collesAudioCount = mysql_fetch_array($resAudioCount);
				$sqlVideoCount = "SELECT COUNT(*) AS CtotalVideo FROM lyrics_post_audio_master WHERE Member_Account_Id='".$all_users['Member_Account_Id']."' AND Lyrics_Audio_Type='VIDEO' AND Status=1";
				$resVideoCount = mysql_query($sqlVideoCount);
				$collesVideoCount = mysql_fetch_array($resVideoCount);
				$sqlTextCount = "SELECT COUNT(*) AS CtotalText FROM lyrics_post_master WHERE Member_Account_Id='".$all_users['Member_Account_Id']."' AND Status=1";
				$resTextCount = mysql_query($sqlTextCount);
				$collesTextCount = mysql_fetch_array($resTextCount);
				$totalPosts = $collesAudioCount['CtotalAudio'] + $collesVideoCount['CtotalVideo'] + $collesTextCount['CtotalText'];
				
				$get_latest_recording_info = mysql_query("
					select nrc.*,DATEDIFF( now( ) , nrc.record_date ) AS dtdiff,pm.Title
					from 	
					new_recording_cam nrc,
					product_master pm					
					where 
					pm.Product_Id = nrc.ses_id And
					nrc.record_user_id='".$all_users['Member_Account_Id']."' order by nrc.id desc limit 0,1
				");
			}
			$dtdiff = 0;
			while($recordings_row=mysql_fetch_array($get_latest_recording_info))
			{
				if(!file_exists("session_images/".$recordings_row['flv_name'].".png"))
				{
					$img = "thumb_not_available_328x186.jpg";
				}else{
					$img = $recordings_row['flv_name'].".png";
				}
				$ses_ttl = $recordings_row['Title'];
				$flv_name = $recordings_row['flv_name'];
				$dtdiff = $recordings_row['dtdiff'];
			}
			if((int)$dtdiff == 0)
				$dtdiff = 'Today';
			elseif((int)$dtdiff == 1)
				$dtdiff = 'Yesterday';
			else
				$dtdiff = $dtdiff. ' Days ago';
				
			$chk_vote = mysql_query("select * from vote_items where item_name='".$all_users['Member_Account_Id']."'");
			if(mysql_num_rows($chk_vote) <= 0)
			{
				mysql_query("
					INSERT INTO `vote_items` (
						`id` ,
						`vote_item_id` ,
						`item_name` ,
						`up_votes` ,
						`down_votes` ,
						`totalComments` ,
						`theme` ,
						`switch_votes` ,
						`time_to_revote` ,
						`can_comment` ,
						`approve_comments` ,
						`date`
						)
						VALUES (
						NULL , '".getRandomId()."', '".$all_users['Member_Account_Id']."', '0', '0', '0', '2', '1', '0', '0', '0', now()
						);
				");
			}
			
			$rv = returnItemVotes(getVoteId($all_users['Member_Account_Id']));
			$up_votes = $rv['upvotes'];
			$down_votes = $rv['downvotes'];
			
			$total = $up_votes+$down_votes;
			$upvotes_percentage = 0;
			if ($total != 0)
				$upvotes_percentage = floor(($up_votes/$total) * 100);
			
			
			$left_info_str = '<div class="map_user_info"><span id="usrid_tmp" style="display:none;height:0px; width:0px;overflow:hidden;">'.$all_users['Member_Account_Id'].'</span>';
				$left_info_str .= '<h1 class="section-title center map_inf_hd">'.ucfirst($all_users['First_Name'])." ".ucfirst($all_users['Last_Name']).'</h1>';
				$left_info_str .= '<div class="mappostinf">';
					$left_info_str .= '<div class="map_post_inf">Post</div>';
					$left_info_str .= '<div class="map_post_inf_circ middle_cntr">'.$totalPosts.'</div>';
					$left_info_str .= '<div class="map_post_inf">Votes</div>';
					$left_info_str .= '<div class="map_post_inf_circ map_votes_percent">'.$upvotes_percentage.'%</div>';
				$left_info_str .= '</div>';
				$left_info_str .= '<div class="map_player_img"><img class="fancyboxrec record_img" href="#inline1" src="session_images/'.$img.'" onclick="callonloadplayer('."\'".$flv_name."\'".')"></div>';
				$left_info_str .= '<div class="session_record_info">';
					$left_info_str .= '<div class="session_record_info_left">';
						$left_info_str .= 'Latest record session<br>'.$dtdiff;
					$left_info_str .= '</div>';
					$left_info_str .= '<div class="session_record_info_right" id="session_record_info_right_id">';
						//$left_info_str .= $vote_str;
					$left_info_str .= '</div>';
				$left_info_str .= '</div>';
				$left_info_str .= '<div class="map_session_title">'.$ses_ttl.'</div>';
				$left_info_str .= '<div class="map_session_user_bio">'.nl2br($all_users['About_Me']).'</div>';
			$left_info_str .= '</div>';
			
			if(file_exists("products/user_image/$all_users[Photo]") && $all_users['Photo']!='')
			{
				$img = SITE_WS_PATH."/products/user_image/".$all_users['Photo'];
			}else{
				$img = SITE_WS_PATH."/images/user_big.png";
			}
			echo "
				{
					name:\"".ucfirst($all_users['First_Name'])." ".ucfirst($all_users['Last_Name'])."\",					
					img:\"".$img."\",
					type:\"".ucfirst($all_users['Account_Type'])."\",
					latitude:".$all_users['map_location_city_lat'].",
					longitude:".$all_users['map_location_city_lng'].",
					location:'".$all_users['map_location']."',
					infoWindow:'<div class=\"infowindowcntr\"><strong>Name:</strong> ".ucfirst($all_users['First_Name'])." ".ucfirst($all_users['Last_Name'])."<br /><strong>Location:</strong> ".$all_users['map_location']." <br /><strong>Posts:</strong> ".$totalPosts." <br /><strong>Votes:</strong> ".$upvotes_percentage."%".$left_info_str."</div>'
				}
			";
		}
		?>		
	];
	</script>
	
	<!-- myConcerts and myPlaylist objects -->
	<script src="front_theme/js/google_maps_marker/myconcerts.js" type="text/javascript"></script>
	<script src="front_theme/music/myplaylist.js" type="text/javascript"></script>
	
	<!-- Libs -->
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="front_theme/js/jquery-1.9.1.min.js"><\/script>')</script>
	<script src="http://maps.google.com/maps/api/js?sensor=false" type="text/javascript"></script>
	<script src="front_theme/js/bootstrap.min.js"></script>
	<script src="front_theme/js/plugins.js" type="text/javascript"></script>
	<script src="front_theme/twitter/jquery.tweet.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="front_theme/facebook/facebook.php" type="text/javascript" charset="utf-8"></script>
	<script src="front_theme/js/slideshow/slideshow.js" type="text/javascript"></script>
	
	<script src="front_theme/js/scripts.js"></script>
	
	<script type="text/javascript" src="player/jquery.fancybox.js"></script>
	<link rel="stylesheet" type="text/css" href="player/jquery.fancybox.css?v=2.1.4" media="screen" />
	<script type="text/javascript" src="player/flowplayer-3.2.12.min.js"></script>
	<script language="javascript">
	var lastflv;
	function callonloadplayer(flv)
	{
		lastflv=flv;
	}
	
	//---------
	
	$(".buttons-area .btn").click(function(){
		if (!($(this).hasClass('btn-default')))
		   $('.btn-icon').removeClass('btn-default').addClass('btn-dark');
		   $(this).addClass('btn-default').removeClass('btn-dark');	
     });
	
	
	</script>

	<!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
	<script>
		var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
		(function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
		g.src='//www.google-analytics.com/ga.js';
		s.parentNode.insertBefore(g,s)}(document,'script'));
	</script>
<div id="inline1" style="width:420px; height:315px;display: none; text-align:center; vertical-align:middle;">
<div id="player" style="float:left; width:420px; height:315px;"></div>
</div>
</body>
</html>