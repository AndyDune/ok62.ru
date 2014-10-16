<?php
/**
 * Анилизирует по заданной сземе $_POST и создаёт строку SET для запроса.
 * 
 * 
 * ----------------------------------------------------
 * | Библиотека: Dune                                  |
 * | Файл: SetFromPost.php                             |
 * | В библиотеке: Dune/Db/Collector/SetFromPost.php   |
 * | Автор: Андрей Рыжов (Dune) <dune@rznlf.ru>        |
 * | Версия: 0.95                                      |
 * | Сайт: www.rznlf.ru                                |
 * ----------------------------------------------------
 *
 * История версий:
 * 
 * Версия 0.95 -> 0.96
 * 
 * 
 */
class Dune_Db_Collector_SetFromPost implements ArrayAccess,Iterator
{

	protected $_array = array();
	
	protected $_allowFormats = array('float', 'int', 'text', 'html');
	
	protected $almostSetTable = array();
	protected $almostSet = array();
	
	public function __construct()
	{
	}

	/**
	 * Добавляет поле для рассмотрения.
	 * Поле обязательно в запросе. Емли в $_POST нет - заменяется по умолчанию.
	 *
	 * @param string $name имя поля (ключа в $_POST)
	 * @param string $table имя таблицы или псевдонима - необязательно
	 * @param string $format один из разреённых форматов для фильтрации
	 * @param mixed $default значение пот умолчанию, если ключа в $_POST нет
	 */
	public function addFieldRequire($name, $table = '', $format = 'int', $default = 0)
	{
	    if (is_array($name))
	    {
	        foreach ($name as $key => $value)
	        {
	            if (!isset($value['format']) or !isset($value['default']))
	               throw new Dune_Exception_Base('Неверный формат массива для задания обязательгых полей в запросе.');
	        	$this->_checkFormat($value['format']);
        	    $array['name'] = $key;
        	    $array['default'] = $value['default'];
        	    $array['format'] = $value['format'];
        	    if (isset($value['table'])) 
        	    {
        	    	$array['table'] = $value['table'];
        	    }
        	    else 
        	       $array['table'] = '';
        	    
        	    $this->_array[] = $array;
	        }
	    }
	    else 
	    {	    
    	    $this->_checkFormat($format);
    	    $array['name'] = $name;
    	    $array['default'] = $default;
    	    $array['format'] = $format;
    	    $array['table'] = $table;
    	    $this->_array[] = $array;
	    }
	}
	
	/**
	 * Добавляет поле для рассмотрения.
	 * Поле не обязательно в запросе.
	 *
	 * @param string $name имя поля (ключа в $_POST)
	 * @param string $table имя таблицы или псевдонима - необязательно
	 * @param string $format один из разреённых форматов для фильтрации
	 */
	public function addField($name, $table = '', $format = 'int')
	{
	    if (is_array($name))
	    {
	        foreach ($name as $key => $value)
	        {
	            if (!isset($value['format']))
	               throw new Dune_Exception_Base('Неверный формат массива для задания обязательгых полей в запросе.');
	        	$this->_checkFormat($value['format']);
        	    $array['name'] = $key;
        	    $array['default'] = null;
        	    $array['format'] = $value['format'];
        	    if (isset($value['table'])) 
        	    {
        	    	$array['table'] = $value['table'];
        	    }
        	    else 
        	       $array['table'] = '';
        	    $this->_array[] = $array;
	        }
	    }
	    else 
	    {
    	    $this->_checkFormat($format);
    	    $array['name'] = $name;
    	    $array['default'] = null;
    	    $array['format'] = $format;
    	    $array['table'] = $table;
    	    $this->_array[] = $array;
	    }
	}
	
	/**
	 * Возвращает строку для SET, для ипоьзования с библиотекой mysqli
	 * Необходима передача объекта mysqli или дочернего
	 * Ко всем данным применяется real_escape_string()
	 *
	 * @param mysqli $db
	 * @return string строка для вставки в запрос в базу данных. !! Без оператора SET.
	 */
	public function getForMysqli(mysqli $db)
	{
	    $this->_makeArrays();
	    $string = '';
	    $count = 0;
	    foreach ($this->almostSet as $key => $value)
	    {
	        if ($count)
	           $string .= ', ';
	        if ($this->almostSetTable[$key])
	           $string .= '`' . $this->almostSetTable[$key] . '`.';
	        $string .= '`' . $key . '`="' . $db->real_escape_string($value) . '"';
	        
	        ++$count;
	    }
	    return $string;
	}

