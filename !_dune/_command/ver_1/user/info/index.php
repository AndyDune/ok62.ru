<?php

$get = Dune_Filter_Get_Total::getInstance();
if ($get['show'] == 'all')
{
    $session = Dune_Session::getInstance('user_page');
    $session->show_all = true;
    $this->setStatus(Dune_Include_Command::STATUS_EXIT);
    return;
}
else if ($get['show'] == 'noall')
{
    $session = Dune_Session::getInstance('user_page');
    $session->show_all = true;
    $this->setStatus(Dune_Include_Command::STATUS_EXIT);
    return;
}

$URL = Dune_Parsing_UrlSingleton::getInstance();

//    if (!Dune_Session::$auth) // Пользователь не может смотреть информацию о продавцах
//    {
//        throw new Dune_Exception_Control_NoAccess('page/user/info/can_not_look_info', 1);
//    }    
    $user = false;
    if ($URL[3] > 0) // Передан id пользователя
    {
        $user = new Dune_Auth_Mysqli_UserActive($URL[3]);
    }
    
    
    $session = Dune_Session::getInstance(Dune_Session::ZONE_AUTH);
    if (!$user or !$user->getUserId())    
    {
        if (!Dune_Session::$auth) // Пользователь не может смотреть информацию о продавцах
        {
            //throw new Dune_Exception_Control('Необходимо зарегистрироваться', 1);
            throw new Dune_Exception_Control_NoAccess('page/user/info/can_not_look_info', 1);
        }    
        
        $user = new Dune_Auth_Mysqli_UserActive($session->user_id);
        if (!$user->getUserId())
        {
            //throw new Dune_Exception_Control('Ошибка', 2);
            throw new Dune_Exception_Control_NoAccess('page/user/info/can_not_look_info_error', 2);
        }
    }
    //echo $user;
    $view = Dune_Zend_View::getInstance();
    //$view->view_folder = Dune_Variables::$pathToViewFolder;
    
    $timeUser = Dune_Auth_Mysqli_UserTime::getInstance($user->getUserId());
    $timeInterval = new Dune_Time_IntervalParse($timeUser->getTimeLastVisit(), time());
    
    $view->time_inteval = $timeInterval->getResultArray();
    
    $view->time_last_visit = $view->render('bit/elements/time_last_visit');
    
    $view->user = $user;
    Dune_Static_StylesList::add('user/info/base');
    Dune_Static_JavaScriptsList::add('thickbox');
    Dune_Static_StylesList::add('thickbox');
    
    $allow_array = $user->getUserArrayConfig(true);
    $view->user_info_allow = new Dune_Array_Container($allow_array->info_access);
    
    $photo = new Special_Vtor_User_Image_Photo($user->getUserId(), $user->time);
    $array_photo = array();
    if (count($photo))
    {
        foreach ($photo as $key => $value)
        {
            $array_photo[0]  = $value->getSourseFileName();
            $array_photo[1]  = $value->getSourseFileUrl();
            $array_photo[2]  = $value->getPreviewFileUrl();
        }
    }
    
    $view->array_photo = $array_photo;
    
    $session = Dune_Session::getInstance(Dune_Session::ZONE_AUTH);
    if ($session->user_id == $user->getUserId())
    {
        // Смотрим свою информацию
        ////////////////////////////////////////////////////
        ///     Сбор информации о собственной активности
           
        ///
        ///////////////////////////////////////////////////
        
            // Генерация кода отображения меню типа ещё что редактируем
        $edit_menu = new Module_Display_User_MoreEditMenu();
        $edit_menu->user = $user;
        $edit_menu->code = $URL->getCommand(2, 'info');
        $edit_menu->make();
        
        $view->more_edit_menu = $edit_menu->getOutput();
        $view->code = $URL->getCommand(2, 'info');
        $view->bookmark = $view->render('bit/user/bookmark/info');
        $view->text = $view->render('page/user/info/look_my');
        echo $view->render('bit/general/container_padding_for_user_panel');
        
    }
    else 
    {
        // Смотрим вражескую информацию
//        echo $view->render('page/user/info/look_not_my');
        
        $session = Dune_Session::getInstance(Dune_Session::ZONE_AUTH);
        $user_i = false;
        if (isset($session->user_id))   
        {   
            $edit_menu = new Module_Display_User_MoreEditMenu();
            $user_i = new Dune_Auth_Mysqli_UserActive($session->user_id);
            $edit_menu->user = $user_i;
            $edit_menu->code = 'contact';
            $edit_menu->make();
            $view->more_edit_menu = $edit_menu->getOutput();
        }
        
        
    $current = Special_Vtor_Object_Request_DataSingleton::getInstance();
//    $current->setUserId(Special_Vtor_User_Auth::$id);
    
//    if (Special_Vtor_User_Auth::$id)
//    {
        $current->setUserId($user->getUserId());
        $list = $current->getList();
        if (count($list))
        {
            $view->list = $list;
            $view->types = Special_Vtor_Types::$typesToRequest;
            $view->request = $view->render('bit/request/public/list_only');
            Dune_Static_StylesList::add('public/request');
        }
//    }
        
    
    if (Dune_Session::$auth) // Пользователь не может смотреть информацию о продавцах    
    {
        $session = Dune_Session::getInstance('contact');
        $session->user_id = $user->getUserId();
        
        $view->code = $URL[2];
        $view->one_user = true;
        $view->h1_code = '/user/info/';
        $session = Dune_Session::getInstance('contact');
         if ($session->link_to_topic_of_user != $session->user_id)
            $session->link_to_topic = false;
        $view->link_to_topic = $session->link_to_topic;
        
        $view->bookmark = $view->render('bit/user/bookmark/contact');
//        $view->text = $view->render('page/user/info/look_not_my');
        
        $module = new Module_User_Contact_TopicList();
        $module->user = $user_i;
        $module->interlocutor = $user;
        $module->no_one = true;
        $URL->setCommand('contact', 2);
        $URL->setCommand('user_' . $user->getUserId(), 3);
        $module->url = $URL->getCommandString();
        $module->make();
        
        $text = $module->getResult('text');
        $view->no_auth = false;
    }
    else
    {
        $text = '';
        $view->no_auth = true;
    }
        
        $view->text = $view->render('page/user/info/look_not_my') . $text;
        
        $view->h1_code = '/user/info/';            
        
        echo $view->render('bit/general/container_padding_for_auth_extend');
        
    }
