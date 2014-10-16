<?php
/**
 * 
 * Список данных об объекте.
 * 
 */
class Special_Vtor_Object_Add_MaterialWall
{
    protected $DB;
    
    protected $_activity = null;
    protected $_type = null;
    protected $_id = null;
                        
    public static $tableObject          = 'unity_catalogue_object';
    public static $tableObjectWall      = 'unity_catalogue_object_material_wall';
    
	public function __construct()
	{
	    $this->DB = Dune_MysqliSystem::getInstance();
	}
	
	public function getList()
	{  
	    $q = 'SELECT * FROM `' . self::$tableObjectWall .'` WHERE `id` > 1';
	    return $this->DB->query($q, null, Dune_MysqliSystem::RESULT_IASSOC);
	}


	public function getListTypeWithObjectsFromAdress(Special_Vtor_Adress $object)
	{
	    $q = 'SELECT * FROM `' . self::$tableObjectWall . '`';
	    return $this->DB->query($q, null, Dune_MysqliSystem::RESULT_IASSOC);
	}

	public function getListTypeWithObjects($type)
	{
	    $q = 'SELECT ?c, ?c, ?c, count(?c) as count  FROM ?t as wall, ?t as object
	          WHERE wall.id = object.type_wall
	               AND object.type = ' . (int)$type . '
	          GROUP BY ?c';
	    return $this->DB->query($q, array(
	                                       array('wall', 'id'),
	                                       array('wall', 'name'),
	                                       array('wall', 'code'),
	                                       array('object', 'id'),
	                                       self::$tableObjectWall,
	                                       self::$tableObject,
	                                       array('wall', 'id')
	                                      ),
	                                      Dune_MysqliSystem::RESULT_IASSOC);
	}
	
	
	public function getListTypeWithObjectsActive($type, $no_default = true)
	{
	    if ($no_default)
            $q = 'SELECT wall.*, count(?c) as count  FROM ?t as wall, ?t as object
    	          WHERE wall.id = object.type_wall
    	                AND object.activity = 1
    	                AND wall.type_id = ' . $type . '

    	          GROUP BY ?c';
        else 
    	    $q = 'SELECT wall.*, count(?c) as count  FROM ?t as wall, ?t as object
    	          WHERE wall.id = object.type_wall
    	                AND
    	                object.activity = 1
    	                AND (wall.type_id = ' . $type . '
                             OR wall.type_id < 2 
                            )
    	          GROUP BY ?c';
	    return $this->DB->query($q, array(
	                                       array('object', 'id'),
	                                       self::$tableObjectWall,
	                                       self::$tableObject,
	                                       array('wall', 'id')
	                                      ),
	                                      Dune_MysqliSystem::RESULT_IASSOC);
	}

	public function getListTypeWithObjectsActiveHave($object_type)
	{
            $q = 'SELECT wall.*, count(?c) as count  FROM ?t as wall, ?t as object
    	          WHERE wall.id = object.type_wall
    	                AND object.activity = 1
    	                AND wall.id > 1
    	                AND object.type = ?i
    	          GROUP BY ?c';
	    return $this->DB->query($q, array(
	                                       array('object', 'id'),
	                                       self::$tableObjectWall,
	                                       self::$tableObject,
	                                       $object_type,
	                                       array('wall', 'id')
	                                      ),
	                                      Dune_MysqliSystem::RESULT_IASSOC);
	}
	
	
}