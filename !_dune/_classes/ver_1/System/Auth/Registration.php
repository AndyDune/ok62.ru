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
    $message_text[0] = '������������ �����������.';    

    
    $cooc = Dune_Cookie_ArraySingleton::getInstance(Dune_Parameters::$cookieNameSystem);

    $good = ''; // ������������ �� ������� ���� ����� - �������� �������� ������������� �������� if ... else
    $session = Dune_Session::getInstance();
try {

    if (((strlen($this->captcha) < 3) or (strcasecmp($this->captcha, $session->captcha))) and $this->check_captcha)
    {
        throw new Dune_Exception_Base('����� �������� ��������� ���.', 9);
    }
    $session->captcha = '';
    // ��������� ��������
    //    throw new Dune_Exception_Base('����������� �������� ����������.', 100);

    
    // ���� �� ���
    if (!$this->login)
    {
        throw new Dune_Exception_Base('�� ������� ���.', 10);
    }
    // @ - �������� � �����
    if (strpos($this->login, '@') !== false 
     or strpos($this->login, '<') !== false 
     or strpos($this->login, '>') !== false
     or strpos($this->login, '"') !== false)
    {
        throw new Dune_Exception_Base('����������� ������ � ����� (@, <, >, ").', 11);
    }
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
    if ($object_auth->checkNameExistence($this->login))
    {
        throw new Dune_Exception_Base('������������ � ����� ������ ��� ����������.', 13);
    }
    if ($object_auth->useMail($this->mail))
    {
        throw new Dune_Exception_Base('����� ����������� ����� ��� ���������������.', 14);
    }
        
    // �������� �������������� ����� � ����� � ���� ��������� ������ 
    $object_auth = new Dune_Auth_Mysqli_UserTemp();
    $object_auth->removeOld(10000); // ������� ������ ������� �������
    if ($object_auth->checkNameExistence($this->login))
    {
        throw new Dune_Exception_Base('������������ � ����� ������ ��� ����������.', 13);
    }
    if ($object_auth->useMail($this->mail))
    {
        throw new Dune_Exception_Base('����� ����������� ����� ��� ���������������.', 14);
    }
        

            
               // ��������� �� ���������
        $object_auth->add();
              
/*        $cooc['message'] = array(
                                 //'text' => '���������',
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
               // �������� ������ � ��������������

          
            

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
    
    