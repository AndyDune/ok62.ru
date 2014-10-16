<?php

class Module_Catalogue_Filter_Save_Type_Common extends Dune_Include_Abstract_Code
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

        // От какой цены фильтровать
        if (isset($post['price_from']))
        {
            $temp = $post->getDigit('price_from');
            if (($temp > 0) and  ($temp < 100000000))
                $session->price_from = $temp;
            else 
                $session->price_from = null;                
        }
        else 
            $session->price_from = null;
            
        // До какой цены фильтровать
        if (isset($post['price_to']))
        {
            $temp = $post->getDigit('price_to');
            if (($temp > 10000) and  ($temp < 100000000))
                $session->price_to = $temp;
            else 
                $session->price_to = null;
            if ($session->price_from > 0 and $session->price_to > 0 and $session->price_from > $session->price_to - 100)
                $session->price_to = null;
        }
        else 
            $session->price_to = null;

            
        if ($this->save_price == 'save_price')
        {
//            echo $session; die();
            return;
        }
        
        
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
        
        
        
        // Продавцы. Пришло с главной.
        $array = $post['seller_array'];
        $session->seller_sk = null;
        $session->seller_an = null;
        $session->seller_all = null;
        $session->seller_f = null;
        $session->seller_e = null;
        $session->seller_array = null;
       
        $result_array = array();
        $all = false;
        if (is_array($array))
        {
            foreach ($array as $key => $value)
            {
                if ($value == 'a')
                {
                    $session->seller_all = true;
                    $all = true;
                    break;
                }
                if ($value == 'e')
                {
                    $session->seller_e = true;
                    continue;
                }
                
                if ($value == 'sk')
                {
                    $session->seller_sk = true;
                    continue;
                }
                if ($value == 'f')
                {
                    $session->seller_f = true;
                    continue;
                }
                else if ($value == 'an')
                {
                    $session->seller_an = true;
                    continue;
                }
                else 
                {
                    $int = (int)$value;
                    if ($int > 0)
                    {
                        $result_array[] = $int;
                    }
                }
            }
            if ($all)
            {
                $session->seller_sk = null;
                $session->seller_an = null;
                $session->seller_f = null;
                $session->seller_e = null;
                $session->seller_array = null;
            }
            else if (count($result_array))
                $session->seller_array = $result_array;
        }
        
        
        
        
/*        if (isset($post['seller']))
        {
            if ($post['seller'] == 'f')
                $session->seller = -1;
            else 
                $session->seller = $post->getDigit('seller');
        }
        else 
            $session->seller = null;
*/
        if (isset($post['fseller']) and $post['fseller'])
        {
            $session->fseller = 1;
            $session->seller_over_the_counter = 1;
            $session->seller = null;
            $session->seller_array = null;
            $session->seller_sk = null;
            $session->seller_an = null;
            $session->seller_f = null;
            $session->seller_e = null;
        }
        else 
        {
            $session->fseller = null;
            $session->seller_over_the_counter = null;
        }
            
            
        if (isset($post['show_bad']) and $post['show_bad'])
        {
            $session->show_bad = null;
        }
        else 
            $session->show_bad = 1;
            
        

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
        

        if (isset($post['condition']))
        {
            $session->condition = $post['condition'];
        }
        else 
            $session->condition = null;


            
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
            
        if (isset($post['online']) and $post['online'] > 0)
        {
            $session->online = 1;
        }
        else 
            $session->onne = null;

            
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
    }
    
}
    
    