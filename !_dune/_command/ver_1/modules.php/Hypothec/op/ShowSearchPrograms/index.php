<?php
$nav_count_per_page = 20;
$get = Dune_Filter_Get_Total::getInstance();

    $crumbs = Dune_Display_BreadCrumb::getInstance();
    $crumbs->addCrumb('Поиск ипотечной программы', '/modules.php?name=Hypothec&op=SearchPrograms');
    $crumbs->addCrumb('Результаты поиска');

	$pagetitle = $this->pagetitle;
	$module_name = $this->module_name;
	$bgcolor1 = $this->bgcolor1;
	$bgcolor2 = $this->bgcolor2;
	$bgcolor3 = $this->bgcolor3;
	
$pagetitle = "Результаты поиска ипотечных программ";





////////////////////////////        Текст фильтра

//////////////////////////////////////////////////

//$f_order      = new Dune_Filter_Get_ValueAllow('order', 'pprogram_id', array('pprogram_id', 'rate_pp'));
//$f_order_mode = new Dune_Filter_Get_ValueAllow('order_mode', 'asc ', array('asc', 'desc'));

//session_start();
$o_session = Dune_Session::getInstance();
$o_session->openZone('hipose');

    foreach ($o_session as $key => $value)
    {
//////////////////////////////////////////        echo '<br />' . $key . ' = ' . $value;
        $data[$key] = $value;
    }


// Установка сортировки
/////////////////////////////////////////    
// Массив разрешенных
$array = array(
    'bank_id',
    'name_pp',
    'rate_pp',
    'creditperiod_pp',
    'firstpayment_pp',
    'currencyid_pp',
    'kinds_pp'
    );
// Обработка комманды на установку сортировки
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
    // Параметры для сортировки по умолчанию
    if (!$o_session->order_col_name)
        $o_session->order_col_name = 'name_pp';
    if (!$o_session->order_asc_desc)
        $o_session->order_asc_desc = 'asc';

$conditions = array();

//echo $o_session;

// Составление массива для передачи в модуль запроса к БД
if ($o_session->bank_id)
{
    $conditions[] = array(
                            'field' => 'p.bank_id',
                            'corr' => '=',
                            'digit' => 1,
                            'value' => $o_session->bank_id
                          );
}
if ($o_session->rate)
{
    $conditions[] = array(
                            'field' => 'pp.rate_pp',
                            'corr' => '<=',
                            'digit' => 1,
                            'value' => $o_session->rate
                          );
}

if ($o_session->firstpayment)
{
    $conditions[] = array(
                            'field' => 'pp.firstpayment_pp',
                            'corr' => '<=',
                            'digit' => 1,
                            'value' => $o_session->firstpayment
                          );
}

if ($o_session->currencyid and $o_session->currencyid != 'ALL')
{
    $conditions[] = array(
                            'field' => 'pp.currencyid_pp',
                            'corr' => '=',
                            'digit' => 0,
                            'value' => $o_session->currencyid
                          );
}
if ($o_session->age)
{
    $conditions[] = array(
                            'field' => 'p.agemin',
                            'corr' => '<=',
                            'digit' => 1,
                            'value' => $o_session->age
                          );
    $conditions[] = array(
                            'field' => 'p.agemax',
                            'corr' => '>=',
                            'digit' => 1,
                            'value' => $o_session->age
                          );
}
if ($o_session->paymenttypeid and $o_session->paymenttypeid  != 'ALL')
{
    $conditions[] = array(
                            'field' => 'p.paymenttypeid',
                            'corr' => '=',
                            'digit' => 0,
                            'value' => $o_session->paymenttypeid
                          );
}
if ($o_session->advrepay)
{
    $conditions[] = array(
                            'field' => 'p.advrepay',
                            'corr' => '<=',
                            'digit' => 1,
                            'value' => $o_session->advrepay
                          );
}

if ($o_session->registration and $o_session->registration  == 'NOTREQUIRED')
{
    $conditions[] = array(
                            'field' => 'p.registration',
                            'corr' => '<>',
                            'digit' => 0,
                            'value' => 'REQUIRED'
                          );
}
else if ($o_session->registration and $o_session->registration  != 'ALL')
{
    $conditions[] = array(
                            'field' => 'p.registration',
                            'corr' => '=',
                            'digit' => 0,
                            'value' => $o_session->registration
                          );
}

