<?php


// !!!!  �������� ����� ������� � �� - �������� �����.


    $message = '';
    $crumbs = Dune_Display_BreadCrumb::getInstance();
    
        
    $get = Dune_Filter_Get_Total::getInstance();
    
    if ($get->getDigit('page', 1) > 1) 
    {
        $crumbs->addCrumb('������ ������� ��������� ���������', '/modules.php?name=Hypothec&op=MasterForProgram');    
    }
    else 
        $crumbs->addCrumb('������ ������� ��������� ��������� &gt; ����: 1');    
    
// ��������� ������� ��� ����� ������ �� �������. 
// ���� ����������������.    
/*    if ($get->check('page') and ($get->getDigit('page', 1) > 1))
    {
        $temp = $get->getDigit('page');
        for ($x = 1; $x < $temp; $x++)
        {
            if ($x == 1)
                $crumbs->addCrumb('����: ' . $x, '/modules.php?name=Hypothec&op=MasterForProgram');
            else 
                $crumbs->addCrumb('����: ' . $x, '/modules.php?name=Hypothec&op=MasterForProgram&page=' . $x);
            if ($x > 5)
                break;
        }
       
        
    }
    $crumbs->addCrumb('����: ' . $get->getDigit('page', 1));    
*/
    
// ������������� ���������� (�������)
    Data_Edinstvo_Hypothec::prepare();
// ����������� ����������� ������
    $levels_count = count(Data_Edinstvo_Hypothec::$programsMaster);
    
    
// ���� ���������� ��� ������� ������� ������ ����� ����������� ������� ������ - �������� �� 1-� �������
    if ($get->getDigit('page', 1) > $levels_count)
    {
//        header('Location: /modules.php?name=Hypothec&op=MasterForProgram');
        throw new Dune_Exception_Control_Goto('/modules.php?name=Hypothec&op=MasterForProgram');
//        exit();
    }
    if ($get->getDigit('page', 1) > 1) 
    {
        $crumbs->addCrumb('���� ' . $get->getDigit('page', 1) . ': ' . Data_Edinstvo_Hypothec::$programsMaster[$get->getDigit('page', 1)]['name']);    
    }
    
// ��������� ������� ������    
    $o_session = Dune_Session::getInstance('master');

// ���� ��� �� 1-� �������� �������    
    if ($get->getDigit('page', 1) > 1) 
    {
   // ����� ������ �������� ������� ������ �� ���������� ������ ����� ������
   // ����� ����  - ����� ����� �������� ����� ���� �������� �� 1-� (����������)
    	$m_list = new Dune_Include_Module('hypothec:check:master.data.for.page');
    	$m_list->page = $get->getDigit('page', 1);
    	$m_list->array = $o_session->getZone(true);
    	$m_list->support = Data_Edinstvo_Hypothec::$programsMaster;
        $m_list->make();
        if (!$m_list->getResult('result'))
        {
            $o_session->message = '�� ���� �������������� �� ������ �������� �������. ������ ������� ���������� ��������� ���������������.' . $get->getDigit('page', 1);
            //header('Location: /modules.php?name=Hypothec&op=MasterForProgram');
            //exit();
        }
    }
    else
    {
        $message = $o_session->message;
        //$o_session->killZone();
    }
    
    
	//$pagetitle = $this->pagetitle;
	$module_name = $this->module_name;
	$bgcolor1 = $this->bgcolor1;
	$bgcolor2 = $this->bgcolor2;
	$bgcolor3 = $this->bgcolor3;
	
    $pagetitle = "������ ������� ��������� ���������";




//////////////////////////////////////////////////

