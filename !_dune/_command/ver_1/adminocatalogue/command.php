<?php
// Команда публичных форм для отсылки сообщений

try {
    
    if (!Dune_Session::$auth) // Пользователь не может смотреть информацию о продавцах
    {
        throw new Dune_Exception_Control_Goto('/ocatalogue/');
    }
    
    $view = Dune_Zend_View::getInstance();
    $session = Dune_Session::getInstance('ocatalogue');
    $view->message = $session->message;
    $session->message = null;

    
    $URL = Dune_Parsing_UrlSingleton::getInstance();

    $command_count = count($URL);
    
    $command = 'list';
    $text_one_name_code = '';
    $sections = array();
    
    $crumbs = Dune_Display_BreadCrumb::getInstance();
    $crumbs->addCrumb('Главная', '/');
    $crumbs->addCrumb('Каталог организаций', '/ocatalogue/');
    $crumbs->addCrumb('Список организаций для редактирования', '/adminocatalogue/');
    Dune_Variables::addTitle('Каталог организаций - ');
//    print_array($sections);    
	    
    $folder_name = new Dune_Data_Container_Folder($URL->getCommand(2, 'list'));
    $folder_name->setPath(dirname(__FILE__));
    $folder_name->registerDefault('list');
    $folder_name->register('edit');
    $folder_name->register('list');
    $folder_name->register('all');
    
    $folder_name->crumbs = $crumbs;
    $folder_name->sections = $sections;
    $folder_name->text_one_name_code = $text_one_name_code;
    $folder_name->command_count = $command_count;
    
    $folder_name->check();

    $folder = new Dune_Include_Folder($folder_name, Dune_Variables::$userStatus);
    
    
//    $this->status = $folder->getStatus();
//    $this->results = $folder->getResults();
    $this->setStatus($folder->getStatus());
    $this->setResult($folder->getResults());
    
    if ($folder->checkStatus(Dune_Include_Command::STATUS_GOTO))
        return;
    
    
    $text = $folder->getOutput();
    
    $crumbs = $folder->getResult('crumbs');
    
    $crumbs_text = $crumbs->getString('<p id="breadcrumb">', '</p>');
    
    $text = $crumbs_text . $text;
    
    $view = Dune_Zend_View::getInstance();
    
    $view->text = $text;
    $view->banners = $view->render('bit/banners/some');
    echo $view->render('bit/general/container_padding_for_banners');
    
    Dune_Static_StylesList::add('base');    
    Dune_Static_StylesList::add('read');
    Dune_Static_StylesList::add('ocatalogue');
    
    
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