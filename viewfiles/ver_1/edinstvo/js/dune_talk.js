var count = 0;

var check_activity = 'no';

var sendMessageEnable = 1;

$(document).ready(function()
{
	lookMessages();
// ---- ����� -----
  var options = { 
    // �������, ������� ����� �������� �� ������ ������� 
    type: "POST",	
//  	target: "#output",
    url: $("#this_url").attr('value') + '?useajax=yes',	
    beforeSubmit: showRequest, // �������, ���������� ����� ��������� 
    success: showResponse, // �������, ���������� ��� ��������� ������
    timeout: 3000 // ����-���
  };
  
  // ����������� ������� submit � �����
  $("#t-form").submit(function() {
  	if(sendMessageEnable == 1) {
	    $(this).ajaxSubmit(options);
	    sendMessageEnable = 0;
	    // !!! ����� !!! 
	    // ������ ���������� false, ����� ������������ �����������
	    // �������� �������� (������� �� �������� form.php) 
  	}
    return false;
  }); 
// ---- ����� -----

	
 $("#textarea-text").keypress(function(event, formElem) 
{
	if((event.ctrlKey) && ((event.keyCode == 0xA)||(event.keyCode == 0xD))) { $("#t-form").submit(); } 
	
});
 
 
	
});
	
	
function lookMessages()
{
  var cmd = "lookMessages()";
//  alert('������');
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
//			alert("������ ���������: " + data);
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
	
// ����� ����� ��������� ������
function showRequest(formData, jqForm, options) { 
    // formData - ������; ����� ������������ $.param ����� ������������� ��� � ������ ��� ������ � alert(),
    // (������ � ���������������� �����), �� � ����� ������� jQuery Form ��� ����������� �������������.
    var queryString = $.param(formData); 
    // jqForm ��� jQuery ������, ���������� �������� �����.
    // ��� ������� � ��������� ����� ����������� 
    // var formElement = jqForm[0]; 
//    alert('��� ��� �� ��������: \n\n' + queryString); 
    // ����� ����� ������� false ����� ��������� �������� �����; 
    // ����� �������� �� fals �������� �������� �������� �����.
    return true; 
} 
 
// ����� ����� ��������� ������ 
function showResponse(responseText, statusText)  { 
    // ��� �������� html ������, ������ �������� - �������� responseText
    // ������� XMLHttpRequest
 
    // ���� ����������� ����� ajaxSubmit (��� ajaxForm) � �������������� ����� dataType 
    // ������������� � 'xml', ������ �������� - �������� responseXML
    // ������� XMLHttpRequest
 
    // ���� ����������� ����� ajaxSubmit (��� ajaxForm) � �������������� ����� dataType
    // ������������� � 'json', ������ �������� - ����� json, ������������ ��������.
 	
	if (responseText.length > 10)
	{
		 $("#edge").before(responseText);
// 		 $("#talk-list").animate({ scrollTop: 100000000}, 1100 );
	     location.replace("#edge");
 		 $("#textarea-text").attr('value', '');
		 $("#textarea-text").focus();
 		 sendMessageEnable = 1;
	}
	
//    alert('������ ������ �������: ' + statusText + '\n\n����� ������ �������: \n' + responseText + 
//        '\n\n������� ������� div ���������� ���� �������.'); 
}
	