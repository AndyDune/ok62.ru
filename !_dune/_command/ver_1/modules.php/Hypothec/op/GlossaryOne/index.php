<?php
    $get = Dune_Filter_Get_Total::getInstance();
	$dbConn = connectToDB();
    $module = new Dune_Include_Module('db:hypothec:glossary.get.one');
    $module->id = $get->getDigit('id', 0, 3);
    $module->make();
    
    $name = $module->getResult('name');
    $text = $module->getResult('text');


    $crumbs = Dune_Display_BreadCrumb::getInstance();
    $crumbs->addCrumb('Глоссарий', '/modules.php?name=Hypothec&op=Glossary');
    $crumbs->addCrumb($name);

	$pagetitle = $this->pagetitle;
	$module_name = $this->module_name;
	$bgcolor1 = $this->bgcolor1;
	$bgcolor2 = $this->bgcolor2;
	$bgcolor3 = $this->bgcolor3;
	
    $pagetitle = "Глоссарий. Определение " . $name;
	
	
//    print_array($words);
//    print_array($list);
	
    $view = Dune_Zend_View::getInstance();
    $view->assign('crumbs', $crumbs->getString('<p id="breadcrumb">', '</p>'));
    $view->assign('name', $name);
    $view->assign('text', $text);
    
    echo $view->render('hypothec:Glossary.one');
	
	$this->results['pagetitle'] = $pagetitle;
	