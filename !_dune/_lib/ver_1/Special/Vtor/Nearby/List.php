<?php
/**
 * 
 * Список конкурирующих.
 * 
 */
class Special_Vtor_User_Nearby_List_Groups
{
    protected $_DB = null;
    
    protected $_status = null;
    protected $_id;
    protected $_userId = 0;
    protected $_data = false;
    
    protected $_orderString = '';
                        
    public static $tableGroups    = 'unity_catalogue_object_builder_look_groups';
    public static $tableCorr      = 'unity_catalogue_object_builder_look_corr';
    public static $tableObjects   = 'unity_catalogue_object';
    
    
	public function __construct($id = null)
	{
	    $this->_id = $id;
	    $this->_DB = Dune_MysqliSystem::getInstance();
	}


/////////////////////////////////////////////////////////////////////////////////    

    /**
     * Число всего группей.
     *
     * @return integer
     */
    public function countTotalGroups()
    {
        $q = 'SELECT count(*) FROM ?t';
        return $this->_DB->query($q, array(self::$tableGroups), Dune_MysqliSystem::RESULT_EL);
    }

    
    /**
     * Список записей из таблицы с ранее указанными параметрами.
     * Возвращает объект итеретор по результатам или false.
     *
     * @param integer $shift сдвиг
     * @param integer $limit колличество записей для выборки
     * @return Dune_Mysqli_Iterator_ResultAssoc
     */
    public function getListGroups($shift = 0, $limit = 100)
    {
        
        $q = 'SELECT *
              FROM ?t as `groups` ' 
           . $this->_orderString           
           . ' LIMIT ?i, ?i';
        return $this->_DB->query($q, array(
                                           self::$tableGroups,
                                           $shift,
                                           $limit
                                           ), Dune_MysqliSystem::RESULT_IASSOC);
    }

    /**
     * Список записей из таблицы с ранее указанными параметрами.
     * Возвращает объект итеретор по результатам или false.
     *
     * @return integer
     */
    public function getCountContactHave()
    {
        $where = $this->_collectWhere();
        if (!$where)
            $where = ' WHERE ';
        else 
            $where = ' AND ';
        
        $q = 'SELECT count(user.*) FROM ?t as user, ?t as text' 
           . $where
           . ' `user`.`id` = `text`.`user_id`'
           . ' AND `text`.`interlocutor_id` = ?i'
           . ' AND `user`.`id` != ?i'
           . ' GROUP BY `user`.`id`';
        return $this->_DB->query($q, array(self::$tableUser,
                                           self::$tableText,
                                           $this->_userId,
                                           $this->_userId
                                           ), Dune_MysqliSystem::RESULT_EL);
    }
    
    
    
    
    /**
     * Список записей из таблицы с ранее указанными параметрами.
     * Возвращает объект итеретор по результатам или false.
     *
     * @param integer $shift сдвиг
     * @param integer $limit колличество записей для выборки
     * @return Dune_Mysqli_Iterator_ResultAssoc
     */
    public function getListContactBegin($shift = 0, $limit = 100, $array_exept = null)
    {
        $where = $this->_collectWhere();
        if (!$where)
            $where = ' WHERE ';
        else 
            $where .= ' AND ';
        
        if (!is_null($array_exept) and is_array($array_exept) and count($array_exept))
        {
            $where .= ' `user`.`id` NOT IN (' . implode(', ', $array_exept) . ') AND ';
        }
            
        $q = 'SELECT user.*, MIN(text.read) as talk_read,
                     MIN(text.time) as talk_time,
                     MAX(text.time_read) as talk_time_read
              FROM ?t as user, ?t as text' 
           . $where
           
           . ' `user`.`id` = `text`.`interlocutor_id`'
           . ' AND `text`.`user_id` = ?i'
           . ' GROUP BY `user`.`id`' 
           . $this->_orderString           
           . ' LIMIT ?i, ?i';
        return $this->_DB->query($q, array(self::$tableUser,
                                           self::$tableText,
                                           $this->_userId,
                                           $shift,
                                           $limit), Dune_MysqliSystem::RESULT_IASSOC);
    }

