<?php
/**
 * 
 * 
 * 
 */
class Special_Vtor_DrawPlan
{
    /**
     * Объект надстройка над mysqli
     *
     * @var Dune_MysqliSystem
     */
    protected $DB;
    
    protected $_user = null;
    protected $_id = null;
    
    protected $_sellerException = array();
    
    protected $_data = false;
    
    protected $_orderString = '';
                        
    public static $tableDraw       = 'unity_draw_plan';
    
    
    public static $tableUser       = 'dune_auth_user_active';
    public static $tableUserTime   = 'dune_auth_user_time';
    
    
	public function __construct($value = null)
	{
	    $this->DB = Dune_MysqliSystem::getInstance();
	}

	public function setUserId($id)
	{
	    $this->_user = $id;
	    return $this;
	}
	
	public function setDrawId($id)
	{
	    $this->_id = $id;
	    return $this;
	}
	
	public function getOneOfUser($id = null)
	{
	    if (is_null($id))
	    {
	       $q = 'SELECT * FROM ?t WHERE user_id = ?i LIMIT 1';
	       $array = array(self::$tableDraw, $this->_user);
	    }
	    else 
	    {
	       $q = 'SELECT * FROM ?t WHERE user_id = ?i AND id = ?i LIMIT 1';
	       $array = array(self::$tableDraw, $this->_user, $id);
	    }
	    return $this->DB->query($q, $array, Dune_MysqliSystem::RESULT_ROWASSOC);
	}

	/**
	 * Выбрать из базы одну картинку.
	 *
	 * @param integer $id
	 * @return mixed
	 */
	public function getOne($id = null)
	{
	    $q = 'SELECT * FROM ?t WHERE id = ?i LIMIT 1';
        $array = array(self::$tableDraw, $id);
	    return $this->DB->query($q, $array, Dune_MysqliSystem::RESULT_ROWASSOC);
	}

	/**
	 * Выбрать из базы одну картинку с информацией о художнике.
	 *
	 * @param integer $id
	 * @return mixed
	 */
	public function getOneWithUser($id = null)
	{
	    $q = 'SELECT `draw`.*, `user`.`name`, `user`.`contact_name` FROM ?t as draw, ?t as user WHERE `draw`.id = ?i AND `draw`.user_id = `user`.`id`  LIMIT 1';
        $array = array(self::$tableDraw, self::$tableUser, $id);
	    return $this->DB->query($q, $array, Dune_MysqliSystem::RESULT_ROWASSOC);
	}
	
	
	public function saveXML($value = '')
	{
	   $q = 'UPDATE ?t SET `xml` = ? WHERE id = ?i LIMIT 1';   
	   return $this->DB->query($q, array(self::$tableDraw, $value, $this->_id), Dune_MysqliSystem::RESULT_AR);
	}

	public function saveFile($value = '')
	{
	   $q = 'UPDATE ?t SET `file` = ? WHERE `id` = ?i LIMIT 1';   
	   $this->DB->query($q, array(self::$tableDraw, $value, $this->_id), Dune_MysqliSystem::RESULT_AR);
	   return $this->DB->getQuery();
	}

	public function savePublic($value = 0)
	{
	   $q = 'UPDATE ?t SET `public` = ?i WHERE `id` = ?i LIMIT 1';   
	   $this->DB->query($q, array(self::$tableDraw, $value, $this->_id), Dune_MysqliSystem::RESULT_AR);
	   return $this->DB->getQuery();
	}
	
	
	public function addWithXML($value = '')
	{
	   $q = 'INSERT INTO ?t SET `xml` = ?, user_id = ?i, `time` = NOW()';   
	   return $this->DB->query($q, array(self::$tableDraw, $value, $this->_user), Dune_MysqliSystem::RESULT_ID);
	}
	
	public function addOne()
	{
	   $q = 'INSERT INTO ?t SET user_id = ?i, `time` = NOW() LIMIT 1';   
	   return $this->DB->query($q, array(self::$tableDraw, $this->_user), Dune_MysqliSystem::RESULT_ID);
	    
	}

}