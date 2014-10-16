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
$post->htmlSpecialChars();
$post->trim();

$folder = Dune_Data_Collector_UrlSingleton::getInstance();
if ($post->_do_ == 'recall')
{
    $cooc['mail_temp'] = $post->mail;
    //$object = new Dune_Include_Module('system:auth.recall.password');
    $object = new System_Auth_RecallPassword();
    $object->check_captcha = true;
    $object->mail      = $post->mail;
    $object->captcha   = $post->captcha;
    $object->make();
echo $object->getOutput();
    if ($object->getResult('success'))
    {
        $view = Dune_Zend_View::getInstance();
        $view->mail = $object->getResult('mail');
        $view->code = $object->getResult('code');
        $view->password = $object->getResult('password');
        $view->name = $object->getResult('name');
        $view->domain = Dune_Parameters::$siteDomain;
        
        
/*        $zend_mail = new Zend_Mail('windows-1251');            
        $zend_mail->setBodyHtml($view->render('mail/auth/recall_password'));
        $zend_mail->setFrom(Dune_Parameters::$adminMail, Dune_Parameters::$siteDomain);
        $zend_mail->addTo($object->getResult('mail'), 'Пользователь ' . $object->getResult('name'));
        $zend_mail->setSubject('Напоминание пароля для входа на сайт: ' . Dune_Parameters::$siteDomain);
        $zend_mail->send();
*/        
        
        $mail = new Module_Mail();
        $mail->body = $view->render('mail/auth/recall_password');
        $mail->mail = $object->getResult('mail');
        $mail->name = 'Пользователь ' . $object->getResult('name');
        $mail->subject = 'Напоминание пароля для входа на сайт: ' . Dune_Parameters::$siteDomain;
        $mail->make();

        $this->status = Dune_Include_Command::STATUS_GOTO; // В будущем - отправить на страницу до входа на страницу входа
        $this->results['goto'] = '/user/enter/';
        echo '/user/enter/';
        
        unset($cooc['mail_temp']);

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
    
    $captcha = new Dune_Zend_Captcha_Image();
    $captcha->setWordlen(4);
    $captcha->generate();
    $view->assign('captcha', $captcha->getImageLink());
    $session = Dune_Session::getInstance();
    $session->captcha = $captcha->getWord();
    
    $view->assign('mail' , $cooc['mail_temp']);
    $view->assign('action', $folder->get());
    $view->assign('message', Dune_Static_Message::$text);
    echo $view->render('page:user:auth_form_to_recall_password');
    
    // Запрет отображения панели пользователя
    $this->results['no_user_panel'] = true;
}
?>