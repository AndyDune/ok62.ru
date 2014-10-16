<?php

$session_zone = 'filter';

$vars = Dune_Variables::getInstance();

//Dune_Static_StylesList::add('main:base');
Dune_Static_StylesList::add('catalogue/base');
Dune_Static_StylesList::add('catalogue/info');
Dune_Static_StylesList::add('catalogue/filter');
Dune_Static_StylesList::add('elements');

Dune_Static_StylesList::add('catalogue/adress_list');
Dune_Static_StylesList::add('catalogue/list');


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
    $adress_array = array(
//                        'region' => $url_info->getRegion(),
                        'region' => 1,  // Только Рязань
                        'area' => $url_info->getArea(),
                        'settlement' => $url_info->getSettlement(),
                        'district' => $url_info->getDistrict(),
                        'street' => $url_info->getStreet(),
                        'house' => $url_info->getHouse(),
                        'group' => $url_info->getGroup(),
                        'building' => $url_info->getBuilding()
                        );
                        
if ($url_info->getRegion())
{
    $adress_array['region'] = $url_info->getRegion();
}                        
$adress_object = new Special_Vtor_Adress($adress_array);

if ($url_info->isDistrictPlus())
{
    $adress_object->setDistrictPlus();
}


// Формирование заголовка страницы при выводе адресов.
    $string = '';
    $addressCityName = $adress_object->getSettlementName(); // Имя города
    $objectInfoType = $url_info->getType();
    $showTitleRegion = true;
    switch ($addressCityName) {
    	case 'Рязань':
    		$showTitleRegion = false;
    		switch ($objectInfoType) {
    			case 1:
    				$addressCityName = 'Продажа квартир в Рязани';
    				break;
    			case 2:
    				$addressCityName = 'Продажа домов в Рязани';
    				break;
    			case 3:
    				$addressCityName = 'Продажа гаражей в Рязани';
    				break;
    			case 4:
    				$addressCityName = 'Продажа коммерческой недвижимости в Рязани';
    				break;
    			case 5:
    				$addressCityName = 'Продажа кладовок в Рязани';
    				break;
    			case 6:
    				$addressCityName = 'Продажа земельных участков в Рязани';
    				break;
    				
    		}
    		break;
    }

    if(!$addressCityName or $showTitleRegion) {
    	$addressRegionName = $adress_object->getRegionName();
    	switch ($addressRegionName) {
    		case 'Рязанская область':
	    		switch ($objectInfoType) {
	    			case 1:
	    				$addressCityName = 'Продажа квартир в Рязанской области';
	    				break;
	    			case 2:
	    				$addressCityName = 'Продажа домов в Рязанской области';
	    				break;
	    			case 3:
	    				$addressCityName = 'Продажа гаражей в Рязанской области';
	    				break;
	    			case 4:
	    				$addressCityName = 'Продажа коммерческой недвижимости в Рязанской области';
	    				break;
	    			case 5:
	    				$addressCityName = 'Продажа кладовок в Рязанской области';
	    				break;
    			    case 6:
    				    $addressCityName = 'Продажа земельных участков в Рязанской области';
    				    break;
	    				
	    		}
    			break;
    	}
    }

    if(isset($addressRegionName) and $addressRegionName != '' and $adress_object->getRegionId() < 2) {
        $addressAreaName = '';
    	$addressAreaName = $adress_object->getAreaName();
    	if($addressAreaName != '') {
    		$addressCityName .= ', ' . $addressAreaName;
    	}
    	$addressSettlementName = $adress_object->getSettlementName();
    	if($addressSettlementName != '') {
    		$addressCityName .= ', ' . $addressSettlementName;
    	}
    }

    $string .= $addressCityName;
    if ($adress_object->getDistrictName())  // Имя района
        $string .= ', ' . $adress_object->getDistrictName(); // Имя района
        
    if ($adress_object->getStreetName())  // Имя улицы
        $string .= ', улица ' . $adress_object->getStreetName(); // Имя улица
        
    Dune_Variables::addTitle($string . ' :: '); // Дополняем title



/////////////////////////////////////////////////////////////////////////////
/// Формирование хлебных крошек
//$display_crumbs = new Dune_Include_Module('display/catalogue/adress/crumbs');
$display_crumbs = new Module_Display_Catalogue_Adress_Crumbs;

$display_crumbs->adress_object = $adress_object;
$display_crumbs->type = $url_info->getType();
if (false)
{
    $display_crumbs->object_name = $object->name_type;
}
$display_crumbs->make();
$text_crumbs = $display_crumbs->getOutput();
///////////////////////////////////////////////////////////////////////////

$main_info = '';
    
