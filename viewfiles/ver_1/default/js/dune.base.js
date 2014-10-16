$(document).ready(function() {


	 var clickhide = 1;
     $('.click-out-hide').click(function(){ alert('1');
												  clickhide = 0;
											  });

		$('body').click(function(){
								  if (clickhide == 1)
								  {
								  $('.click-out-hide').addClass('no-display');									  
								  }
								clickhide = 1;
							 });


    $("ul#li-scroll").removeClass('no-script'); 	
    $("ul#li-scroll").liScroll({travelocity: 0.03}); 

    $(".tickercontainer").corner(); 	
/*	
    $("ul#li-scroll li span.background").corner(); 	
    $("ul#li-scroll li").addClass('scroller-background');
    $("ul#li-scroll li span.background").removeAttr('width');	
    $("ul#li-scroll li span.background").removeAttr('width');		
*/	
});