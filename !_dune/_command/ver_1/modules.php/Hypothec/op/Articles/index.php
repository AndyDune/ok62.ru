<?php

    
    $crumbs = Dune_Display_BreadCrumb::getInstance();
    $crumbs->addCrumb('Статьи');

	$pagetitle = $this->pagetitle;
	$module_name = $this->module_name;
	$bgcolor1 = $this->bgcolor1;
	$bgcolor2 = $this->bgcolor2;
	$bgcolor3 = $this->bgcolor3;
	
     $pagetitle = "Статьи";
	
	$dbConn = connectToDB();
    
    $m_list = new Dune_Include_Module('db:hypothec:articles.list.all');
    $m_list->make();
    
    $list = $m_list->getResult('list');
		
	
    $view = Dune_Zend_View::getInstance();
    $view->assign('crumbs', $crumbs->getString('<p id="breadcrumb">', '</p>'));
    $view->assign('list', $list);
    
    echo $view->render('hypothec:ArticlesList');
	
	$this->results['pagetitle'] = $pagetitle;
	