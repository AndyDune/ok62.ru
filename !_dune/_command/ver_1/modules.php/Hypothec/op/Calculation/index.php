<?php
/*
Из формы приходят:
rate
creditperiod
sumcredit
firstpayment
paymenttypeid

*/
$get = Dune_Filter_Get_Total::getInstance();
$post = Dune_Filter_Post_Total::getInstance();
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
    $session = Dune_Session::getInstance($session_name);


    $object = false;
    if (
        $session->object
        or
        $post->object
        or
        $get->object
        or
        (Dune_Parameters::$pageInternalReferer and strpos(Dune_Parameters::$pageInternalReferer, 'object/'))
        )
    {
        if ($session->object)
            $object = new Special_Vtor_Object_Data($session->object);
        else if ($get->object)
            $object = new Special_Vtor_Object_Data($get->object);
        else if ($post->object)
            $object = new Special_Vtor_Object_Data($post->object);
        else 
        {
            $url_info = new Special_Vtor_Catalogue_Url_Parsing();
            $object = new Special_Vtor_Object_Data($url_info->getObject());
        }
        
        if ($object->check())
        {
            $session->sumcredit = (int)$object->price;
            $session->object = $object->id;
            if ($object->new_building_flag)
                $session->status = 1;
            else 
                $session->status = 2;
        }
        else 
            $object = false;
    }
    
    $crumbs = Dune_Display_BreadCrumb::getInstance();
    $crumbs->addCrumb(Data_Edinstvo_Names::$broker);

	$pagetitle = $this->pagetitle;
	$module_name = $this->module_name;
	$bgcolor1 = $this->bgcolor1;
	$bgcolor2 = $this->bgcolor2;
	$bgcolor3 = $this->bgcolor3;
	
    $pagetitle = Data_Edinstvo_Names::$broker;
	$post = Dune_Filter_Post_Total::getInstance();
	$post->setLength(15);
	$post->trim();
	
	
	
	
    if ($post->_do_ == 'go')    
    {
        $session = Dune_Session::getInstance($session_name);
        $session->killZone();
        $post_array_all = array('use_firstpayment', 'use_creditperiod_or_monthpay', 'status', 'incconfirmid', 'currencyid', 'creditperiod', 'sumcredit', 'firstpayment', 'firstpayment_money', 'paymenttypeid', 'age', 'monthpay');
        $post_array_need = array('status', 'incconfirmid', 'currencyid', 'sumcredit', 'paymenttypeid');
        //$post_array_need = array('status', 'incconfirmid', 'currencyid', 'creditperiod', 'sumcredit', 'paymenttypeid'); // Было до модернизации
        $post_check = new Dune_Check_Post_Keys($post_array_need);
        
        $checked = $post_check->check();
        $arr = $post_check->getAvailable();
        foreach ($post_array_all as $value)
        {
            $session->$value = str_replace(' ', '', $post->$value);
        }
//        echo $post->use_creditperiod_or_monthpay; die();
        
        if (!$checked)
        {
            $session->next = 1;
        }
        else if ($session->use_creditperiod_or_monthpay != 'creditperiod' and $session->use_creditperiod_or_monthpay != 'monthpay')
        {
            $session->next = 6; // Не указан вариант для выбора
            $session->all_have = null;
        }
        else if ($session->use_firstpayment != 'per' and $session->use_firstpayment != 'money')
        {
            $session->next = 7; // Не указан вариант для выбора первогачального платежа.
            $session->all_have = null;
        }
        else if ($session->creditperiod < 1 and $session->monthpay < 2)
        {
            $session->next = 1;
            $session->all_have = null;
        }
        else if ($session->creditperiod < 1 and $session->use_creditperiod_or_monthpay == 'creditperiod')
        {
            $session->next = 6;
            $session->all_have = null;
        }
        else if ($session->monthpay < 10 and $session->use_creditperiod_or_monthpay == 'monthpay')
        {
            $session->next = 6;
            $session->all_have = null;
        }
        else if ((int)$session->firstpayment > 99 or (int)$session->creditperiod > 50)
        {
            $session->next = 3;
            $session->all_have = null;
        }
        else if (str_replace(array(',', ' '), array('.', ''), $session->sumcredit) > 55000000)
        {
            $session->next = 4;
            $session->all_have = null;
        }
        else if ((int)$session->age > 80 or (int)$session->age < 18)
        {
            $session->next = 5;
            $session->all_have = null;
        }
        else 
        {
            $good = true;
            if ($post->use_firstpayment == 'money')
            {
                if ($session->firstpayment_money < 10 or $session->firstpayment_money > $session->sumcredit)
                {
                    $session->next = 8; // Неверно введена сумма первого платежа
                    $session->all_have = null;
                    $good = false;
                }
                else 
                {
                    $session->firstpayment = floor($session->firstpayment_money / $session->sumcredit * 100); 
                }
            }
            
            if ($good)
            {
                if ($session->firstpayment > 1)
                {
                    $session->firstpayment_money = floor($session->firstpayment / 100 * $session->sumcredit); 
                }
                $session->all_have = 1;
                $session->one_bank = false;
            }
        }
        throw new Dune_Exception_Control_Goto('/modules.php?name=Hypothec&op=Calculation&version=' . $version);            
    }

    // Рассчет и вывод результатов
    if ($session->all_have and !$session->one_bank)
