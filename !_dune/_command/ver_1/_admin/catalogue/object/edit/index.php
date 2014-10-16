<?php
/////       ВЕТВЬ
///////////////////////////////
////     
///     Страница в разделе каталога - редактирование зарегистрированных алресов.
///

    // $URL['5'] - id редактируемого объекта.
    $URL = Dune_Parsing_UrlSingleton::getInstance();
    $folder_url = Dune_Data_Collector_UrlSingleton::getInstance();

try
{    
    if (!(int)$URL['5'])
        throw new Dune_Exception_Control_Goto(Dune_Parameters::$pageInternalReferer);

    $object = new Special_Vtor_Object_Data((int)$URL['5']);
    if (!$object->check())
        throw new Dune_Exception_Control_Goto(Dune_Parameters::$pageInternalReferer);

//        echo  $object; die();
     
    if ($URL['6'] == 'plan')
        $folder_name = new Dune_Data_Container_Folder('plan');
    else if ($URL['6'] == 'floor')
        $folder_name = new Dune_Data_Container_Folder('floor');
    else if ($URL['6'] == 'situa')
        $folder_name = new Dune_Data_Container_Folder('situa');
    else if ($URL['6'] == 'gm')
        $folder_name = new Dune_Data_Container_Folder('gm');
        
    else if ($URL['6'] == 'copy')
        $folder_name = new Dune_Data_Container_Folder('copy');
    else 
        $folder_name = new Dune_Data_Container_Folder('type_' . $object->code_type);
        
       
    $view = Dune_Zend_View::getInstance();
    $session = Dune_Session::getInstance('edit_object');
    if ($session->copy_id)
    {
        $view->copy_id = $session->copy_id;
        $URL->cutCommands(5)->setCommand($session->copy_id, 5);
        $view->copy_original_url = $URL->getCommandString();
        $URL->clearModifications();
        $session->copy_id = null;
    }
         
        
    $folder_name->setPath(dirname(__FILE__));
    $folder_name->registerDefault('type_room'); // Обработка квартир
    $folder_name->register('type_room'); // Обработка квартир
    $folder_name->register('type_house'); // Дома
    $folder_name->register('type_garage'); // Гаражи
    $folder_name->register('type_nolife'); // Нежилые помещения
    $folder_name->register('type_pantry'); // Складские помещения
    $folder_name->register('type_land'); // Земельные участки
    $folder_name->register('plan');
    $folder_name->register('gm');
    $folder_name->register('floor');
    $folder_name->register('situa');
    $folder_name->register('copy');
    $folder_name->check();
    
    $data = $object->getInfo();
    
    foreach ($data as $key => $value)
    {// echo $key . ' => ' . $value . '<br>';
        if (!$value)
        {
            $data[$key] = '';
        }
    }
    
    $folder_name->object = $data;
    
    

    if ($object->street_id > 0)
    {
        $folder_name->adress_code = 'street';
        $folder_name->adress_id = $object->street_id;
    }
    else if ($object->district_id > 0)
    {
        $folder_name->adress_code = 'district';
        $folder_name->adress_id = $object->district_id;
    }
    else if ($object->settlement_id > 0)
    {
        $folder_name->adress_code = 'settlement';
        $folder_name->adress_id = $object->settlement_id;
    }
    
    $folder_url->addFolder($URL['5']);
    
     
    
    $folder_name->top_menu = 
    '
    <ul>
    <li style="text-align:right;"><a href="' . $folder_url->get() . 'copy/">Копировать</a></li>
    </ul>
    ';

    
    echo $folder = new Dune_Include_Folder($folder_name, Dune_Variables::$userStatus);
    echo 
    '
    <ul>
    <li><a href="' . $folder_url->get() . '">Информация и фото</a></li>
    <li><a href="' . $folder_url->get() . 'plan/">Планировка</a></li>
    <li><a href="' . $folder_url->get() . 'floor/">План этажа</a></li>
    <li><a href="' . $folder_url->get() . 'situa/">Ситуационый план</a></li>
    <li><a href="' . $folder_url->get() . 'gm/">На карте</a></li>
    <li>&nbsp;</li>
    <li>&nbsp;</li>
    <li><a href="' . $folder_url->get() . 'copy/">Копировать</a></li>
    </ul>
    ';

    $post = Dune_Filter_Post_Total::getInstance();
    if ($post->_do_)
    {
        $cache = Dune_Zend_Cache::getInstance();
        $cache->clean(Zend_Cache::CLEANING_MODE_MATCHING_TAG, array(Special_Vtor_Settings::CACHE_TAG_CATALOGUE));
    }
    
    $this->results = $folder->getResults();
    $this->status = $folder->getStatus();
    Dune_Static_StylesList::add('object:add', 200);
    
}
catch (Dune_Exception_Control_Goto $e)
{
    Dune_Static_Header::location($e->getMessage());
    $this->status = Dune_Include_Command::STATUS_TEXT;
}