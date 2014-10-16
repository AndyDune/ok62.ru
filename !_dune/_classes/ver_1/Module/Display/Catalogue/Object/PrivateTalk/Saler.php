<?php

class Module_Display_Catalogue_Object_PrivateTalk_Saler extends Dune_Include_Abstract_Code
{
    
    protected function code()
    {
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
        $session = Dune_Session::getInstance(Dune_Session::ZONE_AUTH);        
        $user = $session->getZone();


        $get = Dune_Filter_Get_Total::getInstance();
        Dune_Static_StylesList::add('catalogue/info/pablic_talk_list');
        
        $view = Dune_Zend_View::getInstance();
        if ($get->check('user'))
        {
            
            $talk = new Special_Vtor_PrivateTalk_List($user['user_id']);
            $talk->setTopicId($this->object->id);
            $talk->setInterlocutorId($get->getDigit('user'));
            
            $view->count = $talk->count();
            $view->list = $talk->getListCumulate();
            $view->url = $this->url_object->get();
            $view->seller = $this->object->saler_id;
            echo $view->render('bit/catalogue/object/talk_private/list_saler_simple');
            
            
            $display = new Module_Display_Catalogue_Object_PrivateTalk_FormSaler();
            $display->object = $this->object;
            $display->interlocutor = $get->getDigit('user');
            $display->make();
            echo $display->getOutput();
            
            
            // Помечаем поле тему как прочитанную.
            $pTalk = new Special_Vtor_PrivateTalk_One($user['user_id']);
            $pTalk->setInterlocutorId($get->getDigit('user'));
            $pTalk->setTopicId($this->object->id);
            $pTalk->read();
        }
        else 
        {
            $buyer_list = new Special_Vtor_PrivateTalk_ListInterlocuter($user['user_id']);
            $buyer_list->setTopicId($this->object->id);
            $view->list = $buyer_list->getList();
            $view->count = count($view->list);
            $view->url = $this->url_object->get();
            echo $view->render('bit/catalogue/object/talk_private/list_interlocutor');
        }
        
        
/*        $view->count = $talk->count();
        $view->list = $talk->getListCumulate();
        echo $view->render('bit/catalogue/object/talk_private/list_simple');
*/        

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
    }
}
    
    