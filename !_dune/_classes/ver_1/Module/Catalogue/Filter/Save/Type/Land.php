<?php

class Module_Catalogue_Filter_Save_Type_Land extends Dune_Include_Abstract_Code
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

        if (isset($post['condition']))
        {
            $session->condition = $post['condition'];
        }
        else 
            $session->condition = null;

            
        // От какой цены фильтровать
        if (isset($post['value_from_land']))
        {
            $temp = (int)$post['value_from_land'];
            if (($temp > 0) and  ($temp < 1000000))
                $session->value_from_land = $temp;
            else 
                $session->value_from_land = null;                
        }
        else 
            $session->value_from_land = null;
            
        // До какой цены фильтровать
        if (isset($post['value_to_land']))
        {
            $temp = (int)$post['value_to_land'];
            if (($temp > 1) and  ($temp < 10000000))
                $session->value_to_land = $temp;
            else 
                $session->value_to_land = null;
            if ($session->value_from_land > 0 and $session->value_to_land > 0 and $session->value_from_land > $session->value_to_land - 1)
                $session->value_to_land = null;
        }
        else 
            $session->value_to_land = null;

            
        if (isset($post['photo']))
        {
            $session->photo = 1;
        }
        else 
            $session->photo = null;

            
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

            
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
    }
    
}
    
    