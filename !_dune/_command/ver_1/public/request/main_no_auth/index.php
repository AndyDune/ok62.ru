<?php

   $URL = Dune_Parsing_UrlSingleton::getInstance();

    $view = Dune_Zend_View::getInstance();


    
    $view->text = $view->render('bit/request/go_to_auth');

    $view->h1_code = '/public/request/main/'; //'Заявка на размещение объекта в каталоге';
    echo $view->render('bit/general/container_padding_for_auth_extend');

