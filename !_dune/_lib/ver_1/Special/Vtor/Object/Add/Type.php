<?php
/**
 * 
 * Список данных об объекте.
 * 
 */
class Special_Vtor_Object_Add_Type
{
    protected $DB;
    
    protected $_activity = null;
    protected $_type = null;
    protected $_id = null;
                        
    public static $tableObject          = 'unity_catalogue_object';
    public static $tableObjectType      = 'unity_catalogue_object_type_add';
    
	public function __construct($type = null)
	{
	    $this->_id = $type;
	    $this->DB = Dune_MysqliSystem::getInstance();
	}
	
	public function getListType()
	{  
	    $q = 'SELECT * FROM `' . self::$tableObjectType . '` WHERE type_id = ' . (int)$this->_id;
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
	          WHERE type.id = object.type_add
	               AND type.type_id = ' . $this->_id . '
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
	
	
	public function getListTypeWithObjectsActive($no_default = true)
	{
	    if ($no_default)
            $q = 'SELECT type.*, count(?c) as count  FROM ?t as type, ?t as object
    	          WHERE type.id = object.type_add
    	                AND object.activity = 1
    	                AND type.type_id = ' . $this->_id . '

    	          GROUP BY ?c';
        else 
    	    $q = 'SELECT type.*, count(?c) as count  FROM ?t as type, ?t as object
    	          WHERE type.id = object.type_add
    	                AND
    	                object.activity = 1
    	                AND (type.type_id = ' . $this->_id . '
                             OR type.type_id < 2 
                            )
    	          GROUP BY ?c';
	    return $this->DB->query($q, array(
	                                       array('object', 'id'),
	                                       self::$tableObjectType,
	                                       self::$tableObject,
	                                       array('type', 'id')
	                                      ),
	                                      Dune_MysqliSystem::RESULT_IASSOC);
	}

	public function getListTypeWithObjectsActiveHave($object_type)
	{
            $q = 'SELECT type.*, count(?c) as count  FROM ?t as type, ?t as object
    	          WHERE type.id = object.type_add
    	                AND object.activity = 1
    	                AND type.id > 1
    	                AND object.type = ?i
    	          GROUP BY ?c';
	    $result = $this->DB->query($q, array(
	                                       array('object', 'id'),
	                                       self::$tableObjectType,
	                                       self::$tableObject,
	                                       $object_type,
	                                       array('type', 'id')
	                                      ),
	                                      Dune_MysqliSystem::RESULT_IASSOC);
/*	   echo $this->DB->getQuery();
	   echo '<br />';
	   echo count($result);
	   die();
*/
	   return $result;
	}
	
	
}