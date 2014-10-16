<?php

class Module_Admin_Catalogue_Object_SessionSetCommon extends Dune_Include_Abstract_Code
{

    protected function code()
    {
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        

        $session = Dune_Session::getInstance($this->name_zone);

        $post = Dune_Filter_Post_Total::getInstance();

        if ($post->activity)
        {
            $session->activity = 1;
            $session->time_close = date('Y-m-d H:i:s', time() + 155520000);
        }
        else
        { 
            $session->activity = 0;
            $session->time_close = date('Y-m-d H:i:s');
        }

        if ($post->name_complex)
        {
            $str = new Dune_String_Transform($post->name_complex);
            $session->name_complex = $str->setQuoteRussian()->getResult();
        }   
            
        if (!$post->house_number)
            $session->house_number = '';
        if (!$post->building_number)
            $session->building_number = '';
            
            
        if ($post->new_building_flag)
            $session->new_building_flag = 1;
        else 
            $session->new_building_flag = 0;
            
        if ($post->price_contractual)
            $session->price_contractual = 1;
        else 
            $session->price_contractual = 0;
        
        $session->haggling = $post->getDigit('haggling');
            
        switch (true)
        {
            case ($post->getDigit('deal_1') and $post->getDigit('deal_2')):
                $session->deal = 2;
            break;
            case ($post->getDigit('deal_2')):
                $session->deal = 1;
            break;
            default:
                $session->deal = 0;
        }
        
        $make = new Module_Catalogue_Object_MakeAfterEdit();
        $make->make();


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
    }
    
}
    
    