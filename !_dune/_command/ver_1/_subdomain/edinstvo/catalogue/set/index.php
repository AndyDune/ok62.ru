<?php

    
    $get = Dune_Filter_Get_Total::getInstance();
    
    $array = new Dune_String_Explode($get['set'], '_', 1);
    switch ($array[1])
    {
        case 'order':
            
            if (count($array) < 2)
                throw new Dune_Exception_Control_Goto();
                
            $module = new Module_Catalogue_List_Sort_Set();
            $module->field = $array[2];
            $module->order = $array[3];
            $module->make();
            
        break;
    }
    
    throw new Dune_Exception_Control_Goto();