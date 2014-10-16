<?php

    
    $crumbs = Dune_Display_BreadCrumb::getInstance();
    $crumbs->addCrumb('Глоссарий');

	$pagetitle = $this->pagetitle;
	$module_name = $this->module_name;
	$bgcolor1 = $this->bgcolor1;
	$bgcolor2 = $this->bgcolor2;
	$bgcolor3 = $this->bgcolor3;
	
    $pagetitle = "Глоссарий";
	
	$dbConn = connectToDB();
    
    $module = new Dune_Include_Module('db:hypothec:glossary.get.list.prewiew');
    $module->make();
    
    $list = $module->getResult('array');
    $words = $module->getResult('words');
		
//    print_array($words);
//    print_array($list);
	
    $view = Dune_Zend_View::getInstance();
    $view->assign('crumbs', $crumbs->getString('<p id="breadcrumb">', '</p>'));
    $view->assign('list', $list);
    $view->assign('words', $words);
    
    echo $view->render('hypothec:Glossary.prewiew');
	
	$this->results['pagetitle'] = $pagetitle;
	