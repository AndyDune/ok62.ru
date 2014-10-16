<?php
/////       Лист
///////////////////////////////
////     
///     Список районов области
///
    $OBJECT_TYPE_ID = 5;
    $session = Dune_Session::getInstance(Dune_Session::ZONE_AUTH);
    $OBJECT_SALER_ID = $session->user_id;

    $URL = Dune_Parsing_UrlSingleton::getInstance(); // Сачас 6-я возможна
    $folder_url = Dune_Data_Collector_UrlSingleton::getInstance();

    $session = Dune_Session::getInstance('add_object');
    if (!$session->to_go_past_save) // куда уходить после сохранения
    {
        $session->to_go_past_save = Dune_Parameters::$pageInternalReferer;
    }

    $addres_line = new Special_Vtor_AdressLine($this->adress_id, $this->adress_code);

    $data_street     = $addres_line->getDataStreet();
    $data_settlement = $addres_line->getDataSettlement();
    $data_area       = $addres_line->getDataArea();
    $data_district   = $addres_line->getDataDistrict();
    $data_region     = $addres_line->getDataRegion();
    
try {
    $post = Dune_Filter_Post_Total::getInstance();
    // Проишло из формы
    if ($post->_do_ == 'save')
    {
        $post->trim();
        $require_array = array('house_number', 'room', 'adress_code', 'adress_id');
        $stop = false;
        $x = 0;
        foreach ($post as $key => $value)
        { 
            $session->$key = $value;
            if (in_array($key, $require_array))
            { 
                $x++;
            }
        }
        if ($post->balcony)
            $session->balcony = 1;
        else 
            $session->balcony = 0;
        if ($post->loggia)
            $session->loggia = 1;
        else 
            $session->loggia = 0;

        $module = new Module_Admin_Catalogue_Object_SessionSetCommon();
        $module->name_zone = 'add_object';
        $module->make();
            
            
        if ($x != 4)
            throw new Dune_Exception_Control_Goto(Dune_Parameters::$pageInternalReferer);
        $object = new Special_Vtor_Object_Data();
        foreach ($post as $key => $value)
        {
            $object->$key = $value;
        }
        $object->region_id = $data_region['id'];
        $object->area_id = $data_area['id'];
        $object->settlement_id = $data_settlement['id'];
        $object->district_id = $data_district['id'];
        $object->street_id = $data_street['id'];
        $object->type = $OBJECT_TYPE_ID;
        $object->saler_id = $OBJECT_SALER_ID;

        
        $session->killZone();
        $URL->cutCommands(3);
        throw new Dune_Exception_Control_Goto($URL->getCommandString() . 'edit/'. $object->add() . '/');

            
//        $session->to_go_past_save = '';
//        throw new Dune_Exception_Control_Goto($post->link_list);
//        $session->link_list = $post->link_list;
        
        //throw new Dune_Exception_Control_Goto(Dune_Parameters::$pageInternalReferer);
        
    }
    
    if (!$data_region)
        throw new Dune_Exception_Control_Goto($folder_url->getExeptLastFolder(2));
        
        
        
    $link_list_area = $folder_url->getExeptLastFolder(2) . 'list/settlement/' . $data_area['id'] . '/';
    $link_list_region = $folder_url->getExeptLastFolder(2) . 'list/area/' . $data_region['id'] . '/';
    $link_list_settlement = $folder_url->getExeptLastFolder(2) . 'list/street/' . $data_settlement['id'] . '/';
    $link_list_district = $folder_url->getExeptLastFolder(2) . 'list/dstreet/' . $data_district['id'] . '/';
    
    $link_list_street = $folder_url->getExeptLastFolder(2) . 'list/object/' . $this->adress_code . '-' . $this->adress_id . '/';
    
    $crumbs = Dune_Display_BreadCrumb::getInstance();
    $crumbs->addCrumb('Области', $folder_url->getExeptLastFolder(2));
    $crumbs->addCrumb('Районы области: ' . $data_region['name'], $link_list_region);
    $crumbs->addCrumb('Посёлки района: ' . $data_area['name'], $link_list_area);
    if ($data_district['id'])
        $crumbs->addCrumb('Городские районы: ' . $data_district['name'], $link_list_district);
    if ($data_street['id'])        
    {
        $crumbs->addCrumb('Улицы города: ' . $data_settlement['name'], $link_list_settlement);
        $crumbs->addCrumb('Объекты на улице: ' . $data_street['name'], $link_list_street);
    }
    else 
    {
        $link_list_street = $folder_url->getExeptLastFolder(2) . 'list/object/' . $this->adress_code . '-' . $this->adress_id . '/';
        $crumbs->addCrumb('Объекты поселка: ' . $data_settlement['name'], $link_list_street);
    }
    $crumbs->addCrumb('Новый&nbsp;объект');
    echo $crumbs->getString();
    
    
/*    echo $this->adress_code, '<br />';   
    echo $this->adress_id;   
*/    
    $object_condition = new Special_Vtor_Object_Condition();
    $object_condition = $object_condition->getList(5);
    $object_planning = new Special_Vtor_Object_Planning();
    $object_planning = $object_planning->getList();
   
    
    $view = Dune_Zend_View::getInstance();
    
    $house_type = new Special_Vtor_Object_Add_HouseType();
    $view->house_type = $house_type->getListType(5);
    
    $view->data = new Dune_Array_Container($session->getZone());
    $view->condition = $object_condition;
    $view->planning = $object_planning;
    
    $view->adress_code = $this->adress_code;
    $view->adress_id = $this->adress_id;
    
    $view->adress = array(
                            'region' => $data_region,
                            'area' => $data_area,
                            'settlement' => $data_settlement,
                            'district' => $data_district,
                            'street' => $data_street
                          );
    
//    $view->link_list = $link_list;
//    $view->data_region = $data_region;
//    $view->form_action = $folder_url->get() . $URL[6] . '/';
    
    echo $view->render('page/catalogue/object/add/type_pantry');
}
catch (Dune_Exception_Control_Goto $e)
{
    Dune_Static_Header::location($e->getMessage());
    $this->status = Dune_Include_Command::STATUS_TEXT;
}