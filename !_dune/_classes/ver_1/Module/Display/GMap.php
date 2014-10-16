<?php

class Module_Display_GMap extends Dune_Include_Abstract_Code
{

    protected function code()
    {
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        

$key = 'ABQIAAAALTPVufm_y4bze0hX1-F_0xQ64M88eiGkd3KF9GpFOogMWcJRjRRhybXmKu1xOECLPguC2MOBY2gJcg';


if (Dune_Parameters::$subDomain and isset(Special_Vtor_SubDomain::$googleMapsCode[Dune_Parameters::$subDomain]))
{
    $key = Special_Vtor_SubDomain::$googleMapsCode[Dune_Parameters::$subDomain];
}

if (!$this->domain)
    $this->domain = 'ok62.ru';

if (!$this->image_path)
    $this->image_path = 'img/map';

if (!$this->house_path)
    $this->house_path = 'img/house';

if (!$this->group_path)
    $this->group_path = 'img/group';
    

if (!$this->zoom)
    $this->zoom = 11;

if (is_null($this->show_gm_link))
    $this->show_gm_link = true;
    
if (is_null($this->show_main))
    $this->show_main = true;

if (is_null($this->script_link))
    $this->script_link = false;
    
    
if (is_null($this->show_script_tag))
{
    $this->show_script_tag = true;
}
    
if (!$this->id)
    $this->id = 'map';
    
    
$center_ryazan = array(
						'x' => '54.61343614230355',
						'y' => '39.727935791015625'
					);
					
$center_sochi = array(
						'x' => '43.60724507891402',
						'y' => '39.725189208984375'
					);


// Â äàëüíåéøåì ïðèñàáà÷èòü äëÿ ëþáîãî ïîñåëêà !
if ($this->adress_object and
    $this->adress_object instanceof Special_Vtor_Adress
    and
$this->adress_object->getSettlementId() == 32)
{
    $this->data_center = $center_sochi;
}	
				
$data = $this->data;
if (!is_array($data))
    $data = array();
					
$edinstvo_data  = array( // Åäèíñòâî
             		    'x' => 54.616797215799025,
                    	'y' => 39.72249627113342,
                    	'title'   => 'ÇÀÎ «Ãðóïïà êîìïàíèé «ÅÄÈÍÑÒÂÎ»',
                    	'comment' => 'ÇÀÎ «Ãðóïïà êîìïàíèé «ÅÄÈÍÑÒÂÎ»',
                    	'image' => 'edinstvo.png',
                    	'shadow' => 'edinstvo_shadow.png',
                    	'iconSize'   => array(26, 51),
                    	'shadowSize' => array(55, 51),
                    	'iconAnchor' => array(23, 51),                    	
                    	);
if (isset(Special_Vtor_Data::$edinstvoDataGM))
    $edinstvo_data = Special_Vtor_Data::$edinstvoDataGM;

$data[] = $edinstvo_data;
if (!$this->data_center)
{
    if (count($data) < 3)
        $this->data_center = $data[0];
    else 
    {
        $this->data_center = $center_ryazan;
    }
}

					
if ($this->show_gm_link) {
?>
<script charset="utf-8" src="http://maps.google.com/maps?file=api&amp;v=2&amp;&hl=ru&amp;key=<?php echo $key; ?>"
            type="text/javascript"></script>
<?php }


if ($this->script_link) {
?>
<script charset="windows-1251" src="<?php echo $this->script_link; ?>"
            type="text/javascript"></script>
<?php }


if ($this->show_main) {
    
if ($this->show_script_tag)
{
?><script charset="utf-8" type="text/javascript"><?php } ?>


function initialize() {
	var map = new GMap2(document.getElementById("<?php echo $this->id; ?>"));
	map.setCenter(new GLatLng(<?php echo $this->data_center['x']; ?>, <?php echo $this->data_center['y']; ?>), <?php echo $this->zoom; ?>);
	map.addControl(new GLargeMapControl());
	map.addControl(new GMapTypeControl());

	//map.enableScrollWheelZoom();
    map.disableScrollWheelZoom();
	
	<?php foreach ($data as $key => $value) {
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
	
	<?php echo $this->add_to_gm; ?>
	
}



$(document).ready(function()
{
initialize();
});
<?php
if ($this->show_script_tag)
{
?></script><?php
}
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
    }
    
}
    
    