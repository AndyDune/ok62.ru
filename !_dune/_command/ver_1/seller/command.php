<?php
//  оманда публичных форм дл€ отсылки сообщений

    if (Dune_Variables::$userStatus < 599)
    {
    $this->setStatus(Dune_Include_Command::STATUS_GOTO);
    $this->setResult('goto', '/');
    return;
    }
    
try {
    
    $view = Dune_Zend_View::getInstance();
    $view->no_tosell_link = true;
    $URL = Dune_Parsing_UrlSingleton::getInstance();

    Dune_Static_StylesList::add('seller/base');
    $this->setStatus(Dune_Include_Command::STATUS_TEXT);
    
    $folder_name = new Dune_Data_Container_Folder($URL[2]);
    $folder_name->setPath(dirname(__FILE__))
                ->registerDefault('objects')
                ->register('objects')
                ->register('who')
                ->register('tall');
    
    $folder_name->check();
    
    $folder = Dune_Data_Collector_UrlSingleton::getInstance();
    $folder->addFolder($folder_name->getFolder());
    
    $folder = new Dune_Include_Folder($folder_name, Dune_Variables::$userStatus);
    
    $this->setStatus($folder->getStatus());
    $this->setResult($folder->getResults());
    
    $view->text = $folder->getOutput();
    
    
Dune_Static_StylesList::add('base', 1);
Dune_Static_StylesList::add('ie6', 200, Dune_Static_StylesList::MODE_IE6_STYLES);
Dune_Static_StylesList::add('elements');
Dune_Static_JavaScriptsList::addDependent('jquery', 'fw');


$view->assign('title', Dune_Variables::$pageTitle);
$view->assign('description', Dune_Variables::$pageDescription);
$view->assign('keywords', Dune_Variables::$pageKeywords);

$view_array = array(
                    'js' => Dune_Static_JavaScriptsList::get(),
                    'css' => Dune_Static_StylesList::get(),
                    );
$view->assign($view_array);
$view->view_path = Dune_Variables::$pathToViewFolder;

echo $view->render('page/general/seller');    

    
    
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