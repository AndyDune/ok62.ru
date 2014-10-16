<?php
/**
 * 
 * Список планировок.
 * 
 */
class Special_Vtor_Object_Condition
{
    protected $DB;
    
    protected $_activity = null;
    protected $_type = null;
    protected $_id;
                        
    public static $tableObject               = 'unity_catalogue_object';
    public static $tableObjectCondition      = 'unity_catalogue_object_condition';
    
	public function __construct()
	{
	    $this->DB = Dune_MysqliSystem::getInstance();
	}
	
	public function getList($type_id = null, $and_common = true)
	{
	    $q = 'SELECT * FROM `' . self::$tableObjectCondition . '`';
	    $where = '';
	    if (!is_null($type_id))
	       $where = ' type = ' . $type_id;
	    if ($and_common)
	    {
	        if ($where)
	           $where .= ' OR';
	        $where .= ' type = 0';
	    }
        if ($where)
           $where .= ' and';
        $where .= ' id != 0';
	    
	        if ($where)
	           $where = ' WHERE' . $where;
	    $q .= $where;
	    return $this->DB->query($q, null, Dune_MysqliSystem::RESULT_IASSOC);
	}
	
	public function getListWithObjects($type_id = null, $and_common = true, $no_default = true)
	{
	    $q = 'SELECT cond.*, count(object.id) FROM ?t as cond, ?t as object';
	    $where = '';
	    if (!is_null($type_id))
	       $where = ' cond.type = ' . $type_id;
	    if ($and_common)
	    {
	        if ($where)
	           $where .= ' OR';
	        $where .= ' cond.type = 0';
	    }
	    
	        if ($where)
	           $where = ' WHERE (' . $where . ') AND ';
	    $where .= ' object.condition = cond.id';
	    if ($no_default)
	       $where .= ' AND cond.id > 0';
	    $where .= ' AND object.activity = 1';
	    if (!is_null($type_id))
	       $where .= ' AND object.type = ' . (int)$type_id;
	       
	    $q .= $where . ' GROUP BY ?c';
	    
	    $q .= ' ORDER BY `cond`.`order`';

	    return $this->DB->query($q, array(
	                                       self::$tableObjectCondition,
	                                       self::$tableObject,
	                                       array('cond', 'id')
	                                      ), Dune_MysqliSystem::RESULT_IASSOC);
	}


}