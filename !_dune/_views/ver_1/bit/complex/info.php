<?php
$data = $this->data;
$url_catalogue = new Special_Vtor_Catalogue_Url_Collector();
$url_catalogue->setRegion($data['region_id']);
$url_catalogue->setArea($data['area_id']);
$url_catalogue->setSettlement($data['settlement_id']);

$url_catalogue->setStreet($data['street_id']);
$url_catalogue->setHouse($data['house_number']);
$url_catalogue->setBuilding($data['building_number']);

$url_catalogue->setGroup($data['complex_id']);
    
if (Special_Vtor_Settings::$districtPlus)
    $url_catalogue->setDistrict($data['district_id_plus'], true);
else 
    $url_catalogue->setDistrict($data['district_id']);

?>
<div id="crumbs-info"><?php echo $this->crumbs; ?></div>
<div id="house-info">
<?php
if ($data['name'])
{
    ?><h1><?php echo $data['name']; ?></h1><?php
}


?><p class="house-name">
<?php if ($data['settlement_id'] == 1)
{
    ?>Рязань<?php
} else 
{
    echo $data['name_region']; 
    if ($data['area_id'])
    {
        ?>, <?php echo $data['name_area'];
    }
    if ($data['settlement_id'])
    {
        ?>, <?php echo $data['name_settlement'];
    }
    
}
if ($data['district_plus_id'])
{
    ?>, <?php echo $data['name_district_plus'];
}
if ($data['street_id'])
{
?>, <?php if ($data['street_adding']) { ?>улица <?php } echo $data['name_street'];
}

if (!$data['build_status'] and $data['adress_build'])
{
    ?><br /> (<?php echo $data['adress_build'] ?>) <?php
}
?></p><?php


?><table id="house-info-details"><?php

// Всего квартир
if ($data['count_room_total'])
{
    ?><tr><td>Количество квартир</td><td><?php echo $data['count_room_total']; ?></td></tr><?php
}

// Свободных квартир
if ($data['count_room'])
{
    $url_catalogue->setType(1);
    ?><tr><td>Свободных квартир</td><td><?php echo $data['count_room']; ?></td></tr><?php
}
// Стоимость квартир
if ($data['price_min_metre_room'])
{
    ?><tr><td>Стоимость квартир</td><td>от <?php echo number_format($data['price_min_metre_room'], 0,',', ' ');
    if ($data['price_max_metre_room']) { ?> до <?php echo number_format($data['price_max_metre_room'], 0,',', ' '); } ?> руб/м<sup>2</sup></td></tr><?php
}

// Площадь квартир
if ($data['space_total_min_room'])
{
    ?><tr><td>Площадь квартир</td><td>от <?php echo number_format($data['space_total_min_room'], 2,',', ' ');
    if ($data['space_total_max_room']) { ?> до <?php echo number_format($data['space_total_max_room'], 2,',', ' '); } ?> м<sup>2</sup></td></tr><?php
}



// Всего нежилых
if ($data['count_nolife_total'])
{
    ?><tr><td>Колличество нежилых помещений</td><td><?php echo $data['count_nolife_total']; ?></td></tr><?php
}

// Свободных нежилых
if ($data['count_nolife'])
{
    $url_catalogue->setType(4);
    ?><tr><td>Свободных нежилых помещений</td><td><?php echo $data['count_nolife']; ?></td></tr><?php
}
// Стоимость нежилых
if ($data['price_min_metre_nolife'])
{
    ?><tr><td>Стоимость нежилых помещений</td><td>от <?php echo number_format($data['price_min_metre_nolife'], 0,',', ' ');
    if ($data['price_max_metre_nolife'] and $data['price_max_metre_nolife'] != $data['price_min_metre_nolife']) { ?> до <?php echo number_format($data['price_max_metre_nolife'], 0,',', ' '); } ?> руб/м<sup>2</sup></td></tr><?php
}
// Площадь нежилых помещений
if ($data['space_total_min_nolife'])
{
    ?><tr><td>Площадь нежилых помещений</td><td>от <?php echo number_format($data['space_total_min_nolife'], 2,',', ' ');
    if ($data['space_total_max_nolife']) { ?> до <?php echo number_format($data['space_total_max_nolife'], 2,',', ' '); } ?> м<sup>2</sup></td></tr><?php
}





// Всего кладовых
if ($data['count_pantry_total'])
{
    ?><tr><td>Колличество кладовых помещений</td><td><?php echo $data['count_pantry_total']; ?></td></tr><?php
}

// Свободных кладовых
if ($data['count_pantry'])
{
    $url_catalogue->setType(5);
    ?><tr><td>Свободных кладовых помещений</td><td><?php echo $data['count_pantry']; ?></td></tr><?php
}

// Стоимость кладовок
if ($data['price_min_metre_pantry'])
{
    ?><tr><td>Стоимость кладовых помещений</td><td>от <?php echo number_format($data['price_min_metre_pantry'], 0,',', ' ');
    if ($data['price_max_metre_pantry']) { ?> до <?php echo number_format($data['price_max_metre_pantry'], 0,',', ' '); } ?> руб/м<sup>2</sup></td></tr><?php
}
// Площадь кладовых помещений
if ($data['space_total_min_pantry'])
{
    ?><tr><td>Площадь нежилых помещений</td><td>от <?php echo number_format($data['space_total_min_pantry'], 2,',', ' ');
    if ($data['space_total_max_pantry']) { ?> до <?php echo number_format($data['space_total_max_pantry'], 2,',', ' '); } ?> м<sup>2</sup></td></tr><?php
}




?></table><br /><?php

	$list_houses = new Special_Vtor_Sub_List_House();
	$list_houses->setComplex($data['id']);
	
	$result = $list_houses->getDatas();
	if (count($result))
	{
	    foreach ($result as $value)
	    {
            $house = new Display_House_OneInList();
            $house->data = $value;
            echo $house->render();
	    }
	}
	


if ($data['text'])
{
    ?><div class="house-description"><?php echo $data['text']; ?></div><?php
}
?>


<?php
//echo $data;
?>
</div>
