<?php

class Module_Display_Catalogue_Object_List_OnMain extends Dune_Include_Abstract_Code
{

    protected function code()
    {
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        


//$list = new Special_Vtor_Object_List_Elected(1);
//$list->setOrderOrder();

$list = new Special_Vtor_Object_List();
$list->setOrderTimeInsert('DESC');
$list->setActivity(1);
$list->setRegion(null);

$list->setType(1)->setType(3)->setType(4)->setType(2)->setType(6);

$list->setGroupInList();
$objects_list_run =  $list->getListCumulate(0,5);
$objects_list_list = array();
foreach ($objects_list_run as $key => $value)
{
    $objects_list_list[$key] = $value;
    
    $cat_url = new Special_Vtor_Catalogue_Url_Collector();
    $cat_url->setRegion($value['region_id']);
    $cat_url->setArea($value['area_id']);
    $cat_url->setSettlement($value['settlement_id']);
    $cat_url->setStreet($value['street_id']);
    $cat_url->setHouse($value['house_number']);
    
    if (Special_Vtor_Settings::$districtPlus)
        $cat_url->setDistrict($value['district_id_plus'], true);
    else 
       $cat_url->setDistrict($value['district_id']);
    
    $cat_url->setType($value['type']);
    $cat_url->setObject($value['id']);
    $objects_list_list[$key]['link'] = $cat_url->get();
    
//    echo $value['time_insert'], $value['id']; die();
    $pics = new Special_Vtor_Catalogue_Info_Plan($value['id'], $value['time_insert']);
//    echo $pics->count();
    if ($pics->count())    
    {
         $prew = $pics->getOneImage();
        $objects_list_list[$key]['preview'] = $prew->getPreviewFileUrl(100);
    }
    else 
    {
        $pics = new Special_Vtor_Catalogue_Info_Image($value['id'], $value['time_insert']);
        if ($pics->count())
        {
            $prew = $pics->getOneImage();
            $objects_list_list[$key]['preview'] = $prew->getPreviewFileUrl(100);
        }
        else 
            $objects_list_list[$key]['preview'] = '';
    }
}

$view = Dune_Zend_View::getInstance();
$view->objects_list = $objects_list_list;

echo $view->render('bit/main/objects_list_new');


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
    }
    
}
    
    