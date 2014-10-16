<?php

    $crumbs = Dune_Display_BreadCrumb::getInstance();
    $crumbs->addCrumb('Поиск ипотечной программы');

	$pagetitle = $this->pagetitle;
	$module_name = $this->module_name;
	$bgcolor1 = $this->bgcolor1;
	$bgcolor2 = $this->bgcolor2;
	$bgcolor3 = $this->bgcolor3;
	
$pagetitle = "Ипотечные программы";





////////////////////////////        Текст фильтра

//////////////////////////////////////////////////

$f_order      = new Dune_Filter_Get_ValueAllow('order', 'pprogram_id', array('pprogram_id', 'rate_pp'));
$f_order_mode = new Dune_Filter_Get_ValueAllow('order_mode', 'asc ', array('asc', 'desc'));

//session_start();
$o_session = Dune_Session::getInstance();
$o_session->openZone('hipose');
$post = Dune_Filter_Post_Total::getInstance();
$array = array(
    'bank_id',
    'rate',
    'kinds',
    'currencyid',
    'loansecurityid',
    'creditperiodmin',
    'creditperiodmax',
    'sumcredit',
    'firstpayment',
    'incconfirmid',
    'approveperiod',
    'age',
    'registration',
    'nationality',
    'paymenttypeid',
    'advrepay'
    );

if ($post->have('_do_'))
{
    switch ($post->_do_)
    {
        default:
            $o_session->killZone();
            foreach ($post as $key => $value)
            {
                if (key_exists($key, $array));
                {
                    $o_session->$key = $post->$key;
                }
            }
    }
//    header('Location: /modules.php?name=Hypothec&op=ShowSearchPrograms');
    throw new Dune_Exception_Control_Goto('/modules.php?name=Hypothec&op=ShowSearchPrograms');
//    $this->results['exit'] = 'exit';
}
else 
{
    $data = array();
    foreach ($o_session as $key => $value)
    {
        $data[$key] = $value;
    }
                
//$o_session = new Dune_Array_IsSet($_SESSION);

$conditions = array();

if (HYPOTHEC_SHOW_ALL_BANKS)
    $m_list = new Dune_Include_Module('db:hypothec:pprograms.search');
else 
    $m_list = new Dune_Include_Module('db:hypothec:pprograms.search.banks.have.progs');
$m_list->make();



Data_Edinstvo_Hypothec::prepare();

$view = Dune_Zend_View::getInstance();
$view->assign('crumbs', $crumbs->getString('<p id="breadcrumb">', '</p>'));
$view->assign('conditions',$conditions);

$view->assign('data',$data);


$view->assign('bank_id',$o_session->bank_id);
$view->assign('rate_pp',$o_session->rate_pp);
$view->assign('firstpayment_pp',$o_session->firstpayment_pp);
$view->assign('currencyid_pp',$o_session->currencyid_pp);

$view->assign('banks',$m_list->getResult('banks'));

$view->assign('data_specify_array', Data_Edinstvo_Hypothec::$hypothec);
echo $view->render('hypothec:SearchPrograms');

}