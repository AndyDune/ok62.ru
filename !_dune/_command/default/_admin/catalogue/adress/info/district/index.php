<?php
/////       Лист
///////////////////////////////
////     
///     Список районов области
///
    $URL = Dune_Parsing_UrlSingleton::getInstance(); // Сачас 6-я возможна
    $folder_url = Dune_Data_Collector_UrlSingleton::getInstance();

    $session = Dune_Session::getInstance('add');
    
try {
    $post = Dune_Filter_Post_Total::getInstance();
    // Проишло из формы
    if ($post->_do_ == 'save')
    {
        if (!$post->check('id'))
            throw new Dune_Exception_Control_Goto($folder_url->getExeptLastFolder(2));
            
        $q = 'SELECT * 
              FROM unity_catalogue_adress_settlement
              WHERE id = ?i
              ';
        $DB = Dune_MysqliSystem::getInstance();
        $data_area = $DB->query($q, array($post->id), Dune_MysqliSystem::RESULT_ROWASSOC);
        if (!$data_area)
            throw new Dune_Exception_Control_Goto($folder_url->getExeptLastFolder(2));
        $session->name = $post->name;
        $session->order = $post->order;
        $session->type = $post->type;
        $session->population = $post->population;
        if (strlen($post->name) < 3)
        {
            throw new Dune_Exception_Control_Goto(Dune_Parameters::$pageInternalReferer);
        }
        $DB = Dune_MysqliSystem::getInstance();
        $set_q = new Dune_Mysqli_Collector_Set($DB);
        $set_q->assign('name', $post->name);
        $set_q->assign('settlement_id', $post->settlement_id, 'i');
        $set_q->assign('order', $post->order, 'i');
        
        
        echo $q = 'UPDATE unity_catalogue_adress_district ' . $set_q->get() . ' WHERE id = ?i';
        $DB->query($q, array($post->id));
        $session->killZone();
        throw new Dune_Exception_Control_Goto($post->link_list, 5);
        //$session->link_list = $post->link_list;
            
    }
    
    
    if ((int)$URL[6] < 1)
    {
        throw new Dune_Exception_Control_Goto(Dune_Parameters::$pageInternalReferer);
    }


    $q = 'SELECT * 
          FROM unity_catalogue_adress_district
          WHERE id = ?i
          ';
    $DB = Dune_MysqliSystem::getInstance();
    $data_district = $DB->query($q, array($URL[6]), Dune_MysqliSystem::RESULT_ROWASSOC);
    if (!$data_district)
        throw new Dune_Exception_Control_Goto($folder_url->getExeptLastFolder());
    
    $q = 'SELECT * 
          FROM unity_catalogue_adress_settlement
          WHERE id = ?i
          ';
    $DB = Dune_MysqliSystem::getInstance();
    $data_settlement = $DB->query($q, array($data_district['settlement_id']), Dune_MysqliSystem::RESULT_ROWASSOC);
    if (!$data_settlement)
        throw new Dune_Exception_Control_Goto($folder_url->getExeptLastFolder());
    
    $q = 'SELECT * 
          FROM unity_catalogue_adress_area
          WHERE id = ?i
          ';
    $DB = Dune_MysqliSystem::getInstance();
    $data_area = $DB->query($q, array($data_settlement['area_id']), Dune_MysqliSystem::RESULT_ROWASSOC);
    if (!$data_area)
        throw new Dune_Exception_Control_Goto($folder_url->getExeptLastFolder());

    
    
    $q = 'SELECT * 
          FROM unity_catalogue_adress_region 
          WHERE id = ?i
          ';
    $DB = Dune_MysqliSystem::getInstance();
    $data_region = $DB->query($q, array($data_area['region_id']), Dune_MysqliSystem::RESULT_ROWASSOC);
    if (!$data_region)
        throw new Dune_Exception_Control_Goto($folder_url->getExeptLastFolder(2));

        
        
        
    $link_list_area = $folder_url->getExeptLastFolder(2) . 'list/settlement/' . $data_area['id'] . '/';
    $link_list_region = $folder_url->getExeptLastFolder(2) . 'list/area/' . $data_region['id'] . '/';
    $link_list_settlement = $folder_url->getExeptLastFolder(2) . 'list/district/' . $data_settlement['id'] . '/';
    
    $crumbs = Dune_Display_BreadCrumb::getInstance();
    $crumbs->addCrumb('Области', $folder_url->getExeptLastFolder(2));
    $crumbs->addCrumb('Районы области: ' . $data_region['name'], $link_list_region);
    $crumbs->addCrumb('Посёлки района: ' . $data_area['name'], $link_list_area);
    $crumbs->addCrumb('Городские районы: ' . $data_settlement['name'], $link_list_settlement);    
    $crumbs->addCrumb('Редактор');
    echo $crumbs->getString();

    
    $view = Dune_Zend_View::getInstance();
    
    
    if ($session->name)
        $data_district['name'] = $session->name;
    if ($session->order)
        $data_district['order'] = $session->order;
        
        
    $view->data_settlement = $data_settlement;
    $view->data_area = $data_area;
    $view->data_region = $data_region;
    $view->data_district = $data_district;
    
    $view->link_list = $link_list_settlement;

    $view->form_action = $folder_url->get() . $URL[6] . '/';
    
    echo $view->render('page/catalogue/adress/info/district');
    $session->killZone();
}
catch (Dune_Exception_Control_Goto $e)
{
    if ($e->getCode() == 5)
        $session->killZone();
    Dune_Static_Header::location($e->getMessage());
    $this->status = Dune_Include_Command::STATUS_TEXT;
}