<?php
/**
 * 
 * Список конкурирующих.
 * 
 */
class Special_Vtor_Nearby_List_Streets
{
    protected $_DB = null;
    
    protected $_status = null;
    protected $_id;
    protected $_userId = 0;
    protected $_data = false;
    
    protected $_orderString = '';
                        
    public static $tableGroups    = 'unity_catalogue_object_builder_look_groups';
    public static $tableCorr      = 'unity_catalogue_object_builder_look_corr';
    public static $tableStreets   = 'unity_catalogue_adress_street';
    public static $tableObjects   = 'unity_catalogue_object';
    
    protected $_list = null;
    
	public function __construct($id)
	{
	    $this->_id = $id;
	    $this->_DB = Dune_MysqliSystem::getInstance();
	}

/////////////////////////////////////////////////////////////////////////////////    

    /**
     * Число улиц в группе.
     *
     * @return integer
     */
    public function count()
    {
        $q = 'SELECT count(*) 
              FROM ?t as corr, ?t as streets 
              WHERE streets.id = corr.street_id AND corr.group_id = ?i';
        return $this->_DB->query($q, array(self::$tableCorr, self::$tableStreets, $this->_id), Dune_MysqliSystem::RESULT_EL);
    }

    /**

    /**
     * Обновить .
     *
     * @return integer
     */
    public function getList()
    {
        if (!is_null($this->_list))
            return $this->_list;
        $q = 'SELECT streets.*
              FROM ?t as corr, ?t as streets 
              WHERE streets.id = corr.street_id AND corr.group_id = ?i
              ORDER BY streets.name';
        return $this->_list = $this->_DB->query($q, array(self::$tableCorr, self::$tableStreets, $this->_id), Dune_MysqliSystem::RESULT_IASSOC);
    }

    /**
     * Улицы с числом объектов.
     *
     * @return integer
     */
    public function getListCumulate($exception_saler = null, $type = null)
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
        
        $type = '';
        if (!is_null($type) and $type > 0)
        {
            $type = ' AND ojects.type = ' . (int)$type;
        }
        
        if (!is_null($this->_list))
            return $this->_list;
        $q = 'SELECT streets.*, count(objects.id) as count
              FROM ?t as corr, ?t as streets LEFT JOIN ?t as objects ON objects.street_id = streets.id
              WHERE streets.id = corr.street_id 
                    AND
                    corr.group_id = ?i
                    AND 
                    objects.activity = 1
                    ?p
                    ?p
              GROUP BY streets.id
              ORDER BY streets.name
              ';
        return $this->_list = $this->_DB->query($q, array(
                                                          self::$tableCorr,
                                                          self::$tableStreets,
                                                          self::$tableObjects,
                                                          $this->_id,
                                                          $not_in,
                                                          $type
                                                          ), Dune_MysqliSystem::RESULT_IASSOC);
    }
    
    public function addStreet($id)
    {
        $q = 'REPLACE
              INTO ?t
              SET street_id = ?i,
                  group_id = ?i';
        return $this->_DB->query($q, array(self::$tableCorr, $id, $this->_id), Dune_MysqliSystem::RESULT_AR);
    }    

    public function deleteStreet($id)
    {
        $q = 'DELETE
              FROM ?t
              WHERE street_id = ?i
                    AND
                    group_id = ?i';
        return $this->_DB->query($q, array(self::$tableCorr, $id, $this->_id), Dune_MysqliSystem::RESULT_AR);
    }    

    public function delete($id)
    {
        $q = 'DELETE
              FROM ?t
              WHERE group_id = ?i';
        return $this->_DB->query($q, array(self::$tableCorr, $this->_id), Dune_MysqliSystem::RESULT_AR);
    }    
    
    
    public function checkStreet($id)
    {
        $result = false;
        if (is_null($this->_list))
            $this->getList();
        if ($this->_list and count($this->_list) > 0)
        {
            foreach ($this->_list as $value)
            {
                if ($id == $value['id'])
                {
                    $result = true;
                    break;
                }
            }
        }
        return $result;
    }    


    public function getIdArray()
    {
        $result = array();
        if (is_null($this->_list))
            $this->getList();
        if ($this->_list and count($this->_list) > 0)
        {
            foreach ($this->_list as $value)
            {
                    $result[] = $value['id'];
            }
        }
        return $result;
    }    
    
    
    /**
     *
     * @param integer $shift сдвиг
     * @param integer $limit колличество записей для выборки
     * @return Dune_Mysqli_Iterator_ResultAssoc
     */
    public function getCount()
    {
        return $this->count();
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