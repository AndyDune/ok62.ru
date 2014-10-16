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
    $edit_menu->code = 'sell';
    $edit_menu->user = $user;
    $edit_menu->make();
    
    
    //  Формирование списка доступных в данных условиях объектов
    
    $data = new Module_Display_User_ObjectsInSell();
    $data->show = $URL->getCommand(3, 'sell');
    $data->perPage = 10;
    $data->user = $user;
    $data->make();

    if ($data->getResult('exit'))
        throw new Dune_Exception_Base('', 100);
       
    Dune_Static_StylesList::add('catalogue/base');
    Dune_Static_StylesList::add('catalogue/info');
    
    $view->text = $data->getOutput();
    
    
    $view->more_edit_menu = $edit_menu->getOutput();
    $view->code = $URL->getCommand(3, 'sell');
    $view->bookmark = $view->render('bit/user/bookmark/sell_list');
     echo $view->render('bit/general/container_padding_for_user_panel_sell');
    
//    $view->text = $view->render('page/user/activity/sell');;
//    echo $view->render('page/user/info/total');
    
    Dune_Variables::addTitle('Выставленные на продажу. ');

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