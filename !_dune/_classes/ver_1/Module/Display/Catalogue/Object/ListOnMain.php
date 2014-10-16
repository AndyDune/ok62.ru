<?php

class Module_Display_Catalogue_Object_ListOnMain extends Dune_Include_Abstract_Code
{

    protected function code()
    {
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        

$text = Dune_Zend_Cache::loadIfAllow('catalogue_all_new' . $this->adress_object->getCacheTag()); // Смотрим кеш
if (!$text)
{
    $list = new Special_Vtor_Object_List();
    
    
    if ($this->adress_object->getAreaId() == 1 and $this->adress_object->getSettlementId() != 1)   
        $list->setNoRyazan();
    
    $list->setOrderTimeInsert('DESC');
    
    $list->setAdress($this->adress_object);
    
    $list->setActivity(1);
    
    //$list->setType(1)->setType(3)->setType(4)->setType(2);
    
    $object = new Module_Display_Catalogue_Object_List_NewOnCatalogueMain();
    $object->adress_object = $this->adress_object;
    $object->object_list = $list;
    $object->count = $this->count;
    
    
    $new_from_all = array();
    $object->type = 1;
    $object->make();
    $new_from_all[1] = array(
                           'count' => $object->getResult('count'),
                           'list' => $object->getResult('list'),
                           );
    $object->type = 2;
    $object->make();
    $new_from_all[2] = array(
                           'count' => $object->getResult('count'),
                           'list' => $object->getResult('list'),
                           );
    $object->type = 3;
    $object->make();
    $new_from_all[3] = array(
                           'count' => $object->getResult('count'),
                           'list' => $object->getResult('list'),
                           );
    $object->type = 4;
    $object->make();
    $new_from_all[4] = array(
                           'count' => $object->getResult('count'),
                           'list' => $object->getResult('list'),
                           );
    $object->type = 5;
    $object->make();
    $new_from_all[5] = array(
                           'count' => $object->getResult('count'),
                           'list' => $object->getResult('list'),
                           );
    $object->type = 6;
    $object->make();
    $new_from_all[6] = array(
                           'count' => $object->getResult('count'),
                           'list' => $object->getResult('list'),
                           );
    
                           
    
    $view = Dune_Zend_View::getInstance();
    $view->data = $new_from_all;
    
    $view->url_info = $this->url_info;
    
    $view->adress_object = $this->adress_object;
    
    $text = $view->render('bit/catalogue/main/list_new');
    Dune_Zend_Cache::saveIfAllow($text, 'catalogue_all_new' . $this->adress_object->getCacheTag(), array(Special_Vtor_Settings::CACHE_TAG_CATALOGUE));
}
echo 
    $text;
Dune_Static_StylesList::add('catalogue/list_all_new');
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
    }
    
}
    
    