// ������ - ������ ��� ������� $_POST
    $post = Dune_Filter_Post_Total::getInstance();
    $post->setLength(20);
    
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
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////        ������ ������ �� �����. ������.
/////////
// ��������� �� ������� POST ����������, ������� ������� � ������� $array
    if ($post->have('_do_'))
    { $o_session = Dune_Session::getInstance('master');
        switch ($post->_do_)
        {
            default:
// �������� ������ ���������� ����� ����������� �����
                //$o_session->killZone();
// ��������� ������� ����� �����������, ���������� � ������� ���������� $array                
                foreach ($post as $key => $value)
                {
                    if (in_array($key, $array))
                    { 
//                        if (!key_exists($key, $o_session->getZone()) or ($o_session->$key != $post->$key))
//                        {
                            $o_session->count_programs_saved = 0;
                            $o_session->$key = $post->$key;
//                        }
                    }
                }
        }
// ������� ������� ����� ��� ����� ��������
$o_session = Dune_Session::getInstance('master');
            $m_count_programs = new Dune_Include_Module('db:hypothec:programs.for.master.count');
            $m_count_programs->data = $o_session->getZone(true);
            $m_count_programs->make();
            $o_session->count_programs = $m_count_programs->getResult('count');            
            $o_session->count_programs_saved = 1;
        
// ���� �� ������� ����� �������� � ���������� ��������� ���� - ������� �� �����    
        if ($o_session->count_programs == 0)
        {
            // ������� �������� ����� �������� �����
            $m_delete_after = new Dune_Include_Module('hypothec:check:master.data.delete.after');
            $m_delete_after->page = $post->page; // �������� ������ ��������
            $m_delete_after->array = $o_session->getZone(); // ������� ������ ����
            $m_delete_after->support = Data_Edinstvo_Hypothec::$programsMaster; // �������� ������� ������
            $m_delete_after->make(); 
            $o_session->setZone($m_delete_after->getResult('array')); // ���������� ������������ ������� ����
            $x = $post->page;
//            header('Location: /modules.php?name=Hypothec&op=MasterForProgram&page=' . $x);
            throw new Dune_Exception_Control_Goto('/modules.php?name=Hypothec&op=MasterForProgram&page=' . $x);
        }
        
// ������� � ���������� �����
/*        else if ($post->page < $levels_count)
        {
            $x = $post->page + 1;
            header('Location: /modules.php?name=Hypothec&op=MasterForProgram&page=' . $x);
        }
// ����� �� ������ ����� - ������� � 1-��
        else 
            header('Location: /modules.php?name=Hypothec&op=MasterForProgramList');
*/
        else 
        {
            $x = $post->page + 1;
//            header('Location: /modules.php?name=Hypothec&op=MasterForProgram&page=' . $x);
            throw new Dune_Exception_Control_Goto('/modules.php?name=Hypothec&op=MasterForProgram&page=' . $x);
        }
        $this->results['exit'] = 'exit';
    }
//////////////
////////////////////////////                ������ ������ �� �����. �����.
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    else 
    {
// ����� ������ �������� ������������ �������� ���������
// ����������, ���� ��������� ���������� ����������� ������� �������.
        if (!$o_session->count_programs_saved)
        {
            $m_count_programs = new Dune_Include_Module('db:hypothec:programs.for.master.count');
            $m_count_programs->data = $o_session->getZone(true);
            $m_count_programs->make();
            $o_session->count_programs = $m_count_programs->getResult('count');            
            $o_session->count_programs_saved = 1;
        }
    
// ������ �������� ������
 //       echo $o_session;
//        echo $message;
        
        $conditions = array();
        
        /*$m_list = new Dune_Include_Module('db:hypothec:master.count');
        $m_list->page = $get->getDigit('page', 1);
        $m_list->array = $o_session->getZone();
        $m_list->support = Data_Edinstvo_Hypothec::$programsMaster;
        $m_list->make();
        */
        
        
        Data_Edinstvo_Hypothec::prepare();
        
        $view = Dune_Zend_View::getInstance();
        
        $view->assign('page', $get->getDigit('page', 1));
        $view->assign('support', Data_Edinstvo_Hypothec::$programsMaster);
        
//////////////////////////////////////////////////////////////////////////////        
// ������� ��������� ���������� ��� ��������� � �������
        $text_array = new Dune_Array_Container(array()); // ��������� �������
        $texts_path = $_SERVER['DOCUMENT_ROOT'] . '/data/hypo/text/master/';
        $p = $get->getDigit('page', 1);
        foreach ((array)Data_Edinstvo_Hypothec::$programsMaster[$p]['form'] as $value)
        {
            if (is_file($texts_path . $value . '.htm'))
            {
                $text_array->$value = file_get_contents($texts_path . $value . '.htm');
            }
        }

        $view->assign('texts', $text_array);

//////////////////////////////////////////////////////////////////////////////        
        
        $o_session = Dune_Session::getInstance('master');
        $view->assign('data',$o_session->getZone());
        $view->assign('array',$o_session->getZone());
        
        $view->assign('current_page_name', Data_Edinstvo_Hypothec::$programsMaster[$get->getDigit('page', 1)]['name']);
        
        
        
// ������ ������ � �������
        $m_list = new Dune_Include_Module('db:hypothec:banks.list');
        $m_list->make();
        $view->assign('banks',$m_list->getResult('banks'));
        
        $view->assign('levels_count',$levels_count);
        
        $view->assign('count_programs', $o_session->count_programs);
                
        $view->assign('crumbs', $crumbs->getString('<p id="breadcrumb">', '</p>'));
        $view->assign('conditions',$conditions);
        
        $view->assign('data', new Dune_Array_Container($o_session->getZone()));
        
        $view->assign('data_specify_array', Data_Edinstvo_Hypothec::$hypothec);
        echo $view->render('hypothec:master:FilterPages');

        $this->results['pagetitle'] = $pagetitle;
}