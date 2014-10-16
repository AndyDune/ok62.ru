<?php
/**
 * 
 * Список данных об объекте.
 * 
 */
class Special_Vtor_Object_PublicTalkList
{
    protected $_DB = null;
    
    protected $_activity = null;
    protected $_id;
    protected $_data = false;
    
    protected $_orderString = '';
                        
    public static $table          = 'unity_catalogue_object_public_talk';
    public static $tableUser      = 'dune_auth_user_active';
    
    
	public function __construct($id)
	{
	    $this->_id = $id;
	    $this->_DB = Dune_MysqliSystem::getInstance();
	}

    public function setActivity($value = null)
    {
        $this->_activity = (int)$value;
    }	
    

/////////////////////////////////////////////////////////////////////////////////    
    
    /**
     * Число записей с внедренными условиями
     *
     * @return integer
     */
    public function count()
    {
        $q = 'SELECT count(*) FROM `' . self::$table . '` as talk' . $this->_collectWhere();
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
    public function getListCumulate($shift = 0, $limit = 100)
    {
        $where = $this->_collectWhere();
        if (!$where)
            $where = ' WHERE';
        else 
            $where .= ' AND';
        $where .= ' user.id = talk.user_id';
        
        
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
    
    
    protected function _addWhereSpecial()
    {
        return '';
    }

    protected function _setFromString()
    {
        $str = 
           ' `' .  self::$table . '` as talk,' 
           . ' `' . self::$tableUser . '` as user' 
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
        if (!is_null($this->_activity))
        {
            if ($where)
                $where .= ' and ';
            
            $where .= 'talk.activity = ' . $this->_activity;
        }
        if ($where)
            $where .= ' and ';
        $where .= 'talk.object_id = ' . $this->_id;
        if ($where)
            $where = ' WHERE ' . $where;
        return $where;
    }    
}