    /**
     * Список записей из таблицы с ранее указанными параметрами.
     * Возвращает объект итеретор по результатам или false.
     *
     * @return integer
     */
    public function getCountContactBegin($array_exept = null)
    {
        $where = $this->_collectWhere();
        if (!$where)
            $where = ' WHERE ';
        else 
            $where = ' AND ';
            
        
        if (!is_null($array_exept) and is_array($array_exept))
        {
            $where .= ' `user`.`id` NOT IN (' . implode(', ', $array_exept) . ') AND ';
        }
            
            
        $q = 'SELECT count(user.*) FROM ?t as user, ?t as text' 
           . $where
           . ' `user`.`id` = `text`.`interlocutor_id`'
           . ' AND `text`.`user_id` = ?i'
           . ' GROUP BY `user`.`id`';
        return $this->_DB->query($q, array(self::$tableUser,
                                           self::$tableText,
                                           $this->_userId,
                                           ), Dune_MysqliSystem::RESULT_EL);
    }
    
    
    
    /**
     *
     * @param integer $shift сдвиг
     * @param integer $limit колличество записей для выборки
     * @return Dune_Mysqli_Iterator_ResultAssoc
     */
    public function getList($shift = 0, $limit = 100)
    {
        $where = $this->_collectWhere();
        
        $q = 'SELECT user.* FROM ?t as user'
           . $where
           . $this->_orderString
           . ' LIMIT ?i, ?i';
        return $this->_DB->query($q, array(self::$tableUser,
                                           $shift,
                                           $limit), Dune_MysqliSystem::RESULT_IASSOC);
    }
    
    /**
     *
     * @param integer $shift сдвиг
     * @param integer $limit колличество записей для выборки
     * @return Dune_Mysqli_Iterator_ResultAssoc
     */
    public function getListWithTime($shift = 0, $limit = 100)
    {
        $where = $this->_collectWhere();
        if ($where)
            $where .= ' AND ';
        else 
            $where = ' WHERE ';
        
        $q = 'SELECT user.*,
                     UNIX_TIMESTAMP(`time`.`last_visit`) as `last_visit`
              FROM ?t as user, ?t as `time`'
           . $where
           . ' user.id = time.id '
           . $this->_orderString
           . ' LIMIT ?i, ?i';
        return $this->_DB->query($q, array(self::$tableUser,
                                           self::$tableTime,
                                           $shift,
                                           $limit), Dune_MysqliSystem::RESULT_IASSOC);
    }
    
    
    /**
     *
     * @param integer $shift сдвиг
     * @param integer $limit колличество записей для выборки
     * @return Dune_Mysqli_Iterator_ResultAssoc
     */
    public function getCount()
    {
        $where = $this->_collectWhere();
        
        $q = 'SELECT count(*) FROM ?t as user'
             . $where;
             
        return $this->_DB->query($q, array(self::$tableUser,
                                           ), Dune_MysqliSystem::RESULT_EL);
    }
    
    
    protected function _addWhereSpecial()
    {
        return '';
    }

    protected function _setFromString()
    {
        $str = ' `' . self::$tableUser . '` as user,' 
             . ' `' . self::$tableText . '` as text' 
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
    public function setOrder($field, $order = '', $table = 'groups')
    {
        if (!$this->_orderString)
            $this->_orderString = ' ORDER BY ';
        else 
            $this->_orderString .= ', ';
        $this->_orderString .= '`' . $table . '`.`' . $field . '` ' . $order;
    }

    
    /**
     * Добавление порядка выборки. Время изменения записи.
     *
     * @param string $order направление ADC или DESC
     */
    public function setOrderTime($order = '')
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
            $where = ' WHERE ' . $where;
        return $where;
    }    
    
   
}