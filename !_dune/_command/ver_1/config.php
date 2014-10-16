<?php

    $directory = dirname(__FILE__);


    Special_Vtor_Settings::$districtPlus = true;

    Dune_Parameters::$useClassToAssign = true;

    $vars = Dune_Variables::getInstance();    
    
    $cooc = Dune_Cookie_ArraySingleton::getInstance(Dune_Parameters::$cookieNameSystem);
    Dune_Static_Message::checkCookieArray($cooc);
    Dune_BeforePageOut::registerObject($cooc);

    $URL = Dune_Parsing_UrlSingleton::getInstance();
    $URL->setArrayAccessDefault('main'); 
    $command_name = $URL[1];
    
    
  $command = new Dune_Data_Container_Command($command_name, $URL[2]);
  $command->registerCommand(Dune_Variables::$commandNameAdmin, '_admin', Dune_Data_Container_Command::STATUS_ADMIN);
  $command->registerCommand('main')
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
           ->registerCommand('house')
           ->registerCommand('complex')
           ->registerCommand('ocatalogue')
           ->registerCommand('subdomain')
           ->registerCommand('adminocatalogue')
  
           ->registerCommand('modules.php')
           ->registerDefaultCommand('main');
  $command->check();
  
  
    if (Dune_Parameters::$subDomain and Dune_Parameters::$subDomain != 'www')
    {
        if (key_exists(Dune_Parameters::$subDomain, Special_Vtor_SubDomain::$toUserId)) // соотношение поддомена и пользователя
        {
            $vars->subdomainFocusUserId = Special_Vtor_SubDomain::$toUserId[Dune_Parameters::$subDomain];
            $vars->subDomain = Dune_Parameters::$subDomain;
            $user = new Dune_Auth_Mysqli_UserActive(Special_Vtor_SubDomain::$toUserId[Dune_Parameters::$subDomain]);
            $vars->subdomainFocusUserData = new Dune_Array_Container($user->getAll());
            
            if (Dune_Parameters::$subDomain == 'edinstvo') // Специально обрабатываем домен edinstvo
                Special_Vtor_Object_List::$edinstvo = true;
            else 
                Special_Vtor_Object_List::$user = $vars->subdomainFocusUserId;
                
            Special_Vtor_Object_List::$showWitoutHouseNumber = true;
            Special_Vtor_Users::$sellerSelectInFilter = false;
            Special_Vtor_Users::$rubricInFilter = false;
            Special_Vtor_Users::$topMenu = false;
            Special_Vtor_Users::$topMainBanners = false;
            Dune_Parameters::$templateRealization = Dune_Parameters::$subDomain; // реализация прилагательных файлов вида
            
        if (key_exists(Dune_Parameters::$subDomain, Special_Vtor_SubDomain::$specialView)) // Есть спец папка видов.
        {
          Dune_Zend_View::$scriptPath = $_SERVER['DOCUMENT_ROOT'] . '/!_dune/_views/' . Dune_Parameters::$templateSpace . '/_subdomain/' . Dune_Parameters::$subDomain;            
        }

        if (key_exists(Dune_Parameters::$subDomain, Special_Vtor_SubDomain::$specialCommand)
            and in_array($command->getCommand(), Special_Vtor_SubDomain::$specialCommand[Dune_Parameters::$subDomain]))
        {
            $directory .= '/_subdomain/' . Dune_Parameters::$subDomain;
        }
        
            Dune_Zend_Cache::$allowLoad = false;
            Dune_Zend_Cache::$allowSave = false;
            
            $str = new Dune_String_Transform($vars->subdomainFocusUserData->contact_name);
            $str->setQuoteRussian();
            Dune_Variables::addTitle($str->getResult() . ' :: ', true);
            
            //echo $vars; die();            
        }
        else 
        {
            $vars->subdomainFocusUserData = new Dune_Array_Container(array());
        }
    }
    else 
    {
        $vars->subdomainFocusUserData = new Dune_Array_Container(array());
    }
    
    
  Dune_Variables::$pathToViewFolder = '/viewfiles/' . Dune_Parameters::$templateSpace . '/' . Dune_Parameters::$templateRealization;      
  
  $command->setCommandFolderFull($directory);  
  
  
    if (Dune_Session::$auth)
    {
        $session = Dune_Session::getInstance(Dune_Session::ZONE_AUTH);
        Special_Vtor_User_Auth::$id = $session->user_id;
        Special_Vtor_User_Auth::$mail = $session->user_mail;
        Special_Vtor_User_Auth::$name = $session->user_name;
        Special_Vtor_User_Auth::$status = $session->user_status;
    }

return $command;