<!DOCTYPE HTML>
<html><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"><title>The Video / Youtube Gallery - iPad / iPhone Compatible</title>

<link rel="stylesheet" type="text/css" href="style/style.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script type="text/javascript" src="js/swfobject.js"></script>
<script type="text/javascript" src="js/swfaddress.js"></script>



<script type="text/javascript" src="videogallery/vplayer.js"></script>
<script type="text/javascript" src="videogallery/vgallery.js"></script>
<link rel="stylesheet" type="text/css" href="videogallery/vplayer.css"/>
<link rel="stylesheet" type="text/css" href="videogallery/vgallery.css"/>
<link rel="stylesheet" type="text/css" href="videogallery/skin_white.css"/>


<script type="text/javascript">
var width = 915;
var height = 360;
var flashvars = {
//if you specify a xml file the settings will be read from the xml file
xml:"xml/gallery.xml"//the next settings are useless if the xml parameter above exists.
};
var params = {
menu: "false",
allowScriptAccess: "always",
scale: "noscale",
allowFullScreen: "true",
wmode:'opaque'
};
var attributes = {};
//swfobject.embedSWF("preview.swf", "flashcontent", width, height, "10.0.0", "expressInstall.swf", flashvars, params, attributes);
</script>
<link rel='stylesheet' type="text/css" href="testimonialrotator/testimonialrotator.css"/>
<script src="testimonialrotator/testimonialrotator.js" type="text/javascript"></script></head>
<body>
<a href="http://thezoomer.net/ygallerydesigner" class="new-feature" target="_blank"></a>

<div id="header_wrapper">
<div id="header"><img src="img/logo.png"></div>
</div>
<div id="content_wrapper">
<div id="content">
<h3>Demo 1: Self Hosted Video and Audio, YouTube videos</h3>
<div class="videogallery-maincon">
<div class="videogallery-flash">
</div>
<?php
require_once('generatehtml5.php');
readXml('xml/gallery.xml', 'xml');
?>
</div>
    
<p></p>
<div class="delimiter"></div>
<div class="testimonialrotator">
<div class="testimonial">
<span>
Thank you – this module is saving us a ton of time!  Really appreciate the quick responses.
</span>
<div class="the-author">ahengel</div>
</div>

    <div class="testimonial">
    <span>Anyone thinking of buying this gallery, don't hesitate. Great gallery!</span>
    <div class="the-author">john</div>
    </div>

</div>
<div class="delimiter"></div>
<div>
<div class="one_third"><h3>Packed with Powerful Features</h3><img src="img/feat1.png"/>
<p>Take advantage of the awesome features packed in this gallery - including it's own API. You can do things like:<br><br>
<a href="#" onClick="flashcontent.pauseVideo();">Pause Video</a> | <a href="#" onClick="flashcontent.nextVideo();">Go to next video</a></p>
</div>
<div class="one_third">
  <h3>Advertisment Support</h3>
  <img src="img/feat2.png"/>
<p>Insert your own ads before the video plays - both image and video support. <br><br>
<a href="#" onClick="flashcontent.gi(2);">Go to Demo Video</a></p>
</div>
<div class="one_third last">
  <h3>AD Support</h3>
  <img src="img/feat3.png"/>
<p>Insert your own ads before the video plays - both image and video support. </p>
</div>
<div class="clearfix"></div>
</div>
<!-- <div class="demo_text">This gallery content is feeded through a xml that is passed through <strong>FlashVars</strong> ( xml/gallery.xml ) is the default xml, if none is feeded through FlashVars. Menu is on the right. It contains both local videos ( that can be <strong>.flv/.mov/.mp4</strong> ) and <strong>YouTube</strong> videos. <strong>Share</strong> and <strong>embed</strong> buttons are activated ( by the xml option set to on ). You can set <strong>as many social networks as you like</strong>. You can test the embed code right away by copying the code that comes up and paste-ing in your html page or wordpress blog post/page. And of course, after purchase there are instructions on how to replace that code and provide the same functionality for your visitors.</div> -->
<div class="delimiter"></div>
<div class="clearfix"></div>
<div class="two_third">
<h3>Images</h3>
<img src="img/feature1.jpg">
<img src="img/feature2.jpg">
<img src="img/feature3.jpg">
<img src="img/feature4.jpg"></div>
<div class="one_third last">
<h3>Features</h3>
<ol>
<li>1. Three skins for you to choose from. So now it can fit perfectly in your site design.
</li>
<br>
<li>2. Feeds from XML or FlashVars or from a xml set through
FlashVars. Streams YouTube, Vimeo, videos hosted on a RTMP server or
just on your local host. Wow!
</li>
<br>
<li>3. Has html5 functionality so that it can display on iPhone
/ iPad.</li>
<br>
<li>4. Cross-browser compatible. Works on every video able
device.
</li>
</ol>
</div>
<div class="clearfix"></div>
<div class="delimiter"></div>
<h3>Demo 2: Stream from YouTube user</h3>
<div id="flashcontent2">
<object type="application/x-shockwave-flash" data="preview_skin_overlay.swf" width="640" height="460" id="flashcontent" style="visibility: visible; "><param name="movie" value="preview_skin_overlay.swf"><param name="menu" value="false"><param name="allowScriptAccess" value="always"><param name="scale" value="noscale"><param name="allowFullScreen" value="true"><param name="wmode" value="opaque"><param name="flashvars" value="xml=xml/gallery2.xml">
</object>
</div>
<p>As you can see, you can choose not to load the first video to
preserve bandwidth and replace it with a placeholder image of your
choosing. The menu's position can be changed to be down so it fits more
icons. This gallery feeds completely from FlashVars ( need no xml file
on your server, just the swf ) and streams the videos of a user ( in
this case - 'hollywoodstreams' ). You can offcourse stream your user's
videos. Other options are - stream from a YouTube playlist you created,
stream from a rtmp server and stream videos based on a keyword search.</p>
<br>
<div class="delimiter"></div>
<div class="one_half">
<h3 class="big-up">3 Skins</h3>
<p>Choose from 3 awesome skins to personalize your gallery. Or use the included <a href="http://thezoomer.net/ygallerydesigner" target="_blank">Gallery Design Center</a> to creater your own which makes it actually -> unlimited skins.</p>

</div>
<div class="one_half last">
<img src="img/featureskins.png"></div>
<div class="clearfix"></div>
<div class="delimiter"></div>
<h3>Demo 3: Stream Vimeo Videos</h3>
<div id="flashcontent3">
<object type="application/x-shockwave-flash" data="preview_skin_vimeo.swf" width="715" height="360" id="flashcontent" style="visibility: visible; "><param name="movie" value="preview_skin_vimeo.swf"><param name="menu" value="false"><param name="allowScriptAccess" value="always"><param name="scale" value="noscale"><param name="allowFullScreen" value="true"><param name="wmode" value="opaque"><param name="flashvars" value="xml=xml/gallery3.xml">
</object>
</div>
<br>
<br>
<br>
<p>This gallery even supports Vimeo movies. The skin is not
customisable, but the default is already slick enough, and you can
still have a logo over it. A scrollbar is activated via a option in the
xml. This is especially useful if you want to input a large number of
videos in this gallery. By the way, this gallery supports virtually
unlimited videos.</p>
<br>
</div>
<!--end content--></div>

    
    <script>
	jQuery(document).ready(function($){
        $(".testimonialrotator").testimonialrotator({
			settings_slideshowTime:3
			});
});
	</script>
</body></html>