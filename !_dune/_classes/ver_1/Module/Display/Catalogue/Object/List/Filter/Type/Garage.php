<?php

class Module_Display_Catalogue_Object_List_Filter_Type_Garage extends Dune_Include_Abstract_Code
{

    protected function code()
    {
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        


$list = new Special_Vtor_Object_List_Type_NoLife();
$list->setUseAdressFull();


$session = Dune_Session::getInstance($this->session_zone);
//echo $session;
if ($session->levels)
    $list->setLevels();
else 
    $list->setRoomsCountArray(array(
                                    1 => $session->rooms_count_1,
                                    2 => $session->rooms_count_2,
                                    3 => $session->rooms_count_3,
                                    4 => $session->rooms_count_4,
                                    ));
if ($session->house_type)
    $list->setHouseType($session->house_type);
                                
if ($session->condition)
    $list->setConditionArray($session->condition);
             

// Установка фильтра для всех типов
    $set_list = new Module_Display_Catalogue_Object_List_Filter_Type_Common();
    $set_list->list = $list;
    $set_list->session = $session;
    $set_list->adress_object = $this->adress_object;
    $set_list->type = $this->type;
    $set_list->no_ryazan = $this->no_ryazan;
    $set_list->make();
    $no_mediator = $set_list->getResult('no_mediator');
    $list = $set_list->getResult('list');
/// клнец установки для всех типов

    
    $list->setDeal($session->getInt('deal', null));

if ($session->phone)
    $list->setPhone();
if ($session->photo)
    $list->setPhoto();

if ($session->floor_no_first)
    $list->setFloorFrom();
if ($session->floor_from)
    $list->setFloorFrom($session->floor_from);
    
if ($session->floor_socle)
    $list->setSocle(1);
    
    
$x      = 0;
$result = null;
if ($session->new_building_flag_0 === 1)
{
    $x++;
    $result = 0;
}
if ($session->new_building_flag_1 === 1)
{
    $x++;
    $result = 1;
}   
if ($x == 1)
{
    $list->setNewBuilding($result);
}   
    
    
    
if ($session->floor_no_last)
    $list->setFloorTo();
if ($session->floor_to)
    $list->setFloorTo($session->floor_to);

if ($session->value_from)
    $list->setValueFrom($session->value_from);
if ($session->value_to)
    $list->setValueTo($session->value_to);
    
   
    
$list->filter = $session->getZone(true);

if ($this->type)
    $list->setType($this->type);
$count = $list->count();
$this->results['count'] = $count;
$page_curent = $this->url_info->getPage();
$page_per = $this->perPage;
$view = Dune_Zend_View::getInstance();


$module = new Module_Catalogue_List_Sort_Get();
$module->make();

if ($module->getResult('field'))
{
    $order_field = $module->getResult('field');
    $order_direction = $module->getResult('order');
    $order_special = true;
}
else 
{
    $order_special = false;
    $order_field = 'time_insert';
    $order_direction = 'DESC';
}

$price_min_max = array('min' => null, 'max' => null);

$this->setResult('where_string', $list->getWhereStringSpecial());
$this->setResult('use_table_user', $list->isUseTableUser());
$this->setResult('use_table_user_time', $list->isUseTableUserTime());


if ($count)
{  
    if (!$order_special)
        $list->setOrder('priority', 'DESC');
    
//    if ($order_field == 'price')
        $list->setOrder('price_contractual');
    
    $price_min_max = $list->getFromListCumulatePriceMinMax();
        
    $list->setOrder($order_field, $order_direction);
    $objects_list_run = $list->getListCumulate($page_curent * $page_per, $page_per);    
    
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
    
    
    
    
//    echo '<h1>Объектов: ' . $count . '</h1>';
    //$list->setOrderTimeInsert('DESC');
//    $list->setOrder($order_field, $order_direction);
    $view->data = $objects_list_list;
    $view->navigator_per_page = $this->perPage;
    $view->count = $count;
    $view->url_info = $this->url_info;
    $view->navigator_page = $page_curent;
    
    $view->gm = $this->gm;    
    
    $view->order_field     = $order_field;
    $view->order_direction = $order_direction;
    
    $URL = Dune_Parsing_UrlSingleton::getInstance();
    $view->url_self = $URL->getCommandString('true');
    
    $view->type = $this->type;
    $view->price_min_max = $price_min_max;
    $view->list_statistic = $view->render('bit/catalogue/object/list/statistic');
    
    switch ($this->type)
    {
/*        case 1: // Квартиры
            $view->render('bit/catalogue/object/list/room');
        break;
        case 3: // Гаражи
            $view->render('bit/catalogue/object/list/garage');
        break;
        case 5: // Кладовки
            $view->render('bit/catalogue/object/list/pantry');
        break;
*/        
        default:
            echo $view->render('bit/catalogue/object/list/default');
    }
}
else 
{
    $count_with_bad = 0;
    $view->count_with_bad = $count_with_bad;
    echo $view->render('bit/catalogue/object/list/no_one');
}





/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
    }
    
}
    
    