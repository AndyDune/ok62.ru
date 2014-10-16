<?php
/**
*   Работа с массивами $_POST ($GET, $COOKIE).
* 
*   Этап разработки.
* 
* 
* ----------------------------------------------------------
* | Библиотека: Dune                                        |
* | Файл: Total.php                                         |
* | В библиотеке: Dune/Filter/Request/Total.php             |
* | Автор: Андрей Рыжов (Dune) <dune@rznlf.ru>              |
* | Версия: 0.01                                            |
* | Сайт: www.rznlf.ru                                      |
* ----------------------------------------------------------
* 
* Версия 1.00 -> 1.01
* ----------------------
* 
*/

class Dune_Filter_Request_Total implements ArrayAccess,Iterator
{

	protected $_default = '';
	
	protected $_iteratorMode = '_POST';
	protected $_arrayAccessMode = '_POST';
	
	protected $_lastValueFrom = '';
	
	protected $_prioritetArray = array('_GET', '_POST');
	
    static private $instance = null;
    
    /**
    * Возвращает ссылку на объект
    *
    * @param mixed $def значение по умолчанию
    * @return Dune_Filter_Request_Total
    */
    static function getInstance($def = '')
    {
        if (is_null(self::$instance))
        {
            self::$instance = new Dune_Filter_Request_Total($def);
        }
        return self::$instance;
    }
    
    protected function __construct($def)
    {
    	$this->_default = $def;
    }

    public function setIterator($name = 'p')
    {
        switch ($name)
        {
            case 'p':
                $this->_iteratorMode = '_POST';
            break;
            case 'c':
                $this->_iteratorMode = '_COOKIE';
            break;
            case 'g':
                $this->_iteratorMode = '_GET';
            break;
            
        }
        
    }
    
    /**
     * Установка последовательности обработки массивов _GET, _POST, _COOKIE
     * Последнее более приоритетное.
     *
     * @param string $string разлтчные комбинации символов p, g, c
     */
    public function setPrioritet($string = 'gp')
    {
    	$lendth = strlen($string);
    	$allow = array('g', 'p', 'c');
    	if ($lendth > 0)
    	{
    	    for ($t = 0; $t < $lendth; $t++)
    	    {
    	        if (!in_array($string, $allow))
    	           throw new Dune_Exception_Base('Недопустимый символ в строке установки приоритета обработки.');
    	        $this->_prioritetArray = array();
    	        switch ($string[$t])
    	        {
    	        	case 'g':
    	        		$this->_prioritetArray[] = '_GET';
    	        	break;
    	        	case 'p':
    	        		$this->_prioritetArray[] = '_POST';
    	        	break;
    	        	case 'c':
    	        		$this->_prioritetArray[] = '_COOKIE';
    	        	break;
    	        	
    	        }
    	    }
    	    
    	}
    }
    
    
    /**
     * Установка новог значение по умолчанию
     *
     * @param mixed $value
     */
    public function setDefault($value)
    {
    	$this->_default = $value;
    }
    
    /**
     * Фильтрует значение в системных массивах $_POST ($GET, $COOKIE) и возвращат его.
     * Фильтр - число.
     * При отсутствии ключа в массиве - значение по умолчанию $default
     *
     * @param string $name
     * @param integer $default
     * @return integer
     */
    public function getDigit($name, $default = 0, $maxLength = 10)
    {
        $value = $this->_getWithPrioritet($name);
    	if ($value === false)
    		return (int)trim(substr($value, 0, $maxLength));
    	else 
    		return $default;
    }

    /**
     * Фильтрует значение в массиве $_POST ($GET, $COOKIE) и возвращат его.
     * Фильтр - функция htmlspecialchars().
     * При отсутствии ключа в массиве - значение по умолчанию $default
     *
     * @param string $name
     * @param string $default
     * @return string
     */
    public function getHtmlSpecialChars($name, $default = '', $maxLength = 10000)
    {
        $value = $this->_getWithPrioritet($name);
    	if ($value === false)
    		return htmlspecialchars(trim(substr($value, 0, $maxLength)));
    	else 
    		return $default;
    }
    
