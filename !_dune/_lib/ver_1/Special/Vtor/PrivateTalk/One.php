<?php
/**
 * 
 * Список данных об объекте.
 * 
 */
class Special_Vtor_PrivateTalk_One
{
    protected $_DB = null;
    
    protected $_activity = null;
    protected $_id;
    protected $_interlocutorId;
    
    protected $_text = '';
    protected $_topicCode = 0;
    protected $_topicId;
    protected $_messageId;
    
    
                        
    public static $tableTopicList      = 'unity_private_talk_topic_list';
    public static $tableTopicText      = 'unity_private_talk_topic_text';
    
    
	public function __construct($id = null)
	{
	    $this->_id = $id;
	    $this->_DB = Dune_MysqliSystem::getInstance();
	}
	
	public function setInterlocutorId($id)
	{
	    $this->_interlocutorId = $id;
	}
	
	public function setUserId($id)
	{
	    $this->_id = $id;
	    return $this;
	}
	
	public function setTopicId($id)
	{
	    $this->_topicId = $id;
	    return $this;
	}
	public function setMessageId($id)
	{
	    $this->_messageId = $id;
	    return $this;
	}

	public function setTopicCode($id)
	{
	    $this->_topicCode = $id;
	    return $this;
	}
	
	public function setText($text)
	{
//	    $this->_text = htmlspecialchars($text); // что-то странное
        $str_o = new Dune_String_Transform($text);
        $this->_text = $str_o->setQuoteRussian()->setLineFeedToBreak()->getResult(); 
//	    $this->_text = str_replace("\n", '<br />', $this->_text);
	    return $this;
	}

	public function readOne()
	{
/*    	   $q = 'UPDATE ?t SET `read` = 1 WHERE interlocutor = ?i and topic_code = ?i and topic_id = ?i and user = ?i LIMIT 1';
	       return $this->_DB->query($q, array(self::$tableTopicList,
	                                        $this->_id,
	                                        $this->_topicCode, 
	                                        $this->_topicId,
	                                        $this->_interlocutorId
	                                        ), Dune_MysqliSystem::RESULT_AR);
*/
	                                        
    	   $q = 'UPDATE ?t SET `read` = 1, time_read = NOW() WHERE interlocutor_id = ?i AND id = ?i';
	       $result = $this->_DB->query($q, array(self::$tableTopicText,
	                                        $this->_id,
	                                        $this->_messageId
	                                        ), Dune_MysqliSystem::RESULT_AR);

//	       echo    $this->_DB->getQuery(); die();
	       return $result;
	                                        
	}
	
	
	public function read()
	{
/*    	   $q = 'UPDATE ?t SET `read` = 1 WHERE interlocutor = ?i and topic_code = ?i and topic_id = ?i and user = ?i LIMIT 1';
	       return $this->_DB->query($q, array(self::$tableTopicList,
	                                        $this->_id,
	                                        $this->_topicCode, 
	                                        $this->_topicId,
	                                        $this->_interlocutorId
	                                        ), Dune_MysqliSystem::RESULT_AR);
*/
	                                        
    	   $q = 'UPDATE ?t SET `read` = 1, time_read = NOW() WHERE interlocutor_id = ?i and topic_code = ?i and topic_id = ?i and user_id = ?i';
	       return $this->_DB->query($q, array(self::$tableTopicText,
	                                        $this->_id,
	                                        $this->_topicCode, 
	                                        $this->_topicId,
	                                        $this->_interlocutorId
	                                        ), Dune_MysqliSystem::RESULT_AR);
	                                        
	}
	
	
	public function add()
	{
	    $q = 'INSERT INTO ?t SET id = NULL, user_id = ?i, interlocutor_id = ?i, topic_code = ?i, topic_id = ?i, text = ?, time = NOW()';
	    $x = $this->_DB->query($q, array(self::$tableTopicText,
	                                    $this->_id,
	                                    $this->_interlocutorId, 
	                                    $this->_topicCode, 
	                                    $this->_topicId, $this->_text), Dune_MysqliSystem::RESULT_ID);
	    if ($x)
	    {
    	   $q = 'REPLACE INTO ?t SET user = ?i, interlocutor = ?i, topic_code = ?i, topic_id = ?i, `read` = 0, time = NOW()';
	       $x = $this->_DB->query($q, array(self::$tableTopicList,
	                                        $this->_id,
	                                        $this->_interlocutorId, 
	                                        $this->_topicCode, 
	                                        $this->_topicId
	                                        ), Dune_MysqliSystem::RESULT_AR);

	    }
	    return $x;
	}
    
	
	public function isHaveNewMessage()
	{
       $q = 'SELECT COUNT(*)
             FROM ?t as `talk` 
             WHERE
                `talk`.`interlocutor_id` = ?i
                AND `talk`.`read` = 0';

        return $this->_DB->query($q, array(
                                         self::$tableTopicText,
                                         $this->_id, 
                                         ), Dune_MysqliSystem::RESULT_EL);
	}

/////////////////////////////////////////////////////////////////////////////////    
    
    
}