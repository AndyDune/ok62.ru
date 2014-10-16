<?php
// Команда публичных форм для отсылки сообщений

try {
    $URL = Dune_Parsing_UrlSingleton::getInstance();

//    Dune_Static_StylesList::add('public/sell');

    $get = Dune_Filter_Get_Total::getInstance();

    $text = '';
    $page = $get->getDigit('page');
    
    $crumbs = $this->crumbs;
    $this->setResult('crumbs', $crumbs);

    $sections = $this->sections;
    $command_count = $this->command_count;
    
    if (count($sections))
        $current_section = $sections[0]['id'];
    else 
        $current_section = 0;

    $view = Dune_Zend_View::getInstance();        
        
    // Список детишек
    $section_children_o = new Special_Vtor_Organization_Children_List($current_section);
    $section_children = $section_children_o->getDataArray();    
    
    $section_text = '';
    if (count($section_children))
    {
        $view->url = $URL->getCommandString();
        $view->sections = $section_children;
        $section_text = $view->render('bit/organization/list/sections');
    }

    // Список текстов пока последних
    $texts_o = new Special_Vtor_Organization_List();
    $texts_o->setOrder('time_insert', 'DESC');
    $texts = $texts_o->getList(0, 12);
    
    if ($texts and count($texts))
    {
        $view->url = $URL->getCommandString();
        $view->list = $texts;
        $view->section_text = $section_text;
//        $text .= $view->render('bit/organization/list/text_main');
    }
    $text .= $view->render('bit/organization/list/text_main');
    
    echo $text;
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