$(document).ready(function()
{

	if (check_activity == null)
		var check_activity = '';

    if (check_activity.length < 2)
    {
		checkActivity();
	}


$(".setread").live("click", function(){
$.post($(this).attr('href'), {useajax: "yes", _do_: "setread"}, function(data){
																$("#user-enter-form-ajax").html('');
																$("#user-enter-form-ajax").html(data);
														  });
$(this).parents(".look-for-massage").css('display', 'none');
return false;

});

}); // Конец


function checkActivity()
{
  var cmd = "checkActivity()";
//  alert('Момент');
		$.post('/user/check/talk/', {useajax: "yes", _do_: "check_talk"}, function(data){
	  	if (data.length > 10)
		{
			$("#user-enter-form-ajax").html('');
			$("#user-enter-form-ajax").html(data);
		}
	  	if (data.length > 20)
		{
//			alert("Данные загружены: " + data);
//		  	$("#edge").before(data.substr(ind+1));
//	  		$("#talk-list").animate({ scrollTop: 100000000}, 1 );
//			location.replace("#edge");
//    		$("#talk-list").slideDown("fast");
		}
																	});
  		
//  $("#edge").html($("#edge").html() + 10);
  
  timer = window.setTimeout(cmd, 40000);
}	
