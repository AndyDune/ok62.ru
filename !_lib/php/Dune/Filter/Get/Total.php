<?php
/**
*   Работа с массивом $_GET.
* 
* 
* ----------------------------------------------------------
* | Библиотека: Dune                                        |
* | Файл: Total.php                                         |
* | В библиотеке: Dune/Filter/Get/Total.php                 |
* | Автор: Андрей Рыжов (Dune) <dune@rznw.ru>               |
* | Версия: 1.02                                            |
* | Сайт: www.rznw.ru                                       |
* ----------------------------------------------------------
* 
* Версии:
* 1.02 (2009 май 14)
* Строковые функции из контейнера. Класс готов к UTF.
* Добавлена реализция интрефейса Countable
* 
* Версия 1.00 -> 1.01
* ----------------------
* Добавлены реализции интрефейсов ArrayAccess и Iterator
* 
*/

class Dune_Filter_Get_Total implements ArrayAccess, Iterator, Countable
{

	protected $_default = '';
	
    static private $instance = null;
    
    /**
    * Возвращает ссылку на объект
    *
    * @param mixed $def значение по умолчанию
    * @return Dune_Filter_Get_Total
    */
    static function getInstance($def = '')
    {
        if (is_null(self::$instance))
        {
            self::$instance = new Dune_Filter_Get_Total($def);
        }
        return self::$instance;
    }
    
    protected function __construct($def)
    {
    	$this->_default = $def;
    }

    
	/**
	 * Возвращает колличество элементов в массиве $_GET
	 * Реализует интрефейс Countable
	 * 
	 * @return integer
	 */
	public function count()
	{
		return count($_GET);
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
     * Фильтрует значение в массиве $_GET и возвращат его.
     * Фильтр - число.
     * При отсутствии ключа в массиве - значение по умолчанию $default
     *
     * @param string $name
     * @param integer $default
     * @return integer
     */
    public function getDigit($name, $default = 0, $maxLength = 10)
    {
    	if (isset($_GET[$name]))
    	{
    	    $str = Dune_String_Factory::getStringContainer($_GET[$name]);
    		return (int)trim($str->substr(0, $maxLength));
    	}
    	else 
    		return $default;
    }

    /**
     * Фильтрует значение в массиве $_GET и возвращат его.
     * Фильтр - функция htmlspecialchars().
     * При отсутствии ключа в массиве - значение по умолчанию $default
     *
     * @param string $name
     * @param string $default
     * @return string
     */
    public function getHtmlSpecialChars($name, $default = '', $maxLength = 10000)
    {
    	if (isset($_GET[$name]))
    	{
    	    $str = Dune_String_Factory::getStringContainer($_GET[$name]);
    		return htmlspecialchars(trim($str->substr(0, $maxLength)));
    	}
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
    	return isset($_GET[$name]);
    }
    /**
     * Проверка существования ключа
     *
     * @param string $name
     * @return boolean
     */
    public function check($name)
    {
    	return isset($_GET[$name]);
    }
    
////////////////////////////////////////////////////////////////
///////////////////////////////     Магические методы
    public function __set($name, $value)
    {
        $_GET[$name] = $value;
    }
    public function __get($name)
    {
        if (isset($_GET[$name]))
            return $_GET[$name];
        else 
           return $this->_default;
    }    
    
    
    
////////////////////////////////////////////////////////////////
///////////////////////////////     Методы интерфейса Iterator
  // устанавливает итеретор на первый элемент
  public function rewind()
  {
        return reset($_GET);
  }
  // возвращает текущий элемент
  public function current()
  {
      return current($_GET);
  }
  // возвращает ключ текущего элемента
  public function key()
  {
    return key($_GET);
  }
  
  // переходит к следующему элементу
  public function next()
  {
    return next($_GET);
  }
  // проверяет, существует ли текущий элемент после выполнения мотода rewind или next
  public function valid()
  {
    return isset($_GET[key($_GET)]);
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
        return isset($_GET[$key]);
    }
    public function offsetGet($key)
    {
        if (isset($_GET[$key]))
            return $_GET[$key];
        else 
           return $this->_default;
    }
    
    public function offsetSet($key, $value)
    {
        $_GET[$key] = $value;
    }
    public function offsetUnset($key)
    {
        unset($_GET[$key]);
    }    
    
}
