<?php
$this->setStatus(Dune_Include_Command::STATUS_TEXT);

$URL = Dune_Parsing_UrlSingleton::getInstance();

$GET = Dune_Filter_Get_Total::getInstance();
$session = Dune_Session::getInstance('seller');

    
// Если объектане выбрано данные о текущем адресе берём из строки запроса
    $adress_array= array(
//                        'region' => $url_info->getRegion(),
                        'region' => 1,  // Только Рязань
                        'area' => $session->area,
                        'settlement' => $session->settlement,
                        'district' => $session->district,
                        'street' => 0,
                        'house' => 0,
                        'building' => 0
                        );
$adress_object = new Special_Vtor_Adress($adress_array);

$url_info = new Special_Vtor_Catalogue_Url_Parsing('type/' . $session->type . '/adress/' . implode('/', $adress_array) . '/page/' . $GET->getDigit('page') );

    
    if ($adress_array['region'] == 1 and !$adress_array['settlement'] and $adress_array['area'])
        $no_ryazan = true;
    else 
        $no_ryazan = false;
    
    $list = new Special_Vtor_Object_List();
    $list->setSellerException(3)
         ->setActivity(1)
         ->setOrder('type')->setOrder('district_id')->setOrder('rooms_count');
    
    $count = $list->count();
    $data = $list->getListCumulate(0, 1000);

    
Dune_Static_StylesList::add('seller/objects');

    $view = Dune_Zend_View::getInstance();

    $view->count = $count;
    $view->list = $data;
    
    $view->h1 = 'Все вражеские.';
    Dune_Variables::addTitle('.');
    
    $object_condition = new Special_Vtor_Object_Condition();
    $object_condition = $object_condition->getList(1);
    $object_planning = new Special_Vtor_Object_Planning();
    $object_planning = $object_planning->getList();
   
    $house_type = new Special_Vtor_Object_Add_HouseType();
    $view->house_type = $house_type->getListType(1);
        
    $view->condition = $object_condition;
    $view->planning = $object_planning;
    
    
    echo $view->render('bit/seller/objects/tall');