if ($o_session->nationality and $o_session->nationality  == 'NOTREQUIRED')
{
    $conditions[] = array(
                            'field' => 'p.nationality',
                            'corr' => '<>',
                            'digit' => 0,
                            'value' => 'REQUIRED'
                          );
}
else if ($o_session->nationality and $o_session->nationality  != 'ALL')
{
    $conditions[] = array(
                            'field' => 'p.nationality',
                            'corr' => '=',
                            'digit' => 0,
                            'value' => $o_session->nationality
                          );
}

if ($o_session->approveperiod)
{
    $conditions[] = array(
                            'field' => 'p.approveperiod',
                            'corr' => '<=',
                            'digit' => 1,
                            'value' => $o_session->approveperiod
                          );
}


if ($o_session->sumcredit)
{
    $conditions[] = array(
                            'field' => 'pp.sumcreditmin_pp',
                            'corr' => '<=',
                            'digit' => 1,
                            'value' => $o_session->sumcredit
                          );
    $conditions[] = array(
                            'field' => 'pp.sumcreditmax_pp',
                            'corr' => '>=',
                            'digit' => 1,
                            'value' => $o_session->sumcredit
                          );
                          
}
if ($o_session->creditperiodmin)
{
    $conditions[] = array(
                            'field' => 'pp.creditperiod_pp',
                            'corr' => '<=',
                            'digit' => 1,
                            'value' => $o_session->creditperiodmin
                          );
}
if ($o_session->creditperiodmax)
{
    $conditions[] = array(
                            'field' => 'pp.creditperiod_pp',
                            'corr' => '>=',
                            'digit' => 1,
                            'value' => $o_session->creditperiodmax
                          );
}
if ($o_session->loansecurityid and $o_session->loansecurityid  != 'ALL')
{
    $conditions[] = array(
                            'field' => 'p.loansecurityid ',
                            'corr' => '=',
                            'digit' => 0,
                            'value' => $o_session->loansecurityid
                          );
}


if ($o_session->kinds and $o_session->kinds  != 'NOLIMIT')
    $kinds = $o_session->kinds;
else 
    $kinds = false;

if ($o_session->incconfirmid and $o_session->incconfirmid  != 'ANY')
    $incconfirmid = $o_session->incconfirmid;
else 
    $incconfirmid = false;


$m_list = new Dune_Include_Module('db:hypothec:pprograms.list.search');


// Пепредача параметров для сортровки
$m_list->order_col_name = $o_session->order_col_name;
$m_list->asc_desc = $o_session->order_asc_desc;



$m_list->conditions = $conditions;

$m_list->kinds        = $kinds;
$m_list->incconfirmid = $incconfirmid;

$m_list->bank_id = $o_session->bank_id;

$m_list->offset = $get->getDigit('page') * $nav_count_per_page;
$m_list->count = $nav_count_per_page;


$m_list->make();


Data_Edinstvo_Hypothec::prepare();

$view = Dune_Zend_View::getInstance();
////////////////////////////////////////////////
//////////  Показывать ли вход на сравннеие
     $cooc = Dune_Cookie_ArraySingleton::getInstance('compare');
     if ($cooc->count())
         $view->assign('show_compare_button', $cooc->count());
     else 
         $view->assign('show_compare_button', 0);
     $view->assign('elected_id_array',$cooc);
///////////////////////////////////////////

// Передаём класс в вид.
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


/////////////////////////////////////////////////////////
//////////// Постраничная навигация
//$nav_count_per_page = 10;
$nav_count_total = $m_list->getResult('count');
if ($nav_count_total > $nav_count_per_page)
{
    $navigation = new Dune_Navigate_Page('/modules.php?name=Hypothec&op=ShowSearchPrograms&page=', $nav_count_total, $get->getDigit('page'));
    $view->assign('navigation', $navigation->getNavigator());
    //echo $navigation->getNavigator();
}
//////////
//////////////////////////////////////////////////////////



	$view->assign('crumbs', $crumbs->getString('<p id="breadcrumb">', '</p>'));

$view->assign('bank_id',$o_session->bank_id);
$view->assign('rate_pp',$o_session->rate_pp);
$view->assign('firstpayment_pp',$o_session->firstpayment_pp);
$view->assign('currencyid_pp',$o_session->currencyid_pp);


$view->assign('array',$m_list->getResult('array'));
$view->assign('banks',$m_list->getResult('banks'));
$view->assign('data_specify_array', Data_Edinstvo_Hypothec::$hypothec);
echo $view->render('hypothec:ShowSearchPrograms');
