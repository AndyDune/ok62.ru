<?php
/**
 * 
 * Список данных об объекте.
 * 
 */
class Special_Vtor_PrivateTalk_List
{
    protected $_DB = null;
    
    protected $_activity = null;
    protected $_id;
    protected $_data = false;
    
    protected $_orderString = '';
                        
    public static $table          = 'unity_private_talk_topic_text';
    public static $tableList      = 'unity_private_talk_topic_list';
    public static $tableUser      = 'dune_auth_user_active';
    
    protected $_interlocutorId = 0;
        
    protected $_topicCode = 0;
    protected $_topicId = 0;
    
	public function __construct($id = 0)
	{
	    $this->_id = $id;
	    $this->_DB = Dune_MysqliSystem::getInstance();
	}

	public function setInterlocutorId($id)
	{
	    $this->_interlocutorId = $id;
	}
	
    public function setActivity($value = null)
    {
        $this->_activity = (int)$value;
    }	
    
	public function setTopicId($id)
	{
	    $this->_topicId = $id;
	}

	public function setTopicCode($id)
	{
	    $this->_topicCode = $id;
	}

	public function deleteTopic()
	{
	    if (!$this->_topicId)
	       return false;
	       
        $q = 'DELETE FROM ?t
              WHERE topic_id = ?i AND topic_code = ?i';

        
        return $this->_DB->query($q, array(
                                            self::$table,
                                            $this->_topicId,
                                            $this->_topicCode
                                            ), Dune_MysqliSystem::RESULT_AR);

	}
	
	
/////////////////////////////////////////////////////////////////////////////////    
    
    /**
     * Число записей с внедренными условиями
     *
     * @return integer
     */
    public function count()
    {
        $q = 'SELECT count(*) FROM '
                               . $this->_setFromString()
           
                               . $this->_collectWhere()
                               . ' GROUP BY `talk`.`id` ';

        
        return $this->_DB->query($q, null, Dune_MysqliSystem::RESULT_EL);
    }
    
    /**
     * Список записей из таблицы с ранее указанными параметрами.
     * Возвращает объект итеретор по результатам или false.
     *
     * @param integer $shift сдвиг
     * @param integer $limit колличество записей для выборки
     * @return Dune_Mysqli_Iterator_ResultAssoc
     */
    public function getListOnly($shift = 0, $limit = 100)
    {
        $q = 'SELECT * FROM ?t as talk' 
           . $this->_collectWhere()
           . $this->_orderString
           . ' LIMIT ?i, ?i';
        return $this->_DB->query($q, array(self::$table, $shift, $limit), Dune_MysqliSystem::RESULT_IASSOC);
    }

    
    /**
     * Список записей из таблицы с ранее указанными параметрами.
     * Извлекаются данные и из сязанных таблиц (типы, подтипы).
     * Возвращает объект итеретор по результатам или false.
     *
     * @param integer $shift сдвиг
     * @param integer $limit колличество записей для выборки
     * @return Dune_Mysqli_Iterator_ResultAssoc
     */
    public function getListCumulate($shift = 0, $limit = 500, $time = 0)
    {
        $where = $this->_collectWhere();
        
        if ($time)
        {
            if ($where)
            {
                $where .= ' AND ';
            }
            else 
                $where = ' WHERE ';
            $where .= ' talk.time > "' . $time . '"';
        }
        
       $q = 'SELECT talk.*,
                     user.name as name_user,
                     user.contact_name as name_user_contact
                     

             FROM '
           . $this->_setFromString()
           
           . $where
           . ' GROUP BY `talk`.`id` '
           . $this->_orderString           
           . ' LIMIT ?i, ?i';

        return $this->_DB->query($q, array($shift, $limit), Dune_MysqliSystem::RESULT_IASSOC);
    }

    
    public function getListCumulateNoRead($my_id, $time = 0)
    {
        $where = '
        WHERE talk.read = 0
            AND
            talk.interlocutor_id = ?i
            AND
            talk.user_id = user.id
        ';
        if ($time)
        {
            if ($where)
            {
                $where .= ' AND ';
            }
            else 
                $where = ' WHERE ';
            $where .= ' talk.time > "' . $time . '"';
        }
        
       $q = 'SELECT talk.*,
                     user.id as user_id,
                     user.name as name_user,
                     user.contact_name as name_user_contact
                     

             FROM '
           . $this->_setFromString()
           
           . $where
           . ' GROUP BY `talk`.`id` '
           . ' ORDER BY talk.time'
           ;

        return $this->_DB->query($q, array($my_id), Dune_MysqliSystem::RESULT_IASSOC);
    }
    
