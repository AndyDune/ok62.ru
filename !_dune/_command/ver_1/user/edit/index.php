<?php
$URL = Dune_Parsing_UrlSingleton::getInstance();
try
{

    if (!Dune_Session::$auth) // Пользователь не может смотреть информацию о продавцах
    {
        throw new Dune_Exception_Control('Необходимо зарегистрироваться', 1);
    }
    $session = Dune_Session::getInstance(Dune_Session::ZONE_AUTH);
    $get = Dune_Filter_Get_Total::getInstance();
    if (isset($get['delete']))
    {
        $user = new Dune_Auth_Mysqli_UserActive($session->user_id);
        $photo = new Special_Vtor_User_Image_Photo($user->getUserId(), $user->time, true);    
        @unlink($photo->getSystemUrl() . '/' . $get['name']);
        $photo->deletePreviewFolder();
        
        throw new Dune_Exception_Control('Сохранили - вышли', 100);
    }    
    
    
    $post = Dune_Filter_Post_Total::getInstance();
    $post->trim()
         ->htmlSpecialChars()
         ->setLength(4000);
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

        $allows = new Dune_Form_Handle_CheckBox($post);
        $allows->assign('mail_on_message', 0, 1);
        $user->setUserArrayConfigCell('settings', $allows->getResults());
        
        $about_me = $post->about_me;
        
        $trans = new Dune_String_Transform($about_me);
        $trans->deleteLineFeed(2);
        $trans->correctOmissionPoints();
        $trans->setQuoteRussian();
        $about_me = $trans->getResult();
        
        $user->setUserArrayCell('about_me', $about_me);
        $user->loadData($post);
        $user->updateData();
        
        
        
        $session = Dune_Session::getInstance(Dune_Session::ZONE_AUTH);
//        $user = new Dune_Auth_Mysqli_UserActive($session->user_id);
        $photo = new Special_Vtor_User_Image_Photo($user->getUserId(), $user->time, true);    
        
        $module = new Module_File_Picture_Save_PostList();
        $module->name = 'photo';
        $module->size = 900;
        $module->folder = $photo->getSystemUrl();
        $module->max_files_count = 1;
        $module->make();
                
        $photo->deletePreviewFolder();
        
        
        
        throw new Dune_Exception_Control('Сохранили - вышли', 100);
    }
    if ($post['_do_'] == 'save_image')
    {
        $session = Dune_Session::getInstance(Dune_Session::ZONE_AUTH);
        $user = new Dune_Auth_Mysqli_UserActive($session->user_id);
        $photo = new Special_Vtor_User_Image_Photo($user->getUserId(), $user->time, true);    
        
        $module = new Module_File_Picture_Save_PostList();
        $module->name = 'photo';
        $module->size = 900;
        $module->folder = $photo->getSystemUrl();
        $module->max_files_count = 1;
        $module->make();
                
        $photo->deletePreviewFolder();
                
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
    Dune_Static_JavaScriptsList::add('thickbox');
    Dune_Static_StylesList::add('thickbox');
    
    $session = Dune_Session::getInstance(Dune_Session::ZONE_AUTH);    
    if ($session->user_id == $user->getUserId())
    {
        $value = $user->getUserArrayConfigCell('info_access');
        $view->user_info_allow = new Dune_Array_Container($value);

        $value = $user->getUserArrayConfigCell('settings');
        $view->user_settings = new Dune_Array_Container($value);
        
        
        $edit_menu = new Module_Display_User_MoreEditMenu();
        $edit_menu->code = 'edit';
        $edit_menu->user = $user;
        $edit_menu->make();
        
        $view->more_edit_menu = $edit_menu->getOutput();
        
        
        
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
    
    $view    = Dune_Zend_View::getInstance();

    $view->array_photo = $array_photo;
        
        
        
        $view->code = $URL[2];
        $view->bookmark = $view->render('bit/user/bookmark/info');
        $view->text = $view->render('page/user/info/edit');
        echo $view->render('bit/general/container_padding_for_user_panel');
        
//        echo $view->render('page/user/info/edit');
    }
    else 
    {
        // Смотрим вражескую информацию
        Dune_Static_StylesList::add('user/info/message');        
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