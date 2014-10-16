<?php

class Module_Catalogue_Object_PublicTalk_SaveMessage extends Dune_Include_Abstract_Code
{

    protected function code()
    {
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        




        $session = Dune_Session::getInstance(Dune_Session::ZONE_AUTH);        
        $user = $session->getZone();
        
        $message_interval = Special_Vtor_Settings::$timeIntervalMessageToPublicTalk; 
        $time = Dune_Auth_Mysqli_UserTime::getInstance($user['user_id']);
        $cooc = Dune_Cookie_ArraySingleton::getInstance(Dune_Parameters::$cookieNameSystem);
        if ($time->getTime('pablic_talk_message') and $time->getTime('pablic_talk_message') > time() - $message_interval)
        {
            $cooc['text'] = $post->text;
            break;
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
            break;
        }
        
        Dune_BeforePageOut::registerObject($time);
        $time->setTime('pablic_talk_message');
        
        unset($cooc['text']);
        
        $object = new Special_Vtor_Object_Data($post->getDigit('object_id'));
        if (!$object->check())
        {
            return;
        }
        
        // Сохраняем сообщение
        $mail_to = new Module_Catalogue_Mail_Saler_GetPublicTalkMassage();
        $mail_to->ttext = $post->text;
        $mail_to->salerId = $object->saler_id;
        $mail_to->senderId = $user['user_id'];
        $mail_to->senderName = $user['user_name'];
        $mail_to->objectId = $post->getDigit('object_id');
        $mail_to->make();
        
        
        // Сохраняем сообщение
        $publicTalk = new Special_Vtor_Object_PublicTalkOne($post->getDigit('object_id'));
        $publicTalk->setText($post->text);
        $publicTalk->setUserId($user['user_id']);
        $publicTalk->setObjectId($post->getDigit('object_id'));
        $publicTalk->add();



/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
    }
    
}
    
    