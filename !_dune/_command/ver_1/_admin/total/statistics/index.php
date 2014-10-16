<?php

    $session_name = 'zone_statistics';
    $session = Dune_Session::getInstance($session_name);
    if (!$session->time_begin)
        $session->time_begin = '2008-10-01';
    if (!$session->time_end)
        $session->time_end = date('Y-m-d');
        
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
        $session = Dune_Session::getInstance($session_name);
        $view->data = $session->getZone(true);
	    echo $results['text'] = $view->render('total:statistics');
    }

$this->setResult($results);
$this->setStatus($status);
