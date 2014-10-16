<?php
// Команда настроек пользователя

try {
    
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
    $folder_name->setPath(dirname(__FILE__))
                ->registerDefault('info')
                ->register('info')
                ->register('edit')
                ->register('enter')
                ->register('recall')
                ->register('registration')
                ->register('checkmail')
                ->register('changepassword')
                ->register('basket')
                ->register('salelist')
                ->register('sell')
                ->register('do')
                ->register('regorenter')
                ->register('list')
                ->register('dialogs')
                ->register('request')
                ->register('message')
                ->register('contact' . $ajax)
                ->register('check' . $ajax);
    
    $folder_name->register('nearby'); // Просмотр вражеских объектов застройщиками
    
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