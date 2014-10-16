<?php
/*
*   Проверка наличия обязательных параметров для модуля.
*   Установка выходных параметров по умолчанию.
*
*/

class Dune_Exception_Control_Module_Exit extends Dune_Exception_Control
{
}

$parameters = $this->parameters;

    // Возвращает защитный код
    // Путую строку если код выбирать запрещено (обычно из-за ограничения не более 3 выборок в течении часа)
    
    $text['id'] = 0;
    $text['status'] = 0;
    $text['array'] = array();
    $text['name'] = '';
    
    $message_code[0] = 0;
    $message_text[0] = 'Пользователь авторизован.';    

    

    echo $cooc = Dune_Cookie_ArraySingleton::getInstance(Dune_Parameters::$cookieNameSystem);
    
 try {
     if (empty($cooc['was_reg']))
     {
         throw new Dune_Exception_Control('Пользователь не регистрировался.', 15);
     }
        
     $session = Dune_Session::getInstance(Dune_Session::ZONE_AUTH);
     if (Dune_Session::$auth)
     {
         throw new Dune_Exception_Control_Module_Exit('Запущена авторизованная сессия.', 0);
     }
     else if (!isset($cooc['user_login']))
     {
        throw new Dune_Exception_Control('В пироге пользователя нет указания адреса электронной почты.', 10);
     }
     else if (!isset($cooc['user_code']))
     {
        throw new Dune_Exception_Control('В пироге пользователя нет указания защитного кода.', 11);
     }
            
     $object_auth = new Dune_Auth_Mysqli_UserActive();
     if (strpos('@', $cooc['user_login']) !== false)
        $good = $object_auth->useMail($cooc['user_login']);
     else 
     {
        $good = $object_auth->useName($cooc['user_login']);
     }
                
     if (!$good) // Нет такого пользователя
     {
          throw new Dune_Exception_Control('Нер пользователя.', 14);
     }
     else if ($object_auth->checkCode($cooc['user_code'], 1)) // Правильный ли секретный код
     {
        $text['user_status'] = $object_auth->getUserStatus();
        $text['user_array'] = $object_auth->getUserArray();
        $text['user_name'] = $object_auth->getUserName();
        $text['user_mail'] = $object_auth->getUserMail();
                                   
        $text['user_id'] = $object_auth->getUserId();
        $cooc['was_reg'] = 1;
                                    
        // Сохраняем момент входа
        //Functions_Mysqli_Users::setTime($object_auth->getUserId(), 'last_visit');
                     
     }
     else 
     {
          throw new Dune_Exception_Control('Попытка авторизации неудачна. Неверный код.', 13);
     }
                    
                
/*                 В будущем внедрить проверку на вхождение юзера в Ч.С.
                    case ($object_auth->checkMailBlackList($cooc['user_mail'])):
                        $message_code[0] = 12;
                        $message_text[0] = 'Адрес электроной почты в чёрном листе.';
                    break;
*/                 
            
           Dune_Session::$auth = true;
                    
           $session->user_code = $cooc['user_code'];
           $session->user_mail = $text['user_mail'];
           $session->user_login = $cooc['user_login'];
           $session->user_name = $text['user_name'];
           $session->user_status = $text['user_status'];
           $session->user_array = $text['user_array'];
           $session->user_id = $text['user_id'];
                    
           Dune_Variables::$userStatus = $text['status'];
                    
           $session->lockZone('auth1');
            


 }
 catch (Dune_Exception_Control_Module_Exit $e)
 {
 //    echo 'Dune_Exception_Control_Module_Exit<br/>';
 }
 catch (Dune_Exception_Control $e)
 {
/*     Для теста
     echo 'Dune_Exception_Control<br/>';
     echo $e->getCode(), '<br/>';
     echo $e->getMessage(), '<br/>';
     
*/     
     unset($cooc['was_reg']);
     unset($cooc['user_code']);
     //unset($cooc['user_mail']);
     unset($cooc['user_status']);
 }
    
    
    if (Dune_Session::$auth)
    {
    	$session = Dune_Session::getInstance(Dune_Session::ZONE_AUTH);
        Dune_Variables::$userStatus = $session->user_status;
    }
    
/*            if ($message_code[0])
            {
                $cooc['message'] = array(
                                         'code'    => $message_code[0],
                                         'section' => 'auth.cookie_enter'
                                         );
            }
*/            
    
    	
    
    