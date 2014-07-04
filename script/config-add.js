
$(document).ready(function(){
   $('.player-box .option-box ul').find('li.main-row:last').addClass('last');
   $('.player-rit-box .player-rit ul').find('li:first').addClass('first');
   $('.player-rit-box .player-rit ul').find('li:last').addClass('last');
   $('.footer-container .footer-wrapper').find('.footer-box:last').addClass('last');
   $('ul.small-link').find('li:first').addClass('first');
   $('.rit_small-link ul').find('li:last').addClass('last');
   $('.rit_small-link ul').find('li:first').addClass('first');
   $('.contentArea .lftPannel .moreMix ul').find('li:last').addClass('last');
   $('.form-container ul').find('li:first').addClass('first');
   $('.form-container ul').find('li:last').addClass('last');
   $('.rgtPannel').find('.rgtPannel-col:last').addClass('last');
   $('.rgtPannel .rgtPannel-col').find('p:first').addClass('first');
   $('.rgtPannel .rgtPannel-col').find('p:last').addClass('last');
   $('.dark-gray_wrap, .dark-gray_wrap ul.albm-detail, .genre-wrap').find('.new-albm:last, li:last, .genre-col:last').addClass('last');
   $('.genre-info ul ').find('li:first').addClass('first');
   $('.genre-info ul ').find('li:last').addClass('last');
   $('.genre-col').find('.genre-block:last').addClass('last');
   
   $("input.scroll").click(function(event){		
		$('html,body').animate({scrollTop:$('#confirm_id').offset().top}, 500);
	});
   $("input.scroll1").click(function(event){		
		$('html,body').animate({scrollTop:$('#report').offset().top}, 500);
	});
   $(".postBlock input.yesBtn").click(function(event){		
		$('html,body').animate({scrollTop:$('#Lyrics').offset().top}, 500);
	});
   $(".postNew input.postNewBtn").click(function(event){		
		$('html,body').animate({scrollTop:$('#Lyrics').offset().top}, 500);
	});
	
   $('.account-wrapper').append('<div class="btm-shad"></div>');	
   $('.account-widget').append('<div class="lft-cor"></div>');
   $('.account-widget').append('<div class="brd-top"></div><div class="brd-btm"></div>');
   $('.account-widget .lft-cor').append('<div class="wrap-1"></div>');
   $('.account-widget .lft-cor .wrap-1').append('<div class="wrap-2"></div>');
   $('.account-widget .lft-cor .wrap-1 .wrap-2').append('<div class="wrap-3"></div>');
   $('.account-widget').append('<div class="rit-cor"></div>');
   $('.account-widget .rit-cor').append('<div class="wrap-1"></div>');
   $('.account-widget .rit-cor .wrap-1').append('<div class="wrap-2"></div>');
   $('.account-widget .rit-cor .wrap-1 .wrap-2').append('<div class="wrap-3"></div>');
   $('.account-widget .post-box').append('<div class="nw-cor-1"></div><div class="nw-cor-2"></div><div class="nw-cor-3"></div><div class="nw-cor-4"></div>');
   $('.account-widget .package-box ul ').find('li:first').addClass('first');
   $('.account-widget .package-box ul ').find('li:last').addClass('last');
   
  $(".top-nav ul li a").hover(function() { 
		$(this).parents('.top-nav ul li').addClass("current");	
		$('.sub-nav').mouseleave(function(){
			$(".top-nav ul li").removeClass("current")					  
		});
		$(this).parents('.top-nav ul li').find(".sub-nav").slideDown('fast').show(); 
		$(this).parents('.top-nav ul li').hover(function() {  
		 }, function(){  
			$(this).parent().find(".sub-nav").hide();
		});  
  	});
  
});
