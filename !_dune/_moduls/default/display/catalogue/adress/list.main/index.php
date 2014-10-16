<?php
$view = Dune_Zend_View::getInstance();

// $this->url_info - объект строки запроса в каталог


$have_area_in_url = false;       // Нет указания района области в адресе
$have_settlement_in_url = false; // Нет указания города области в адресе
$have_region_center_url = false; // Нет ссылки на областной центр
$have_street_in_url = false;

$list_areas = array(); // Список районов областей
$region_center = array(); // Массив данных областного центра.
$list_settlement = array(); // Список посёлков в районе
$list_district = array(); // Список городских районов
$list_street = array(); // Список улиц района


    $cat_url = new Special_Vtor_Catalogue_Url_Collector();
    $cat_url->setRegion($this->adress_array['region']);
    $cat_url->setType($this->url_info->getType());

$BD = Dune_MysqliSystem::getInstance();
    

try {
//////////////////////////////////////////////////////////////////////////////////////  begin
////                         Формирование массива областного центра

    $q = 'SELECT sett.*, area.id as area_id
          FROM `unity_catalogue_adress_settlement` as sett, `unity_catalogue_adress_area` as area
          WHERE sett.`type` = 1 
                AND `sett`.`area_id` = area.id
                AND `area`.`region_id` = ?i
          ';
    $from_db = $BD->query($q, array($this->adress_array['region']), Dune_MysqliSystem::RESULT_ROWASSOC);
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
    $cat_url->setType($this->url_info->getType());


//////////////////////////////////////////////////////////////////////////////////////  begin
////                         Формирование списка районов области
$q = 'SELECT *
      FROM `unity_catalogue_adress_area`
      WHERE `region_id` = ?i
      ';
$from_db = $BD->query($q, array($this->adress_array['region']), Dune_MysqliSystem::RESULT_IASSOC);

foreach ($from_db as $value)
{
    $cat_url->setArea($value['id']);
    
    $arr['link'] = $cat_url->get();
    $arr['name'] = $value['name'];
    if ($value['id'] == $this->adress_array['area'] and !$have_region_center_url)
    {
        $arr['current'] = true;
        $have_area_in_url = $value['id'];
    }
    else 
        $arr['current'] = false;
    $list_areas[$value['id']] = $arr;
    
}
////
//////////////////////////////////////////////////////////////////////////////////////  end


if ($have_region_center_url)
    throw new Dune_Exception_Control('Сейчс просматриваем обласной центр.');

//////////////////////////////////////////////////////////////////////////////////////  begin
////                         Формирование списка поселков района

if ($have_area_in_url)
{
    $q = 'SELECT *
          FROM `unity_catalogue_adress_settlement`
          WHERE `area_id` = ?i
          ';
    $from_db = $BD->query($q, array($have_area_in_url), Dune_MysqliSystem::RESULT_IASSOC);
    
    $cat_url->setArea($this->adress_array['area']);
    foreach ($from_db as $value)
    {
        if ($value['type'] == 1)
        {
            continue;
        }
        $cat_url->setSettlement($value['id']);
        $arr['link'] = $cat_url->get();
        $arr['name'] = $value['name'];
        if ($value['id'] == $this->adress_array['settlement'])
        {
            $arr['current'] = true;
            $have_settlement_in_url = $value['id'];
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

    $q = 'SELECT *
          FROM `unity_catalogue_adress_district`
          WHERE `settlement_id` = ?i
          ';
    $from_db = $BD->query($q, array($have_region_center_url), Dune_MysqliSystem::RESULT_IASSOC);
    
    $cat_url->setArea($this->adress_array['area']);
    $cat_url->setSettlement($have_region_center_url);
    foreach ($from_db as $value)
    {
        $cat_url->setDistrict($value['id']);
        $arr['link'] = $cat_url->get();
        $arr['name'] = $value['name'];
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

        $q = 'SELECT *
              FROM `unity_catalogue_adress_street`
              WHERE `district_id` = ?i
              ';
        $from_db = $BD->query($q, array($have_district_in_url), Dune_MysqliSystem::RESULT_IASSOC);
        
        $cat_url->setDistrict($have_district_in_url);
        
        foreach ($from_db as $value)
        {
            $cat_url->setStreet($value['id']);
            $arr['link'] = $cat_url->get();
            $arr['name'] = $value['name'];
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


$view->assign('list_areas', $list_areas);
$view->assign('list_settlement', $list_settlement);
$view->assign('region_center', $region_center);

$view->assign('list_district', $list_district);
$view->assign('list_street', $list_street);

/*
echo '<pre>';
print_r($this->adress_array);
print_r($list_areas);
echo '</pre>';
*/
echo $view->render('bit/catalogue/adress/list_main');
?>