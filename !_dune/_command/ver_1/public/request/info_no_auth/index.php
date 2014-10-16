<?php
Dune_Static_Header::noCache();
$URL = Dune_Parsing_UrlSingleton::getInstance();

    $cooc = Dune_Cookie_ArraySingleton::getInstance(Dune_Parameters::$cookieNameSystem);
    
$my = false;
$look = false;
$have = false;
try
{
    $get = Dune_Filter_Get_Total::getInstance();

    if ($URL[4] > 0)
    {
        $current = Special_Vtor_Object_Request_NoAuth_DataSingleton::getInstance($URL[4]);
        $current->useIdGetDataFromDb($URL[4]);
        if (!$current->isFromBd())
        { 
            throw new Dune_Exception_Control_Goto('Нет такой заявки.', 51);
        }
        if ($current->getUserCode() === $cooc[Special_Vtor_Settings::NO_AUTH_USER_CODE_KEY])
        {
            $my = true;
            $have = $current->getCount();
        }
        $data = $current->getData(true);
        if ($data['public'])
        {
            $look = true;
            $have = $current->getCount();
        }

        if (!$my and !$look) // Нельзя смотреть чужое или если статус не позволяет
        {
            $this->setStatus(Dune_Include_Command::STATUS_GOTO);
            $this->setResult('goto', '/public/request/');
            return;
        }
        
        
            $user = false;
            $array_photo = false;

        $object_type_id = $current->getTypeId();
        $URL[4] = $object_type_code = Special_Vtor_Types::$typesToRequest[$object_type_id];
        $edit = $current->getId();
        
    }
    else 
    {
        throw new Dune_Exception_Control_Goto('/public/request/');
    }
        
    $view        = Dune_Zend_View::getInstance();
    
/*    if ($data['text'])
    {
        $name = 'array' . ucfirst($current->getTypeCodeName());
        if (!isset(Special_Vtor_RequestQuestions::$$name))
            $name = 'array';
        foreach (Special_Vtor_RequestQuestions::$$name as $value)
        {
            $data['text'] = str_replace($value . "\r\n", '<h4 style="margin:10px 0 0 0; padding:0;">' . htmlspecialchars($value) . '</h4>', $data['text']);
        }
        $data['text'] = str_replace("\r\n", '<br />', $data['text']);
   }
*/    
    $view->data  = $data;
    $view->edit  = $edit;
    $view->my    = $my;    
    $view->have  = $have;    


    $view->object_type_code = $object_type_code;
    
//    $view->steps_panel = $view->render('bit/request/panel');
    
    
    Dune_Variables::addTitle('Заявка на покупку недвижимости.');
    Dune_Variables::$pageDescription = 'Заявка на покупку недвижимости.';
    
    $view->types = Special_Vtor_Types::$typesToRequest;
    $view->user = $user;
    $view->array_photo = $array_photo;
                
    //$view->text = $view->render('bit/request/info/' . $object_type_code);
    $view->text = $view->render('bit/request/info/common_no_auth');
    
    //$view->h1 = $view->render('bit/request/info/h1/' .  $object_type_code);
    $view->h1 = $view->render('bit/request/info/h1/common');
    
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