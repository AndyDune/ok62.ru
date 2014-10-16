<?php


class System_Auth_RecallPassword extends Dune_Include_Abstract_Code
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

    //$cooc['user_mail'] = $this->mail;
    $good = ''; // Передаваемый по цепочке флаг удачи - помогает избегать множественных вложений if ... else
    $session = Dune_Session::getInstance();
try {

    //if (false)
    if (((strlen($this->captcha) < 3) or (strcasecmp($this->captcha, $session->captcha))) and $this->check_captcha)
    {
        throw new Dune_Exception_Base('Введён неверный секретный код.', 9);
    }
    
    // ВРЕМЕННАЯ ЗАГЛУШКА
    //    throw new Dune_Exception_Base('Регистрация временно недоступна.', 100);

    
    // Введен ли почтвый адрес
    if (!$this->mail or (strlen($this->mail) < 3))
    {
        throw new Dune_Exception_Base('Адрес электроной почты недопустим.', 12);
    }

    // Проверяем почту детально
    $test = new Dune_Data_Format_Mail($this->mail);
    if (!$test->check())
    {
        throw new Dune_Exception_Base('Адрес электроной почты недопустим.', 12);
    }

    // Проверка сущкествования имени и почты в базе активных юзеров   
    $object_auth = new Dune_Auth_Mysqli_UserActive();
    if (!$object_auth->useMail($this->mail))
    {
        throw new Dune_Exception_Base('Нет такого почтового ящика.', 13);
    }
            
               // Сохраняем во временной
              
        $cooc['message'] = array(
                                 //'text' => 'Сохранили',
                                 'code'    => 100,
                                 'section' => 'auth.recall.password'
                                 );
        $this->results['code'] = md5($object_auth->getCode()); 
        $this->results['password'] = $object_auth->getPassword();
        $this->results['name'] = $object_auth->getUserName(); 
        $this->results['mail'] = $object_auth->getUserMail(); 
        $this->results['success'] = true; 
               // Посылаем письмо с подтверждением

          
            

} // try
catch (Dune_Exception_Base $e)
{        
     $message_code[0] = $e->getCode();
     $message_text[0] = $e->getMessage();

    
    if ($message_code[0])
    {
        $cooc['message'] = array(
                                 //'text' => $e->getMessage(),
                                 'code'    => $message_code[0],
                                 'section' => 'auth.recall.password'
                                 );
    }
            
    $session->captcha = '';
    echo $good;
    $this->messageCode = $message_code;
    $this->messageText = $message_text;
}   


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
    }
    
}
    
    