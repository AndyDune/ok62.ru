<?php
//  оманда публичных форм дл€ отсылки сообщений

    $URL = Dune_Parsing_UrlSingleton::getInstance();
    $cooc = Dune_Cookie_ArraySingleton::getInstance(Dune_Parameters::$cookieNameSystem);
    $folder_postfix = '';
    Dune_Static_JavaScriptsList::add('thickbox');
    Dune_Static_StylesList::add('thickbox');
    Dune_Static_StylesList::add('catalogue/info_one');
    Dune_Static_StylesList::add('elements');
    
    if (Dune_Variables::$userStatus < 1 and $URL[3] == 'draw')
    {
        $folder_postfix = '_na';
    }
    
    $folder_name = new Dune_Data_Container_Folder($URL[3] . $folder_postfix);
    $folder_name->setPath(dirname(__FILE__));
    $folder_name->registerDefault('list');
    //$folder_name->register('look');
    $folder_name->register('info');
    $folder_name->register('draw' . $folder_postfix);
    
    $folder_name->check();
    
    $folder = Dune_Data_Collector_UrlSingleton::getInstance();
    $folder->addFolder($folder_name->getFolder());
    
    $folder = new Dune_Include_Folder($folder_name, Dune_Variables::$userStatus);
    
    $this->setStatus($folder->getStatus());
    $this->setResult($folder->getResults());
    echo $folder->getOutput();
