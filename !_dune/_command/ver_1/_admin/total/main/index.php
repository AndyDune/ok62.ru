<?php

    $results[0] = '';
    $status = Dune_Include_Command::STATUS_PAGE;
    $results['text'] = '';

    $sys_dbm = Dune_AsArray_DbmSingletonSystem::getInstance();
	
    $view = Dune_Zend_View::getInstance();
    $view ->assign('allow_reg', $sys_dbm['allow_reg']);
    
    $post = Dune_Filter_Post_Total::getInstance();
    if ($post->check('_do_'))
    {
    	$status = Dune_Include_Command::STATUS_EXIT;
    	include '.do.php';
    }
    else 
    {
	    
	    $view ->assign('do_path', '/' . Dune_Variables::$commandNameAdmin . '/total/main/');
	        
	    $results['text'] = $view->render('total:main');
    }
    

$this->results = $results;
$this->status = $status;
