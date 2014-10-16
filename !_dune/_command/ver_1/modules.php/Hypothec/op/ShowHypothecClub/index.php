<?php

    
    $crumbs = Dune_Display_BreadCrumb::getInstance();
    $crumbs->addCrumb('Èïîòå÷íûé êëóá "ÅÄÈÍÑÒÂÎ"', '/modules.php?name=Hypothec&op=ShowHypothecClub');

	$pagetitle = $this->pagetitle;
	$module_name = $this->module_name;
	$bgcolor1 = $this->bgcolor1;
	$bgcolor2 = $this->bgcolor2;
	$bgcolor3 = $this->bgcolor3;
	
    $pagetitle = "Èïîòå÷íûé êëóá";
	
    $get = Dune_Filter_Get_Total::getInstance();
    $COMMAND = $get['c'];
    $stuk = '';
    if ($COMMAND)
    {
        $array = new Dune_String_Explode($COMMAND, '-');
        $count = $array->count();
        $curr = 1;
        foreach ($array as $value)
        {
            if ($stuk)
                $stuk .= '/';
            $stuk .= $value;
            $crumbs_link = $_SERVER['DOCUMENT_ROOT'] . '/docs/hypothec/club/' . $stuk . '/crumbs.php';
        	if (is_file($crumbs_link))
        	{
        	    ob_start();
        	    include $crumbs_link;
        	    $text = ob_get_clean();
        	    if ($curr == $count)
        	       $crumbs->addCrumb($name);
        	    else 
        	       $crumbs->addCrumb($name, $link);
        	    $curr++;
        	}
        	else 
        	{
        	   $stuk = '';
        	   break;
        	}
        }
    }
    
/*    $module = new Dune_Include_Module('db:hypothec:glassary.get.list');
    $module->make();
    $list = $module->getResult('array');
*/	
    if ($stuk)
        $file = $_SERVER['DOCUMENT_ROOT'] . '/docs/hypothec/club/' . $stuk . '/index.htm';
    else 
        $file = $_SERVER['DOCUMENT_ROOT'] . '/docs/hypothec/club/index.htm';
	if (is_file($file))
	{
	    ob_start();
	    include $file;
	    $text = ob_get_clean();
	}
    
    $view = Dune_Zend_View::getInstance();
    $view->assign('crumbs', $crumbs->getString('<p id="breadcrumb">', '</p>'));
    $view->assign('text', $text);
    
    echo $view->render('hypothec:ShowHypothecClub');
	
	$this->results['pagetitle'] = $pagetitle;
	