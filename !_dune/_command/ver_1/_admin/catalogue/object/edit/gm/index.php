<?php
/////       Лист
///////////////////////////////
////     
///     Редактирование квартиры.
///
    $URL = Dune_Parsing_UrlSingleton::getInstance(); // Сачас 6-я возможна
    $folder_url = Dune_Data_Collector_UrlSingleton::getInstance();

    $session = Dune_Session::getInstance('edit_object');
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
    $get = Dune_Filter_Get_Total::getInstance();
    
    // Проишло из формы
    switch ($post->_do_)
    {
        case 'save_gm':
		// Выборка информации о картинках модели
            $object = new Special_Vtor_Object_Data($post->id);
            if (!$object->check()) // Нет записи с таким id
                throw new Dune_Exception_Control_Goto(Dune_Parameters::$pageInternalReferer);
                
            $object->gm_x = $post->pos_x;
            $object->gm_y = $post->pos_y;
            
            $mod = new Module_Map_HitDistrictPlus();
            $mod->x = $post->pos_x;
            $mod->y = $post->pos_y;
            $mod->make();
            if ($mod->getResult('success')) // Не нашли район
            {
                $object->district_id_plus = $mod->getResult('district');
            }
            else
                $object->district_id_plus = 1;
            
            $object->save();
			
            
            throw new Dune_Exception_Control_Goto(Dune_Parameters::$pageInternalReferer);
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
    
    
    $view = Dune_Zend_View::getInstance();
    
    $view->data = $this->object;
    
    if ($this->object->gm_x)
    {
        $view->pos_x = $this->object->gm_x;
        $view->pos_y = $this->object->gm_y;
    }
    else 
    {
        $q = 'SELECT * FROM `unity_catalogue_object`
              WHERE `settlement_id` = ?i 
                  AND street_id = ?i
                  AND house_number = ? 
                  AND building_number = ? 
                  AND (gm_x != NULL OR gm_x != "" )
              LIMIT 1';
        $db = Dune_MysqliSystem::getInstance();
        $res = $db->query($q, array(
                              $this->object->settlement_id,
                              $this->object->street_id,
                              $this->object->house_number,
                              $this->object->building_number
                             ),
                       Dune_MysqliSystem::RESULT_ROWASSOC);
       if ($res) 
       {
        $view->pos_x = $res['gm_x'];
        $view->pos_y = $res['gm_y'];
        $view->enother = true;
       }
       else 
       {
            $view->pos_x = '54.61677857844892';
            $view->pos_y = '39.7225284576416';
       }
 
    }
    
        
    
    $view->adress_code = $this->adress_code;
    $view->adress_id = $this->adress_id;
    
    $view->adress = array(
                            'region' => $data_region,
                            'area' => $data_area,
                            'settlement' => $data_settlement,
                            'district' => $data_district,
                            'street' => $data_street
                          );

    
    
    // Передаем масви картинок
     $images = new Special_Vtor_Catalogue_Info_Plan($view->data->id, $view->data->time_insert);
     $photos = array();     
     foreach ($images as $key => $imagesOne) 
     {
         $photos[] = $imagesOne;
     }
     $view->photos = $photos;
     
     $view->command_path_edit = $URL->getRequestPathString();
                          
//    $view->link_list = $link_list;
//    $view->data_region = $data_region;
//    $view->form_action = $folder_url->get() . $URL[6] . '/';
    
    echo $view->render('page/catalogue/object/edit/gm');
}
catch (Dune_Exception_Control_Goto $e)
{
    Dune_Static_Header::location($e->getMessage());
    $this->status = Dune_Include_Command::STATUS_TEXT;
}