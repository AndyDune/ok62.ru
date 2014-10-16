<?php

class Module_User_Contact_SaveMessage extends Dune_Include_Abstract_Code
{
    
    protected function code()
    {
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        

        $session = Dune_Session::getInstance(Dune_Session::ZONE_AUTH);        
        $user = $session->getZone();
        $this->setResult('success', false);

        $post = Dune_Filter_Post_Total::getInstance();
        $post->trim();
        $post->setLength(3000);
        
        $message_interval = Special_Vtor_Settings::$timeIntervalMessageToPrivateTalk; 
        $time = Dune_Auth_Mysqli_UserTime::getInstance($user['user_id']);
        $cooc = Dune_Cookie_ArraySingleton::getInstance(Dune_Parameters::$cookieNameSystem);
        if ($time->getTime('private_talk_message') and $time->getTime('private_talk_message') > time() - $message_interval)
        {
            $cooc['text'] = $post->text;
            Dune_Static_Message::setCode(1); // Пореже
            return;
        }
        if (
            (strlen($post->text) < 1)
            )
        {
            $cooc['text'] = $post->text;
            Dune_Static_Message::setCode(2);  // Текста мало
            return;
        }
        
        if ($this->topic_code == 0)
        {
            $object = new Special_Vtor_Object_Data($this->topic_id);
            if (!$object->check() or $object->activity != 1
                or 
                ($object->saler_id != $user['user_id']  and $object->saler_id != $this->interlocutor)
                )
            {
                $cooc['text'] = $post->text;
                Dune_Static_Message::setCode(3);  // В теме запрещено оставлять сообщение
                return;
            }
        }
        Dune_BeforePageOut::registerObject($time);
        $time->setTime('private_talk_message');
        
        unset($cooc['text']);
        
        // Отправляем сообщение о получении сообщения
/*        $mail_to = new Module_Catalogue_Mail_Saler_GetPrivateTalkMassage();
        $mail_to->ttext = $post->text;
        $mail_to->salerId = $object->saler_id;
        $mail_to->senderId = $user['user_id'];
        $mail_to->senderName = $user['user_name'];
        $mail_to->objectId = $post->object_id;
        $mail_to->make();
*/       

        $post->htmlSpecialChars();
        
        $pTalk = new Special_Vtor_PrivateTalk_One($user['user_id']);
        $pTalk->setText($post->text);
        $pTalk->setInterlocutorId($this->interlocutor);
        $pTalk->setTopicCode($this->topic_code);
        $pTalk->setTopicId($this->topic_id);
        $pTalk->add();
        
        $this->setResult('success', true);
        
        $value = $this->interlocutor_object->getUserArrayConfigCell('settings');
        $array = new Dune_Array_Container($value);
        // Если включено посыл сообщения при сообщении.
        if ($array['mail_on_message'])
        {
            $mail = new Module_Mail();
            $view = Dune_Zend_View::getInstance();
            $URL = Dune_Parsing_UrlSingleton::getInstance();
            $URL->setCommand('user_' . $user['user_id'], 3);
            $view->command = $URL->getCommandString();
            $view->domain = Dune_Parameters::$siteDomain;
            $view->mtext = $post->text;
            $view->name = $user['user_name'];
            $view->user_id = $user['user_id'];
            
            $mail->body = $view->render('mail/talk/get_private_message'); 
            $mail->mail = $this->interlocutor_object->getUserMail();
            $mail->name = $this->interlocutor_object->getUserName();
            $mail->subject = 'Сообщение от пользователя ' . $user['user_name'];
            $mail->make();
        }
        

        
        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
    }
}