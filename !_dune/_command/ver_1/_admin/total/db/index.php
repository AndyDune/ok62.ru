<?php

        
//     echo $session   ;
     
    $results[0] = '';
    $status = Dune_Include_Command::STATUS_PAGE;
    $results['text'] = '';
    
    
    $post = Dune_Filter_Post_Total::getInstance();
    if ($post->check('_do_'))
    {
    	$status = Dune_Include_Command::STATUS_EXIT;
    	include '.do.php';
    }
    else 
    {
        $view = Dune_Zend_View::getInstance();
        
	    $sess = Dune_Session::getInstance('result');
	    $view->count = $sess->count;
	    $view->count_success = $sess->count_success;
	    $sess->killZone();
        
	    echo $results['text'] = $view->render('total:db');
    }

$this->setResult($results);
$this->setStatus($status);
