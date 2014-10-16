<?php
// Шахматка объектов

try {
    
    $URL = Dune_Parsing_UrlSingleton::getInstance();    
    
            
/////////////////////////////////////////////////////////////            
////////////    Отображение информации о доме
    $grids = array(
                  'room'   => array(1, 'Шахматка квартир'),
                  'nolife' => array(4, 'Шахматка нежилых помещений')
                  );

    $data = $this->data;
        
    $view = Dune_Zend_View::getInstance();
    
    $URL->cutCommands(2);
    $view->url = $URL->getCommandString();

    
    if (!$data['grid_id'])
    {
        throw new Dune_Exception_Control_Goto($URL->getCommandString());
    }
    if (in_array($URL[4], $grids))
    {
        $grid_type_name = $URL[4];
        $grid_type_code = $grids[$grid_type_name][0];
        $grid_type_name_crumb = $grids[$grid_type_name][1];
    }
    else 
    {
        $grid_type_name = 'room';
        $grid_type_code = 1;
        $grid_type_name_crumb = $grids['room'][1];
    }
    
    if (!$data['grid_' . $grid_type_name])
    {
        throw new Dune_Exception_Control_Goto($URL->getCommandString());
    }
   
    $module = new Module_Sub_View_SetAddInfoForHousePage();
    $module->data = $data;
    $module->view = $view;
    $module->make();
    

    $crumbs = Dune_Display_BreadCrumb::getInstance('1');
    
    $crumbs->addCrumb($grid_type_name_crumb, $URL->getCommandString());
    
    Dune_Variables::addTitle($grid_type_name_crumb . ':: ' . $data['name'] . ' :: ');
    
//  Выборка массива подъездов - BEGIN

    $_o = new Special_Vtor_Sub_List_Porch($data['id']);
    $porchs = $_o->getDatas();

    $_o = new Special_Vtor_Sub_List_ObjectsInHouse($data, $grid_type_code);
    $objects = $_o->getDataForGrid();
    unset($_o);
    
    
    $module = new Module_Sub_View_GenerateArrayFotGrid();
    $module->porchs = $porchs;
    $module->objects = $objects;
    $module->make();
    
//  echo $module->getOutput();  
    
    $view->porchs = $porchs;
    $view->grid   = $module->getResult('data');
    
//  Выборка массива подъездов - END
    
    
    
    $view->crumbs = $crumbs->getString();
    
    $view->data = $data;
    $view->pd = $data['pd'];
    $view->info_center =  $view->render('bit/house/grid');
    
    $view->info_right =  $view->render('bit/house/add_info');
    
    echo $view->render('page/one/default_3_col');
    
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