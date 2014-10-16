<?php

	$pagetitle = $this->pagetitle;
	$module_name = $this->module_name;
	$bgcolor1 = $this->bgcolor1;
	$bgcolor2 = $this->bgcolor2;
	$bgcolor3 = $this->bgcolor3;
	
     $pagetitle = "Строим вместе";
	
//	$nukeSmarty = new NukeSmarty();
	$nukeSmarty = Dune_Zend_View::getInstance();
	$seedHypBank = new HypBank();
	
	$bank_smarty = array();
	$img_path="http://edinstvo62.ru/modules/Hypothec/images/";
	
	
	$crumbs = Dune_Display_BreadCrumb::getInstance();
	$crumbs->addCrumb('Льготная ипотека', '/modules.php?name=Hypothec&op=Privilege');
	$crumbs->addCrumb('&quot;Строим вместе&quot;');
	
	$nukeSmarty->assign('crumbs', $crumbs->getString('<p id="breadcrumb">', '</p>'));
	
	$nukeSmarty->assign('IMG_PATH', $img_path);
	
	
	echo $nukeSmarty->render('hypothec/StroimVmeste');
	
	
	$this->results['pagetitle'] = $pagetitle;
	