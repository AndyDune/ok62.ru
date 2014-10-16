<?php
// Информация о доме Панорама

try {
    
    $URL = Dune_Parsing_UrlSingleton::getInstance();    
    $GET = Dune_Filter_Get_Total::getInstance();
            
/////////////////////////////////////////////////////////////            
////////////    Отображение информации о доме
        

    $data = $this->data;
        
    $view = Dune_Zend_View::getInstance();
    
    $view->url_sourse = $URL->getCommandString();
    $URL->cutCommands(2);
    $view->url = $URL->getCommandString();

    if (!($data['panorama_id'] or $data['complex_panorama_id']))
    {
        throw new Dune_Exception_Control_Goto($URL->getCommandString());
    }
    if ($data['panorama_id'])
        $panorama_id = $data['panorama_id'];
    else 
        $panorama_id = $data['complex_panorama_id'];
    $panorama = new Special_Vtor_Catalogue_Info_PanoramaCommon($panorama_id); // а есть ли панораы
    if (!$panorama->count())
        throw new Dune_Exception_Control_Goto($URL->getCommandString());
    
    
    $module = new Module_Sub_View_SetAddInfoForComplexPage();
    $module->data = $data;
    $module->view = $view;
    $module->make();
    
    
    $URL->clearModifications();
    $crumbs = Dune_Display_BreadCrumb::getInstance('1');
    $crumbs->addCrumb('Панорамный обзор', $URL->getCommandString());
    
    Dune_Variables::addTitle('Панорамный обзор :: ' . $data['name'] . ' :: ');
    
    $view->number = $GET->getDigit('number', 1, 2);
    $view->crumbs = $crumbs->getString();
    $view->data = $data;
    $view->pd = $data['pd'];
    $view->panorama = $panorama;
    $view->info_center =  $view->render('bit/complex/panorama');
    
    $view->info_right =  $view->render('bit/complex/add_info');
    
    $module = new Display_Complex_LeftSideInfo();
    $module->complex = $data['id'];
    $module->make();
    $view->info_left = $module->render();
    
    
    //echo $view->render('page/one/default_3_col');
    echo $view->render('page/one/default_2_col');
    
    Dune_Static_StylesList::add('cols');
//    Dune_Static_StylesList::add('catalogue/info_one_photo');
    Dune_Static_StylesList::add('catalogue/info_panorama'); 
    
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