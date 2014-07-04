// JavaScript Document

// Clear cookies if needed
//eraseCookie('showdash_popup');
//eraseCookie('artist_howto_b');
//eraseCookie('musician_howto_a');

//Check to see if cookie is ready
var showdash_popup = readCookie('showdash_popup')
//var artist_howto_b = readCookie('artist_howto_b')

//var artist_howto_c = readCookie('artist_howto_c')

var musician_howto_a = readCookie('musician_howto_a')
//var musician_howto_b = readCookie('musician_howto_b')
//var musician_howto_c = readCookie('musician_howto_c')

if (showdash_popup || musician_howto_a) {
//alert("yes cookie set");
$("#howtoSlides").css('display', 'none');
} 



$(document).ready(function() {
//INIT START UP
$("#step1").animate({left: '+0',    opacity:1,},function() {
//Now show highlight
$(".hightlight_Area").css('display', 'block');	
//HighLight
 for(i=0;i<4;i++) {
    $(".hightlight_Area").fadeTo('slow', 0.2).fadeTo('slow', 1);
  }
	});
//$().effect("pulsate", { times:3 }, 2000).trigger();







//Next button1
$(".nextbtn1").click(function() {
//Hide highlights	
$(".hightlight_Area").css('display', 'none');	
$("#step1").animate({left: '-200', opacity:0},function() {
//Bring in the next step...	
$("#step1").hide()
$("#step2").css('display', 'block').animate({left: '+0', opacity:1,}, function() {
//Oncompletion
//Scroll to right location
//$(window).scrollTo(300, 550);
//Show highligh blinking
$(".hightlight_Area").css('display', 'block');
 for(i=0;i<4;i++) {
       $(".hightlight_Area").fadeTo('slow', 0.2).fadeTo('slow', 1);
  }
  
	});
  });
});


//Next button2
$(".nextbtn2").click(function() {
$(".hightlight_Area").css('display', 'none');	
$("#step2").animate({left: '-200', opacity:0},function() {
//Oncompletin = Bring in the next step...	
$("#step2").hide()
$("#step3").css('display', 'block').animate({left: '+0',    opacity:1,}, function() {
//Oncompletion
//Scroll to right location
//$(window).scrollTo(410, 550);
//Show highligh blinking
$(".hightlight_Area").css('display', 'block');
 for(i=0;i<4;i++) {
       $(".hightlight_Area").fadeTo('slow', 0.2).fadeTo('slow', 1);
  }
	});
  });
});


//Next button3
$(".nextbtn3").click(function() {
$(".hightlight_Area").css('display', 'none');	
$("#step3").animate({left: '-200', opacity:0},function() {
//Oncompletin = Bring in the next step...	
$("#step3").hide()
$("#step4").css('display', 'block').animate({left: '+0',    opacity:1,}, function() {
//Oncompletion
//Scroll to right location
//$(window).scrollTo(550, 550);
//Show highligh blinking
$(".hightlight_Area").css('display', 'block');
 for(i=0;i<4;i++) {
       $(".hightlight_Area").fadeTo('slow', 0.2).fadeTo('slow', 1);
  }
	});
  });
});



//Close button
$(".closePos").click(function() {
	
$("#howtoSlides").css('display', 'none');

});


//Done button
$(".donebtn_Img").click(function() {
$("#howtoSlides").css('display', 'none');
/*createCookie('mu_howto','mu_artist',99999);*/	
$(window).scrollTo(0, 550);
});



});
// /JQUERY WRAP END...



//Move Documemnt window for next how to
function moveWindow(howfar, speed) {
$(window).scrollTo(howfar, speed);
	}


//Set Cookies
function createCookie(name,value,days) {
	if (days) {
		var date = new Date();
		date.setTime(date.getTime()+(days*24*60*60*1000));
		var expires = "; expires="+date.toGMTString();
	}
	else var expires = "";
	document.cookie = name+"="+value+expires+"; path=/";
}

//Read Cookies
function readCookie(name) {
	var nameEQ = name + "=";
	var ca = document.cookie.split(';');
	for(var i=0;i < ca.length;i++) {
		var c = ca[i];
		while (c.charAt(0)==' ') c = c.substring(1,c.length);
		if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
	}
	return null;
	
	
}

//Erase Cookies
function eraseCookie(name) {
	createCookie(name,"",-1);
}


