<?php

class Module_Catalogue_Object_Save_QueryFromUserAuth extends Dune_Include_Abstract_Code
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
            $post->setLength(1000);
            $post->htmlSpecialChars();;
                
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
                if ($post->haggling)
                    $session->haggling = $post->haggling;
                else 
                    $session->haggling = 0;
    
                // Флаг возможности торга
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
            
//            $module = new Module_Catalogue_Object_Save_CheckRequire();
            
//            $module->make();
//            if (!$module->getResult('success'))
//                throw new Dune_Exception_Control('Не заполнены обязательные поля.', 1);
                
            $object = new Special_Vtor_Object_Query_Data();
            $object->setUserId(Special_Vtor_User_Auth::$id);
            
            if (($object->getLastObjectInsertTime() !== false) and $object->getLastObjectInsertTime() < Special_Vtor_Settings::$timeIntervalObjectToAdd)
                throw new Dune_Exception_Control('Слишком часто.', 2);
                
//            if ($object->getCountObjectsInsertInQuery() >= Special_Vtor_Settings::$maxObjectsInQueryToAdd)
//                throw new Dune_Exception_Control('Слишком много.', 4);
//            else 
//                throw new Dune_Exception_Control('Потеря сеанса.', 3);

                
            $object->setTypeId($post->type);
            unset($session->type);
            $object->loadData($session->getZone()); 
            if ($this->update_id)
            {
                if ($object->useIdGetDataFromDb($this->update_id))
                {
                    $object->setStatus(0);
                    $object->save();
                    $result = $object->save();
                    $result = 1;            //      !!! - разобраться с возвращением нуля.
                }
                
            }
            else 
            {
                //$result = $object->add();
            }
            if ($result)
            {
                $session->killZone();
                $this->setResult('success', true);
            }    
            $this->setResult('id', $result);
            



/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
    }
    
}
    
    