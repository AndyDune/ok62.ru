<h1>Редактирование объекта. Позиция на GM.</h1>
<div id="edit-object-container">
<?php
$o_form = new Dune_Form_Form();
$o_form->setMethod(Dune_Form_Form::METHOD_POST);
$o_form->setEnctype(Dune_Form_Form::ENCTYPE_MULTI);
echo $o_form->getBegin();
$o_hidden_do = new Dune_Form_InputHidden('_do_');
$o_hidden_do->setValue('save_gm');
echo $o_hidden_do;
$o_hidden_do = new Dune_Form_InputHidden('id');
$o_hidden_do->setValue($this->data->id);
echo $o_hidden_do;

$o_submit = new Dune_Form_InputSubmit('Сохранить');
$o_submit->setValue('Сохранить');

if ($this->enother)
{
    ?><strong style="color:red;">Данные соседнего объекта.</strong><?php
}
?>

X:<input id="pos_x" name="pos_x" value="<?php echo $this->pos_x ?>" />
Y:<input id="pos_y" name="pos_y" value="<?php echo $this->pos_y ?>" />
<?php echo $o_submit->get();?>
</form><span style="color:red;" id="pos_message"></span>
<!--           Графика                   -->
<dl>
<dt>По адресу</dt>
<dd>
<?php echo $this->data->name_settlement; ?>, <?php echo $this->data->name_street; ?>, дом <?php echo $this->data->house_number; ?>
, корпус <?php echo $this->data->house_building; ?>
, номер <?php echo $this->data->room; ?>

</dd>
</dl>
<div id="edit-object-pics">
<h2>На карте</h2>

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
   		$('#pos_message').html('Данные сменились');
   		
   		
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
	map.enableScrollWheelZoom();
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

    <div id="map_canvas" style="width: 700px; height: 500px"></div>

</div>




</div>
