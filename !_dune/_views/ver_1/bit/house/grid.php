<?php
$data   = $this->data;
$grid   = $this->grid;
$porchs = $this->porchs;
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
?></h1><p class="house-name"></p>


<div id="object-info-grid"><?php
// catalogue/info_one_photo.css

//    print_array($grid);

//print_array($porchs);


if (count($grid))
{
    foreach ($porchs as $value)
    {
        $po[] = $value;
    }
    krsort($po);
    foreach ($po as $value)
    {
        $count_td = $value['count_on_level'];
        if ($value['last_level_name'])
            $last_level_name = $value['last_level_name'];
        else 
            $last_level_name = $value['level_end'];
?><table><tr><th>Этаж</th><th colspan="<?php echo $value['count_on_level']; ?>"><?php echo $value['number']; ?>-й подъезд
<span><strong class="green">зелёный - свободна,</strong> <strong class="red">красный - нет в продаже</strong></span>
</th></tr><?php
$last_level = true;
foreach ($grid[$value['number']] as $level_name => $one_level)
{
?><tr><td class="level-name"><?php
if ($last_level)
    echo $last_level_name;
else 
    echo $level_name;
?></td><?php
$count_current = 0;
foreach ($one_level as $one_room)
{
    ?><td <?php
    if (is_array($one_room))
    {
        ?>class="room-active"><a href="/catalogue/type/<?php echo $one_room['type']; ?>/object/<?php echo $one_room['id'];
        if (Special_Vtor_Settings::$districtPlus)
        {
        ?>/adress<?php echo Special_Vtor_Settings::$districtPlusPostFix;  ?>/<?php
        }
        else 
        {
        ?>/<?php
        }
        ?>"><span class="number">№<?php echo $one_room['room'] ?></span><?php
        
        if ($one_room['rooms_count'])
        {
            ?><span><?php echo $one_room['rooms_count']; ?> комн.</sup></span><?php
        }
        
        if ($one_room['space_calculation'])
        {
            ?><span><?php echo $one_room['space_calculation']; ?>м<sup>2</sup></span><?php
        }
        else if ($one_room['space_total'])
        {
            ?><span><?php echo $one_room['space_total']; ?>м<sup>2</sup></span><?php
        }
        if ($one_room['price'])
        {
            ?><span><strong><?php echo $one_room['price']; ?>р.</strong></span></a><?php
        }
        

    }
    else if ($one_room)
    {
        ?>class="room-no-active"><span class="number">№<?php
        echo $one_room;
        ?></span><?php
    }
    else 
    {
        ?>class="room-no"><?php
    }
    $count_current++;
    ?></td><?php
}
if ($count_current != $count_td)
{
    ?><td class="td-free" colspan="<?php echo $count_td - $count_current; ?>"></td><?php
}
?></tr><?php
$last_level = false;
}
?></table><?php        
    }
}
?></div>


</div>