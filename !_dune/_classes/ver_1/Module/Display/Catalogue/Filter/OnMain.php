<?php

class Module_Display_Catalogue_Filter_OnMain extends Dune_Include_Abstract_Code
{

    protected function code()
    {
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $view = Dune_Zend_View::getInstance();
        $vars = Dune_Variables::getInstance();
        $session = Dune_Session::getInstance($this->session_zone);
        $view->saved = $session->getZone(true);
/*        
        $house_type = new Special_Vtor_Object_Add_HouseType();
        $view->house_type = $house_type->getListTypeWithObjectsActive();
        $condition = new Special_Vtor_Object_Condition();
        $view->condition = $condition->getListWithObjects($this->type);
        
*/      
        $type = new Special_Vtor_Object_Types($vars->subdomainFocusUserId);
        $from_db = $type->getListTypeWithObjectsActive();
        $cat_url = new Special_Vtor_Catalogue_Url_Collector();
        $list = array();
        if ($from_db)
        {
            foreach ($from_db as $value)
            {
                $cat_url->setType($value['id']);
                $arr['link']    = $cat_url->get();
                $arr['name']    = $value['name_many'];
                $arr['id']      = $value['id'];
                $arr['count']   = $value['count'];
                $arr['current'] = false;
                $list[$value['id']] = $arr;            
            }
        }    
        $view->list_type = $list;
        
        
        $house_type = new Special_Vtor_Object_Add_HouseType();
        $view->house_type = $house_type->getListTypeWithObjectsActive();
        $view->house_type_nolife = $house_type->getListTypeWithObjectsActiveHave(4);
        
        $condition = new Special_Vtor_Object_Condition();
        $view->condition_room = $condition->getListWithObjects(1);
        $view->condition_nolife = $condition->getListWithObjects(4);
        $view->condition_pantry = $condition->getListWithObjects(5);
        $view->condition_garage = $condition->getListWithObjects(3);
        
        
    $adress_array= array(
//                        'region' => $url_info->getRegion(),
                        'region' => 1,  // Только Рязань
                        'area' => 1,
                        'settlement' => 1,
                        'district' => 0,
                        'street' => 0,
                        'house' => 0,
                        'building' => 0
                        );
        $adress_object = new Special_Vtor_Adress($adress_array);
        
//        $display_adress_list = new Module_Display_Catalogue_Adress_ListMainWithObjects();
        if (Special_Vtor_Settings::$districtPlus)
            $display_adress_list = new Module_Display_Catalogue_Adress_ListMainWithObjectsPlus();
        else 
            $display_adress_list = new Module_Display_Catalogue_Adress_ListMainWithObjects();
        
        
        $display_adress_list->adress_array = $adress_array;
        $display_adress_list->adress_object = $adress_object;
        $display_adress_list->use_filter = false;
        $display_adress_list->type = 1;
        $display_adress_list->from_main = true;
        $display_adress_list->make();
        $text_adress = $display_adress_list->getOutput();
        
        $view->adress_type_1 = $text_adress;

        $display_adress_list->type = 3;
        $display_adress_list->make();
        $text_adress = $display_adress_list->getOutput();
        
        $view->adress_type_3 = $text_adress;

        $display_adress_list->type = 4;
        $display_adress_list->make();
        $view->adress_type_4 = $display_adress_list->getOutput();

        $display_adress_list->type = 5;
        $display_adress_list->make();
        $view->adress_type_5 = $display_adress_list->getOutput();

        
        $display_adress_list->type = 2;
        $display_adress_list->make();
        $view->adress_type_2 = $display_adress_list->getOutput();

        $display_adress_list->type = 6;
        $display_adress_list->make();
        $view->adress_type_6 = $display_adress_list->getOutput();
        
        
        $type_add = new Special_Vtor_Object_Add_Type();
        $view->house_type_add = $type_add->getListTypeWithObjectsActiveHave(2);
        
        $wall = new Special_Vtor_Object_Add_MaterialWall();
        $view->house_type_wall = $wall->getListTypeWithObjectsActiveHave(2);
        

        $view->subdomainFocusUserId = $vars->subdomainFocusUserId;
        $view->subdomainFocusUserData = $vars->subdomainFocusUserData;

        
        
        echo $view->render('bit/main/filter');


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
    }
    
}
    
    