<?php

class Module_Catalogue_Filter_Save_Transit extends Dune_Include_Abstract_Code
{

    protected function code()
    {
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        

        $session = Dune_Session::getInstance($this->session_zone);
        $session_array = $session->getZone(true);
        $session->clearZone();
        $session->have = true;
        $session->type = $this->type;
        
        
        $session->price_from = $session_array['price_from'];
        $session->price_to = $session_array['price_to'];
            

        $session->seller_sk = $session_array['seller_sk'];
        $session->seller_an = $session_array['seller_an'];
        $session->seller_all = $session_array['seller_all'];
        $session->seller_f = $session_array['seller_f'];
        $session->seller_array = $session_array['seller_array'];
        
        $session->fseller = $session_array['fseller'];
        $session->show_bad = $session_array['show_bad'];        
        
        
        $session->deal = $session_array['deal'];
        
        $session->value_from = $session_array['value_from'];
        $session->value_to = $session_array['value_to'];
        
        $session->photo = $session_array['photo'];
echo        $session->have_panorama = $session_array['have_panorama'];
        $session->have_plan = $session_array['have_plan'];
        $session->online = $session_array['online'];
        
            

            

            
            
/*        if (isset($post['new_building_flag_0']))
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

*/            
            

            
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
    }
    
}
    
    