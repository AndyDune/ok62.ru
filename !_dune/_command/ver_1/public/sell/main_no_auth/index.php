<?php

        $session = Dune_Session::getInstance('control');
        $session->edit = -1;
        $session->step = 1;

$URL = Dune_Parsing_UrlSingleton::getInstance();

    $view = Dune_Zend_View::getInstance();
    
    
    $cooc = Dune_Cookie_ArraySingleton::getInstance(Dune_Parameters::$cookieNameSystem);
    if (isset($cooc['edit']) and $cooc['edit_type'] == 'object' and isset($cooc['edit_type_code']))
    {
        $arr['type_code'] = $cooc['edit_type_code'];
        $arr['id'] = $cooc['edit'];
        $view->last_edit = $arr;
    }
    else 
    {

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
                die();
                throw new Dune_Exception_Control_Goto('/public/sell/');
            }
            $cooc['edit'] = md5(uniqid('id', true));
            $cooc['edit_type'] = 'object';
            $cooc['edit_type_code'] =  $object_type_code;
            $cooc['have_object_to_sell'] = true;
            $current_object = Special_Vtor_Object_Query_AuthNo_DataSingleton::getInstance($cooc['edit']);
            $time = false; //$current_object->getLastObjectInsertTime();
            if (
                $time !== false
                 and
                 time() - $time < Special_Vtor_Settings::$timeIntervalObjectToAdd
               )
                throw new Dune_Exception_Control('Часто создается объект на редактирование.', 54);
    
            $current_object->setTypeId($object_type);
            $session->edit = $cooc['edit'];
            $current_object->add();
            $session->step = 1;
            throw new Dune_Exception_Control_Goto('/public/sell/' . $object_type_code . '/');
            
        }
        
    }
    
    $view->text = $view->render('bit/sell/main/invitation_auth_no');

    $view->h1_code = '/public/sell/main/'; //'Заявка на размещение объекта в каталоге';
    echo $view->render('bit/general/container_padding_for_auth_extend');
    
    
//    $view->text = $view->render('bit/sell/main/invitation_auth_no');

//    echo $view->render('bit/general/container_padding_for_auth');