    public function getListCumulateAll($my_id, $shift = 0, $limit = 100, $time = 0)
    {
        $where = '
        WHERE 
            talk.interlocutor_id = ?i
            AND
            talk.user_id = user.id
        ';
        if ($time)
        {
            if ($where)
            {
                $where .= ' AND ';
            }
            else 
                $where = ' WHERE ';
            $where .= ' talk.time > "' . $time . '"';
        }
        
       $q = 'SELECT talk.*,
                     user.id as user_id,
                     user.name as name_user,
                     user.time as user_time,
                     user.contact_name as name_user_contact
                     

             FROM '
           . $this->_setFromString()
           
           . $where
           . ' GROUP BY `talk`.`id` '
           . ' ORDER BY talk.read ASC, talk.time DESC'
           . ' LIMIT ?i, ?i'
           ;

        return $this->_DB->query($q, array($my_id, $shift, $limit,), Dune_MysqliSystem::RESULT_IASSOC);
    }
    
    public function getCountAll($my_id, $time = 0)
    {
        $where = '
        WHERE 
            talk.interlocutor_id = ?i
        ';
        if ($time)
        {
            if ($where)
            {
                $where .= ' AND ';
            }
            else 
                $where = ' WHERE ';
            $where .= ' talk.time > "' . $time . '"';
        }
        
       $q = 'SELECT count(*)

             FROM '
           . ' `' . self::$table . '` as talk' 
           
           . $where
           ;

        return $this->_DB->query($q, array($my_id), Dune_MysqliSystem::RESULT_EL);
    }
    
    
    /**
     * Список записей из таблицы с ранее указанными параметрами.
     * Извлекаются данные и из сязанных таблиц (типы, подтипы).
     * Возвращает объект итеретор по результатам или false.
     *
     * @param integer $shift сдвиг
     * @param integer $limit колличество записей для выборки
     * @return Dune_Mysqli_Iterator_ResultAssoc
     */
    public function getListCumulateToMe($shift = 0, $limit = 500, $time = 0)
    {
        $where = $this->_collectWhereToMe();
        
        if ($time)
        {
            if ($where)
            {
                $where .= ' AND ';
            }
            else 
                $where = ' WHERE ';
            $where .= ' talk.time > "' . $time . '"';
        }
        
       $q = 'SELECT talk.*,
                     user.name as name_user,
                     user.id as user_id,
                     user.contact_name as name_user_contact
                     

             FROM '
           . $this->_setFromString()
           
           . $where
           . ' GROUP BY `talk`.`id` '
           . $this->_orderString           
           . ' LIMIT ?i, ?i';

        return $this->_DB->query($q, array($shift, $limit), Dune_MysqliSystem::RESULT_IASSOC);
    }
    
    
    
    protected function _addWhereSpecial()
    {
        return '';
    }

    protected function _setFromString()
    {
        $str = ' `' . self::$table . '` as talk,' 
             . ' `' . self::$tableUser . '` as user' 
//             . ' `' . self::$tableList . '` as topic' 
            ;
           
        return $str;
    }
    
/////////////////////////////////////////////////////////////////////////////////    
///////     Метды установки порядка выборки


