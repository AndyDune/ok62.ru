<?php
$look_public = false;
if (Dune_Variables::$userStatus < 500) // Нельзя смотреть список обычному пользователю
{
    $look_public = true;
//    $this->setStatus(Dune_Include_Command::STATUS_GOTO);
//    $this->setResult('goto', '/');
//    return;
}

$per_page = 30;
$my = false;
$have = false;


$URL = Dune_Parsing_UrlSingleton::getInstance();

$deal = '';
if ($URL->getCommandPart(4, 1) == 'mode')
{
    $deal = $URL->getCommandPart(4, 2);
}
//$session = Dune_Session::getInstance(Dune_Session::ZONE_AUTH);
//$user = new Dune_Auth_Mysqli_UserActive($session->user_id);

    $view = Dune_Zend_View::getInstance();
    
    $current = Special_Vtor_Object_Request_DataSingleton::getInstance();
    if ($look_public )
        $current->setPublicToGet();
    
    $get = Dune_Filter_Get_Total::getInstance();
    $current_page = $get->getDigit('page');
    
    if (Special_Vtor_User_Auth::$id)
    {
        $my = true;
        $current->setUserId(Special_Vtor_User_Auth::$id);
        $have = $current->getCount();
    }

    $url = Dune_Parsing_UrlSingleton::getInstance();
    $url->setCommand('mode_rent', 4);
    $link_rent = $url->getCommandString();
    $url->setCommand('mode_sale', 4);
    $link_sale = $url->getCommandString();
    
    $url->cutCommands(3);
    $link_total = $url->getCommandString();

    
    $crumbs_array[0] = array('name' => 'Каталог', 'link' => '/catalogue/');
    
    switch ($deal)
    {
        case 'sale':
            $current->setDeal('sale');
            $crumbs_array[1] = array('name' => 'Куплю', 'link' => $link_sale);
        break;
        case 'rent':
            $current->setDeal('rent');
            $crumbs_array[1] = array('name' => 'Возьму в аренду', 'link' => $link_rent);
        break;
        default:
            $crumbs_array[1] = array('name' => 'Куплю или возьму в аренду', 'link' => $link_total);
    }
    
    $count = $current->getCountAll();
    if ($count > $per_page)
    {
        $navigator = new Dune_Navigate_Page($URL->getCommandString() . '?page=', $count, $current_page, $per_page);
        $view->navigator = $navigator->getNavigator();
    }
    
//    $view->list = $current->getListAll($current_page * $per_page, $per_page);
    
    $view->list = $current->getListAllWithUsers($current_page * $per_page, $per_page);
    
    $view->type_code = Special_Vtor_Settings::$typeCodeToString;
    
    $view->types = Special_Vtor_Types::$typesToRequest;
    
    $view->deal  = $deal;
    $view->my    = $my;    
    $view->have  = $have;    
    
    
    $view->crumbs_array = $crumbs_array;
    
    $view->link_rent = $link_rent;
    $view->link_sale = $link_sale;
    
    
    
    $view->text_header = $view->render('bit/request/public/list_header');
    $view->text = $view->render('bit/request/public/list');

//    $view->h1 = 'Заявки на приобретение недвижимости.';
    Dune_Variables::addTitle($view->getResult('title'));
    echo $view->render('bit/general/container_padding_for_auth_extend');


