<?php

	$pagetitle = $this->pagetitle;
	$module_name = $this->module_name;
	$bgcolor1 = $this->bgcolor1;
	$bgcolor2 = $this->bgcolor2;
	$bgcolor3 = $this->bgcolor3;
	
	$pagetitle = "Программа";


	Menu("ShowFixedProgram");
	$dbConn = connectToDB();
    $nukeSmarty = new NukeSmarty();
    
	$focusProgram = new HypProgram();
	$focusProgram->retrieve($_GET['programID']);
	$focusProgram->initBank();
	$img_path="/modules/Hypothec/images/";
	
	
	$parameters = array();
	
	$program_smarty = array(
							'ID' => $focusProgram->id,
							'NAME' => $focusProgram->name,
							'BANK_ID' => $focusProgram->bank_id,
							'BONUS' => $focusProgram->bonus,
							'URL' => $focusProgram->url,
							'BANK_ID' => $focusProgram->bank->id,
							'BANK_NAME' => $focusProgram->bank->bankName,
							'BANK_LOGO_URL' => $focusProgram->bank->bankLogoUrl,
							'parameters' => $focusProgram->getProgramParamList(),
							);

	$nukeSmarty->assign('program', $program_smarty);
	$nukeSmarty->assign('IMG_PATH', $img_path);
	
	$nukeSmarty->assign('IS_INTERNET', IsInternet());
     
	$nukeSmarty->display('modules/Hypothec/templates/ShowFixedProgram.tpl');
	
	
	$this->results['pagetitle'] = $pagetitle;
	