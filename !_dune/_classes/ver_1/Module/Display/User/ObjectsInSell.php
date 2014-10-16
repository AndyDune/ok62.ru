<?php

class Module_Display_User_ObjectsInSell extends Dune_Include_Abstract_Code
{

    protected function code()
    {
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        


    $view = Dune_Zend_View::getInstance();
    $order_field = 'time_insert';
    $order_direction = 'DESC';
    
    $exit = false;

    switch ($this->show)
    {
        case 'request':
            $list_sell_query = new Special_Vtor_User_Object_ListQuerySell($this->user->id);
            $count_sell_query = $list_sell_query->count();
        //    $list_sell_query->setOrder('status', '');
            $list_sell_query->setOrder('time', 'DESC');    
            $view->data = $list_sell_query->getListCumulateTransform();
        //    $view->edit = $list_sell_query->haveEdit();
            $view->count = $count_sell_query;
            $name = 'request';
        break;
        
        // Тема для рефакторинга - возможно сделать 1 запрос и далее разборка его на составляющие   !!FUTURE!!
        
        case 'noactive':
            $list_sell = new Special_Vtor_Object_List();
            $list_sell->setSeller($this->user->id);
            $list_sell->setOrder($order_field, $order_direction);
            $list_sell->setActivity(0);
            $count_sell = $list_sell->count();
            $view->data = $list_sell->getListCumulate();
            $view->count = $count_sell;
            $name = 'sell';
        break;
                
        case 'history':
            $list_sell = new Special_Vtor_Object_List();
            $list_sell->setSeller($this->user->id);
            $list_sell->setOrder($order_field, $order_direction);
            $list_sell->setActivity(2);
            $count_sell = $list_sell->count();
            $view->data = $list_sell->getListCumulate();
            $view->count = $count_sell;
            $name = 'history';
        break;
        case 'pay':
            $module = new Module_Pay_PageList();
            $module->order_field = $order_field;
            $module->order_direction = $order_direction;
            $module->user = $this->user;
            $module->make();
            $view->data = $module->getResult('data');
            $view->count = $module->getResult('count');
            $exit = $module->getResult('exit');
            $name = 'pay';
        break;
        
        default:
            $list_sell = new Special_Vtor_Object_List();
            $list_sell->setSeller($this->user->id);
            $list_sell->setActivity(array(0, 1));
            $count_sell = $list_sell->count();
            $list_sell->setOrder('activity', 'DESC');
            $list_sell->setOrder($order_field, $order_direction);
            $view->data = $list_sell->getListCumulate();
            $view->count = $count_sell;
            $name = 'sell';
        break;
        
    }
    $this->setResult('exit', $exit);
    echo $view->render('bit/user/activity/sell/' . $name);


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
    }
    
}
    
    