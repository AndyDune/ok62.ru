<?php

class Module_Display_Catalogue_Object_ListInAdress extends Dune_Include_Abstract_Code
{

    protected function code()
    {
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        

    $no_mediator = true;

$list = new Special_Vtor_Object_List();

    if ($this->no_ryazan)   
    {
        $list->setNoRyazan();
    }
$list->setUseAdressFull();

$list->setAdress($this->adress_object);
$list->setActivity(1);
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
$price_min_max = array('min' => $saved['price_from'], 'max' => $saved['price_from']);
*/
$price_min_max = array('min' => null, 'max' => null);

$this->setResult('where_string', '');
$this->setResult('use_table_user', false);
$this->setResult('use_table_user_time', false);


if ($count)
{

    if (Special_Vtor_Settings::$useGroupInList)   
        $list->setGroupInList();
    
    
    //  Специальный порядок для вывода списка    
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
    
    
    
    
    if (!$order_special)
        $list->setOrder('priority', 'DESC');
        
        
//    if ($order_field == 'price')
        $list->setOrder('price_contractual');
     
       
    if ($list_spec === false)
    {
        $list->setOrder($order_field, $order_direction);
        $objects_list_run = $list->getListCumulate($page_curent * $page_per, $page_per);    
    }
    else 
        $objects_list_run = $list_spec;
    
    
       
//    $objects_list_run = $list->getListCumulateGroupInHouse($page_curent * $page_per, $page_per);    
    
//    if ((int)$price_min_max['max'] < 1 and (int)$price_min_max['min'] < 1)
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
    $cat_url->setBuilding($value['building_number']);
    
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
    
    $cat_url->setGroup($value['group']);
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
    
    
    //$list->setOrderTimeInsert('DESC');
//    $list->setOrder($order_field, $order_direction);
    $view->data = $objects_list_list;
    $view->navigator_per_page = $this->perPage;
    
    $view->count = $count;
    
    $view->gm = $this->gm;
    
    $view->count_no_group = $count_no_group;
    
    $view->price_min_max = $price_min_max;
   
    $view->url_info = $this->url_info;
    $view->navigator_page = $page_curent;
    
    $view->order_field     = $order_field;
    $view->order_direction = $order_direction;
    
    
    $URL = Dune_Parsing_UrlSingleton::getInstance();
    $view->url_self = $URL->getCommandString('true');

    $view->type = $this->type;
    $view->list_statistic = $view->render('bit/catalogue/object/list/statistic');
        
    switch ($this->type)
    {
        case 1: // Квартиры
            echo $view->render('bit/catalogue/object/list/room');
        break;
        
        case 2: // Квартиры
            echo $view->render('bit/catalogue/object/list/house');
        break;

        
        case 3: // Гаражи
            echo $view->render('bit/catalogue/object/list/garage');
        break;
/*        
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
    
    