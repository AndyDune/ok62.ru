<?php

class Module_Display_Catalogue_Object_List_NewOnCatalogueMain extends Dune_Include_Abstract_Code
{

    protected function code()
    {
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        


$list = $this->object_list;
$type = $this->type;
$count_display = $this->count;

//$list = new Special_Vtor_Object_List();
//$list->setOrderTimeInsert('DESC');
//$list->setActivity(1);
$list->clearType()
     ->setType($type);
$this->setResult('list', array());
$list->setShowWitoutHouseNumber();
$count = $list->count();
$list->setShowWitoutHouseNumber(false);
$objects_list_list = array();
if ($count)
{
//    if (Special_Vtor_Settings::$useGroupInList)   
        $list->setGroupInList();
    
    $objects_list_run =  $list->getListCumulate(0,$count_display);
    foreach ($objects_list_run as $key => $value)
    {
        $objects_list_list[$key] = $value;
        
        $cat_url = new Special_Vtor_Catalogue_Url_Collector();
        $cat_url->setRegion($value['region_id']);
        $cat_url->setArea($value['area_id']);
        $cat_url->setSettlement($value['settlement_id']);
        $cat_url->setStreet($value['street_id']);
        $cat_url->setHouse($value['house_number']);
        $cat_url->setGroup($value['group']);
        if ($this->adress_object->getDistrictPlus())
            $cat_url->setDistrict($value['district_id_plus'], true);
        else 
            $cat_url->setDistrict($value['district_id']);
//        $cat_url->setDistrict($value['district_id']);
        
        $cat_url->setType($value['type']);
        $cat_url->setObject($value['id']);
        $objects_list_list[$key]['link'] = $cat_url->get();
        
        $pics = new Special_Vtor_Catalogue_Info_Plan($value['id'], $value['time_insert']);
        //echo $pics->count();
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
//                $pics = new Special_Vtor_Catalogue_Info_Image($value['id'], $value['time_insert']);
                $prew = $pics->getOneImage();
                $objects_list_list[$key]['preview'] = $prew->getPreviewFileUrl(100);
            }
            else 
                $objects_list_list[$key]['preview'] = '';
        }
    }
}

$this->setResult('list', $objects_list_list);
$this->setResult('count', $count);


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
    }
    
}
    
    