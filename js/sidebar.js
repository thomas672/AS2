
$(function() {
    $('.menuBtn').click(function(){
    	$('#menuSidebar').toggleClass('menu-hide');
		return false;
    })
    $('html').click(function(){
    	$('#menuSidebar').removeClass('menu-hide');
    })
});