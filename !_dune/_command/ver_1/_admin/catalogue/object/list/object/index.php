<?php
/////       Лист
///////////////////////////////
////     
///     Список объектов улицы или поселка или района.
///

try {


    $URL = Dune_Parsing_UrlSingleton::getInstance();
    $folder_url = Dune_Data_Collector_UrlSingleton::getInstance();
        
    //echo $URL->getCommandPart(6, 1, false, '-'); die();
    
    $folder_name = new Dune_Data_Container_Folder($URL->getCommandPart(6, 1, false, '-'));
    $folder_name->setPath(dirname(__FILE__));
    $folder_name->registerDefault('street');
    $folder_name->register('street');
    $folder_name->register('settlement');
    $folder_name->check();

    $folder_url->addFolder($folder_name->getFolder());
    
    echo $folder = new Dune_Include_Folder($folder_name, Dune_Variables::$userStatus);
    
    $this->results = $folder->getResults();
    $this->status = $folder->getStatus();
    

}
catch (Dune_Exception_Control_Goto $e)
{
    Dune_Static_Header::location($e->getMessage());
    $this->status = Dune_Include_Command::STATUS_TEXT;
}