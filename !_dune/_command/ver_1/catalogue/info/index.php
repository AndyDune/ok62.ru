<?php

$session_zone = 'filter';

$vars = Dune_Variables::getInstance();

//Dune_Static_StylesList::add('main:base');
Dune_Static_StylesList::add('catalogue/base');
Dune_Static_StylesList::add('catalogue/info');
//Dune_Static_StylesList::add('filter');
Dune_Static_StylesList::add('elements');

Dune_Static_StylesList::add('catalogue/adress_list');
//Dune_Static_StylesList::add('catalogue/list');

//Dune_Static_JavaScriptsList::add('jquery');
Dune_Static_JavaScriptsList::add('thickbox');
Dune_Static_StylesList::add('thickbox');

$view = Dune_Zend_View::getInstance();

$url_info = new Special_Vtor_Catalogue_Url_Parsing();

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

$object_have = true;

//$object = new Special_Vtor_Object_Data($url_info->getObject());
$object = $this->object;
        
$adress_array = $object->getAdressArray(Special_Vtor_Settings::$districtPlus);
$adress_object = $object->getAdressObject(Special_Vtor_Settings::$districtPlus);

    
    
$object_no_active = '';
if ($object->activity != 1)
{
  Dune_Static_StylesList::add('user/info/message');        
  $object_no_active =  $view->render('page/catalogue/message/object_no_active');
}

if ($object->activity != 1 and Dune_Variables::$userStatus < 1000)
{
  echo $object_no_active;
  return;
}


/////////////////////////////////////////////////////////////////////////////
/// Основное адресное табло
//$text_adres = Dune_Zend_Cache::loadIfAllow('adress_count_object' . $url_info->getType()); // кеширование потом

//$display_adress_list = new Dune_Include_Module('display/catalogue/adress/list.main.with.objects');
//$display_adress_list = new Module_Display_Catalogue_Adress_ListMainWithObjects();
if (Special_Vtor_Vars::$districtPlusInUrl)
    $display_adress_list = new Module_Display_Catalogue_Adress_ListMainWithObjectsPlus();
else 
    $display_adress_list = new Module_Display_Catalogue_Adress_ListMainWithObjects();

$display_adress_list->adress_array = $adress_array;
$display_adress_list->adress_object = $adress_object;
$display_adress_list->use_filter = false;
$display_adress_list->session_zone = $session_zone;
$display_adress_list->url_info = $url_info;
$display_adress_list->type = $url_info->getType();
$display_adress_list->make();
$text_adress = $display_adress_list->getOutput();

///////////////////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////////////////////
/// Формирование хлебных крошек
//$display_crumbs = new Dune_Include_Module('display/catalogue/adress/crumbs');
$display_crumbs = new Module_Display_Catalogue_Adress_Crumbs;

$display_crumbs->adress_object = $adress_object;
$display_crumbs->type = $url_info->getType();

    $display_crumbs->object_name = $object->name_type;
    
$display_crumbs->make();
$text_crumbs = $display_crumbs->getOutput();
///////////////////////////////////////////////////////////////////////////



    $display_seller = new Module_Display_Catalogue_Object_SalerInfo();
    $display_seller->object = $object;
    $display_seller->make();
    $view->seller = $display_seller->getResult('seller');


$main_info = '';
//    Формирование дисплея информации об объекте
//$display_main_info = new Dune_Include_Module('display/catalogue/object/info.one');
$display_main_info = new Module_Display_Catalogue_Object_InfoOne();
$display_main_info->adress_array = $adress_array;
$display_main_info->adress_object = $adress_object;
$display_main_info->type = $url_info->getType();
$display_main_info->mode = $url_info->getMode();

$display_main_info->object = $object;
$display_main_info->make();
$main_info = $display_main_info->getOutput();

    if (Dune_Session::$auth)
    {
        /////////////////////////////////////////////////////////////////////////////
        /// При просмотре объекта табло справа - кнопка отложить
        //$display = new Dune_Include_Module('display/catalogue/object/save.object');
        $display = new Module_Display_Catalogue_Object_SaveToBasket();
        $display->object = $object;
        $display->make();
        $left_column .= $display->getOutput();
        ///////////////////////////////////////////////////////////////////////////
    }        
        /////////////////////////////////////////////////////////////////////////////
        /// При просмотре объекта табло справа - информация о продавце
        //$display_adress_list_add = new Dune_Include_Module('display/catalogue/object/saler.info');
        $display_adress_list_add = new Module_Display_Catalogue_Object_SalerInfo();
        $display_adress_list_add->object = $object;
        $display_adress_list_add->make();
        ///////////////////////////////////////////////////////////////////////////
        
        $left_column .= $display_adress_list_add->getOutput();




//  Формирование списка типов

