<?php

class Module_Catalogue_Filter_Save_Type_House extends Dune_Include_Abstract_Code
{

    protected function code()
    {
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        

        $session = Dune_Session::getInstance($this->session_zone);
        $post = Dune_Filter_Post_Total::getInstance();        
        
        $session->type = $post->getDigit('type');
        
        
        $session->rooms_count_1 = $post->getDigit('rooms_count_1', 0, 2);
        $session->rooms_count_2 = $post->getDigit('rooms_count_2', 0, 2);
        $session->rooms_count_3 = $post->getDigit('rooms_count_3', 0, 2);
        $session->rooms_count_4 = $post->getDigit('rooms_count_4', 0, 2);

        $session->floor_count_0 = $post->getDigit('floor_count_0', 0, 2);
        $session->floor_count_1 = $post->getDigit('floor_count_1', 0, 2);
        $session->floor_count_2 = $post->getDigit('floor_count_2', 0, 2);
        
        
        $deal = null;
        if (isset($post['rent']) and $post['rent'] > 0)
        {
            $deal = 1;
        }
        if (isset($post['sale']) and $post['sale'] > 0)
        {
            if ($deal === 1)
                $deal++;
            else
                $deal = 0; 
        }
        $session->deal = $deal;
        
        if (isset($post['house_type']))
        {
            $session->house_type = $post['house_type'];
/*            $array = $_POST['house_type'];
            $array_new = array();
            if (is_array($array))
            {
                foreach ($array as $key => $value)
                {
                    if ((int)$value > 0)
                        $array_new[$key] = (int)$value;
                }
                $session->house_type = $array_new;
            }
*/
        }
        else 
            $session->house_type = null;

        if (isset($post['condition']))
        {
            $session->condition = $post['condition'];
        }
        else 
            $session->condition = null;

        if (isset($post['floor_no_first']))
        {
            $session->floor_no_first = 1;
        }
        else 
            $session->floor_no_first = null;

        if (isset($post['floor_no_last']))
        {
            $session->floor_no_last = 1;
        }
        else 
            $session->floor_no_last = null;
            
        // С какого этажа смотреть
        if (isset($post['floor_from']))
        {
            $temp = (int)$post['floor_from'];
            if (($temp > 0) and  ($temp < 16))
            {
                $session->floor_no_first = null;
                $session->floor_from = $temp;
            }
            else 
                $session->floor_from = null;                
        }
        else 
            $session->floor_from = null;
            
        // До какого этажа смотреть
        if (isset($post['floor_to']))
        {
            $temp = (int)$post['floor_to'];
            if (($temp > 0) and  ($temp < 16))
            {
                $session->floor_no_last = null;
                $session->floor_to = $temp;
            }
            else 
                $session->floor_to = null;                
        }
        else 
            $session->floor_to = null;

            
        // От какой цены фильтровать
        if (isset($post['value_from']))
        {
            $temp = (int)$post['value_from'];
            if (($temp > 0) and  ($temp < 10000))
                $session->value_from = $temp;
            else 
                $session->value_from = null;                
        }
        else 
            $session->value_from = null;
            
        // До какой цены фильтровать
        if (isset($post['value_to']))
        {
            $temp = (int)$post['value_to'];
            if (($temp > 1) and  ($temp < 10000))
                $session->value_to = $temp;
            else 
                $session->value_to = null;
            if ($session->value_from > 0 and $session->value_to > 0 and $session->value_from > $session->value_to - 1)
                $session->value_to = null;
        }
        else 
            $session->value_to = null;
            
            

        if (isset($post['phone']))
        {
            $session->phone = 1;
        }
        else 
            $session->phone = null;
            
        if (isset($post['photo']))
        {
            $session->photo = 1;
        }
        else 
            $session->photo = null;

            
        if (isset($post['levels']))
        {
            $session->levels = 1;
        }
        else 
            $session->levels = null;

        if (isset($post['have_bath']))
        {
            $session->have_bath = 1;
        }
        else 
            $session->have_bath = null;
            
        if (isset($post['have_land']))
        {
            $session->have_land = 1;
        }
        else 
            $session->have_land = null;

        if (isset($post['garage']))
        {
            $session->garage = 1;
        }
        else 
            $session->garage = null;
            
            
        if (isset($post['new_building_flag_0']))
        {
            $session->new_building_flag_0 = 1;
        }
        else 
            $session->new_building_flag_0 = null;
            
        if (isset($post['new_building_flag_1']))
        {
            $session->new_building_flag_1 = 1;
        }
        else 
            $session->new_building_flag_1 = null;

            
            
        if (isset($post['have_panorama']) and $post['have_panorama'] > 0)
        {
            $session->have_panorama = 1;
        }
        else 
            $session->have_panorama = null;
            
            
        if (isset($post['have_plan']) and $post['have_plan'] > 0)
        {
            $session->have_plan = 1;
        }
        else 
            $session->have_plan = null;

        if (isset($post['type_add']) and count($post['type_add']) > 0)
        {
            $session->type_add = $post['type_add'];
        }
        else 
            $session->type_add = null;

        if (isset($post['type_wall']) and count($post['type_wall']) > 0)
        {
            $session->type_wall = $post['type_wall'];
        }
        else 
            $session->type_wall = null;
            
            
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
    }
    
}
    
    