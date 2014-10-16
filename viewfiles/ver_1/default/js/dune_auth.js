$(document).ready(function()
{

	 var cl = 1;
     $('#user-enter-form-hidden').click(function(){
												  cl = 0;
											  });

		$('body').click(function(){
								  if (cl == 1)
								  {
								  $('#user-enter-form-hidden').addClass('no-display');									  
								  }
								cl = 1;
							 });

	
	$('#user-enter-form-show').click(function(){
//											  $('#user-enter-form-hidden').css('display','block');
											  $('#user-enter-form-hidden').removeClass('no-display');
											  return false;
											  });
	$('#user-enter-form-hide').click(function(){
//											  $('#user-enter-form-hidden').css('display','none');
											  $('#user-enter-form-hidden').addClass('no-display');
											  return false;
											  });
	
});