	/**
	 * Возвращает строку для SET, для ипоьзования с библиотекой mysql
	 * Ко всем данным применяется mysql_real_escape_string()
	 *
	 * @return string строка для вставки в запрос в базу данных. !! Без оператора SET.
	 */
	public function getForMysql()
	{
	    $this->_makeArrays();
	    $string = '';
	    $count = 0;
	    foreach ($this->almostSet as $key => $value)
	    {
	        if ($count)
	           $string .= ', ';
	        if ($this->almostSetTable[$key])
	           $string .= '`' . $this->almostSetTable[$key] . '`.';
	        $string .= '`' . $key . '`="' . mysql_real_escape_string($value) . '"';
	        
	        ++$count;
	    }
	    return $string;
	}
	
	/**
	 * Генерит промежуточные массивы.
	 *
	 * @return boolean
	 * @access private
	 */
	protected function _makeArrays()
	{
	    if (!count($this->_array))
	       return false;
	    foreach ($this->_array as $value)
	    {
	        $from_post = $this->_getFromPost($value['name']);
	        if (is_null($from_post))
	        {
	            if (!is_null($value['default']))
	               $this->almostSet[$value['name']] = $value['default'];
	        }
	        else 
	        {
	            $this->almostSet[$value['name']] = $this->_filter($from_post, $value['format']);
	        }
	        if (isset($value['table']))
	           $this->almostSetTable[$value['name']] = $value['table'];
	        else 
	           $this->almostSetTable[$value['name']] = '';
	    }
	    return true;
	}

	/**
	 * Фильтр.
	 * При неверном коде фильтра - исключение.
	 *
	 * @param mixed $value фильтруемое значение
	 * @param string $filter код фильтра
	 * @return mixed результат работы
	 * 
	 * @access private
	 */
	protected function _filter($value, $filter)
	{
	    switch ($filter)
	    {
	    	case 'int':
	    	    $value = (int)$value;
	    	break;
	    	case 'float':
	    	    $value = (float)str_replace(',', '.', $value);
	    	break;
	    	case 'text':
	    	    $value = htmlspecialchars($value);
	    	break;
	    	case 'html':
	    	    $value = $value;
	    	break;
	    
	    	default:
                throw new Dune_Exception_Base('Незарегиистрированный ключ фильтра.' . $filter);
	    }
	    return $value;
	}
	
	protected function _getFromPost($key)
	{
	    if (key_exists($key, $_POST))
	       return $_POST[$key];
	    else 
	       return null;
	}
	
	protected function _checkFormat($format)
	{
	    if (!in_array($format, $this->_allowFormats))
	    {
	        throw new Dune_Exception_Base('Неверный флаг формата принят: ' . $format);
	    }
	}
////////////////////////////////////////////////////////////////
///////////////////////////////     Магические методы
    public function __set($name, $value)
    {
        $this->_array[$name] = $value;
    }
    public function __get($name)
    {
        if (isset($this->_array[$name]))
            return $this->_array[$name];
        else 
           return $this->_defaultValue;
    }  
    
    public function __toString()
    {
    	$string = '<pre>';
    	ob_start();
    	print_r($this->_array);
    	$string .= ob_get_clean();
    	return  '</pre>' . $string;
    }
      ////////////////////////////////////////////////////////////////
///////////////////////////////     Методы интерфейса ArrayAccess
    /**
     * @param mixed $key
     * @return mixed
     * @access private
     */
    public function offsetExists($key)
    {
        return isset($this->_array[$key]);
    }
    public function offsetGet($key)
    {
        if (isset($this->_array[$key]))
            return $this->_array[$key];
        else 
           return $this->_defaultValue;
    }
    
    public function offsetSet($key, $value)
    {
        $this->_array[$key] = $value;
    }
    public function offsetUnset($key)
    {
        unset($this->_array[$key]);
    }    
    ////////////////////////////////////////////////////////////////
///////////////////////////////     Методы интерфейса Iterator
  // устанавливает итеретор на первый элемент
  public function rewind()
  {
        return reset($this->almostSet);
  }
  // возвращает текущий элемент
  public function current()
  {
      return current($this->almostSet);
  }
  // возвращает ключ текущего элемента
  public function key()
  {
    return key($this->almostSet);
  }
  
  // переходит к следующему элементу
  public function next()
  {
    return next($this->almostSet);
  }
  // проверяет, существует ли текущий элемент после выполнения мотода rewind или next
  public function valid()
  {
    return isset($this->almostSet[key($this->almostSet)]);
  }    
/////////////////////////////
////////////////////////////////////////////////////////////////   

}