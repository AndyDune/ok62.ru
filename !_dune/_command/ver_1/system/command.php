<?php
// Команда настроек пользователя

try {
    
    if (!Dune_Session::$auth or Dune_Variables::$userStatus < 1000) // Пользователь не может смотреть информацию о продавцах
    {
        throw new Dune_Exception_Control_NoAccess('page/user/info/can_not_look_info', 1);
    }
    
    
    $URL = Dune_Parsing_UrlSingleton::getInstance();

    Dune_Static_StylesList::add('public/sell');
    Dune_Static_StylesList::add('catalogue/info_one');
    Dune_Static_StylesList::add('elements');
    
    if (Dune_Parameters::$ajax and false)
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
    $folder_name->registerDefault('export');
    $folder_name->register('export');
    $folder_name->register('analis');
    
    $folder_name->check();
    
    $folder = Dune_Data_Collector_UrlSingleton::getInstance();
    $folder->addFolder($folder_name->getFolder());
    
    $folder = new Dune_Include_Folder($folder_name, Dune_Variables::$userStatus);
    
    $this->status = $folder->getStatus();
    $this->results = $folder->getResults();
    echo $folder->getOutput();
    
}
catch (Dune_Exception_Control_Goto $e)
{
    if ($e->getCode())
    {
        Dune_Static_Message::setCode($e->getCode());
    }
    if ($e->getMessage())
    {
        $this->setStatus(Dune_Include_Command::STATUS_GOTO);
        $this->setResult('goto', $e->getMessage());
    }
    else 
    {
        $this->setStatus(Dune_Include_Command::STATUS_EXIT);
    }
}
catch (Dune_Exception_Control_NoAccess $e)
{
    if ($e->getCode())
    {
        Dune_Static_Message::setCode($e->getCode());
    }
    if ($e->getMessage())
    {
        Dune_Static_StylesList::add('user/info/message');
        $view = Dune_Zend_View::getInstance();
        echo $view->render($e->getMessage());
    }
    else 
    {
        $this->setResult('goto', '/');
        $this->setStatus(Dune_Include_Command::STATUS_EXIT);
    }
}