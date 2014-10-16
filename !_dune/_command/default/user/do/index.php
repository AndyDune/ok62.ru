<?php

$URL = Dune_Parsing_UrlSingleton::getInstance();
switch (true)
{
    case (!Dune_Session::$auth):
    break;
    case ($URL[3] == 'savetobasket'):
        if ($URL[4])
        {
            $basket = new Special_Vtor_Object_User_Save($URL[4]);
            $session = Dune_Session::getInstance(Dune_Session::ZONE_AUTH);
            $basket->save($session->user_id);
        }
    break;
    case ($URL[3] == 'savefrombasket'):
        if ($URL[4])
        {
            $basket = new Special_Vtor_Object_User_Save($URL[4]);
            $session = Dune_Session::getInstance(Dune_Session::ZONE_AUTH);
            $basket->saveNo($session->user_id);
        }
    break;
///////////////////////////////////////////////////////////////    
// Сохраняем сообщение из базара по объекту.    
    case ($URL[3] == 'save-message-to-publictalk'):

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
        
        // Сохраняем сообщение
        $publicTalk = new Special_Vtor_Object_PublicTalkOne($post->getDigit('object_id'));
        $publicTalk->setText($post->text);
        $publicTalk->setUserId($user['user_id']);
        $publicTalk->setObjectId($post->object_id);
        $publicTalk->add();
    break;

    
///////////////////////////////////////////////////////////////    
// Сохраняем сообщение из базара по объекту.    
    case ($URL[3] == 'save-message-to-privatetalk'):
        $module = new Module_Catalogue_Object_PrivateTalk_SaveMessage();
        $module->make();
    break;
    case ($URL[3] == 'save-message-to-privatetalksaler'):
        $module = new Module_Catalogue_Object_PrivateTalk_SaveMessageSaler();
        $module->make();
    break;
    
    
}

$this->status = Dune_Include_Command::STATUS_EXIT;