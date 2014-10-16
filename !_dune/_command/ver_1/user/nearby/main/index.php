<?php
$URL = Dune_Parsing_UrlSingleton::getInstance();

$per_page = 50;

    if (!Dune_Session::$auth) // Пользователь не может смотреть информацию о продавцах
    {
        //throw new Dune_Exception_Control('Необходимо зарегистрироваться', 1);
        throw new Dune_Exception_Control_NoAccess('page/user/info/can_not_look_info', 1);
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
    $session = Dune_Session::getInstance('users-list');
    if ($URL->getCommandPart(3,1) == 'order')
    {
        $session->order = $order = $URL->getCommandPart(3,2);
    }
    else 
    {
        if ($order = $session->order)
        {
            $URL[3] = 'order_' . $order;
        }
    }
    $get = Dune_Filter_Get_Total::getInstance();
    $current_page = $get->getDigit('page');
    
    $view->order = $order;
    
    $module = new Module_Catalogue_Nearby_Groups_List();
    $module->user = $user;
    $module->mode = 'all';
    $module->page = $current_page;
    $module->per_page = $per_page;
    $module->order = $order;
    $module->make();
    $view->list = $module->getResult('list');
    
    $count = $module->getResult('count');

    if ($count > $per_page)
    {
        $navigator = new Dune_Navigate_Page($URL->getCommandString() . '?page=', $count, $current_page, $per_page);
        $view->navigator = $navigator->getNavigator();
    }
    
//    $view->list_contact_begin = $module->getResult('list_contact_begin');

//////////////////////////////////////////////////////////      
           
     $session = Dune_Session::getInstance('contact');
     if (isset($session->user_id))
     {
         $user_look = new Dune_Auth_Mysqli_UserActive($session->user_id);
         if (!$user_look->getUserId())
         {
             $session->killZone();
         }     
         else 
         {
            $view->user = $user_look;
            $view->one_user = true;
         }
     }
     $view->user_id = $user->getUserId();
     $view->code = 'list';
     $view->h1_code = '/user/nearby/';
     $session = Dune_Session::getInstance('nearby');
     if ($session->link_to != $session->group_id)
        $session->link_to = false;
     
     $view->link_to = $session->link_to;

//     $view->bookmark = $view->render('bit/user/bookmark/contact');
    
     $view->crumbs_array = array(array('name' => 'Список наблюдаемых объектов', 'link' => '/user/nearby/'));
     $view->text = $view->render('page/user/nearby/all');
     echo $view->render('bit/general/container_padding_for_auth_extend');

     
     
     Dune_Static_StylesList::add('user/info/list');
