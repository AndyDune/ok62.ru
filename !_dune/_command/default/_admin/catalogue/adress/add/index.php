<?php
/////       ВЕТВЬ
///////////////////////////////
////     
///     Страница в разделе каталога - редактирование зарегистрированных алресов.
///
    $URL = Dune_Parsing_UrlSingleton::getInstance();
    $folder_url = Dune_Data_Collector_UrlSingleton::getInstance();
        
    $folder_name = new Dune_Data_Container_Folder($URL[5]);
    $folder_name->setPath(dirname(__FILE__));
    $folder_name->registerDefault('region');
    $folder_name->register('region');
    $folder_name->register('area');
    $folder_name->register('settlement');
    $folder_name->register('district');
    $folder_name->register('street');
    $folder_name->register('dstreet');
    $folder_name->check();

    $folder_url->addFolder($folder_name->getFolder());
    
    echo $folder = new Dune_Include_Folder($folder_name, Dune_Variables::$userStatus);
    
    $this->results = $folder->getResults();
    $this->status = $folder->getStatus();
    
