<?php
$nav_count_per_page = 20;

$post = Dune_Filter_Post_Total::getInstance();
$get = Dune_Filter_Get_Total::getInstance();


    $crumbs = Dune_Display_BreadCrumb::getInstance();
    $crumbs->addCrumb('Ипотечные программы');

	$pagetitle = $this->pagetitle;
	$module_name = $this->module_name;
	$bgcolor1 = $this->bgcolor1;
	$bgcolor2 = $this->bgcolor2;
	$bgcolor3 = $this->bgcolor3;
	
$pagetitle = "Ипотечные программы";


$this->results['pagetitle'] = $pagetitle;

////////////////////////////        Текст фильтра
//////////////////////////////////////////////////

$f_order      = new Dune_Filter_Get_ValueAllow('order', 'pprogram_id', array('pprogram_id', 'rate_pp'));
$f_order_mode = new Dune_Filter_Get_ValueAllow('order_mode', 'asc ', array('asc', 'desc'));

//session_start();
$o_session = Dune_Session::getInstance('hipo');
$o_session->openZone('hipo');

if ($post->have('_do_'))
{
    $o_session->killZone();
    $o_session->bank_id = $post->getDigit('bank_id', 0);
    $o_session->rate_pp = $post->getDigit('rate_pp', 0, 5);
    $o_session->firstpayment_pp = $post->getDigit('firstpayment_pp', 0, 5);
    $o_session->currencyid_pp = $post->getHtmlSpecialChars('currencyid_pp', 'RUR', 5);
    
//    header('Location: ' . $_SERVER['HTTP_REFERER']);
    throw new Dune_Exception_Control_Goto();
//    $this->results['exit'] = 'exit';
    
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

$conditions = array();
if ($o_session->bank_id)
{
    $conditions[] = array(
                            'field' => 'p.bank_id',
                            'corr' => '=',
                            'digit' => 1,
                            'value' => $o_session->bank_id
                          );
}
if ($o_session->rate_pp)
{
    $conditions[] = array(
                            'field' => 'pp.rate_pp',
                            'corr' => '<=',
                            'digit' => 1,
                            'value' => $o_session->rate_pp
                          );
}

if ($o_session->firstpayment_pp)
{
    $conditions[] = array(
                            'field' => 'pp.firstpayment_pp',
                            'corr' => '<=',
                            'digit' => 1,
                            'value' => $o_session->firstpayment_pp
                          );
}

if ($o_session->currencyid_pp and $o_session->currencyid_pp != 'ALL')
{
    $conditions[] = array(
                            'field' => 'pp.currencyid_pp',
                            'corr' => '=',
                            'digit' => 0,
                            'value' => $o_session->currencyid_pp
                          );
}



$m_list = new Dune_Include_Module('db:hypothec:pprograms.list.all');

// Пепредача параметров для сортровки
$m_list->order_col_name = $o_session->order_col_name;
$m_list->asc_desc = $o_session->order_asc_desc;

$m_list->conditions = $conditions;
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
$o_session = Dune_Session::getInstance('hipo');	
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
    $navigation = new Dune_Navigate_Page('/modules.php?name=Hypothec&op=ShowAllPrograms&page=', $nav_count_total, $get->getDigit('page'), $nav_count_per_page);
    $view->assign('navigation', $navigation->getNavigator('special'));
    //echo $navigation->getNavigator();
}
//////////
//////////////////////////////////////////////////////////

	$view->assign('crumbs', $crumbs->getString('<p id="breadcrumb">', '</p>'));

$o_session = Dune_Session::getInstance('hipo');	
	
$view->assign('bank_id',$o_session->bank_id);
$view->assign('rate_pp',$o_session->rate_pp);
$view->assign('firstpayment_pp',$o_session->firstpayment_pp);
$view->assign('currencyid_pp',$o_session->currencyid_pp);

$view->assign('elected_id_array',$cooc);


$view->assign('array',$m_list->getResult('array'));
$view->assign('banks',$m_list->getResult('banks'));
$view->assign('data_specify_array', Data_Edinstvo_Hypothec::$hypothec);

echo $view->render('hypothec:ShowAllPrograms');

}
	//Menu("ShowAllPrograms");
     

/* $dbConn = connectToDB();
     $nukeSmarty = new NukeSmarty();
     
     $seedHypBank = new HypBank();
     $seedHypProgram = new HypProgram();
 
     $programs = $seedHypProgram->getProgramList();
     
     $programs_smarty = array();
     $img_path="/modules/Hypothec/images/";
     
     foreach ($programs as $seedHypProgram) {
     	
     	$seedHypProgram->initBank();
     	$programs_smarty[] = array(
								'ID' => $seedHypProgram->id,
								'NAME' => $seedHypProgram->name,
								'BONUS' => $seedHypProgram->bonus,
								'BANK_ID' => $seedHypProgram->bank->id,
								'BANK_NAME' => $seedHypProgram->bank->bankName,
								'BANK_LOGO_URL' => $seedHypProgram->bank->bankLogoUrl,
								);
		
     }
     
   	 $nukeSmarty->assign('programs', $programs_smarty);
     
	 $nukeSmarty->assign('IS_INTERNET', IsInternet());
	 $nukeSmarty->assign('IMG_PATH', $img_path);
	 
	 $nukeSmarty->assign('crumbs', $crumbs->getString('<p id="breadcrumb">', '</p>'));
	 
	
	 $nukeSmarty->display('modules/Hypothec/templates/ShowAllPrograms.tpl');
	
	
	$this->results['pagetitle'] = $pagetitle;
*/	