<?php

class Module_User_MakeAfterEnter extends Dune_Include_Abstract_Code
{

    protected function code()
    {
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
    $this->results['goto'] = '';
    $cooc = Dune_Cookie_ArraySingleton::getInstance(Dune_Parameters::$cookieNameSystem);
    
    if (strlen($cooc[Special_Vtor_Settings::NO_AUTH_USER_CODE_KEY]) > 20)
    {
        $session = Dune_Session::getInstance(Dune_Session::ZONE_AUTH);
        
        $current = Special_Vtor_Object_Request_NoAuth_DataSingleton::getInstance();
        $current->setUserCode($cooc[Special_Vtor_Settings::NO_AUTH_USER_CODE_KEY]);
        $current->setToAuth($session->user_id);
        
        unset($cooc[Special_Vtor_Settings::NO_AUTH_USER_CODE_KEY]);
    }
    
    switch (true)
    {
        case $cooc['have_pablic_message'] :

            if ($cooc['text'] and $cooc['object_id'])
            {
                $object_id = (int)$cooc['object_id'];
                $text = htmlspecialchars(substr($cooc['text'], 0, Special_Vtor_Settings::$maxLengthMessagePublic));
                    
                $object = new Special_Vtor_Object_Data($object_id);
                if ($object->check())
                {
                    $session = Dune_Session::getInstance(Dune_Session::ZONE_AUTH);
                    $pTalk = new Special_Vtor_Object_PublicTalkOne();
                    $pTalk->setText($text);
                    $pTalk->setUserId($session->user_id);
                    $pTalk->setObjectId($object_id);
                    $new_id = $pTalk->add();
                    if ($new_id and $cooc['url'])
                    {
                        if ($pos = strpos($cooc['url'], '#'))
                        {
                            $cooc['url'] = substr($cooc['url'], 0, $pos);
                        }
                        $this->results['goto'] = $cooc['url'] . '#mes_' . $new_id;
                    }
                }
            }
            unset($cooc['url']);
            unset($cooc['text']);
            unset($cooc['have_pablic_message']);
            unset($cooc['object_id']);
        break;
        case $cooc['have_private_message'] :

            if ($cooc['text'] and $cooc['object_id'])
            {
                $object_id = (int)$cooc['object_id'];
                $text = htmlspecialchars(substr($cooc['text'], 0, Special_Vtor_Settings::$maxLengthMessagePublic));
                    
                $object = new Special_Vtor_Object_Data($object_id);
                if ($object->check())
                {
                    
                    
                    $session = Dune_Session::getInstance(Dune_Session::ZONE_AUTH);
                    
                    
/*                    $pTalk = new Special_Vtor_Object_PublicTalkOne();
                    $pTalk->setText($text);
                    $pTalk->setUserId($session->user_id);
                    $pTalk->setObjectId($object_id);
                    $new_id = $pTalk->add();
*/                    
                    $pTalk = new Special_Vtor_PrivateTalk_One($session->user_id);
                    $pTalk->setText($text);
                    $pTalk->setInterlocutorId($object->saler_id);
                    $pTalk->setTopicId($object_id);
                    $new_id = $pTalk->add();
                    
                    if ($new_id and $cooc['url'])
                    {
                        if ($pos = strpos($cooc['url'], '#'))
                        {
                            $cooc['url'] = substr($cooc['url'], 0, $pos);
                        }
                        $this->results['goto'] = $cooc['url'] . '#mes_' . $new_id;
                    }
                }
            }
            unset($cooc['url']);
            unset($cooc['text']);
            unset($cooc['have_pablic_message']);
            unset($cooc['object_id']);
        break;
        
        
        case $cooc['have_object_to_sell'] :
            if (isset($cooc['edit']) and $cooc['edit_type'] == 'object')
            {
                $current_object = Special_Vtor_Object_Query_AuthNo_DataSingleton::getInstance($cooc['edit']);
                if ($current_object->isFromBd())
                {
                    $new_object = Special_Vtor_Object_Query_DataSingleton::getInstance();
                    $session = Dune_Session::getInstance(Dune_Session::ZONE_AUTH);
                    $new_object->setUserId($session->user_id);
                    $new_object->setTypeId($current_object->getTypeId());
                    $new_object->setStatus(1);
                    $new_object->loadData($current_object->getData());
//                    $new_object->add(true);
                    
        $module = new Module_Catalogue_Object_Save_DoAfterSendToSell();
        $module->object_id = $new_object->add(true);
        $module->make();
                    
                    
                    $plan = new Special_Vtor_Object_Query_PlanAuthNo($current_object->getId(), $current_object->getTime());
                    $plan->deletePreviewFolder();
                    $photo = new Special_Vtor_Object_Query_ImageAuthNo($current_object->getId(), $current_object->getTime());
                    $photo->deletePreviewFolder();

                    if ($photo->count())
                    {
                        $photo_new = new Special_Vtor_Object_Query_Image($new_object->getId(), $new_object->getTime(), true);
                        $url_new = $photo_new->getSystemUrl();
                        foreach ($photo as $value)
                        {
                            $file_name = $value->getSourseFileName();
                            $file_name_full = $value->getSourseFileUrlSystem();
                            copy($file_name_full, $url_new . '/' . $file_name);
                        }
                    }
                    if ($plan->count())
                    {
                        $photo_new = new Special_Vtor_Object_Query_Plan($new_object->getId(), $new_object->getTime(), true);
                        $url_new = $photo_new->getSystemUrl();
                        foreach ($plan as $value)
                        {
                            $file_name = $value->getSourseFileName();
                            $file_name_full = $value->getSourseFileUrlSystem();
//                            copy($file_name_full, $url_new . '/' . $file_name);
                            if (!copy($file_name_full, $url_new . '/' . $file_name))
                            {
                                echo 'Куда ' . $url_new . '/' . $file_name . '<br />';
                                echo 'Откуда ' . $file_name_full;
                                //die();
                            }
                            
                        }
                    }
                    
                           
                    $current_object->delete();
                    $plan->deleteFolder();
                    $photo->deleteFolder();
                }
                $this->setResult('goto', '/user/sell/request/');
            }       
            unset($cooc['edit']);
            unset($cooc['have_object_to_sell']);
            unset($cooc['edit_type']);
            unset($cooc['edit_type_code']);
        break;
        
    }


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
    }
    
}
    
    