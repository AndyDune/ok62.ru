<?php
/////       Лист
///////////////////////////////
////     
///     Список районов области
///
    $URL = Dune_Parsing_UrlSingleton::getInstance(); // Сачас 6-я возможна
    $folder_url = Dune_Data_Collector_UrlSingleton::getInstance();

try {
    if ((int)$URL[6] < 1)
    {
        throw new Dune_Exception_Control_Goto($folder_url->getExeptLastFolder());
    }

    $q = 'SELECT * 
          FROM unity_catalogue_adress_area
          WHERE id = ?i
          ';
    $DB = Dune_MysqliSystem::getInstance();
    $data_area = $DB->query($q, array($URL[6]), Dune_MysqliSystem::RESULT_ROWASSOC);
    if (!$data_area)
        throw new Dune_Exception_Control_Goto($folder_url->getExeptLastFolder(2));
    
    $q = 'SELECT * 
          FROM unity_catalogue_adress_region 
          WHERE id = ?i
          ';
    $DB = Dune_MysqliSystem::getInstance();
    $data_region = $DB->query($q, array($data_area['region_id']), Dune_MysqliSystem::RESULT_ROWASSOC);
    if (!$data_region)
        throw new Dune_Exception_Control_Goto($folder_url->getExeptLastFolder(2));
    
    
    $q = 'SELECT * 
          FROM unity_catalogue_adress_settlement
          WHERE area_id = ?i 
          ORDER BY type, name';
    $DB = Dune_MysqliSystem::getInstance();
    $list_settlement = $DB->query($q, array($data_area['id']), Dune_MysqliSystem::RESULT_IASSOC);

    $list_ob = new Special_Vtor_Object_List();
    $list_ob->setShowWitoutHouseNumber();
    $list_ob->setRegion($data_area['region_id']);
    $list_ob->setArea($data_area['id']);
    $LIST_SETTLEMENT = array();
    if ($list_settlement->count())
    {
        foreach ($list_settlement as $key => $value)
        {
            $list_ob->setSettlement($value['id']);
            $LIST_SETTLEMENT[$key] = $value;
            
            $list_ob->setActivity(0);
            $LIST_SETTLEMENT[$key]['count_total'] = $list_ob->count();
            $list_ob->setActivity(1);
            $LIST_SETTLEMENT[$key]['count_active'] = $list_ob->count();
        }
    }
    
    
    
    $link_list = $folder_url->getExeptLastFolder(2) . 'list/area/' . $data_region['id'] . '/';        
    
    $crumbs = Dune_Display_BreadCrumb::getInstance();
    $crumbs->addCrumb('Области', $folder_url->getExeptLastFolder());
    $crumbs->addCrumb('Районы области: ' . $data_region['name'], $link_list);
    $crumbs->addCrumb('Посёлки района: ' . $data_area['name']);
    echo $crumbs->getString();

    
    $view = Dune_Zend_View::getInstance();
    $view->link_next_list_center = $folder_url->getExeptLastFolder() . 'district';
    $view->link_next_list = $folder_url->getExeptLastFolder() . 'street';
    
    $URL->cutCommands(4)->setCommand('object');
    
    $view->link_list_object = $folder_url->getExeptLastFolder() . 'object';
    
    $URL->cutCommands(2)->setCommand('adress')->setCommand('info');
  
    $view->link_edit = $URL->getCommandString() . 'settlement';

    
    $view->link_add = $folder_url->getExeptLastFolder(2) . 'add/settlement/' . $data_area['id'] . '/';
    $view->data = new Dune_Array_Container($LIST_SETTLEMENT);
    echo $view->render('page/catalogue/object/list/settlement');
}
catch (Dune_Exception_Control_Goto $e)
{
    Dune_Static_Header::location($e->getMessage());
    $this->status = Dune_Include_Command::STATUS_TEXT;
}