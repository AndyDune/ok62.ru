<?php
$session_zone = 'filter';

Dune_Static_StylesList::add('main:base');
Dune_Static_StylesList::add('main/objects_list_new_last');
Dune_Static_StylesList::add('main/filter');
Dune_Static_StylesList::add('main/filter_top_line');
Dune_Static_StylesList::add('filter');

Dune_Static_StylesList::add('catalogue/adress_list');


Dune_Static_JavaScriptsList::add('dune_main_page');

$view = Dune_Zend_View::getInstance();
//$view->view_folder = Dune_Variables::$pathToViewFolder;
/////////////////////////////////////////////////
///     Список типов с числом объектов в сиситеме
$types_list = new Special_Vtor_Object_Types();
///
/////////////////////////////////////////////////


///////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////
///     Список объектов последних в системе
//$objects_list = new Special_Vtor_Object_List();
//$objects_list->setOrderTimeInsert('DESC');
//$objects_list->setActivity(1);
$vars = Dune_Variables::getInstance();

if (!$vars->subdomainFocusUserId)
{

Dune_Data_Zend_Cache::$lifetime = 300; // 5 минут
$text = Dune_Zend_Cache::loadIfAllow('special_on_main');
if (!$text)
{

$objects_list = new Special_Vtor_Object_List_Elected(1); // выбираем избраное

//$objects_list->setOrderOrder();
//$objects_list_run =  $list->getListCumulate();
$objects_list_list = array();

///
/////////////////////////////////////////////////
//$objects_list_run = $objects_list->getListCumulate(0, 4);
$objects_list_run = $objects_list->getRandomRows();
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
    
    $pics = new Special_Vtor_Catalogue_Info_Plan($value['id'], $value['time_insert']);
    //echo $pics->count();
    if ($pics->count())    
    {
        $prew = $pics->getOneImage();
        $objects_list_list[$key]['preview'] = $prew->getPreviewFileUrl(100);
    }    
    else if ($value['pics'])
    {
        $pics = new Special_Vtor_Catalogue_Info_Image($value['id'], $value['time_insert']);
        $prew = $pics->getOneImage();
        $objects_list_list[$key]['preview'] = $prew->getPreviewFileUrl(100);
    }
    else 
        $objects_list_list[$key]['preview'] = '';
}
$view->objects_list = $objects_list_list;

$view->objects_count = $objects_list->count();
$text = $view->render('bit/main/objects_list_elected');

Dune_Zend_Cache::saveIfAllow($text, 'special_on_main');
}

}
else 
    $text = '';
$this->results['objects_list_new'] = $text;
Dune_Data_Zend_Cache::$lifetime = 2600000; // Месяц
////
////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////


    $display = new Module_Display_SubDomain_MainPage();
    $display->make();
    $text = $display->getOutput();

    $this->results['objects_search'] = $text;

/*    Dune_Static_StylesList::add('main/objects_list_elected');
    $display = new Module_Display_Catalogue_Object_List_OnMain();
    $display->objects_count = $objects_count = 0;//$display_main_info->getResult('count');
    $display->session_zone = $session_zone;
    $display->make();
    $this->results['objects_list_elected'] = $display->getOutput();
*/    
    $this->results['objects_list_elected'] = $display->getResult('objects_list_elected');
    
    
    
$this->results['objects_list_pop'] = '';


//$view->types_list = $types_list->getListTypeWithObjectsActive();;

//echo $view->render('page/main/default');

