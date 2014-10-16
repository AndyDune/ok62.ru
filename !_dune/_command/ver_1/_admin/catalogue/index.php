<?php
/////       ÂÅÒÂÜ
///////////////////////////////
////     
///     Ãåíåğàëüíûé êàòàëîãà
///
    $folder_url = Dune_Data_Collector_UrlSingleton::getInstance();
    $currentCommand = $folder_url->getFolder();
	
    $crumbs = Dune_Display_BreadCrumb::getInstance();
    $crumbs->addCrumb('Íà÷àëî', $folder_url->get());
    
    $URL = Dune_Parsing_UrlSingleton::getInstance();

    $folder_name = new Dune_Data_Container_Folder($URL[3]);
    $folder_name->setPath(dirname(__FILE__));
    $folder_name->registerDefault('main');
    $folder_name->register('main');
    $folder_name->register('adress');
    $folder_name->register('object');
    $folder_name->check();

    $folder_url->addFolder($folder_name->getFolder());
    
    echo $folder = new Dune_Include_Folder($folder_name, Dune_Variables::$userStatus);
    
/*    $addd = new Special_Vtor_Adress();
    echo $addd;
    $addd->setArea(0);
    echo $addd;
    echo $addd->getAreaName();
    echo $addd->getSetQuery();
*/    
    $this->results = $folder->getResults();
    $this->status = $folder->getStatus();

	include 'menu.php';
	
    $view = Dune_Zend_View::getInstance();
    $view->assign('menu_left', $menu_left);
    $view->assign('command_admin', Dune_Variables::$commandNameAdmin);
    $view->assign('array_command', array(Dune_Variables::$commandNameAdmin, $currentCommand));
    
	$this->results['body_id'] = 'body_catalogue';
	
	$this->results['menu_left'] = $view->render('menu:left.first');