<?php 
$URL = Dune_Parsing_UrlSingleton::getInstance();
$one_user = false; // Флаг наличия конкретного выбраого пользователя
$user_look = false; // Объект информации о выбранном пользователе

$this->setStatus(Dune_Include_Command::STATUS_TEXT);

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
        
     $session = Dune_Session::getInstance(Dune_Session::ZONE_AUTH);

///////////////////////////////////////////////////////////
/// Создание 
    // Одна тема
    $id = $URL->getCommandPart(4, 2);
    if ($URL->getCommandPart(4, 1) == 'topic' and $id !== false)
    {
        $post = Dune_Filter_Post_Total::getInstance();
        //$post->setIconv(Dune_Filter_Post_Total::ENC_UTF8, Dune_Filter_Post_Total::ENC_WINDOWS1251);
        $post->setResultCharset();
        $module = new Module_User_Contact_TopicOneSaveOnly();
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
//        echo $module->getOutput();
        if ($module->getResult('success'))
        {
//            echo '*0*';
            switch ($module->getResult('output'))
            {
                case 'list':
                    echo $module->getOutput();
                break;
                default:
                    Dune_Static_Header::charset();
                    $view = Dune_Zend_View::getInstance();
                    //$post->setIconv(Dune_Filter_Post_Total::ENC_UTF8, Dune_Filter_Post_Total::ENC_UTF8);
                    $post->setLength(0);
                    $view->mtext = str_replace("\n", '<br />', $post->text);
                    $view->name = $user->getUserName();
                    $view->user_id = $user->getUserId();
                    echo $view->render('ajax/talk/say_i');
            }
        }
        else 
            throw new Dune_Exception_Control('Ошибка', 3);
        
    }
    else // Список тем
    {
        echo '*3*';
        return;
    }

//////////////////////////////////////////////////////////      
      
}


catch (Dune_Exception_Control $e)
{
    $view = Dune_Zend_View::getInstance();
    if ($e->getCode() == 1)
    {
        echo '*1*';
    }
    else if ($e->getCode() == 2)
    {
        echo '*2*';
    }   
    else if ($e->getCode() == 3)
    {
        echo '*4*'; // Не удалось сохрапнить
    }   
    
}