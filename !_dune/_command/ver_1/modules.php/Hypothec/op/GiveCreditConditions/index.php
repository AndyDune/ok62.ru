<?php

	$pagetitle = $this->pagetitle;
	$module_name = $this->module_name;
	$bgcolor1 = $this->bgcolor1;
	$bgcolor2 = $this->bgcolor2;
	$bgcolor3 = $this->bgcolor3;
	
	
	$pagetitle = "Условия кредитов";

     
    Menu("GiveCreditConditions");

    $show_info_smarty = false;
    if(isset($_POST['choise']) and count($_POST['choise'])) {
    	$show_info_smarty = true;
    }
    
    $dbConn = connectToDB();
    $img_path="/modules/Hypothec/images/";
    
    $nukeSmarty = new NukeSmarty();
    $seedHypBank = new HypBank();
    //$seedHypProgram = new HypProgram();
    $seedHypCondition = new HypCondition();
    
	$banks = array();
	if(isset($_POST['choise']) and count($_POST['choise'])) {
		foreach ($_POST['choise'] as $bankID => $val) {
			$seedHypBank = new HypBank();
			$seedHypBank->retrieve($bankID);
			$banks[] = $seedHypBank;
		}
	}
	
	
	
    $array = array();
    foreach ($_POST['choise'] as $key => $val) {
    	$array[] = $key;
    }
   //print_array($array);
	$conditions = $seedHypCondition->getCondList($array);
	//print_array($conditions);
    $conditions_smarty = array();
    $banks_smarty = array();
     
    // Получаем все банки для множественного выбора
	$banks_list = $seedHypBank->getBankList();
    $banks_list_smarty = array();
    foreach ($banks_list as $seedHypBank) {
		$bank_checked = false;
		if(isset($_POST['choise'][$seedHypBank->id])) {
			$bank_checked = true;
		}
		
    	$banks_list_smarty[] = array(
    									'ID' => $seedHypBank->id,
    									'NAME' => $seedHypBank->bankName,
	     								'CHECKED' => $bank_checked,
	     								'LOGO_URL' => $seedHypBank->bankLogoUrl,
    									);
    }
    
    
    
    foreach ($conditions as $seedHypCondition) {
     	
    	$banks_array = array();
     	$cond_bank_values = $seedHypCondition->getBankCondList();
     	
//     	print_array($cond_bank_values);
     	foreach ($banks as $seedHypBank) {
     	
     		
			$banks_array[] = array (
	     								'ID' => $seedHypBank->id,
	     								'NAME' => $seedHypBank->bankName,
	     								'VALUE' => $cond_bank_values[$seedHypBank->id]['BANK_VALUE'],
	     								'LOGO_URL' => $cond_bank_values[$seedHypBank->id]['BANK_LOGO_URL'],
     								);
     	}
     	
     	
     	$conditions_smarty[] = array(
     									'ID' => $seedHypCondition->id,
     									'NAME' => $seedHypCondition->name,
     									'banks' => $banks_array,
     								);
     	
	}
     
	foreach ($banks as $seedHypBank) {
		
     	
		$banks_smarty[] = array (
	     								'ID' => $seedHypBank->id,
	     								'NAME' => $seedHypBank->bankName,
	     								'LOGO_URL' => $seedHypBank->bankLogoUrl,
     								);
	}
	$nukeSmarty->assign('SHOW_INFO', $show_info_smarty);
	$nukeSmarty->assign('conditions', $conditions_smarty);
	$nukeSmarty->assign('banks', $banks_smarty);
	$nukeSmarty->assign('banks_list', $banks_list_smarty);
	$nukeSmarty->assign('IMG_PATH', $img_path);
	
	$nukeSmarty->assign('IS_INTERNET', IsInternet());
	
	
	$nukeSmarty->display('modules/Hypothec/templates/FORMGiveCreditConditions.tpl');	
	
	$this->results['pagetitle'] = $pagetitle;
	