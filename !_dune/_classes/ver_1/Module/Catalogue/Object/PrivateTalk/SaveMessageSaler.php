<?php

class Module_Catalogue_Object_PrivateTalk_SaveMessageSaler extends Dune_Include_Abstract_Code
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
        
        // Сохраняем сообщение
        $pTalk = new Special_Vtor_PrivateTalk_One($user['user_id']);
        $pTalk->setText($post->text);
        $pTalk->setInterlocutorId($post->interlocutor);
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
    
    