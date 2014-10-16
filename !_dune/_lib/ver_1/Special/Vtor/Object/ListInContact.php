<?php
/**
 * 
 * Список данных об объекте.
 * 
 */
class Special_Vtor_Object_ListInContact
{
                        
    public static $tableText          = 'unity_private_talk_topic_text';
    
    
	public function __construct($id = null)
	{
	    $this->_id = $id;
	    $this->DB = Dune_MysqliSystem::getInstance();
	}


/////////////////////////////////////////////////////////////////////////////////    
    
    
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
        
        $q = 'SELECT objects.*,
                     type.name as name_type,
                     type_add.name as name_type_add,
                     
  	                 region.name     as name_region,
   	                 area.name       as name_area,
   	                 settlement.name as name_settlement,
   	                 settlement.type as type_settlement,
   	                 district.name   as name_district,
   	                 street.name     as name_street

             FROM '
           . $this->_setFromString()
           
           . $where
           . ' GROUP BY `objects`.`id` '
           . $this->_orderString           
           . ' LIMIT ?i, ?i';

        return $this->DB->query($q, array($shift, $limit), Dune_MysqliSystem::RESULT_IASSOC);
    }
    
    
    protected function _addWhereSpecial()
    {
        return '';
    }

    protected function _setFromStringSpecial()
    {
        return ' `' .  self::$tableText . '` as text';
    }
    
/////////////////////////////////////////////////////////////////////////////////    
///////     Метды установки порядка выборки


    /**
     * Добавление порядка выборки. Время внесения записи.
     *
     * @param string $order направление ADC или DESC
     */
    public function setOrder($field, $order = '', $table = 'objects')
    {
        if (!$this->_orderString)
            $this->_orderString = ' ORDER BY ';
        else 
            $this->_orderString .= ', ';
        $this->_orderString .=  $table. '.' . $field . ' ' . $order;
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
            if (is_array($this->_activity) and count($this->_activity) > 0)
            {
                $where .= 'objects.activity IN (' . implode(',', $this->_activity) .')';
            }
        }
        if (!is_null($this->_type))
        {
            if ($where)
                $where .= ' and ';
            $where .= ' objects.type = ' . $this->_type;
        }
        
        if ($this->_seller)
        {
            if ($where)
                $where .= ' and ';
            $where .= ' objects.saler_id = ' . (int)$this->_seller;
        }
        
        foreach ($this->_adressArray as $key => $value)
        {
            if (!is_null($value))
            {
                if ($where)
                    $where .= ' and';
                if ($key == 'building_number')
                    $where .= ' objects.`' . $key . '` = ' . $this->DB->real_escape_string($value);
                else 
                    $where .= ' objects.`' . $key . '` = ' . (int)$value;
            }
        }
        if ($where)
            $where = ' WHERE ' . $where;
            
        if (!$where)
            $where = ' WHERE';
        else 
            $where .= ' AND';
            
        $where .= ' type.id = objects.type';
        $where .= ' AND type_add.id = objects.type_add';
        
        $where .= ' AND objects.region_id = region.id';
        $where .= ' AND objects.area_id   = area.id';
        $where .= ' AND objects.settlement_id   = settlement.id';
        $where .= ' AND objects.street_id   = street.id';
        $where .= ' AND objects.district_id   = district.id';
            
        return $where;
    }    
}