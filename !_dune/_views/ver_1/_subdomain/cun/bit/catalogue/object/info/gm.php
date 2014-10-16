<p id="object-page-gm" class="object-page"><strong>�� �����</strong></p>
<?php
$flat_array = $this->to_map_add;
$name_x = $this->source_gm . 'gm_x';
$name_y = $this->source_gm . 'gm_y';
$flat_array[] = array(
                        'x' => $this->object->$name_x,
                        'y' => $this->object->$name_y,
                        'comment' => $this->comment,
                        'img_url' => 'base',
						'img_width' => 50,
						'img_height' => 22,
                     );
/*echo '<pre>';
print_r($flat_array);
echo '</pre>';
*/
$position_x = $this->object->$name_x;
$position_y = $this->object->$name_y;

$key = 'ABQIAAAALTPVufm_y4bze0hX1-F_0xQ64M88eiGkd3KF9GpFOogMWcJRjRRhybXmKu1xOECLPguC2MOBY2gJcg';

if (Dune_Parameters::$subDomain and isset(Special_Vtor_SubDomain::$googleMapsCode[Dune_Parameters::$subDomain]))
{
    $key = Special_Vtor_SubDomain::$googleMapsCode[Dune_Parameters::$subDomain];
}

?>
<script charset="utf-8" src="http://maps.google.com/maps?file=api&amp;v=2&amp;&hl=ru&amp;key=<?php echo $key; ?>"
            type="text/javascript"></script>
<script charset="utf-8" type="text/javascript">


// Создание основного значка
function createMarker(point, index, comment, img_url, img_width, img_height) {
	var baseIcon = new GIcon(G_DEFAULT_ICON);

	if(img_url == 'base') {
		var markerOptions = { icon:baseIcon, draggable:false };
	} else {
		var lenkomIcon = new GIcon(baseIcon);
		lenkomIcon.iconSize = new GSize(img_width, img_height);
		lenkomIcon.image = img_url;
		var markerOptions = { icon:lenkomIcon, draggable:false };
	}
	
	var marker = new GMarker(point, markerOptions);
	
/*	GEvent.addListener(marker, "click", function() {
   		marker.openInfoWindowHtml(comment);
	});
*/	
/*	GEvent.addListener(marker, "dragend", function() {
   		var markerInfo = marker.getLatLng();
   		alert('x: ' + markerInfo.lat() + "\ny: " + markerInfo.lng());
	});
*/	
	return marker;
}


// �?нициализация
function initialize() {
	// Создаем карту
	var map = new GMap2(document.getElementById("map_canvas"));
	map.setCenter(new GLatLng(<?php echo $position_x;  ?>, <?php echo $position_y; ?>), 14);
	map.addControl(new GLargeMapControl());
	map.addControl(new GMapTypeControl());
//	map.enableScrollWheelZoom();
	map.disableScrollWheelZoom();
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

    <div id="map_canvas" style="margin:10px auto 10px auto; width: 700px; height: 500px"></div>
