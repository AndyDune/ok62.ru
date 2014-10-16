<?php

class Module_Catalogue_Object_OfficeChange extends Dune_Include_Abstract_Code
{

    protected function code()
    {
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        

    $this->setResult('success', false);

    $object = new Special_Vtor_Object_Data($this->id);
    if (!$object->check())
    {
        return;
    }

    
$planer = new Special_Vtor_Catalogue_Info_Plan($object->id, $object->time_insert); // а есть ли планеровка (план)
$plan_situa = new Special_Vtor_Catalogue_Info_PlanSitua($object->id, $object->time_insert); // а есть ли ситуационный план
if (!$plan_situa->count())
{
    $plan_situa = new Special_Vtor_Catalogue_Info_HouseSituaCommon($object->street_id, $object->house_number, $object->building_number);
}
$plan_floor = new Special_Vtor_Catalogue_Info_PlanFloor($object->id, $object->time_insert); // а есть ли план этажа
$image = new Special_Vtor_Catalogue_Info_Image($object->id, $object->time_insert);
$house = new Special_Vtor_Catalogue_Info_House($object->id, $object->time_insert); // а есть ли фото дома
if (!$house->count())
{
    $house = new Special_Vtor_Catalogue_Info_HousePhotoCommon($object->street_id, $object->house_number, $object->building_number);
}
$panorama = new Special_Vtor_Catalogue_Info_Panorama($object->id, $object->time_insert); // а есть ли панораы

if (!$panorama->count() and $object->panorama)
    $panorama = new Special_Vtor_Catalogue_Info_PanoramaCommon($object->panorama); // а есть ли панораы

// Ўарашим временные
$planer->clearPreviewFolder();
$plan_situa->clearPreviewFolder();
$plan_floor->clearPreviewFolder();
$image->clearPreviewFolder();    
$house->clearPreviewFolder();    
    

$object->pics             = $image->count();
$object->have_situa       = $plan_situa->count();
$object->have_photo_house = $house->count();
$object->have_panorama    = $panorama->count();
$object->have_plan        = $planer->count();


if (!$object->price)
{
    $object->price_contractual = 1;
}
else 
{
    $object->price_contractual = 0;
}

if (!$object->space_loggia)
{
    $object->loggia = 1;
}
if (!$object->space_balcony)
{
    $object->balcony = 1;
}


$object->save();
$this->setResult('success', true);

//$plan_platform = new Special_Vtor_Catalogue_Info_PlanPlatform($object->id, $object->time_insert); // а есть ли план этажа


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
    }
    
}
    
    