<?php

    $session = Dune_Session::getInstance('control');
//    $current_object = Special_Vtor_Object_Query_DataSingleton::getInstance($session->edit);        
    if (!$current_object->isFromBd())
    {
        throw new Dune_Exception_Control('Ïîòåğÿ ñåàíñà.', 55);
    }
    
    $view->type = $current_object->getTypeId();
    
    
    
    Dune_Static_StylesList::add('catalogue/info_panorama');
    
    $get = Dune_Filter_Get_Total::getInstance();
    $view->number = $get->getDigit('number', 1);
    $view->base_url = '/public/sell/' . $object_type_code . '/step_9/';
    
    if (Dune_Parameters::$ajax)
        $text = $view->render('bit/sell/' . $object_type_code . '/auth/step_9_ajax');
    else 
        $text = $view->render('bit/sell/' . $object_type_code . '/auth/step_9');
    
    //$this->setStatus(Dune_Include_Command::STATUS_AJAX);
    
/*    ob_start();
    echo $session;
    $text .= ob_get_clean();
*/        
    $session = Dune_Session::getInstance('control');
    $session->step = 9;