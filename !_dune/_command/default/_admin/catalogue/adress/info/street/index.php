<?php
/////       ����
///////////////////////////////
////     
///     ������������� ����� ����������������.
///
    $URL = Dune_Parsing_UrlSingleton::getInstance(); // ����� 6-� ��������
    $folder_url = Dune_Data_Collector_UrlSingleton::getInstance();

    $session = Dune_Session::getInstance('add');
    
try {
    $post = Dune_Filter_Post_Total::getInstance();
    // ������� �� �����
    if ($post->_do_ == 'save')
    {
        if (!$post->check('id'))
            throw new Dune_Exception_Control_Goto($folder_url->getExeptLastFolder(2));
            
        $q = 'SELECT * 
              FROM unity_catalogue_adress_street
              WHERE id = ?i
              ';
        $DB = Dune_MysqliSystem::getInstance();
        $data_street = $DB->query($q, array($post->id), Dune_MysqliSystem::RESULT_ROWASSOC);
        if (!$data_street)
            throw new Dune_Exception_Control_Goto($folder_url->getExeptLastFolder(2));
        $session->name = $post->name;
        $session->order = $post->order;

        if (strlen($post->name) < 3)
        {
            throw new Dune_Exception_Control_Goto(Dune_Parameters::$pageInternalReferer);
        }
        $DB = Dune_MysqliSystem::getInstance();
        $set_q = new Dune_Mysqli_Collector_Set($DB);
        $set_q->assign('name', $post->name);
        $set_q->assign('order', $post->order, 'i');
        
        echo $q = 'UPDATE unity_catalogue_adress_street ' . $set_q->get() . ' WHERE id = ?i';
        $DB->query($q, array($post->id));
        $session->killZone();
        throw new Dune_Exception_Control_Goto($post->link_list, 5);
        //$session->link_list = $post->link_list;
    }
    
    
    if ((int)$URL[6] < 1)
    {
        throw new Dune_Exception_Control_Goto(Dune_Parameters::$pageInternalReferer);
    }

    
    
    $addres_line = new Special_Vtor_AdressLine($URL[6]);

    $data_street = $addres_line->getDataStreet();
    if (!$data_street['id'])
        throw new Dune_Exception_Control_Goto($folder_url->getExeptLastFolder());
        
    $data_settlement = $addres_line->getDataSettlement();
    if (!$data_settlement['id'])
        throw new Dune_Exception_Control_Goto($folder_url->getExeptLastFolder());

    $data_area = $addres_line->getDataArea();
    if (!$data_area)
        throw new Dune_Exception_Control_Goto($folder_url->getExeptLastFolder());
    $data_region = $addres_line->getDataRegion();
    if (!$data_region)
        throw new Dune_Exception_Control_Goto($folder_url->getExeptLastFolder(2));
        
        
        
    $link_list_area = $folder_url->getExeptLastFolder(2) . 'list/settlement/' . $data_area['id'] . '/';
    $link_list_region = $folder_url->getExeptLastFolder(2) . 'list/area/' . $data_region['id'] . '/';
    $link_list_settlement = $folder_url->getExeptLastFolder(2) . 'list/street/' . $data_settlement['id'] . '/';
    //$link_list_district = $folder_url->getExeptLastFolder(2) . 'list/dstreet/' . $data_district['id'] . '/';
    
    $crumbs = Dune_Display_BreadCrumb::getInstance();
    $crumbs->addCrumb('�������', $folder_url->getExeptLastFolder(2));
    $crumbs->addCrumb('������ �������: ' . $data_region['name'], $link_list_region);
    $crumbs->addCrumb('������ ������: ' . $data_area['name'], $link_list_area);
    //$crumbs->addCrumb('��������� ������: ' . $data_settlement['name'], $link_list_settlement);    
    $crumbs->addCrumb('����� ������: ' . $data_settlement['name'], $link_list_settlement);
    $crumbs->addCrumb('��������');
    echo $crumbs->getString();

    
    $view = Dune_Zend_View::getInstance();
    
    
    if ($session->name)
        $data_street['name'] = $session->name;
    if ($session->order)
        $data_street['order'] = $session->order;
        
        
    $view->data_settlement = $data_settlement;
    $view->data_area = $data_area;
    $view->data_region = $data_region;
//    $view->data_district = $data_district;
    $view->data_street = $data_street;
    
//    $view->link_list = $link_list_district;

    $view->form_action = $folder_url->get() . $URL[6] . '/';
    
    echo $view->render('page/catalogue/adress/info/dstreet');
    $session->killZone();
}
catch (Dune_Exception_Control_Goto $e)
{
    if ($e->getCode() == 5)
        $session->killZone();
    Dune_Static_Header::location($e->getMessage());
    $this->status = Dune_Include_Command::STATUS_TEXT;

}