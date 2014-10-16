<?php
if (!Dune_Session::$auth or Dune_Variables::$userStatus < 500)
{
    throw new Dune_Exception_Control_NoAccess('page/user/info/can_not_look_info');
}
    Dune_Static_StylesList::add('user/nearby');

    $URL = Dune_Parsing_UrlSingleton::getInstance();
    $folder_name = new Dune_Data_Container_Folder($URL[3]);
    $folder_name->setPath(dirname(__FILE__));
    $folder_name->registerDefault('main');
    $folder_name->register('list');
    $folder_name->register('edit');
    
    $folder_name->check();
    
    $folder = new Dune_Include_Folder($folder_name, Dune_Variables::$userStatus);
    
    $this->setStatus($folder->getStatus());
    $this->setResult($folder->getResults());
    echo $folder->getOutput();
