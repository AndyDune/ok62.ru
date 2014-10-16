<?php

	$pagetitle = $this->pagetitle;
	$module_name = $this->module_name;
	$bgcolor1 = $this->bgcolor1;
	$bgcolor2 = $this->bgcolor2;
	$bgcolor3 = $this->bgcolor3;
	
     $pagetitle = "Все банки";
	
	$dbConn = connectToDB();
//	$nukeSmarty = new NukeSmarty();
	$nukeSmarty = Dune_Zend_View::getInstance();
	$seedHypBank = new HypBank();
	
	$bank_smarty = array();
	$img_path="http://edinstvo62.ru/modules/Hypothec/images/";
	
	$banks = $seedHypBank->getBankList();
	foreach ($banks as $seedHypBank) {
		
		$programs = array();
		//$program_list = $seedHypBank->getProgramList();
		$program_count = $seedHypBank->getPProgramCount();
		if (!$program_count)
		  continue;
/*		foreach ($program_list as $seedProgram) {
			$programs[] = array(
								'ID' => $seedProgram->id,
								'NAME' => $seedProgram->name,
								);
		}
*/		
		$bank_smarty[] = array(
								'ID' => $seedHypBank->id,
								'NAME' => $seedHypBank->bankName,
								'LOGO_URL' => $seedHypBank->bankLogoUrl,
								'NOVOSTROI' => $seedHypBank->bankNovostroi,
								'VTOR' => $seedHypBank->bankVtor,
								'programs' => $program_count,
								);
	}
	
	
	$crumbs = Dune_Display_BreadCrumb::getInstance();
	
	$nukeSmarty->assign('crumbs', $crumbs->getString('<p id="breadcrumb">', '</p>'));
	
	$nukeSmarty->assign('banks', $bank_smarty);
	$nukeSmarty->assign('IMG_PATH', $img_path);
	
//	$nukeSmarty->assign('IS_INTERNET', IsInternet());
	
	echo $nukeSmarty->render('hypothec/Main');
	
	
	$this->results['pagetitle'] = $pagetitle;
	