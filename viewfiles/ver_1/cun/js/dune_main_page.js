$(document).ready(function() {
	// Раздача уникальных идентификаторов		
//	var menuList = $("#ul-bookmark li.bookm-flop");
	var current_form = '#type_1_form';
	
	$('#to-find-top-bottom').click(function(){
											$(current_form).submit();
											});
	
	var menuList = $("#select-bookmark");	
	
	var sellerList = $("#select-seller");	
	var dealList = $("#select-deal");		
	
	
//    $(".corners").corner(); 	
//    $('.down-bookmark-li').css('display','none');
//	$('.down-bookmark-li').addClass('no-display');
//    $('.down-seller-li').css('display','none');	
//	$('.down-seller-li').addClass('no-display');											


	 var click_hide_seller = 1;
	 var click_hide_type = 1;	 

	var cssindex = 50;
	var was = false;	
//	$(".accordion p").hide();	
	menuList.each(function (i)
				 {
					$(this).change(
								function()
									{
										var str = $('option:selected', this).attr("value");
										var ind = str.indexOf("#");
										if (ind != -1)
										{
//											var subs = str.substr(ind);
											var subs = str;
											current_form = str + '_form';
//											$(subs).css("top", "200px");
											$(subs).css("opacity", "0");
											$(subs).css("z-index", cssindex);
											$(subs).animate({top: "0px", opacity: "1"}, "slow");
											if (was)
											{
												was = subs;
											}
											cssindex++;
											//alert(str.substr(ind + 1) + " символов: " + str.length);
										}
										
//										$('.current-bookmark-span a').removeClass('corner');
										click_hide_seller = 0;
//										return(false);
									}
								  );
				 });


	var was = false;	
//	$(".accordion p").hide();	
	sellerList.each(function (i)
				 {	
					$(this).change(
								function()
									{
										//var str = $('option:selected', this).attr("value");
										var list = $('option:selected', this);
										$('form input').remove('.filter-seller');
										list.each(function(i){
														   var str = $(this).attr("value");
														   if (str == 'sk' && false)
														   {
															   var list = $('option.sk');
															   list.each(function(i){
																				   $(this).attr('selected', 'selected');
																				   $('form').append('<input type="hidden" value="' + $(this).attr('value') +'" name="seller_array[]" class="filter-seller" />')
																				  
																				  });
														   }
														   else if (str == 'an' && false)
														   {
															   var list = $('option.an');
															   list.each(function(i){
																				   $(this).attr('selected', 'selected');
																				   $('form').append('<input type="hidden" value="' + $(this).attr('value') +'" name="seller_array[]" class="filter-seller" />')
																				  
																				  });
														   }
														   else
														   {
															   $('form').append('<input type="hidden" value="' + str +'" name="seller_array[]" class="filter-seller" />')
														   }
														   });
									}
								  );
				 });





	dealList.each(function (i)
				 {	
					$(this).change(
								function()
									{
										//var str = $('option:selected', this).attr("value");
										var list = $('option:selected', this);
										$('form input').remove('.filter-deal');
										list.each(function(i){
														   var str = $(this).attr("value");
														   $('form').append('<input type="hidden" name="' + str +'" value="1" class="filter-deal" />')

														   });
									}
								  );
				 });

	 var clickhide = 1;

		$('body').click(function(){
								  if (clickhide == 1)
								  {
    						      $('.down-seller-li').addClass('no-display');
    						      $('.down-bookmark-li').addClass('no-display');
     							$(".current-bookmark-li a.length_big_2lines").removeClass('length_big_2lines_active');
     							$(".current-bookmark-li a.length_very_small").removeClass('length_very_small_active');								
								
     							$(".current-seller-li a.length_big_2lines").removeClass('length_big_2lines_active');
     							$(".current-seller-li a.length_very_small").removeClass('length_very_small_active');								
								
								  }
								clickhide = 1;
							 });


	$('#filter-panorama').click(function(){
											   if($(this).attr('checked') == true)
											   {
											   	   $('.filter-panorama').attr('value', 1);
											   }
											   else
											   {
										   	      $('.filter-panorama').attr('value', 0);
											   }
											   
											   });
	$('#filter-online').click(function(){
											   if($(this).attr('checked') == true)
											   {
											   	   $('.filter-online').attr('value', 1);
											   }
											   else
											   {
										   	      $('.filter-online').attr('value', 0);
											   }
											   
											   });

	$('#filter-fseller').click(function(){
											   if($(this).attr('checked') == true)
											   {
											   	   $('.filter-fseller').attr('value', 1);
											   }
											   else
											   {
										   	      $('.filter-fseller').attr('value', 0);
											   }
											   
											   });

});