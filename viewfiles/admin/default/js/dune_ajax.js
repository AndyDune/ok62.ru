$(document).ready(function() {

$.ajaxSetup({
  dataType: "html"
});
						   
   
  // --------------
  $("#ajax-f").change(
    function () {
$.post(
  '/ajax/',
  {
    type: "test-request",
    id: $("option:selected", this).attr("value"),
    param2: 2
  }
  , function(data){$(":text").attr("value", data);}
);		
    });
  // --------------
  $("#registry-name-check").click(
    function () {
								  //$("#input-name").next().remove();
								  if (typeof($("#input-name").attr("value")) == "string")
								  {
$.post(
  '/doorway/registry/',
  {
    type: "test-request",
    name: $("#input-name").attr("value"),
    param2: 2
  }
  , function(data){
//	  $("#input-name").after(data);
	  $("#ajax-form-check-name").html(data);
	  }
);		
								  }
	return false;
    });
});