<?php
// Команда настроек пользователя

    $URL = Dune_Parsing_UrlSingleton::getInstance();


    $folder_name = new Dune_Data_Container_Folder($URL[2]);
    $folder_name->setPath(dirname(__FILE__));
    $folder_name->registerDefault('info');
    $folder_name->register('info');
    $folder_name->register('edit');
    $folder_name->register('enter');
    $folder_name->register('recall');
    $folder_name->register('registration');
    $folder_name->register('checkmail');
    $folder_name->register('changepassword');
    $folder_name->register('basket');
    $folder_name->register('salelist');
    $folder_name->register('do');
    
    $folder_name->check();
    
    $folder = Dune_Data_Collector_UrlSingleton::getInstance();
    $folder->addFolder($folder_name->getFolder());
    
    $folder = new Dune_Include_Folder($folder_name, Dune_Variables::$userStatus);
    
    $this->status = $folder->getStatus();
    $this->results = $folder->getResults();
    echo $folder->getOutput();
