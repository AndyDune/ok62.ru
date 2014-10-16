<?php

class Module_Display_Catalogue_Object_TypeList extends Dune_Include_Abstract_Code
{

    protected function code()
    {
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        



// Модуль - дисплей форми рования списка типов
$view = Dune_Zend_View::getInstance();

// $this->url_info - объект строки запроса в каталог

$list = array(); // Список типов


    $cat_url = new Special_Vtor_Catalogue_Url_Collector();
    $cat_url->setRegion($this->adress_array['region']);
    $cat_url->setArea($this->adress_array['area']);
    $cat_url->setSettlement($this->adress_array['settlement']);
    $cat_url->setDistrict($this->adress_array['district'], Special_Vtor_Settings::$districtPlus);
    $cat_url->setStreet($this->adress_array['street']);
    
$BD = Dune_MysqliSystem::getInstance();    

/*$q = 'SELECT *
      FROM `unity_catalogue_object_type`
      ';
$from_db = $BD->query($q, null, Dune_MysqliSystem::RESULT_IASSOC);
*/
$vars = Dune_Variables::getInstance();
$type = new Special_Vtor_Object_Types((int)$vars->subdomainFocusUserId);
$from_db = $type->getListTypeWithObjectsActive();
if ($from_db)
{
    foreach ($from_db as $value)
    {
        $cat_url->setType($value['id']);
        $arr['link'] = $cat_url->get();
        $arr['name'] = $value['name_many'];
        $arr['count'] = $value['count'];
        if ($value['id'] == $this->url_info->getType())
            $arr['current'] = true;
        else 
            $arr['current'] = false;
        $list[] = $arr;            
    }
}    

$view->assign('list', $list);

$session = Dune_Session::getInstance('filter');
if ($this->url_info->getType() != $session->type)
{
    $session->killZone();
}

echo $view->render('bit/catalogue/object/type_list');




/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
    }
    
}
    
    