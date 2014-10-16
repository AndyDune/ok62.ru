<?php
/**
 * 
 *
 * 
 */
class Special_Vtor_Object_User_Save
{
    protected $DB;
    protected $_id;
   
    public static $table = 'unity_catalogue_object_user_saved';
    
	public function __construct($id)
	{
	    $this->_id = $id;
	    $this->DB = Dune_MysqliSystem::getInstance();
	}
	
	public function isSavedBy($user_id)
	{
	    $q = 'SELECT count(*) FROM ?t WHERE `user_id` = ?i and `object_id` = ?i';
	    return $this->DB->query($q, array(self::$table, $user_id, $this->_id), Dune_MysqliSystem::RESULT_EL);
	}
	
	public function save($user_id)
	{
	    $q = 'REPLACE INTO ?t SET `user_id` = ?i, `object_id` = ?i, `time` = NOW()';
	    return $this->DB->query($q, array(self::$table, $user_id, $this->_id), Dune_MysqliSystem::RESULT_EL);
	}
	public function saveNo($user_id)
	{
	    $q = 'DELETE FROM ?t WHERE `user_id` = ?i and `object_id` = ?i LIMIT 1';
	    return $this->DB->query($q, array(self::$table, $user_id, $this->_id), Dune_MysqliSystem::RESULT_AR);
	}

	public function clear()
	{
	    $q = 'DELETE FROM ?t WHERE `object_id` = ?i';
	    return $this->DB->query($q, array(self::$table, $this->_id), Dune_MysqliSystem::RESULT_AR);
	}
	
}