<?php
/**
 * 
 *
 * 
 */
class Special_Vtor_User_Object_List extends Special_Vtor_Object_List
{
    protected $_userId;
   
    public static $table = 'dune_auth_user_active';
    
	public function __construct($user_id)
	{
	    $this->_userId = $user_id;
	    $this->DB = Dune_MysqliSystem::getInstance();
	}
	

	protected function _addWhereSpecial()
    {
        return ' `objects`.`saler_id` = `user`.`id` AND `user`.`id` = ' . $this->_userId;
    }
	
  /**
     * Число записей с внедренными условиями
     *
     * @return integer
     */
  /*
    public function count()
    {
        $q = 'SELECT count(DISTINCT objects.id) FROM ?t as objects, ?t as user ' . $this->_collectWhere();
        return $this->DB->query($q, array(self::$tableObject, self::$table), Dune_MysqliSystem::RESULT_EL);
    }
*/    
    protected function _setFromString()
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
           
           . ' `' . self::$table . '` as `user`' 
           ;
        return $str;
    }
    
}