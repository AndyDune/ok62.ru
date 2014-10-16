<?php
$per_page = 30;

$this->setStatus(Dune_Include_Command::STATUS_TEXT);

$URL = Dune_Parsing_UrlSingleton::getInstance();

$GET = Dune_Filter_Get_Total::getInstance();
$page = $GET->getDigit('page');
$session = Dune_Session::getInstance('seller');

if (isset($GET['type']))
{
    $session->type =  $GET->getDigit('type');
    if ($session->type != 1)
        $session->rooms_count = 0;
}    
    
if (isset($GET['region']))
    $session->region =  $GET->getDigit('region');

if (isset($GET['seller']))
{
    $session->seller =  $GET['seller'];
}
    
    
if (isset($GET['rooms_count']))
    $session->rooms_count =  $GET->getDigit('rooms_count');
    
    
if (isset($GET['settlement']) and $GET['settlement'] > 0)
{
    $session->settlement =  $GET->getDigit('settlement');
    $session->no_ryzan =  false;
}

if (isset($GET['area']))
    $session->area =  $GET->getDigit('area');

if (isset($GET['district']))
    $session->district =  $GET->getDigit('district');

if (isset($GET['nook']))
    $session->nook =  $GET->getDigit('nook');

if ($session->settlement != 1)    
{
    $session->district = 0;
}
else 
    $session->area = 0;

if (isset($GET['ryazan']) and $GET['ryazan'] == 'no')
{
    $session->no_ryzan =  true;
    $session->district = 0;
    $session->seller = 0;
    $session->settlement = 0;
}
    
    
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

    
    if ($adress_array['region'] == 1 and !$adress_array['settlement'] and $session->no_ryzan)
        $no_ryazan = true;
    else 
        $no_ryazan = false;
    
        
    if ($session->type == 1)
    {
        $list = new Special_Vtor_Object_List_Type_Room();
        if ($session->rooms_count)
            $list->setRoomsCountArray(array($session->rooms_count => 1));
    }
    else 
        $list = new Special_Vtor_Object_List();

/*        echo (int)$session->seller;
        echo '<br />';
        echo $session->seller;
*/

    if (strcmp($session->seller, (int)$session->seller) != 0 and (int)$session->seller)
    {
        $list->setSellerException((int)$session->seller);
    }
    else if ($session->seller > 0)
    {
        $list->setSeller((int)$session->seller);
    }
        
    $list->setOrderTimeInsert('DESC');
    
    if ($no_ryazan)   
        $list->setNoRyazan();
        
    $list->setShowWitoutHouseNumber();
        
    $list->setAdress($adress_object);
    $list->setActivity(1);
    if ($session->type)
        $list->setType($session->type);
    $count = $list->count();

    $data = $list->getListCumulate($page * $per_page, $per_page);

    
Dune_Static_StylesList::add('seller/objects');

    $view = Dune_Zend_View::getInstance();

    
    $q = 'SELECT * 
          FROM unity_catalogue_adress_district
          WHERE settlement_id = ?i 
          ORDER BY name';
    $DB = Dune_MysqliSystem::getInstance();
    $list_district = $DB->query($q, array(1), Dune_MysqliSystem::RESULT_IASSOC);

    $view->list_distrinct = $list_district;
    $view->distrinct = $session->district;
    
    $view->rooms_count = $session->rooms_count;
    
    $view->type = $session->type;
    
    $view->no_ryzan = $session->no_ryzan;
    
    $view->settlement = $session->settlement;
    
    $view->seller = $session->seller;
    
    $view->list = $data;
    $view->count = $count;
    $view->navigator_per_page = $per_page;
    $view->navigator_page = $page;
    
    $view->h1 = 'Разде продавца.';
    Dune_Variables::addTitle('.');
    
    echo $view->render('bit/seller/objects/page');

