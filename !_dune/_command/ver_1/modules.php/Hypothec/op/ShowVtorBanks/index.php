<?php

	$pagetitle = $this->pagetitle;
	$module_name = $this->module_name;
	$bgcolor1 = $this->bgcolor1;
	$bgcolor2 = $this->bgcolor2;
	$bgcolor3 = $this->bgcolor3;
	
     $pagetitle = "Банки - вторичка";


      Menu("ShowVtorBanks");
	
	$dbConn = connectToDB();
	$nukeSmarty = new NukeSmarty();
	$seedHypBank = new HypBank();
	
	$bank_smarty = array();
	$img_path="/modules/Hypothec/images/";
	
	$banks = $seedHypBank->getVtorBankList();
	foreach ($banks as $seedHypBank) {
		
		$programs = array();
		$program_list = $seedHypBank->getProgramList();
		foreach ($program_list as $seedProgram) {
			$programs[] = array(
								'ID' => $seedProgram->id,
								'NAME' => $seedProgram->name,
								);
		}
		
		$bank_smarty[] = array(
								'ID' => $seedHypBank->id,
								'NAME' => $seedHypBank->bankName,
								'LOGO_URL' => $seedHypBank->bankLogoUrl,
								'NOVOSTROI' => $seedHypBank->bankNovostroi,
								'VTOR' => $seedHypBank->bankVtor,
								'programs' => $programs,
								);
	}
	
	
	$nukeSmarty->assign('banks', $bank_smarty);
	$nukeSmarty->assign('IMG_PATH', $img_path);
	
	$nukeSmarty->assign('IS_INTERNET', IsInternet());
	
	$nukeSmarty->display('modules/Hypothec/templates/ShowVtorBanks.tpl');
	
	
	$this->results['pagetitle'] = $pagetitle;
	