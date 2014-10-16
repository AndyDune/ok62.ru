<?php
$view = Dune_Zend_View::getInstance();
$view->auth = Dune_Session::$auth;
$view->user_status = Dune_Variables::$userStatus;
    $user_info = new Dune_Auth_Mysqli_UserActive($this->object->saler_id);
    //echo $user_info;
    $allow_array = $user_info->getUserArrayConfig(true);
    
    $view->user_info = $user_info;
    $view->view_folder = Dune_Variables::$pathToViewFolder;
    $view->user_info_allow = new Dune_Array_Container($allow_array->info_access);
    echo $view->render('bit/user/info/with_object_view_open');
