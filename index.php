<?php

error_reporting(E_ALL | E_STRICT);

//require_once('!_lib/php/Zend/Loader.php');
//require_once('!_lib/php/Dune/Zend/Loader.php');
require_once('!_lib/php/Dune/Loader.php');

//Dune_Zend_Loader::assignDir($_SERVER['DOCUMENT_ROOT'] . '/!_lib/php');
Dune_Loader::assignDir($_SERVER['DOCUMENT_ROOT'] . '/!_lib/php');
//Zend_Loader::registerAutoload('Dune_Zend_Loader');
Dune_Loader::registerAutoload();
require_once('!_lib/php/config.php');

require_once 'Dune/Parameters.php';
require_once 'Dune/Static/Message.php';
require_once 'Dune/Static/Alloy.php';
require_once 'Dune/Zend/Config/Ini.php';
require_once 'Dune/Cookie/ArraySingleton.php';
require_once 'Dune/BeforePageOut.php';
require_once 'Dune/Variables.php';
require_once 'Dune/Parsing/UrlSingleton.php';
require_once 'Dune/Data/Container/Command.php';
require_once 'Dune/Include/Command.php';
require_once 'Dune/Objects.php';
require_once 'Dune/Time/IntervalSingleton.php';

require_once 'Dune/Time/IntervalSingleton.php';

require_once 'Zend/View/Abstract.php';
require_once 'Zend/View.php';
require_once 'Dune/Zend/View.php';

require_once 'Dune/Data/Container/Folder.php';
require_once 'Dune/Include/Folder.php';


require_once 'Dune/Include/Module.php';

require_once 'Dune/Static/JavaScriptsList.php';
require_once 'Dune/Static/StylesList.php';


$time = Dune_Time_IntervalSingleton::getInstance();
Dune_Static_Quotes::stripMagic();

function exception_handler($e) {
  $cooc = Dune_Cookie_ArraySingleton::getInstance(Dune_Parameters::$cookieNameSystem);
  if ($cooc['show_ajax_error'] == 'yes' or !Dune_Parameters::$ajax)
  {
  echo "Экстремальное исключение: <pre>" , $e->getMessage(), "</pre><br />";
  echo '<pre>';
//  $cooc = Dune_Cookie_ArraySingleton::getInstance(Dune_Parameters::$cookieNameSystem);
//  if (isset($cooc['tester']))
    print_r($e->getTrace());
  echo '</pre>';
  }
//  echo $e->getError();
//  echo '<br />',$e->getErrno();
}
set_exception_handler('exception_handler');

ob_start();

///////////////////////////////////////////////////////////////////
/////////////		пїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅ пїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅ пїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅ пїЅпїЅ пїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅ
Dune_Static_Message::$messagesFile = $_SERVER['DOCUMENT_ROOT'].'/!_system/messages.ini';
Dune_Static_Alloy::$configFile     = $_SERVER['DOCUMENT_ROOT'].'/!_system/dbm/config.dbm';
Dune_Zend_Config_Ini::$filename    = $_SERVER['DOCUMENT_ROOT'].'/!_system/config.ini';

//    Dune_Parameters::start();
    $config = Dune_Zend_Config_Ini::getInstance('base');
    
    Dune_Parameters::$cookieSiteDomain  = $config->domain->cookie;
    Dune_Parameters::$siteDomain        = $config->domain->site;
    
    Dune_Parameters::$useClassToCheckAjax  = $config->param->use_class_to_check_ajax;
    
    $cooc = Dune_Cookie_ArraySingleton::getInstance(Dune_Parameters::$cookieNameSystem);
    Dune_BeforePageOut::registerObject($cooc);
    $get = Dune_Filter_Get_Total::getInstance();
    if ($get->tester)
        $cooc['tester'] = $get->tester;
    
    switch (true)
    {
        case ($cooc['tester'] == $config->user->code->tester):
            $section = 'tester';
        break;
    
        default:
            $section = false;
    
    }
    if ($section)
    {
        $config = Dune_Zend_Config_Ini::getInstance($section);
    }
    
    
    Dune_Parameters::start($config);
    
    Dune_Include_Module::$modulsPath = Dune_Parameters::$modulsPath;
    
    Dune_Parameters::$siteClassesFolder = $config->folder->page->siteClasses;
    
//require_once('!_dune/_classes/' . Dune_Parameters::$siteClassesFolder . '/Autoload.php');    
//SiteAutoload::register();    


