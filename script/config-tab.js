
$(document).ready(function(){
	$('.tabbing-wrapper .tabbing-content').hide();
	$('.tabbing-wrapper .tabbing-content:first').fadeIn();
	$('.tabbing-wrapper .tabbing-title ul li:first').addClass('active');
	$('.tabbing-wrapper .tabbing-title ul li a').click(function(){ 
	$('.tabbing-wrapper .tabbing-title ul li').removeClass('active');
	$(this).parent().addClass('active'); 
	var currentTab = $(this).attr('href'); 
	$('.tabbing-wrapper div.tabbing-content').hide();
	$(currentTab).slideToggle(600);
	return false;
	});
});
