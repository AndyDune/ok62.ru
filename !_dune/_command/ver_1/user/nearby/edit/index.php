<?php
$URL = Dune_Parsing_UrlSingleton::getInstance();

$page_per = $per_page = 50;

    if (!Dune_Session::$auth) // Пользователь не может смотреть информацию о продавцах
    {
        //throw new Dune_Exception_Control('Необходимо зарегистрироваться', 1);
        throw new Dune_Exception_Control_NoAccess('page/user/info/can_not_look_info', 1);
    }    

$group_current = (int)$URL->getCommandPart(4, 1);    
    
    $post = Dune_Filter_Post_Total::getInstance();
    $post->htmlSpecialChars();
    if ($post['do'] == 'save')
    {
        if ($post->getDigit('edit') > 0)
        {
            $group = new Special_Vtor_Nearby_Group($post->getDigit('edit'));
            if (!$group->check())
            {
                throw new Dune_Exception_Control_Goto('/user/nearby/');
            }
        }
        else 
        {
            $group = new Special_Vtor_Nearby_Group();
        }
        $group->setText($post['text']);
        $group->setName($post['name']);
        $group->setOrder($post['order']);
        if (!$group->save())
            throw new Dune_Exception_Control_Goto('/user/nearby/');
        $group_current = $group->getId();
        if ($post['streets'] and strlen($post['streets'] > 0))
        {
            $streets_object = new Special_Vtor_Nearby_List_Streets($group_current);
            $streets_array = new Dune_String_Explode($post['streets'], ' ');
            if (count($streets_array))
            {
                foreach ($streets_array as $value)
                {
                    if ((int)$value)
                        $streets_object->addStreet((int)$value);
                 }
            }
        }
        
        
        $photo = new Special_Vtor_Nearby_PhotoGroup($group_current, '', true);    
        
        $module = new Module_File_Picture_Save_PostList();
        $module->name = 'photo';
        $module->size = 900;
        $module->folder = $photo->getSystemUrl();
        $module->max_files_count = 1;
        $module->make();

        $photo->deletePreviewFolder();
        
        throw new Dune_Exception_Control_Goto('/user/nearby/edit/' . $group_current . '/');
    }
    
    
    $get = Dune_Filter_Get_Total::getInstance();
    
    if (isset($get['delete_photo']))
    {
        $photo = new Special_Vtor_Nearby_PhotoGroup($group_current, '', true);
        @unlink($photo->getSystemUrl() . '/' . $get['name']);
        $photo->deletePreviewFolder();
        
        throw new Dune_Exception_Control_Goto('/user/nearby/edit/' . $group_current . '/');
    }    
    
    
    if ($get['do'] == 'delete_street')
    {
        if ($group_current and $get->getDigit('id') > 0)
        {
            $streets_object = new Special_Vtor_Nearby_List_Streets($group_current);
            $streets_object->deleteStreet($get->getDigit('id'));
        }
        throw new Dune_Exception_Control_Goto();    
    }
    if ($get['do'] == 'delete_group')
    {
        if ($group_current and $get->getDigit('id') > 0)
        {
            $streets_object = new Special_Vtor_Nearby_List_Streets($group_current);
            $streets_object->delete();
            $group = new Special_Vtor_Nearby_Group($group_current);
            $group->delete();
        }
        throw new Dune_Exception_Control_Goto('/user/nearby/');    
    }

    
    $user = false;
    $session = Dune_Session::getInstance(Dune_Session::ZONE_AUTH);
    
    $view = Dune_Zend_View::getInstance();
    
    //$view->user = $user;
        
    
/////////////// ---     Меню слева
     $session = Dune_Session::getInstance(Dune_Session::ZONE_AUTH);
     $user = new Dune_Auth_Mysqli_UserActive($session->user_id);
     
     $edit_menu = new Module_Display_User_MoreEditMenu();
     $edit_menu->user = $user;
     $edit_menu->code = 'nearby';
     $edit_menu->make();
     $view->more_edit_menu = $edit_menu->getOutput();
/////////////// ---     /Меню слева




///////////////////////////////////////////////////////////
/// Создание массивов для отображения

     $group = new Special_Vtor_Nearby_Group($group_current);
     if (!$group->check())
     {
        $group_current = '';
     }

     
    $array_photo = array();
if ($group_current)
{
    $photo = new Special_Vtor_Nearby_PhotoGroup($group_current, '', true);    
    
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
}
    $view->array_photo = $array_photo;
     
    $streets_object = new Special_Vtor_Nearby_List_Streets($group_current);
    $streets_array = $streets_object->getList();
    $streets_ids = $streets_object->getIdArray();

    $view->street_array = $streets_array;
    $view->group_current = $group_current;
    
    $view->h1_code = 'nearby_group_edit';
    
    $group_data = $group->getData();
    
    $view->group = $group_data;
    
    $view->crumbs_array = array(
    array('name' => 'Список наблюдаемых объектов', 'link' => '/user/nearby/'),
    array('name' => 'Редактирование', 'link' => '#')
    );
    
    
    $text = $view->render('bit/catalogue/object/edit/nearby');
    
//    $view->text = $text;
//    echo $view->render('bit/general/container_padding_for_auth_extend');
     
     Dune_Static_StylesList::add('catalogue/list');
    

    $view->text = $text;
    echo $view->render('bit/general/container_padding_for_auth_extend');
     
    Dune_Static_StylesList::add('catalogue/list');
    