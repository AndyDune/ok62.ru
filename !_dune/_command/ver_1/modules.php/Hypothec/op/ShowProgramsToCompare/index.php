<?php

    $crumbs = Dune_Display_BreadCrumb::getInstance();
    $ref = new Dune_String_Referer();
    if ($ref->haveSubString('modules.php?name=Hypothec&op=CalculationList'))// �� ������ ���������� ������ �������
    {
        $crumbs->addCrumb(Data_Edinstvo_Names::$broker, '/modules.php?name=Hypothec&op=Calculation');
        $crumbs->addCrumb('������ ��������� ��������', $_SERVER['HTTP_REFERER']);
    }
    else 
    {
        $crumbs->addCrumb('��������� ���������', '/modules.php?name=Hypothec&op=ShowAllPrograms');
    }
    $crumbs->addCrumb('������ ������������ ��������');

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
// ������ �����������
$array = array(
    'bank_id',
    'name_pp',
    'rate_pp',
    'creditperiod_pp',
    'firstpayment_pp',
    'currencyid_pp',
    'kinds_pp'
    );
// ��������� �������� �� ��������� ����������
if ($get->have('_do_'))
{
    switch ($get->_do_)
    {
        case 'order':
            if (!$o_session->order_asc_desc)
                $o_session->order_asc_desc = 'asc';
            else if ($o_session->order_col_name != $get->col_name)
                $o_session->order_asc_desc = 'asc';
            else 
            {
                if ($o_session->order_asc_desc == 'asc')
                    $o_session->order_asc_desc = 'desc';
                else 
                    $o_session->order_asc_desc = 'asc';
            }
            if (key_exists($get->col_name, $array));
            {
                $o_session->order_col_name = $get->col_name;
            }
    }    
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    //header('Location: /modules.php?name=Hypothec&op=ShowSearchPrograms');
    $this->results['exit'] = 'exit';
}
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



$m_list = new Dune_Include_Module('db:hypothec:pprograms.list.compare');
$m_list->conditions = $cooc->getArray();

// ��������� ���������� ��� ���������
$m_list->order_col_name = $o_session->order_col_name;
$m_list->asc_desc = $o_session->order_asc_desc;

$m_list->make();


Data_Edinstvo_Hypothec::prepare();

$view = Dune_Zend_View::getInstance();


///////////////////////////////////////////
// ������� ����� � ���.
switch ($o_session->order_col_name) {
	case 'sumcreditmax_pp':
	    if ($o_session->order_asc_desc == 'asc')
	       $view->assign('sumcreditmax_pp_class', 'order-up');
	    else 
	       $view->assign('sumcreditmax_pp_class','order-down');
	break;
	case 'sumcreditmin_pp':
	    if ($o_session->order_asc_desc == 'asc')
	       $view->assign('sumcreditmin_pp_class', 'order-up');
	    else 
	       $view->assign('sumcreditmin_pp_class','order-down');
	break;
	case 'name_pp':
	    if ($o_session->order_asc_desc == 'asc')
	       $view->assign('name_pp_class', 'order-up');
	    else 
	       $view->assign('name_pp_class','order-down');
	break;
	case 'rate_pp':
	    if ($o_session->order_asc_desc == 'asc')
	       $view->assign('rate_pp_class', 'order-up');
	    else 
	       $view->assign('rate_pp_class','order-down');
	break;
	case 'creditperiod_pp':
	    if ($o_session->order_asc_desc == 'asc')
	       $view->assign('creditperiod_pp_class', 'order-up');
	    else 
	       $view->assign('creditperiod_pp_class','order-down');
	break;
	case 'firstpayment_pp':
	    if ($o_session->order_asc_desc == 'asc')
	       $view->assign('firstpayment_pp_class', 'order-up');
	    else 
	       $view->assign('firstpayment_pp_class','order-down');
	break;
	case 'currencyid_pp':
	    if ($o_session->order_asc_desc == 'asc')
	       $view->assign('currencyid_pp_class', 'order-up');
	    else 
	       $view->assign('currencyid_pp_class','order-down');
	break;
	case 'kinds_pp':
	    if ($o_session->order_asc_desc == 'asc')
	       $view->assign('kinds_pp_class', 'order-up');
	    else 
	       $view->assign('kinds_pp_class','order-down');
	break;
	
	default:
	break;
}

////////////////////////////////////////////////
//////////  ���������� �� ���� �� ���������
     if ($cooc->count())
         $view->assign('show_compare', 1);
     else 
         $view->assign('show_compare', 0);
///////////////////////////////////////////


    $session = Dune_Session::getInstance();
    $session->openZone('master');
    $view->assign('age',$session->age);
    $session->closeZone();


	$view->assign('crumbs', $crumbs->getString('<p id="breadcrumb">', '</p>'));


$view->assign('array',$m_list->getResult('array'));
$view->assign('banks',$m_list->getResult('banks'));
$view->assign('data_specify_array', Data_Edinstvo_Hypothec::$hypothec);
echo $view->render('hypothec:ShowProgramsToCompare');
