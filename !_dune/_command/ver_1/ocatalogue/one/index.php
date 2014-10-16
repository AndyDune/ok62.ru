<?php
//  оманда публичных форм дл€ отсылки сообщений

try {
    $URL = Dune_Parsing_UrlSingleton::getInstance();

//    Dune_Static_StylesList::add('public/sell');

    $sections = $this->sections;
    $command_count = $this->command_count;
    $text_one_name_code = $this->text_one_name_code;
    $crumbs = $this->crumbs;
    
    $table = 'unity_organization_text';

    $one = new Dune_Mysqli_Table($table);

    $one->useKey('name_code', $text_one_name_code);

    if (!$data = $one->getData(true))
    {
        throw new Dune_Exception_Control_Goto('/ocatalogue/');
    }

    if ($data['name_crumb'])
        $name = $data['name_crumb'];
    else 
        $name = $data['name'];
    
   
    $crumbs->addCrumb(ucfirst($name), $text_one_name_code);
    $this->setResult('crumbs', $crumbs);
   

    $view = Dune_Zend_View::getInstance();
    
    Dune_Variables::addTitle($this->sections[0]['name'] . ' - ');
    Dune_Variables::addTitle($data['name'] . ' - ');
    
    $view->data = $data;
    $view->url = $URL->getCommandString();
    $text = $view->render('bit/organization/one/info');
    
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