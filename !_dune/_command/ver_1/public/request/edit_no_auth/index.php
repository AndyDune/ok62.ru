<?php

    $cooc = Dune_Cookie_ArraySingleton::getInstance(Dune_Parameters::$cookieNameSystem);
    if (!$cooc[Special_Vtor_Settings::NO_AUTH_USER_CODE_KEY] or strlen($cooc[Special_Vtor_Settings::NO_AUTH_USER_CODE_KEY]) < 20)
    {
        $cooc[Special_Vtor_Settings::NO_AUTH_USER_CODE_KEY] = md5(uniqid('xxx'));
        $cooc[Special_Vtor_Settings::NO_AUTH_USER_CODE_KEY . 'have_request'] = false;
    }

Dune_Static_Header::noCache();
$URL = Dune_Parsing_UrlSingleton::getInstance();

$session = Dune_Session::getInstance('request');
$object_type_id = $session->object_type_id;
$object_type_code = $session->object_type_code;
$have = false;
try
{
    $get = Dune_Filter_Get_Total::getInstance();

    $post = Dune_Filter_Post_Total::getInstance();    
    if ($post['save'] == 'save')
    {
        if (!key_exists($post->getDigit('type'), Special_Vtor_Types::$typesToRequest))
        {
            $data = new Dune_Array_Container(array());
            foreach ($post as $key => $value)
            {
                 $data[$key] = $value;
            }
            $session->data = $data;
            throw new Dune_Exception_Control('��� ������������', 5);
        }
        
//////////////  �������� �����    ///////////////////////
        $session = Dune_Session::getInstance();
        if ((strlen($post['captcha']) < 3 or $post['captcha'] != $session->captcha) and $post->getDigit('edit') < 1)
        {
            $data = new Dune_Array_Container(array());
            foreach ($post as $key => $value)
            {
                 $data[$key] = $value;
            }
            $session = Dune_Session::getInstance('request');            
            $session->data = $data;
            
            throw new Dune_Exception_Control('�������� �������� ���.', 6);
        }
/////////////////////////////////////////////////////////
        
        $session = Dune_Session::getInstance('request');
        $object_type_id   = $session->object_type_id   = $post->getDigit('type');
        $object_type_code = $session->object_type_code = Special_Vtor_Types::getTypeCode($object_type_id);
        
        $module = new Module_Catalogue_Request_SaveNoAuth();
        $module->type_code = $object_type_code;
        $module->type_id = $object_type_id;
        $module->make();
        if ($module->getResult('success'))
        {
            $session = Dune_Session::getInstance('request');
            $session->killZone();
            throw new Dune_Exception_Control_Goto('/public/request/info/' . $module->getResult('id') . '/');
            //throw new Dune_Exception_Control();
        }
        
        $data = new Dune_Array_Container(array());
        foreach ($post as $key => $value)
        {
             $data[$key] = $value;
        }
        $session->data = $data;
        throw new Dune_Exception_Control('', 5);
        
    }
    else if (isset($get['edit']))
    {
        $current = Special_Vtor_Object_Request_NoAuth_DataSingleton::getInstance($get->getDigit('edit'));
        $current->useIdGetDataFromDb($get->getDigit('edit'));
        if (!$current->isFromBd())
        { 
            throw new Dune_Exception_Control_Goto('��� ����� ������.', 51);
        }
        if ($current->getUserCode() != $cooc[Special_Vtor_Settings::NO_AUTH_USER_CODE_KEY])
        {
            throw new Dune_Exception_Control_Goto('������������� ����� ������.', 53);
        }
        
        if ($get['delete'] == 'delete')
        {
            $current->delete();
            throw new Dune_Exception_Control('�������');
        }
// �� ������������ ��� �������������
//        $current_object->setStatus(0);
//        $current_object->save();
        $session->clearZone();
        
        $object_type_id = $session->object_type_id = $current->getTypeId();
        $object_type_code = $session->object_type_code = Special_Vtor_Types::getTypeCode($object_type_id);
        $session->edit = $current->getId();
        $session->data = $current->getData(true);
        
    }
    else
    {
//        $object_type_id   = $session->object_type_id   = array_search($URL[4], Special_Vtor_Settings::$typeCodeToString);
//        $object_type_code = $session->object_type_code = $URL[4];
     //   if (!($session->data instanceof Dune_Array_Container))
        $session = Dune_Session::getInstance('request');     
        $session->edit = null;
//        $session->data = new Dune_Array_Container(array());
//        $session->data['text'] = '';
    }
        
    if ($cooc[Special_Vtor_Settings::NO_AUTH_USER_CODE_KEY . 'have_request'])
    {
        $current = Special_Vtor_Object_Request_NoAuth_DataSingleton::getInstance();
        $current->setUserCode($cooc[Special_Vtor_Settings::NO_AUTH_USER_CODE_KEY]);
        $have = $current->getCount();
        if (!$have)
        {
            $cooc[Special_Vtor_Settings::NO_AUTH_USER_CODE_KEY . 'have_request'] = false;
        }
    }
    
/*    if (Special_Vtor_User_Auth::$id and $current->getUserId() == Special_Vtor_User_Auth::$id)
    {
        $have = $current->getCount();
    }
*/    

    $session = Dune_Session::getInstance('request');
    
    $view        = Dune_Zend_View::getInstance();
    $view->data  = $session->data;
    $view->edit  = $session->edit;
    $view->have  = $have;    
    
    $session->killZone();

    $captcha = new Dune_Zend_Captcha_Image();
    $captcha->setWordlen(4);
    $captcha->generate();
    $view->assign('captcha', $captcha->getImageLink());
    $session = Dune_Session::getInstance();
    $session->captcha = $captcha->getWord();
    
    
    $view->action = $URL->getCommandString();

    $view->object_type_code = $object_type_code;
    
//    $view->steps_panel = $view->render('bit/request/panel');
    
    $cooc = Dune_Cookie_ArraySingleton::getInstance(Dune_Parameters::$cookieNameSystem);
    $array['type_code'] = $object_type_code;
    $array['id'] = $session->edit;
    $cooc['temp'] = $array;
    
    Dune_Variables::addTitle('�������������� ������ �� ������� ������������');
    Dune_Variables::$pageDescription = '�������������� ������ �� ������� ������������.';
    
    
    $session = Dune_Session::getInstance(Dune_Session::ZONE_AUTH);
    $user = new Dune_Auth_Mysqli_UserActive($session->user_id);
    $view->user_object = $user;
    
    //$URL[4] = 'step';
    
    $view->types = Special_Vtor_Types::$typesToRequest;
    
    //$view->text = $view->render('bit/request/edit/' . $object_type_code);
    $view->text = $view->render('bit/request/edit/common_no_auth');
    
    //$view->h1 = $view->render('bit/request/edit/h1/' .  $object_type_code);
    $view->h1 = $view->render('bit/request/edit/h1/common');
    
    echo $view->render('bit/general/container_padding_for_auth_extend');
    Dune_Static_StylesList::add('catalogue/request');
    Dune_Static_JavaScriptsList::add('dune_form');
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