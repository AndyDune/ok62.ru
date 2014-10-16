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

    if ($data['have_photo'])
    {
        $img = new Special_Vtor_Sub_Image_House($data['id']);
        $one = $img->getOneImage();
        $view->photo_list = $img;
        $view->photo = $img->getOneImage($img->count() - 1);
        
    }
    else if ($data['complex_id'] and $data['complex_have_photo'])
    {
        $img = new Special_Vtor_Sub_Complex_Image_Photo($data['complex_id']);
        $one = $img->getOneImage();
        $view->photo_list = $img;        
        $view->photo = $img->getOneImage($img->count() - 1);
    }

    else 
        throw new Dune_Exception_Control_Goto($URL->getCommandString());
        
    $module = new Module_Sub_View_SetAddInfoForHousePage();
    $module->data = $data;
    $module->view = $view;
    $module->no_photo = true;
    $module->make();
    
    
    $URL->clearModifications();
    $crumbs = Dune_Display_BreadCrumb::getInstance('1');
    $crumbs->addCrumb('Фоторепортаж', $URL->getCommandString());
    Dune_Variables::addTitle('Фоторепортаж :: ' . $data['name'] . ' :: ');
    
    $view->crumbs = $crumbs->getString();
    $view->data = $data;
    $view->pd = $data['pd'];
    $view->info_center =  $view->render('bit/house/photo');
    
    $view->photo = false;
    $view->info_right =  $view->render('bit/house/add_info');
    
    $module = new Display_Complex_LeftSideInfo();
    $module->complex = $data['complex_id'];
    $module->house = $data['id'];
    $module->make();
    $view->info_left = $module->render();
    
    
    echo $view->render('page/one/default_3_col');
    
    Dune_Static_StylesList::add('cols');
    Dune_Static_StylesList::add('catalogue/info_one_photo');
    
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