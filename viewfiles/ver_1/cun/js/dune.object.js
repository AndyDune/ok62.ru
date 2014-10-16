$(document).ready(function()
{

$('.tooltip').tooltip({
	track: true,
	delay: 0,
	showURL: false,
	showBody: "- ",
	opacity: 0.98
});

$('#object-info-developer').css('display', 'none');

$('#switch-some li a').click(function(){
									  $('#switch-some li').each(function(){
																		 $(this).removeClass('current');
																		 });
									  
									  $('.switch-some-div').each(function(){
																		 $(this).css('display', 'none');
																		 });
									  $($(this).attr('href')).css('display', 'block');
									  $(this).parent().addClass('current');
									  
									  return false;
									  });



});