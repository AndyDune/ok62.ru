<?php

class Module_Catalogue_Object_Save_QueryFromUserAuthNo extends Dune_Include_Abstract_Code
{
    
    protected function code()
    {
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
            $this->setResult('success', false);

            $post = Dune_Filter_Post_Total::getInstance();

            $post->trim();
            $post->htmlSpecialChars();;
            $post->setLength(500);
            
            $stop = false;
            
            $session = Dune_Session::getInstance('data');
            $session->clearZone();
            foreach ($post as $key => $value)
            {
                $session->$key = $value;
            }
            
        if (!$this->gm)
        {
            
            if ($post->balcony)
                $session->balcony = 1;
            else 
                $session->balcony = 0;
                
            if ($post->loggia)
                $session->loggia = 1;
            else 
                $session->loggia = 0;
    
            if ($post->activity)
                $session->activity = 1;
            else 
                $session->activity = 0;

            if ($post->have_phone)
                $session->have_phone = 1;
            else 
                $session->have_phone = 0;

            // Флаг возможности торга
//            if ($post->haggling)
                $session->haggling = $post->getDigit('haggling');
//            else 
//                $session->haggling = 0;

            
            // Тип дома
            if ($post->house_type)
                $session->house_type = $post->getDigit('house_type');
            else 
                $session->house_type = 0;
                
                            
            $spaces = new Dune_String_Explode($session->space_total,'/', 1);
            if ($spaces->count() == 3)
            {
                $session->space_total = $spaces[1];
                $session->space_living = $spaces[2];
                $session->space_kitchen = $spaces[3];
            }
                
        }                

            $session = Dune_Session::getInstance('control');
            $object = Special_Vtor_Object_Query_AuthNo_DataSingleton::getInstance($session->edit);
            
//            else 
//                throw new Dune_Exception_Control('Потеря сеанса.', 3);

            $session = Dune_Session::getInstance('data');
                
            $object->setTypeId($post->type);
            unset($session->type);
            $object->loadData($session->getZone()); 

            if ($this->update_id)
            {
                $result = $object->save();

            }
            else 
            {
                //$result = $object->add();
            }
            if ($result)
            {
                $session->clearZone();
                $this->setResult('success', true);
            }    
            $this->setResult('id', $result);
            



/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
    }
    
}
    
    