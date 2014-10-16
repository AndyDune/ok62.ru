<?php
/**
 * 
 * Список данных об объекте.
 * 
 */
class Special_Vtor_Object_Types
{
    protected $DB;
    
    protected $_activity = null;
    protected $_type = null;
    protected $_id;
    
    protected $_user = 0;
    protected $_userText = '';
                        
    public static $tableObject          = 'unity_catalogue_object';
    public static $tableObjectType      = 'unity_catalogue_object_type';
    public static $tableObjectTypeAdd   = 'unity_catalogue_object_type_add';
    
	public function __construct($user = 0)
	{
	    $this->DB = Dune_MysqliSystem::getInstance();
	    if ($user)
	    {
	       $this->_user = $user;
	       $this->_userText = ' AND object.saler_id = ' . $user;
	    }
	       
	}
	
	public function getListType()
	{
	    $q = 'SELECT * FROM `' . self::$tableObjectType . '`';
	    return $this->DB->query($q, null, Dune_MysqliSystem::RESULT_IASSOC);
	}


	public function getListTypeWithObjectsFromAdress(Special_Vtor_Adress $object)
	{
	    $q = 'SELECT * FROM `' . self::$tableObjectType . '`';
	    return $this->DB->query($q, null, Dune_MysqliSystem::RESULT_IASSOC);
	}

	public function getListTypeWithObjects()
	{
	    $q = 'SELECT ?c, ?c, ?c, count(?c) as count  FROM ?t as type, ?t as object
	          WHERE type.id = object.type
	                AND
	                object
	          GROUP BY ?c';
	    return $this->DB->query($q, array(
	                                       array('type', 'id'),
	                                       array('type', 'name'),
	                                       array('type', 'code'),
	                                       array('object', 'id'),
	                                       self::$tableObjectType,
	                                       self::$tableObject,
	                                       array('type', 'id')
	                                      ),
	                                      Dune_MysqliSystem::RESULT_IASSOC);
	}
	
	
	public function getListTypeWithObjectsActive()
	{
	    $q = 'SELECT type.*, count(?c) as count  FROM ?t as type, ?t as object
	          WHERE type.id = object.type
	                AND
	                object.activity = 1 ' . $this->_userText . '
	          GROUP BY ?c';
	    return $this->DB->query($q, array(
	                                       array('object', 'id'),
	                                       self::$tableObjectType,
	                                       self::$tableObject,
	                                       array('type', 'id')
	                                      ),
	                                      Dune_MysqliSystem::RESULT_IASSOC);
	}
	
}