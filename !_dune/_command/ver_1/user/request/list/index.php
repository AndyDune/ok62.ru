<?php
    $URL = Dune_Parsing_UrlSingleton::getInstance();
    $session = Dune_Session::getInstance(Dune_Session::ZONE_AUTH);
    $user = new Dune_Auth_Mysqli_UserActive($session->user_id);

    $view = Dune_Zend_View::getInstance();
    
    $edit_menu = new Module_Display_User_MoreEditMenu();
    $edit_menu->code = 'request_info';
    $edit_menu->user = $user;
    $edit_menu->make();
    $view->more_edit_menu = $edit_menu->getOutput();
    
    $current = Special_Vtor_Object_Request_DataSingleton::getInstance();
    $current->setUserId(Special_Vtor_User_Auth::$id);
    
    $view->list = $current->getList();
    $view->type_code = Special_Vtor_Settings::$typeCodeToString;
    
    $view->types = Special_Vtor_Types::$typesToRequest;
    $view->text = $view->render('bit/request/edit/list');

    $view->h1 = 'Мои заявки';
    Dune_Variables::addTitle('Мои заявки. ');
    echo $view->render('bit/general/container_padding_for_auth_extend');


