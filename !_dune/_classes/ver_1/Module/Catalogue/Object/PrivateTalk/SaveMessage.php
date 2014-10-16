<?php

class Module_Catalogue_Object_PrivateTalk_SaveMessage extends Dune_Include_Abstract_Code
{
    
    protected function code()
    {
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        

        $session = Dune_Session::getInstance(Dune_Session::ZONE_AUTH);        
        $user = $session->getZone();
        
        $message_interval = Special_Vtor_Settings::$timeIntervalMessageToPrivateTalk; 
        $time = Dune_Auth_Mysqli_UserTime::getInstance($user['user_id']);
        $cooc = Dune_Cookie_ArraySingleton::getInstance(Dune_Parameters::$cookieNameSystem);
        if ($time->getTime('private_talk_message') and $time->getTime('private_talk_message') > time() - $message_interval)
        {
            $cooc['text'] = $post->text;
            
            return;
        }
        $post = Dune_Filter_Post_Total::getInstance();
        $post->trim();
        $post->setLength(500);
        $post->htmlSpecialChars();
        if (
            ($post->getDigit('object_id') < 1)
            or (strlen($post->text) < 5)
            )
        {
            $cooc['text'] = $post->text;
            return;
        }
        
        $object = new Special_Vtor_Object_Data($post->getDigit('object_id'));
        if (!$object->check())
        {
            $cooc['text'] = $post->text;
            return;
        }
        
        Dune_BeforePageOut::registerObject($time);
        $time->setTime('private_talk_message');
        
        unset($cooc['text']);
        
        // Отправляем сообщение о получении сообщения
        $mail_to = new Module_Catalogue_Mail_Saler_GetPrivateTalkMassage();
        $mail_to->ttext = $post->text;
        $mail_to->salerId = $object->saler_id;
        $mail_to->senderId = $user['user_id'];
        $mail_to->senderName = $user['user_name'];
        $mail_to->objectId = $post->object_id;
        $mail_to->make();
        
        $pTalk = new Special_Vtor_PrivateTalk_One($user['user_id']);
        $pTalk->setText($post->text);
        $pTalk->setInterlocutorId($object->saler_id);
//        $pTalk->setTopic('object');
//        $pTalk->setTopicCode(0);
        $pTalk->setTopicId($post->object_id);
        $pTalk->add();

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
    }
}