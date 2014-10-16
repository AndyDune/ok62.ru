<?php
/**
 * 
 *
 * 
 */
class Special_Vtor_User_Object_Save extends Special_Vtor_Object_List
{
    protected $_userId;
   
    public static $table = 'unity_catalogue_object_user_saved';
    
	public function __construct($user_id)
	{
	    $this->_userId = $user_id;
	    $this->DB = Dune_MysqliSystem::getInstance();
	}
	
	public function isSavedOne($object_id)
	{
	    $q = 'SELECT count(*) FROM ?t WHERE `object_id` = ?i and `user_id` = ?i';
	    return $this->DB->query($q, array(self::$table, $object_id, $this->_userId), Dune_MysqliSystem::RESULT_EL);
	}
	
	public function isSavedAny()
	{
	    $q = 'SELECT count(*) FROM ?t WHERE `user_id` = ?i';
	    return $this->DB->query($q, array(self::$table, $this->_userId), Dune_MysqliSystem::RESULT_EL);
	}

	public function save($object_id)
	{
	    $q = 'REPLACE INTO ?t SET `object_id` = ?i, `user_id` = ?i, `time` = NOW()';
	    return $this->DB->query($q, array(self::$table, $object_id, $this->_userId), Dune_MysqliSystem::RESULT_EL);
	}
	public function saveNo($object_id)
	{
	    $q = 'DELETE FROM ?t WHERE `object_id` = ?i and `user_id` = ?i LIMIT 1';
	    return $this->DB->query($q, array(self::$table, $object_id, $this->_userId), Dune_MysqliSystem::RESULT_AR);
	}

	public function clear()
	{
	    $q = 'DELETE FROM ?t WHERE `user_id` = ?i';
	    return $this->DB->query($q, array(self::$table, $this->_userId), Dune_MysqliSystem::RESULT_AR);
	}

	public function getSavedIdArray()
	{
	    $q = 'SELECT object_id FROM ?t WHERE `user_id` = ?i';
	    return $this->DB->query($q, array(self::$table, $this->_userId), Dune_MysqliSystem::RESULT_EL);
	}
	
	public function count($ok62 = false)
	{
	    $q = 'SELECT count(*) FROM ?t WHERE `user_id` = ?i';
	    return $this->DB->query($q, array(self::$table, $this->_userId), Dune_MysqliSystem::RESULT_EL);
	}

	protected function _addWhereSpecial()
    {
        return ' `saved`.`object_id` = `objects`.`id` AND `saved`.`user_id` = ' . $this->_userId;
    }
	
    protected function _setFromString($add_join = false)
    {
        $str = 
           ' `' .  self::$tableObject . '` as objects,' 
           . ' `' . self::$tableObjectType . '` as type,' 
           . ' `' . self::$tableObjectTypeAdd . '` as type_add,' 
           
           . ' `' . self::$tableAdressRegion . '` as region,' 
           . ' `' . self::$tableAdressArea . '` as area,' 
           . ' `' . self::$tableAdressSettlement . '` as settlement,' 
           . ' `' . self::$tableAdressDistrict . '` as district,' 
           . ' `' . self::$tableAdressStreet . '` as street,' 
           
           . ' `' . self::$table . '` as saved' 
           ;
        return $str;
    }
    
}