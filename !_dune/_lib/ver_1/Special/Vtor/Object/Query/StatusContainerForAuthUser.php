<?php
/**
 * 
 * Данные о добавляемом объекте.
 * 
 */
class Special_Vtor_Object_Query_StatusContainerForAuthUser
{
    protected $DB;
    protected $_id;
    protected $_userId = 0;
    protected $_type = 0;

    protected $_time;
    protected $_status;
    protected $_result_id;
    
    protected $_step = 1;
    
    protected $_objectNotFinished = null;
    
    public static $_filesFolder = '/input/object/';
    
    protected $_data  = array();
    protected $_words = array();
    
    protected $_dataToInsert      = array();
    protected $_infoArrayChachged = false;
    

    public static $tableQuery        = 'unity_catalogue_object_query_to_add';

    
    static private $instance = null;
    
    
    /**
    * Возвращает ссылку на объект
    *
    * @param integer $user_id
    * @return Special_Vtor_Object_Query_StatusContainerForAuthUser
    */
    static function getInstance($user_id = 0)
    {
        if (is_null(self::$instance))
        {
            self::$instance = new Special_Vtor_Object_Query_StatusContainerForAuthUser($user_id);
        }
        return self::$instance;
    }
    
	protected function __construct($user_id = 0)
	{
	    $this->_userId = $user_id;
	    $this->DB = Dune_MysqliSystem::getInstance();
	}
	
    
	public function setStep($value)
	{
	    $this->_step = $value;
	}
	
	public function setUserId($value)
	{
	    $this->_user_id = $value;
	}
	
	/**
	 * Проверка на существование заявки, внесенной, но не зафиксированной.
	 * 
	 * @return Special_Vtor_Object_Query_Data
	 */
	public function getNotFinished()
	{
	    if (is_null($this->_objectNotFinished))
	    {
    	    $object = new Special_Vtor_Object_Query_Data();
    	    $object->setUserId($this->_userId);
    	    if ($object->checkNotFinished())
    	       return $this->_objectNotFinished = $object;
    	    else 
    	       return $this->_objectNotFinished = false;
	    }
	    else 
	       return $this->_objectNotFinished;
	}
	
	/**
	 * Выборка момента времени внесения предыдущего объекта.
	 *
	 * @return string
	 */
	public function getLastObjectInsertTime()
	{
	    if (!$this->_user_id)
	    {
	        throw new Dune_Exception_Base('Не указан идентификатор пользователя.');
	    }
	    $q = 'SELECT UNIX_TIMESTAMP(time) FROM ?t WHERE user_id = ?i ORDER BY id DESC';
        return $this->DB->query($q, array(
                                          self::$tableQuery,
                                          $this->_user_id,
                                          ), Dune_MysqliSystem::RESULT_EL);

	}

	/**
	 * Выборка колличества объектов в очереди на размещение.
	 *
	 * @return integer
	 */
	public function getCountObjectsInsertInQuery()
	{
	    if (!$this->_user_id)
	    {
	        throw new Dune_Exception_Base('Не указан идентификатор пользователя.');
	    }
	    $q = 'SELECT count(*) FROM ?t WHERE user_id = ?i AND status = 0';
        return $this->DB->query($q, array(
                                          self::$table,
                                          $this->_user_id,
                                          ), Dune_MysqliSystem::RESULT_EL);

	}
	
	

    
    
////////////////////////////////////////////////////////////////
///////////////////////////////     Защищенные методы
    
    
    protected function _getFromDb()
    {
        $good = false;
        $q = 'SELECT * FROM ?t WHERE id = ?i';
        $result = $this->DB->query($q, array(
                                          self::$table,
                                          $this->_id
                                          ), Dune_MysqliSystem::RESULT_ROWASSOC);
        if ($result !== false)
        {
            $this->_user_id = $result['user_id'];
            $this->_time = $result['time'];
            $this->_type = $result['type'];
            $this->_status = $result['status'];
            $this->_result_id = $result['result_id'];
            $this->_data = @unserialize($result['data']);
            if (!is_array($this->_data))
                $this->_data = array();
            else 
                $this->_dataToInsert = $this->_data;
            $good = true;
            $this->_words = @unserialize($result['words']);
            if (!is_array($this->_words))
                $this->_words = array();
            
        }
        return $good;
    }
    
    
////////////////////////////////////////////////////////////////
///////////////////////////////     Магические методы
    public function __set($name, $value)
    {
        $this->_infoArrayChachged = true;
        $this->_dataToInsert[$name] = $value;
    }
    
    public function __get($name)
    {
        if (isset($this->_data[$name]))
            return $this->_data[$name];
        else 
            return null;
    }
    public function __toString()
    {
    	$string = '<pre>';
    	ob_start();
    	print_r($this->_data);
    	$string .= ob_get_clean();
    	return  $string . '</pre>';
    }
/////////////////////////////
////////////////////////////////////////////////////////////////
   

}