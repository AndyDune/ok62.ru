<?php
/////////////////////////////////////////////////////////////////////////////////////////
/////////////
/////////////       Геекральный файл команды админки
/////////////
/////////////////////////////////////////////////////////////////////////////////////////
	Dune_Parameters::$templateSpace = Dune_Parameters::$templateSpaceAdmin;  
	Dune_Parameters::$templateRealization = Dune_Parameters::$templateRealizationAdmin;
	Dune_Zend_View::$scriptPath = $_SERVER['DOCUMENT_ROOT'] . '/!_dune/_views/' . Dune_Parameters::$templateSpace;
	
    // Заглушка на доступ	
	if (Dune_Variables::$userStatus < 500)
	{
	    echo '/';
	    $this->status = Dune_Include_Command::STATUS_GOTO;
	    return;
	}
//////////////
/////////////////////////////////////////////////////////////////////////////////////////

// Команда настроек пользователя

    $URL = Dune_Parsing_UrlSingleton::getInstance();

    $folder_name = new Dune_Data_Container_Folder($URL[2]);
    //$folder_name->setPath($_folder);
    $folder_name->setPath(dirname(__FILE__));
    $folder_name->registerDefault('total');
    $folder_name->register('total');
    $folder_name->register('catalogue');
    $folder_name->check();

    $folder_url = Dune_Data_Collector_UrlSingleton::getInstance();
    $folder_url->addFolder($folder_name->getFolder());

    echo $folder = new Dune_Include_Folder($folder_name, Dune_Variables::$userStatus);
    
    //echo $folder->getResult('menu_left');
    
    $this->results = $folder->getResults();
    $this->status = $folder->getStatus();

    
/////////////////////////////////////////////////////////////////////////////////////////    
///////      Это была админка    
$this->results['admin'] = true;