    /**
     * Проверка существования ключа
     *
     * @param string $name
     * @return boolean
     */
    public function have($name)
    {
    	return $this->_isSetWithPrioritet($name);
    }
    
    /**
     * Проверка существования ключа
     *
     * @param string $name
     * @return boolean
     */
    public function check($name)
    {
    	return $this->_isSetWithPrioritet($name);
    }
    
    /**
     * Возвращает код мссива (p, g, c) из которого было выбрано последнее значение.
     * Если выборка последнего значения дала значение по умолчанию (ключа ни в одном массиве не было) - возврат false.
     *
     * @return mixed
     */
    public function lastGetFrom()
    {
        $names = array('_POST' => 'p', '_GET' => 'g', '_COOKIE' => 'c');
        if ($this->_lastValueFrom)
            return $names[$this->_lastValueFrom];
        return false;
    }
    
    protected function _getWithPrioritet($name)
    {
        $result = false;
        $this->_lastValueFrom = '';
        foreach ($this->_prioritetArray as $value)
        {
            if (isset($$value[$name]))
            {
                $result = $$value[$name];
                $this->_lastValueFrom = $value;
            }
        }
        return $result;
    }
    protected function _isSetWithPrioritet($name)
    {
        $result = false;
        $this->_lastValueFrom = '';
        foreach ($this->_prioritetArray as $value)
        { 
            
            if (isset($$value[$name]))
            { echo '2, ';
                $result = true;
                $this->_lastValueFrom = $value;                
            }
        }
        return $result;
    }
    
    protected function _chekcArray($key, $arrayName)
    {
        switch ($arrayName)
        {
            case '_POST':
                if (isset($_POST[$key]))
                    return $_POST[$key];
                else
                    return false;
            break;   
            case '_GET':
                if (isset($_GET[$key]))
                    return $_GET[$key];
                else
                    return false;
            break;   
            case '_COOKIE':
                if (isset($_COOKIE[$key]))
                    return $_COOKIE[$key];
                else
                    return false;
            break;   
        }
    }
    
    
////////////////////////////////////////////////////////////////
///////////////////////////////     Магические методы
    public function __set($name, $value)
    {
        throw new Dune_Exception_Base('Звпрещено менять значения обрабатываемых массивов.');
    }
    public function __get($name)
    {
        $value = $this->_getWithPrioritet($name);
    	if ($value === false)
    		return trim($value);
    	else 
    		return $this->_default;
    }    
    
    
    
////////////////////////////////////////////////////////////////
///////////////////////////////     Методы интерфейса Iterator
  // устанавливает итеретор на первый элемент
  public function rewind()
  {
        //return reset($_POST);
        return reset($$this->_iteratorMode);
  }
  // возвращает текущий элемент
  public function current()
  {
      return current($$this->_iteratorMode);
  }
  // возвращает ключ текущего элемента
  public function key()
  {
    return key($$this->_iteratorMode);
  }
  
  // переходит к следующему элементу
  public function next()
  {
    return next($$this->_iteratorMode);
  }
  // проверяет, существует ли текущий элемент после выполнения мотода rewind или next
  public function valid()
  {
    return isset($$this->_iteratorMode[key($$this->_iteratorMode)]);
  }    
/////////////////////////////
////////////////////////////////////////////////////////////////    
    
    
////////////////////////////////////////////////////////////////
///////////////////////////////     Методы интерфейса ArrayAccess
    /**
     * @param mixed $key
     * @return mixed
     * @access private
     */
    public function offsetExists($key)
    {
        return isset($$this->_arrayAccessMode[$key]);
    }
    public function offsetGet($key)
    {
        if (isset($$this->_arrayAccessMode[$key]))
            return $$this->_arrayAccessMode[$key];
        else 
           return $this->_default;
    }
    
    public function offsetSet($key, $value)
    {
        $$this->_arrayAccessMode[$key] = $value;
    }
    public function offsetUnset($key)
    {
        unset($$this->_arrayAccessMode[$key]);
    }    
    
}
