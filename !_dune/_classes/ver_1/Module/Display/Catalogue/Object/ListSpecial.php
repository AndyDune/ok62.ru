<?php

class Module_Display_Catalogue_Object_ListSpecial extends Dune_Include_Abstract_Code
{

    protected function code()
    {
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        

//$text = Dune_Zend_Cache::loadIfAllow('catalogue_special' . $this->adress_object->getCacheTag()); // Смотрим кеш
$text = Dune_Zend_Cache::loadIfAllow('catalogue_special'); // Смотрим кеш
if (!$text)
{
    $list = new Special_Vtor_Object_List_Elected(1); // выбираем избраное
    
    
    
//    $list->setAdress($this->adress_object);
    
    $list->setActivity(1);
    
    //$list->setType(1)->setType(3)->setType(4)->setType(2);
    
    $list->setOrder('selection_id' , 'DESC', 'el');
//    $list->setOrderTimeInsert('DESC');
        
    $result = $list->getListCumulate();

    $objects_list_list = array();
    foreach ($result as $key => $value)
    {
        $objects_list_list[$key] = $value;
        
        $cat_url = new Special_Vtor_Catalogue_Url_Collector();
        $cat_url->setRegion($value['region_id']);
        $cat_url->setArea($value['area_id']);
        $cat_url->setSettlement($value['settlement_id']);
        $cat_url->setStreet($value['street_id']);
        $cat_url->setHouse($value['house_number']);
        
//        $cat_url->setDistrict($value['district_id']);

    if (Special_Vtor_Settings::$districtPlus)
        $cat_url->setDistrict($value['district_id_plus'], true);
    else 
        $cat_url->setDistrict($value['district_id']);
        
        
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

       
    
    $view = Dune_Zend_View::getInstance();
    $view->data = $objects_list_list;
    
    $view->url_info = $this->url_info;
    
    $text = $view->render('bit/catalogue/main/list_special');
    Dune_Zend_Cache::saveIfAllow($text, 'catalogue_special', array(Special_Vtor_Settings::CACHE_TAG_CATALOGUE));
}
echo 
    $text;
Dune_Static_StylesList::add('catalogue/list_all_new');
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
    }
    
}
    
    