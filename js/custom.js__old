// If JavaScript is enabled remove 'no-js' class and give 'js' class
jQuery('html').removeClass('no-js').addClass('js');


/* Init Sound Manager before DOM is fully loaded
 ---------------------------------------------------------------------- */
$.playable('js/soundmanager/swf/', {
	autoStart : false, // Start playing the first item
	playNext : false, // Play next item when previous ends
	loopNext : false, // Play first item when no more next item
	pauseOnly : false, // Just pause previous on skip
	playAlone : true, // Force stop/pause previous on skip
	doUnload : false, // Unload sound on stop/finish
	useConsole: false, // Display debug console
	debugMode : false // Debug mode
});


// When DOM is fully loaded
jQuery(document).ready(function($) {


	/* Custom Functions
	 ---------------------------------------------------------------------- */


	/* Detect Touch Device
	 ---------------------------------------------------------------------- */
	(function() {

		if (Modernizr.touch) {

			$('body').addClass('touch-device');

		}

	})();


	/* Nivo Slider
	 ---------------------------------------------------------------------- */
	(function() {

		$(window).load(function() {

			// Add slider filter effect for touch devices
			var $nivo_effect = 'random';
			if (Modernizr.touch) $nivo_effect = 'fade';

        	$('.nivo-slider').nivoSlider({
        		effect: $nivo_effect, // Specify sets like: 'fold,fade,sliceDown'
				slices: 6, // For slice animations
				boxCols: 4, // For box animations
				boxRows: 2, // For box animations
				animSpeed: 500, // Slide transition speed
				pauseTime: 3000, // How long each slide will show
				startSlide: 0, // Set starting Slide (0 index)
				directionNav: true, // Next & Prev navigation
				directionNavHide: false, // Only show on hover
				controlNav: false, // 1,2,3... navigation
				controlNavThumbs: false, // Use thumbnails for Control Nav
				pauseOnHover: true, // Stop animation while hovering
				manualAdvance: true, // Force manual transitions
				prevText: 'Prev', // Prev directionNav text
				nextText: 'Next', // Next directionNav text
				randomStart: false, // Start on a random slide
				beforeChange: function(){}, // Triggers before a slide transition
				afterChange: function(){}, // Triggers after a slide transition
				slideshowEnd: function(){}, // Triggers after all slides have been shown
				lastSlide: function(){}, // Triggers when last slide is shown
				afterLoad: function(){} // Triggers when slider has loaded
        	});

    	});

	})();


	/* Revolution Slider
	 ---------------------------------------------------------------------- */
	(function() {
		$('.fullwidthbanner').revolution( {	
			delay: 9000,												
			startwidth: 940,
			startheight: 600,
			onHoverStop: 'on',						// Stop Banner Timet at Hover on Slide on/off
			thumbWidth: 100,						// Thumb With and Height and Amount (only if navigation Tyope set to thumb !)
			thumbHeight: 50,
			thumbAmount: 4,
			hideThumbs: 200,
			navigationType: 'both',					// Bullet, thumb, none, both	 (No Shadow in Fullwidth Version !)
			navigationArrows: 'verticalcentered',	// Nexttobullets, verticalcentered, none
			navigationStyle: 'round',				// Round,square,navbar
			touchenabled: 'on',						// Enable Swipe Function : on/off
			navOffsetHorizontal: 0,
			navOffsetVertical: 20,
			fullWidth: 'on',
			shadow: 0								//0 = no Shadow, 1,2,3 = 3 Different Art of Shadows -  (No Shadow in Fullwidth Version !)
		});	
	})();


	/* Masonry boxes
	 ---------------------------------------------------------------------- */
	(function() {

		$(window).load(function() {

			$('.masonry-wrap').isotope({
				masonry : {
			        columnWidth : 1,
					gutterWidth: 2,
			    },
			    masonryHorizontal: {
			    	rowHeight: 3
			  	}
			});	
			
    	});

	})();


	/* Sound Manager 
 	---------------------------------------------------------------------- */

	$(function(){
		// If playable doesn't loaded
		if (!$.playable) return;

		// Single player
		$('.playable').playable();
		$('.playable.autostart').playable({
			autoStart: true, 
			playNext: false
		});

		// Playlist
		$('.playlist').playable({
			playNext: true
		});
		$('.playlist.autostart').playable({
			autoStart: true, 
			playNext: true
		});

		// Full player tracklist
		$('#tracklist').playable({
			playNext: true
		});
		$('#tracklist.autostart').playable({
			autoStart: true, 
			playNext: true
		});

		// Playlist functions
		$('.playlist li:odd').addClass('odd');
		$('.playlist').each(function(){
			$('li', this).each(function(i){
				i = i+1;
				$('<span class="track-number">'+i+'</span>').prependTo(this);
			});
		});

		// Add special click event to play playlist
		$('.play-track').on('click', function(e){
			var 
				$playlist = $(this).data('playlist'),
				$track_num = $(this).data('track');
				if ($playlist  == undefined || $playlist == '') return;
				if ($track_num == undefined || $track_num == '') $track_num = 1;
				$track_num = $track_num - 1;  

			$('#'+ $playlist +' .playable:eq('+$track_num+')').playable('play');
			e.preventDefault();
		});
		
	});
	
	// Full Player
	(function() {
		// If playable doesn't loaded
		if (!$.playable) return;

		var 
			$player = $('#full-player-wrap .container'),
			$list = $('#tracklist', $player),
			$length = $('.track', $list).length-1,
			$track_number = 0;

		// Update list
		var _update_list = function(){

			// Animate list
			$list.animate({top : $track_number*(-50)}, 400, 'easeOutQuart');

			// Tracklist navigation active class
			$('#tracklist-nav ul li', $player).removeClass('active');
			$('#tracklist-nav ul li:eq('+$track_number+')', $player).addClass('active');
		}

		// Build tracklist navigation
		//$player.append('<div id="tracklist-nav"></div>');
		$('#tracklist-nav', $player).append('<ul></ul>');
		$('li .track', $list).each(function(i){

			var 
				$track_name = $(this).text(),
				$num = i+1;

			$('#tracklist-nav ul', $player).append('<li><span class="track-num">'+$num+'</span>'+$track_name+'</li>');

			// Add click event
			$('#tracklist-nav ul li:eq('+i+')', $player).on('click', function(e){

				// Track number
				$track_number = i;
				var 
					$this_track = $('li:eq('+i+') .track', $list);

				if ($this_track.hasClass('playing')) {
					$this_track.playable('pause');
				} else {
					$this_track.playable('play');
				}
				_update_list();
				e.preventDefault();
			});
		});

		// Add active class to the first track
		$('#tracklist-nav ul li:eq(0)', $player).addClass('active');
		
		
		// Navigation
		// Play
		$('.play', $player).on('click', function(e){
			var 
				$this_track = $('li:eq('+$track_number+') .track', $list);

			if ($this_track.hasClass('playing')) {
				$this_track.playable('pause');
			} else {
				$this_track.playable('play');
			}
			e.preventDefault();
		});

		// Next
		$('.next', $player).on('click', function(e){
			if ($track_number < $length) {
				$track_number = $track_number + 1;
				$('li:eq('+$track_number+') .track', $list).playable('play');
				_update_list();
			}
			e.preventDefault();
		});

		// Prev
		$('.prev', $player).on('click', function(e){
			if ($track_number > 0) {
				$track_number = $track_number - 1;
				$('li:eq('+$track_number+') .track', $list).playable('play');
				_update_list();
			}
			e.preventDefault();
		});

		// Details
		$('.details', $player).on('click', function(e){
			$('#tracklist-nav', $player).slideToggle(400);
			e.preventDefault();
		});


		// Add SM events
		$('#tracklist .track').bind('onfinish', function( event, sound ){
			if ($track_number < $length) {
				$track_number = $track_number + 1;
				_update_list();
			}
		});
		$('#tracklist .track').bind('onplay', function( event, sound ){
			$('.play', $player).addClass('pause');
		});
		$('#tracklist .track').bind('onpause', function( event, sound ){
			$('.play', $player).removeClass('pause');
		});

	})();
 	

 	/* Fancybox (Lightbox)
	 ---------------------------------------------------------------------- */
	(function() {
		// Add Fancybox only for images
		$('.imagebox').fancybox({
			overlayOpacity : .8,
			overlayColor: '#000'
		});

		// Add Fancybox only for media
		$('.mediabox').fancybox({

			type: 'iframe',
			centerOnScroll : true,
			autoScale : true,
			overlayOpacity : .8,
			overlayColor: '#000',
		
			onStart : function(e) {
				var 
					$el = $(e);

				if ($el.data('width') != 'auto')
					this.width = $el.data('width');
				if ($el.data('height') != 'auto')
					this.height = $el.data('height');
        	}
		});

	})();


	/* Countdown
	 ---------------------------------------------------------------------- */
	(function() {

		$('.countdown, .header-countdown').each(function(e) {
			var date = $(this).data('event-date');

	        $(this).countdown(date, function(event) {
	            var $this = $(this);

	            switch(event.type) {
	                case "seconds":
	                case "minutes":
	                case "hours":
	                case "days":
	                case "weeks":
	                case "daysLeft":
	                    $this.find('.' + event.type).html(event.value);
	                    break;

	                case "finished":
	              
	                    break;
	            }
	        });
    	});


        // Helper function that add 0 before number
        function pad (str, max) {
  			return str.length < max ? pad('0' + str, max) : str;
		}
		
	})();


	/* Tooltip
	 ---------------------------------------------------------------------- */
	(function() {
		var $mouse_move = false;

		// Disable Thumb slide effect on touch devices
		if (Modernizr.touch) return;

		if (!$('.tip').length) return;

		$('.tip').on('mouseenter', function(e) {
			// Add tip object
			var 
				tip = {},
				title = '',
				min_width = 233;
			tip = { 
				'desc' : $(this).data('tip-desc'),
				'title' : $(this).data('tip-title'), 
				'top' : $(this).offset().top 
			};

			// Check if title is exists
			if (tip.title != undefined || tip.title != '') title = '<span>'+tip.title+'</span>';

			// Append datatip prior to closing body tag
			$('body').append('<div id="tip"><div class="tip-content"><span class="tip-top"></span><p>'+title+tip.desc+'</p><div></div>');

			// Set max width
			if ($(this).outerWidth() > min_width) $('#tip p').width($(this).outerWidth());

			// Store datatip's height and width for later use
			tip['h'] = $('#tip div:first').outerHeight()+100;
			tip['w'] = $('#tip div:first').outerWidth();

			// Set datatip's mask properties - position, height, width etc	
			$('#tip').css({position:'absolute', overflow:'hidden', width:'100%', top:tip['top']-tip['h'], height:tip['h'], left:0 });

			if ($mouse_move) {
				// Set tip position
				$('#tip div').css({ left:e.pageX-(tip['w']/2), top:tip['h']+5 }).animate({ top:100 }, 500, 'easeOutBack');

				// Move datatip according to mouse position, whilst over instigator element
				$(this).mousemove(function(e){ $('#tip div').css({left: e.pageX-(tip['w']/2)}); });	
			} else {
				// Set tip position
				var pos =  $(this).offset();
				$('#tip div').css({ left: pos.left+'px', top:tip['h']+5 }).animate({ top:100 }, 500, 'easeOutBack');
			}

		}).on('mouseleave', function(e) {

			// Remove datatip instances
			$('#tip').remove(); 

		});

	})();


	/* Thumb slider
	 ---------------------------------------------------------------------- */
	(function() {

		// Disable Thumb slide effect on touch devices
		if (Modernizr.touch) return;

		var 
			mouseX = 0,
			mouseY = 0;

		// If "thumb-slide" has two images
		if ($('.thumb-slide img').length > 1) {

			// Check mouse position
			$('body').mousemove(function(e){
	   			mouseX = e.pageX // gives X position
	   			mouseY = e.pageY // gives Y position
			});
			$(window).resize(function() {
  				$('.thumbs-wrap img:last-child').css({visibility : 'hidden'})
			});

			var 
				$this,
				$thumb,
				$hoverThumb,
				$height,
				$width,
				$wrap,
				$enterFrom,
				$leaveFrom;

			// Hover event
			$('.thumb-slide').on('mouseenter', function(e) {

				$this       = $(this),
				$wrap 		= $('.thumbs-wrap', $this),
				$thumb      = $('img:first-child', $this),
				$hoverThumb = $('img:last-child', $this),
				$height 	= $thumb.height(),
				$width	 	= $thumb.width(),
				$enterFrom  = enterFrom($this);

				//console.log("enter from: " + enterFrom($this));

				// Add fixed width and height to the thumb image 
				$this.width($width);
				$this.height($height);
				$thumb.height($height);
				$thumb.width($width);
				$hoverThumb.height($height);
				$hoverThumb.width($width);
				$wrap.height($height*2);
				$wrap.width($width*2);

				// Add initial styles to thumb image and wrapper
				$thumb.css({
					position : 'absolute',
					top : 0,
					left : 0
				});
				$wrap.css({
					position : 'absolute',
					top: 0,
					left: 0
				});

				// Show direct animate

				// From top
				if ($enterFrom == 'top') {

					// Set Hover thumb position and thumbs wrap
					$wrap.css({ top : 0, left : 0 });
					$hoverThumb.css({ top : -$height + 'px', left : 0, visibility : 'visible'});

					// Animate
					$wrap.stop().animate({ top : $height + 'px' }, 400, 'easeOutQuart');
				}
				// From bottom
				else if ($enterFrom == 'bottom') {

					// Set Hover thumb position and thumbs wrap
					$wrap.css({ top :  0, left : 0 });
					$hoverThumb.css({ top : $height + 'px', left : 0, visibility : 'visible'});

					// Animate
					$wrap.stop().animate({ top : -$height + 'px' }, 400, 'easeOutQuart');
				}
				// From left
				else if ($enterFrom == 'left') {

					// Set Hover thumb position and thumbs wrap
					$wrap.css({ top : 0, left : '0' });
					$hoverThumb.css({ top : 0, left : -$width + 'px', visibility : 'visible'});

					// Animate
					$wrap.stop().animate({ left : $width + 'px'}, 400, 'easeOutQuart');
				}
				// From right
				else if ($enterFrom == 'right') {

					// Set Hover thumb position and thumbs wrap
					$wrap.css({ top : 0, left : 0 });
					$hoverThumb.css({ top : 0, left : $width + 'px', visibility : 'visible'});

					// Animate
					$wrap.stop().animate({ left : -$width + 'px'}, 400, 'easeOutQuart');
				}
		
			
			}).on('mouseleave', function(e) {
				
				$leaveFrom  = leaveFrom($this, e);

				//console.log("leave from: " + leaveFrom($this, e));

				// From top
				if ($leaveFrom == 'top') {
					// Set Hover thumb position and thumbs wrap
					$wrap.css({ top : $height + 'px', left : 0 });
					$hoverThumb.css({ top : -$height + 'px', left : 0 });

					// Animate
					$wrap.stop().animate({ top : 0 }, 400, 'easeOutQuart');
					
				}
				// From bottom
				else if ($leaveFrom == 'bottom') {
					// Set Hover thumb position and thumbs wrap
					$wrap.css({ top : -$height + 'px', left : 0 });
					$hoverThumb.css({ top : $height + 'px', left : 0 });

					// Animate
					$wrap.stop().animate({ top : 0 }, 400, 'easeOutQuart');
					
				}
				// From left
				else if ($leaveFrom == 'left') {
					// Set Hover thumb position and thumbs wrap
					$wrap.css({ top : 0, left : $width + 'px' });
					$hoverThumb.css({ top : 0, left : -$width + 'px' });

					// Animate
					$wrap.stop().animate({ left : 0 }, 400, 'easeOutQuart');
					
				}
				// From right
				else if ($leaveFrom == 'right') {
					// Set Hover thumb position and thumbs wrap
					$wrap.css({ top : 0, left : -$width + 'px' });
					$hoverThumb.css({ top : 0, left : $width + 'px' });

					// Animate
					$wrap.stop().animate({ left : 0 }, 400, 'easeOutQuart');
					
				}
			
				// Reset styles
				$thumb.css({ 
					position : 'relative',
					height : 'auto',
					width : 'auto'

				});
				$wrap.css({ 
					position : 'relative',
					height : 'auto',
					width : 'auto'
				});
				$this.css({
					width : 'auto',
					height : 'auto'
				});
			
			});

		}

		// Detect mouse direction

		// Enter from
		function enterFrom(el) {
			var 
				$direction = 'top',
				$pos       = el.offset();

			// For IE browsers
			if ($.browser.msie) {
				if ((mouseX-Math.round(el.width()/4)) <= $pos.left) return $direction = 'left';
				if ((mouseX+Math.round(el.width()/4)) >= ($pos.left + el.width())) return $direction = 'right';
				if (((mouseX+Math.round(el.width()/4)) >= $pos.left) && ((mouseY-Math.round(el.height()/4)) <= $pos.top)) return $direction = 'top';
				if (((mouseX-Math.round(el.width()/4)) >= $pos.left) && ((mouseY+Math.round(el.height()/4)) >= ($pos.top + el.height()))) return $direction = 'bottom';
			}
			
			if (mouseX <= $pos.left) return $direction = 'left';
			if (mouseX >= ($pos.left + el.width())) return $direction = 'right';
			if ((mouseX >= $pos.left) && (mouseY <= $pos.top)) return $direction = 'top';
			if ((mouseX >= $pos.left) && (mouseY >= ($pos.top + el.height()))) return $direction = 'bottom';

			return $direction;
		}

		// Leave from
		function leaveFrom(el, e) {
			var 
				$direction = 'top',
				$pos       = el.offset(),
				$mouseX    = e.pageX,
				$mouseY    = e.pageY;

			if ($mouseX <= $pos.left) return $direction = 'left';
			if ($mouseX >= ($pos.left + el.width())) return $direction = 'right';
			if (($mouseX >= $pos.left) && ($mouseY <= $pos.top)) return $direction = 'top';
			if (($mouseX >= $pos.left) && ($mouseY >= ($pos.top + el.height()))) return $direction = 'bottom';

			return $direction;
		}


	})();


	/* Stats
	 ---------------------------------------------------------------------- */
	(function() {

		$('ul.stats').each(function(){

			// Variables
			var
				$max_el       = 6,
				$stats        = $(this),
				$stats_values = [],
				$stats_names  = [],
				$timer        = $stats.data('timer'),
				$stats_length;

			// Get all stats and convert to array
			// Set length variable
			$('li', $stats).each(function(i){
				$stats_values[i] = $('.stat-value', this).text();
				$stats_names[i] = $('.stat-name', this).text();
			});
			$stats_length = $stats_names.length;

			// Clear list
			$stats.html('');

			// Init
			display_stats();

			// Set $timer
			var init = setInterval(function(){
				display_stats();
			},$timer);

			// Generate new random array
			function randsort(c,l,m) {
    			var o = new Array();
		    	for (var i = 0; i < m; i++) {
		        	var n = Math.floor(Math.random()*l);
		        	var index = jQuery.inArray(n, o);
		        	if (index >= 0) i--;
		       		else o.push(n);
		    	}
		    	return o;
			}

			// Display stats
			function display_stats(){
				var random_list = randsort($stats_names, $stats_length, $max_el);
				var i = 0;

				// First run
				if ($('li', $stats).size() == 0) {
					for (var e = 0; e < random_list.length; e++) {
						$($stats).append('<li><span class="stat-value"></span><span class="stat-name"></span></li>');
					}
				}

				var _display = setInterval(function(){

					var num = random_list[i];
						stat_name = $('li', $stats).eq(i).find('.stat-name');
						stat_name.animate({ opacity : 0}, 400, 'easeOutQuart', function(){
							$(this).text($stats_names[num]);
							$(this).css({left : '-100%', opacity : 1});
							$(this).animate({ left : 0}, 400, 'easeOutQuart');
						});
						
						stat_value = $('li', $stats).eq(i).find('.stat-value');
						display_val(stat_value, num);
					i++;
					if (i == random_list.length)
						clearInterval(_display);
				},600);
			}

			// Display value
			function display_val(val, num) {
				var 
					val_length = $stats_values[num].length,
					val_int = parseInt($stats_values[num]),
					counter = 10,
					delta = 10,
					new_val;

				// Delta
				if (val_int <= 50) delta = 1;
				else if (val_int > 50 && val_int <= 100) delta = 3;
				else if (val_int > 100 && val_int <= 1000) delta = 50;
				else if (val_int > 1000 && val_int <= 2000) delta = 100
				else if (val_int > 2000 && val_int <= 3000) delta = 150;
				else if (val_int > 3000 && val_int <= 4000) delta = 200;
				else delta = 250;

				var _display = setInterval(function(){
					
					counter = counter+delta;
					new_val = counter;
					val.text(new_val);
					if (new_val >= val_int) {
						clearInterval(_display);
						val.text($stats_values[num]);
					}
						
				},40);
				
			}

		});

	})();


	/* Number counter
	 ---------------------------------------------------------------------- */
	(function() {

		function num_count(el) {
			var 
				el = $(el),
				num = parseInt(el.data('number')),
				counter = 1,
				delta = 1,
				new_num;

			el.text('');

			// Delta
			if (num <= 100) delta = 2;
			else if (num > 100 && num <= 500) delta = 12;
			else delta = 20;

			var _display = setInterval(function(){

				counter = counter+delta;
				new_num = counter;
				el.text(new_num);

				if (new_num >= num) {
					clearInterval(_display);
					el.text(num);
				}
				
			},40);
		}

		// Events count, 404
		num_count('.events-count, #error-404 span');
		
	})();


	/* Main Navigation
	 ---------------------------------------------------------------------- */
	(function() {

		var 
			$nav            = $('#main-nav').children('ul'),
			$responsive_nav = '<option value="" selected>Navigate...</option>';
		
		// Create main navigation
		$('li', $nav).on('mouseenter', function() {
			var 
				$this = $(this),
				$sub  = $this.children('ul');
			if ($sub.length) $this.addClass('active');
			$sub.hide().stop(true, true).fadeIn(200);
		}).on('mouseleave', function() {
			$(this).removeClass('active').children('ul').stop(true, true).fadeOut(50);
		});

		// Responsive navigation
		$nav.find('li').each(function() {
			var 
				$this   = $(this),
				$a      = $this.children('a'),
				$depth  = $this.parents('ul').length - 1,
				$indent = '';

			if ($depth) {
				while($depth > 0) {
					$indent += '--';
					$depth--;
				}
			}

			$responsive_nav += '<option value="' + $a.attr('href') + '">' + $indent + ' ' + $a.text() + '</option>';
		}).end()
		  .after('<select class="responsive-nav">' + $responsive_nav + '</select>');

		$('.responsive-nav').on('change', function() {
			window.location = $(this).val();
		});
		
	})();


	/*	Sticky footer
	 ---------------------------------------------------------------------- */
	(function() {
		// Set main content top and buttons margins.
		var $margins = $('#main-content').outerHeight(true)-$('#main-content').outerHeight(); 
		$('#main-content').css('min-height', $(window).outerHeight(true) - $('#header').outerHeight(true) - $('#page-header').outerHeight(true) - $('#footer-top').outerHeight(true) - $('#footer').outerHeight(true) - $margins);	
	})();


	/* Twitter feed
	 ---------------------------------------------------------------------- */
	(function() {

		if (!$('.tweets').length) return;

		$('.tweets').each(function(){

			var 
				$this = $(this),
				$count = $this.data('tweets-count'),
				$php_url = 'plugins/tweets.php';

			if($count == undefined || $count == '') $count = 1;

			$this.html('<img src="img/loader.gif" height="11" width="16" alt="Loading..." />');

			$.ajax({
				url: $php_url,
				dataType: 'html',
				timeout: 10000,
				type: 'GET',
				error:
					function(xhr, status, error) {
						$this.html('An error occured: ' + error );
					},
				success:
					function(data, status, xhr) {
						$this.html(data).hide();
						$('li:nth-child('+$count+') ~ li', $this).remove();
						$this.show();
					}
			});
			

		});

	})();


	/* Items Filter
	 ---------------------------------------------------------------------- */

	(function() {

		var $container = $('.items');

		if ($container.length) {

			var 
				mouseOver;

			// Init Isotope
			$(window).on('load', function() {

				$container.isotope({
					portfolioelector : 'article',
					layoutMode   : 'fitRows',
					hiddenStyle: $.browser.msie ? { opacity: 0, top: -400 } : { opacity: 0, scale: 0.001 }
				});

			});

			// Init filters
			if ($('#cat-filter').length) _items_filter($('#cat-filter'), 'data-categories');
			if ($('#tag-filter').length) _items_filter($('#tag-filter'), 'data-tags');

			// Add filter event
			function _items_filter($el, $data) {

				// Add all filter class
				$el.addClass('item-filter');

				// Add categories to item classes
				$('article', $container).each(function(i) {
					var 
						$this = $(this);
						$this.addClass($this.attr($data));
				});

				$el.on('click', 'a', function(e){
					var 
						$this   = $(this),
						$option = $this.attr($data);

					// Add active filter class
					$('.item-filter').removeClass('active-filter');
					$el.addClass('active-filter');
					$('.item-filter:not(.active-filter) li a').removeClass('active');
					$('.item-filter:not(.active-filter) li:first-child a').addClass('active');

					// Add/remove active class for this filter
					$el.find('a').removeClass('active');
					$this.addClass('active');

					if ($option) {
						if ($option !== '*') $option = $option.replace($option, '.' + $option)
						$container.isotope({ filter : $option });
					}

					e.preventDefault();

				});

				$el.find('a').first().addClass('active');
			}

		}

	})();


	/* Flexible videos
	 ---------------------------------------------------------------------- */
	$('.container').fitVids();


	/* Scroll to top
	 ---------------------------------------------------------------------- */
	(function() {
		var
			$title         = 'Back to Top',
			$displayHeight = 200,
			$speed         = 800,
			$fixedPos      = true;

		// Detect if mobile browser support fixed position
		if (/(iPhone|iPod|iPad)\sOS\s[0-4][_\d]+/i.test(navigator.userAgent))
			$fixedPos= false;
		if (/Android\s+([0-2][\.\d]+)/i.test(navigator.userAgent))
			$fixedPos = false;
		
		// Append scroll button
		$('body').append('<a href="#" id="scroll-button" title="' + $title + '" class="hidden">'+ $title + '</a>');

		$('#scroll-button').click(function(e){
				$('html, body').animate({ scrollTop : 0 }, $speed, 'easeOutExpo');

				e.preventDefault();
			});

		$(window).scroll(function() {
			var $pos = $(window).scrollTop();

			if (!$fixedPos) {
				$('#scroll-button').css({
					position : 'absolute',
					top      : $pos+20
				});
			}

			if ($pos > $displayHeight)
				$('#scroll-button').removeClass('hidden');
			else 
				$('#scroll-button').addClass('hidden');
		});

	})();


	/*	Sharee plugin
	 ---------------------------------------------------------------------- */
	(function() {

		$('#share').sharrre({
			share: {
				googlePlus 	: true,
				facebook 	: true,
				twitter 	: true,
				digg 		: false,
				delicious 	: false
			},
			enableTracking	: true,
			buttons: {
				googlePlus	: {size: 'tall'},
				facebook	: {layout: 'box_count'},
				twitter 	: {count: 'vertical'},
				digg 		: {type: 'DiggMedium'},
				delicious 	: {size: 'tall'}
			},
			hover : function(api, options){
				$(api.element).find('.buttons').show();
			},
			hide : function(api, options){
				$(api.element).find('.buttons').hide();
			}
		});

	})();


	/* Gmap
	 ---------------------------------------------------------------------- */
	(function() {

		var $gmap = $('#gmap');

		if($gmap.length) {

			$gmap.gMap({
				address: 'Level 13, 2 Elizabeth St, Melbourne Victoria 3000 Australia',
				zoom: 16,
				zoomControl: true,
				scrollwheel: false,
				markers: [
					{ 'address' : 'Level 13, 2 Elizabeth St, Melbourne Victoria 3000 Australia' }
				]
			});

		}

	})();
	

	/* Contact Form
	 ---------------------------------------------------------------------- */
	(function() {

		var 
			$form   = $('.contact-form'),
			$ajax_loader = '<img src="img/loader.gif" height="11" width="16" alt="Loading..." />';

		$form.append('<div id="ajax-message" class="hidden"></div>');
		var $ajax_message = $('#ajax-message');
		
		// Submit click event
		$form.on('click', 'input[type=submit]', function(e){

			$ajax_message.hide().html($ajax_loader).show();
			
			// Ajax request
			$.post('plugins/contact-form.php', $form.serialize(), function(data) {

				// Show ajax-message
				$ajax_message.html(data);

				// If the message was sent, clear form fields
				if (data.indexOf("success") != -1) {
					clear_form_elements($form);
				}
			});
			
			e.preventDefault();
		});

		function clear_form_elements(el) {

		    $(el).find(':input').each(function() {
		        switch(this.type) {
		            case 'password':
		            case 'select-multiple':
		            case 'select-one':
		            case 'text':
		            case 'email':
		            case 'textarea':
		                $(this).val('');
		                break;
		            case 'checkbox':
		            case 'radio':
		                this.checked = false;
		        }
		    });

		}

	})();

});