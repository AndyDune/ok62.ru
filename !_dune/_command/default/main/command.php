<?php
Dune_Static_StylesList::add('main:base');

$view = Dune_Zend_View::getInstance();
$view->view_folder = Dune_Variables::$pathToViewFolder;
/////////////////////////////////////////////////
///     Список типов с числом объектов в сиситеме
$types_list = new Special_Vtor_Object_Types();
///
/////////////////////////////////////////////////

/////////////////////////////////////////////////
///     Список объектов последних в системе
$objects_list = new Special_Vtor_Object_List();
$objects_list->setOrderTimeInsert('DESC');
$objects_list->setActivity(1);
///
/////////////////////////////////////////////////
$view->objects_list = $objects_list->getListCumulate(0, 10);
$view->objects_count = $objects_list->count();
$view->types_list = $types_list->getListTypeWithObjectsActive();;

echo $view->render('page/main/default');

