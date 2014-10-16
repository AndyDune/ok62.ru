<?php


class System_Auth_RecallPassword extends Dune_Include_Abstract_Code
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

    //$cooc['user_mail'] = $this->mail;
    $good = ''; // ������������ �� ������� ���� ����� - �������� �������� ������������� �������� if ... else
    $session = Dune_Session::getInstance();
try {

    //if (false)
    if (((strlen($this->captcha) < 3) or (strcasecmp($this->captcha, $session->captcha))) and $this->check_captcha)
    {
        throw new Dune_Exception_Base('����� �������� ��������� ���.', 9);
    }
    
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
    if (!$object_auth->useMail($this->mail))
    {
        throw new Dune_Exception_Base('��� ������ ��������� �����.', 13);
    }
            
               // ��������� �� ���������
              
        $cooc['message'] = array(
                                 //'text' => '���������',
                                 'code'    => 100,
                                 'section' => 'auth.recall.password'
                                 );
        $this->results['code'] = md5($object_auth->getCode()); 
        $this->results['password'] = $object_auth->getPassword();
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
    
    