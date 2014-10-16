<?php
	$currentCommand = 'total';
	
    echo '<h1>Подключена субкомманда</h1>';
    
	include 'menu.php';
	
    $view = Dune_Zend_View::getInstance();
    $view->assign('menu_left', $menu_left);
    $view->assign('command_admin', Dune_Variables::$commandNameAdmin);
    $view->assign('array_command', array(Dune_Variables::$commandNameAdmin, $currentCommand));
        
	$this->results['body_id'] = 'body_total';
	
	$this->results['menu_left'] = $view->render('menu:left.first');