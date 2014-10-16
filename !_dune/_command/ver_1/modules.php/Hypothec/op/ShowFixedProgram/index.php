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
            		$program_data_have = true;
            		
        		}
        		else 
        		{
            		$program_data_array['bank_data'] = array();
            		$program_data_have = false;
        		}
    		}
    		
       		$sql = '
       				SELECT
       					*
       				FROM
       					hypothec_incconfirm_correspondence
       				WHERE
       					program_id  = ' . $programID->get();
        		
       		$result = mysql_query($sql, $dbConn);

       		if(mysql_num_rows($result) > 0)
       		{
       		    while ($row = mysql_fetch_assoc($result)) 
       		    {
       		    	$program_data_array['incconfirm_data'][] = $row;
       		    }
           		$program_data_array['incconfirm_data_have'] = true;
           		
//           		$test = new Dune_Test_Array($program_data_array['incconfirm_data']);
//           		$test->printPre();
       		}
       		else 
       		{
           		$program_data_array['incconfirm_data'] = array();
           		$program_data_have['incconfirm_data_have'] = false;
       		}


       		$sql = '
       				SELECT
       					*
       				FROM
       					hypothec_programs_expenses
       				WHERE
       					exp_id  = ' . $programID->get();
        		
       		$result = mysql_query($sql, $dbConn);

       		if(mysql_num_rows($result) > 0)
       		{
           		$program_data_array['expenses'] = mysql_fetch_assoc($result);
           		$program_data_array['expenses_have'] = true;
           		
//           		$test = new Dune_Test_Array($program_data_array['incconfirm_data']);
//           		$test->printPre();
       		}
       		else 
       		{
           		$program_data_array['expenses'] = array();
           		$program_data_array['expenses_have'] = false;
       		}
       		
       		
		} // Конец если была выбрана запись программы
		
		}

    if (!isset($program_data_array['name']))
        $program_data_array['name'] = 'Ипотечная программа не выбрана';
		
        
        
    $cr = Dune_Display_BreadCrumb::getInstance();
    $cr->addCrumb('Ипотечные программы', '/modules.php?name=Hypothec&op=ShowAllPrograms');
    $cr->addCrumb($program_data_array['name'], '');
		
	$pagetitle = $this->pagetitle;
	$module_name = $this->module_name;
	$bgcolor1 = $this->bgcolor1;
	$bgcolor2 = $this->bgcolor2;
	$bgcolor3 = $this->bgcolor3;
	
	if ($program_data_have)
	   $pagetitle = $program_data_array['name'];
	else 
	   $pagetitle = "Программа";


	//Menu("ShowFixedProgram");
	
	
	$view = Dune_Zend_View::getInstance();
	$view->assign('data_array', $program_data_array);
	$view->assign('data_have', $program_data_have);
	
	$view->assign('crumbs', $cr->getString('<p id="breadcrumb">', '</p>'));
	
	include '!_system/data/hypothec.php';
	
	$view->assign('data_specify_array', $hypothec);
	
	echo $view->render('hypothec:ShowFixedProgram');
	
	
	$this->results['pagetitle'] = $pagetitle;
	