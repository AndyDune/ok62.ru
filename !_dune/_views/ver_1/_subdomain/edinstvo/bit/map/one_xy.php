<?php
$flat_array = $this->to_map_add;

$array[] = array(
                        'x' => 54.616797215799025,
                        'y' => 39.72249627113342,
                        'comment' => '',
                        'img_url' => 'base',
						'img_width' => 50,
						'img_height' => 22,
                     );
/*echo '<pre>';
print_r($flat_array);
echo '</pre>';
*/
$income = $this->data;
if (isset($income['x']))
{
    $array[0]['x'] = $income['x'];
    $array[0]['y'] = $income['y'];
    if (isset($income['title']))
        $array[0]['title'] = $income['title'];
}

$position_x = $array[0]['x'];
$position_y = $array[0]['y'];

?>
<script charset="utf-8" src="http://maps.google.com/maps?file=api&amp;v=2&amp;&hl=ru&amp;key=ABQIAAAALTPVufm_y4bze0hX1-F_0xQ64M88eiGkd3KF9GpFOogMWcJRjRRhybXmKu1xOECLPguC2MOBY2gJcg"
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
	map.enableScrollWheelZoom();
//	map.addControl(new GScaleControl());
//	map.addControl(new GHierarchicalMapTypeControl());
	

	<?php foreach ($array as $key => $value) {
	 if (isset($value['image']) and strlen($value['image']) > 5  and isset($value['iconSize']))   
	 {
	     $value['image'] = 'http://' . $this->domain . '/' . $this->image_path . '/' . $value['image'];
	    ?>
	var baseIcon = new GIcon(G_DEFAULT_ICON);
	var edinstvoIcon = new GIcon(baseIcon);
	edinstvoIcon.image = "<?php echo $value['image'] ?>";
	<?php if (isset($value['shadow']))
	 {
	    $value['shadow'] = 'http://' . $this->domain . '/' . $this->image_path . '/' .  $value['shadow'];
	    ?>
	edinstvoIcon.shadow = "<?php echo $value['shadow'] ?>";
	<?php } ?>
	<?php if (isset($value['iconSize'])) { ?>
	edinstvoIcon.iconSize = new GSize(<?php echo $value['iconSize'][0]  ?>, <?php echo $value['iconSize'][1] ?>);
	<?php }
	if (isset($value['shadowSize'])) { ?>
	edinstvoIcon.shadowSize = new GSize(<?php echo $value['shadowSize'][0]  ?>, <?php echo $value['shadowSize'][1] ?>);
	<?php }
	if (isset($value['iconAnchor'])) { ?>
	edinstvoIcon.iconAnchor = new GPoint(<?php echo $value['iconAnchor'][0]  ?>, <?php echo $value['iconAnchor'][1] ?>);
	<?php }
	  }
      else 
      {
            ?> var edinstvoIcon = new GIcon(G_DEFAULT_ICON); <?php
      }
	?>
	var markerOptions = { icon:edinstvoIcon<?php 
    if (isset($value['title'])) { ?>, title:'<?php echo $value['title'] ?>'<?php }
	?> };
	var point = new GLatLng(<?php echo $value['x'] ?>, <?php echo $value['y'] ?>);
	var marker<?php echo $key; ?> = new GMarker(point, markerOptions);
	
    <?php if (isset($value['comment'])) { ?>	
	GEvent.addListener(marker<?php echo $key; ?>, "click", function() {
	    var comment = '<?php echo str_replace(array("/n", "/r"), array('',''), $value['comment']) ?>';
   		marker<?php echo $key; ?>.openInfoWindowHtml(comment);
	});
	<?php } ?>
	map.addOverlay(marker<?php echo $key; ?>);
	<?php } ?>


	<?php
	if (false) {
	foreach ($array as $key => $data) {
	    
//    $comm = iconv('windows-1251', 'utf-8', $data['comment']);
    if ($data['img_url'] != 'base')
    {
//        $data['img_url'] = 'http://' . $this->domain . $data['img_url'];
    }
//    $data['comment'] = $comm;
	    
		?>
		var point = new GLatLng(<?php echo $data['x'];?>, <?php echo $data['y'];?>);
		map.addOverlay(createMarker(point, <?php echo $key;?>, '<?php echo $data['comment'];?>', '<?php echo $data['img_url'];?>', <?php echo $data['img_width'];?>, <?php echo $data['img_height'];?>));
		<?php
	} }
	?>
}



$(document).ready(function()
{
initialize();
//GUnload();
});
</script>

    <div id="map_canvas" style="margin:10px auto 10px auto; width: 700px; height: 500px"></div>
