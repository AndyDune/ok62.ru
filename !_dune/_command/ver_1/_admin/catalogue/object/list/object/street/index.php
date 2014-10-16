<?php
/////       Лист
///////////////////////////////
////     
///     Список объектов улицы или поселка или района.
///
    $URL = Dune_Parsing_UrlSingleton::getInstance(); // Сачас 6-я возможна
    $folder_url = Dune_Data_Collector_UrlSingleton::getInstance();
    $URL6 = new Dune_String_Explode($URL[6], '-');

try {
    if (!isset($URL6[1]) or $URL6[1] < 1)
        throw new Dune_Exception_Control_Goto(Dune_Parameters::$pageInternalReferer);

    
    $addres_line = new Special_Vtor_AdressLine($URL6[1]);

    $data_street = $addres_line->getDataStreet();
    if (!$data_street or !$data_street['id'])
        throw new Dune_Exception_Control_Goto($folder_url->getExeptLastFolder());
        
    $data_settlement = $addres_line->getDataSettlement();
    if (!$data_settlement['id'])
        throw new Dune_Exception_Control_Goto($folder_url->getExeptLastFolder());

    $data_area = $addres_line->getDataArea();
    if (!$data_area)
        throw new Dune_Exception_Control_Goto($folder_url->getExeptLastFolder());
        
    $data_region = $addres_line->getDataRegion();
    if (!$data_region)
        throw new Dune_Exception_Control_Goto($folder_url->getExeptLastFolder(2));
        
    $data_district = $addres_line->getDataDistrict();
    
    $link_list_area = $folder_url->getExeptLastFolder(2) . 'list/settlement/' . $data_area['id'] . '/';
    $link_list_region = $folder_url->getExeptLastFolder(2) . 'list/area/' . $data_region['id'] . '/';
    $link_list_settlement = $folder_url->getExeptLastFolder(2) . 'list/street/' . $data_settlement['id'] . '/';
    $link_list_district = $folder_url->getExeptLastFolder(2) . 'list/dstreet/' . $data_district['id'] . '/';
    
    
    $URL->cutCommands(4);
    
    $link_list_area = $URL->getCommandString() . 'settlement/' . $data_area['id'] . '/';
    $link_list_region = $URL->getCommandString() . 'area/' . $data_region['id'] . '/';
    $link_list_settlement = $URL->getCommandString() . 'street/' . $data_settlement['id'] . '/';
    $link_list_district = $URL->getCommandString() . 'dstreet/' . $data_district['id'] . '/';
    
    
    $crumbs = Dune_Display_BreadCrumb::getInstance();
    $crumbs->addCrumb('Области', $folder_url->getExeptLastFolder(2));
    $crumbs->addCrumb('Районы области: ' . $data_region['name'], $link_list_region);
    $crumbs->addCrumb('Посёлки района: ' . $data_area['name'], $link_list_area);
    if ($data_district['id'])
        $crumbs->addCrumb('Городские районы: ' . $data_district['name'], $link_list_district);    
    $crumbs->addCrumb('Улицы города: ' . $data_settlement['name'], $link_list_settlement);
    $crumbs->addCrumb('Объекты на улице: ' . $data_street['name']);
    echo $crumbs->getString();
    
    
    $OBJECTS_O = new Special_Vtor_Object_List();
    $OBJECTS_O->setShowWitoutHouseNumber();
    $OBJECTS_O->setStreet($data_street['id']);
    $OBJECTS_O->setOrder('street_id');
    $OBJECTS_O->setOrder('house_number');
    $OBJECTS_O->setShowWitoutHouseNumber();
    $OBJECTS = $OBJECTS_O->getListCumulate(0, 1000);
    
/*    echo '<br /> Всего: ', $OBJECTS->count();
    foreach ($OBJECTS as $value)
    {
        foreach ($value as $key => $value_2)
        {
            echo '<br /> ' . $key . ' => ' .$value_2;
        }
    }
*/    

    $view = Dune_Zend_View::getInstance();
    $view->link_edit = $folder_url->getExeptLastFolder(2) . 'edit';
    $view->link_add = $folder_url->getExeptLastFolder(2) . 'add/street-' . $data_street['id'];

    $URL->cutCommands(3);    
    $view->link_edit = $URL->getCommandString() . 'edit';
    $view->link_add = $URL->getCommandString() . 'add/street-' . $data_street['id'];
    
    
    $type_list = new Special_Vtor_Object_Types();
    $type_list = $type_list->getListType();
    $type_list->count();
    $view->types = $type_list;
    $view->data = $OBJECTS;
    echo $view->render('page/catalogue/object/list/object.street');

}
catch (Dune_Exception_Control_Goto $e)
{
    Dune_Static_Header::location($e->getMessage());
    $this->status = Dune_Include_Command::STATUS_TEXT;
}