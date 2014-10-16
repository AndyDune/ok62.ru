<?php

$session_zone = 'filter';


//Dune_Static_StylesList::add('main:base');
Dune_Static_StylesList::add('catalogue/base');
Dune_Static_StylesList::add('catalogue/info');
//Dune_Static_StylesList::add('filter');
Dune_Static_StylesList::add('elements');

Dune_Static_StylesList::add('catalogue/adress_list');
//Dune_Static_StylesList::add('catalogue/list');

//Dune_Static_JavaScriptsList::add('jquery');
Dune_Static_JavaScriptsList::add('thickbox');
Dune_Static_StylesList::add('thickbox');

$view = Dune_Zend_View::getInstance();

$url_info = new Special_Vtor_Catalogue_Url_Parsing();

$adress_array = array();
/*
region - область
area - район в области
settlement - населённый пункт (город село деревня и т.д.) уникальный код
district - городской район
street - код улицы
house - дом 
building - корпус

*/
$objects_count = 0;

$text_elected = '';
$left_column = '';

$object_have = true;

//$object = new Special_Vtor_Object_Data($url_info->getObject());
$object = $this->object;
        
$adress_array = $object->getAdressArray();
$adress_object = $object->getAdressObject();

    
    
$object_no_active = '';
if ($object->activity != 1)
{
  Dune_Static_StylesList::add('user/info/message');        
  $object_no_active =  $view->render('page/catalogue/message/object_no_active');
}

if ($object->activity != 1 and Dune_Variables::$userStatus < 1000)
{
  echo $object_no_active;
  return;
}





    $display_seller = new Module_Display_Catalogue_Object_SalerInfo();
    $display_seller->object = $object;
    $display_seller->make();
    $view->seller = $display_seller->getResult('seller');


$main_info = '';
//    Формирование дисплея информации об объекте
//$display_main_info = new Dune_Include_Module('display/catalogue/object/info.one');
$display_main_info = new Module_Display_Catalogue_Object_InfoOnePrint();
$display_main_info->adress_array = $adress_array;
$display_main_info->adress_object = $adress_object;
$display_main_info->type = $url_info->getType();
$display_main_info->mode = $url_info->getMode();

$display_main_info->object = $object;
$display_main_info->make();
$main_info = $display_main_info->getOutput();


    Dune_Static_StylesList::add('catalogue/info');

echo $main_info;

/*$o = new Special_Vtor_Object_List();
$o->setActivity(0);
$o->setType(1);
echo $o->count();
$list = $o->getListCumulate();
foreach ($list as $value)
{
    echo '<pre>';
    print_r($value);
    echo '</pre>';
}
*/
//Dune_Variables::$pageTitle = 'Открытый Каталог Недвижимости Рязани.';
$this->setStatus(Dune_Include_Command::STATUS_TEXT);
