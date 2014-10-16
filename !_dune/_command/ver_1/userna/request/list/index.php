<?php
    if (Dune_Session::$auth)
    {
        $this->setStatus(Dune_Include_Command::STATUS_GOTO);
        $this->setResult('goto', '/user/request/');
    }
    $URL = Dune_Parsing_UrlSingleton::getInstance();
    $session = Dune_Session::getInstance(Dune_Session::ZONE_AUTH);

    $view = Dune_Zend_View::getInstance();
    
    $current = Special_Vtor_Object_Request_NoAuth_DataSingleton::getInstance();
    
    $cooc = Dune_Cookie_ArraySingleton::getInstance(Dune_Parameters::$cookieNameSystem);    
    
    if (strlen($cooc[Special_Vtor_Settings::NO_AUTH_USER_CODE_KEY]) > 20)
    {
        $current->setUserCode($cooc[Special_Vtor_Settings::NO_AUTH_USER_CODE_KEY]);
        $view->list = $current->getList();
    }
    else 
        $view->list = array();
    $view->type_code = Special_Vtor_Settings::$typeCodeToString;
    
    $view->types = Special_Vtor_Types::$typesToRequest;
    $view->text = $view->render('bit/request/edit/list');

    $view->h1 = 'Мои заявки';
    Dune_Variables::addTitle('Мои заявки. ');
    echo $view->render('bit/general/container_padding_for_auth_extend');


