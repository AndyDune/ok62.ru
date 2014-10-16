<?php
// Модуль, отдающий поле аутентифокации если пользовательне опознан
// Либо поле информации о пользователе.

$view = Dune_Zend_View::getInstance();
Dune_Static_StylesList::add('user/auth');
    $cooc = Dune_Cookie_ArraySingleton::getInstance(Dune_Parameters::$cookieNameSystem);    

$folder = Dune_Data_Collector_UrlSingleton::getInstance();
$URL = Dune_Parsing_UrlSingleton::getInstance();

$post = Dune_Filter_Post_Total::getInstance();
$post->trim();
if ($post['_do_'] == 'export')
{
    if (!$post['folder'])
        throw new Dune_Exception_Control_Goto('', 2);
    $module = new Module_Catalogue_SimpleExport();
    $module->folder = $post['folder'];
    $module->folder_main = '_temp/export';
    $module->make();
    if ($module->getResult('success'))
        throw new Dune_Exception_Control_Goto('', 1);
    else 
        throw new Dune_Exception_Control_Goto('', 10);
}

$session = Dune_Session::getInstance('export');
$view->text = $session->text;
$session->text = null;

echo $view->render('page/system/export');

    
    // Запрет отображения панели пользователя
$this->results['no_user_panel'] = true;
