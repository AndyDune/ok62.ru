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

?>
<p class="house-name">
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


if ($data['text_short'])
{
    ?><div><?php echo $data['text_short']; ?></div><?php
}






?><div id="complex-info-grafic"><?php
if ($this->photo)
{
    ?><dl class="pic-text"><dd><a href="<?php echo $this->url ?>photo/" title="Оригинал фотографии"><img src="<?php echo $this->photo->getPreviewFileUrl(150); ?>" /></a> </dd>
    <dt><a href="<?php echo $this->url ?>photo/">Фоторепортаж</a></dt>
    </dl> <?php
}
?>

<?php
if ($this->situa)
{
    ?><dl class="pic-text"><dd><a class="thickbox" href="<?php echo $this->situa->getSourseFileUrl(); ?>" title="Оригинал плана"><img src="<?php echo $this->situa->getPreviewFileUrl(150); ?>" /></a> </dd>
    <dt><a class="thickbox" href="<?php echo $this->situa->getSourseFileUrl(); ?>">Ситуационый план</a></dt>
    </dl> <?php
}
?>


<?php
if ($this->fasad)
{
    ?><dl class="pic-text"><dd><a class="thickbox" href="<?php echo $this->fasad->getSourseFileUrl(); ?>" title="Фасад"><img src="<?php echo $this->fasad->getPreviewFileUrl(150); ?>" /></a> </dd>
    <dt><a class="thickbox" href="<?php echo $this->fasad->getSourseFileUrl(); ?>">Фасад</a></dt>
    </dl> <?php
}
?>



<?php
$goo = false;
if ($data['gm_x'])
{
    $gm = array('x' => $data['gm_x'], 'y' => $data['gm_y']);
    $goo = true;
}
else if ($data['complex_gm_x'])
{
    $gm = array('x' => $data['group_gm_x'], 'y' => $data['group_gm_y']);
    $goo = true;
}
if ($goo and false)
{
    ?><dl class="pic-text"><dt><a href="http://ok62.ru/map/public/<?php echo $gm['x']; ?>_<?php echo $gm['y']; ?>/">Смотреть на карте</a></dt></dl> <?php
}
?>

<?php
if (($data['panorama_id'] or $data['complex_panorama_id']) and false)
{
    ?><dl class="pic-text"><dt><a href="<?php echo $this->url; ?>panorama/">Панорамный обзор</a></dt></dl> <?php
}
?>

<?php
if ($data['gen_plan'] and false)
{
    ?><dl class="pic-text"><dt><a href="<?php echo $this->url; ?>gen/">Генеральный план</a></dt></dl> <?php
}
?>


<?php
if ($this->pd and false)
{
    ?><dl class="pic-text"><dt><a href="<?php echo $this->url; ?>pd/">Проектная декларация</a></dt></dl> <?php
}
?>

</div>




<?php


?><ul class="jast-list"><?php

// Всего квартир
if ($data['count_room_total'])
{
    ?><li>Количество квартир - <?php echo $data['count_room_total']; ?></li><?php
}

// Свободных квартир
if ($data['count_room'])
{
    ?><li>Свободных квартир - <?php echo $data['count_room']; ?></li><?php
}
// Стоимость квартир
if ($data['price_min_metre_room'])
{
    ?><li>Стоимость квартир от <?php echo number_format($data['price_min_metre_room'], 0,',', ' ');
    if ($data['price_max_metre_room']) { ?> до <?php echo number_format($data['price_max_metre_room'], 0,',', ' '); } ?> руб/м<sup>2</sup></li><?php
}

// Площадь квартир
if ($data['space_total_min_room'])
{
    ?><li>Площадь квартир от <?php echo number_format($data['space_total_min_room'], 2,',', ' ');
    if ($data['space_total_max_room']) { ?> до <?php echo number_format($data['space_total_max_room'], 2,',', ' '); } ?> м<sup>2</sup></li><?php
}


// Всего нежилых
if ($data['count_nolife_total'])
{
    ?><li>Колличество нежилых помещений - <?php echo $data['count_nolife_total']; ?></li><?php
}

// Свободных нежилых
if ($data['count_nolife'])
{
    ?><li>Свободных нежилых помещений - <?php echo $data['count_nolife']; ?></li><?php
}
// Стоимость нежилых
if ($data['price_min_metre_nolife'])
{
    ?><li>Стоимость нежилых помещений от <?php echo number_format($data['price_min_metre_nolife'], 0,',', ' ');
    if ($data['price_max_metre_nolife'] and $data['price_max_metre_nolife'] != $data['price_min_metre_nolife']) { ?> до <?php echo number_format($data['price_max_metre_nolife'], 0,',', ' '); } ?> руб/м<sup>2</sup></li><?php
}


// Всего кладовых
if ($data['count_pantry_total'])
{
    ?><li>Колличество кладовых помещений - <?php echo $data['count_pantry_total']; ?></li><?php
}

// Свободных кладовых
if ($data['count_pantry'])
{
    ?><li>Свободных кладовых помещений - <?php echo $data['count_pantry']; ?></li><?php
}



?></table><br /><h2>Объекты комплекса</h2><?php

	$list_houses = new Special_Vtor_Sub_List_House();
	$list_houses->setComplex($data['id']);
	
	$result = $list_houses->getDatas();
	if (count($result))
	{
	    foreach ($result as $value)
	    {
            $house = new Display_House_OneInListComplex();
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
