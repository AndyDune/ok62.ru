<?php
/**
 * Реализует все интерфейсы лоя превращения класа в массив.
 * 
 * ----------------------------------------------------
 * | Библиотека: Dune                                  |
 * | Файл: Interface.php                               |
 * | В библиотеке: Dune/Array/Abstract/Interface.php   |
 * | Автор: Андрей Рыжов (Dune) <dune@rznw.ru>         |
 * | Версия: 1.98                                      |
 * | Сайт: www.rznw.ru                                 |
 * ----------------------------------------------------
 *
 * История версий:
 *
 * Версия 0.98 (2008 декабрь 27) Нет хороших комменетариев.
 * 
 */
abstract class Dune_Array_Abstract_Interface implements ArrayAccess, Iterator, Countable
{

	protected $_array = array();
	protected $_defaultValue = null;
	
	/**
	 * Возвращает колличество элементов массива
	 * Реализует интрефейс Countable
	 * 
	 * @return integer
	 */
	public function count()
	{
		return count($this->_array);
	}

	/**
	 * Возвращает весь массив, если не указан параметр $key
	 * Возвращает содержимое ячейки массива с индексом переданным в $key
	 *
	 * @param string $key
	 * @return mixed
	 */
	public function get($key = false)
	{
		if ($key !== false)
		{
			if (isset($this->_array[$key]))
				return $this->_array[$key];
			else 
				return $this->_defaultValue;
		}
		else 
			return $this->_array;
	}
	
	/**
	 *
	 * @param string $key
	 * @return mixed
	 */
	public function set($key, $value = '')
	{
    	$this->__set($key, $value);
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
        $this->__set($key, $value);
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
        return reset($this->_array);
  }
  // возвращает текущий элемент
  public function current()
  {
      return current($this->_array);
  }
  // возвращает ключ текущего элемента
  public function key()
  {
    return key($this->_array);
  }
  
  // переходит к следующему элементу
  public function next()
  {
    return next($this->_array);
  }
  // проверяет, существует ли текущий элемент после выполнения мотода rewind или next
  public function valid()
  {
    //return isset($this->_array[key($this->_array)]);
    return key_exists(key($this->_array), $this->_array);
  }    
/////////////////////////////
////////////////////////////////////////////////////////////////   

}