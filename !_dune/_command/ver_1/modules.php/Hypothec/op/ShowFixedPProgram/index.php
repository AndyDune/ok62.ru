<?php
    Data_Edinstvo_Hypothec::prepare();

	$pagetitle = $this->pagetitle;
	$module_name = $this->module_name;
	$bgcolor1 = $this->bgcolor1;
	$bgcolor2 = $this->bgcolor2;
	$bgcolor3 = $this->bgcolor3;


		global $dbConn;
		if(empty($dbConn)) $dbConn = connectToDB();

		$programID = Dune_Filter_Get_Digit::getInstance('programID');
		
    $m_list = new Dune_Include_Module('db:hypothec:pprograms.info.one');
    $m_list->id = $programID->get();
    $m_list->make();
		
$kinds_corr = $m_list->getResult('kinds_corr');
$info = $m_list->getResult('info');
$incconfirm_corr = $m_list->getResult('incconfirm_corr');
    
    if (!$info->count())
        $program_data_array['name'] = '��������� ��������� �� �������';
/*		
echo $info;
echo $kinds_corr;
echo $incconfirm_corr;
*/        
        
    $cr     = Dune_Display_BreadCrumb::getInstance();
    
// ������, ����� ������� �� ��������
    $cr = Dune_Display_BreadCrumb::getInstance();
    $ref = new Dune_String_Referer();
    if ($ref->haveSubString('modules.php?name=Hypothec&op=ShowSearchPrograms')) // �� ������ ���������� ������
    {
        $cr->addCrumb('�����', '/modules.php?name=Hypothec&op=ShowSearchPrograms');
        $cr->addCrumb('������ ��������� ��������', $_SERVER['HTTP_REFERER']);
    }
    else if ($ref->haveSubString('modules.php?name=Hypothec&op=MasterForProgramList'))// �� ������ ���������� ������ �������
    {
        $cr->addCrumb('������ �������', '/modules.php?name=Hypothec&op=MasterForProgram');
        $cr->addCrumb('������ ��������� ��������', $_SERVER['HTTP_REFERER']);
    }
    else if ($ref->haveSubString('modules.php?name=Hypothec&op=CalculationList'))// �� ������ ���������� ������ �������
    {
        $cr->addCrumb(Data_Edinstvo_Names::$broker, '/modules.php?name=Hypothec&op=Calculation');
        $cr->addCrumb('������ ��������� ��������', $_SERVER['HTTP_REFERER']);
    }
   
    else if ($ref->haveSubString('modules.php?name=Hypothec&op=Calculation'))// �� ������ ���������� ������ �������
    {
        $cr->addCrumb(Data_Edinstvo_Names::$broker, '/modules.php?name=Hypothec&op=Calculation');
    }
    
    else 
        $cr->addCrumb('��������� ���������', '/modules.php?name=Hypothec&op=ShowAllPrograms');
    
    $cr->addCrumb('�������� ���������');
    
	$view = Dune_Zend_View::getInstance();
	$view->assign('crumbs', $cr->getString('<p id="breadcrumb">', '</p>'));
	$view->assign('data_specify_array', Data_Edinstvo_Hypothec::$hypothec);
	
	$view->assign('info',$info);
	$view->assign('kinds_corr',$kinds_corr);
	$view->assign('incconfirm_corr',$incconfirm_corr);
	
	

    $expenses = array();
	$expenses_have = false;
	
    if ($info->count())
    {	
	
       		$sql = '
       				SELECT
       					*
       				FROM
       					hypothec_programs_expenses
       				WHERE
       					exp_id  = ' . $info->program_id;
        		
       		$result = mysql_query($sql, $dbConn);

       		if(mysql_num_rows($result) > 0)
       		{
           		$expenses = mysql_fetch_assoc($result);
           		$expenses_have = true;
           		
       		}
    }
    $session = Dune_Session::getInstance();
    $session->openZone('master');
    $view->assign('age',$session->age);
    $session->closeZone();
    
    $view->assign('expenses',$expenses);
	$view->assign('expenses_have',$expenses_have);
	
	
	echo $view->render('hypothec:ShowFixedPProgram');
    
    
/*		
	if ($program_data_have)
	   $pagetitle = $program_data_array['name'];
	else 
	   $pagetitle = "���������";


	//Menu("ShowFixedProgram");
	
	
	$view = Dune_Zend_View::getInstance();
	$view->assign('data_array', $program_data_array);
	$view->assign('data_have', $program_data_have);
	
	$view->assign('crumbs', $cr->getString('<p id="breadcrumb">', '</p>'));
	
	
	$view->assign('data_specify_array', Data_Edinstvo_Hypothec::$hypothec);
	
	echo $view->render('hypothec:ShowFixedPProgram');
*/	
	
	$this->results['pagetitle'] = $pagetitle;
	