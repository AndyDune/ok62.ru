<?php

class Module_Display_User_AuthField extends Dune_Include_Abstract_Code
{

    protected function code()
    {
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        


// ������, �������� ���� �������������� ���� �������������� �������
// ���� ���� ���������� � ������������.
$view = Dune_Zend_View::getInstance();
Dune_Static_StylesList::add('user/auth');

if (Dune_Session::$auth)
{
   $session = Dune_Session::getInstance(Dune_Session::ZONE_AUTH);
    
   $talk = new Special_Vtor_PrivateTalk_One($session->user_id);
   $view->talk = $talk->isHaveNewMessage();
   $view->name = $session->user_name;
   if ($session->user_status > 999)
   {
       $view->admin = Dune_Variables::$commandNameAdmin;
   }
   echo $view->render('bit/user/auth_have');
   Dune_Static_JavaScriptsList::add('dune_was_auth');
}
else 
{
    Dune_Static_JavaScriptsList::add('dune_auth');
    $cooc = Dune_Cookie_ArraySingleton::getInstance(Dune_Parameters::$cookieNameSystem);    
    $view->assign('login', $cooc['user_login']);
    echo $view->render('bit:user:auth_form_to_enter');
}


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
    }
    
}
    
    