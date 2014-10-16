<?php
$URL = Dune_Parsing_UrlSingleton::getInstance();

$page_per = $per_page = 50;

    if (!Dune_Session::$auth) // Пользователь не может смотреть информацию о продавцах
    {
        //throw new Dune_Exception_Control('Необходимо зарегистрироваться', 1);
        throw new Dune_Exception_Control_NoAccess('page/user/info/can_not_look_info', 1);
    }    
    
    $user = false;
    $session = Dune_Session::getInstance(Dune_Session::ZONE_AUTH);
    
    $view = Dune_Zend_View::getInstance();
    
    //$view->user = $user;
        
    
/////////////// ---     Меню слева
     $session = Dune_Session::getInstance(Dune_Session::ZONE_AUTH);
     $user = new Dune_Auth_Mysqli_UserActive($session->user_id);
     
     $edit_menu = new Module_Display_User_MoreEditMenu();
     $edit_menu->user = $user;
     $edit_menu->code = 'nearby';
     $edit_menu->make();
     $view->more_edit_menu = $edit_menu->getOutput();
/////////////// ---     /Меню слева


///////////////////////////////////////////////////////////
/// Создание массивов для отображения
$list = new Special_Vtor_Object_List();

$group_current = (int)$URL->getCommandPart(4, 1);
$interval_current = (int)$URL->getCommandPart(4, 3, 0);
if ($group_current < 1)
{
    throw new Dune_Exception_Control_Goto('/user/nearby/');
}


$group_current_object = new Special_Vtor_Nearby_Group($group_current);
if (!$group_current_object->check())
{
    throw new Dune_Exception_Control_Goto('/user/nearby/');
}

$streets_object = new Special_Vtor_Nearby_List_Streets($group_current);
$streets_array = $streets_object->getListCumulate(Special_Vtor_Settings::$arrayEdinstvoSalers);
$streets_ids = $streets_object->getIdArray();

if (!$streets_array or count($streets_array) < 1)
{
    throw new Dune_Exception_Control_Goto('/user/nearby/');
}
$streets_current = (int)$URL->getCommandPart(4, 2);

if ($streets_current and $streets_object->checkStreet($streets_current))
{
    $streets = array($streets_current);
}
else 
{
    $streets = $streets_ids;
}

if ($URL->getCommandPart(5, 1) == 'type')
    $type = (int)$URL->getCommandPart(5, 2);
else 
    $type = 0;

$view->street_current = $streets_current;
$view->street_array = $streets_array;
$view->interval_current = $interval_current;
$view->type = $type;

$view->group_current = $group_current;

$list->setStreet($streets);
$list->setActivity(1);

if ($type)
    $list->setType($type);

    if ($interval_current)
        $list->setTimeInteval($interval_current * 86400);

$count = $list->count();
$this->results['count'] = $count;
$get = Dune_Filter_Get_Total::getInstance();
$page_curent = $get->getDigit('page');

$order_field = 'time_insert';
$order_direction = 'DESC';
if ($count)
{
//    echo '<h1>Объектов: ' . $count . '</h1>';
    
    $list->setOrder('priority', 'DESC');
    $list->setOrder($order_field, $order_direction);
    $objects_list_run = $list->getListCumulate($page_curent * $page_per, $page_per, Special_Vtor_Settings::$arrayEdinstvoSalers);    
    
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
        $objects_list_list[$key]['pic'] = $prew->getSourseFileUrl();
    }    
    else if ($value['pics'])
    {
        $pics = new Special_Vtor_Catalogue_Info_Image($value['id'], $value['time_insert']);
        $prew = $pics->getOneImage();
        $objects_list_list[$key]['preview'] = $prew->getPreviewFileUrl(100);
        $objects_list_list[$key]['pic']     = $prew->getSourseFileUrl();
    }
    else 
        $objects_list_list[$key]['preview'] = '';
        $objects_list_list[$key]['pic'] = '';
}
    
    
    //$list->setOrderTimeInsert('DESC');
//    $list->setOrder($order_field, $order_direction);
    $view->data = $objects_list_list;
    $view->navigator_per_page = $page_per;
    $view->count = $count;
    $view->url_info = $URL->getCommandString();
    $view->navigator_page = $page_curent;
    
    $view->h1_code = '/user/nearby/';
    
    $view->crumbs_array = array(
    array('name' => 'Список наблюдаемых объектов', 'link' => '/user/nearby/'),
    array('name' => $group_current_object->getName(), 'link' => '#')
    );
    
    $text = $view->render('bit/catalogue/object/list/nearby');
    
//    $view->text = $text;
//    echo $view->render('bit/general/container_padding_for_auth_extend');
     
     Dune_Static_StylesList::add('catalogue/list');
    

}
else 
{
    //$text = '<h1>Нет объектов с указанным адресом и/или типом</h1>';
    $text = $view->render('bit/catalogue/object/list/nearby');
    $view->h1_code = 'no_objects';
}
    $view->text = $text;
    echo $view->render('bit/general/container_padding_for_auth_extend');
     
    Dune_Static_StylesList::add('catalogue/list');
    