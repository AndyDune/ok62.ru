<?php

    $status = Special_Vtor_Object_Query_StatusContainerForAuthUser::getInstance(Special_Vtor_User_Auth::$id);
    $object = $status->getNotFinished();

    $session = Dune_Session::getInstance('control');
    $current_object = Special_Vtor_Object_Query_DataSingleton::getInstance($session->edit);        
    if (!$current_object->isFromBd())
    {
        throw new Dune_Exception_Control('Потеря сеанса.', 55);
    }
    
    
    $post = Dune_Filter_Post_Total::getInstance();
    if (isset($post['_do_']))
    {
         $module = new Module_Catalogue_Object_Save_CheckRequire();
         $module->data = $current_object->getData(true);
         $module->make();
         if (!$module->getResult('success'))
             throw new Dune_Exception_Control('Не заполнены обязательные поля.', 1);
        
        $current_object->setStatus(1);
        $current_object->save();
        
        $module = new Module_Catalogue_Object_Save_DoAfterSendToSell();
        $module->object_id = $session->edit;
        $module->make();
        
        throw new Dune_Exception_Control_Goto('/user/sell/request/');
    }
    
    //$view->data = $post;
//    $object = new Special_Vtor_Object_Query_Data();
//    $object->setUserId(Special_Vtor_User_Auth::$id);
            
    $object_condition = new Special_Vtor_Object_Condition();
    $object_condition = $object_condition->getList($object_type);
    $object_planning = new Special_Vtor_Object_Planning();
    $object_planning = $object_planning->getList();

    $view->status = $current_object->getStatus();
       
    $view->condition = $object_condition;
    $view->planning = $object_planning;
    
    $house_type = new Special_Vtor_Object_Add_HouseType();
    $view->house_type = $house_type->getListType($object_type);
    
    
    $session = Dune_Session::getInstance('data');
    
    $view->data = $current_object->getData(true);
    $view->id = $current_object->getId();
    
    
    $photo = new Special_Vtor_Object_Query_Image($current_object->getId(), $current_object->getTime());
    $plan = new Special_Vtor_Object_Query_Plan($current_object->getId(), $current_object->getTime());
    
    $array_photo = array();
    if (count($photo))
    {
        foreach ($photo as $key => $value)
        {
            $array_run[0] = $value->getSourseFileName();
            $array_run[1] = $value->getSourseFileUrl();
            $array_run[2] = $value->getPreviewFileUrl();
            $array_photo[] = $array_run;
        }
    }

    $array_plan = array();
    if (count($plan))
    {
        foreach ($plan as $key => $value)
        {
            $array_plan[0]  = $value->getSourseFileName();
            $array_plan[1]  = $value->getSourseFileUrl();
            $array_plan[2]  = $value->getPreviewFileUrl();
        }
    }
    
    $view->array_photo = $array_photo;
    $view->array_plan = $array_plan;
        
        
    
    $view->type = $current_object->getTypeId();
    
    
    $text = $view->render('bit/sell/' . $object_type_code . '/auth/step_10');
    
    $session = Dune_Session::getInstance('data');
    
/*    ob_start();
    echo $session;
    $text .= ob_get_clean();
*/        
    $session = Dune_Session::getInstance('control');
    $session->step = 10;