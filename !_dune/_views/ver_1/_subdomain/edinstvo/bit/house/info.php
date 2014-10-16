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
<h1>Улица <?php

echo $data['name_street'];
if ($data['house_number'])
{
    ?>, дом <?php echo $data['house_number'];
}
if ($data['building_number'])
{
    ?>, корпус <?php echo $data['building_number'];
}

if (!$data['build_status'] and $data['adress_build'])
{
    ?><br /> (<?php echo $data['adress_build'] ?>) <?php
}
?></h1><?php
if ($data['new_building_flag'])
{
    ?><p class="house-status">Новостройка, <?php echo  $data['new_building_text']; ?></p><?php
}
else 
{
    ?><p class="house-status">Сданный дом</p><?php
}
if ($data['name'])
{
    ?><p class="house-name"><?php echo $data['name']; ?></p><?php
}


if ($data['have_fasad'])
{
    $img = new Special_Vtor_Sub_Image_Fasad($data['id']);
    $this->fasad = $img->getOneImage();
}
?><table id="table-house-one" width="100%" cellpadding="5" cellspacing="0">
<tr>
<td width="260px" rowspan="2">

<?php if ($this->fasad)
{
    ?><a href="/house/<?php echo $data['id']; ?>/"><img src="<?php echo $this->fasad->getPreviewFileUrl(250); ?>" alt="Фасад дома." /></a><?php
}
?>
</td>
<td colspan="2">
<?php
if ($data['district_id_plus'] > 1)
{
    ?><p class="p-house-list-district">Район: <?php echo $data['name_district_plus'] ?></p><?php
}

// Этажность
if ($data['count_floors'])
{
    ?><p>Этажность: <?php echo $data['count_floors']; ?></p><?php
}
?><td></tr><tr><td><?php

?><div><?php
// Свободных квартир
if ($data['count_room_total'])
{
    ?><p class="strong">Всего квартир - <?php echo $data['count_room_total']; ?></p><?php
}

if ($data['count_room'])
{
    ?><p class="strong">Свободных - <a href="/house/<?php echo $data['id'] ?>/grid/room/"><?php echo $data['count_room']; ?></a></p><?php
}

if ($data['count_room_1'])
{
    ?><p class="strong">1-комн. - <a href="/house/<?php echo $data['id'] ?>/grid/room/"><?php echo $data['count_room_1']; ?></a></p><?php
}
if ($data['count_room_2'])
{
    ?><p class="strong">2-комн. - <a href="/house/<?php echo $data['id'] ?>/grid/room/"><?php echo $data['count_room_2']; ?></a></p><?php
}
if ($data['count_room_3'])
{
    ?><p class="strong">3-комн. - <a href="/house/<?php echo $data['id'] ?>/grid/room/"><?php echo $data['count_room_3']; ?></a></p><?php
}

if ($data['count_room_4'])
{
    ?><p class="strong">других - <a href="/house/<?php echo $data['id'] ?>/grid/room/"><?php echo $data['count_room_4']; ?></a></p><?php
}


?></div>
</td>
<td><div>
<?php
// Свободных нежилых
if ($data['count_nolife_total'])
{
    ?><p class="strong">Всего нежилых помещений: <?php echo $data['count_nolife_total']; ?></p><?php
}

// Свободных нежилых
if ($data['count_nolife'])
{
    $url_catalogue->setType(4);
    ?><p class="strong">Свободных: <a href="/house/<?php echo $data['id'] ?>/grid/nolife/"><?php echo $data['count_nolife']; ?></a></p><?php
}
?></div><div><?php
// Свободных нежилых
if ($data['count_pantry_total'])
{
    ?><p class="strong">Всего кладовых помещений: <?php echo $data['count_pantry_total']; ?></p><?php
}

// Свободных кладовых
if ($data['count_pantry'])
{
    ?><p class="strong">Свободных: <a href="/house/<?php echo $data['id'] ?>/grid/pantry/"><?php echo $data['count_pantry']; ?></a></p><?php
}

?></div>
</td>
</tr>
</table>






<h4>Описание помещений</h4>
<ul class="just-list">
<?php
// Стоимость квартир
if ($data['price_min_metre_room'])
{
    ?><li>Стоимость квартир от <?php echo number_format($data['price_min_metre_room'], 0,',', ' ');
    if ($data['price_max_metre_room']) { ?> до <?php echo number_format($data['price_max_metre_room'], 0,',', ' '); } ?> руб/м<sup>2</sup></li><?php
}

// Стоимость квартир
if ($data['price_max_metre_room'])
{
    ?><li>Стоимость квартир до <?php echo number_format($data['price_max_metre_room'], 0,',', ' ');
    ?> руб/м<sup>2</sup></li><?php
}

// Площадь квартир
if ($data['space_total_min_room'])
{
    ?><li>Площадь квартир от <?php echo number_format($data['space_total_min_room'], 2,',', ' ');
    if ($data['space_total_max_room']) { ?> до <?php echo number_format($data['space_total_max_room'], 2,',', ' '); } ?> м<sup>2</sup></li><?php
}

// Стоимость нежилых
if ($data['price_min_metre_nolife'])
{
    ?><li>Стоимость нежилых помещений от <?php echo number_format($data['price_min_metre_nolife'], 0,',', ' ');
    if ($data['price_max_metre_nolife'] and $data['price_max_metre_nolife'] != $data['price_min_metre_nolife']) { ?> до <?php echo number_format($data['price_max_metre_nolife'], 0,',', ' '); } ?> руб/м<sup>2</sup></li><?php
}
// Площадь нежилых помещений
if ($data['space_total_min_nolife'])
{
    ?><li>Площадь нежилых помещений от <?php echo number_format($data['space_total_min_nolife'], 2,',', ' ');
    if ($data['space_total_max_nolife']) { ?> до <?php echo number_format($data['space_total_max_nolife'], 2,',', ' '); } ?> м<sup>2</sup></li><?php
}



// Стоимость кладовок
if ($data['price_min_metre_pantry'])
{
    ?><li>Стоимость кладовых помещений от <?php echo number_format($data['price_min_metre_pantry'], 0,',', ' ');
    if ($data['price_max_metre_pantry']) { ?> до <?php echo number_format($data['price_max_metre_pantry'], 0,',', ' '); } ?> руб/м<sup>2</sup></li><?php
}
// Площадь кладовых помещений
if ($data['space_total_min_pantry'])
{
    ?><li>Площадь нежилых помещений от <?php echo number_format($data['space_total_min_pantry'], 2,',', ' ');
    if ($data['space_total_max_pantry']) { ?> до <?php echo number_format($data['space_total_max_pantry'], 2,',', ' '); } ?> м<sup>2</sup></li><?php
}





?></ul>

<br />
<?php













if ($data['text'])
{
    ?><div class="house-description"><?php echo $data['text']; ?></div><?php
}
?>


<?php
//echo $data;
?>
</div>
