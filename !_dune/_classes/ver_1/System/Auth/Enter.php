<?php

class System_Auth_Enter extends Dune_Include_Abstract_Code
{

    protected function code()
    {
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        


    // Возвращает защитный код
    // Путую строку если код выбирать запрещено (обычно из-за ограничения не более 3 выборок в течении часа)
    
    $this->results['success'] = false;
   
    $message_code[0] = 0;
    $message_text[0] = 'Пользователь авторизован.';    

    
    $cooc = Dune_Cookie_ArraySingleton::getInstance(Dune_Parameters::$cookieNameSystem);

    $cooc['user_login'] = $this->login;
    
try {    
    if (!$this->login)
    {
        throw new Dune_Exception_Control('Не указано имя или адрес электронной почты.', 10);
    }
    
    if (!$this->password or strlen($this->password) < 1)
    {
        throw new Dune_Exception_Control('Не указан пароль либо он непозволительно короток.', 11);        
    }
    
    $object_auth = new Dune_Auth_Mysqli_UserActive();
    if (strpos($this->login, '@') !== false)
    {
        $good = $object_auth->useMail($this->login);
    }
    else 
    {
        $good = $object_auth->useName($this->login);
    }
        
        
        if (!$good) // Нет такого пользователя
        {
            throw new Dune_Exception_Control('Такого пользователя не существует.', 12);
        }
        
        
    if (!$object_auth->getUserStatus())
    {
            throw new Dune_Exception_Control('Пользователь временно заблокирован.', 17);
    }
        
        
//        $this->attempt_interval; // Время на повторные попытки
//        $this->attempt_count; // Число попыток за интервал
        
        
        $user_time  = Dune_Auth_Mysqli_UserTime::getInstance($object_auth->getUserId());
        $user_count = Dune_Auth_Mysqli_UserCount::getInstance($object_auth->getUserId());
        Dune_BeforePageOut::registerObject($user_count);
        Dune_BeforePageOut::registerObject($user_time);
        $time = time() - $this->attempt_interval;
        
        if ($user_time->getTimePasswordCheck() < $time)
        {
            $user_count->setCountPasswordCheck(1);
            $user_time->setTimePasswordCheck(); 
        }
        else if ($user_count->getCountPasswordCheck() < $this->attempt_count or !Special_Vtor_Settings::$checkEnterAttemptCount)
        {
            $user_count->setCountPasswordCheck(1, true);
        }
        else  // Слишком много попыток - подождите
        {
            throw new Dune_Exception_Control('Слишком много попыток - подождите.', 14);
        }
        

        if ($this->md5)
        {
            if (!$object_auth->checkCodeHash($this->password))
                throw new Dune_Exception_Control('Попытка авторизации неудачна. Неверный пароль.', 13);
        }
        else if (!$object_auth->checkPassword($this->password)) // Правильный ли пароль
        {
            $t = $this->password;
            throw new Dune_Exception_Control('Попытка авторизации неудачна. Неверный пароль. ', 13);
        }
                    
                
/*                 В будущем внедрить проверку на вхождение юзера в Ч.С.
                    case ($object_auth->checkMailBlackList($cooc['user_mail'])):
                        $message_code[0] = 12;
                        $message_text[0] = 'Адрес электроной почты в чёрном листе.';
                    break;
*/              
           $user_time->setTimeLastEnter();
           $user_time->setTimeLastVisit();
   
           $s_begin = new System_Auth_SessionBegin();
           $s_begin->user = $object_auth;
           $s_begin->make();
           
           
           echo 1; // Всё хорошо
           $this->results['success'] = true;
                
                

} // try
catch (Dune_Exception_Control $e)
{        
            
     $message_code[0] = $e->getCode();
     $message_text[0] = $e->getMessage();
    
            
            if ($message_code[0])
            {
                $cooc['message'] = array(
                                      //   'text' => $e->getMessage(),
                                         'code'    => $message_code[0],
                                         'section' => 'auth.enter'
                                         );
            }
            
}    
    $this->messageCode = $message_code;
    $this->messageText = $message_text;


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
    }
    
}
    
    