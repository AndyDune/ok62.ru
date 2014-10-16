$(document).ready(function() {
	
	$('.input-deal').click(function(){
											$('.input-deal-request').removeAttr('checked');
											});
	$('.input-deal-request').click(function(){
											$('.input-deal').removeAttr('checked');
											});
	
});