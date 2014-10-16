<?php
/**
 * 
 * Данные о добавляемом объекте.
 * 
 */
class Special_Vtor_Object_Query_AuthNo_DataSingleton extends Special_Vtor_Object_Query_Abstract_Data
{
    
   /**
    * Иниц. при первом вызове стат. метода и возвращается при последующих
    *
    * @var Special_Vtor_Object_Query_AuthNo_DataSingleton
    * @access private
    */
    static private $instance = NULL;
    
  /**
   * Создаёт реализацию класса при первом вызове
   * Возвращает сохранённый указатель объекта при последующих вызовах
   *
   * Вызывает указаталь на объект с системными параметрами
   * 
   * @return Special_Vtor_Object_Query_AuthNo_DataSingleton
   */
    static public function getInstance($id = 0)
    {
        if (self::$instance == NULL)
        {
            self::$instance = new Special_Vtor_Object_Query_AuthNo_DataSingleton($id);
        }
        return self::$instance;
    }

    public static $table          = 'unity_catalogue_object_query_to_add_na';
    
	protected function __construct($id = 0)
	{
	    $this->DB = Dune_MysqliSystem::getInstance();
	    $this->_id = $id;
	    if ($id)
	    {
	        $this->_haveSaved = $this->_getFromDb();
	    }
	}

    
	public function delete()
	{
	    if ($this->_haveSaved)
	    {
	        $q = 'DELETE FROM ?t WHERE id = ?';
            return $this->DB->query($q, array(
                                              self::$table,
                                              $this->_id,
                                              ), Dune_MysqliSystem::RESULT_AR);
	        
	    }
	}
	
	
	public function useIdGetDataFromDb($id)
	{
	   $this->_id = $id;
	   return $this->_haveSaved = $this->_getFromDb();
	}
	
	public function setUserId($value)
	{
	    $this->_user_id = $value;
	}
	
	public function checkNotFinished()
	{
	    if (!$this->_user_id)
	       throw new Dune_Exception_Base('Не определен пользователь.');
	    return $this->_getFromDbNotFinished();
	}

	public function loadData($array)
	{
	    $this->_dataToInsert = $array;
	    $this->_infoArrayChachged = true;
	}
	
	public function getData($in_container = false)
	{
	    if ($in_container)
	       return new Dune_Array_Container($this->_data);
	    return $this->_data;
	}
	
	public function setResultId($value)
	{
	    $this->_infoArrayChachged = true;
	    $this->_result_id = $value;
	}
	
	public function setStatus($value)
	{
	    $this->_infoArrayChachged = true;
	    $this->_status = $value;
	}
	
	public function getStatus()
	{
	    return $this->_status;
	}

	public function getUserId()
	{
	    return $this->_id;
	}
	
	/**
	 * Добавить комметрарий в массив комментраиев
	 *
	 * @param string $value
	 */
	public function addWords($value)
	{
	    $this->_infoArrayChachged = true;
	    $this->_words[] = htmlspecialchars($value);
	}

	/**
	 * Выборка всего массива коментариев.
	 *
	 * @return string
	 */
	public function getWords()
	{
	    return $this->_words;
	}
	
	/**
	 * Выборка момента времени внесения предыдущего объекта.
	 *
	 * @return string
	 */
	public function getLastObjectInsertTime()
	{
	    if (!$this->_id)
	    {
	        throw new Dune_Exception_Base('Не указан идентификатор пользователя.');
	    }
	    $q = 'SELECT UNIX_TIMESTAMP(time) FROM ?t WHERE id = ? ORDER BY id DESC';
        return $this->DB->query($q, array(
                                          self::$table,
                                          $this->_id,
                                          ), Dune_MysqliSystem::RESULT_EL);

	}

