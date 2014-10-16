<div id="edit-object-container">
<?php
$o_form = new Dune_Form_Form();
$o_form->setMethod(Dune_Form_Form::METHOD_POST);
$o_form->setEnctype(Dune_Form_Form::ENCTYPE_MULTI);
echo $o_form->getBegin();
$o_hidden_do = new Dune_Form_InputHidden('_do_');
$o_hidden_do->setValue('make_gm');
echo $o_hidden_do;

$o_submit = new Dune_Form_InputSubmit('Сохранить');
$o_submit->setValue('Перейти по ссылке.');

?>

X:<input id="pos_x" name="pos_x" value="<?php echo $this->pos_x ?>" />
Y:<input id="pos_y" name="pos_y" value="<?php echo $this->pos_y ?>" />
<input type="hidden" name="domain" id="domain_name" value="<?php echo $this->domain ?>" />
<?php echo $o_submit->get();?>
</form><span style="color:red;" id="pos_message"></span>
<p>Ссылка с учетом позиционирования: <span style=" display:none; background-color: #F6F6CC; padding: 5px;">http://<?php echo $this->domain ?>/map/public/<span class="pos_x"><?php echo $this->pos_x ?></span>_<span class="pos_y"><?php echo $this->pos_y ?></span>/</span>
<input type="text" size="75" id="focus_and_mark" name="link" value="http://<?php echo $this->domain ?>/map/public/<?php echo $this->pos_x ?>_<?php echo $this->pos_y ?>/" /></p>
<!--           Графика                   -->
<div id="edit-object-pics">
<h2>Целеуказание на карте</h2>
<p>Кликните на указателе мышкой и, удерживая кнопку нажатой, двигайте курсор для смены позиции.</p>
<?php
$flat_array = array();
$flat_array1[] = array(
						'x' => 54.61005615077809,
						'y' => 39.70310926437378,
						'comment' => 'Пример',
						'img_url' => 'http://www.ok62.ru/img/map/lenkom.gif',
						'img_width' => 50,
						'img_height' => 40,
					);
$flat_array[] = array(
                        'x' => $this->pos_x,
                        'y' => $this->pos_y,
                        'comment' => '',
                        'img_url' => 'base',
						'img_width' => 50,
						'img_height' => 22,
                     );
/*echo '<pre>';
print_r($flat_array);
echo '</pre>';
*/
$position_x = $this->pos_x;
$position_y = $this->pos_y;
?>
<script charset="utf-8" src="http://maps.google.com/maps?file=api&amp;v=2&amp;&hl=ru&amp;key=ABQIAAAALTPVufm_y4bze0hX1-F_0xQ64M88eiGkd3KF9GpFOogMWcJRjRRhybXmKu1xOECLPguC2MOBY2gJcg"
            type="text/javascript"></script>
<script charset="utf-8" type="text/javascript">

$('#focus_and_mark').focus(function(){
    $(this).select();
});


// РЎРѕР·РґР°РЅРёРµ РѕСЃРЅРѕРІРЅРѕРіРѕ Р·РЅР°С‡РєР°
function createMarker(point, index, comment, img_url, img_width, img_height) {
	var baseIcon = new GIcon(G_DEFAULT_ICON);

	if(img_url == 'base') {
		var markerOptions = { icon:baseIcon, draggable:true };
	} else {
		var lenkomIcon = new GIcon(baseIcon);
		lenkomIcon.iconSize = new GSize(img_width, img_height);
		lenkomIcon.image = img_url;
		var markerOptions = { icon:lenkomIcon, draggable:true };
	}
	
	var marker = new GMarker(point, markerOptions);
	
	GEvent.addListener(marker, "click", function() {
   		marker.openInfoWindowHtml(comment);
	});
	
	GEvent.addListener(marker, "dragend", function() {
   		var markerInfo = marker.getLatLng();
   		
   		
//   		alert('x: ' + markerInfo.lat() + "\ny: " + markerInfo.lng());
   		
   		$('#pos_x').attr('value',markerInfo.lat());
   		$('#pos_y').attr('value',markerInfo.lng());
   		$('.pos_x').html(markerInfo.lat());
   		$('.pos_y').html(markerInfo.lng());
   		
   		$('#focus_and_mark').attr('value', 'http://' + $('#domain_name').attr('value') + '/map/public/' + markerInfo.lat() + '_' + markerInfo.lng() + '/');
//   		$('#pos_message').html('Данные сменились');
   		
   		
	});
	
	return marker;
}


// Р?РЅРёС†РёР°Р»РёР·Р°С†РёСЏ
function initialize() {
	// РЎРѕР·РґР°РµРј РєР°СЂС‚Сѓ
	var map = new GMap2(document.getElementById("map_canvas"));
	map.setCenter(new GLatLng(<?php echo $position_x;  ?>, <?php echo $position_y; ?>), 14);
	map.addControl(new GLargeMapControl());
	map.addControl(new GMapTypeControl());
	map.disableScrollWheelZoom();
//	map.enableScrollWheelZoom();
//	map.addControl(new GScaleControl());
//	map.addControl(new GHierarchicalMapTypeControl());
	
	<?php
	foreach ($flat_array as $key => $data) {
	    
//    $comm = iconv('windows-1251', 'utf-8', $data['comment']);
    if ($data['img_url'] != 'base')
    {
        $data['img_url'] = 'http://' . $this->domain . $data['img_url'];
    }
//    $data['comment'] = $comm;
	    
		?>
		var point = new GLatLng(<?php echo $data['x'];?>, <?php echo $data['y'];?>);
		map.addOverlay(createMarker(point, <?php echo $key;?>, '<?php echo $data['comment'];?>', '<?php echo $data['img_url'];?>', <?php echo $data['img_width'];?>, <?php echo $data['img_height'];?>));
		<?php
	}
	?>
	
	
	
	
}


$(document).ready(function()
{
initialize();
//GUnload();
});
</script>

    <div id="map_canvas" style="width: 100%; height: 600px"></div>

</div>




</div>
