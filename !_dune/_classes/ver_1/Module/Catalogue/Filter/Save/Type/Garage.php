<?php

class Module_Catalogue_Filter_Save_Type_Garage extends Dune_Include_Abstract_Code
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

        if (isset($post['floor_socle']))
        {
            $session->floor_socle = 1;
        }
        else 
            $session->floor_socle = null;
            
            
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

            
            
            
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
    }
    
}
    
    