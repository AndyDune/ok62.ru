<?php

// Команда настроек пользователя

    $post = Dune_Filter_Post_Total::getInstance();
    if ($post->_do_ === 'make_gm')
    {
        $gx = $post->getFloat('pos_x');
        $gy = $post->getFloat('pos_y');
        
        // ТОчка в районе
/*        $mod = new Module_Map_HitDistrictPlus();
        $mod->x = $gx;
        $mod->y = $gy;
        $mod->make();
        echo $mod->getOutput() , '<br />';
        echo $mod->getResult('message'), '<br />';
        if ($mod->getResult('success'))
        {
            echo 'Нашли: ' . Special_Vtor_Districts::$list[$mod->getResult('district')];
            
        }
        die();
*/ 
       // точка в районе конец
        
        
        if ($gx > 0 and $gy > 0)
        {
            throw new Dune_Exception_Control_Goto('/map/public/' . $gx . '_' . $gy . '/');
        }
    }

    $url = Dune_Parsing_UrlSingleton::getInstance();
    $get = Dune_Filter_Get_Total::getInstance();
    
    $view = Dune_Zend_View::getInstance();
    $view->text = '<h1>Команда всякой инфы</h1>';

    $text = '';
    $pagetitle = "Указание местоположения на карте.";

    
    $crumbs = Dune_Display_BreadCrumb::getInstance();
    $crumbs->addCrumb('Главная', '/');
    $crumbs->addCrumb('Клиентам', '/read/clients/');
    $crumbs->addCrumb('Целеуказание на карте', '/');
	
    $crumbs_text = $crumbs->getString('<p id="breadcrumb">', '</p>');
    
    $data = array();

    $pos_x = '54.61671645388694';
    $pos_y = '39.72235679626465';
    
    $gx = (float)$url->getCommandPart(3, 1);
    $gy = (float)$url->getCommandPart(3, 2);
    if ($gy > 1 and $gy > 1)
    {
        $pos_x = $gx;
        $pos_y = $gy;
    }
    $view->pos_x = $pos_x;
    $view->pos_y = $pos_y;
    $text = $view->render('bit/map/public');
    
    
    $text = $crumbs_text . $text;
    
    $view->assign('text', $text);
    
    Dune_Variables::addTitle($pagetitle. ' ');
    
    Dune_Variables::$pageDescription = 'Указание на карте местоположение любого произвольного объекта (бара, спортзала, пляжа и т.д.). ' . Dune_Variables::$pageDescription;
    
    $view->banners = $view->render('bit/banners/some');
    
    echo $view->render('bit/general/container_padding_for_banners');
    Dune_Static_StylesList::add('read');