//if (true)
    { // die();
        if ($session->creditperiod > 1 and $session->use_creditperiod_or_monthpay == 'creditperiod')
        {
            $mod = new Dune_Include_Module('db:hypothec:calculation:make');
        }
        else 
            $mod = new Dune_Include_Module('db:hypothec:calculation:make.with.age');
          
              
        $mod->currencyid = $session->currencyid;
        $mod->creditperiod = $session->creditperiod;
        $mod->creditperiod = $session->creditperiod;
        $mod->status = $session->status;
        
        $mod->age = $session->age;
        $mod->monthpay = $session->getFloat('monthpay');
        
        $mod->incconfirmid = $session->incconfirmid;
        $mod->sumcredit = $session->getFloat('sumcredit');
        $mod->firstpayment = $session->firstpayment;
        $mod->paymenttypeid = $session->paymenttypeid;
        
        
        $mod->make();
        
        
        $arr = $mod->getResult('array');
        if ($session->creditperiod > 1 and count($arr))
        {
        	$MAIN_creditperiod = $session->creditperiod;
        	if ($session->age)
        	{
        	    $interv = $arr['agemax'] - $session->age;
        	    if ($interv < $arr['creditperiod_pp'] and $interv > 0 and $interv < $session->creditperiod)
        	    {
        	       $MAIN_creditperiod = $interv;
        	    }
        	}
            $session->creditperiod_fact = $MAIN_creditperiod;
        }
        else if (count($arr))
        {
            $MAIN_creditperiod = $mod->getResult('creditperiod');
            $session->creditperiod_fact = $mod->getResult('creditperiod');
        }
        // echo $mod;
        $session->one_bank = $mod->getResult('array');
        
        
/*        echo '<pre>';
        print_r($mod->getResult('array'));
        echo '
        
        
        ', $mod->getResult('count');
        echo '</pre>';
*/        
        $arr = $mod->getResult('array');
        $session->count = $mod->getResult('count');
        $session->count_all = $mod->getResult('count_all');
        if ($mod->getResult('count'))
        {
            $session->program = $arr;
            $session->all_have = 1;
            $session->rate = $arr['rate_pp'];
            $session->sql_filter = $mod->getResult('sql_filter');
            $session->sql_filter_all = $mod->getResult('sql_filter_all');
            
            $sum_all = $session->getFloat('sumcredit');
            $session->sumcredit_bank = $sum_all = $sum_all - $sum_all * ($session->firstpayment / 100);

            // Рассчёт платежа
//            $mod = new Dune_Include_Module('hypothec:calculation:payment:base');
            $mod = new Module_Hypo_PaymentCalculation();
            $mod->rate = $session->rate;
            $mod->creditperiod = $MAIN_creditperiod;
            $mod->sumcredit = $session->sumcredit_bank;
            $mod->paymenttypeid = $session->paymenttypeid;
            $mod->make();
            $session->pay_month = $mod->getResult('pay_month');
            $session->pay_month_dolg = $mod->getResult('pay_month_dolg');
            $session->pay_over  = $mod->getResult('pay_over');
            // END // Рассчёт платежа
            
        }
        else 
        {
            $session->next = 2;
            $session->all_have = 0;
        }
        
        
     }
