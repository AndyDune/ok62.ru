<?php
$data   = $this->data;
$list   = $this->list;
$count = $this->count;
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


<div id="object-info-grid-pantry"><?php
// catalogue/info_one_photo.css

//    print_array($grid);

//print_array($porchs);

if (count($count))
{
    ?><table><tr><th>Код</th><th>Имя</th><th>Номер</th><th>Площадь, м<sup>2</sup></th><th>Цена, руб.</th><th>Этаж</th></tr><?php
    foreach ($list as $value)
    {
        $link = '/catalogue/type/5/adress' . Special_Vtor_Settings::$districtPlusPostFix .'/object/' . $value['id'] . '/';
        

        $o = new Dune_Data_Parsing_Date($value['time_insert']);
        $code = $o->getMonth() . $o->getYear(1);
        switch (strlen($value['id']))
        {
            case 1:
                $zeros = '0000';
            break;
            case 2:
                $zeros = '000';
            break;
            case 3:
                $zeros = '00';
            break;
            case 4:
                $zeros = '0';
            break;
            default:
                $zeros = '';
        }
        
         $code = $code . $zeros . $value['id']; 

        
        
        ?><tr><?php

        ?><td class="shot"><strong><a href="<?php echo $link; ?>"><?php
        echo $code;
        ?></a></strong></td><?php
        
        
        ?><td><a href="<?php echo $link; ?>">Кладовое&nbsp;помещение</a></td><?php
        
        ?><td class="shot"><?php echo $value['room']; ?></td><?php
        
        ?><td class="shot"><?php echo $value['space_total']; ?></td><?php
        
        ?><td class="shot"><?php echo number_format($value['price'], 0, ',', ' '); ?></td><?php
        
                
        ?><td class="shot"><?php

        if ($value['floor'] > 0)
            echo $value['floor'];
        else if ($value['floor'] < 0)
        {
            ?>цоколь<?php
        }
        else
        { 
            ?>-<?php
        }
        ?></td><?php

        
/*        echo '<pre>';
        print_r($value);
        echo '</pre>';
*/        
        ?></tr><?php
    }
    ?></table><?php
}
?></div>


</div>