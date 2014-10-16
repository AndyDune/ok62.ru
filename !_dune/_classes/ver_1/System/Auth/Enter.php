<?php

class System_Auth_Enter extends Dune_Include_Abstract_Code
{

    protected function code()
    {
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        


    // ���������� �������� ���
    // ����� ������ ���� ��� �������� ��������� (������ ��-�� ����������� �� ����� 3 ������� � ������� ����)
    
    $this->results['success'] = false;
   
    $message_code[0] = 0;
    $message_text[0] = '������������ �����������.';    

    
    $cooc = Dune_Cookie_ArraySingleton::getInstance(Dune_Parameters::$cookieNameSystem);

    $cooc['user_login'] = $this->login;
    
try {    
    if (!$this->login)
    {
        throw new Dune_Exception_Control('�� ������� ��� ��� ����� ����������� �����.', 10);
    }
    
    if (!$this->password or strlen($this->password) < 1)
    {
        throw new Dune_Exception_Control('�� ������ ������ ���� �� ��������������� �������.', 11);        
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
        
        
        if (!$good) // ��� ������ ������������
        {
            throw new Dune_Exception_Control('������ ������������ �� ����������.', 12);
        }
        
        
    if (!$object_auth->getUserStatus())
    {
            throw new Dune_Exception_Control('������������ �������� ������������.', 17);
    }
        
        
//        $this->attempt_interval; // ����� �� ��������� �������
//        $this->attempt_count; // ����� ������� �� ��������
        
        
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
        else  // ������� ����� ������� - ���������
        {
            throw new Dune_Exception_Control('������� ����� ������� - ���������.', 14);
        }
        

        if ($this->md5)
        {
            if (!$object_auth->checkCodeHash($this->password))
                throw new Dune_Exception_Control('������� ����������� ��������. �������� ������.', 13);
        }
        else if (!$object_auth->checkPassword($this->password)) // ���������� �� ������
        {
            $t = $this->password;
            throw new Dune_Exception_Control('������� ����������� ��������. �������� ������. ', 13);
        }
                    
                
/*                 � ������� �������� �������� �� ��������� ����� � �.�.
                    case ($object_auth->checkMailBlackList($cooc['user_mail'])):
                        $message_code[0] = 12;
                        $message_text[0] = '����� ���������� ����� � ������ �����.';
                    break;
*/              
           $user_time->setTimeLastEnter();
           $user_time->setTimeLastVisit();
   
           $s_begin = new System_Auth_SessionBegin();
           $s_begin->user = $object_auth;
           $s_begin->make();
           
           
           echo 1; // �� ������
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
    
    