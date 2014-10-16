<?php
/**
 * 
 * Данные о добавляемом объекте.
 * 
 */
abstract class Special_Vtor_Object_Request_Abstract_DataNoAuth implements Iterator
{
    protected $DB;
    protected $_id;
    protected $_user_id = 0;
    protected $_user_code = 0;
    protected $_type = 0;

    protected $_time;
    
    protected $_data  = array();
   
    protected $_text = '';    
    
    protected $_name = '';    
    protected $_rent = 0;    
    protected $_sale = 0;    
    protected $_price = 0;        

    
    protected $_dataToInsert      = array();
    protected $_infoArrayChachged = false;
    
    protected $_haveSaved = false;

    public static $table          = 'unity_catalogue_object_request';
    
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
	        $q = 'DELETE FROM ?t WHERE id = ?i';
            return $this->DB->query($q, array(
                                              self::$table,
                                              $this->_id,
                                              ), Dune_MysqliSystem::RESULT_AR);
	        
	    }
	}
	
	public function isFromBd()
	{
	    return $this->_haveSaved;
	}
    
	public function useIdGetDataFromDb($id)
	{
	   $this->_id = $id;
	   return $this->_haveSaved = $this->_getFromDb();
	}
	
	public function getId()
	{
	    return $this->_id;
	}
	
	public function getTime()
	{
	    if (!$this->_haveSaved)
	    {
	        throw new Dune_Exception_Base('Не загружены данные из базы.');
	    }
	    return $this->_time;
	}
	
	public function setTypeId($value)
	{
	    $this->_type = $value;
	}
	
	public function getTypeId()
	{
	    return $this->_type;
	}
	
	public function getTypeCodeName()
	{
	    if (isset(Special_Vtor_Settings::$typeCodeToString[$this->_type]))
	       return Special_Vtor_Settings::$typeCodeToString[$this->_type];
	    else 
	       return false;
	}
	
	public function setUserId($value)
	{
	    $this->_user_code = $value;
	}

	public function setUserCode($value)
	{
	    $this->_user_code = $value;
	}
	
	/**
	 * Перевод данных незарегистрированного пользователя зарегистрированному.
	 *
	 * @param integer $user_id
	 * @return unknown
	 */
	public function setToAuth($user_id)
	{
	    if ($user_id < 1)
	       return false;
	    if (!$this->_user_code)
	       throw new Dune_Exception_Base('Необходимо указать код пользователя.');
	    $q = 'UPDATE ?t SET user_id = ?i WHERE user_code = ?';
        return $this->DB->query($q, array(
                                          self::$table,
                                          $user_id,
                                          $this->_user_code
                                          ), Dune_MysqliSystem::RESULT_AR);
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
	
	public function setStatus($value)
	{
	    $this->_infoArrayChachged = true;
	    $this->_status = $value;
	}

	public function getUserId()
	{
	    return $this->_user_code;
	}

	public function getUserCode()
	{
	    return $this->_user_code;
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
	 * 
	 *
	 * @return string
	 */
	public function setText($text)
	{
	    $this->_text = $text;
	}

	public function setName($value)
	{
	    $this->_name = substr($value, 0, 200);
	}
	
	public function setSale($value)
	{
	    $this->_sale = (int)$value;
	    if ($this->_sale > 1)
	       $this->_sale = 1;
	}
	public function setRent($value)
	{
	    $this->_rent = (int)$value;
	    if ($this->_rent > 1)
	       $this->_rent = 1;
	    
	}
	
	public function setPrice($value)
	{
	       $this->_price = substr($value, 0, 200);
//	    $this->_price = (int)$value;
//	    if ($this->_price > 100000000)
//	       $this->_price = 100000000;
	    
	}

	
	/**
	 * Выборка момента времени внесения предыдущего объекта.
	 *
	 * @return string
	 */
	public function getLastInsertTime()
	{
	    if (!$this->_user_id)
	    {
	        throw new Dune_Exception_Base('Не указан идентификатор пользователя.');
	    }
	    $q = 'SELECT UNIX_TIMESTAMP(time) FROM ?t WHERE user_code = ? ORDER BY id DESC';
        return $this->DB->query($q, array(
                                          self::$table,
                                          $this->_user_code,
                                          ), Dune_MysqliSystem::RESULT_EL);

	}

	/**
	 * Выборка колличества заявок.
	 *
	 * @return integer
	 */
	public function getCount()
	{
	    if (!$this->_user_code)
	    {
	        //$this->_haveSaved
	        throw new Dune_Exception_Base('Не указан идентификатор пользователя 1.');
	    }
	    $q = 'SELECT count(*) FROM ?t WHERE user_code = ?';
        return $this->DB->query($q, array(
                                          self::$table,
                                          $this->_user_code,
                                          ), Dune_MysqliSystem::RESULT_EL);

	}
	

	/**
	 * Выборка всех заявок пользователя.
	 *
	 * @return integer
	 */
	public function getList()
	{
	    if (!$this->_user_code)
	    {
	        throw new Dune_Exception_Base('Не указан идентификатор пользователя.');
	    }
	    $q = 'SELECT * FROM ?t WHERE user_code = ? ORDER BY time DESC';
        return $this->DB->query($q, array(
                                          self::$table,
                                          $this->_user_code
                                          ), Dune_MysqliSystem::RESULT_IASSOC);

	}
	

	/**
	 * Выборка всех заявок пользователя.
	 *
	 * @return integer
	 */
	public function getListAll($shift = 0, $count = 100)
	{
	    $q = 'SELECT * FROM ?t ORDER BY time DESC LIMIT ?i, ?i';
        return $this->DB->query($q, array(
                                          self::$table,
                                          $shift,
                                          $count
                                          ), Dune_MysqliSystem::RESULT_IASSOC);
	}
	
	
	/**
	 * Выборка колличества заявок.
	 *
	 * @return integer
	 */
	public function getCountAll()
	{
	    $q = 'SELECT count(*) FROM ?t';
        return $this->DB->query($q, array(
                                          self::$table
                                          ), Dune_MysqliSystem::RESULT_EL);
	}
	
	
	
	
    public function add($is_load_result = false)
    {
//        if (count($this->_dataToInsert) < 2)
//            return false;

            
        if (!$this->_user_code)
            throw new Dune_Exception_Base('Идентификатор пользователя нужно указывать обязательно.');
        if (!$this->_type)
            throw new Dune_Exception_Base('Тип объекта нужно указывать обязательно.');
        
        $q = 'INSERT INTO ?t SET id = NULL, user_code = ?, type = ?i, data = ?s, text = ?,
                                 name = ?,
                                 price = ?,
                                 rent = ?i,
                                 sale = ?i
                                 ';
        $this->_id = $this->DB->query($q, array(
                                          self::$table,
                                          $this->_user_code,
                                          $this->_type,
                                          $this->_dataToInsert,
                                          $this->_text,
                                          $this->_name,
                                          $this->_price,
                                          $this->_rent,
                                          $this->_sale
                                          ), Dune_MysqliSystem::RESULT_ID);
        if ($is_load_result and $this->_id)
        {
            $this->_haveSaved = $this->_getFromDb();
        }
        return $this->_id;
    }

    /**
     * Сохранить измененные данные в таблице.
     *
     * @return boolean
     */
    public function save($id = 0)
    {
    //    if (!$this->_infoArrayChachged)
    //        return true;

        if (!$this->_haveSaved)
            return false;
            
        if (!$id)
            $id = $this->_id;
        
        if (!$this->_user_code)
            throw new Dune_Exception_Base('Идентификатор пользователя нужно указывать обязательно.');
        if (!$this->_type)
            throw new Dune_Exception_Base('Тип объекта нужно указывать обязательно.');

        $q = 'UPDATE ?t SET 
                        data = ?s,
                        text = ?,
                        name = ?,
                        price = ?,
                        rent = ?i,
                        sale = ?i
                        WHERE id = ?i LIMIT 1';
        return $this->DB->query($q, array(
                                          self::$table,
                                          $this->_dataToInsert,
                                          $this->_text,
                                          
                                          $this->_name,
                                          $this->_price,
                                          $this->_rent,
                                          $this->_sale,
                                          
                                          $id 
                                          ), Dune_MysqliSystem::RESULT_AR);
                                          
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
            if ($result['user_code'])
                $this->_user_code = $result['user_code'];
            else 
                $this->_user_code = 'no';
             
            $this->_time = $result['time'];
            $this->_type = $result['type'];
            $this->_text = $result['text'];            
            
            $this->_name = $result['name'];
            $this->_rent = $result['rent'];
            $this->_sale = $result['sale'];
            $this->_price = $result['price'];
            
            $this->_data = @unserialize($result['data']);
            if (!is_array($this->_data))
                $this->_data = array();
            else 
            {
                if (!count($this->_dataToInsert))
                    $this->_dataToInsert = $this->_data;
            }
            $good = true;
            $this->_data['text'] = $this->_text;
            $this->_data['time'] = $this->_time;
            $this->_data['type'] = $this->_type;
            
            $this->_data['rent'] = $this->_rent;
            $this->_data['name'] = $this->_name;
            $this->_data['sale'] = $this->_sale;
            $this->_data['price'] = $this->_price;
            $this->_data['public'] = $result['public'];            
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