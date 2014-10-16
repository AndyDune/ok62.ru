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

//        echo  $object;
     
    if ($URL['6'] == 'plan')
        $folder_name = new Dune_Data_Container_Folder('plan');
    else 
        $folder_name = new Dune_Data_Container_Folder('type_' . $object->code_type);
    $folder_name->setPath(dirname(__FILE__));
    $folder_name->registerDefault('type_room'); // Обработка квартир
    $folder_name->register('type_room'); // Обработка квартир
    $folder_name->register('type_house'); // Дома
    $folder_name->register('type_garage'); // Гаражи
    $folder_name->register('type_nolife'); // Нежилые помещения
    $folder_name->register('type_pantry'); // Складские помещения
    $folder_name->register('plan');
    $folder_name->check();
    
    $folder_name->object = $object->getInfo();

    if ($object->street_id > 0)
    {
        $folder_name->adress_code = 'street';
        $folder_name->adress_id = $object->street_id;
    }
    $folder_url->addFolder($URL['5']);
    
    
    echo $folder = new Dune_Include_Folder($folder_name, Dune_Variables::$userStatus);
    echo 
    '
    <ul>
    <li><a href="' . $folder_url->get() . '">Информация и фото</a></li>
    <li><a href="' . $folder_url->get() . 'plan/">Планировка</a></li>
    </ul>
    ';

    
    $this->results = $folder->getResults();
    $this->status = $folder->getStatus();
    Dune_Static_StylesList::add('object:add', 200);
    
}
catch (Dune_Exception_Control_Goto $e)
{
    Dune_Static_Header::location($e->getMessage());
    $this->status = Dune_Include_Command::STATUS_TEXT;
}