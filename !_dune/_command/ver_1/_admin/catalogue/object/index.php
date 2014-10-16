<?php
/////       ВЕТВЬ
///////////////////////////////
////     
///     Что показываем: список, форму редактора или форму новшества.
///
    $URL = Dune_Parsing_UrlSingleton::getInstance();
    $folder_url = Dune_Data_Collector_UrlSingleton::getInstance();
        

    $folder_name = new Dune_Data_Container_Folder($URL[4]);
    $folder_name->setPath(dirname(__FILE__));
    $folder_name->registerDefault('list');
    $folder_name->register('list');
    $folder_name->register('edit');
    $folder_name->register('add');
    $folder_name->check();

    
    $folder_url->addFolder($folder_name->getFolder());
    echo $folder = new Dune_Include_Folder($folder_name, Dune_Variables::$userStatus);
    $this->results = $folder->getResults();
    $this->status = $folder->getStatus();
    
  
    
    
/*    $crumbs = Dune_Display_BreadCrumb::getInstance();
    $crumbs->addCrumb('Адреса', $folder_url->get());
    echo $crumbs->getString();
*/
    
