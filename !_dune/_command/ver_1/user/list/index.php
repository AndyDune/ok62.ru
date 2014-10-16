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
    $user = new Dune_Auth_Mysqli_UserActive($session->user_id);
    if (!$user->getUserId())
    {
        //throw new Dune_Exception_Control('Ошибка', 2);
        throw new Dune_Exception_Control_NoAccess('page/user/info/can_not_look_info_error', 2);
    }
    //echo $user;
    $view = Dune_Zend_View::getInstance();
    
    
    $allow_array = $user->getUserArrayConfig(true);
    $view->user_info_allow = new Dune_Array_Container($allow_array->info_access);
        
     $session = Dune_Session::getInstance(Dune_Session::ZONE_AUTH);
     if (isset($session->user_id))   
     {   
            $edit_menu = new Module_Display_User_MoreEditMenu();
            $edit_menu->user = $user;
            $edit_menu->code = 'contact';
            $edit_menu->make();
            $view->more_edit_menu = $edit_menu->getOutput();
      }

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
    
    
    $module = new Module_User_List_Contact();
    $module->user_id = $user->getUserId();
    $module->mode = 'all';
    $module->page = $current_page;
    $module->per_page = $per_page;
    $module->order = $order;
    $module->make();
    $view->list = $module->getResult('list_contact');
    
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
     $view->h1_code = '/user/list/';
     $session = Dune_Session::getInstance('contact');
     if ($session->link_to_topic_of_user != $session->user_id)
        $session->link_to_topic = false;
     
     $view->link_to_topic = $session->link_to_topic;

     $view->bookmark = $view->render('bit/user/bookmark/contact');
     $view->text = $view->render('page/user/list/all');
     echo $view->render('bit/general/container_padding_for_auth_extend');
        
    Dune_Static_StylesList::add('user/info/list');