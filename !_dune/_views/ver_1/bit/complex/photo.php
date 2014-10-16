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
    ?><h1>Фоторепортаж. <?php echo $data['name']; ?></h1><?php
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
?></p>
<!--
<p class="house-name">Фоторепортаж</p>
-->

<div id="object-info-photo"><?php
// catalogue/info_one_photo.css

if ($this->photo_list->count())
{
    foreach ($this->photo_list as $value)
    {
?><div class="div-one-object-photo"><a class="thickbox" href="<?php echo $value->getSourseFileUrl(); ?>"><img src="<?php echo $value->getPreviewFileUrl(180); ?>" alt="ФОТО"/></a></div>
<?php
    }
}
?></div>


</div>