<?php

// Команда настроек пользователя

    $url = Dune_Parsing_UrlSingleton::getInstance();
    $get = Dune_Filter_Get_Total::getInstance();
    
    $mode = $url->getCommandPart(3, 2);
    
    $view = Dune_Zend_View::getInstance();
    $view->text = '<h1>Команда всякой инфы</h1>';

    $text = '';
    $pagetitle = "";

    
    $crumbs = Dune_Display_BreadCrumb::getInstance();
    $crumbs->addCrumb('Главная', '/');
    $crumbs->addCrumb('На карте', '/');
     
	
    $crumbs_text = $crumbs->getString('<p id="breadcrumb">', '</p>');
    
    $data = array();
    
    switch ($mode)
    {
        case 'xy':
            $gx = (float)$url->getCommandPart(3, 3);
            $gy = (float)$url->getCommandPart(3, 4);
            if ($gy > 1 and $gy > 1)
            {
                $data['x'] = $gx;
                $data['y'] = $gy;
                if ($get['name'])
                {
                    $string = htmlspecialchars(urldecode($get['name']));
                    $data['title'] = $string;
                }
            }
        break;
    }
    $view->data = $data;
    $text = $view->render('bit/map/one_xy');
    
    
    $text = $crumbs_text . $text;
    
    $view->assign('text', $text);
    
    Dune_Variables::addTitle($pagetitle. ' ');
    
    $view->banners = $view->render('bit/banners/some');
    
    echo $view->render('bit/general/container_padding_for_banners');
    Dune_Static_StylesList::add('read');