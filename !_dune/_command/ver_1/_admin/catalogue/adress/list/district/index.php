<?php
/////       ����
///////////////////////////////
////     
///     ������ ������� ������
///
    $URL = Dune_Parsing_UrlSingleton::getInstance(); // ����� 6-� ��������
    $folder_url = Dune_Data_Collector_UrlSingleton::getInstance();

try {
    if ((int)$URL[6] < 1)
    {
        throw new Dune_Exception_Control_Goto($folder_url->getExeptLastFolder());
    }

    
    $q = 'SELECT * 
          FROM unity_catalogue_adress_settlement
          WHERE id = ?i 
         ';
    $DB = Dune_MysqliSystem::getInstance();
    $data_settlement = $DB->query($q, array($URL[6]), Dune_MysqliSystem::RESULT_ROWASSOC);
    if (!$data_settlement)
        throw new Dune_Exception_Control_Goto($folder_url->getExeptLastFolder(2));
    
    
    $q = 'SELECT * 
          FROM unity_catalogue_adress_area
          WHERE id = ?i
          ';
    $DB = Dune_MysqliSystem::getInstance();
    $data_area = $DB->query($q, array($data_settlement['area_id']), Dune_MysqliSystem::RESULT_ROWASSOC);
    if (!$data_area)
        throw new Dune_Exception_Control_Goto($folder_url->getExeptLastFolder(2));
    
    $q = 'SELECT * 
          FROM unity_catalogue_adress_region 
          WHERE id = ?i
          ';
    $DB = Dune_MysqliSystem::getInstance();
    $data_region = $DB->query($q, array($data_area['region_id']), Dune_MysqliSystem::RESULT_ROWASSOC);
    if (!$data_region)
        throw new Dune_Exception_Control_Goto($folder_url->getExeptLastFolder(2));
    
    
    $q = 'SELECT * 
          FROM unity_catalogue_adress_district
          WHERE settlement_id = ?i 
          ORDER BY name';
    $DB = Dune_MysqliSystem::getInstance();
    $list_district = $DB->query($q, array($data_settlement['id']), Dune_MysqliSystem::RESULT_IASSOC);

    $link_list = $folder_url->getExeptLastFolder(2) . 'list/area/' . $data_region['id'] . '/';        
    
    $link_list_area = $folder_url->getExeptLastFolder(2) . 'list/settlement/' . $data_area['id'] . '/';
    $link_list_region = $folder_url->getExeptLastFolder(2) . 'list/area/' . $data_region['id'] . '/';
    
    $crumbs = Dune_Display_BreadCrumb::getInstance();
    $crumbs->addCrumb('�������', $folder_url->getExeptLastFolder(2));
    $crumbs->addCrumb('������ �������: ' . $data_region['name'], $link_list_region);
    $crumbs->addCrumb('������ ������: ' . $data_area['name'], $link_list_area);
    $crumbs->addCrumb('��������� ������: ' . $data_settlement['name']);
    echo $crumbs->getString();
    
    
    
    $view = Dune_Zend_View::getInstance();
//    $view->link_next_list_center = $folder_url->getExeptLastFolder() . 'district';
    $view->link_next_list = $folder_url->getExeptLastFolder() . 'dstreet';
    $view->link_edit = $folder_url->getExeptLastFolder(2) . 'info/district';
    $view->link_add = $folder_url->getExeptLastFolder(2) . 'add/district/' . $data_settlement['id'] . '/';
    $view->data = $list_district;
    echo $view->render('page/catalogue/adress/list/district');
}
catch (Dune_Exception_Control_Goto $e)
{
    Dune_Static_Header::location($e->getMessage());
    $this->status = Dune_Include_Command::STATUS_TEXT;
}