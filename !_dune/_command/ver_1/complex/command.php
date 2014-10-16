<?php
// Команда публичных форм для отсылки сообщений

    $URL = Dune_Parsing_UrlSingleton::getInstance();

    $crumbs = Dune_Display_BreadCrumb::getInstance('1');
    $crumbs->addCrumb('Главная', '/');
   
    
    Dune_Static_StylesList::add('complex_house');
    $id = (int)$URL[2];
    if ($URL[2] == $id and $id > 1)
    {
        $command = 'one';
    }
    else 
        $command = $URL[2];
    
    $folder_name = new Dune_Data_Container_Folder($command);
    $folder_name->setPath(dirname(__FILE__));
    $folder_name->registerDefault('main');
    $folder_name->register('main');
    $folder_name->register('one');
    $folder_name->check();
    
    $folder_name->registerParameter('id', $id);
    
    $folder = new Dune_Include_Folder($folder_name, Dune_Variables::$userStatus);
    
    $this->status = $folder->getStatus();
    $this->results = $folder->getResults();
    echo $folder->getOutput();
    
    
    Dune_Static_JavaScriptsList::add('thickbox');
    Dune_Static_StylesList::add('thickbox');
    
    
    Special_Vtor_Users::$topMainBanners = false;
    