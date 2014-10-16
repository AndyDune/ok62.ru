<?php
$nav_count_per_page = 20;

$post = Dune_Filter_Post_Total::getInstance();
$get = Dune_Filter_Get_Total::getInstance();


    $crumbs = Dune_Display_BreadCrumb::getInstance();
    $crumbs->addCrumb(Data_Edinstvo_Names::$broker, '/modules.php?name=Hypothec&op=Calculation');
    $crumbs->addCrumb('Ипотечные программы');

	$pagetitle = $this->pagetitle;
	$module_name = $this->module_name;
	$bgcolor1 = $this->bgcolor1;
	$bgcolor2 = $this->bgcolor2;
	$bgcolor3 = $this->bgcolor3;
	
$pagetitle = "Ипотечные программы по результатам работы ипотечного брокера";




////////////////////////////        Текст фильтра
//////////////////////////////////////////////////

$f_order      = new Dune_Filter_Get_ValueAllow('order', 'pprogram_id', array('pprogram_id', 'rate_pp'));
$f_order_mode = new Dune_Filter_Get_ValueAllow('order_mode', 'asc ', array('asc', 'desc'));

//session_start();
$version = $get->version;
if (!$version)
{
    $version = $post->version;
}
if (!$version)
{
    $version = uniqid();
}

    $session_name = 'calculation_' . $version;

$o_session = Dune_Session::getInstance($session_name);
$sql_filter = $o_session->sql_filter;
$sql_count = $o_session->count;
$age = $o_session->age;
$o_session->openZone('hipo');

if ($post->have('_do_'))
{
    $o_session->killZone();
    $o_session->bank_id = $post->getDigit('bank_id', 0);
    $o_session->rate_pp = $post->getDigit('rate_pp', 0, 5);
    $o_session->firstpayment_pp = $post->getDigit('firstpayment_pp', 0, 5);
    $o_session->currencyid_pp = $post->getHtmlSpecialChars('currencyid_pp', 'RUR', 5);
    
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    $this->results['exit'] = 'exit';
    
}
else if ($get->check('_do_'))
{
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
//    header('Location: ' . $_SERVER['HTTP_REFERER']);
    //header('Location: /modules.php?name=Hypothec&op=ShowSearchPrograms');
//    $this->results['exit'] = 'exit';
    throw new Dune_Exception_Control_Goto();
    
}
else 
{
        // Параметры для сортировки по умолчанию
    if (!$o_session->order_col_name)
        $o_session->order_col_name = 'name_pp';
    if (!$o_session->order_asc_desc)
        $o_session->order_asc_desc = 'asc';

 //echo $o_session;


//$m_list = new Dune_Include_Module('db:hypothec:pprograms.list.calculation');
$m_list = new Module_Hypo_PaymentCalculationList();
$m_list->session_name = $session_name;

// Пепредача параметров для сортровки
$m_list->order_col_name = $o_session->order_col_name;
$m_list->asc_desc = $o_session->order_asc_desc;

$m_list->sql_filter = $sql_filter;

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
$nav_count_total = $sql_count;
if ($nav_count_total > $nav_count_per_page)
{
    $navigation = new Dune_Navigate_Page('/modules.php?name=Hypothec&op=CalculationList&version=' . $version . '&page=', $nav_count_total, $get->getDigit('page'), $nav_count_per_page);
    $view->assign('navigation', $navigation->getNavigator('special'));
    //echo $navigation->getNavigator();
}
//////////
//////////////////////////////////////////////////////////

	$view->assign('crumbs', $crumbs->getString('<p id="breadcrumb">', '</p>'));

	
     $view->assign('elected_id_array',$cooc);
	
	
$view->assign('bank_id',$o_session->bank_id);
$view->assign('rate_pp',$o_session->rate_pp);
$view->assign('firstpayment_pp',$o_session->firstpayment_pp);
$view->assign('currencyid_pp',$o_session->currencyid_pp);

$view->assign('age', $age);


$view->assign('version', $version);

$view->assign('array',$m_list->getResult('array'));
$view->assign('data_specify_array', Data_Edinstvo_Hypothec::$hypothec);

//echo $view->render('hypothec:Calculation:ShowAllPrograms');

echo $view->render('hypothec/Calculation/ShowAllPrograms_spec');

}