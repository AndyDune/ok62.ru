<?php
/**
 * Dune Framework
 * 
 * ��������� ������ ������������ � ��������� �������.
 * ������ � ������� explode()
 * 
 * ----------------------------------------------------
 * | ����������: Dune                                  |
 * | ����: Explode.php                                 |
 * | � ����������: Dune/String/Explode.php             |
 * | �����: ������ ����� (Dune) <dune@rznw.ru>         |
 * | ������: 1.07                                      |
 * | ����: www.rznw.ru                                 |
 * ----------------------------------------------------
 *
 * ������� ������:
 * 
 * ������ 1.07  (2009 ��� 14)
 * ��������� ������� �� ����������. ����� ����� � UTF.
 * 
 * ������ 1.05  (2009 ������ 22)
 * ���������� ������ �������� 0(����) �� ���������� ��������.
 * 
 * ������ 1.05  (2009 ������ 21)
 * ��������� ���������� ���������� Countable.
 * 
 * ������ 1.04  (2008 ������� 04)
 * �������� ����� getResultArray() ������� ����� ��������.
 * 
 * 
 * ������ 1.03  (2008 ������� 23)
 * �������� ����� getInteger() ��� ������� � ������ ��������� �������.
 * ��������� ����������� ������ ������ ������� ������ �������.
 * 
 * ������ 1.02
 * ���������� ��������.
 * 
 * ������ 1.00 -> 1.01
 * ��������� ������ � ������ ��� ������ ������������, ���� ������� ������� $separator.
 * ����� ��������� �������� (���� ������� ���������) ��� ������ make()
 */

class Dune_String_Explode implements ArrayAccess, Iterator, Countable
{
	protected $_string;
	protected $_separator;
	protected $_array = array();
	protected $_count = 0;
	protected $_empty = false;
	
	
	public function __construct($string, $separator = '', $key_begin = 0)
	{
	    $str = Dune_String_Factory::getStringContainer($string);
	    $this->_string = $str->trim(' '.$separator);
//		$this->_string = trim($string, ' '.$separator);
		$this->_separator = $separator;
		if ($this->_separator)
			$this->make($key_begin);
		
	}
	
	public function setSeparator($separator)
	{
		$this->_separator = $separator;
	}
	
	public function count()
	{
		return $this->_count;
	}
	
	public function leaveEmpty($bool = true)
	{
		$this->_empty = $bool;
	}

	public function getInteger($key = 0, $default = null)
	{
        if (isset($this->_array[$key]))
            return (int)$this->_array[$key];
        else 
           return $default;
	}
	
	/**
	 * ����������� ����� � ������ �� �����������. ������� ������.
	 *
	 * @return integer
	 */
    public function make($key_begin = 0)
    {
        $array_result = array();
        if ($this->_string)
        {
            $array_begin = explode($this->_separator, $this->_string);
            foreach ($array_begin as $value)
            {
                $x = trim($value);
                if ($x != '' or $this->_empty)
                {
                    $array_result[$key_begin] = $x;
                    $key_begin++;
                }
            }
        }
        $this->_array = $array_result;
        $this->_count = count($array_result);
        
        return $this->_count;
    }

    /**
     * ������� ����� ��������������� �������.
     *
     * @param boolean $in_container
     * @return array
     */
    public function getResultArray($in_container = false)
    {
        if ($in_container)
            return new Dune_Array_Container($this->_array);
        return $this->_array;
    }

    
//////////////////////////////////////////////////////////////////
///////////////////////////////     ������ ���������� ArrayAccess
    public function offsetExists($key)
    {
        return isset($this->_array[$key]);
    }
    public function offsetGet($key)
    {
        if (isset($this->_array[$key]))
            return $this->_array[$key];
        else 
           return null;
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
    return isset($this->_array[key($this->_array)]);
  }    
/////////////////////////////
////////////////////////////////////////////////////////////////   
    
    
}

