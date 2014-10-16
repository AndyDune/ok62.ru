<?php

class System_Site_BeforeCommand extends Dune_Include_Abstract_Code
{

    protected function code()
    {
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        

    Special_Vtor_Settings::$districtPlus = true;

    Dune_Parameters::$useClassToAssign = true;

    $cooc = Dune_Cookie_ArraySingleton::getInstance(Dune_Parameters::$cookieNameSystem);
    Dune_Static_Message::checkCookieArray($cooc);
    Dune_BeforePageOut::registerObject($cooc);

    $URL = Dune_Parsing_UrlSingleton::getInstance();    
    
  Dune_Objects::$command = new Dune_Data_Container_Command($URL[1], $URL[2]);
  Dune_Objects::$command->setCommandFolder('default');
  Dune_Objects::$command->registerCommand(Dune_Variables::$commandNameAdmin, '_admin', Dune_Data_Container_Command::STATUS_ADMIN);
  Dune_Objects::$command->registerCommand('main')
                        ->registerCommand('catalogue')
                        ->registerCommand('public')
                        ->registerCommand('user')
                        ->registerCommand('userna')
                        ->registerCommand('info')
                        ->registerCommand('read')
                        ->registerCommand('system')
                        ->registerCommand('seller')
                        ->registerCommand('data')
                        ->registerCommand('map')
                        ->registerCommand('ocatalogue')
                        ->registerCommand('adminocatalogue')
  
                        ->registerCommand('modules.php')
                        ->registerDefaultCommand('main');
  Dune_Objects::$command->check();
    
    
    if (Dune_Session::$auth)
    {
        $session = Dune_Session::getInstance(Dune_Session::ZONE_AUTH);
        Special_Vtor_User_Auth::$id = $session->user_id;
        Special_Vtor_User_Auth::$mail = $session->user_mail;
        Special_Vtor_User_Auth::$name = $session->user_name;
        Special_Vtor_User_Auth::$status = $session->user_status;
    }
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
    }
    
}