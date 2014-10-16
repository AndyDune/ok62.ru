<?php
        $session = Dune_Session::getInstance('request');
        $session->edit = -1;
        $session->step = 1;

$URL = Dune_Parsing_UrlSingleton::getInstance();

    $view = Dune_Zend_View::getInstance();

    $cooc = Dune_Cookie_ArraySingleton::getInstance(Dune_Parameters::$cookieNameSystem);
    

    $session = Dune_Session::getInstance('request');
    
    $post = Dune_Filter_Post_Total::getInstance();
    if ($post['new'])
    {
            $object_type_code = '';
            $object_type_id = 0;
            
    if (in_array($post['new'], Special_Vtor_Settings::$typeCodeToString))
    {
        $object_type_id = array_search($post['new'], Special_Vtor_Settings::$typeCodeToString);
        $object_type_code = $post['new'];
    }        
    
            if (!$object_type_code)
            {
                throw new Dune_Exception_Control_Goto('/public/request/');
            }
            
            $current = Special_Vtor_Object_Request_DataSingleton::getInstance();
            $current->setUserId(Special_Vtor_User_Auth::$id); 
            $time = $current->getLastInsertTime();
            if (
                $time !== false
                 and
                 time() - $time < Special_Vtor_Settings::$timeIntervalObjectToAdd
               )
                throw new Dune_Exception_Control('Часто создается объект на редактирование.', 54);

            if ($current->getCount() >= Special_Vtor_Settings::$maxRequestCount)
                throw new Dune_Exception_Control('Слишком много.', 4);
                
/*         
           $current_object->setTypeId($object_type_id);
            $current_object->setUserId(Special_Vtor_User_Auth::$id);
            $session->edit = $current_object->add();
*/            

            $session = Dune_Session::getInstance('request');
            $session->object_type_id = $object_type_id;
            $session->object_type_code = $object_type_code;
            $session->new = true;
            
            throw new Dune_Exception_Control_Goto('/public/request/edit/' . $object_type_code . '/');
    
    }
    
    $view->text = $view->render('bit/request/main/invitation_auth');

    $view->h1_code = '/public/request/main/'; //'Заявка на размещение объекта в каталоге';
    echo $view->render('bit/general/container_padding_for_auth_extend');

