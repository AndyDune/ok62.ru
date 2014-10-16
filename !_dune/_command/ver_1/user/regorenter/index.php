<?php
// Модуль, отдающий поле аутентифокации если пользовательне опознан
// Либо поле информации о пользователе.

$view = Dune_Zend_View::getInstance();
Dune_Static_StylesList::add('user/auth');
Dune_Static_StylesList::add('user/auth_2_forms');
$cooc = Dune_Cookie_ArraySingleton::getInstance(Dune_Parameters::$cookieNameSystem);    

$folder = Dune_Data_Collector_UrlSingleton::getInstance();
$URL = Dune_Parsing_UrlSingleton::getInstance();
if (Dune_Session::$auth)
{
   echo $view->render('page:user:auth_done');
   return;
}

    Dune_Static_Header::noCache();
    $session = Dune_Session::getInstance();    
//    $view->message_code = $session->message_code;
    
    $captcha = new Dune_Zend_Captcha_Image();
    $captcha->setWordlen(4);
    $captcha->generate();
    
    $view->assign('captcha', $captcha->getImageLink());
    $session->captcha = $captcha->getWord();
    
    $view->assign('login', $cooc['login']);
    $view->assign('mail' , $cooc['mail_temp']);
    $view->assign('action', $folder->get());
    $view->assign('message', Dune_Static_Message::$text);
    
    
    $view->assign('login', $cooc['user_login']);
    echo $view->render('page:user:auth_form_to_enter_or_register');
    
    // Запрет отображения панели пользователя
//    $this->results['no_user_panel'] = true;
    $this->setResult('no_user_panel', true);
