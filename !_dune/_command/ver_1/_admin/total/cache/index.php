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
	    echo $results['text'] = $view->render('total:cache');
    }

$this->setResult($results);
$this->setStatus($status);
