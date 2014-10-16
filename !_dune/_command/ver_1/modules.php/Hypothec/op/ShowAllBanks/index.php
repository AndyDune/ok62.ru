<?php
    $crumbs = Dune_Display_BreadCrumb::getInstance();
    $crumbs->addCrumb('Банки');

	$pagetitle = $this->pagetitle;
	$module_name = $this->module_name;
	$bgcolor1 = $this->bgcolor1;
	$bgcolor2 = $this->bgcolor2;
	$bgcolor3 = $this->bgcolor3;

     $pagetitle = "Все банки";

	$dbConn = connectToDB();
	//$nukeSmarty = new NukeSmarty();
	$nukeSmarty = Dune_Zend_View::getInstance();
	$seedHypBank = new HypBank();
	
	$bank_smarty = array();
	
	$img_path="/modules/Hypothec/images/";
	
	$img_path = $this->img_path;
	
	$banks = $seedHypBank->getBankList();
	foreach ($banks as $seedHypBank) {
		
		$programs = array();
		//$program_list = $seedHypBank->getProgramList();
		$program_count = $seedHypBank->getPProgramCount();
		
		if (HYPOTHEC_SHOW_ALL_BANKS or $program_count)
		{
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
	}
	
	
	$nukeSmarty->assign('banks', $bank_smarty);
	$nukeSmarty->assign('IMG_PATH', $img_path);
	$nukeSmarty->assign('crumbs', $crumbs->getString('<p id="breadcrumb">', '</p>'));
	
	$nukeSmarty->assign('IS_INTERNET', IsInternet());
	
	
//	$nukeSmarty->display('modules/Hypothec/templates/ShowAllBanks_plus.tpl');
	
	echo $nukeSmarty->render('hypothec/ShowAllBanks_plus');
	
	$this->results['pagetitle'] = $pagetitle;
	