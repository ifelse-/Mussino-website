(function(m){m.fn.vGallery=function(a){a=m.extend({menuWidth:100,menuHeight:350,menuSpace:0,randomise:"off",autoplay:"off",autoplayNext:"on",menu_position:"right",menuitem_width:"200",menuitem_height:"71",menuitem_space:"0",transition_type:"slideup",design_skin:"skin_default",videoplayersettings:""},a);this.each(function(){function v(a,b){var a=parseInt(Math.random()*b),c=0;for(j=0;j<l.length;j++)a==l[j]&&(c=1);if(1==c)v(0,b);else return l.push(a),a}function x(b){!1==is_ios()&&(("right"==a.menu_position||
"left"==a.menu_position)&&f.css({top:-((b.pageY-e.offset().top)/h*((a.menuitem_height+a.menuitem_space)*d-h))}),("bottom"==a.menu_position||"top"==a.menu_position)&&f.css({left:-((b.pageX-e.offset().left)/g*((a.menuitem_width+a.menuitem_space)*d-g))}))}function y(a){t(f.children().index(a.currentTarget))}function t(b){function d(){i.parent().children(".preloader").fadeOut("fast");"fade"==a.transition_type&&(c.children().eq(b).css({left:0,top:0}),-1<k&&c.children().eq(k).animate({opacity:"0"},1E3),
c.children().eq(b).css({opacity:"0"}),c.children().eq(b).animate({opacity:"1"},1E3));"slideup"==a.transition_type&&(-1<k&&(c.children().eq(k).animate({left:0,top:0},0),c.children().eq(k).animate({left:0,top:-h},700)),c.children().eq(b).animate({left:0,top:h},0),c.children().eq(b).animate({left:0,top:0},700));is_ios()&&-1<k&&"VIDEO"==c.children().eq(k).children().eq(0)[0].tagName&&c.children().eq(k).children().eq(0).get(0).pause();!is_ios()&&!is_ie8()&&-1<k&&epauseMovie(c.children().eq(k));u=!1;k=
b}if(!(k==b||!0==u)){var f=!1,e=c.children().eq(b),g=e.parent().children().index(e);e.hasClass("vplayer-tobe")&&(f=!0,a.videoplayersettings.videoWidth=n,a.videoplayersettings.videoHeight=q,"on"==a.autoplay&&0==g&&(a.videoplayersettings.autoplay="on"),"on"==a.autoplayNext&&0<g&&(a.videoplayersettings.autoplay="on"),e.vPlayer(a.videoplayersettings));u=!0;-1==k||!1==f?d():(i.parent().children(".preloader").fadeIn("fast"),setTimeout(d,1E3))}}var i=jQuery(this);m(this)[0].getAttribute("id");var d=0,o,
c,e,f,n,q,g,h,l=[],w=[],k=-1,p=0,r=0,u=!1;a.menuitem_width=parseInt(a.menuitem_width);a.menuitem_height=parseInt(a.menuitem_height);a.menuitem_space=parseInt(a.menuitem_space);d=jQuery(this).children().length;n=parseInt(jQuery(this).css("width"));q=parseInt(jQuery(this).css("height"));g=n;h=q;if(("right"==a.menu_position||"left"==a.menu_position)&&1<d)g+=a.menuitem_width+a.menuSpace;if(("bottom"==a.menu_position||"top"==a.menu_position)&&1<d)h+=a.menuitem_height+a.menuSpace;i.addClass(a.design_skin);
a.videoplayersettings.design_skin=a.design_skin;0==i.css("opacity")&&i.animate({opacity:1},1E3);i.parent().children(".preloader").fadeOut("fast");for(b=0;b<d;b++)w[b]=jQuery(this).children().eq(b),"on"==a.randomise?v(0,d):l[b]=b;i.append('<div class="sliderMain"><div class="sliderCon"></div></div>');i.append('<div class="navMain"><div class="navCon"></div></div>');o=jQuery(this).find(".sliderMain");c=jQuery(this).find(".sliderCon");is_ie8()&&c.addClass("sliderCon-ie8");e=jQuery(this).find(".navMain");
f=jQuery(this).find(".navCon");i.css({width:g,height:h});i.parent().hasClass("videogallery-con")&&i.parent().css({width:g,height:h});for(b=0;b<d;b++){var s=i.children().eq(l[b]).attr("data-description");-1<s.indexOf("{ytthumb}")&&(s=s.split("{ytthumb}").join('<img src="http://img.youtube.com/vi/'+i.children().eq(l[b]).attr("data-src")+'/0.jpg" class="imgblock"/>'));f.append('<div><div class="navigationThumb-content">'+s+"</div></div>");f.children().eq(b).addClass("navigationThumb");f.children().eq(b).css({width:a.menuitem_width,
height:a.menuitem_height});f.children().eq(b).click(y);"right"==a.menu_position||"left"==a.menu_position?f.children().eq(b).css({top:r}):f.children().eq(b).css({left:p});r+=a.menuitem_height+a.menuitem_space;p+=a.menuitem_width+a.menuitem_space}for(var b=0,b=0;b<d;b++)c.append(w[l[b]]);for(b=0;b<d;b++)is_ios();for(b=0;b<d;b++)c.children().eq(b).css({position:"absolute",top:"0px",left:p}),p+=g;o.css({width:g,height:h});"right"==a.menu_position&&e.css({width:a.menuitem_width,height:h,left:n});"left"==
a.menu_position&&(e.css({width:a.menuitem_width,height:h,left:0}),o.css({left:a.menuitem_width}));"bottom"==a.menu_position&&e.css({width:g,height:a.menuitem_height,top:q,left:0});"top"==a.menu_position&&(e.css({width:g,height:a.menuitem_height,top:0,left:0}),o.css({top:a.menuitem_height}));is_ios()&&e.css("overflow","auto");0!=a.menuSpace&&e.css({left:n+a.menuSpace});f.css({position:"relative"});jQuery(".navigationThumb").eq(0).height()*d>h&&e.mousemove(x);r=0;1==d&&(jQuery(this).css({width:n}),
e.hide());t(0);setInterval(function(){},5E3);m.fn.turnFullscreen=function(){jQuery(this).css({position:"static"});o.css({position:"static"})};m.fn.turnNormalscreen=function(){jQuery(this).css({position:"relative"});o.css({position:"relative"});for(b=0;b<d;b++)c.children().eq(b).css({position:"absolute"})};m.fn.vGallery.gotoItem=function(a){t(a)};return this})}})(jQuery);