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

    $command_count = $this->command_count;
    
        
    $view = Dune_Zend_View::getInstance();

    // Список текстов раздела
    $text_list_o = new Special_Vtor_Organization_List();
    $session = Dune_Session::getInstance(Dune_Session::ZONE_AUTH);

    if (Dune_Variables::$userStatus < 500)
        $text_list_o->setUser($session->user_id);
    $count = $text_list_o->getCout();    
    
    $text_list_o->setOrder('time_insert', 'DESC');
    $text_list = $text_list_o->getList($page * $per_page, $per_page);    
    $URL->cutCommands(1)->setCommand('edit');
    $view->url_edit = $URL->getCommandString();
    $view->list = $text_list;
    $view->per_page = $per_page;
    $view->page = $page;
    $view->count = $count;
    $text .= $view->render('bit/organization/list/text_user');
        
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