//require_once('!_dune/_classes/' . Dune_Parameters::$siteClassesFolder . '/config.php');   
//spl_autoload_register('__autoloadSpecial');
Dune_Loader::assignDir($_SERVER['DOCUMENT_ROOT'] . '/!_dune/_classes/' . Dune_Parameters::$siteClassesFolder);   
Dune_Loader::assignDir($_SERVER['DOCUMENT_ROOT'] . '/!_dune/_lib/' . Dune_Parameters::$libDynamicFolder);

Dune_Parameters::checkAjax();

require_once 'System/Session/Start.php';
require_once 'System/Site/BeforeCommand.php';

///////////////////////////////////////////////////////////////////////////////////////////////////
////////////     пїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅ пїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅ. пїЅпїЅпїЅпїЅпїЅпїЅ пїЅпїЅпїЅпїЅпїЅ.

    Dune_Parameters::$timeSetVisit = $config->time->set_visit;

    //$object_cookie_enter = new Dune_Include_Module('system:session.start');
    $module = new System_Session_Start(); // пїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅ пїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅ пїЅпїЅпїЅпїЅпїЅпїЅпїЅ
    $module->make();

///////////////////////////////////////////////////////////////////
/////////////		пїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅ пїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅ пїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅ пїЅпїЅпїЅпїЅпїЅ пїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅ
//Dune_Variables::$userStatus
    //Dune_Parameters::$templateSpaceAdmin = 'admin'; 
    //Dune_Parameters::$templateRealizationAdmin = 'default';
    Dune_Parameters::$templateSpaceAdmin = $config->folder->admin->templateSpace; 
    Dune_Parameters::$templateRealizationAdmin = $config->folder->admin->templateRealization; 
    
    //Dune_Parameters::$templateSpace = 'default';
    //Dune_Parameters::$templateRealization = 'default';
    Dune_Parameters::$templateSpace = $config->folder->page->templateSpace;
    Dune_Parameters::$templateRealization = $config->folder->page->templateRealization; 
    
    
    Dune_Variables::getFromIni($config);
    //Dune_Variables::$commandHandlerPage = 'default';
    //Dune_Variables::$commandHandlerAdmin = 'default';
    Dune_Variables::$commandHandlerPage = $config->folder->page->commandHandler;
    Dune_Variables::$commandHandlerAdmin = $config->folder->admin->commandHandler;
    
    //Dune_Variables::$commandNameAdmin = 'admin';
    Dune_Variables::$commandNameAdmin = $config->name->command->admin;
    
    //Dune_Data_Container_SubCommand::$commandSpace = 'default';
    
    //Dune_Data_Zend_Cache::$cache_dir = '_temp/cache';
    Dune_Data_Zend_Cache::$cache_dir = $config->folder->cache;
    
    Dune_Zend_Cache::$allowLoad = $config->allow->cache->load;
    Dune_Zend_Cache::$allowSave = $config->allow->cache->save;
    
    

Dune_Zend_View::$scriptPath = $_SERVER['DOCUMENT_ROOT'] . '/!_dune/_views/' . Dune_Parameters::$templateSpace;

/////////////////////////////////////////////////////////////////////       пїЅпїЅпїЅпїЅпїЅпїЅпїЅ

   
    
///////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////   пїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅ пїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅ пїЅпїЅпїЅпїЅпїЅпїЅпїЅ пїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅ. пїЅпїЅпїЅпїЅпїЅпїЅ.
///////////////////////////////////////////////////////////////////////////////////////////////////
  
//  Dune_Variables::$currentCommand = Dune_Objects::$command->getCommand();  
  
 // пїЅ пїЅпїЅпїЅпїЅпїЅ пїЅпїЅпїЅпїЅпїЅ пїЅпїЅпїЅпїЅпїЅпїЅпїЅ пїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅ пїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅ пїЅпїЅпїЅпїЅ, пїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅ пїЅпїЅпїЅпїЅпїЅпїЅ пїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅ пїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅ.
  Dune_Objects::$command = include(Dune_Parameters::$commandPath . '/' . $config->folder->page->command . '/config.php');
