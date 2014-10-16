<?php

$session_zone = 'filter';


//Dune_Static_StylesList::add('main:base');
Dune_Static_StylesList::add('catalogue/base');
Dune_Static_StylesList::add('catalogue/info');
Dune_Static_StylesList::add('elements');

Dune_Static_StylesList::add('catalogue/adress_list');
Dune_Static_StylesList::add('catalogue/list');


$view = Dune_Zend_View::getInstance();

$url_info = new Special_Vtor_Catalogue_Url_Parsing();

$adress_array = array();
/*
region - �������
area - ����� � �������
settlement - ��������� ����� (����� ���� ������� � �.�.) ���������� ���
district - ��������� �����
street - ��� �����
house - ��� 
building - ������

*/
$objects_count = 0;

$text_elected = '';
$left_column = '';
$object_have = false;

    
//echo $url_info->getRegion(); die();

if (!$url_info->getRegion())
    $getRegion = null;
else 
    $getRegion = $url_info->getRegion();

// ���� ��������� ������� ������ � ������� ������ ���� �� ������ �������
    $adress_array= array(
                        'region' => $getRegion,//$url_info->getRegion(),
//                        'region' => 1,  // ������ ������
                        'area' => $url_info->getArea(),
                        'settlement' => $url_info->getSettlement(),
                        'district' => $url_info->getDistrict(),
                        'street' => $url_info->getStreet(),
                        'house' => $url_info->getHouse(),
                        'building' => $url_info->getBuilding()
                        );
$adress_object = new Special_Vtor_Adress($adress_array);

    if (Special_Vtor_Settings::$districtPlus)
    {
        $adress_object->setDistrictPlus();
    }



// ������������ ��������� �������� ��� ������ �������.
    $string = '';
//    $string .= $adress_object->getSettlementName(); // ��� ������
    $string .= '������������ ������'; // ��� ������
    if ($adress_object->getDistrictName())  // ��� ������
        $string .= ', ' . $adress_object->getDistrictName(); // ��� ������
        
    if ($adress_object->getStreetName())  // ��� �����
        $string .= ', ����� ' . $adress_object->getStreetName(); // ��� �����
        
    Dune_Variables::addTitle($string . ' :: '); // ��������� title


/////////////////////////////////////////////////////////////////////////////
/// �������� �������� �����
//$text_adres = Dune_Zend_Cache::loadIfAllow('adress_count_object' . $url_info->getType()); // ����������� �����

//$display_adress_list = new Dune_Include_Module('display/catalogue/adress/list.main.with.objects');
//$display_adress_list = new Module_Display_Catalogue_Adress_ListMainWithObjects();
if (Special_Vtor_Settings::$districtPlus)
{
    $display_adress_list = new Module_Display_Catalogue_Adress_ListMainWithObjectsPlus();
}
else 
    $display_adress_list = new Module_Display_Catalogue_Adress_ListMainWithObjects();

$display_adress_list->adress_array = $adress_array;
$display_adress_list->adress_object = $adress_object;
$display_adress_list->use_filter = false;
$display_adress_list->url_info = $url_info;
$display_adress_list->type = $url_info->getType();
$display_adress_list->make();
$text_adress = $display_adress_list->getOutput();

///////////////////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////////////////////
/// ������������ ������� ������
//$display_crumbs = new Dune_Include_Module('display/catalogue/adress/crumbs');
$display_crumbs = new Module_Display_Catalogue_Adress_Crumbs;
$display_crumbs->no_adress = true;
$display_crumbs->adress_object = $adress_object;
//$display_crumbs->type = $url_info->getType();
if (false)
{
    $display_crumbs->object_name = $object->name_type;
}
$display_crumbs->make();
$text_crumbs = $display_crumbs->getOutput();
///////////////////////////////////////////////////////////////////////////

$main_info = '';
    
///////////////////////////////////////////////////////////////
//////////      ��������������� ����� �� ��������� ��������
    
//    $display = new Module_Display_Catalogue_Object_Elected_OnCatalogue(); // � ���� � ����� 2
//    $display->make();
//    $text_elected = $display->getOutput();
    $text_elected = '';
    
//  ������������ ������ ��������� � ������ �������� ��������
//$display_main_info = new Dune_Include_Module('display/catalogue/object/list.in.adress');
$session = Dune_Session::getInstance($session_zone);
    if ($session->type != $url_info->getType())
        $session->killZone();
            $main_info = ''; 
            
    $display_main_info = new Module_Display_Catalogue_Object_ListOnMain();

    $display_main_info->adress_array = $adress_array;
    $display_main_info->adress_object = $adress_object;
    $display_main_info->type = $url_info->getType();
    
    
    $display_main_info->count = 9;
    $display_main_info->url_info = $url_info;
    $display_main_info->make();
    $main_info = $display_main_info->getOutput();
    


    /////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////
    /// ������ ��� ��������������� ������ 
    if ($url_info->getType()) // ������� ��� - ���� ������ ��� ������� ���� �� �����������
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



//  ������������ ������ �����

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


// ������������ ��������� ����� ������� ��� �������
$bottom_content = '';

//$banners_left = new Module_Display_Banners_Left();
//$banners_left->make();

$view->bottom_content = $bottom_content;
$view->crumbs = $text_crumbs;
$view->type = $text_type;
$view->main = $main_info;
$view->adress_main = $text_adress; // . $banners_left->getOutput();
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
//Dune_Variables::$pageTitle = '�������� ������� ������������ ������.';

    echo $view->render('page:catalogue:default_no_auth_2col');
