<?php

$session_zone = 'filter';


$view = Dune_Zend_View::getInstance();

//$url_info = new Special_Vtor_Catalogue_Url_Parsing();
$url_info = $this->url_info;

$adress_array = array();
/*
region - область
area - район в области
settlement - населённый пункт (город село деревня и т.д.) уникальный код
district - городской район
street - код улицы
house - дом 
building - корпус

*/
$objects_count = 0;

$text_elected = '';
$left_column = '';
$object_have = false;

    
    


// Если объектане выбрано данные о текущем адресе берём из строки запроса
    $adress_array= array(
                        'region' => $url_info->getRegion(),
//                        'region' => 1,  // Только Рязань    // убрал для Сочи 2009 апрель 27
                        'area' => $url_info->getArea(),
                        'settlement' => $url_info->getSettlement(),
                        'district' => $url_info->getDistrict(),
                        'street' => $url_info->getStreet(),
                        'house' => $url_info->getHouse(),
                        'building' => $url_info->getBuilding()
                        );
$adress_object = new Special_Vtor_Adress($adress_array);


if ($url_info->isDistrictPlus())
{
    $adress_object->setDistrictPlus();
}


$main_info = '';
    
    
//  Формирование списка доступных в данных условиях объектов
//$display_main_info = new Dune_Include_Module('display/catalogue/object/list.in.adress');

$session = Dune_Session::getInstance($session_zone);

    if ($session->type != $url_info->getType())
        $session->killZone();
            $main_info = ''; 
    switch ($session->type)
    {
        case 1:
            $display_main_info = new Module_Display_Catalogue_Object_List_Filter_Type_GM_Room();
        break;
        case 4:
            $display_main_info = new Module_Display_Catalogue_Object_List_Filter_Type_GM_NoLife();
        break;
        case 5:
            $display_main_info = new Module_Display_Catalogue_Object_List_Filter_Type_GM_Pantry();
        break;
        case 3:
            $display_main_info = new Module_Display_Catalogue_Object_List_Filter_Type_GM_Garage();
        break;
        case 2:
            $display_main_info = new Module_Display_Catalogue_Object_List_Filter_Type_GM_House();
        break;

        case 6:
            $display_main_info = new Module_Display_Catalogue_Object_List_Filter_Type_GM_Land();
        break;
        
        default:
            $display_main_info = new Module_Display_Catalogue_Object_ListInAdressGM();
    }
    
    if ($adress_array['region'] == 1 and !$adress_array['settlement'] and $adress_array['area'])
        $display_main_info->no_ryazan = true;
    else 
        $display_main_info->no_ryazan = false;
    
    $display_main_info->session_zone = $session_zone;    
    $display_main_info->adress_array = $adress_array;
    $display_main_info->adress_object = $adress_object;
    $display_main_info->type = $url_info->getType();
    $display_main_info->url_info = $url_info;
    $display_main_info->make();
//    $main_info = $display_main_info->getOutput();
    
    $module = new Module_Display_GMap();
    $module->adress_object = $adress_object;
    $module->show_gm_link    = false;
    $module->show_script_tag = false;
    
    
if ($url_info->isDistrictPlus())
{
    $view = Dune_Zend_View::getInstance();
    $view->district_id_plus = $url_info->getDistrict();
//    if ($url_info->getSettlement() == 1 and !$url_info->getDistrict())
//        $view->all = true;
    $module->add_to_gm = $view->render('bit/map/districts');
}
    
    $module->data = $display_main_info->getResult('data');
    $module->make();
    
    /////   Для теста
    
/*    $file = Dune_AsArray_File_String::getInstance(Dune_Variables::$pathToArrayFiles);
    Dune_BeforePageOut::registerObject($file);
    $file['OUTUT'] = $module->getOutput();
*/    
    
    $this->setStatus(Dune_Include_Command::STATUS_TEXT);
    echo $module->getOutput();
    
/////////////////////////////////////////////////////////////////////////////
/// Основное адресное табло
//$text_adres = Dune_Zend_Cache::loadIfAllow('adress_count_object' . $url_info->getType()); // кеширование потом



// Формирование публичной ветки общения для объекта
$bottom_content = '';


//   $view->main = $main_info;
//   echo $view->render('page:catalogue:default_no_auth');
