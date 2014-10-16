<?php
// Команда публичных форм для отсылки сообщений

try {
    $URL = Dune_Parsing_UrlSingleton::getInstance();

//    Dune_Static_StylesList::add('public/sell');
    
    $command_count = count($URL);
    
    $command = 'main';
    $text_one_name_code = '';
    $sections = array();
    
    if ($command_count > 1)
    {
        $command_count_next = $command_count;
        if (strcmp($URL->getCommandPart($command_count, 2, false, '.'), 'html') == 0)
        { 
            $command_count_next--;
            $text_one_name_code = $URL->getCommandPart($command_count, 1, false, '.');
            $command = 'one';
        }
        else 
            $command = 'list';
        if ($command_count_next > 1)
        {
            $sections_o = new Special_Vtor_Organization_Parents_List();
            $array = $sections_o->setSectionCode($URL->getCommand($command_count_next));
            if ($array)
            {
                $sections = $sections_o->getDataArray();
//                print_array($sections); die();
            }
        }        
    }
    $crumbs = Dune_Display_BreadCrumb::getInstance();
    $crumbs->addCrumb('Главная', '/');
    $crumbs->addCrumb('Каталог организаций', '/ocatalogue/');
    Dune_Variables::addTitle('Каталог организаций - ');
//    print_array($sections);    
	    
    if (count($sections))
    {
//        $command = 'list';
        $sections_temp = $sections;
        krsort($sections_temp);
        $accum = '';
        foreach ($sections_temp as $value)
        {
            if ($value['name_crumb'])
                $name = $value['name_crumb'];
            else 
                $name = $value['name'];
            $accum .= '/' . $value['name_code'];
            $crumbs->addCrumb(ucfirst($name), '/ocatalogue' . $accum . '/');
        }
        unset($sections_temp);
    }

    $folder_name = new Dune_Data_Container_Folder($command);
    $folder_name->setPath(dirname(__FILE__));
    $folder_name->registerDefault('main');
    $folder_name->register('list');
    $folder_name->register('one');
    $folder_name->register('main');
    
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