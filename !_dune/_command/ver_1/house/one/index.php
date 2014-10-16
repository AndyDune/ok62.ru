<?php
// Информация о доме

try {
    
    $URL = Dune_Parsing_UrlSingleton::getInstance();    
    
    $id = $this->id;

/*        $db = new Dune_Mysqli_Table(Special_Vtor_Tables::$houses);
        $db->useId($URL[3]);
        if (!($data = $db->getData(1)))
            throw new Dune_Exception_Control_Goto('/house/');
*/            
/////////////////////////////////////////////////////////////            
////////////    Отображение информации о доме
        
    $house = new Special_Vtor_Sub_Data_House($id);
    if (!($data = $house->getInfo(1)))
        throw new Dune_Exception_Control_Goto('/house/');
    
    if ($data['to_update'])
    {
        if ($data['count_room_total'])
        {
            $house->update(1);
        }
        if ($data['count_nolife_total'])
        {
            $house->update(4);
        }
        if ($data['count_pantry_total'])
        {
            $house->update(5);
        }
        $house->setUpdateDone();
    }
        
    $crumbs = Dune_Display_BreadCrumb::getInstance('1');        
    if ($data['group_name'])
    {
        $crumbs->addCrumb($data['group_name'], '/complex/' . $data['complex_id'] . '/');
    }
    
        
    if ($data['name'])
        $name = $data['name'];
    else 
        $name = 'Информация о доме';
        
    $URL->cutCommands(2);
    $crumbs->addCrumb($name, $URL->getCommandString());
    $URL->clearModifications();
         
    $folder_name = new Dune_Data_Container_Folder($URL->getCommand(3, 'info'));
    $folder_name->setPath(dirname(__FILE__));
    $folder_name->registerDefault('info');
    $folder_name->register('photo');
    $folder_name->register('panorama');
    $folder_name->register('situa');
    $folder_name->register('pd');
    $folder_name->register('grid');
    $folder_name->check();
    
    $folder_name->registerParameter('data', $data);
    
    $folder = new Dune_Include_Folder($folder_name, Dune_Variables::$userStatus);
    
    $this->status = $folder->getStatus();
    $this->results = $folder->getResults();
    echo $folder->getOutput();    
    
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