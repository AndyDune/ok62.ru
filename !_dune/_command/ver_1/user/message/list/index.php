<?php



// Модуль, отдающий поле аутентифокации если пользовательне опознан
// Либо поле информации о пользователе.

$per_page = 20;


if (Dune_Session::$auth)
{
    
   $view = Dune_Zend_View::getInstance();
   $session = Dune_Session::getInstance(Dune_Session::ZONE_AUTH);
    $user = new Dune_Auth_Mysqli_UserActive($session->user_id);
   $URL = Dune_Parsing_UrlSingleton::getInstance();
    
            // Генерация кода отображения меню типа ещё что редактируем
        $edit_menu = new Module_Display_User_MoreEditMenu();
        $edit_menu->user = $user;
        $edit_menu->code = $URL->getCommand(2, 'message');
        $edit_menu->make();
        
        $view->more_edit_menu = $edit_menu->getOutput();
        $view->code = $URL->getCommand(2, 'info');
    
   
   
   $list = new Special_Vtor_PrivateTalk_List();
   $count = $list->getCountAll($session->user_id);

    $current_page = (int)$URL->getCommand(4, 0);   
if ($count > $per_page)
{
    $URL->cutCommands(3);
    $URL->setCommand('page', 3);
    $navigator = new Dune_Navigate_Page($URL->getCommandString(), $count, $current_page, $per_page);
    $view->navigator = $navigator->getNavigator();
}
   
   
   $result_list = $list->getListCumulateAll($session->user_id, $current_page * $per_page, $per_page);
   $array_run = array();
   foreach ($result_list as $key => $value)
   {
       $array_run[$key] = $value;
       $photo = new Special_Vtor_User_Image_Photo($value['user_id'], $value['user_time']);
       if (count($photo))
       {
           $t = $photo->getOneImage();
           $array_run[$key]['photo_preview'] = $t->getPreviewFileUrl(50);
        }
    }
    $view->list = $array_run;
   
    Dune_Static_StylesList::add('user/info/list');
     Dune_Static_StylesList::add('talk/base');
     $view->code = 'all';
     $view->bookmark = $view->render('bit/user/bookmark/messages');
     $view->text = $view->render('bit/user/contact/messages_all');
     echo $view->render('bit/general/container_padding_for_auth_extend');



}
