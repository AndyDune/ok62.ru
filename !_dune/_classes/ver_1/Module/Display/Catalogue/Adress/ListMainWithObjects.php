<?php

class Module_Display_Catalogue_Adress_ListMainWithObjects extends Dune_Include_Abstract_Code
{

    protected function code()
    {
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        

    $store_cache_load_local = $store_cache_load = Dune_Zend_Cache::$allowLoad;
    $store_cache_save_local = $store_cache_save = Dune_Zend_Cache::$allowSave;

    
    $types_total = array(1,2,3,4,5,6);
    
// !!!! Всегда пока смотрим областной центр
$this->adress_array['region'] = 1;
//$this->adress_array['settlement'] = 1;

$query_from = '';
$query_where = '';
$session = Dune_Session::getInstance($this->session_zone);
if ($session->where_string and strlen($session->where_string) > 10)
{
    $query_where = ' AND ' . $session->where_string;
    
    if ($session->use_table_user or stripos($query_where, 'user.'))
    {
        $query_from = ', `' . Special_Vtor_Object_List::$tableUser . '` as user';
        $query_where .= ' AND `objects`.`saler_id` = `user`.`id`';
    }
    if ($session->use_table_user_time)
    {
        $query_where .= ' AND objects.saler_id = time.id';
//        if ($query_from)
//            $query_from .= ', ';
        $query_from .= ', `' . Special_Vtor_Object_List::$tableUserTime . '` as time';
    }
    $store_cache_save_local = Dune_Zend_Cache::$allowSave = false;
    $store_cache_load_local = Dune_Zend_Cache::$allowLoad = false;
}




// $this->url_info - объект строки запроса в каталог
if ($this->url_info)
{
    $this->type = $this->url_info->getType();
}

$name_cache = 'adress_panel' . (string)$this->from_main . $this->type . $this->adress_object->getCacheTag();

$data = Dune_Zend_Cache::loadIfAllow($name_cache);
if (!$data)
{


$view = Dune_Zend_View::getInstance();
$have_area_in_url = false;       // Нет указания района области в адресе
$have_settlement_in_url = false; // Нет указания города области в адресе
$have_region_center_url = false; // Нет ссылки на областной центр
$have_street_in_url = false;


    $have_region_url = 1;

$list_areas = array(); // Список районов областей
$region_center = array(); // Массив данных областного центра.
$list_settlement = array(); // Список посёлков в районе
$list_district = array(); // Список городских районов
$list_street = array(); // Список улиц района


    $cat_url = new Special_Vtor_Catalogue_Url_Collector();
//    $cat_url->setRegion($this->adress_array['region']);
    $cat_url->setRegion(1);
    $cat_url->setType($this->type);

$BD = Dune_MysqliSystem::getInstance();
    
/*
    $q = 'SELECT sett.id, sett.name, area.id as area_id, count(object.id) as count
          FROM `unity_catalogue_adress_settlement` as sett,
               `unity_catalogue_adress_area` as area,
               `unity_catalogue_object` as object
          WHERE sett.`type` = 1 
                AND `sett`.`area_id` = area.id
                AND `area`.`region_id` = ?i
                AND `area`.id = `object`.`area_id`
          GROUP BY sett.id
          ';
*/

try {
    
    
//////////////////////////////////////////////////////////////////////////////////////  begin
///                         Временно: поселки за пределом рязанской области
    
$list_settlement_no_ryazan = array();
    

        
        $q = 'SELECT sett.*, count(objects.id) as count,
                    objects.region_id as `region_id`
              FROM `unity_catalogue_adress_settlement` as sett,
                   `unity_catalogue_object` as objects
              WHERE objects.`region_id` > 1
                    AND
                    sett.id = objects.settlement_id
                    AND
                    objects.activity = 1
              GROUP BY sett.id
              ';
    $from_db = $BD->query($q, null, Dune_MysqliSystem::RESULT_IASSOC);
    
    $from_db_type = array();
    // Формирование списка районов с учетом колличества типов по адресу
    $type = $this->type;
    if ($type and in_array($type, $types_total))
    {
        $array_count_for_type = array();
        $q = 'SELECT sett.*,
                    count(objects.id) as count,
                    objects.region_id as `region_id`
              FROM `unity_catalogue_adress_settlement` as sett,
                   `unity_catalogue_object` as objects,
                   `unity_catalogue_object_type` as type' . $query_from . '
              WHERE objects.`region_id` > 1
                    AND
                    sett.id = objects.settlement_id
                    AND
                    objects.activity = 1
                    AND
                    objects.type = type.id
                    AND 
                    type.id = ?i
                    ' . $query_where . '
              GROUP BY sett.id
              ';
         $from_db_type = $BD->query($q, array($type), Dune_MysqliSystem::RESULT_IASSOC);
         foreach ($from_db_type as $value)
         {
             $array_count_for_type[$value['id']] = $value['count'];
         }
    }
    else 
    {
        $array_count_for_type = false;
    }
    
    
    foreach ($from_db as $value)
    {
        $cat_url->setArea($value['area_id']);
        $cat_url->setRegion($value['region_id']);
        $cat_url->setSettlement($value['id']);
        $arr = $value;
        $arr['link'] = $cat_url->get();
//        $arr['name'] = $value['name'];
        
        if ($array_count_for_type !== false)
        {
            if (key_exists($value['id'], $array_count_for_type))
            {
                $arr['count'] = $array_count_for_type[$value['id']];
            }
            else 
                $arr['count'] = 0;
        }
        else 
            $arr['count'] = $value['count'];
            
//            echo $this->adress_array['region_id'];
        if ($value['id'] == $this->adress_array['settlement'] and $value['region_id'] == $this->adress_array['region'])
        {
            $arr['current'] = true;
//            $have_area_in_url = $value['id'];
        }
        else 
            $arr['current'] = false;
        $list_settlement_no_ryazan[$value['id']] = $arr;
    }    
    




    
///    
//////////////////////////////////////////////////////////////////////////////////////  end



$cat_url->setRegion(1);
    
    
//////////////////////////////////////////////////////////////////////////////////////  begin
///                         Скока объектов городе
    
    $str_count = 'count_in_ryazan_type_0';
    
    $type = $this->type;
    if ($type and in_array($type, $types_total))
    {
        
    $q = 'SELECT count(objects.id) as count
          FROM `unity_catalogue_object` as objects ' . $query_from . '
          WHERE objects.`settlement_id` = ?i
                AND
                objects.activity = 1
                AND
                objects.type = ?i
          ' . $query_where;
        
         $count_in_ryazan = $BD->query($q, array(1, $type), Dune_MysqliSystem::RESULT_EL);
         $str_count = 'count_in_ryazan_type_' . $type;
         $$str_count = $count_in_ryazan;
         
    }
    else 
    {
    $q = 'SELECT count(objects.id) as count
          FROM `unity_catalogue_object` as objects ' . $query_from . '
          WHERE objects.`settlement_id` = ?i
                AND
                objects.activity = 1
          ' . $query_where;
        
         $count_in_ryazan = $BD->query($q, array(1), Dune_MysqliSystem::RESULT_EL);
         $$str_count = $count_in_ryazan;

    }

    
    
    
//////////////////////////////////////////////////////////////////////////////////////  begin
///                         Скока объектов в области
    
    $type = $this->type;
    if ($type and in_array($type, $types_total))
    {
        
    $q = 'SELECT count(objects.id) as count
          FROM `unity_catalogue_object` as objects' . $query_from . '
          WHERE objects.`settlement_id` != ?i
                AND
                objects.region_id = 1
                AND
                objects.activity = 1
                AND
                objects.type = ?i
                
          ' . $query_where;
        
         $count_in_ryazan_region = $BD->query($q, array(1, $type), Dune_MysqliSystem::RESULT_EL);
         
    }
    else 
    {
    $q = 'SELECT count(objects.id) as count
          FROM `unity_catalogue_object` as objects' . $query_from . '
          WHERE objects.`settlement_id` != ?i
                AND
                objects.region_id = 1
                AND
                objects.activity = 1
          ' . $query_where;
        
         $count_in_ryazan_region = $BD->query($q, array(1), Dune_MysqliSystem::RESULT_EL);

    }
    


//////////////////////////////////////////////////////////////////////////////////////  begin
////                         Формирование массива областного центра

    $q = 'SELECT sett.*, area.id as area_id
          FROM `unity_catalogue_adress_settlement` as sett, `unity_catalogue_adress_area` as area
          WHERE sett.`type` = 1 
                AND `sett`.`area_id` = area.id
                AND `area`.`region_id` = ?i
          ';
//    $from_db = $BD->query($q, array($this->adress_array['region']), Dune_MysqliSystem::RESULT_ROWASSOC);
    $from_db = $BD->query($q, array(1), Dune_MysqliSystem::RESULT_ROWASSOC);
    if ($from_db)
    {
        $cat_url->setArea($from_db['area_id']);
    
        $cat_url->setSettlement($from_db['id']);
        $region_center['link'] = $cat_url->get();
        $region_center['name'] = $from_db['name'];
        if ($from_db['id'] == $this->adress_array['settlement'])
        {
            $region_center['current'] = true;
            $have_region_center_url = $from_db['id'];
        }
        else 
            $region_center['current'] = false;
       
    }

////
//////////////////////////////////////////////////////////////////////////////////////  end

    $cat_url = new Special_Vtor_Catalogue_Url_Collector();
    $cat_url->setRegion($this->adress_array['region']);
    $cat_url->setType($this->type);






    $have_district_in_url = false;
//////////////////////////////////////////////////////////////////////////////////////  begin
////                         Формирование списка районов области

Dune_Zend_Cache::$allowSave = $store_cache_save;
Dune_Zend_Cache::$allowLoad = $store_cache_load;
       
        
    $text = Dune_Zend_Cache::loadIfAllow('adress_have_region_url_' . $have_region_url);
    if (!$text)
    {

        $q = 'SELECT area.*, count(objects.id) as count
              FROM `unity_catalogue_adress_area` as area,
                   `unity_catalogue_object` as objects
              WHERE area.`region_id` = ?i
                    AND
                    area.id = objects.area_id
                    AND
                    objects.activity = 1
                    AND
                    objects.settlement_id != 1
              GROUP BY area.id
              ';
//        die($have_region_url);
        $from_db = $BD->query($q, array($have_region_url), Dune_MysqliSystem::RESULT_IASSOC);
    
        if ($from_db)
            Dune_Zend_Cache::saveIfAllow(serialize($from_db), 'adress_have_region_url_' . $have_region_url,  array(Special_Vtor_Settings::CACHE_TAG_CATALOGUE));
     }
     else 
     {
         $from_db = unserialize($text);
     }
Dune_Zend_Cache::$allowSave = $store_cache_save_local;
Dune_Zend_Cache::$allowLoad = $store_cache_load_local;
    
    
    $from_db_type = array();
    // Формирование списка районов с учетом колличества типов по адресу
    $type = $this->type;
    if ($type and in_array($type, $types_total))
    {
        $array_count_for_type = array();
        $q = 'SELECT area.*, count(objects.id) as count
              FROM `unity_catalogue_adress_area` as area,
                   `unity_catalogue_object` as objects,
                   `unity_catalogue_object_type` as type' . $query_from . '
              WHERE area.`region_id` = ?i
                    AND
                    area.id = objects.area_id
                    AND
                    objects.activity = 1
                    AND
                    objects.type = type.id
                    AND 
                    type.id = ?i
                    AND
                    objects.settlement_id != 1
                    ' . $query_where . '
              GROUP BY area.id
              ';
         $from_db_type = $BD->query($q, array($have_region_url, $type), Dune_MysqliSystem::RESULT_IASSOC);
         foreach ($from_db_type as $value)
         {
             $array_count_for_type[$value['id']] = $value['count'];
         }
    }
    else 
    {
        $array_count_for_type = false;
    }
    
    
    $cat_url->setRegion(1);
    $cat_url->setSettlement(0);
    foreach ($from_db as $value)
    {
        $cat_url->setArea($value['id']);
        $arr['link'] = $cat_url->get();
        $arr['name'] = $value['name'];
        
        if ($array_count_for_type !== false)
        {
            if (key_exists($value['id'], $array_count_for_type))
            {
                $arr['count'] = $array_count_for_type[$value['id']];
            }
            else 
                $arr['count'] = 0;
        }
        else 
            $arr['count'] = $value['count'];
            
        if ($value['id'] == $this->adress_array['area'] and !$region_center['current'])
        {
            $arr['current'] = true;
            $have_area_in_url = $value['id'];
        }
        else 
            $arr['current'] = false;
        $list_area[$value['id']] = $arr;
    }
    
//    print_r($list_area); 
//    die();
    
////
//////////////////////////////////////////////////////////////////////////////////////  end


///
//////////////////////////////////////////////////////////////////////////////////////  end

// !!!! Всегда пока смотрим областной центр
//$have_region_center_url = 1;
if ($have_region_center_url)
    throw new Dune_Exception_Control('Сейчс просматриваем обласной центр.');

    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
//////////////////////////////////////////////////////////////////////////////////////  begin
////                         Формирование списка поселков района

if ($have_area_in_url)
{
Dune_Zend_Cache::$allowSave = $store_cache_save;
Dune_Zend_Cache::$allowLoad = $store_cache_load;
       
        
    $text = Dune_Zend_Cache::loadIfAllow('adress_have_area_in_url_' . $have_area_in_url);
    if (!$text)
    {
        $q = 'SELECT sett.*, count(objects.id) as count
              FROM `unity_catalogue_adress_settlement` as sett,
                   `unity_catalogue_object` as objects
              WHERE sett.`area_id` = ?i
                    AND
                    sett.id = objects.settlement_id
                    AND
                    objects.activity = 1
                    AND
                    objects.settlement_id != 1
              GROUP BY sett.id
              ';
        $from_db = $BD->query($q, array($have_area_in_url), Dune_MysqliSystem::RESULT_IASSOC);
        if ($from_db)
            Dune_Zend_Cache::saveIfAllow(serialize($from_db), 'adress_have_area_in_url_' . $have_area_in_url,  array(Special_Vtor_Settings::CACHE_TAG_CATALOGUE));
     }
     else 
     {
         $from_db = unserialize($text);
     }
Dune_Zend_Cache::$allowSave = $store_cache_save_local;
Dune_Zend_Cache::$allowLoad = $store_cache_load_local;
    
    $from_db_type = array();
    // Формирование списка районов с учетом колличества типов по адресу
    $type = $this->type;
    if ($type and in_array($type, $types_total))
    {
        $array_count_for_type = array();
        $q = 'SELECT sett.*, count(objects.id) as count
              FROM `unity_catalogue_adress_settlement` as sett,
                   `unity_catalogue_object` as objects,
                   `unity_catalogue_object_type` as type' . $query_from . '
              WHERE sett.`area_id` = ?i
                    AND
                    sett.id = objects.settlement_id
                    AND
                    objects.activity = 1
                    AND
                    objects.type = type.id
                    AND 
                    type.id = ?i
                    AND
                    objects.settlement_id != 1
                    ' . $query_where . '
              GROUP BY sett.id
              ';
         $from_db_type = $BD->query($q, array($have_area_in_url, $type), Dune_MysqliSystem::RESULT_IASSOC);
         foreach ($from_db_type as $value)
         {
             $array_count_for_type[$value['id']] = $value['count'];
         }
    }
    else 
    {
        $array_count_for_type = false;
    }
    
    
    $cat_url->setArea($have_area_in_url);
    foreach ($from_db as $value)
    {
        $cat_url->setSettlement($value['id']);
        $arr = $value;
        $arr['link'] = $cat_url->get();
//        $arr['name'] = $value['name'];
        
        if ($array_count_for_type !== false)
        {
            if (key_exists($value['id'], $array_count_for_type))
            {
                $arr['count'] = $array_count_for_type[$value['id']];
            }
            else 
                $arr['count'] = 0;
        }
        else 
            $arr['count'] = $value['count'];
            
        if ($value['id'] == $this->adress_array['settlement'])
        {
            $arr['current'] = true;
//            $have_area_in_url = $value['id'];
        }
        else 
            $arr['current'] = false;
        $list_settlement[$value['id']] = $arr;
    }    
    
    
}
////
//////////////////////////////////////////////////////////////////////////////////////  end




}
catch (Dune_Exception_Control $e) // Срабатывает если нахождение текущей позиции в областном центре.
{
    
    $have_district_in_url = false;
//////////////////////////////////////////////////////////////////////////////////////  begin
////                         Формирование списка районов города

Dune_Zend_Cache::$allowSave = $store_cache_save;
Dune_Zend_Cache::$allowLoad = $store_cache_load;
       
        
    $text = Dune_Zend_Cache::loadIfAllow('adress_have_region_center_url_' . $have_region_center_url);
    if (!$text)
    {
        $q = 'SELECT dist.*, count(object.id) as count
              FROM `unity_catalogue_adress_district` as dist,
                   `unity_catalogue_object` as object
              WHERE dist.`settlement_id` = ?i
                    AND
                    dist.id = object.district_id
                    AND
                    object.activity = 1
              GROUP BY dist.id
              ';
        $from_db = $BD->query($q, array($have_region_center_url), Dune_MysqliSystem::RESULT_IASSOC);
        if ($from_db)
            Dune_Zend_Cache::saveIfAllow(serialize($from_db), 'adress_have_region_center_url_' . $have_region_center_url,  array(Special_Vtor_Settings::CACHE_TAG_CATALOGUE));
        }
        else 
        {
            $from_db = unserialize($text);
        }
Dune_Zend_Cache::$allowSave = $store_cache_save_local;
Dune_Zend_Cache::$allowLoad = $store_cache_load_local;

        
    $from_db_type = array();
    // Формирование списка районов с учетом колличества типов по адресу
    $type = $this->type;
    if ($type and in_array($type, $types_total))
    {
        $array_count_for_type = array();
        $q = 'SELECT dist.*, count(objects.id) as count
              FROM `unity_catalogue_adress_district` as dist,
                   `unity_catalogue_object` as objects,
                    `unity_catalogue_object_type` as type' . $query_from . '
              WHERE dist.`settlement_id` = ?i
                    AND
                    dist.id = objects.district_id
                    AND
                    objects.activity = 1
                    AND
                    objects.type = type.id
                    AND 
                    type.id = ?i
                    ' . $query_where . '
              GROUP BY dist.id
              ';
         $from_db_type = $BD->query($q, array($have_region_center_url, $type), Dune_MysqliSystem::RESULT_IASSOC);
         foreach ($from_db_type as $value)
         {
             $array_count_for_type[$value['id']] = $value['count'];
         }
    }
    else 
    {
        $array_count_for_type = false;
    }
    
    
    $cat_url->setArea($this->adress_array['area']);
    $cat_url->setSettlement($have_region_center_url);
    foreach ($from_db as $value)
    {
        $cat_url->setDistrict($value['id']);
        $arr['link'] = $cat_url->get();
        $arr['name'] = $value['name'];
        
        if ($array_count_for_type !== false)
        {
            if (key_exists($value['id'], $array_count_for_type))
            {
                $arr['count'] = $array_count_for_type[$value['id']];
            }
            else 
                $arr['count'] = 0;
        }
        else 
            $arr['count'] = $value['count'];
            
        if ($value['id'] == $this->adress_array['district'])
        {
            $arr['current'] = true;
            $have_district_in_url = $value['id'];
        }
        else 
            $arr['current'] = false;
        $list_district[$value['id']] = $arr;
    }
    
    
    
////
//////////////////////////////////////////////////////////////////////////////////////  end
    
//////////////////////////////////////////////////////////////////////////////////////  begin
////                         Формирование списка улиц в районе города
    
    if ($have_district_in_url)
    {
        $cat_url->setDistrict($have_district_in_url);

Dune_Zend_Cache::$allowSave = $store_cache_save;
Dune_Zend_Cache::$allowLoad = $store_cache_load;
       
        
        $text = Dune_Zend_Cache::loadIfAllow('adress_have_district_in_url_' . $have_district_in_url);
        if (!$text)
        {
            $q = 'SELECT street.*, count(object.id) as count
                  FROM `unity_catalogue_adress_street` as street, 
                       `unity_catalogue_object` as object
                  WHERE street.district_id = ?i
                        AND
                        street.id = object.street_id
                        AND
                        object.activity = 1
                  GROUP BY street.id
                  ORDER BY street.name
                  ';
            $from_db = $BD->query($q, array($have_district_in_url), Dune_MysqliSystem::RESULT_IASSOC);
            if ($from_db)
                Dune_Zend_Cache::saveIfAllow(serialize($from_db), 'adress_have_district_in_url_' . $have_district_in_url,  array(Special_Vtor_Settings::CACHE_TAG_CATALOGUE));
            
        }
        else 
        {
            $from_db = unserialize($text);
        }
Dune_Zend_Cache::$allowSave = $store_cache_save_local;
Dune_Zend_Cache::$allowLoad = $store_cache_load_local;
        
        
    // Формирование списка районов с учетом колличества типов по адресу
    $type = $this->type;
    if ($type and in_array($type, $types_total))
    {
        $array_count_for_type = array();
        
        $q = 'SELECT street.*, count(objects.id) as count
              FROM `unity_catalogue_adress_street` as street, 
                   `unity_catalogue_object` as objects,
                   `unity_catalogue_object_type` as type' . $query_from . '
              WHERE street.district_id = ?i
                    AND
                    street.id = objects.street_id
                    AND
                    objects.activity = 1
                    AND
                    objects.type = type.id
                    AND 
                    type.id = ?i
                    ' . $query_where . '
              GROUP BY street.id
              ';
        
         $from_db_type = $BD->query($q, array($have_district_in_url, $type), Dune_MysqliSystem::RESULT_IASSOC);
         foreach ($from_db_type as $value)
         {
             $array_count_for_type[$value['id']] = $value['count'];
         }
    }
    else 
    {
        $array_count_for_type = false;
    }
        
        
        $cat_url->setDistrict($have_district_in_url);
        
        foreach ($from_db as $value)
        {
            $cat_url->setStreet($value['id']);
            $arr['link'] = $cat_url->get();
            $arr['name'] = $value['name'];
            //$arr['count'] = $value['count'];
            
        if ($array_count_for_type !== false)
        {
            
            if (key_exists($value['id'], $array_count_for_type))
            { 
                $arr['count'] = $array_count_for_type[$value['id']];
            }
            else 
                $arr['count'] = 0;
        }
        else 
            $arr['count'] = $value['count'];
            
            
            if ($value['id'] == $this->adress_array['street'])
            {
                $arr['current'] = true;
                $have_street_in_url = $value['id'];
            }
            else 
                $arr['current'] = false;
            $list_street[$value['id']] = $arr;
        }
        
    }

////
//////////////////////////////////////////////////////////////////////////////////////  end
}


$view->assign('list_area', $list_area)
     ->assign('list_settlement', $list_settlement)
     
     ->assign('list_settlement_no_ryazan', $list_settlement_no_ryazan)
     
     ->assign('region_center', $region_center)
     ->assign('type', $type)
     ->assign('count_in_ryazan', $count_in_ryazan);
     
     
$view->assign('list_district', $list_district);
$view->assign('list_street', $list_street);

$view->assign($str_count, $$str_count);


/*
echo '<pre>';
print_r($this->adress_array);
print_r($list_areas);
echo '</pre>';
*/
if ($this->from_main)
{
    $str = $view->render('bit/catalogue/adress/list_main_with_objects_main_page');
}
else 
    $str = $view->render('bit/catalogue/adress/list_main_with_objects');
    
    Dune_Zend_Cache::saveIfAllow($str, $name_cache, array(Special_Vtor_Settings::CACHE_TAG_CATALOGUE));
    
    echo $str;

}
else 
    echo $data;

     Dune_Zend_Cache::$allowLoad = $store_cache_load;
     Dune_Zend_Cache::$allowSave = $store_cache_save;
    
    
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
    }
    
}