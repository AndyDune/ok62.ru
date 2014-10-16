<?php

class System_Auth_Registration extends Dune_Include_Abstract_Code
{

    protected function code()
    {
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        


    
    $this->results['success'] = false;
   
    $message_code[0] = 0;
    $message_text[0] = 'Пользователь авторизован.';    

    
    $cooc = Dune_Cookie_ArraySingleton::getInstance(Dune_Parameters::$cookieNameSystem);

    $good = ''; // Передаваемый по цепочке флаг удачи - помогает избегать множественных вложений if ... else
    $session = Dune_Session::getInstance();
try {

    if (((strlen($this->captcha) < 3) or (strcasecmp($this->captcha, $session->captcha))) and $this->check_captcha)
    {
        throw new Dune_Exception_Base('Введён неверный секретный код.', 9);
    }
    $session->captcha = '';
    // ВРЕМЕННАЯ ЗАГЛУШКА
    //    throw new Dune_Exception_Base('Регистрация временно недоступна.', 100);

    
    // Есть ли имя
    if (!$this->login)
    {
        throw new Dune_Exception_Base('Не указано имя.', 10);
    }
    // @ - запрещён в имени
    if (strpos($this->login, '@') !== false 
     or strpos($this->login, '<') !== false 
     or strpos($this->login, '>') !== false
     or strpos($this->login, '"') !== false)
    {
        throw new Dune_Exception_Base('Недопусимый символ в имени (@, <, >, ").', 11);
    }
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
    if ($object_auth->checkNameExistence($this->login))
    {
        throw new Dune_Exception_Base('Пользователь с таким именем уже существует.', 13);
    }
    if ($object_auth->useMail($this->mail))
    {
        throw new Dune_Exception_Base('Адрес электронной почты уже зарегистрирован.', 14);
    }
        
    // Проверка сущкествования имени и почты в базе временных юзеров 
    $object_auth = new Dune_Auth_Mysqli_UserTemp();
    $object_auth->removeOld(10000); // Удаляем старые передаём секунды
    if ($object_auth->checkNameExistence($this->login))
    {
        throw new Dune_Exception_Base('Пользователь с таким именем уже существует.', 13);
    }
    if ($object_auth->useMail($this->mail))
    {
        throw new Dune_Exception_Base('Адрес электронной почты уже зарегистрирован.', 14);
    }
        

            
               // Сохраняем во временной
        $object_auth->add();
              
/*        $cooc['message'] = array(
                                 //'text' => 'Сохранили',
                                 'code'    => 17,
                                 'section' => 'auth.registry'
                                 );
*/
        Dune_Static_Message::setCode(17, 'auth.registry');
                                 
//        $session = Dune_Session::getInstance();    
//        $session->message_code = 17;
                                 
                                 
        $this->results['code'] = $object_auth->getCodeHash(); 
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
/*        $cooc['message'] = array(
                                 'code'    => $message_code[0],
                                 'section' => 'auth.registry'
                                 );
*/                                 
        Dune_Static_Message::setCode($message_code[0], 'auth.registry');
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
    
    