var count = 0;

var check_activity = 'no';

var sendMessageEnable = 1;

$(document).ready(function()
{
	lookMessages();
// ---- Форма -----
  var options = { 
    // элемент, который будет обновлен по ответу сервера 
    type: "POST",	
//  	target: "#output",
    url: $("#this_url").attr('value') + '?useajax=yes',	
    beforeSubmit: showRequest, // функция, вызываемая перед передачей 
    success: showResponse, // функция, вызываемая при получении ответа
    timeout: 3000 // тайм-аут
  };
  
  // привязываем событие submit к форме
  $("#t-form").submit(function() {
  	if(sendMessageEnable == 1) {
	    $(this).ajaxSubmit(options);
	    sendMessageEnable = 0;
	    // !!! Важно !!! 
	    // всегда возвращаем false, чтобы предупредить стандартные
	    // действия браузера (переход на страницу form.php) 
  	}
    return false;
  }); 
// ---- Форма -----

	
 $("#textarea-text").keypress(function(event, formElem) 
{
	if((event.ctrlKey) && ((event.keyCode == 0xA)||(event.keyCode == 0xD))) { $("#t-form").submit(); } 
	
});
 
 
	
});
	
	
function lookMessages()
{
  var cmd = "lookMessages()";
//  alert('Момент');
	if (count != 0)
	{
		$.post($("#this_url").attr('value'), { _do_: "get_last", time: $("#edge").html() }, function(data){
	  	if (data.length > 0)
		{
			var ind = data.indexOf("-");
			$("#edge").html(data.substr(0, ind));
		}
	  	if (data.length > 20)
		{
//			alert("Данные загружены: " + data);
		  	$("#edge").before(data.substr(ind+1));
//	  		$("#talk-list").animate({ scrollTop: 100000000}, 1 );
			location.replace("#edge");
//    		$("#talk-list").slideDown("fast");
		}
		});		
		
  
//  $("#edge").html($("#edge").html() + 10);
  
	}
  count++;
  timer = window.setTimeout(cmd, 5000);
}	
	
// вызов перед передачей данных
function showRequest(formData, jqForm, options) { 
    // formData - массив; здесь используется $.param чтобы преобразовать его в строку для вывода в alert(),
    // (только в демонстрационных целях), но в самом плагине jQuery Form это совершается автоматически.
    var queryString = $.param(formData); 
    // jqForm это jQuery объект, содержащий элементы формы.
    // Для доступа к элементам формы используйте 
    // var formElement = jqForm[0]; 
//    alert('Вот что мы передаем: \n\n' + queryString); 
    // здесь можно вернуть false чтобы запретить отправку формы; 
    // любое отличное от fals значение разрешит отправку формы.
    return true; 
} 
 
// вызов после получения ответа 
function showResponse(responseText, statusText)  { 
    // для обычного html ответа, первый аргумент - свойство responseText
    // объекта XMLHttpRequest
 
    // если применяется метод ajaxSubmit (или ajaxForm) с использованием опции dataType 
    // установленной в 'xml', первый аргумент - свойство responseXML
    // объекта XMLHttpRequest
 
    // если применяется метод ajaxSubmit (или ajaxForm) с использованием опции dataType
    // установленной в 'json', первый аргумент - объек json, возвращенный сервером.
 	
	if (responseText.length > 10)
	{
		 $("#edge").before(responseText);
// 		 $("#talk-list").animate({ scrollTop: 100000000}, 1100 );
	     location.replace("#edge");
 		 $("#textarea-text").attr('value', '');
		 $("#textarea-text").focus();
 		 sendMessageEnable = 1;
	}
	
//    alert('Статус ответа сервера: ' + statusText + '\n\nТекст ответа сервера: \n' + responseText + 
//        '\n\nЦелевой элемент div обновиться этим текстом.'); 
}
	