<?php
$URL = Dune_Parsing_UrlSingleton::getInstance();
try
{

    if (!Dune_Session::$auth) // Пользователь не может смотреть информацию о продавцах
    {
        throw new Dune_Exception_Control('Необходимо зарегистрироваться', 1);
    }
    $session = Dune_Session::getInstance(Dune_Session::ZONE_AUTH);
    $get = Dune_Filter_Post_Total::getInstance();
       
    $session = Dune_Session::getInstance(Dune_Session::ZONE_AUTH);
    $user = new Dune_Auth_Mysqli_UserActive($session->user_id);
    if (!$user->getUserId())
    {
         throw new Dune_Exception_Control('Ошибка. Недостаток данных в сессии. ID пользователя.', 2);
    }

    //echo $user;
    $view = Dune_Zend_View::getInstance();
    //$view->view_folder = Dune_Variables::$pathToViewFolder;
    
    Dune_Static_StylesList::add('user/info/base');
    
    $session->closeZone();        
    
    $view->user = $user;   
    $view->assign('message', Dune_Static_Message::$text);  

    // Генерация кода отображения меню типа ещё что редактируем
    $edit_menu = new Module_Display_User_MoreEditMenu();
    $edit_menu->current = 'basket';
    $edit_menu->user = $user;
    $edit_menu->make();
    $view->more_edit_menu = $edit_menu->getOutput();
        
        
    
    
    //  Формирование списка доступных в данных условиях объектов
    //$data = new Dune_Include_Module('display/catalogue/object/list.in.adress');
    
    $data = new Module_Display_User_ObjectsInBusket();
    $data->perPage = 10;
    $data->user = $user;
    $data->make();    
    Dune_Static_StylesList::add('catalogue/base');
    Dune_Static_StylesList::add('catalogue/info');
    $view->data = $data->getOutput();
    
    
    echo $view->render('page/user/activity/basket');

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
                                     'section' => 'user.edit_basket'
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