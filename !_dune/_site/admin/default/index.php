<?php

	
    //header("Content-type: text/plain; charset=windows-1251");
    header("Cache-Control: no-store, no-cache, must-revalidate");
    header("Cache-Control: post-check=0, pre-check=0", false);	

$view = Dune_Zend_View::getInstance();

// Геристрируем базовый файл стилей
Dune_Static_StylesList::add('base', 1);

$view->assign('text', Dune_Variables::$pageText);
$view->assign('title', Dune_Variables::$pageTitle);
$view->assign('description', Dune_Variables::$pageDescription);
$view->assign('keywords', Dune_Variables::$pageKeywords);



// Выборка поля аутентификации пользователя.
// Форма входя либо текущая короткая информация.
if (!Dune_Variables::$results->no_user_panel)
{
    $auth_field = new Dune_Include_Module('display:user:auth_field');
    $auth_field->make();
    $view->assign('auth_field', $auth_field->getOutput());
}


$view_array = array(
                    'js' => Dune_Static_JavaScriptsList::get(),
                    'css' => Dune_Static_StylesList::get(),
                    );
$view->assign($view_array);
                    
$view->view_realization = Dune_Parameters::$templateRealization;

// Время выполнения скрипта
$time = Dune_Time_IntervalSingleton::getInstance();
$view->assign('time', $time->getTime());

$o_array = Dune_Variables::$results;

//echo Dune_Variables::$results; die() ;

    Dune_Static_StylesList::add('main');
    Dune_Static_StylesList::add('menu_top');
    Dune_Static_StylesList::add('menu_left');
    Dune_Static_StylesList::add('slide');
    Dune_Static_StylesList::add('list');
    Dune_Static_StylesList::add('ui.tabs');
    Dune_Static_StylesList::add('pics');
//    Dune_Static_StylesList::add('check');
    
    Dune_Static_JavaScriptsList::add('jquery', 10);
    Dune_Static_JavaScriptsList::add('jquery.cookie', 10);
    Dune_Static_JavaScriptsList::add('ui.tabs', 11);
    Dune_Static_JavaScriptsList::add('dune');
    
    
    $config = array(
    				'view_files_path'=> '/viewfiles/'
    				                 . Dune_Parameters::$templateSpace 
    								 . '/'
    								 . Dune_Parameters::$templateRealization,
    				'title' 	     => Dune_Variables::$pageTitle,
    				'description' 	 => Dune_Variables::$pageDescription,
    				'keywords' 	     => Dune_Variables::$pageKeywords,
    				'body_id' 	     => $o_array->body_id,
    				'command_admin'  => Dune_Variables::$commandNameAdmin,
    				'menu_left'  	 => $o_array->menu_left,
    				'text' 		     => Dune_Variables::$pageText
    				);
    				
   $view->assign($config);
    
    
   Dune_Objects::$pageTemplate =  $view->render('index');
