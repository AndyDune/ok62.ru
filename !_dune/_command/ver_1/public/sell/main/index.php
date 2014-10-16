<?php
        $session = Dune_Session::getInstance('control');
        $session->edit = -1;
        $session->step = 1;

$URL = Dune_Parsing_UrlSingleton::getInstance();

    $view = Dune_Zend_View::getInstance();
    

    $cooc = Dune_Cookie_ArraySingleton::getInstance(Dune_Parameters::$cookieNameSystem);
    if (isset($cooc['temp']['id']) and isset($cooc['temp']['type_code']))
    {
        $view->last_edit = $cooc['temp'];
    }
    unset($cooc['temp']);

    $session = Dune_Session::getInstance('control');
    
    $post = Dune_Filter_Post_Total::getInstance();
    if ($post['new'])
    {
            $object_type_code = '';
            $object_type = 0;
            switch ($post['new'])
            {
                case 'room':
                    $object_type_code = 'room';
                    $object_type = 1;
                break;
                case 'garage':
                    $object_type_code = 'garage';
                    $object_type = 3;
                break;
                case 'nolife':
                    $object_type_code = 'nolife';
                    $object_type = 4;
                break;
            }
            
            if (!$object_type_code)
            {
                echo $object_type_code;
//                die();
                throw new Dune_Exception_Control_Goto('/public/sell/');
            }
            $current_object = Special_Vtor_Object_Query_DataSingleton::getInstance();
            $current_object->setUserId(Special_Vtor_User_Auth::$id); 
            $time = $current_object->getLastObjectInsertTime();
//            echo time() - $time;
            if (
                $time !== false
                 and
                 time() - $time < Special_Vtor_Settings::$timeIntervalObjectToAdd
               )
                throw new Dune_Exception_Control('Часто создается объект на редактирование.', 54);

            if ($current_object->getCountObjectsInsertInQuery() >= Special_Vtor_Settings::$maxObjectsInQueryToAdd)
                throw new Dune_Exception_Control('Слишком много.', 4);
                
            $session = Dune_Session::getInstance('control');
            $current_object->setTypeId($object_type);
            $current_object->setUserId(Special_Vtor_User_Auth::$id);
            $session->edit = $current_object->add();
            throw new Dune_Exception_Control_Goto('/public/sell/' . $object_type_code . '/');
            
    
    }
    
    $view->text = $view->render('bit/sell/main/invitation_auth');

    $view->h1_code = '/public/sell/main/'; //'Заявка на размещение объекта в каталоге';
    echo $view->render('bit/general/container_padding_for_auth_extend');