    /**
     * Добавление порядка выборки. Время внесения записи.
     *
     * @param string $order направление ASC или DESC
     */
    public function setOrder($field, $order = 'ASC')
    {
        if (!$this->_orderString)
            $this->_orderString = ' ORDER BY ';
        else 
            $this->_orderString = ', ';
        $this->_orderString .= $field . ' ' . $order;
    }

    
    /**
     * Добавление порядка выборки. Время изменения записи.
     *
     * @param string $order направление ASC или DESC
     */
    public function setOrderTime($order = 'ASC')
    {
        if (!$this->_orderString)
            $this->_orderString = ' ORDER BY';
        $this->_orderString .= ' talk.time ' . $order;
     }
    
    
    /**
     * Сбросить порядок.
     */
    public function resetOrder()
    {
        $this->_orderString = '';
    }
    
////////////////////////////////////////////////////////////////////////
////////////        Защищённые методы
    protected function _collectWhere()
    {
        $where = '';
        $where = $this->_addWhereSpecial();
        
        if ($where)
            $where .= ' AND ';
        if ($this->_interlocutorId)
        {
            $str = '(
                    (talk.user_id = ?i AND talk.interlocutor_id = ?i)
                    OR
                    (talk.user_id = ?i AND talk.interlocutor_id = ?i)
                    )';

            $str = $this->_DB->makeSubstitution($str, array(
                                                            $this->_id, 
                                                            $this->_interlocutorId,
                                                            $this->_interlocutorId,
                                                            $this->_id
                                                            ));
            $where .= $str;                                                            

        }
        else 
            $where .= 'talk.user_id = ' . $this->_id;
            
        $where .= ' AND talk.user_id = user.id';
            
        $where .= ' AND talk.topic_id = ' . $this->_topicId;
        $where .= ' AND talk.topic_code = ' . $this->_topicCode;
        if ($where)
            $where = ' WHERE ' . $where;
        return $where;
    }    
    
    protected function _collectWhereToMe()
    {
        $where = '';
        $where = $this->_addWhereSpecial();
        
        if ($where)
            $where .= ' AND ';
        if ($this->_interlocutorId)
        {
            $str = '(
                    (talk.user_id = ?i AND talk.interlocutor_id = ?i)
                    )';

            $str = $this->_DB->makeSubstitution($str, array(
                                                            $this->_interlocutorId,
                                                            $this->_id
                                                            ));
            $where .= $str;                                                            

        }
        else 
            $where .= 'talk.user_id = ' . $this->_id;
            
        $where .= ' AND talk.user_id = user.id';
            
        $where .= ' AND talk.topic_id = ' . $this->_topicId;
        $where .= ' AND talk.topic_code = ' . $this->_topicCode;
        if ($where)
            $where = ' WHERE ' . $where;
        return $where;
    }    

    
    
    protected function _collectWhere1()
    {
        $where = '';
        $where = $this->_addWhereSpecial();
        
        if ($where)
            $where .= ' AND ';
            
        if ($this->_interlocutorId)
        {
            $str = '(
                    (topic.user = ?i AND topic.interlocutor = ?i AND topic.user = talk.user_id)
                    OR
                    (topic.user = ?i AND topic.interlocutor = ?i AND topic.user = talk.user_id)
                    )';
 //AND (talk.user_id = ?i OR talk.user_id = ?i)            
            $str = $this->_DB->makeSubstitution($str, array(
                                                            $this->_id, 
                                                            $this->_interlocutorId,
                                                            $this->_interlocutorId,
                                                            $this->_id
//                                                            $this->_id,                                                             
//                                                            $this->_interlocutorId
                                                            ));
            $where .= $str;
        }
        else 
            $where .= 'topic.user = ' . $this->_id;
        
        $where .= ' AND user.id = talk.user_id';
        
        
        $where .= ' AND topic.topic_id = ' . $this->_topicId;
        $where .= ' AND topic.topic_code = ' . $this->_topicCode;

        $where .= ' AND talk.topic_id = topic.topic_id';
        $where .= ' AND talk.topic_code = topic.topic_code';
        
        if ($where)
            $where = ' WHERE ' . $where;
        return $where;
    }    
    
}