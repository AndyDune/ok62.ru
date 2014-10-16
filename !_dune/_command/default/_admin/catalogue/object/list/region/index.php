<?php
/////       Лист
///////////////////////////////
////     
///     Список областей
///
    $URL = Dune_Parsing_UrlSingleton::getInstance(); // Сачас 5-я возможна
    $folder_url = Dune_Data_Collector_UrlSingleton::getInstance();
        
    
    $crumbs = Dune_Display_BreadCrumb::getInstance();
    $crumbs->addCrumb('Области');
    echo $crumbs->getString();

    
    $q = 'SELECT * 
          FROM unity_catalogue_adress_region 
          ORDER BY name';
    $DB = Dune_MysqliSystem::getInstance();
    $data = $DB->query($q, null, Dune_MysqliSystem::RESULT_IASSOC);
    
    $list_ob = new Special_Vtor_Object_List();
    
    foreach ($data as $key => $value)
    {
        $list_ob->setActivity(0);
        $list_ob->setRegion($value['id']);
        $DATA[$key] = $value;
        $DATA[$key]['count_total'] = $list_ob->count();
        $list_ob->setActivity(1);
        $DATA[$key]['count_active'] = $list_ob->count();
    }
    
    $view = Dune_Zend_View::getInstance();
    $view->link_next_list = $folder_url->getExeptLastFolder() . 'area';
    $view->data = new Dune_Array_Container($DATA);
    echo $view->render('page/catalogue/object/list/region');