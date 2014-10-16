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
$get = Dune_Filter_Get_Total::getInstance();
$mail = false;
if ($get->check('mail'))
{
    $mail = $get->mail;
    $code = $get->code;
}
else if ($post->check('mail'))
{
    $mail = $post->mail;
    $code = $post->code;
}

$folder = Dune_Data_Collector_UrlSingleton::getInstance();
if ($mail)
{
    //$object = new Dune_Include_Module('system:auth.checkmail');
    $object = new System_Auth_Checkmail();
    $object->code     = $code;
    $object->mail     = substr($mail, 0, 30);
    $object->make();
//echo $object->getOutput();
    if ($object->getResult('success'))
    {
        $view = Dune_Zend_View::getInstance();
        $view->mail = $object->getResult('mail');
        $view->code = $object->getResult('code');
        $view->name = $object->getResult('name');
        $view->password = $object->getResult('code');
        $view->domain = Dune_Parameters::$siteDomain;
        
        $zend_mail = new Zend_Mail('windows-1251');            
        $zend_mail->setBodyHtml($view->render('mail/auth/registration_success'));
        $zend_mail->setFrom(Dune_Parameters::$adminMail, Dune_Parameters::$siteDomain);
        $zend_mail->addTo($object->getResult('mail'), 'Успешная регистрация пользователя ' . $object->login);
        $zend_mail->setSubject('Регистрация на сайте: ' . Dune_Parameters::$siteDomain . '. Приглашение.');
        $zend_mail->send();

        $this->status = Dune_Include_Command::STATUS_GOTO; // В будущем - отправить на страницу до входа на страницу входа
        $cooc['new_user'] = 1;
        $this->results['goto'] = '/user/info/';
        echo '/user/info/';
        
    }
    else 
    {
        $this->status = Dune_Include_Command::STATUS_GOTO;
        $this->results['goto'] = $folder->get();
        echo $folder;
    }
    
    return;
}
else 
{
    Dune_Static_Header::noCache();
    
/*    $captcha = new Dune_Zend_Captcha_Image();
    $captcha->setWordlen(4);
    $captcha->generate();
    $view->assign('captcha', $captcha->getImageLink());
    $session = Dune_Session::getInstance();
    $session->captcha = $captcha->getWord();
*/    
    $view->assign('code', $cooc['user_code']);
    $view->assign('mail' , $cooc['user_mail']);
    $view->assign('action', $folder->get());
    $view->assign('message', Dune_Static_Message::$text);
    echo $view->render('page:user:auth_form_to_checkmail');
    
    // Запрет отображения панели пользователя
    $this->results['no_user_panel'] = true;
}
?>