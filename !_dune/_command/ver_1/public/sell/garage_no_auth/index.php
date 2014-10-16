<?php
Dune_Static_Header::noCache();
$URL = Dune_Parsing_UrlSingleton::getInstance();
$object_type = 3;
$object_type_code = 'garage';

    $session = Dune_Session::getInstance('control');
    $cooc = Dune_Cookie_ArraySingleton::getInstance(Dune_Parameters::$cookieNameSystem);
    if (isset($cooc['edit']) and $cooc['edit_type'] == 'object' and isset($cooc['edit_type_code']))
    {
        $current_object = Special_Vtor_Object_Query_AuthNo_DataSingleton::getInstance($cooc['edit']);
        if (!$current_object->isFromBd())
        {
            throw new Dune_Exception_Control_Goto('Объект уделен. Время прошло', 51);
        }
//        $current_object->setStatus(0);
//        $current_object->save();
        $session->edit = $cooc['edit'];
        
    $object_type = $current_object->getTypeId();
    $session = Dune_Session::getInstance('control');
    $session->step = $URL->getCommandPart(4, 2, $session->getInt('step', 1));

    
    }
    else 
    {
        throw new Dune_Exception_Control_Goto('/public/sell/');
        
/*        $get = Dune_Filter_Get_Total::getInstance();
        if (!isset($get['new']))
        {
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
*/ 
       }
    
    
    // Выбираем номер шага из урла в4-ой команде, формае <слово>_<номер>
//    $session->step = $URL->getCommandPart(4, 2, $session->getInt('step', 1));
    
//    if (!$current_object) // Если нет обрабатываемого объекта переход всегда к 1-му шагу
//        $session->step = 1;
        
    $view          = Dune_Zend_View::getInstance();
    $view->step    = $session->step;

    $view->object_type_code = $object_type_code;
    $view->auth_no = 1;
    $view->steps_panel = $view->render('bit/sell/' . $object_type_code . '/auth_no/steps_panel');
    
    
    switch (true)
    {
        case (!$session->step or $session->step == 1):
            include(dirname(__FILE__) . '/step_1/index.php');
        break;
        case ($session->step == 2):
            include(dirname(__FILE__) . '/step_2/index.php');
        break;
        case ($session->step == 3):
            include(dirname(__FILE__) . '/step_3/index.php');
        break;
        case ($session->step == 9):
            include(dirname(__FILE__) . '/step_9/index.php');
        break;
        
        case ($session->step == 4): // GM
            include(dirname(__FILE__) . '/step_4/index.php');
        break;
        
        case ($session->step == 10):
            include(dirname(__FILE__) . '/step_10/index.php');
        break;
        
        default:
            include(dirname(__FILE__) . '/step_1/index.php');
    }
    
        
    Dune_Variables::$pageTitle = 'Продажа гаража. ' .  Dune_Variables::$pageTitle;
    Dune_Variables::$pageDescription = 'Отправка заявки на продажу гаража.';
    
    //$URL[4] = 'step';
    
    $view->text = $text;
    echo $view->render('bit/general/container_padding_for_auth');

