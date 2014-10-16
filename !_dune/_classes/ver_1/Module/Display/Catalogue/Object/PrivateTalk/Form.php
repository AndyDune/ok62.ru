<?php

class Module_Display_Catalogue_Object_PrivateTalk_Form extends Dune_Include_Abstract_Code
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
//    if (!Dune_Session::$auth)
//        throw new Dune_Exception_Control('Пользователь не авторизован - не может оставлять сообщение.', 1);
        
    $session = Dune_Session::getInstance(Dune_Session::ZONE_AUTH);        
    $user = $session->getZone();
//    $time = Dune_Auth_Mysqli_UserTime::getInstance($user['user_id']);
    
    $session = Dune_Session::getInstance('talk');
    
//if ($time->getTime('private_talk_message') and $time->getTime('private_talk_message') > time() - $message_interval)    
    
    if ($session->text)
        $view->text = $session->text;
        
    $view->object_id = $this->object->id;
    $view->saler_id = $this->object->saler_id;
    if (Dune_Session::$auth)    
        $view->action = '/user/do/save-message-to-privatetalk/';
    else 
        $view->action = '/user/do/save-message-to-privatetalk-na/';
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
    
    