//    echo $session; die();
    
	$dbConn = connectToDB();
	

    $view = Dune_Zend_View::getInstance();
    $session = Dune_Session::getInstance($session_name);
    
    $view->assign('crumbs', $crumbs->getString('<p id="breadcrumb">', '</p>'));
    
    $view->assign('message_id', $session->next);
    $view->assign('count', $session->count);
    $view->assign('count_all', $session->count_all);
    
    $view->assign('version', $version);

    
    $view->assign('program', new Dune_Array_Container($session->program));
    
    $view->assign('rate', $session->rate);
    $view->assign('pay_month', $session->pay_month);
    $view->assign('pay_month_dolg', $session->pay_month_dolg);
    $view->assign('pay_over', $session->pay_over);
    
    $view->assign('sumcredit_d', str_replace(' ', '', $session->sumcredit));
    $view->assign('sumcredit_bank', $session->sumcredit_bank);
    
    $view->assign('monthpay', $session->monthpay);
    
   
    $view->assign('age', $session->age);
    
    $view->assign('use_creditperiod_or_monthpay', $session->use_creditperiod_or_monthpay);
    $view->assign('use_firstpayment', $session->use_firstpayment);
    
    
    $view->assign('creditperiod', $session->creditperiod);
    $view->assign('creditperiod_fact', $session->creditperiod_fact);
    
    $view->assign('sumcredit', $session->sumcredit);
    $view->assign('firstpayment', $session->firstpayment);
    $view->assign('firstpayment_money', $session->firstpayment_money);
    $view->assign('paymenttypeid', $session->paymenttypeid);
    $view->assign('paymenttypearray', array('ANNUIT' => 'Аннуитетные', 'DIFF' => 'Дифференцированные', 'PLAV' => 'С плавающей ставкой'));
    
    $view->assign('currencyid', $session->currencyid);
    $view->assign('currencyarray', array('RUR' => 'Рубли', 'EUR' => 'Евро', 'USD' => 'Доллары'));

    $view->assign('incconfirmid', $session->incconfirmid);
    $view->assign('incconfirmarray', array('0' => 'Не важно', '1' => '2-НДФЛ', '2' => 'По форме банка'));
    
    $view->assign('status', $session->status);
    $view->assign('statusarray', array('1' => 'Новостройки', '2' => 'Вторичный рынок'));
    
    $type = 1;
    if ($object !== false)
    {
        $type = $object->type;
        $view->object = $object;
        $view->object_id = $object->id;
        $view->object_type = $object->type;
        Dune_Static_StylesList::add('catalogue/base');
        Dune_Static_StylesList::add('catalogue/info');

        $planer = new Special_Vtor_Catalogue_Info_Plan($object->id, $object->time_insert); // а есть ли планеровка (план)
        
        if ($planer->count())
        {
            $temp = $planer->getOneImage();
            $view->preview = $temp->getPreviewFileUrl();
        }
        else if ($this->object->pics)
        {
            $image = new Special_Vtor_Catalogue_Info_Image($object->id, $object->time_insert);
            $temp = $image->getOneImage();
            $view->preview = $temp->getPreviewFileUrl();
            $view->image = $temp->getSourseFileUrl();
        }
        else 
            $view->preview = '';
        
        $view->object_info = $view->render('hypothec/object');
    }
    if ($session->all_have)
    {
        $object_list = new Special_Vtor_Object_List_Condition();
        $object_list->setType($type);
        $object_list->setPriceFrom(1000);
        $object_list->setPriceTo($session->sumcredit);
        $object_list->setShowWitoutHouseNumber();
        $view->assign('objects_count', $object_list->count());
        echo $view->render('hypothec:Calculation:DialogAndResult');
    }
    else
        echo $view->render('hypothec:Calculation:Dialog');
    $session->next = null;
	
	$this->results['pagetitle'] = $pagetitle;

	
	Dune_Static_JavaScriptsList::add('jquery.dimensions');
	Dune_Static_JavaScriptsList::add('jquery.tooltip.pack');
	
	Dune_Static_StylesList::add('tooltip', 555);