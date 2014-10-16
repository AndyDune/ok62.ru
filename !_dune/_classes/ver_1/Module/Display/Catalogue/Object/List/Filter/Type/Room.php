<?php

class Module_Display_Catalogue_Object_List_Filter_Type_Room extends Dune_Include_Abstract_Code
{

    protected function code()
    {
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        


$list = new Special_Vtor_Object_List_Type_Room();
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
//    $list = $set_list->getResult('list');
    $no_mediator = $set_list->getResult('no_mediator');
/// клнец установки для всех типов
     
if ($session->seller and $session->seller > 0)
    $list->setSeller($session->seller);
    
else if ($session->seller and $session->seller == -1)
{
    $array = array();
    foreach (Special_Vtor_Data::$sellerSpecial as $value)
    {
        $array[] = $value['id'];
    }
    $list->setSellerException($array);
}

if ($session->phone)
    $list->setPhone();
if ($session->photo)
    $list->setPhoto();

if ($session->floor_no_first)
    $list->setFloorFrom();
if ($session->floor_from)
    $list->setFloorFrom($session->floor_from);

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
    
$count = $list->count(1);
$count_no_group = $list->count();

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


/*$session = Dune_Session::getInstance($this->session_zone);
$saved = $session->getZone(true);
$price_min_max = array('min' => $saved['price_from'], 'max' => $saved['price_to']);
*/

$price_min_max = array('min' => null, 'max' => null);

$this->setResult('where_string', $list->getWhereStringSpecial());
$this->setResult('use_table_user', $list->isUseTableUser());
$this->setResult('use_table_user_time', $list->isUseTableUserTime());

if ($count)
{  
    $list_spec = false;
    if (!$order_special)
    {
        if ($no_mediator and !$page_curent and $count > $page_per)  // Работает в тестовом режиме
        {
            $list->clearSeller();
            $list->setOrder($order_field, $order_direction);
            $fseller_list = $list->getListCumulate(0, $page_per);
            $fseller_count = count($fseller_list);
            $list->setSeller(Special_Vtor_Settings::$idOk62);
            $list->setFSeller(false);
            if ($fseller_count > 0)
            {
                if ($fseller_count > $page_per - 2)
                    $fseller_count_temp = $page_per - 2;
                else 
                    $fseller_count_temp = $fseller_count;
                $ok62_list = $list->getListCumulate(0, $page_per - $fseller_count_temp);
                $ok62_count = count($ok62_list);
                if ($ok62_count > 0)
                {
                    $list_spec = array();
                    $x = 0;
                    foreach ($fseller_list as $value)
                    {
                        $list_spec[] = $value;
                        $x++;
                        if ($x == $page_per - 2)
                        {
                            break;
                        }
                    }
                    foreach ($ok62_list as $value)
                    {
                        $list_spec[] = $value;
                    }
                }
                else 
                {
                    $list_spec = $fseller_list;
                }
                
            }
        }
        else 
            $list->setOrder('priority', 'DESC');
    }
    
//    if ($order_field == 'price')
        $list->setOrder('price_contractual');
        
        
    if (Special_Vtor_Settings::$useGroupInList)   
        $list->setGroupInList();

        
    if ($list_spec === false)
    {
        $list->setOrder($order_field, $order_direction);
        $objects_list_run = $list->getListCumulate($page_curent * $page_per, $page_per);    
    }
    else 
        $objects_list_run = $list_spec;
    
//    if ((int)$price_min_max['max'] < 1 or (int)$price_min_max['min'] < 1)
      $price_min_max = $list->getFromListCumulatePriceMinMax();
    
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

    // Узнаем на каких этажах есть квартирки
    if ($value['count_in_group'] > 1) 
    {
        
        $list = new Special_Vtor_Object_List();
        $list->setActivity(1);
        $list->setRegion(null);
        $list->setOrder('floor');
        $list->setShowWitoutHouseNumber();
        $objects_list_list[$key]['array_group'] = $list->getListCumulateInGroup($value['group_list']);
    }
    else 
    {
        $objects_list_list[$key]['array_group'] = array();
    }
    
    $cat_url->setType($value['type']);
        
    $objects_list_list[$key]['link_adress'] = $cat_url->get(); // Ссылка для объекта без указания кода объект а        
    
    
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
            $prew = $pics->getOneImage();
            $objects_list_list[$key]['preview'] = $prew->getPreviewFileUrl(100);
        }
        else 
            $objects_list_list[$key]['preview'] = '';
    }
}
    
    
    
    
//    echo '<h1>Объектов: ' . $count . '</h1>';
    //$list->setOrderTimeInsert('DESC');
//    $list->setOrder($order_field, $order_direction);
    $view->data = $objects_list_list;
    $view->navigator_per_page = $this->perPage;
    
    $view->count = $count;
    $view->count_no_group = $count_no_group;

    $view->gm = $this->gm;    
    
    $view->url_info = $this->url_info;
    $view->navigator_page = $page_curent;
    
    $view->price_min_max = $price_min_max;
    
    $view->order_field     = $order_field;
    $view->order_direction = $order_direction;
    
    $URL = Dune_Parsing_UrlSingleton::getInstance();
    $view->url_self = $URL->getCommandString('true');
    
    $view->type = $this->type;
    $view->list_statistic = $view->render('bit/catalogue/object/list/statistic');
    
    echo $view->render('bit/catalogue/object/list/room');
}
else 
{
    $session = Dune_Session::getInstance($this->session_zone);
    $count_with_bad = 0;
    if (!$session->show_bad)
    {
        $list->setShowWitoutHouseNumber(true);
        $count_with_bad = $list->count();
    }
    
    $view->count_with_bad = $count_with_bad;
    echo $view->render('bit/catalogue/object/list/no_one');
}




/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
    }
    
}
    
    