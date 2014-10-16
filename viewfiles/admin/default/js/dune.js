$(document).ready(function() {
$('.list-table tr').hover(
							  function(){$(this).addClass('hilight-hover');},
							  function(){$(this).removeClass('hilight-hover');}
							  );

$('.list-table-js tr').hover(
							  function(){$(this).addClass('hilight-hover');},
							  function(){$(this).removeClass('hilight-hover');}
							  );

$("#tabs-menu > ul").tabs();

});