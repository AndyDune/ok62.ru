<?php
$vars = Dune_Variables::getInstance();
$view = Dune_Zend_View::getInstance();

// Геристрируем базовый файл стилей
Dune_Static_StylesList::add('base', 1);
Dune_Static_StylesList::add('ie6', 200, Dune_Static_StylesList::MODE_IE6_STYLES);
Dune_Static_StylesList::add('ie7', 200, Dune_Static_StylesList::MODE_IE7_STYLES);
Dune_Static_StylesList::add('elements');
Dune_Static_JavaScriptsList::addDependent('jquery', 'fw');

$view->assign('text', Dune_Variables::$pageText);
$view->assign('title', Dune_Variables::$pageTitle);
$view->assign('description', Dune_Variables::$pageDescription);
$view->assign('keywords', Dune_Variables::$pageKeywords);


    Dune_Static_StylesList::add('catalogue/request');
    Dune_Static_JavaScriptsList::add('dune_form');


// Выборка поля аутентификации пользователя.
// Форма входя либо текущая короткая информация.
//if (!Dune_Variables::$results->no_user_panel and Special_Vtor_Users::$topMainBanners)
//{
if (!Dune_Variables::$results->no_user_panel)
{    
    $auth_field = new Module_Display_User_AuthField();
    $auth_field->make();
    $view->assign('auth_field_v2', $auth_field->getOutput());

    if (Special_Vtor_Users::$topMainBanners)
    {
        $banners = new Module_Display_Banners_Special();
        $banners->make();
        $view->assign('auth_field', $banners->getOutput());
    }    
    else 
    {
        Dune_Static_StylesList::add('subdomain_base');
    }

}

if ($view->getResult('run_string') and !$vars->subdomainFocusUserId)
{
    $module = new Module_Display_RunString();
    $module->make();
    $view->assign('runs_string', $module->getOutput());
}

if ($vars->subdomainFocusUserId)
{
    $file = $_SERVER['DOCUMENT_ROOT'] . '/data/subdomain/' . $vars->subDomain . '/menu.php';
    if (is_file($file))
    {
        ob_start();
        include($file);
        $view->assign('top_menu', ob_get_clean());
    }
}
else if (!Dune_Variables::$results->no_top_menu and Special_Vtor_Users::$topMenu)
{
    $view->current = '';
    $view->assign('top_menu', $view->render('bit/menu/general_top'));
}

                    
$view->view_realization = Dune_Parameters::$templateRealization;
$view->view_path = Dune_Variables::$pathToViewFolder;

// Время выполнения скрипта
$time = Dune_Time_IntervalSingleton::getInstance();
$view->assign('time', $time->getTime());

if (Dune_Objects::$command->getCommand() == 'main' and !$vars->subdomainFocusUserId)
{
    $module = new Module_Display_RunString();
    $module->view_path = Dune_Variables::$pathToViewFolder;
    $module->make();
    $view->assign('run_string', $module->getOutput());
}

$view_array = array(
                    'js' => Dune_Static_JavaScriptsList::get(),
                    'css' => Dune_Static_StylesList::get(),
                    );
$view->assign($view_array);

$view->subdomainFocusUserId = $vars->subdomainFocusUserId;


if (Dune_Objects::$command->getCommand() == 'main')
{
    $view->assign('objects_list_new', Dune_Variables::$results->objects_list_new);
    $view->assign('objects_list_pop', Dune_Variables::$results->objects_list_pop);
    $view->assign('objects_search', Dune_Variables::$results->objects_search);
    $view->assign('objects_list_elected', Dune_Variables::$results->objects_list_elected);
    Dune_Objects::$pageTemplate = $view->render('page:general:main');
}
else 
    Dune_Objects::$pageTemplate = $view->render('page:general:default_container');

    
    