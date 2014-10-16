<?php
    $post = Dune_Filter_Post_Total::getInstance();
    $get = Dune_Filter_Get_Total::getInstance();
    
    $session = Dune_Session::getInstance('control');
//    $current_object = Special_Vtor_Object_Query_DataSingleton::getInstance($session->edit);        
    
    if (isset($get['delete']))
    {
        $plan = new Special_Vtor_Object_Query_PlanAuthNo($current_object->getId(), $current_object->getTime());    
        @unlink($plan->getSystemUrl() . '/' . $get['name']);
        $plan->deletePreviewFolder();
        
        throw new Dune_Exception_Control('Ñäåëàëè');
    }    
    if (isset($post['_do_']))
    {
        $plan = new Special_Vtor_Object_Query_PlanAuthNo($current_object->getId(), $current_object->getTime(), true);    
        
        switch ($post['_do_'])
        {
            case 'save':

                $module = new Module_File_Picture_Save_PostList();
                $module->name = 'plan';
                $module->size = 900;
                $module->folder = $plan->getSystemUrl();
                $module->max_files_count = 1;
                $module->make();
                
                $plan->deletePreviewFolder();
            break;
        }
        
        throw new Dune_Exception_Control('Ñäåëàëè');
    }
    
    $plan = new Special_Vtor_Object_Query_PlanAuthNo($current_object->getId(), $current_object->getTime());
    
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
    
    $view    = Dune_Zend_View::getInstance();

    $view->array_plan = $array_plan;
    
    $view->url = '/public/sell/' . $object_type_code . '/step_3/';
    
    $view->type = $object_type;
    
    
    $text = $view->render('bit/sell/' . $object_type_code . '/auth/step_3');
    
    $session = Dune_Session::getInstance('data');
    
/*    ob_start();
    echo $session;
    $text .= ob_get_clean();
*/        
    $session = Dune_Session::getInstance('control');
    $session->step = 3;