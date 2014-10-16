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
    $post->setLength(30);
    if ($post['_do_'] == 'save')
    {
        if ($post->id != $session->user_id)
            throw new Dune_Exception_Control('Редактируем не свою инфу', 3);

        $user = new Dune_Auth_Mysqli_UserActive($post->id);
        if (!$user->getUserId())
        {
            throw new Dune_Exception_Control('Ошибка', 2);
        }
        if ($post->id != $user->getUserId())
            throw new Dune_Exception_Control('Редактируем не свою инфу', 3);
            
        $session->closeZone();            
        $session->user_password = $post->password_old;
        
        if (strlen($post->password_old) < 8 or !$user->checkPassword($post->password_old))
            throw new Dune_Exception_Control('Старый пароль введен не корректно.', 4);
            
        if ($post->password_new_1 != $post->password_new_2)
            throw new Dune_Exception_Control('Новый пароль введенный в 2-х полях не совпадает.', 5);
            
        if (strlen($post->password_new_1) < 8 or strlen($post->password_new_1) > 30)
            throw new Dune_Exception_Control('Малая или большая длина нового пароля.', 6);
        
        $user->setPassword($post->password_new_1);
        $user->updatePassword();
        
        throw new Dune_Exception_Control('Сохранили - вышли', 100);
    }
       
    $user = false;
    if ($URL[3] > 0) // Передан id пользователя
    {
        $user = new Dune_Auth_Mysqli_UserActive($URL[3]);
    }
    if (!$user or !$user->getUserId())    
    {
        $session = Dune_Session::getInstance(Dune_Session::ZONE_AUTH);
        $user = new Dune_Auth_Mysqli_UserActive($session->user_id);
        if (!$user->getUserId())
        {
            throw new Dune_Exception_Control('Ошибка', 2);
        }
    }
    //echo $user;
    $view = Dune_Zend_View::getInstance();
    //$view->view_folder = Dune_Variables::$pathToViewFolder;
    
    Dune_Static_StylesList::add('user/info/base');
    
    if ($session->user_id == $user->getUserId())
    {
        $session->closeZone();        
        $view->user_password = $session->user_password;
        $view->user = $user;   
        $view->assign('message', Dune_Static_Message::$text);  

        // Генерация кода отображения меню типа ещё что редактируем
        $edit_menu = new Module_Display_User_MoreEditMenu();
        $edit_menu->current = 'changepassword';
        $edit_menu->user = $user;
        $edit_menu->make();
        
        $view->more_edit_menu = $edit_menu->getOutput();
        
        
        echo $view->render('page/user/info/edit_password');
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
    switch ($e->getCode())
    {
        case 4:
        case 5:
        case 6:
        case 100:
            $this->status = Dune_Include_Command::STATUS_EXIT;
            $cooc = Dune_Cookie_ArraySingleton::getInstance(Dune_Parameters::$cookieNameSystem);
            $cooc['message'] = array(
                                     'text'    => $e->getMessage(),
                                     'code'    => $e->getCode(),
                                     'section' => 'user.changepassword'
                                     );
            
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