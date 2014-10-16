<?php
// Информация о доме

try {
    
    $URL = Dune_Parsing_UrlSingleton::getInstance();    
    
    $vars = Dune_Variables::getInstance();
    
    
	$list_houses = new Special_Vtor_Sub_List_Complex();
	
	
    if (Special_Vtor_Object_List::$edinstvo)
        $list_houses->setEdinstvo();
    else if (Special_Vtor_Object_List::$user)
        $list_houses->setUser(Special_Vtor_Object_List::$user);
    else 
	   $list_houses->setEdinstvo();
	
	$result = $list_houses->getDatas();
        
    $view = Dune_Zend_View::getInstance();
    
    $URL->cutCommands(1);
    $view->url = $URL->getCommandString();

    $crumbs = Dune_Display_BreadCrumb::getInstance('1');
    $crumbs->addCrumb('Все комплексы');
    $view->crumbs = $crumbs->getString();
    
    $view->data = $result;
    $view->info_center =  $view->render('bit/complex/list');
    
    $view->info_right =  '';
    
    echo $view->render('page/one/default_3_col');
    Dune_Static_StylesList::add('cols');
	
	

    
    $this->getStatus(Dune_Include_Command::STATUS_PAGE);
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