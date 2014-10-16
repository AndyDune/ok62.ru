<?php

class Module_User_Contact_TopicOneSaveOnly extends Dune_Include_Abstract_Code
{

    protected function code()
    {
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
    $this->setResult('success', false);
    $this->setResult('output', 'save');
    
    $post = Dune_Filter_Post_Total::getInstance();
    if ($post['_do_'] == 'save')
    {
        $module = new Module_User_Contact_SaveMessage();
        $module->topic_code = $this->topic_code;
        $module->topic_id   = $this->topic_id;
        $module->interlocutor = $this->interlocutor->getUserId();
        $module->interlocutor_object = $this->interlocutor;
        $module->make();
        
        $this->setResult('success', $module->getResult('success'));
        
        //$this->setResult('exit', true);
        $this->setResult('goto', Dune_Parameters::$pageInternalReferer . '#edge');
        return;
    }
    else 
    {
        $talk = new Special_Vtor_PrivateTalk_List($this->user->getUserId());
        $talk->setTopicId($this->topic_id);
        $talk->setTopicCode($this->topic_code);
        $talk->setInterlocutorId($this->interlocutor->getUserId());
        
        
        
        
        $view = Dune_Zend_View::getInstance();
        $view->url = $this->url;
        
//        $view->count = $talk->count();
        $view->i = $this->user->getUserId();
        $tt = $post->getDigit('time', 0);
        if ($tt > 10000)
        {
            $view->list = $talk->getListCumulateToMe(0, 1000, date('Y-m-d H:i:s', $tt));
            if ($view->list)
            {
                    // Помечаем поле темукака прочитанную.
                $pTalk = new Special_Vtor_PrivateTalk_One($this->user->getUserId());
                $pTalk->setTopicId($this->topic_id);
                $pTalk->setTopicCode($this->topic_code);
                $pTalk->setInterlocutorId($this->interlocutor->getUserId());
                $pTalk->read();
            }
            
        }
        else 
            $view->list = false;
//        $view->render('ajax/talk/last_list');

    Dune_Static_Header::charset();
    $this->setResult('success', true);
    $this->setResult('output', 'list');
    echo time() . '-' . $view->render('ajax/talk/last_list');
    }

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
    }
    
}
    
    