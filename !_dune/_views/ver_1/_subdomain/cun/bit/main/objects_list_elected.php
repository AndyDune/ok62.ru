<div class="objects-elected-on-main"><h2>Спецпредложения</h2>
<div class="o-e-2">
<div class="o-e-3">
<div class="o-e-4">
<ul>
<?php 
$count = count($this->objects_list);
for ($x = $count; $x < 4; $x++)
{
    $this->objects_list[] = $this->objects_list[0];
}
//print_array($this->objects_list);
foreach ($this->objects_list as $value) {
	$imgTitle = 'Продажа';
	$imgTitle .= ' ';
	switch ($value['type']) {
		case 1:
			$imgTitle .= $value['rooms_count'] . '-комнатной квартиры';
			if($value['planning'] == 2) {
				$imgTitle .= ' ';
				$imgTitle .= 'улучшенной планировки';
			}
			break;
	}
	switch ($value['name_settlement']) {
		case 'Рязань':
			$imgTitle .= ' ';
			$imgTitle .= 'в Рязани';
			break;
	}
	?>
<li>
<?php if ($value['price']) { ?>
<p style="color:red; padding: 0 0 4px 0; font-weight: bold;"><?php echo number_format($value['price'], 0, ',', ' ') ?> руб.</p>
<?php } ?>
<a href="<?php echo $value['link']?>" title="<?=$imgTitle;?>">
<?php if ($value['preview']) {?>
<img src="<?php echo $value['preview'];?>" height="100" width="100" alt="<?=$imgTitle;?>" />
<?php } else {?>

<img src="<?php echo $this->view_folder?>/img/house-3.png" height="100" width="100"/>
<?php } ?>

<p><?php
switch ($value['type']) {
	case 1:
		echo $value['rooms_count'] . '-комнатная квартира';
		if($value['planning'] == 2) {
			echo ' улучшенной планировки';
		}
		break;
	default:
		echo $value['name_type'];
		if (($value['type'] == 1 or $value['type'] == 2) and $value['rooms_count'] ) {?>, комнат: <?php echo $value['rooms_count']; }
		break;
}
?>
</p>
<p>
<?php if ($value['settlement_id'] == 1) { 
    
if ($value['street_adding']) { ?>улица <?php } echo $value['name_street']; 
if ($value['house_number']) {
?>, дом <?php echo $value['house_number']; }

} else 
    { 
    echo $value['name_region'];
    if ($value['region_id'] == 1) {
        ?>, <?php echo $value['name_area'];
    } 
    if ($value['type_settlement'] < 100) {
        ?>, <?php echo $value['name_settlement'];
    } else {
        ?>, <?php echo $value['settlement_name'];
    }
    } ?>


</p>

</a>
</li>
<?php }?>
</ul>

</div></div></div>
<p id="to-page-special"><a href="/catalogue/spec/">Все спецпредложения</a></p>
</div>