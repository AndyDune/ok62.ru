<?php
Dune_Static_Header::noCache();
$URL = Dune_Parsing_UrlSingleton::getInstance();

$session = Dune_Session::getInstance('request');
$object_type_id = $session->object_type_id;
$object_type_code = $session->object_type_code;

try
{
    $get = Dune_Filter_Get_Total::getInstance();

    if ($URL[4] > 0)
    {
        $current = Special_Vtor_Object_Request_DataSingleton::getInstance($URL[4]);
        $current->useIdGetDataFromDb($get->getDigit('edit'));
        if (!$current->isFromBd())
        { 
            throw new Dune_Exception_Control_Goto('Нет такой заявки.', 51);
        }
        if ($current->getUserId() != Special_Vtor_User_Auth::$id)
        {
            throw new Dune_Exception_Control_Goto('Редактировать чужое нельзя.', 53);
        }
// Не обозначается как редактируемое
//        $current_object->setStatus(0);
//        $current_object->save();
        $session->clearZone();
        
        $object_type_id = $session->object_type_id = $current->getTypeId();
        $URL[4] = $object_type_code = $session->object_type_code = $current->getTypeCodeName();
        $session->edit = $current->getId();
        $session->data = $current->getData(true);
        
    }
    else 
    {
        throw new Dune_Exception_Control_Goto('/user/request/');
    }
        
    $view        = Dune_Zend_View::getInstance();
    $view->data  = $session->data;
    $view->edit  = $session->edit;
    
    $view->action = $URL->getCommandString();

    $view->object_type_code = $object_type_code;
    
//    $view->steps_panel = $view->render('bit/request/panel');
    
    $cooc = Dune_Cookie_ArraySingleton::getInstance(Dune_Parameters::$cookieNameSystem);
    $array['type_code'] = $object_type_code;
    $array['id'] = $session->edit;
    $cooc['temp'] = $array;
    
    Dune_Variables::addTitle('Просмотр заявки на покупку недвижимости');
    Dune_Variables::$pageDescription = 'Просмотр заявки на покупку недвижимости.';
    
    //$URL[4] = 'step';
    
    $view->text = $view->render('bit/request/info/' . $object_type_code);
    
//    echo $view->render('bit/general/container_padding_for_auth');
    $view->h1 = $view->render('bit/request/info/h1/' .  $object_type_code);
    echo $view->render('bit/general/container_padding_for_auth_extend');
    Dune_Static_StylesList::add('catalogue/request');
}

catch (Dune_Exception_Control_Goto $e)
{
    if ($e->getCode() > 50)
    {
        $session = Dune_Session::getInstance('control');
        unset($session->edit);
        $this->setResult('goto', '/public/request/');
        
        Dune_Static_Message::setCode($e->getCode());
    }
    else 
    {
        $this->setResult('goto', $e->getMessage());
    }
    $this->setStatus(Dune_Include_Command::STATUS_GOTO);
}
catch (Dune_Exception_Control $e)
{
    if ($e->getCode())
    {
        Dune_Static_Message::setCode($e->getCode());
        $this->setStatus(Dune_Include_Command::STATUS_EXIT);
    }
    else 
        $this->setStatus(Dune_Include_Command::STATUS_EXIT);
}