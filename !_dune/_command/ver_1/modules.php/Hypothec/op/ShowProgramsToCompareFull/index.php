<?php
    Data_Edinstvo_Hypothec::prepare();
    
    $crumbs = Dune_Display_BreadCrumb::getInstance();
    $crumbs->addCrumb('��������� ���������', '/modules.php?name=Hypothec&op=ShowAllPrograms');
    $crumbs->addCrumb('������ ������������ ��������', '/modules.php?name=Hypothec&op=ShowProgramsToCompare');
    $crumbs->addCrumb('��������� ���� ����������');

	$pagetitle = $this->pagetitle;
	$module_name = $this->module_name;
	$bgcolor1 = $this->bgcolor1;
	$bgcolor2 = $this->bgcolor2;
	$bgcolor3 = $this->bgcolor3;
	
    $pagetitle = "��������� ���������. ������ ��� ���������";




    $o_session = Dune_Session::getInstance();
    $o_session->openZone('compare');
    $get = Dune_Filter_Get_Total::getInstance();

// ��������� ����������
/////////////////////////////////////////    
    // ��������� ��� ���������� �� ���������
    if (!$o_session->order_col_name)
        $o_session->order_col_name = 'name_pp';
    if (!$o_session->order_asc_desc)
        $o_session->order_asc_desc = 'asc';


//////////////////////////////////////////////////
////////////////////////////////////////////////
//////////  ���� �� ����������
     $cooc = Dune_Cookie_ArraySingleton::getInstance('compare');
     //Dune_BeforePageOut::registerObject($cooc);
///////////////////////////////////////////


// ���������� ���� ������ ���������� ��������
    $m_list = new Dune_Include_Module('db:hypothec:pprograms.list.compare.full');
    $m_list->conditions = $cooc->getArray();
    
// ��������� ���������� ��� ���������
    $m_list->order_col_name = $o_session->order_col_name;
    $m_list->asc_desc = $o_session->order_asc_desc;
    $m_list->make();

    
    $programs_list_array = $m_list->getResult('array');
    
    
    //print_array($programs_list_array);
    

// ����� ����    
    $view = Dune_Zend_View::getInstance();

// ������� ������
	$view->assign('crumbs', $crumbs->getString('<p id="breadcrumb">', '</p>'));

// ����� ��������
    $view->assign('programs_list', $programs_list_array);
    
//    $array = $programs_list_array[1];
//    $view->assign('info', $array);

    $session = Dune_Session::getInstance();
    $session->openZone('master');
    $view->assign('age',$session->age);
    $session->closeZone();


    $view->assign('banks',$m_list->getResult('banks'));
    $view->assign('data_specify_array', Data_Edinstvo_Hypothec::$hypothec);
    echo $view->render('hypothec:ShowProgramsToCompareFull');
