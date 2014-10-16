<?php

class System_Auth_Checkmail extends Dune_Include_Abstract_Code
{

    protected function code()
    {
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        

    $this->results['success'] = false;
   
    $message_code[0] = 0;
    $message_text[0] = '������������ �����������.';    

    
    $cooc = Dune_Cookie_ArraySingleton::getInstance(Dune_Parameters::$cookieNameSystem);

    $cooc['user_mail'] = $this->mail;
    $cooc['user_code'] = $this->code;
    $good = ''; // ������������ �� ������� ���� ����� - �������� �������� ������������� �������� if ... else
    $session = Dune_Session::getInstance();
try {

    
    // ��������� ��������
    //    throw new Dune_Exception_Base('����������� �������� ����������.', 100);

    
    // ������ �� ������� �����
    if (!$this->mail or (strlen($this->mail) < 3))
    {
        throw new Dune_Exception_Base('����� ���������� ����� ����������.', 12);
    }

    // ��������� ����� ��������
    $test = new Dune_Data_Format_Mail($this->mail);
    if (!$test->check())
    {
        throw new Dune_Exception_Base('����� ���������� ����� ����������.', 12);
    }

    // �������� �������������� ����� � ����� � ���� �������� ������   
    $object_auth = new Dune_Auth_Mysqli_UserActive();
    if ($object_auth->useMail($this->mail))
    {
        throw new Dune_Exception_Base('����� ����������� ����� ��� ���������������.', 14);
    }
        
    // �������� �������������� ����� � ����� � ���� ��������� ������ 
    $object_auth_temp = new Dune_Auth_Mysqli_UserTemp();
    $object_auth_temp->removeOld(10000); // ������� ������ ������� �������
    if (!$object_auth_temp->useMail($this->mail))
    {
        throw new Dune_Exception_Base('����� ����������� ����� ����������� � ������� �� �������.', 14);
    }

            
               // ��������� �� ���������
        $object_auth->setUserArray($object_auth_temp->getUserArray());
        $object_auth->setUserStatus(1);
        $object_auth->setUserName($object_auth_temp->getUserName());
        $cooc['user_id'] = $object_auth->add();
              
        $cooc['user_name']    = $object_auth->getUserName();
        $cooc['user_login']   = $object_auth->getUserName();
        $cooc['user_code']    = $object_auth->getUserCode();
        $cooc['was_reg']      = 1;


         Dune_Session::$auth = true;
         $session = Dune_Session::getInstance(Dune_Session::ZONE_AUTH);
         $session->unlockZone('auth1');
           
         $session->user_code     = $cooc['user_code'];
         $session->user_mail     = $object_auth->getUserMail();
         $session->user_login    = $cooc['user_login'];
         $session->user_name     = $cooc['user_name'];
         $session->user_status   = $object_auth->getUserStatus();
         $session->user_array    = $object_auth->getUserArray();
         $session->user_id       = $cooc['user_id'];
                    
         $session->lockZone('auth1');
            
        
        
        $cooc['message'] = array(
                                 'text' => '���������',
                                 'code'    => 12,
                                 'section' => 'auth.checkmail'
                                 );
        $this->results['code']     = $object_auth->getCode(); 
        $this->results['password'] = $object_auth->getPassword(); 
        $this->results['name']     = $object_auth->getUserName(); 
        $this->results['mail']     = $object_auth->getUserMail(); 
        $this->results['success']  = true; 
               // �������� ������ � ��������������

          
            

} // try
catch (Dune_Exception_Base $e)
{        
     $message_code[0] = $e->getCode();
     $message_text[0] = $e->getMessage();

    
    if ($message_code[0])
    {
        $cooc['message'] = array(
                                 'code'    => $message_code[0],
                                 'section' => 'auth.checkmail'
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
    
    