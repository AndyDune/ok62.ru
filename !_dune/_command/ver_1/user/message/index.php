<?php
    
    $URL = Dune_Parsing_UrlSingleton::getInstance();

    
    $folder_name = new Dune_Data_Container_Folder($URL[3]);
    $folder_name->setPath(dirname(__FILE__))
                ->registerDefault('list')
                ->register('list');
    
    $folder_name->check();
    
    $folder = Dune_Data_Collector_UrlSingleton::getInstance();
    $folder->addFolder($folder_name->getFolder());
    
    $folder = new Dune_Include_Folder($folder_name, Dune_Variables::$userStatus);
    
    $this->status = $folder->getStatus();
    $this->results = $folder->getResults();
    echo $folder->getOutput();
    