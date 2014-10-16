<?php

if (Special_Vtor_Settings::$districtPlus)
    $adress_plus = Special_Vtor_Settings::$districtPlusPostFix;
else 
    $adress_plus = '';


$session_zone = 'filter';

$url_info = new Special_Vtor_Catalogue_Url_Parsing();
Special_Vtor_Vars::$districtPlusInUrl = $url_info->isDistrictPlus(); // Есть ли в урле флаг использования районов-плюс
$URL = Dune_Parsing_UrlSingleton::getInstance();
$session = Dune_Session::getInstance($session_zone);

// Генеральный файл комманды catalogue
if ($session->type and $session->type != $url_info->getType())
{
    $module = new Module_Catalogue_Filter_Save_Transit();
    $module->type = $url_info->getType();
    $module->session_zone = $session_zone;
    $module->make();
}
$get = Dune_Filter_Get_Total::getInstance();
if ($get->show === 'all')
{
    $session->show_bad = 1; // Показ объектов, которые без дома.
    $session->type = $url_info->getType();
    $session->have = true;
    $this->setStatus(Dune_Include_Command::STATUS_EXIT);
    return;
}
if ($get->set === 'filter')
{
    $session->price_to = $get->getDigit('price'); // Показ объектов, которые без дома.
    $session->price_from = 1000; // Цена должна быть указана
    $session->type = $url_info->getType();
    
        if ($get['new_building_flag'] == 1)
        {
            $session->new_building_flag_1 = 1;
        }
        else 
            $session->new_building_flag_1 = null;
            
        if ($get['new_building_flag'] == 2)
        {
            $session->new_building_flag_0 = 1;
        }
        else 
            $session->new_building_flag_0 = null;
            
    $session->have = true;
    $this->setStatus(Dune_Include_Command::STATUS_GOTO);
    $this->setResult('goto', $URL->getCommandString(true) . '?version=' . $get->version);
    return;
}

if ($get->gm === 'yes')
{
    $cooc = Dune_Cookie_ArraySingleton::getInstance(Dune_Parameters::$cookieNameSystem);
    $cooc['gm'] = false;
    $this->setStatus(Dune_Include_Command::STATUS_EXIT);
    return;
}
if ($get->gm === 'no')
{
    $cooc = Dune_Cookie_ArraySingleton::getInstance(Dune_Parameters::$cookieNameSystem);
    $cooc['gm'] = true;
    $this->setStatus(Dune_Include_Command::STATUS_EXIT);
    return;
}

// Включение показа всего без группровки.
if ($get->show == 'no_group_in_list')
{
    $session = Dune_Session::getInstance();
    $session->no_group_in_list = true;
    $this->setStatus(Dune_Include_Command::STATUS_EXIT);
    return;
}

$post = Dune_Filter_Post_Total::getInstance();
if ($post->request_rent or $post->request_sale)
{
    if ($post->request_rent)
        $str = 'rent';
    else 
        $str = 'sale';
    $this->setStatus(Dune_Include_Command::STATUS_GOTO);
    $this->setResult('goto', '/public/request/list/mode_' . $str . '/');
    return;
}

/**
 * Отправляем по коду объекта на страницу.
 */
if ($post->object_code and strlen($post->object_code) > 0)
{
    $module = new Module_Catalogue_UrlFromCode();
    $module->object_code = $post->object_code;
    $module->make();
    if ($module->getResult('success'))
    {
        $session = Dune_Session::getInstance();
        $this->setStatus(Dune_Include_Command::STATUS_GOTO);
        $session->object_code = $post->object_code;
        $this->setResult('goto', $module->getResult('url'));
    }
    else 
        $this->setStatus(Dune_Include_Command::STATUS_EXIT);
    return;
}


if ($post->clear)
{
    $session->killZone();
    $this->setStatus(Dune_Include_Command::STATUS_EXIT);
    return;
}
$post = Dune_Filter_Post_Total::getInstance();
if ($post->filter == 'save')
{
    $post->trim();
    $post->setLength(11);
    
    $save = new Module_Catalogue_Filter_Save();
    $save->session_zone = $session_zone;
    $save->save_price = $post->save_price;
    $save->make();
//    die();
    if (strpos(Dune_Parameters::$pageInternalReferer, 'catalogue'))
    {
        $this->results['goto'] = str_replace('page', 'z', Dune_Parameters::$pageInternalReferer);
        $this->status = Dune_Include_Command::STATUS_GOTO;
    }
    else 
    {
        $this->status = Dune_Include_Command::STATUS_GOTO;
        $this->results['goto'] = '/catalogue/type/' . $post->type . '/adress' . $adress_plus . '/';
    }
    return;
}

