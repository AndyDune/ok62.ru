<?php
// Команда публичных форм для отсылки сообщений

try {
    $URL = Dune_Parsing_UrlSingleton::getInstance();

//    Dune_Static_StylesList::add('public/sell');

    $get = Dune_Filter_Get_Total::getInstance();

    $text = '';
    $page = $get->getDigit('page');
    $per_page = 10;
    
    $crumbs = $this->crumbs;
    $this->setResult('crumbs', $crumbs);

    $sections = $this->sections;
    $command_count = $this->command_count;
    
    if (count($sections))
    {
//        echo $sections[0]['name_code']; die();
        $current_section = $sections[0]['id'];
        $current_section_data = new Dune_Array_Container($sections[0]);
        Dune_Variables::addTitle($current_section_data['name'] . ' - ');
    }
    else 
        $current_section = 0;

    if (!$current_section)
    {
        throw new Dune_Exception_Control_Goto('/ocatalogue/');
    }
        
    $view = Dune_Zend_View::getInstance();        
        
    // Список детишек
    $section_children_o = new Special_Vtor_Organization_Children_List($current_section);
    $section_children_o->setHaveTexts();
    
//    $section_children_o->refreshCountText();
//    $section_children_o->refreshCountChildren();
    
    $section_children = $section_children_o->getDataArray();    
    
    $section_text = '';
    if (count($section_children))
    {
        $view->url = $URL->getCommandString();
        $view->sections = $section_children;
        $section_text = $view->render('bit/organization/list/sections');
    }

    // Список текстов раздела
//    echo $current_section; die();
    $text_list_o = new Special_Vtor_Organization_List($current_section);
    $count = $text_list_o->getCout();    
    
    if ($count)
    {
        $text_list_o->setOrder('time_insert', 'DESC');
        $text_list = $text_list_o->getList($page * $per_page, $per_page);    
//        $URL->cutCommands(1);
//        $URL->clearModifications();
        $view->url = $URL->getCommandString();
        $view->list = $text_list;
        $view->section_text = $section_text;
        $view->section_data = $current_section_data;
        $view->per_page = $per_page;
        $view->page = $page;
        $view->count = $count;
    }
    $text .= $view->render('bit/organization/list/text_local');
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