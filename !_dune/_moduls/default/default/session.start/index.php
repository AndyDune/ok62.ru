<?php

    $cooc = Dune_Cookie_ArraySingleton::getInstance(Dune_Parameters::$cookieNameSystem);

    switch (true)
    {
        case (isset($cooc['was_reg'])):
            $session = Dune_Session::getInstance();
            if (Dune_Session::$auth)
            {
                $message_code[0] = 0;
                $message_text[0] = 'Запущена авторизованная сессия.';
            }
            else if (!isset($cooc['user_login']))
            {
                $message_code[0] = 10;
                $message_text[0] = 'В пироге пользователя нет указания адреса электронной почты.';
                unset($cooc['was_reg']);
            }
            else if (!isset($cooc['user_code']))
            {
                $message_code[0] = 11;
                $message_text[0] = 'В пироге пользователя нет указания защитного кода.';
                unset($cooc['was_reg']);
            }
            else 
            {
                $object_auth = Dune_Auth::factory('Mail Mysqli');
                switch (false)
                {
                    case ($object_auth->checkMailBlackList($cooc['user_mail'])):
                        $message_code[0] = 12;
                        $message_text[0] = 'Адрес электроной почты в чёрном листе.';
                    break;
                    default:
                        switch (true)
                        {
                            case ($object_auth->checkMail($cooc['user_mail']) == 1):
                                if ($object_auth->checkCode($cooc['user_code']))
                                {
                                    $text['status'] = $object_auth->getUserStatus();
                                    $text['array'] = $object_auth->getUserArray();
                                    $text['name'] = $object_auth->getUserName();
                                    
                                    $text['id'] = $object_auth->getUserId();
                                    $cooc['was_reg'] = 1;
                                    
                                    // Сохраняем момент входа
                                    Functions_Mysqli_Users::setTime($object_auth->getUserId(), 'last_visit');
                                }
                                else 
                                {
                                    $message_code[0] = 13;
                                    $message_text[0] = 'Попытка авторизации неудачна. Неверный код.';
                                    unset($cooc['user_code']);
                                    unset($cooc['user_mail']);
                                    unset($cooc['was_reg']);
                                }
                              break;
                              default:
                                    $message_code[0] = 14;
                                    $message_text[0] = 'Адрес электронной почты не зарегистрирован.';
                                    unset($cooc['user_code']);
                                    unset($cooc['user_mail']);
                                    unset($cooc['was_reg']);
                        }
                }        
            
                if (!$message_code[0])
                {
                    Dune_Session::$auth = true;
                    $session->openZone(Dune_Session::ZONE_AUTH);
                    
                    $session->user_code = $cooc['user_code'];
                    $session->user_mail = $cooc['user_mail'];
                    $session->user_login = $cooc['user_login'];
                    $session->user_name = $text['name'];
                    $session->user_status = $text['status'];
                    $session->user_array = $text['array'];
                    $session->user_id = $text['id'];
                    
                    Dune_Variables::$userStatus = $text['status'];
                    
                    $session->closeZone();
                }
            
            }
            if ($message_code[0])
            {
                $cooc['message'] = array(
                                         'code'    => $message_code[0],
                                         'section' => 'auth.cookie_enter'
                                         );
            }
            
        break;
        // Старт сессии при использовании капчи
        case (isset($cooc['capcha'])):
            $session = Dune_Session::getInstance();
        break;
        default:
            $message_code[0] = 15;
            $message_text[0] = 'Пользователь не регистрировался.';
    }    
    $this->results = $text;
    $this->messageCode = $message_code;
    $this->messageText = $message_text;
    
    if (Dune_Session::$auth)
    {
    	$session = Dune_Session::getInstance();
	    $session->openZone(Dune_Session::ZONE_AUTH);
        Dune_Variables::$userStatus = $session->user_status;
        $session->closeZone();
    }
    	
    
    