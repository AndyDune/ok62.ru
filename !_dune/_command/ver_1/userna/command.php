<?php
// Команда настроек пользователя

    $URL = Dune_Parsing_UrlSingleton::getInstance();

    Dune_Static_StylesList::add('public/sell');
    Dune_Static_StylesList::add('catalogue/info_one');

    Dune_Static_StylesList::add('elements');
    
    if (Dune_Parameters::$ajax)
    {
        $ajax = '_ajax';
        $comm = $URL[2] . $ajax;
    }
    else 
    {
        $ajax = '';
        $comm = $URL[2];
    }
    
    $folder_name = new Dune_Data_Container_Folder($comm);
    $folder_name->setPath(dirname(__FILE__));
    $folder_name->registerDefault('request');
    $folder_name->register('request');

    
    $folder_name->check();
    
    $folder = Dune_Data_Collector_UrlSingleton::getInstance();
    $folder->addFolder($folder_name->getFolder());
    
    $folder = new Dune_Include_Folder($folder_name, Dune_Variables::$userStatus);
    
    $this->status = $folder->getStatus();
    $this->results = $folder->getResults();
    echo $folder->getOutput();
