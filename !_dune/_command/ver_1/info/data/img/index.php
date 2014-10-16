<?php
    
    $URL = Dune_Parsing_UrlSingleton::getInstance();

    $comm = $URL[3];
    
    $folder_name = new Dune_Data_Container_Folder($comm);
    $folder_name->setPath(dirname(__FILE__))
                ->registerDefault('gm_object')
                ->register('gm_object');
    
    
    $folder_name->check();
    
    
    $folder = new Dune_Include_Folder($folder_name, Dune_Variables::$userStatus);
    
    $this->status = $folder->getStatus();
    $this->results = $folder->getResults();
    echo $folder->getOutput();
    