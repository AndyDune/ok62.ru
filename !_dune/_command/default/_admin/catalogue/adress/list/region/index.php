<?php
/////       Лист
///////////////////////////////
////     
///     Список областей
///
    $URL = Dune_Parsing_UrlSingleton::getInstance(); // Сачас 5-я возможна
    $folder_url = Dune_Data_Collector_UrlSingleton::getInstance();
        
    
    $crumbs = Dune_Display_BreadCrumb::getInstance();
    $crumbs->addCrumb('Области');
    echo $crumbs->getString();

    
    $q = 'SELECT * 
          FROM unity_catalogue_adress_region 
          ORDER BY name';
    $DB = Dune_MysqliSystem::getInstance();
    $data = $DB->query($q, null, Dune_MysqliSystem::RESULT_IASSOC);
    
    $view = Dune_Zend_View::getInstance();
    $view->link_next_list = $folder_url->getExeptLastFolder() . 'area';
    $view->data = $data;

    echo $view->render('page/catalogue/adress/list/region');