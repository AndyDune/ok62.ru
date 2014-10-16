<?php
/////       ВЕТВЬ
///////////////////////////////
////     
///     Страница в разделе каталога - редактирование зарегистрированных алресов.
///
    $URL = Dune_Parsing_UrlSingleton::getInstance();
    $folder_url = Dune_Data_Collector_UrlSingleton::getInstance();

try
{    
    $URL5 = new Dune_String_Explode($URL['5'], '-', 1);
    if ($URL5->count() < 4)
        throw new Dune_Exception_Control_Goto(Dune_Parameters::$pageInternalReferer);
            
    
    $folder_name = new Dune_Data_Container_Folder('type_' . $URL5[4]);
    $folder_name->setPath(dirname(__FILE__));
    $folder_name->registerDefault('type_room'); // Обработка квартир
    $folder_name->register('type_room'); // Обработка квартир
    $folder_name->register('type_house'); // Дома
    $folder_name->register('type_garage'); // Гаражи
    $folder_name->register('type_nolife'); // Нежилые помещения
    $folder_name->register('type_pantry'); // Складские помещения
    
    $folder_name->check();

    if (!in_array($URL5[1], array('street'))) // Незарегистрированный начальный адресс
        throw new Dune_Exception_Control_Goto(Dune_Parameters::$pageInternalReferer);
    $folder_name->adress_code = $URL5[1];
    $folder_name->adress_id = $URL5[2];
    
    $folder_url->addFolder($URL['5']);
    
    echo $folder = new Dune_Include_Folder($folder_name, Dune_Variables::$userStatus);
    
    $this->results = $folder->getResults();
    $this->status = $folder->getStatus();
    Dune_Static_StylesList::add('object:add');
    
}
catch (Dune_Exception_Control_Goto $e)
{
    Dune_Static_Header::location($e->getMessage());
    $this->status = Dune_Include_Command::STATUS_TEXT;
}