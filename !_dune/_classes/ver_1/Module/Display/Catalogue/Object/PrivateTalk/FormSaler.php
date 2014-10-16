<?php

class Module_Display_Catalogue_Object_PrivateTalk_FormSaler extends Dune_Include_Abstract_Code
{
    
    protected function code()
    {
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        

    $message_interval = Special_Vtor_Settings::$timeIntervalMessageToPrivateTalk; 
    $view = Dune_Zend_View::getInstance();
    Dune_Static_StylesList::add('catalogue/info/form_pablic_talk');
    
try 
{
    if (!Dune_Session::$auth)
        throw new Dune_Exception_Control('ѕользователь не авторизован - не может оставл€ть сообщение.', 1);
        
    $session = Dune_Session::getInstance(Dune_Session::ZONE_AUTH);        
    $user = $session->getZone();
    $time = Dune_Auth_Mysqli_UserTime::getInstance($user['user_id']);
//    if ($time->getTime('private_talk_message') and $time->getTime('private_talk_message') > time() - $message_interval)
//        throw new Dune_Exception_Control('—лишком часто.', 2);
    $view->object_id = $this->object->id;
    $view->saler_id = $this->object->saler_id;
    $view->interlocutor = $this->interlocutor;
    $view->action = '/user/do/save-message-to-privatetalksaler/';
    $cooc = Dune_Cookie_ArraySingleton::getInstance(Dune_Parameters::$cookieNameSystem);
    $view->text = $cooc['text'];
    echo $view->render('bit/catalogue/object/talk/form_simple');
        
        
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
    
    