<?php
// Информация о доме

try {
    
    $URL = Dune_Parsing_UrlSingleton::getInstance();    
    
            
/////////////////////////////////////////////////////////////            
////////////    Отображение информации о доме
        

    $data = $this->data;
        
    $view = Dune_Zend_View::getInstance();
    
    $URL->cutCommands(2);
    $view->url = $URL->getCommandString();

    if (!$data['pd'])
    {
        throw new Dune_Exception_Control_Goto($URL->getCommandString());
    }    
    
    $module = new Module_Sub_View_SetAddInfoForHousePage();
    $module->data = $data;
    $module->view = $view;
    $module->make();

    $crumbs = Dune_Display_BreadCrumb::getInstance('1');
    $crumbs->addCrumb('Проектная декларация', $URL->getCommandString());
    Dune_Variables::addTitle('Проектная декларация :: ' . $data['name'] . ' :: ');
    
    $view->crumbs = $crumbs->getString();
    
    $view->data = $data;
    $view->info_center =  $view->render('bit/house/pd');
    
    $view->info_right =  $view->render('bit/house/add_info');
    
    //echo $view->render('page/one/default_3_col');
    echo $view->render('page/one/default_2_col');
    
    Dune_Static_StylesList::add('cols');
    
/*    echo '<img src="';
    echo $one->getSourseFileUrl();
    echo '" /><br />';
   
    echo '<img src="';    
    echo $one->getPreviewFileUrl();
    echo '" /><br />';
*/    
//////////////////////////////////////////////////////////////        
    
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