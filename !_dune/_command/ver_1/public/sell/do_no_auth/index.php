<?php
    $session = Dune_Session::getInstance('control');
    $cooc = Dune_Cookie_ArraySingleton::getInstance(Dune_Parameters::$cookieNameSystem);
    $URL = Dune_Parsing_UrlSingleton::getInstance();
    switch ($URL[4])
    {
        case 'delete':
            if (isset($cooc['edit']) and $cooc['edit'] > 0 and $cooc['edit_type'] == 'object')
            {
                $current_object = Special_Vtor_Object_Query_AuthNo_DataSingleton::getInstance($cooc['edit']);
                if (!$current_object->isFromBd())
                {
                    throw new Dune_Exception_Control_Goto('Объект уделен.', 51);
                }
                $session->clearZone();
                
                $plan = new Special_Vtor_Object_Query_PlanAuthNo($current_object->getId(), $current_object->getTime());
                $plan->deletePreviewFolder();
                $plan->deleteFolder();
                
                $photo = new Special_Vtor_Object_Query_ImageAuthNo($current_object->getId(), $current_object->getTime());
                $photo->deletePreviewFolder();
                $photo->deleteFolder();
        
                       
                $current_object->delete();
            }
            unset($cooc['edit']);
            unset($cooc['have_object_to_sell']);
            unset($cooc['edit_type']);
            unset($cooc['edit_type_code']);
            throw new Dune_Exception_Control_Goto('Объект удaлен.', 56);
        break;
    }