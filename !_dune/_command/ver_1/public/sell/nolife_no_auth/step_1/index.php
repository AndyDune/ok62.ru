<?php
    $post = Dune_Filter_Post_Total::getInstance();
//    $session = Dune_Session::getInstance('control');
    if (isset($post['_do_']))
    {
//        $status = Special_Vtor_Object_Query_StatusContainerForAuthUser::getInstance(Special_Vtor_User_Auth::$id);
//        $object = $status->getNotFinished();
        $current_object = Special_Vtor_Object_Query_AuthNo_DataSingleton::getInstance($session->edit);        
        if ($current_object->isFromBd())
        {
            $update_id = $current_object->getId();
        }
        else 
        {
            $update_id = 0;
            throw new Dune_Exception_Control('Потеря сеанса.', 55);
        }
        $module = new Module_Catalogue_Object_Save_QueryFromUserAuthNo();
        $module->update_id = $update_id;
        $module->make();
        
        $cooc = Dune_Cookie_ArraySingleton::getInstance(Dune_Parameters::$cookieNameSystem);
        if ($module->getResult('success'))
        {
            $session = Dune_Session::getInstance('control');
            $session->step = 2;
            $session->added_id = $cooc['added_id'] = $module->getResult('id');
            $URL->setCommand('step_1', 4);
            throw new Dune_Exception_Control_Goto($URL->getCommandString());
        }
            
        throw new Dune_Exception_Control('Ошибка сохранения данных', 5);
    }
    
    //$view->data = $post;
//    $object = new Special_Vtor_Object_Query_Data();
    
//    $object->setUserId(Special_Vtor_User_Auth::$id);

    if (($current_object->getLastObjectInsertTime() !== false) and $current_object->getLastObjectInsertTime() < Special_Vtor_Settings::$timeIntervalObjectToAdd)
//    if ($object->getLastObjectInsertTime() < Special_Vtor_Settings::$timeIntervalObjectToAdd)
    {
        $session->message_code =  2; // Слишком часто
        Dune_Static_Message::setCode(2);
    }
                
    if ($current_object->getCountObjectsInsertInQuery() >= Special_Vtor_Settings::$maxObjectsInQueryToAdd)
    {
        $session->message_code =  4; // Слишком много
        Dune_Static_Message::setCode(4);
    }
    
    $object_condition = new Special_Vtor_Object_Condition();
    $object_condition = $object_condition->getList($object_type);
    $object_planning = new Special_Vtor_Object_Planning();
    $object_planning = $object_planning->getList();
        
    $house_type = new Special_Vtor_Object_Add_HouseType();
    $view->house_type = $house_type->getListType($object_type);
    
    
    $view->condition = $object_condition;
    $view->planning = $object_planning;
    
    $view->do = 'add';
    $session = Dune_Session::getInstance('data');
    if (!count($session))
    {
        $view->data = $current_object->getData(true);
        $view->id = $current_object->getId();
        $view->do = 'save';
    }
    else
        $view->data = $session->getZone(true);
    
    
    
    $view->type = $object_type;
    
    $text = $view->render('bit/sell/' . $object_type_code . '/auth/step_1');
    
    $session = Dune_Session::getInstance('data');
    
/*    ob_start();
    echo $session;
    $text .= ob_get_clean();
*/        
    $session = Dune_Session::getInstance('control');
    $session->step = 1;