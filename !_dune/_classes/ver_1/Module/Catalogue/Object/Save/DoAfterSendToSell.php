<?php

class Module_Catalogue_Object_Save_DoAfterSendToSell extends Dune_Include_Abstract_Code
{
    protected function code()
    {
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
        $current_object = Special_Vtor_Object_Query_DataSingleton::getInstance($this->object_id);
        $photo = new Special_Vtor_Object_Query_Image($current_object->getId(), $current_object->getTime());
        $plan = new Special_Vtor_Object_Query_Plan($current_object->getId(), $current_object->getTime());    
        
        $folderDisplay = '/' . Special_Vtor_Settings::$folderToSellKeep . '/' . $current_object->getId();
        $folderSystem = $_SERVER['DOCUMENT_ROOT'] . $folderDisplay;
        if (!is_dir($folderSystem))
            mkdir($folderSystem);
        else 
        {
            $dir = new Dune_Directory_Delete($folderSystem);
            $dir->deleteContent();
        }
        
        $user = new Dune_Auth_Mysqli_UserActive($current_object->getUserId());
        
        $array_photo = array();
        $array_plan  = array();
        
        if ($photo->count())
        {
            $folderSystemPic = $folderSystem . '/photo';
            if (!is_dir($folderSystemPic))
                mkdir($folderSystemPic);
        
            foreach ($photo as $value)
            {
                $file_name = $value->getSourseFileName();
                $file_name_full = $value->getSourseFileUrlSystem();
                copy($file_name_full, $folderSystemPic . '/' . $file_name);
                $array_photo[] = $file_name;
            }
        }
        
        if ($plan->count())
        {
            $folderSystemPic = $folderSystem . '/plan';
            if (!is_dir($folderSystemPic))
                mkdir($folderSystemPic);
            foreach ($plan as $value)
            {
                $file_name = $value->getSourseFileName();
                $file_name_full = $value->getSourseFileUrlSystem();
                copy($file_name_full, $folderSystemPic . '/' . $file_name);
                $array_plan[] = $file_name;
            }
        }
        
        $view = Dune_Zend_View::getInstance();
                
        $object_condition = new Special_Vtor_Object_Condition();
        $object_condition = $object_condition->getList($current_object->getTypeId());
        $object_planning = new Special_Vtor_Object_Planning();
        $object_planning = $object_planning->getList();

        $view->status = $current_object->getStatus();
       
        $view->condition = $object_condition;
        $view->planning = $object_planning;
    
        $house_type = new Special_Vtor_Object_Add_HouseType();
        $view->house_type = $house_type->getListType($current_object->getTypeId());
        
        
        $view->data = $current_object->getData(true);
        $view->type_id = $current_object->getTypeId();
        $view->type_code = $current_object->getTypeCodeName();
        $view->time = $current_object->getTime();
        $view->id = $current_object->getId();
        $view->user_id = $user->getUserId();
        $view->user_mail = $user->getUserMail();
        $view->user_name = $user->getUserName();
        $view->domain = Dune_Parameters::$siteDomain;
        $view->folder = $folderDisplay;
        
        $view->array_photo = $array_photo;
        $view->array_plan  = $array_plan;
        
        $text = $view->render('page/tosell/file/' . $current_object->getTypeCodeName());
        
        file_put_contents($folderSystem . '/index.htm', $text);
        
        $mail = new Module_Catalogue_Mail_GetToSell();
        $mail->textmail = $text;
        $mail->make();
        
//        die();
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
    }
    
}
    
    