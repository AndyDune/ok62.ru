<?php
	$currentCommand = 'total';
	
//    echo '<h1>Подключена субкомманда</h1>';
/*    
	include 'menu.php';
	
    $view = Dune_Zend_View::getInstance();
    $view->assign('menu_left', $menu_left);
    $view->assign('command_admin', Dune_Variables::$commandNameAdmin);
    $view->assign('array_command', array(Dune_Variables::$commandNameAdmin, $currentCommand));
        
	$this->results['body_id'] = 'body_total';
	
	$this->results['menu_left'] = $view->render('menu:left.first');
*/	
	
	
/////       ВЕТВЬ
///////////////////////////////
////     
///
	$URL = Dune_Parsing_UrlSingleton::getInstance();
	
    $crumbs = Dune_Display_BreadCrumb::getInstance();
    $crumbs->addCrumb('Начало', $URL->getCommandString());
    

    $folder_name = new Dune_Data_Container_Folder($URL[3]);
    $folder_name->setPath(dirname(__FILE__));
    $folder_name->registerDefault('statistics');
    $folder_name->register('statistics');
    $folder_name->register('cache');
    $folder_name->register('db');
    $folder_name->check();

    
    echo $folder = new Dune_Include_Folder($folder_name, Dune_Variables::$userStatus);
    $this->results = $folder->getResults();
    
	include 'menu.php';
	
    $view = Dune_Zend_View::getInstance();
    $view->assign('menu_left', $menu_left);
    $view->assign('command_admin', Dune_Variables::$commandNameAdmin);
    $view->assign('array_command', array(Dune_Variables::$commandNameAdmin, $currentCommand));
    
	$this->results['body_id'] = 'body_total';
	
	$this->results['menu_left'] = $view->render('menu:left.first');	
	
    $this->setStatus($folder->getStatus());
    
	