//  Dune_Objects::$command->setCommandFolder($config->folder->page->command);
  
  $folder = Dune_Data_Collector_UrlSingleton::getInstance();
  $folder->addFolder(Dune_Objects::$command->getCommand());
  
  $object_command_run = new Dune_Include_Command(Dune_Objects::$command, Dune_Variables::$userStatus);

  switch (true)
  {
      case $object_command_run->checkStatus(Dune_Include_Command::STATUS_EXIT):
          if (Dune_Parameters::$ajax)
          {
              Dune_Variables::$pageText =  '';
          }
          else 
          {
              header('Location: ' . Dune_Parameters::$pageInternalReferer);
              header("Cache-Control: no-store, no-cache, must-revalidate");
              header("Cache-Control: post-check=0, pre-check=0", false);
          }
//          Dune_BeforePageOut::make();                        
//          exit();
      break;
      case $object_command_run->checkStatus(Dune_Include_Command::STATUS_GOTO):
          if (Dune_Parameters::$ajax)
          {
              Dune_Variables::$pageText =  '';
          }
          else 
          {
              header('Location: ' . $object_command_run->getResult('goto'));
              header("Cache-Control: no-store, no-cache, must-revalidate");
              header("Cache-Control: post-check=0, pre-check=0", false);
          }
              
//          Dune_BeforePageOut::make();                        
//          exit();
      break;

      
      case $object_command_run->checkStatus(Dune_Include_Command::STATUS_ADMIN):
/////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////  пїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅ пїЅпїЅпїЅпїЅпїЅпїЅпїЅ
          Dune_Variables::$results = new Dune_Array_Container($object_command_run->getResults());
          include Dune_Parameters::$pathToAdmin . '/'. Dune_Variables::$commandHandlerAdmin . '/index.php';

////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////
      break;
      
      case $object_command_run->checkStatus(Dune_Include_Command::STATUS_PAGE):
/////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////  пїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅ пїЅпїЅпїЅпїЅ пїЅпїЅпїЅпїЅпїЅпїЅ пїЅпїЅ пїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅ
         Dune_Variables::$pageText =  $object_command_run->getOutput();
         Dune_Variables::$results = new Dune_Array_Container($object_command_run->getResults());
         if (Dune_Variables::$results->admin)
            include Dune_Parameters::$pathToAdmin . '/'. Dune_Variables::$commandHandlerAdmin . '/index.php';
         else 
            include Dune_Parameters::$pathToPage . '/' . Dune_Variables::$commandHandlerPage . '/index.php';

///////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////
      break;
      
      case $object_command_run->checkStatus(Dune_Include_Command::STATUS_TEXT):
          Dune_Variables::$pageText =  $object_command_run->getOutput();
      break;
      case $object_command_run->checkStatus(Dune_Include_Command::STATUS_NOACCESS):
          if (Dune_Parameters::$ajax)
          {
              Dune_Variables::$pageText =  '';
          }
          else 
          {
              Dune_Variables::$pageText =  $object_command_run->getOutput();
          }
      break;
      
      case $object_command_run->checkStatus(Dune_Include_Command::STATUS_AJAX):
          header("Content-type: text/plain; charset=windows-1251");
          header("Cache-Control: no-store, no-cache, must-revalidate");
          header("Cache-Control: post-check=0, pre-check=0", false);
          Dune_Variables::$pageText =  $object_command_run->getOutput();
      break;
  }

///////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////   пїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅ пїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅ пїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅ пїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅ. пїЅпїЅпїЅпїЅпїЅ
///////////////////////////////////////////////////////////////////////////////////////////////////
/*  if (Dune_Static_Message::$have)
  { 
      Dune_Objects::$pageTemplate->assign('message', Dune_Static_Message::$text);
  }
*/
//echo htmlspecialchars($templ->get());
  Dune_BeforePageOut::make();
  ob_clean();

  if (Dune_Objects::$pageTemplate and !Dune_Parameters::$ajax)
    $output =  Dune_Objects::$pageTemplate;
  else 
    $output =  Dune_Variables::$pageText;

    
//    $time = time();
    
/*  $files_array = Dune_AsArray_File_String::getInstance(Dune_Variables::$pathToArrayFiles);
  $files_array[$time] = $output;
*/
   
   if (false and (strpos($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip') !== false) and function_exists('gzencode'))
   {
    header("Content-Encoding: gzip");
    echo gzencode($output);
   }
   else 
    echo $output;
    
    	function print_array($var, $exit = false) {
    		echo '<pre>';
    		print_r($var);
    		echo '</pre>';
    		if($exit) exit;
    	}
