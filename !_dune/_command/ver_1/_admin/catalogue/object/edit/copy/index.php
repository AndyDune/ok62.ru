<?php
/////       Лист
///////////////////////////////
////     
///     Редактирование квартиры.
///
    $URL = Dune_Parsing_UrlSingleton::getInstance(); // Сачас 6-я возможна
    $folder_url = Dune_Data_Collector_UrlSingleton::getInstance();

    $session = Dune_Session::getInstance('edit_object');

    
try {
    
    $post = Dune_Filter_Post_Total::getInstance();
    $get = Dune_Filter_Get_Total::getInstance();
    
    $URL = Dune_Parsing_UrlSingleton::getInstance();
    $object = new Special_Vtor_Object_Data($URL['5']);
    if (!$object->check()) // Нет записи с таким id
        throw new Dune_Exception_Control_Goto(Dune_Parameters::$pageInternalReferer);
    
    if (false == ($id = $object->copy())) // Нет записи с таким id
        throw new Dune_Exception_Control_Goto(Dune_Parameters::$pageInternalReferer);
    
    $objectN = new Special_Vtor_Object_Data($id);
        
    $folder = '/catalogue/objects/' . substr($object->time_insert, 0, 4) . '/' . $object->id;
    $folderNew = '/catalogue/objects/' . substr($objectN->time_insert, 0, 4) . '/' . $id;
//    $folderNew = '/catalogue/objects/2020/' . $objectn->id;
    
    $copy = new Dune_Directory_Copy($folder, $folderNew);
    $copy->copy();
        
    $session = Dune_Session::getInstance('edit_object');
    $session->clearZone();
    $session->copy_id = $URL['5'];
    
//    echo 22;
//    die();
    $URL->cutCommands(5)->setCommand($id, 5);
    throw new Dune_Exception_Control_Goto($URL->getCommandString());

}
catch (Dune_Exception_Control_Goto $e)
{
    Dune_Static_Header::location($e->getMessage());
    $this->status = Dune_Include_Command::STATUS_TEXT;
}