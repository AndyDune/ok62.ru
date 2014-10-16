<?php

		global $dbConn;
		if(empty($dbConn)) $dbConn = connectToDB();

		$programID = Dune_Filter_Get_Digit::getInstance('programID');
		
        $program_data_array = array();
        $program_data_have = false;
		if ($programID->have())
		{

		$sql = '
				SELECT
					*
				FROM
					hypothec_programs
				WHERE
					id  = ' . $programID->get();
		
		$result = mysql_query($sql, $dbConn);
		$array_panorama_complex = array();
		if(mysql_num_rows($result) > 0)
		{
    		$program_data_array = mysql_fetch_assoc($result);
    		$program_data_have = true;
    		
    		if (!is_null($program_data_array['bank_id']) and $program_data_array['bank_id'])
    		{
        		$sql = '
        				SELECT
        					*
        				FROM
        					hypothec_bank
        				WHERE
        					id  = ' . $program_data_array['bank_id'];
        		
        		$result = mysql_query($sql, $dbConn);
        		$array_panorama_complex = array();
        		if(mysql_num_rows($result) > 0)
        		{
            		$program_data_array['bank_data'] = mysql_fetch_assoc($result);
            		$program_data_have['bank_data_have'] = true;
            		
        		}
        		else 
        		{
            		$program_data_array['bank_data'] = array();
            		$program_data_have['bank_data_have'] = false;
        		}
    		}
    		
		}
		
		}


	$pagetitle = $this->pagetitle;
	$module_name = $this->module_name;
	$bgcolor1 = $this->bgcolor1;
	$bgcolor2 = $this->bgcolor2;
	$bgcolor3 = $this->bgcolor3;
	
	if ($program_data_have)
	   $pagetitle = $program_data_array['name'];
	else 
	   $pagetitle = "Программа";


	Menu("ShowFixedProgram");
	
	
	$view = Dune_Zend_View::getInstance();
	$view->assign('data_array', $program_data_array);
	$view->assign('data_have', $program_data_have);
	
	include '!_system/data/hypothec.php';
	
	$view->assign('data_specify_array', $hypothec);
	
	echo $view->render('hypothec:ShowFixedProgram');
	
/*    $nukeSmarty = new NukeSmarty();
    
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
*/	
	
	$this->results['pagetitle'] = $pagetitle;
	