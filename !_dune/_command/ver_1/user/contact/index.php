<?php
$URL = Dune_Parsing_UrlSingleton::getInstance();
$one_user = false; // Флаг наличия конкретного выбраого пользователя
$user_look = false; // Объект информации о выбранном пользователе

     $session = Dune_Session::getInstance('contact');
     if ($id = (int)$URL->getCommandPart(3, 2))
     {
        $user_look = new Dune_Auth_Mysqli_UserActive($id);
        if ($user_look->getUserId())
        {
           $session->user_id = $id;
           $one_user = true;
        }

     }
     
     if (!$one_user and isset($session->user_id))
     {
         $user_look = new Dune_Auth_Mysqli_UserActive($session->user_id);
         if (!$user_look->getUserId())
         {
             $session->killZone();
             $this->setStatus(Dune_Include_Command::STATUS_GOTO);
             $this->setResult('goto', '/user/list/');
             return;
         }     
         else 
         {
            $one_user = true;
            $URL->setCommand('user_' . $session->user_id, 3); // Создаём комманду для пользователя
         }
     }

try
{

    if (!Dune_Session::$auth) // Пользователь не может смотреть информацию о продавцах
    {
        throw new Dune_Exception_Control('Необходимо зарегистрироваться', 1);
    }    
    $user = false;
    $session = Dune_Session::getInstance(Dune_Session::ZONE_AUTH);
    $user = new Dune_Auth_Mysqli_UserActive($session->user_id);
    if (!$user->getUserId())
    {
        throw new Dune_Exception_Control('Ошибка', 2);
    }
    //echo $user;
    $view = Dune_Zend_View::getInstance();
    
    //$view->user = $user;
//    Dune_Static_StylesList::add('user/info/base');
    Dune_Static_StylesList::add('talk/base');
    Dune_Static_JavaScriptsList::add('jquery.form');
    Dune_Static_JavaScriptsList::add('thickbox');
    Dune_Static_JavaScriptsList::add('dune_talk');
    Dune_Static_StylesList::add('thickbox');
    
    
        
     $session = Dune_Session::getInstance(Dune_Session::ZONE_AUTH);
     if (isset($session->user_id))   
     {   
            $edit_menu = new Module_Display_User_MoreEditMenu();
            $edit_menu->user = $user;
            $edit_menu->code = 'contact';
            $edit_menu->make();
            $view->more_edit_menu = $edit_menu->getOutput();
      }

///////////////////////////////////////////////////////////
/// Создание 
    // Одна тема
    $id = $URL->getCommandPart(4, 2);
    if ($URL->getCommandPart(4, 1) == 'topic' and $id !== false)
    {
        $module = new Module_User_Contact_TopicOne();
        $module->user = $user;
        if ((int)$id > 1)
        {
            $module->topic_code = 0;
            $module->topic_id = (int)$id;
        }
        else 
        {
            $module->topic_code = 1;
            $module->topic_id = 1;
        }
        $module->interlocutor = $user_look;
        $module->url = $URL->getCommandString();
        $module->make();
        if ($module->getResult('exit'))
        {
            $this->setStatus(Dune_Include_Command::STATUS_EXIT);
            return;
        }        
        if ($module->getResult('goto'))
        {
            $this->setStatus(Dune_Include_Command::STATUS_GOTO);
            $this->setResult('goto', $module->getResult('goto'));
            return;
        }        
        if (!$module->getResult('success'))
        {
            $this->setStatus(Dune_Include_Command::STATUS_GOTO);
            $this->setResult('goto', '/user/list/');
            return;
        }
        else 
            $text = $module->getResult('text');
        $view->h1_code = '/user/contact/topic/';
        
     $session = Dune_Session::getInstance('contact');
     $session->link_to_topic = $URL[4];
     $session->link_to_topic_of_user = $user_look->getUserId();

    }
    else // Список тем
    {
        $this->setStatus(Dune_Include_Command::STATUS_GOTO);
        $this->setResult('goto', '/user/dialogs/');
        return;
       
/*        $module = new Module_User_Contact_TopicList();
        $module->user_id = $user;
        $module->interlocutor_id = $user_look;
        $module->no_one = true;
        $module->url = $URL->getCommandString();
        $module->make();
        if ($module->getResult('count') < 2)
        {
            $URL->setCommand('topic_dif', 4);
            $this->setStatus(Dune_Include_Command::STATUS_GOTO);
            $this->setResult('goto', $URL->getCommandString());
            return;
        }
        else 
            $text = $module->getResult('text');
        $view->h1_code = '/user/contact/';            
*/        
    }

//////////////////////////////////////////////////////////      
      
           
     $view->user_id = $user->getUserId();
     $view->code = 'contact';
     $session = Dune_Session::getInstance('contact');
     $view->link_to_topic = $session->link_to_topic;
     $view->user = $user_look;
     $view->one_user = $one_user;
     $view->bookmark = $view->render('bit/user/bookmark/contact');
     $view->text = $text;
//     $view->text = $view->render('page/user/list/all');
     echo $view->render('bit/general/container_padding_for_auth_extend');
        
}


catch (Dune_Exception_Control $e)
{
    $view = Dune_Zend_View::getInstance();
    if ($e->getCode() == 1)
    {
        Dune_Static_StylesList::add('user/info/message');
        echo $view->render('page/user/info/can_not_look_info');
    }
    else if ($e->getCode() == 2)
    {
        Dune_Static_StylesList::add('user/info/message');
        echo $view->render('page/user/info/can_not_look_info_error');
    }   
}