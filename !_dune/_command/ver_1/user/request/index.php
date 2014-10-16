<?php
    Dune_Static_StylesList::add('public/request');
if (Dune_Session::$auth)
{
    $URL = Dune_Parsing_UrlSingleton::getInstance();
    $folder_name = new Dune_Data_Container_Folder($URL[3]);
    $folder_name->setPath(dirname(__FILE__));
    $folder_name->registerDefault('list');
    $folder_name->register('info');
    
    $folder_name->check();
    
    $folder = new Dune_Include_Folder($folder_name, Dune_Variables::$userStatus);
    
    $this->setStatus($folder->getStatus());
    $this->setResult($folder->getResults());
    echo $folder->getOutput();
}
else 
{
    $view = Dune_Zend_View::getInstance();
    echo $view->render('page/user/info/can_not_look_info');
}