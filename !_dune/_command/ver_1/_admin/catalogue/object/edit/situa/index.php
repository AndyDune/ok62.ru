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
    switch ($get->_do_)
    {
        case 'delete_situa':
		// Выборка информации о картинках модели
            $object = new Special_Vtor_Object_Data($get->id);
            if (!$object->check()) // Нет записи с таким id
                throw new Dune_Exception_Control_Goto(Dune_Parameters::$pageInternalReferer);
            $object->have_plan = 0;
            $object->save();
			$mm_pics_info = new Dune_Include_Module('file:picture:list.preview.delete.one');
			$mm_pics_info->local_folder = 'situa';
			$mm_pics_info->path_main = Special_Vtor_Object_Path::$pathObjects 
			                         . '/' 
			                         . $object->getInsertYear()
			                         . '/' 
			                         . $object->id;
			                         
			$mm_pics_info->path_preview = Special_Vtor_Object_Path::$pathObjectsPreview 
			                         . '/' 
			                         . $object->getInsertYear()
			                         . '/' 
			                         . $object->id;
			                         
			$mm_pics_info->make(); // Погнали
			
			
            
            throw new Dune_Exception_Control_Goto(Dune_Parameters::$pageInternalReferer);
    }    
    // Проишло из формы
    switch ($post->_do_)
    {
        case 'save_situa':
		// Выборка информации о картинках модели
            $object = new Special_Vtor_Object_Data($post->id);
            if (!$object->check()) // Нет записи с таким id
                throw new Dune_Exception_Control_Goto(Dune_Parameters::$pageInternalReferer);
                
            $object->have_plan = 1;
            $object->save();
                
                
			//$mm_pics_info = new Dune_Include_Module('file:picture:list.preview.save.post');
			$mm_pics_info = new Module_File_Picture_ListPreviewSavePost();
			$mm_pics_info->local_folder = 'situa';
			echo $mm_pics_info->path_main = Special_Vtor_Object_Path::$pathObjects 
			                         . '/' 
			                         . $object->getInsertYear()
			                         . '/' 
			                         . $object->id;
			                         
			$mm_pics_info->path_preview = Special_Vtor_Object_Path::$pathObjectsPreview 
			                         . '/' 
			                         . $object->getInsertYear()
			                         . '/' 
			                         . $object->id;
			                         
			$mm_pics_info->make(); // Погнали
			//echo $mm_pics_info;
			
            
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
    
    
/*    echo $this->adress_code, '<br />';   
    echo $this->adress_id;   
*/    
    $object_condition = new Special_Vtor_Object_Condition();
    $object_condition = $object_condition->getList(1);
    $object_planning = new Special_Vtor_Object_Planning();
    $object_planning = $object_planning->getList();
   
    
    $view = Dune_Zend_View::getInstance();
    
    if ($session->have)
        $view->data = new Dune_Array_Container($session->getZone());
    else 
        $view->data = $this->object;
        
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

    
    // Передаем масви картинок
     $images = new Special_Vtor_Catalogue_Info_PlanSitua($view->data->id, $view->data->time_insert);
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
    
    echo $view->render('page/catalogue/object/edit/situa');
}
catch (Dune_Exception_Control_Goto $e)
{
    Dune_Static_Header::location($e->getMessage());
    $this->status = Dune_Include_Command::STATUS_TEXT;
}