	/**
	 * Выборка колличества объектов в очереди на размещение.
	 *
	 * @return integer
	 */
	public function getCountObjectsInsertInQuery()
	{
	    if (!$this->_id)
	    {
	        throw new Dune_Exception_Base('Не указан идентификатор пользователя.');
	    }
	    $q = 'SELECT count(*) FROM ?t WHERE id = ? AND status IN (0,1)';
        return $this->DB->query($q, array(
                                          self::$table,
                                          $this->_id,
                                          ), Dune_MysqliSystem::RESULT_EL);

	}
	
	
    public function add($is_load_result = false)
    {
//        if (count($this->_dataToInsert) < 2)
//            return false;

            
        if (!$this->_id)
            throw new Dune_Exception_Base('Идентификатор записи нужно указывать обязательно.');
        if (!$this->_type)
            throw new Dune_Exception_Base('Тип объекта нужно указывать обязательно.');
        
        $q = 'INSERT INTO ?t SET id = ?, user_id = 0, type = ?i, data = ?s';
        return $this->DB->query($q, array(
                                          self::$table,
                                          $this->_id,
                                          $this->_type,
                                          $this->_dataToInsert
                                          ), Dune_MysqliSystem::RESULT_AR);
    }

    /**
     * Сохранить измененные данные в таблице.
     *
     * @return boolean
     */
    public function save($id = 0)
    {

        if (!$this->_infoArrayChachged)
            return true;

        if (!$this->_haveSaved)
            return false;
            
        if (!$id)
            $id = $this->_id;

        if (is_array($this->_data))
        {
            $result = $this->_data;
            foreach ($this->_dataToInsert as $key => $value)
            {
                $result[$key] = $value;
            }
            $this->_dataToInsert = $result;
        }
            
            
        if (!$this->_id)
            throw new Dune_Exception_Base('Идентификатор пользователя нужно указывать обязательно.');
        if (!$this->_type)
            throw new Dune_Exception_Base('Тип объекта нужно указывать обязательно.');
        
            
        $q = 'UPDATE ?t SET 
                        status = ?i,
                        data = ?s,
                        result_id = ?i,
                        words = ?s
                        WHERE id = ? LIMIT 1';
        return $this->DB->query($q, array(
                                          self::$table,
                                          $this->_status,
                                          $this->_dataToInsert,
                                          $this->_result_id,
                                          $this->_words,
                                          $id 
                                          ), Dune_MysqliSystem::RESULT_AR);
                                          
    }

    
    
////////////////////////////////////////////////////////////////
///////////////////////////////     Защищенные методы
    
    
    protected function _getFromDb()
    {
        $good = false;
        $q = 'SELECT * FROM ?t WHERE id = ?';
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
            {
                if (!count($this->_dataToInsert))
                    $this->_dataToInsert = $this->_data;
            }
            $good = true;
            $this->_words = @unserialize($result['words']);
            if (!is_array($this->_words))
                $this->_words = array();
            
        }
        return $good;
    }

    protected function _getFromDbNotFinished()
    {
        $good = false;
        $q = 'SELECT * FROM ?t WHERE id = ? AND status = 0';
        $result = $this->DB->query($q, array(
                                          self::$table,
                                          $this->_id,
                                          ), Dune_MysqliSystem::RESULT_ROWASSOC);
        if ($result !== false)
        {
            $this->_id = $result['id'];
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
            
            $this->_haveSaved = true;
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

////////////////////////////////////////////////////////////////
///////////////////////////////     Методы интерфейса Iterator
  // устанавливает итеретор на первый элемент
  public function rewind()
  {
      return reset($this->_data);
  }
  // возвращает текущий элемент
  public function current()
  {
      return current($this->_data);
  }
  // возвращает ключ текущего элемента
  public function key()
  {
    return key($this->_data);
  }
  
  // переходит к следующему элементу
  public function next()
  {
    return next($this->_data);
  }
  // проверяет, существует ли текущий элемент после выполнения мотода rewind или next
  public function valid()
  {
    return isset($this->_data[key($this->_data)]);
  }    
/////////////////////////////
////////////////////////////////////////////////////////////////    
    
    
}