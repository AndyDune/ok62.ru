<?php
/**
 * 
 *
 * 
 */
class Special_Vtor_User_Object_ListQuerySell
{
    protected $_userId;
    protected $_type = null;
    protected $_orderString = '';
    
    protected $_haveRedact = 0;
   
    public static $tableObject     = 'unity_catalogue_object_query_to_add';
    public static $tableObjectType = 'unity_catalogue_object_type';
    
	public function __construct($user_id)
	{
	    $this->_userId = $user_id;
	    $this->DB = Dune_MysqliSystem::getInstance();
	}
	

	
    public function getListCumulateTransform($shift = 0, $limit = 100)
    {
        $result = array();
        $where = $this->_collectWhere();
        
        $q = 'SELECT objects.*,
                     type.name as name_type,
                     type.code as name_type_code

             FROM '
           . $this->_setFromString()
           
           . $where
           . ' GROUP BY `objects`.`id` '
           . $this->_orderString           
           . ' LIMIT ?i, ?i';

        $list = $this->DB->query($q, array($shift, $limit), Dune_MysqliSystem::RESULT_IASSOC);
        if (count($list))
        {
            foreach ($list as $value)
            {
                $run_result = @unserialize($value['data']);
                if (!is_array($run_result))
                    $run_result = array();
                $run_result['id'] = $value['id'];
                $run_result['type'] = $value['type'];
                $run_result['time'] = $value['time'];
                
                $run_result['status'] = $value['status'];
                if ($run_result['status'] == 0)
                    $this->_haveRedact = $value['id'];
                $run_result['result_id'] = $value['result_id'];
                $run_result['mode'] = $value['mode'];
                $run_result['name_type'] = $value['name_type'];
                $run_result['name_type_code'] = $value['name_type_code'];

                $result[] = new Dune_Array_Container($run_result);
            }
        }
        return $result;
    }
	
    public function haveEdit()
    {
        return $this->_haveRedact;
    }
	
	public function count()
	{
	    $q = 'SELECT count(*) FROM ?t WHERE `user_id` = ?i';
	    return $this->DB->query($q, array(self::$tableObject, $this->_userId), Dune_MysqliSystem::RESULT_EL);
	}

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

	
	
    protected function _setFromString()
    {
        $str = 
           ' `' .  self::$tableObject . '` as objects,' 
           . ' `' . self::$tableObjectType . '` as type' 
           ;
        return $str;
    }
    
    
    
////////////////////////////////////////////////////////////////////////
////////////        Защищённые методы
    protected function _addWhereSpecial()
    {
        return '';
    }

    protected function _collectWhere()
    {
        $where = '';
        $where = $this->_addWhereSpecial();
        if (!is_null($this->_type))
        {
            if ($where)
                $where .= ' and ';
            $where .= ' objects.type = ' . $this->_type;
        }
        
        if ($where)
            $where .= ' and ';
        $where .= ' objects.user_id = ' . (int)$this->_userId;
        
        if ($where)
            $where = ' WHERE ' . $where;
            
        if (!$where)
            $where = ' WHERE';
        else 
            $where .= ' AND';
            
        $where .= ' type.id = objects.type';
            
        return $where;
    }        
    
}