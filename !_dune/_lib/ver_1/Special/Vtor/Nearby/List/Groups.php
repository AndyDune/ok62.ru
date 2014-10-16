<?php
/**
 * 
 * Список конкурирующих.
 * 
 */
class Special_Vtor_Nearby_List_Groups
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
    public function countGroups()
    {
        $q = 'SELECT count(*) FROM ?t';
        return $this->_DB->query($q, array(self::$tableGroups), Dune_MysqliSystem::RESULT_EL);
    }

    /**
     * Обновить .
     *
     * @return integer
     */
    public function updateCountField($id, $exception_saler = null)
    {
        $not_in = '';
        if ($exception_saler and is_array($exception_saler))
        {
            foreach ($exception_saler as $value) 
            {
                if ($not_in)
                    $not_in .= ', ';
                $not_in .= $value;
            }
            if ($not_in)
                $not_in = ' AND objects.saler_id NOT IN (' . $not_in . ') ';
        }
        $q = 'UPDATE ?t
              SET `count` = (
                             SELECT count(DISTINCT objects.id) 
                             FROM ?t as objects, ?t as corr
                             WHERE objects.street_id = corr.street_id 
                                   ?p
                                   AND 
                                   corr.group_id = ?i  
                                   AND 
                                   objects.activity = 1  
                           )
               WHERE id = ?i';
        $this->_DB->query($q, array(
                                            self::$tableGroups,
                                            self::$tableObjects,
                                            self::$tableCorr,
                                            $not_in,
                                            $id,
                                            $id
                                            ), Dune_MysqliSystem::RESULT_AR);
                                            
        $q = 'SELECT count FROM ?t WHERE id = ?i';
        return $this->_DB->query($q, array(self::$tableGroups, $id), Dune_MysqliSystem::RESULT_EL);
                                            
    }

    /**
     * Обновить .
     *
     * @return integer
     */
    public function getCountForOne($id)
    {
        $q = 'SELECT count(DISTINCT objects.id) 
              FROM ?t as objects, ?t as corr
              WHERE objects.street_id = corr.street_id 
                    AND
                    corr.group_id = ?i';
        return $this->_DB->query($q, array(
                                            self::$tableObjects,
                                            self::$tableCorr,
                                            $id
                                            ), Dune_MysqliSystem::RESULT_EL);
    }
    
    
    /**
     * Список наблюдаемых
     * 
     * @param integer $shift сдвиг
     * @param integer $limit колличество записей для выборки
     * @return Dune_Mysqli_Iterator_ResultAssoc
     */
    public function getListGroups($shift = 0, $limit = 100)
    {
        
        $q = 'SELECT *, UNIX_TIMESTAMP(time_update) as time_update_unix
              FROM ?t as `groups` 
              ?p
              LIMIT ?i, ?i';
        return $this->_DB->query($q, array(
                                           self::$tableGroups,
                                           $this->_orderString,
                                           $shift,
                                           $limit
                                           ), Dune_MysqliSystem::RESULT_IASSOC);
    }
    
    /**
     *
     * @param integer $shift сдвиг
     * @param integer $limit колличество записей для выборки
     * @return Dune_Mysqli_Iterator_ResultAssoc
     */
    public function getList($shift = 0, $limit = 100)
    {
        return $this->getListGroups($shift, $limit);
    }
    
    /**
     *
     * @param integer $shift сдвиг
     * @param integer $limit колличество записей для выборки
     * @return Dune_Mysqli_Iterator_ResultAssoc
     */
    public function getCount()
    {
        $q = 'SELECT count(*) FROM ?t';
             
        return $this->_DB->query($q, array(self::$tableGroups,
                                           ), Dune_MysqliSystem::RESULT_EL);
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

   
}