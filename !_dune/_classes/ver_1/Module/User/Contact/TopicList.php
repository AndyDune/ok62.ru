<?php

class Module_User_Contact_TopicList extends Dune_Include_Abstract_Code
{

    protected function code()
    {
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        

    $this->setResult('success', true);
    
    $list_sell = new Special_Vtor_Object_List();
    $list_sell->setShowWitoutHouseNumber();
    $list_sell->setActivity(1);
    $list_sell->setOrder('time_insert', 'DESC');
    
    if ($this->user)
    {
        $list_sell->setSeller($this->user->getUserId());
        $result_array_sell_i = $list_sell->getListCumulate(0, 2000);
    }
    else 
        $result_array_sell_i = array();
        
    $list_sell->setSeller($this->interlocutor->getUserId(), true);
    $result_array_sell_enemy = $list_sell->getListCumulate(0, 2000);
    
    $list_topics = new Special_Vtor_PrivateTalk_ListTopics($this->user->getUserId());
    $list_topics->setTopicCode(1);
    $list_topics->setInterlocutorId($this->interlocutor->getUserId());
    
    $topic_total_array_i = $list_topics->getListTopicsInCodeWriteByMe();
    $topic_total_array_enemy = $list_topics->getListTopicsInCodeWriteByEnemy();

    $list_topics->setTopicCode(0);    
    $topic_object_array_i = $list_topics->getListTopicsInCodeWriteByMe();
    $topic_object_array_enemy = $list_topics->getListTopicsInCodeWriteByEnemy();
    
    
    $view = Dune_Zend_View::getInstance();
    
    $session = Dune_Session::getInstance('user_page');
    $view->show_all = $session->show_all;
    
    if ($count_result_array_sell_enemy = count($result_array_sell_enemy))
    {
        
    }
    $count_result_array_sell_i = count($result_array_sell_i);
    
    $view->count_result_array_sell_enemy = $count_result_array_sell_enemy;
    $view->count_result_array_sell_i = $count_result_array_sell_i;
    
    $count_topics = 1 + $count_result_array_sell_enemy + $count_result_array_sell_i;
    $this->setResult('count', $count_topics);
        
    
    
    $view->topic_total_array_i = $topic_total_array_i;
    $view->topic_total_array_enemy = $topic_total_array_enemy;
    $view->topic_object_array_i = $topic_object_array_i;
    $view->topic_object_array_enemy = $topic_object_array_enemy;
    
    $view->interlocutor_id = $this->interlocutor->getUserId();
    $view->list_sell_i = $result_array_sell_i;
    $view->url = $this->url;
    $view->list_sell_enemy = $result_array_sell_enemy;
    $this->setResult('text', $view->render('bit/user/contact/topics_list_total'));

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
    }
    
}
    
    