<h1>Заявка на размещение квартиры в каталоге</h1>

<?php
//echo $this->steps_panel;
?>

<?php switch ($this->message_code) { 
case 1: ?>
<p id="system-message">Не заполнены обязательные поля.</p>
<?php break; ?> 

<?php case 2: ?>
<p id="system-message">Запрещено слишком часто отправлять пакеты.</p>
<?php break; ?> 

<?php case 3: ?>
<p id="system-message">Потеря сеанса.</p>
<?php break; ?> 

<?php case 4: ?>
<p id="system-message">Вы достигли лимита колличества объектов отправленных на обработку модератору. Ждите, мы с Вами свяжемся.</p>
<?php break; ?> 

<?php case 5: ?>
<p id="system-message">Ошибка. Сделайте повторную попытку сохранения данных.</p>
<?php break; ?> 


<?php } 
echo $this->steps_panel;
?>

<div id="object-under-bookmark">

<div id="object-info">

<div id="object-sell">
<form method="post">



<span style="color:red;" id="pos_message"></span>
<!--           Графика                   -->
<div id="edit-object-pics">

<?php
$flat_array = array();
$def = array(
						'x' => 54.61005615077809,
						'y' => 39.70310926437378,
						'comment' => 'Пример',
						'img_url' => 'http://www.ok62.ru/img/map/lenkom.gif',
						'img_width' => 50,
						'img_height' => 40,
					);
/*echo '<pre>';
print_r($flat_array);
echo '</pre>';
*/

if (strlen($this->data['gm_x']) < 4)
    $position_x = $def['x'];
else 
    $position_x = $this->data['gm_x'];

if (strlen($this->data['gm_y']) < 4)
    $position_y = $def['y'];
else 
    $position_y = $this->data['gm_y'];
    
$flat_array[] = array(
                        'x' => $position_x,
                        'y' => $position_y,
                        'comment' => '',
                        'img_url' => 'base',
						'img_width' => 50,
						'img_height' => 22,
                     );

    
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
	
//	GEvent.addListener(marker, "click", function() {
//   		marker.openInfoWindowHtml(comment);
//	});
	
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

    <div id="map_canvas" style="width: 100%; height: 500px"></div>

</div>



<input style="display:none;" id="pos_x" name="gm_x" value="<?php echo $this->data['gm_x']; ?>" />
<input style="display:none;" id="pos_y" name="gm_y" value="<?php echo $this->data['gm_y']; ?>" />

<!--
<input name="gm_x" id="pos_x" type="hidden" value="<?php echo $this->data['gm_y']; ?>" />
<input name="gm_y" id="pos_y" type="hidden" value="<?php echo $this->data['gm_x']; ?>" />
-->

<input name="type" type="hidden" value="<?php echo $this->type; ?>" />
<input name="_do_" type="hidden" value="<?php echo $this->do; ?>" />
<input name="id" type="hidden" value="<?php echo $this->id; ?>" />
<p class="submit-tipa-big">
<input name="go" type="submit" value="Сохранить" />
</p>
</form>
</div>
</div>
<div class="ugol-left-top"></div>
<div class="ugol-left-bottom"></div>
<div class="ugol-right-top"></div>
<div class="ugol-right-bottom"></div>

</div>
