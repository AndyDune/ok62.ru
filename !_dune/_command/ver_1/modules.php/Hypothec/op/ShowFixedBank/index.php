<?php
    $crumbs = Dune_Display_BreadCrumb::getInstance();
    $crumbs->addCrumb('Банки', '/modules.php?name=Hypothec&op=ShowAllBanks');
    


$nav_count_per_page = 20;
$get = Dune_Filter_Get_Total::getInstance();
	$pagetitle = $this->pagetitle;
	$module_name = $this->module_name;
	$bgcolor1 = $this->bgcolor1;
	$bgcolor2 = $this->bgcolor2;
	$bgcolor3 = $this->bgcolor3;
	
	$pagetitle = "Банк";


//	Menu("ShowFixedBank");

 	$dbConn = connectToDB();

    $focusBank = new HypBank();
   // $seedHypCondition = new HypCondition();
   	$img_path="/modules/Hypothec/images/";
   	$img_path = $this->img_path;
    $seedHypProgram = new HypProgram();
    
    $bankID = Dune_Filter_Get_Digit::getInstance('bankID');
	$focusBank->retrieve($bankID->get());
	
	$crumbs->addCrumb($focusBank->bankName);
	
// Выбирается весь список отобранных программ
    $m_list = new Dune_Include_Module('db:hypothec:pprograms.list.bank');
    $m_list->bank_id = $bankID->get();
    
    $m_list->offset = $get->getDigit('page') * $nav_count_per_page;
    $m_list->count = $nav_count_per_page;
    
    $m_list->conditions = array();
    
// Пепредача параметров для сортровки - здесь заглушка
    $m_list->order_col_name = 'name_pp';
    $m_list->asc_desc = 'ASC';
    $m_list->make();
    

	
	//$conditions_smarty = array();
	$programs_smarty = array();
   

	//$conditions = $focusBank->getCondValueList();
	//print_array($conditions);
/*	$programs = $focusBank->getProgramList();
		 $show_program_smarty = false;
    if(isset ($programs) and count($programs)>0) {
    	$show_program_smarty = true;
    }
*/	
    if (count($m_list->getResult('array')))
        $show_program_smarty = true;
    else 
        $show_program_smarty = false;
	
	
   /* foreach ($conditions as $seedHypCondition) {
	$conditions_smarty[] = array( 
	
									'ID' => $seedHypCondition->id,
     								'NAME' => $seedHypCondition->name,
     								'VALUE' => $seedHypCondition->value,
     								
								);	
	
    }*/
	$conditions = array();
	$programs_smarty = array();
	
/*	foreach ($programs as $seedHypProgram) {
	$programs_smarty[] = array(
								'ID' => $seedHypProgram->id,
								'NAME' => $seedHypProgram->name,
								'BONUS' => $seedHypProgram->bonus,
								'firstpayment' => $seedHypProgram->firstpayment,
								'creditperiodmin' => $seedHypProgram->creditperiodmin,
								'creditperiodmax' => $seedHypProgram->creditperiodmax,
								'ratemin' => $seedHypProgram->ratemin,
								'ratemax' => $seedHypProgram->ratemax,
								'currencyid' => $seedHypProgram->currencyid
							
							  );
	}
*/	
    if (strlen($focusBank->bankUrl) > 3)
    {
        $x_point = strpos($focusBank->bankUrl, '.ru');
        $substr = strpos('.', $focusBank->bankUrl);
        $str = $focusBank->bankUrl;
        $new_str = array();
        for ($x = $x_point; $x >= 0; $x--)
        {
            if ($str[$x] != '/')
                $new_str[] = $str[$x];
            else 
                break;
        }
        krsort($new_str, SORT_NUMERIC);
        $url_show = implode('', $new_str) . 'ru';
    }
    else 
        $url_show = 'Сайт';
	
	$bank_smarty = array(
							'ID' => $focusBank->id,
							'NAME' => $focusBank->bankName,
							'NOVOSTROI' => $focusBank->bankNovostroi,
							'VTOR' => $focusBank->bankVtor,
							'LOGO_URL' => $focusBank->bankLogoUrl,
							'BANK_URL' => $focusBank->bankUrl,
							'BANK_URL_SHOW' => $url_show,
							'DISCRIPTION'=> $focusBank->bankDiscription,
							'programs'=>$programs_smarty,
							'conditions'=> $focusBank->getCondValueList(),
							);
	
	$view = Dune_Zend_View::getInstance();
	
	
/////////////////////////////////////////////////////////
//////////// Постраничная навигация
//$nav_count_per_page = 10;
$nav_count_total = $m_list->getResult('count');
if ($nav_count_total > $nav_count_per_page)
{
    $navigation = new Dune_Navigate_Page('/modules.php?name=Hypothec&op=ShowFixedBank&bankID=' . $focusBank->id . '&page=', $nav_count_total, $get->getDigit('page'), $nav_count_per_page);
    $view->assign('navigation', $navigation->getNavigator('special'));
    //echo $navigation->getNavigator();
}
//////////
//////////////////////////////////////////////////////////	
	

     $cooc = Dune_Cookie_ArraySingleton::getInstance('compare');
     if ($cooc->count())
         $view->assign('show_compare_button', $cooc->count());
     else 
         $view->assign('show_compare_button', 0);
     $view->assign('elected_id_array',$cooc);

$view->assign('crumbs', $crumbs->getString('<p id="breadcrumb">', '</p>'));

	$view->assign('array', $m_list->getResult('array'));
	
	Data_Edinstvo_Hypothec::prepare();
	$view->assign('data_specify_array', Data_Edinstvo_Hypothec::$hypothec);
	
	$view->assign('bank', $bank_smarty);
	$view->assign('IMG_PATH', $img_path);
	$view->assign('SHOW_PROGRAM', $show_program_smarty);
	
	$view->assign('IS_INTERNET', IsInternet());

	echo $view->render('hypothec:ShowFixedBank');
	
	
	 //$nukeSmarty->display('modules/Hypothec/templates/ShowFixedBank_plus.tpl');
	
	
	$this->results['pagetitle'] = $pagetitle;
	