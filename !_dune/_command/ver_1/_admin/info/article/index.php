<?php
	
	
/////       ÂÅÒÂÜ
///////////////////////////////
////     
///
	$URL = Dune_Parsing_UrlSingleton::getInstance();
	
    $crumbs = Dune_Display_BreadCrumb::getInstance();
    $crumbs->addCrumb('Íà÷àëî', $URL->getCommandString());
    

    $folder_name = new Dune_Data_Container_Folder($URL[4]);
    $folder_name->setPath(dirname(__FILE__));
    $folder_name->registerDefault('main');
    $folder_name->register('main');
    $folder_name->register('comments');
    $folder_name->register('commentsmoder');
    $folder_name->register('sections');
    $folder_name->register('texts');
    $folder_name->register('edittext');
    $folder_name->register('editsection');
    $folder_name->check();

try
{    
    
    
    echo $folder = new Dune_Include_Folder($folder_name, Dune_Variables::$userStatus);
    $this->results = $folder->getResults();
	
    $view = Dune_Zend_View::getInstance();
	
    $this->setStatus($folder->getStatus());
    
    
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
