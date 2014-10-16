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
          FROM unity_catalogue_adress_region 
          WHERE id = ?i
          ';
    $DB = Dune_MysqliSystem::getInstance();
    $data_region = $DB->query($q, array($URL[6]), Dune_MysqliSystem::RESULT_ROWASSOC);
    if (!$data_region)
        throw new Dune_Exception_Control_Goto($folder_url->getExeptLastFolder());
    
    
    $q = 'SELECT * 
          FROM unity_catalogue_adress_area
          WHERE region_id = ?i 
          ORDER BY name';
    $DB = Dune_MysqliSystem::getInstance();
    $list_areas = $DB->query($q, array($URL[6]), Dune_MysqliSystem::RESULT_IASSOC);

        
    
    $crumbs = Dune_Display_BreadCrumb::getInstance();
    $crumbs->addCrumb('Области', $folder_url->getExeptLastFolder());
    $crumbs->addCrumb($data_region['name']);
    echo $crumbs->getString();

    
    $view = Dune_Zend_View::getInstance();
    $view->link_next_list = $folder_url->getExeptLastFolder() . 'settlement';
    $view->link_edit = $folder_url->getExeptLastFolder(2) . 'info/area';
    $view->link_add = $folder_url->getExeptLastFolder(2) . 'add/area/' . $data_region['id'] . '/';
    $view->data = $list_areas;
    echo $view->render('page/catalogue/adress/list/area');
}
catch (Dune_Exception_Control_Goto $e)
{
    Dune_Static_Header::location($e->getMessage());
    $this->status = Dune_Include_Command::STATUS_TEXT;
}