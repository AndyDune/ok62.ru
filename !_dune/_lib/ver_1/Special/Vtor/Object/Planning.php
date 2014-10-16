<?php
/**
 * 
 * Список планировок.
 * 
 */
class Special_Vtor_Object_Planning
{
    protected $DB;
    
    protected $_activity = null;
    protected $_type = null;
    protected $_id;
                        
    public static $tableObject          = 'unity_catalogue_object';
    public static $tableObjectPlanning      = 'unity_catalogue_object_planning';
    public static $tableObjectTypeAdd   = 'unity_catalogue_object_type_add';
    
	public function __construct()
	{
	    $this->DB = Dune_MysqliSystem::getInstance();
	}
	
	public function getList()
	{
	    $where = '';
	    $q = 'SELECT * FROM `' . self::$tableObjectPlanning . '`';
        if ($where)
           $where .= ' and';
        $where .= ' id != 0';
	    
	    if ($where)
	       $where = ' WHERE' . $where;
	    $q .= $where;        
	    return $this->DB->query($q, null, Dune_MysqliSystem::RESULT_IASSOC);
	}


}