<?php

try {
    //////////////////////// Выполняемый код
    
    include_once('!_lib/library.php');
    include_once('!_lib/EdinstvoBean.php');
    include_once('!_lib/HypParameter.php');    
    include_once('!_lib/HypBank.php');
    include_once('!_lib/HypProgram.php');
    include_once('!_lib/HypCondition.php');
    
    ////////////////////////////////////////
    
    
    $this->setStatus(Dune_Include_Command::STATUS_PAGE);
    $this->setResult(array());
    
    $GET = Dune_Filter_Get_Total::getInstance();
    
    
    $folder_name = new Dune_Data_Container_Folder($GET['name']);
    $folder_name->setPath(dirname(__FILE__));
    $folder_name->registerDefault('Hypothec');
    $folder_name->register('Hypothec');
    
    $folder_name->check();
    
    $folder = new Dune_Include_Folder($folder_name, Dune_Variables::$userStatus);
    
    $this->setStatus($folder->getStatus());
    $this->setResult($folder->getResults());
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
        $view = Dune_Zend_View::getInstance();
        echo $view->render($e->getMessage());
    }
    else 
    {
        $this->setResult('goto', '/');
        $this->setStatus(Dune_Include_Command::STATUS_EXIT);
    }
}