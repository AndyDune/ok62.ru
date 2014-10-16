<?php

class Module_Display_Catalogue_Object_PublicTalk_Form extends Dune_Include_Abstract_Code
{
    protected function code()
    {
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        

    $message_interval = Special_Vtor_Settings::$timeIntervalMessageToPublicTalk; 
    $view = Dune_Zend_View::getInstance();
    Dune_Static_StylesList::add('catalogue/info/form_pablic_talk');
    
try 
{
//    if (!Dune_Session::$auth)
//        throw new Dune_Exception_Control('ѕользователь не авторизован - не может оставл€ть сообщение.', 1);

    $cooc = Dune_Cookie_ArraySingleton::getInstance(Dune_Parameters::$cookieNameSystem);
    $view->object_id = $this->object->id;
    $view->text = $cooc['text'];
        
    if (Dune_Session::$auth)
    {

        $session = Dune_Session::getInstance(Dune_Session::ZONE_AUTH);        
        $user = $session->getZone();
        $time = Dune_Auth_Mysqli_UserTime::getInstance($user['user_id']);
        
    //    if ($time->getTime('pablic_talk_message') and $time->getTime('pablic_talk_message') > time() - $message_interval)
    //        throw new Dune_Exception_Control('—лишком часто.', 2);
            
        $session = Dune_Session::getInstance('talk');
        if ($session->text)
            $view->text = $session->text;
            
        $view->action = '/user/do/save-message-to-publictalk/';
        
        echo $view->render('bit/catalogue/object/talk/form_simple');
    }   
    else 
    {
/*   
        $captcha = new Dune_Zend_Captcha_Image();
        $captcha->setWordlen(3);
        $captcha->generate();
        $view->assign('captcha', $captcha->getImageLink());
        $session = Dune_Session::getInstance();
        $session->captcha = $captcha->getWord();
        $view->assign('message', Dune_Static_Message::$text);
        $view->mail = $cooc['mail'];
        $view->login = $cooc['login'];
        echo $view->render('bit/catalogue/object/talk/form_simple_no_auth');
*/        
        $view->action = '/user/do/save-message-to-publictalk-na/';        
        echo $view->render('bit/catalogue/object/talk/form_simple');
    }
}
catch (Dune_Exception_Control $e)
{
    switch ($e->getCode())
    {
        case 1:
            echo $view->render('bit/catalogue/object/talk/no_auth');
        break;
        case 2:
            echo $view->render('bit/catalogue/object/talk/no_time_left');
        break;
        
    }
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
    }
}
    
    