$cache_name = 'object_cache_type_list' . $url_info->getType() 
            . $adress_object->getRegionId() 
            . $adress_object->getAreaId() 
            . $adress_object->getDistrictId() 
            . (string)$adress_object->getDistrictPlus() 
            . $adress_object->getSettlementId()
            . $adress_object->getStreetId();

$text_type = Dune_Zend_Cache::loadIfAllow($cache_name);
if (!$text_type)
{
    //$display_type = new Dune_Include_Module('display/catalogue/object/type.list');
    $display_type = new Module_Display_Catalogue_Object_TypeList();
    $display_type->adress_array = $adress_array;
    $display_type->adress_object = $adress_object;
    $display_type->url_info = $url_info;
    $display_type->make();    
    $text_type = $display_type->getOutput();
    Dune_Zend_Cache::saveIfAllow($text_type, $cache_name, array(Special_Vtor_Settings::CACHE_TAG_CATALOGUE));
}


// Формирование публичной ветки общения для объекта
$bottom_content = '';
    // Формирование табло информации о прдавце
    
/*    $display_seller = new Module_Display_Catalogue_Object_SalerInfo();
    $display_seller->object = $object;
    $display_seller->make();
*/        

    $bottom_content .= $display_seller->getOutput();
    
    
    $cat_url = new Special_Vtor_Catalogue_Url_Collector();
    $cat_url->setRegion($adress_array['region']);
    $cat_url->setArea($adress_array['area']);
    $cat_url->setSettlement($adress_array['settlement']);
    $cat_url->setDistrict($adress_array['district'], Special_Vtor_Settings::$districtPlus);
    $cat_url->setStreet($adress_array['street']);
    $cat_url->setType($url_info->getType());
    $cat_url->setHouse($url_info->getHouse());
    $cat_url->setMode($url_info->getMode());
    $cat_url->setObject($url_info->getObject());
    $view->url_object = $cat_url;
    $session = Dune_Session::getInstance('talk');

//    if (Dune_Session::$auth)
//    {
        $get = Dune_Filter_Get_Total::getInstance();
        if (isset($get['talk_mode']))
            $session->talk_mode = $get['talk_mode'];
        $view->talk_mode = $session->talk_mode;
        $bottom_content .= $view->render('bit/catalogue/object/talk/mode_change');
        
//    }
//    else 
//        $bottom_content .= $view->render('bit/catalogue/object/talk/mode_change_no');

    if ($session->talk_mode == 'private')
    {
        $session = Dune_Session::getInstance(Dune_Session::ZONE_AUTH);
        if ($object->saler_id == $session->user_id)
        {
            $display = new Module_Display_Catalogue_Object_PrivateTalk_Saler();
            $display->perPage = 50;
            $display->object = $object;
            $display->url_object = $cat_url;
            $display->seller = $object->saler_id;
            
            $display->make();
            $bottom_content .= $display->getOutput();
        }
        else 
        {
            $display = new Module_Display_Catalogue_Object_PrivateTalk_List();
            $display->url_object = $cat_url;
            $display->perPage = 50;
            $display->object = $object;
            $display->seller = $object->saler_id;
            $display->make();
            $bottom_content .= $display->getOutput();
            
            $display = new Module_Display_Catalogue_Object_PrivateTalk_Form();
            $display->object = $object;
            $display->make();
            $bottom_content .= $display->getOutput();
        }
    }
    else 
    {
        $display = new Module_Display_Catalogue_Object_PublicTalk();
        $display->mode = $url_info->getMode();
        $display->adress_object = $adress_object;
        $display->type = $url_info->getType();
        $display->perPage = 10;
        $display->seller = $object->saler_id;
        $display->object = $object;
        $display->make();
        $bottom_content .= $display->getOutput();
        
        $display = new Module_Display_Catalogue_Object_PublicTalk_Form();
        $display->mode = $url_info->getMode();
        $display->adress_object = $adress_object;
        $display->type = $url_info->getType();
        $display->object = $object;
        $display->make();
        $bottom_content .= $display->getOutput();
    }
    


$view->bottom_content = $bottom_content;
$view->crumbs = $text_crumbs;
$view->type = $text_type;
$view->main = $object_no_active . $main_info;
if (!$vars->subdomainFocusUserId)
{
    $banners_left = new Module_Display_Banners_Left();
    $banners_left->make();
    $view->adress_main = $text_adress . $banners_left->getOutput();
}
else 
{
    $view->adress_main = $text_adress;
}

$view->adress_add = $left_column;
$view->elected = $text_elected;


/*$o = new Special_Vtor_Object_List();
$o->setActivity(0);
$o->setType(1);
echo $o->count();
$list = $o->getListCumulate();
foreach ($list as $value)
{
    echo '<pre>';
    print_r($value);
    echo '</pre>';
}
*/
//Dune_Variables::$pageTitle = 'Открытый Каталог Недвижимости Рязани.';

    Dune_Static_StylesList::add('catalogue/info');
    echo $view->render('page:catalogue:default_object_info');