$session = Dune_Session::getInstance();
if ($session->no_group_in_list)
    Special_Vtor_Settings::$useGroupInList = false;


$session = Dune_Session::getInstance($session_zone);
/*Dune_Static_StylesList::add('catalogue/base');
Dune_Static_StylesList::add('catalogue/info');
Dune_Static_StylesList::add('filter');
Dune_Static_StylesList::add('elements');

Dune_Static_StylesList::add('catalogue/adress_list');
Dune_Static_StylesList::add('catalogue/list');

Dune_Static_JavaScriptsList::add('thickbox');
*/

Dune_Static_JavaScriptsList::add('dune.catalogue');

$view = Dune_Zend_View::getInstance();
$view->object_code = $session->object_code;
$view->version = $get->version;

//$url_info = new Special_Vtor_Catalogue_Url_Parsing();

$adress_array = array();
/*
region - область
area - район в области
settlement - населённый пункт (город село деревня и т.д.) уникальный код
district - городской район
street - код улицы
house - дом 
building - корпус
*/
$objects_count = 0;

$text_elected = '';
$left_column = '';
$object_have = false;
    if ($url_info->getObject())
    {
        $object = new Special_Vtor_Object_Data($url_info->getObject());
        if ($object->check())
        {
            $object_have = true;
        }
    }

    
//////////////////////////
//////////////////////////


try {
    
    $get = Dune_Filter_Get_Total::getInstance();
    $URL = Dune_Parsing_UrlSingleton::getInstance();
    
    if ($get['set'])
    {
        $comm = 'set';
        $object = false;
    }
    else if ($URL[2] == 'spec')
    {
        $comm = 'spec';
        $object = false;
    }
    else if ($get['gm'])
    {
        $comm = 'gm';
        $object = false;
    }
    else if ($object_have)
    {
        $comm = 'info';
        if ($get['print'] == 'print')
            $comm = $comm . '_print';
    }
    else if (!in_array($url_info->getType(), array(1,2,3,4,5,6)))
    {
        $comm = 'main';
        $object = false;
    }
    else 
    {
        $comm = 'list';
        $object = false;
    }

    if (Dune_Parameters::$ajax)
    {
        if ($comm == 'info')
            $comm = $comm . '_ajax';
    }
    
    $folder_name = new Dune_Data_Container_Folder($comm);
    $folder_name->setPath(dirname(__FILE__))
                ->registerDefault('main')
                ->register('info')
                ->register('info_print')
                ->register('main')
                ->register('list')
                ->register('set')
                ->register('spec')
                ->register('gm')
                ->registerParameter('object', $object);
    
    $folder_name->check();
    
    $folder = Dune_Data_Collector_UrlSingleton::getInstance();
    $folder->addFolder($folder_name->getFolder());
//    $folder->url_info = $url_info;
    $folder_name->registerParameter('url_info', $url_info);
    
    
    $folder = new Dune_Include_Folder($folder_name, Dune_Variables::$userStatus);
    
    $this->setStatus($folder->getStatus());
    $this->results = $folder->getResults();
    echo $folder->getOutput();
    
}
catch (Dune_Exception_Control_Goto $e)
{
    if ($e->getCode())
    {
        Dune_Static_Message::setCode($e->getCode());
    }
    if ($e->getMessage())
    {
        $this->setStatus(Dune_Include_Command::STATUS_GOTO);
        $this->setResult('goto', $e->getMessage());
    }
    else 
    {
        $this->setStatus(Dune_Include_Command::STATUS_EXIT);
    }
}
catch (Dune_Exception_Control_NoAccess $e)
{
    if ($e->getCode())
    {
        Dune_Static_Message::setCode($e->getCode());
    }
    if ($e->getMessage())
    {
        Dune_Static_StylesList::add('user/info/message');
        $view = Dune_Zend_View::getInstance();
        echo $view->render($e->getMessage());
    }
    else 
    {
        $this->setResult('goto', '/');
        $this->setStatus(Dune_Include_Command::STATUS_EXIT);
    }
}



//////////////////////////
/////////////////////////
    
