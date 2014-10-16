<?php

class Module_System_RegistrationAndMail extends Dune_Include_Abstract_Code
{

    protected function code()
    {
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        

    $post = Dune_Filter_Post_Total::getInstance();

    //$object = new Dune_Include_Module('system:auth.registration');
    $object = new System_Auth_Registration;
    $object->check_captcha = true;
    $object->login     = $post->login;
    $object->mail      = $post->mail;
    $post->htmlSpecialChars();
    $object->captcha   = $post->captcha;
    $object->make();
//echo $object->getOutput();
    if ($object->getResult('success'))
    {
        $view = Dune_Zend_View::getInstance();
        $view->mail = $object->getResult('mail');
        $view->code = $object->getResult('code');
        $view->name = $object->getResult('name');
        $view->domain = Dune_Parameters::$siteDomain;
        
/*        $zend_mail = new Zend_Mail('windows-1251');            
        $zend_mail->setBodyHtml($view->render('mail/auth/check_mail'));
        $zend_mail->setFrom(Dune_Parameters::$adminMail, Dune_Parameters::$siteDomain);
        
        //$zend_mail->addBcc(Dune_Parameters::$adminMail);
        //$zend_mail->addCc(Dune_Parameters::$adminMail);
        
        $zend_mail->addTo($object->getResult('mail'), 'Новый пользователь ' . $object->login);
        $zend_mail->setSubject('Регистрация на сайте: ' . Dune_Parameters::$siteDomain . '.  Проверка адреса электронной почты.');
        $zend_mail->send();
*/

        $mail = new Module_Mail();
        $mail->body = $view->render('mail/auth/check_mail');
        $mail->mail = $object->getResult('mail');
        $mail->name = 'Новый пользователь ' . $object->login;
        $mail->subject = 'Регистрация на сайте: ' . Dune_Parameters::$siteDomain . '.  Проверка адреса электронной почты.';
        $mail->make();
        
        $this->results['success'] = true;
        
        return true;
    }
    else 
    {
        $this->results['success'] = false;
        return false;
    }


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
    }
    
}
    
    