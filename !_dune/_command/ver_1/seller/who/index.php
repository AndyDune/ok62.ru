<?php
$per_page = 20;

$this->setStatus(Dune_Include_Command::STATUS_TEXT);

$URL = Dune_Parsing_UrlSingleton::getInstance();

$GET = Dune_Filter_Get_Total::getInstance();
$current_page = $page = $GET->getDigit('page');
$session = Dune_Session::getInstance('seller');

if (isset($GET['type']))
{
    $session->type =  $GET->getDigit('type');
    if ($session->type != 1)
        $session->rooms_count = 0;
}    
    
    Dune_Static_StylesList::add('seller/objects');

    $view = Dune_Zend_View::getInstance();

    
    $q = 'SELECT users.*,
                 count(objects.id) as count_objects,
                 users_rel.id as id_rel,
                 users_rel.name as name_rel,
                 users_rel.contact_name as contact_name_rel
          FROM dune_auth_user_active as `users`
               LEFT JOIN dune_auth_user_active as `users_rel` ON `users`.`relative` = `users_rel`.`id`,
               `unity_catalogue_object` as `objects`
          WHERE 
                objects.activity = 1 
                AND
                users.id = objects.saler_id
          GROUP BY  users.id
          ORDER BY name
          LIMIT ?i, ?i';
    $DB = Dune_MysqliSystem::getInstance();
    $list_district = $DB->query($q, array($page*$per_page, $per_page), Dune_MysqliSystem::RESULT_IASSOC);


    $q = 'SELECT count(distinct(`users`.id)) as `count`
          FROM dune_auth_user_active as `users`,
               `unity_catalogue_object` as `objects`
          WHERE 
                objects.activity = 1 
                AND
                users.id = objects.saler_id
          ';
    $DB = Dune_MysqliSystem::getInstance();
    $count = $DB->query($q, null, Dune_MysqliSystem::RESULT_EL);
//    die();
    
    
if ($count > $per_page)
{
    $navigator = new Dune_Navigate_Page($URL->getCommandString() . '?page=', $count, $current_page, $per_page);
    $view->navigator = $navigator->getNavigator();
}
    
    
/*    foreach ($list_district as $value)
    {
        print_array($value);
    }
    die();
*/    
    $view->type = $session->type;
    $view->list = $list_district;
    
    $view->seller = $session->seller;
    
//    $view->list = $data;
//    $view->count = $count;
    $view->navigator_per_page = $per_page;
    $view->navigator_page = $page;
    
    $view->h1 = 'Разде продавца.';
    Dune_Variables::addTitle('.');
    
    echo $view->render('bit/seller/who');
    Dune_Static_StylesList::add('user/info/list');

