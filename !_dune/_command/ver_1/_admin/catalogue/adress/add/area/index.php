<?php
/////       Лист
///////////////////////////////
////     
///     Список районов области
///
    $URL = Dune_Parsing_UrlSingleton::getInstance(); // Сачас 6-я возможна
    $folder_url = Dune_Data_Collector_UrlSingleton::getInstance();

    $session = Dune_Session::getInstance('add');
    
try {
    $post = Dune_Filter_Post_Total::getInstance();
    // Проишло из формы
    if ($post->_do_ == 'save')
    {
        if (!$post->check('region_id'))
            throw new Dune_Exception_Control_Goto($folder_url->getExeptLastFolder(2));
            
        $q = 'SELECT * 
              FROM unity_catalogue_adress_region 
              WHERE id = ?i
              ';
        $DB = Dune_MysqliSystem::getInstance();
        $data_region = $DB->query($q, array($post->region_id), Dune_MysqliSystem::RESULT_ROWASSOC);
        if (!$data_region)
            throw new Dune_Exception_Control_Goto($folder_url->getExeptLastFolder(2));
         
        if (strlen($post->name) < 3)
        {
            throw new Dune_Exception_Control_Goto(Dune_Parameters::$pageInternalReferer);
        }
        $DB = Dune_MysqliSystem::getInstance();
        $set_q = new Dune_Mysqli_Collector_Set($DB);
        $set_q->assign('id', null, 'n');
        $set_q->assign('name', $post->name);
        $set_q->assign('region_id', $post->region_id, 'i');
        if ($post->check('order') and $post->order > 0)
            $set_q->assign('order', $post->order, 'i');
        echo $q = 'INSERT INTO unity_catalogue_adress_area ' . $set_q->get();
        $DB->query($q);
        throw new Dune_Exception_Control_Goto($post->link_list);
        $session->link_list = $post->link_list;
            
    }
    
    
    if ((int)$URL[6] < 1)
    {
        throw new Dune_Exception_Control_Goto(Dune_Parameters::$pageInternalReferer);
    }
    
    $q = 'SELECT * 
          FROM unity_catalogue_adress_region 
          WHERE id = ?i
          ';
    $DB = Dune_MysqliSystem::getInstance();
    $data_region = $DB->query($q, array($URL[6]), Dune_MysqliSystem::RESULT_ROWASSOC);
    if (!$data_region)
        throw new Dune_Exception_Control_Goto($folder_url->getExeptLastFolder());
    
    $link_list = $folder_url->getExeptLastFolder(2) . 'list/area/' . $URL[6] . '/';
    
    $crumbs = Dune_Display_BreadCrumb::getInstance();
    $crumbs->addCrumb('Области', $folder_url->getExeptLastFolder(2));
    $crumbs->addCrumb('Районы области: ' . $data_region['name'], $link_list);
    $crumbs->addCrumb('Добавить район');
    echo $crumbs->getString();

    
    $view = Dune_Zend_View::getInstance();
    
    
    
    $view->link_list = $link_list;
    $view->data_region = $data_region;
    $view->form_action = $folder_url->get() . $URL[6] . '/';
    
    echo $view->render('page/catalogue/adress/add/area');
}
catch (Dune_Exception_Control_Goto $e)
{
    Dune_Static_Header::location($e->getMessage());
    $this->status = Dune_Include_Command::STATUS_TEXT;
}