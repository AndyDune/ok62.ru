<?php
$list = new Special_Vtor_Object_List();
$list->setAdress($this->adress_object);
$list->setActivity(1);
if ($this->type)
    $list->setType($this->type);
$count = $list->count();
$page_curent = $this->url_info->getPage();
$page_per = $this->perPage;
$view = Dune_Zend_View::getInstance();
$order_field = 'time_insert';
$order_direction = 'DESC';
if ($count)
{
    echo '<h1>Объектов: ' . $count . '</h1>';
    //$list->setOrderTimeInsert('DESC');
    $list->setOrder($order_field, $order_direction);
    $view->data = $list->getListCumulate($page_curent * $page_per, $page_per);
    $view->navigator_per_page = $this->perPage;
    $view->count = $count;
    $view->url_info = $this->url_info;
    $view->navigator_page = $page_curent;
    switch ($this->type)
    {
/*        case 1: // Квартиры
            $view->render('bit/catalogue/object/list/room');
        break;
        case 3: // Гаражи
            $view->render('bit/catalogue/object/list/garage');
        break;
        case 5: // Кладовки
            $view->render('bit/catalogue/object/list/pantry');
        break;
*/        
        default:
            echo $view->render('bit/catalogue/object/list/all');
    }
}
else 
    echo '<h1>Нет объектов с указанным адресом и/или типом</h1>';
