<?php
/**
 * 
 * Список данных об объекте.
 * 
 */
class Special_Vtor_PrivateTalk_ListTopics
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
    
	public function __construct($id)
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
     * Извлекаются данные и из сязанных таблиц (типы, подтипы).
     * Возвращает объект итеретор по результатам или false.
     *
     * @param integer $shift сдвиг
     * @param integer $limit колличество записей для выборки
     * @return Dune_Mysqli_Iterator_ResultAssoc
     */
    public function getListTopicsInCode($shift = 0, $limit = 100)
    {
        $where = $this->_collectWhere();
        
        
       $q = 'SELECT talk.topic_id as id,
                    MIN(talk.read) as read, 
                    MAX(talk.time) as time_write, 
                    MAX(talk.time_read) as time_read, 
                    COUNT(talk.topic_id) as count
             FROM '
           . $this->_setFromString()
           
           . $where
           . ' GROUP BY `talk`.`topic_id` '
           . $this->_orderString           
           . ' LIMIT ?i, ?i';

        $x =  $this->_DB->query($q, array($shift, $limit), Dune_MysqliSystem::RESULT_IASSOC);
        $array = array();
        if ($x)
        {
            $array = array();
            foreach ($x as $value)
            {
                $array[$value['id']] = $value;
            }
        }
        return $array;
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
    public function getListTopicsInCodeWriteByMe($shift = 0, $limit = 100)
    {
       $q = 'SELECT talk.topic_id as id,
                    MIN(talk.read) as `read`, 
                    MAX(UNIX_TIMESTAMP(talk.time)) as `time_write`, 
                    MAX(talk.time_read) as `time_read`, 
                    COUNT(*) as `count`
             FROM ?t as talk 
             WHERE
                    talk.user_id = ?i
                AND talk.interlocutor_id = ?i
                AND talk.topic_code = ?i
            GROUP BY `talk`.`topic_id` '
           . $this->_orderString           
           . ' LIMIT ?i, ?i';

        $x =  $this->_DB->query($q, array(
                                         self::$table,
                                         $this->_id, 
                                         $this->_interlocutorId,
                                         $this->_topicCode,
                                         $shift, 
                                         $limit), Dune_MysqliSystem::RESULT_IASSOC);
        $array = array();
        if ($x)
        {
            $array = array();
            foreach ($x as $key => $value)
            {
                $array[$value['id']] = $value;
                $array[$value['id']]['order'] = $value['time_write'];
            }
        }
        return $array;
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
    public function getListTopicsInCodeWriteByEnemy($shift = 0, $limit = 100)
    {
       $q = 'SELECT DISTINCT(talk.topic_id) as id,
                    MIN(talk.read) as `read`, 
                    MAX(UNIX_TIMESTAMP(talk.time)) as `time_write`, 
                    MAX(talk.time_read) as `time_read`, 
                    COUNT(*) as `count`
             FROM ?t as talk 
             WHERE
                    talk.user_id = ?i 
                AND talk.interlocutor_id = ?i
                AND talk.topic_code = ?i
            GROUP BY `talk`.`topic_id` 
            ORDER BY `talk`.`read`'
       //    . $this->_orderString           
           . ' LIMIT ?i, ?i';

        $x =  $this->_DB->query($q, array(
                                         self::$table,
                                         $this->_interlocutorId,
                                         $this->_id, 
                                         $this->_topicCode,
                                         $shift, 
                                         $limit), Dune_MysqliSystem::RESULT_IASSOC);
        $array = array();
        if ($x)
        {
            $array = array();
            foreach ($x as $key => $value)
            {
                $array[$value['id']] = $value;
                $array[$value['id']]['order'] = $value['time_write'];
            }
        }
        return $array;
    }
    
    
    
    protected function _addWhereSpecial()
    {
        return '';
    }

    protected function _setFromString()
    {
        $str = ' `' . self::$table . '` as talk' 
//             . ' `' . self::$tableList . '` as topic' 
            ;
           
        return $str;
    }
    
/////////////////////////////////////////////////////////////////////////////////    
///////     Метды установки порядка выборки


    /**
     * Добавление порядка выборки. Время внесения записи.
     *
     * @param string $order направление ADC или DESC
     */
    public function setOrder($field, $order = 'ADC')
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
     * @param string $order направление ADC или DESC
     */
    public function setOrderTime($order = 'ADC')
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
            throw new Dune_Exception_Base('Не указан собеседник.');
            
            
        $where .= ' AND talk.topic_code = ' . $this->_topicCode;
        if ($where)
            $where = ' WHERE ' . $where;
        return $where;
    }    
    
}