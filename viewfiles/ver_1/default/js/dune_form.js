$(document).ready(function()
{

$('.title-to-value').each(function(){
								   var str = $(this).attr('value');
								   if (str == null)
								   	str  = '';
								   if (str.length < 1)
								   {
									   $(this).attr('value', $(this).attr('title'));
									   $(this).addClass('form-field-empty');
								   }
								   });

$('.title-to-value').focus(function(){
								   if ($(this).hasClass('form-field-empty'))
								   {
									   $(this).attr('value', '');
									   $(this).removeClass('form-field-empty');
								   }
								   });
$('.title-to-value').blur(function(){
								   var str = $(this).attr('value');
								   if (str == null)
								   	str  = '';
								   if (str.length < 1)
								   {
									   $(this).attr('value', $(this).attr('title'));
									   $(this).addClass('form-field-empty');
								   }
								   });

$('form').submit(function(){
	$('.title-to-value', this).each(function(){
									   if ($(this).hasClass('form-field-empty'))
									   {
										   $(this).attr('value', '');
										   $(this).removeClass('form-field-empty');
									   }
									   });
						  });
	
});
