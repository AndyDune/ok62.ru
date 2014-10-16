<?php
    $crumbs = Dune_Display_BreadCrumb::getInstance();
    $crumbs->addCrumb('������', '/modules.php?name=Hypothec&op=Articles');

	$pagetitle = $this->pagetitle;
	$module_name = $this->module_name;
	$bgcolor1 = $this->bgcolor1;
	$bgcolor2 = $this->bgcolor2;
	$bgcolor3 = $this->bgcolor3;
	
	
	$dbConn = connectToDB();
    
	$id = Dune_Filter_Get_Digit::getInstance('id');
    $m_list = new Dune_Include_Module('db:hypothec:articles.read');
    $m_list->id = $id->get();
    $m_list->make();
    
    $info = $m_list->getResult('info');
		
    $crumbs->addCrumb($info->name);
    $pagetitle = $info->name;
	
    $view = Dune_Zend_View::getInstance();
    $view->assign('crumbs', $crumbs->getString('<p id="breadcrumb">', '</p>'));
    $view->assign('info', $info);
    
    echo $view->render('hypothec:ArticleRead');
	
	$this->results['pagetitle'] = $pagetitle;
	