///////////////////////////////////////////////////////////////
//////////      Спецаредложения везде на страницах каталога
    
    $display = new Module_Display_Catalogue_Object_Elected_OnCatalogue(); // В базе с кодом 2
    $display->make();
    $text_elected = $display->getOutput();
    
    
$gm_info = '';
    
    // Для goo maps          !!!!!!
    $cooc = Dune_Cookie_ArraySingleton::getInstance(Dune_Parameters::$cookieNameSystem);
    if (!$cooc['gm'])
    {
        $module = new Module_Display_GMap();
        $module->show_main = false;
        $cat_url = new Special_Vtor_Catalogue_Url_Collector();
        $cat_url->setAdress($adress_object)->setType($url_info->getType());
        $module->script_link = $cat_url->get() . '?gm=gm';
        $module->make();
        $gm_info = $module->getOutput() . '<div style="position:relative; width:100%; height:400px;" id="map"></div>';
    }
    // Для goo maps          /!!!!!!
    
    
    
    
//  Формирование списка доступных в данных условиях объектов
//$display_main_info = new Dune_Include_Module('display/catalogue/object/list.in.adress');
$session = Dune_Session::getInstance($session_zone);

    if ($session->type != $url_info->getType())
        $session->killZone();
            $main_info = ''; 
    switch ($session->type)
    {
        case 1:
            $display_main_info = new Module_Display_Catalogue_Object_List_Filter_Type_Room();
        break;
        case 4:
            $display_main_info = new Module_Display_Catalogue_Object_List_Filter_Type_NoLife();
        break;
        case 5:
            $display_main_info = new Module_Display_Catalogue_Object_List_Filter_Type_Pantry();
        break;
        case 3:
            $display_main_info = new Module_Display_Catalogue_Object_List_Filter_Type_Garage();
        break;
        case 2:
            $display_main_info = new Module_Display_Catalogue_Object_List_Filter_Type_House();
        break;

        case 6:
            $display_main_info = new Module_Display_Catalogue_Object_List_Filter_Type_Land();
        break;
        
        default:
            $display_main_info = new Module_Display_Catalogue_Object_ListInAdress();
    }
    
    if ($adress_array['region'] == 1 and !$adress_array['settlement'] and $adress_array['area'])
//    if ($adress_array['region'] == 1 and !$adress_array['settlement'])
        $display_main_info->no_ryazan = true;
    else 
        $display_main_info->no_ryazan = false;
    
    $display_main_info->session_zone = $session_zone;    
    $display_main_info->adress_array = $adress_array;
    $display_main_info->adress_object = $adress_object;
    $display_main_info->type = $url_info->getType();
    $display_main_info->perPage = 10;
    $display_main_info->gm = $gm_info;
    $display_main_info->url_info = $url_info;
    $display_main_info->make();
    $objects_count = $display_main_info->getResult('count');
    $main_info = $display_main_info->getOutput();
    
    
    
    
$session = Dune_Session::getInstance($session_zone);
if ($session->type)
{
    $session->where_string = $display_main_info->getResult('where_string');
    $session->use_table_user = $display_main_info->getResult('use_table_user');
    $session->use_table_user_time = $display_main_info->getResult('use_table_user_time');
}
    

    
/////////////////////////////////////////////////////////////////////////////
/// Основное адресное табло
//$text_adres = Dune_Zend_Cache::loadIfAllow('adress_count_object' . $url_info->getType()); // кеширование потом

//$display_adress_list = new Dune_Include_Module('display/catalogue/adress/list.main.with.objects');
//if (Special_Vtor_Vars::$districtPlusInUrl)
if (Special_Vtor_Settings::$districtPlus)
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
    /////////////////////////////////////////////////////////////////////////////
    /// Фильтр для дополнительного отбора 
    if ($url_info->getType()) // передан тип - спец фильтр для каждого типа по отдельносьи
    {
        $display = new Module_Display_Catalogue_Filter_Base();
        $display->adress_object = $adress_object;
        $display->objects_count = $objects_count = 0;//$display_main_info->getResult('count');
        $display->type = $url_info->getType();
        $display->session_zone = $session_zone;
        $display->make();
    }
    else 
    {
        $display = new Dune_Include_Module('display/catalogue/adress/list.add');
        $display->adress_array = $adress_array;
        $display->make();
    }
    ///////////////////////////////////////////////////////////////////////////
    $left_column .= $display->getOutput();



//  Формирование списка типов

$cache_name = 'object_cache_type_list' . $url_info->getType() 
            . $adress_object->getRegionId() 
            . $adress_object->getAreaId() 
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


$view->bottom_content = $bottom_content;
$view->crumbs = $text_crumbs;
$view->type = $text_type;
$view->main = $main_info;
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

    echo $view->render('page:catalogue:default_no_auth');
