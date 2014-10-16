<?php
$URL = Dune_Parsing_UrlSingleton::getInstance();
try
{

    if (!Dune_Session::$auth) // Пользователь не может смотреть информацию о продавцах
    {
        throw new Dune_Exception_Control('Необходимо зарегистрироваться', 1);
    }
    $session = Dune_Session::getInstance(Dune_Session::ZONE_AUTH);
    $post = Dune_Filter_Post_Total::getInstance();
    $post->trim();
    if ($post['_do_'] == 'save')
    {
        if ($post['id'] != $session->user_id)
            throw new Dune_Exception_Control('Необходимо редактируем не свою инфу', 3);

        $user = new Dune_Auth_Mysqli_UserActive($post['id']);
        if (!$user->getUserId())
        {
            throw new Dune_Exception_Control('Ошибка', 2);
        }
        $allows = new Dune_Form_Handle_CheckBox($post);
        $allows->assign('contact_surname_allow', 0, 1);
        $allows->assign('mail_allow', 0, 1);
        $allows->assign('phone_allow', 0, 1);
        $allows->assign('icq_allow', 0, 1);
        $user->setUserArrayConfigCell('info_access', $allows->getResults());
        $user->loadData($post);
        $user->updateData();
        
        throw new Dune_Exception_Control('Сохранили - вышли', 100);
    }
       
    $user = false;
    if ($URL[3] > 0) // Передан id пользователя
    {
        $user = new Dune_Auth_Mysqli_UserActive($URL[3]);
    }
    if (!$user or !$user->getUserId())    
    {
        $user = new Dune_Auth_Mysqli_UserActive($session->user_id);
        if (!$user->getUserId())
        {
            throw new Dune_Exception_Control('Ошибка', 2);
        }
    }
    //echo $user;
    $view = Dune_Zend_View::getInstance();
    //$view->view_folder = Dune_Variables::$pathToViewFolder;
    
    $view->user = $user;
    Dune_Static_StylesList::add('user/info/base');
    if ($session->user_id == $user->getUserId())
    {
        $info_access = $user->getUserArrayConfigCell('info_access');
        $view->user_info_allow = new Dune_Array_Container($info_access);
        
        
        $edit_menu = new Module_Display_User_MoreEditMenu();
        $edit_menu->current = 'edit';
        $edit_menu->user = $user;
        $edit_menu->make();
        
        $view->more_edit_menu = $edit_menu->getOutput();
        // Смотрим свою информацию
        ////////////////////////////////////////////////////
        ///     Сбор информации о собственной активности
            
        ///
        ///////////////////////////////////////////////////
        echo $view->render('page/user/info/edit');
    }
    else 
    {
        // Смотрим вражескую информацию
        echo $view->render('page/user/info/edit_can_not');
    }

}
catch (Dune_Exception_Control $e)
{
    $view = Dune_Zend_View::getInstance();
    if ($e->getCode() == 100)
    {
        $this->status = Dune_Include_Command::STATUS_EXIT;
    }
    if ($e->getCode() == 1)
    {
        Dune_Static_StylesList::add('user/info/message');
        echo $view->render('page/user/info/can_not_look_info');
    }
    else if ($e->getCode() == 2)
    {
        Dune_Static_StylesList::add('user/info/message');
        echo $view->render('page/user/info/can_not_look_info_error');
    }   
    else if ($e->getCode() == 3)
    {
        Dune_Static_StylesList::add('user/info/message');
        echo $view->render('page/user/info/can_not_edit_info');
    }   
    
}