<?php
/**
 * ��������� ��� ���������� ��� ����������� ����� � ������.
 * 
 * ----------------------------------------------------
 * | ����������: Dune                                  |
 * | ����: Interface.php                               |
 * | � ����������: Dune/Array/Abstract/Interface.php   |
 * | �����: ������ ����� (Dune) <dune@rznw.ru>         |
 * | ������: 1.98                                      |
 * | ����: www.rznw.ru                                 |
 * ----------------------------------------------------
 *
 * ������� ������:
 *
 * ������ 0.98 (2008 ������� 27) ��� ������� �������������.
 * 
 */
abstract class Dune_Array_Abstract_Interface implements ArrayAccess, Iterator, Countable
{

	protected $_array = array();
	protected $_defaultValue = null;
	
	/**
	 * ���������� ����������� ��������� �������
	 * ��������� ��������� Countable
	 * 
	 * @return integer
	 */
	public function count()
	{
		return count($this->_array);
	}

	/**
	 * ���������� ���� ������, ���� �� ������ �������� $key
	 * ���������� ���������� ������ ������� � �������� ���������� � $key
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
///////////////////////////////     ���������� ������
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
///////////////////////////////     ������ ���������� ArrayAccess
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
///////////////////////////////     ������ ���������� Iterator
  // ������������� �������� �� ������ �������
  public function rewind()
  {
        return reset($this->_array);
  }
  // ���������� ������� �������
  public function current()
  {
      return current($this->_array);
  }
  // ���������� ���� �������� ��������
  public function key()
  {
    return key($this->_array);
  }
  
  // ��������� � ���������� ��������
  public function next()
  {
    return next($this->_array);
  }
  // ���������, ���������� �� ������� ������� ����� ���������� ������ rewind ��� next
  public function valid()
  {
    //return isset($this->_array[key($this->_array)]);
    return key_exists(key($this->_array), $this->_array);
  }    
/////////////////////////////
////////////////////////////////////////////////////////////////   

}