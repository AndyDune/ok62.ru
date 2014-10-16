<?php

class Module_User_Contact_TopicOne extends Dune_Include_Abstract_Code
{

    protected function code()
    {
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
    $this->setResult('success', true);
    $this->setResult('exit', false);
    $this->setResult('goto', false);
    
    $post = Dune_Filter_Post_Total::getInstance();
    if ($post['_do_'] == 'save')
    {
        $module = new Module_User_Contact_SaveMessage();
        $module->topic_code = $this->topic_code;
        $module->topic_id   = $this->topic_id;
        $module->interlocutor = $this->interlocutor->getUserId();
        $module->interlocutor_object = $this->interlocutor;
        $module->make();
        
        //$this->setResult('exit', true);
        $this->setResult('goto', Dune_Parameters::$pageInternalReferer . '#edge');
        return;
    }
    
    
    $view = Dune_Zend_View::getInstance();
    $view->url = $this->url;
    
            
        $talk = new Special_Vtor_PrivateTalk_List($this->user->getUserId());
        $talk->setTopicId($this->topic_id);
        $talk->setTopicCode($this->topic_code);
        $talk->setInterlocutorId($this->interlocutor->getUserId());
            
            // Помечаем поле темукака прочитанную.
            $pTalk = new Special_Vtor_PrivateTalk_One($this->user->getUserId());
            $pTalk->setTopicId($this->topic_id);
            $pTalk->setTopicCode($this->topic_code);
            $pTalk->setInterlocutorId($this->interlocutor->getUserId());
            $pTalk->read();
            
            
        $view->count = $talk->count();
        $view->i = $this->user->getUserId();
        $view->list = $talk->getListCumulate();
            
//      $view->text = $view->render('bit/catalogue/object/talk_private/list_simple');
    
    
        if ($this->topic_code == 0)
        {
            $object = new Special_Vtor_Object_Data($this->topic_id);
            if (!$object->check() or $object->activity != 1
                or 
                ($object->saler_id != $this->user->getUserId()  and $object->saler_id != $this->interlocutor->getUserId())
                )
            {
                Dune_Static_Message::setCode(3);  // В теме запрещено оставлять сообщение
                $this->setResult('goto', '/user/info/' . $this->interlocutor->getUserId() . '/');
                return;
            }
            else 
            {
                $view->object = $object->getInfo(true);
                $planer = new Special_Vtor_Catalogue_Info_Plan($object->id, $object->time_insert); // а есть ли планеровка (план)

                if ($planer->count())
                {
                    $temp = $planer->getOneImage();
                    $view->preview = $temp->getPreviewFileUrl();
                }
                else if ($object->pics)
                {
                    $image = new Special_Vtor_Catalogue_Info_Image($object->id, $object->time_insert);
                    $temp = $image->getOneImage();
                    $view->preview = $temp->getPreviewFileUrl();
                }
                else 
                    $view->preview = '';
            }
        }


//    $text = $view->render('bit/user/contact/topic_one');
    
    
     // Фотография собеседника
     $photo = new Special_Vtor_User_Image_Photo($this->interlocutor->getUserId(), $this->interlocutor->time);
     
     $array_photo = array();
     if (count($photo))
     {
         foreach ($photo as $key => $value)
         {
             $array_photo[0]  = $value->getSourseFileName();
             $array_photo[1]  = $value->getSourseFileUrl();
             $array_photo[2]  = $value->getPreviewFileUrl();
         }
     }
    
    $view    = Dune_Zend_View::getInstance();

    $view->array_photo = $array_photo;

    $view->topic_code = $this->topic_code;
    $view->topic_id = $this->topic_id;

    $view->interlocutor = $this->interlocutor->getUserId();
    
//    $view->action = '/user/do/save-message-to-privatetalk/';
    
    $cooc = Dune_Cookie_ArraySingleton::getInstance(Dune_Parameters::$cookieNameSystem);
    $view->text = $cooc['text'];
    
//    echo $view->render('bit/catalogue/object/talk/form_simple');
    
    $URL = Dune_Parsing_UrlSingleton::getInstance();
    $view->this_url = $URL->getCommandString();
    $view->form =  $view->render('bit/user/contact/form');

    $view->interlocutor = $this->interlocutor;    
    $text = $view->render('bit/user/contact/topic_one');    
    
    $this->setResult('text', $text);

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
    }
    
}
    
    