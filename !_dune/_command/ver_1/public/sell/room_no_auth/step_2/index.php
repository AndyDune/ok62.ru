<?php
    $post = Dune_Filter_Post_Total::getInstance();
    $get = Dune_Filter_Get_Total::getInstance();
    
    $session = Dune_Session::getInstance('control');
    
    if (isset($get['delete']))
    {
        $photo = new Special_Vtor_Object_Query_ImageAuthNo($current_object->getId(), $current_object->getTime());
        @unlink($photo->getSystemUrl() . '/' . $get['name']);
        $photo->deletePreviewFolder();
        
        throw new Dune_Exception_Control('Ñäåëàëè');
    }    
    if (isset($post['_do_']))
    {
        $photo = new Special_Vtor_Object_Query_ImageAuthNo($current_object->getId(), $current_object->getTime(), true);    
        
        switch ($post['_do_'])
        {
            case 'save':
                $module = new Module_File_Picture_Save_PostList();
                $module->folder = $photo->getSystemUrl();
                $module->name = 'photo';
                $module->size = 900;
                $module->max_files_count = Special_Vtor_Settings::$maxCountPhotoLoad;
                $module->make();

                
                $photo->deletePreviewFolder();

            break;
        }
        
        throw new Dune_Exception_Control('Ñäåëàëè');
    }
    
    $photo = new Special_Vtor_Object_Query_ImageAuthNo($current_object->getId(), $current_object->getTime());
    
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

    
    $view    = Dune_Zend_View::getInstance();
    $view->count_images_to_load = Special_Vtor_Settings::$maxCountPhotoLoad - count($array_photo);
    $view->array_photo = $array_photo;
    
    $view->url = '/public/sell/' . $object_type_code . '/step_2/';
    
    $view->type = $object_type;
    
   
    $text = $view->render('bit/sell/' . $object_type_code . '/auth/step_2');
    
    $session = Dune_Session::getInstance('data');
    
/*    ob_start();
    echo $session;
    $text .= ob_get_clean();
*/        
    $session = Dune_Session::getInstance('control');
    $session->step = 2;