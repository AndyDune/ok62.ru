<?php
 
// Команда публичных форм для отсылки сообщений

    $URL = Dune_Parsing_UrlSingleton::getInstance();
    $cooc = Dune_Cookie_ArraySingleton::getInstance(Dune_Parameters::$cookieNameSystem);
    $folder_postfix = '';
    Dune_Static_StylesList::add('catalogue/info_one');
    Dune_Static_StylesList::add('elements');
    
    if (Dune_Session::$auth)
    {
        
            // Генерация кода отображения меню типа ещё что редактируем
        $session = Dune_Session::getInstance(Dune_Session::ZONE_AUTH);
        $user = new Dune_Auth_Mysqli_UserActive($session->user_id);
        $view = Dune_Zend_View::getInstance();
        $edit_menu = new Module_Display_User_MoreEditMenu();
        if ($URL[3] == 'info')
            $edit_menu->code = 'request_info';
        else 
            $edit_menu->code = 'request';
        $edit_menu->user = $user;
        $edit_menu->make();
        $view->more_edit_menu = $edit_menu->getOutput();
        // Проверка на 
        
/*        $status = Special_Vtor_Object_Query_StatusContainerForAuthUser::getInstance(Special_Vtor_User_Auth::$id);
        $object = $status->getNotFinished();
        if ($object)
        {
            $curent_command = $object->getTypeCodeName();
            $this->status = Dune_Include_Command::STATUS_GOTO;
            if ($URL[3] != $object->getTypeCodeName())
            {
                $URL[3] = $object->getTypeCodeName();
                $this->results['goto'] = $URL->getCommandString();
                return;
            }
        }
*/
    }
    else 
    {
//        $cooc = Dune_Cookie_ArraySingleton::getInstance(Dune_Parameters::$cookieNameSystem);
//        echo '<br /><br /><br /><br /><br /><br /><br />' , $cooc;
            
        if ($URL[3] != 'list')
            $folder_postfix = '_no_auth';
    }
try
{
    Dune_Static_StylesList::add('public/request');

    $folder_name = new Dune_Data_Container_Folder($URL[3] . $folder_postfix);
    $folder_name->setPath(dirname(__FILE__))
                ->registerDefault('edit' . $folder_postfix)
//              ->register('main' . $folder_postfix)
                ->register('edit' . $folder_postfix) 
                ->register('info' . $folder_postfix)
                ->register('list');
//    $folder_name->register('do' . $folder_postfix);
    
    
    $folder_name->check();
    
    $folder = Dune_Data_Collector_UrlSingleton::getInstance();
    $folder->addFolder($folder_name->getFolder());
    
    $folder = new Dune_Include_Folder($folder_name, Dune_Variables::$userStatus);
    
    $this->setStatus($folder->getStatus());
    $this->setResult($folder->getResults());
    echo $folder->getOutput();
}
catch (Dune_Exception_Control_Goto $e)
{
    if ($e->getCode() > 50)
    {
        unset($cooc['edit']);
        unset($cooc['edit_type']);
        unset($cooc['edit_type_code']);

        $session = Dune_Session::getInstance('control');
        unset($session->edit);
        $this->setResult('goto', '/public/request/');
        
        Dune_Static_Message::setCode($e->getCode());
    }
    else 
    {
        $this->setResult('goto', $e->getMessage());
    }
    $this->setStatus(Dune_Include_Command::STATUS_GOTO);
}
catch (Dune_Exception_Control $e)
{
    if ($e->getCode())
    {
        Dune_Static_Message::setCode($e->getCode());
        
        $this->setStatus(Dune_Include_Command::STATUS_EXIT);
    }
    else 
        $this->setStatus(Dune_Include_Command::STATUS_EXIT);
}