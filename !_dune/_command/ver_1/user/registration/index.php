<?php
// Модуль, страницы регистрации
// Либо поле информации о пользователе.

$view = Dune_Zend_View::getInstance();
Dune_Static_StylesList::add('user/auth');

if (Dune_Session::$auth)
{
   echo $view->render('page:user:auth_done');
   return;
}
$cooc = Dune_Cookie_ArraySingleton::getInstance(Dune_Parameters::$cookieNameSystem);    
$post = Dune_Filter_Post_Total::getInstance();
$post->setLength(50);
//$post->htmlSpecialChars();
$post->trim();

$folder = Dune_Data_Collector_UrlSingleton::getInstance();
if ($post->_do_ == 'register')
{
    $object = new Module_System_RegistrationAndMail();
    $object->make();
//echo $object->getOutput();
    if ($object->getResult('success'))
    {
        unset($cooc['mail_temp']);
        unset($cooc['login']);
        $this->status = Dune_Include_Command::STATUS_GOTO; // В будущем - отправить на страницу до входа на страницу входа
        $this->results['goto'] = '/user/checkmail/';
        echo '/user/checkmail/';
    }
    else 
    {
        //$post->htmlSpecialChars(false);
        $cooc['mail_temp'] = $post->mail;
        $cooc['login'] = $post->login;
        $this->status = Dune_Include_Command::STATUS_GOTO;
        $this->results['goto'] = $folder->get();
        echo $folder;
    }
    return;
}
else 
{
    Dune_Static_Header::noCache();
    
    $captcha = new Dune_Zend_Captcha_Image();
    $captcha->setWordlen(4);
    $captcha->generate();
    $view->assign('captcha', $captcha->getImageLink());
    $session = Dune_Session::getInstance();
    $session->captcha = $captcha->getWord();
    
    $view->assign('login', $cooc['login']);
    $view->assign('mail' , $cooc['mail_temp']);
    $view->assign('action', $folder->get());
    $view->assign('message', Dune_Static_Message::$text);
    echo $view->render('page:user:auth_form_to_registration');
    
    // Запрет отображения панели пользователя
    $this->results['no_user_panel'] = true;
}
?>