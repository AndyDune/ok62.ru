<?php
/**
*   ������ � �������� $_GET.
* 
* 
* ----------------------------------------------------------
* | ����������: Dune                                        |
* | ����: Total.php                                         |
* | � ����������: Dune/Filter/Get/Total.php                 |
* | �����: ������ ����� (Dune) <dune@rznw.ru>               |
* | ������: 1.02                                            |
* | ����: www.rznw.ru                                       |
* ----------------------------------------------------------
* 
* ������:
* 1.02 (2009 ��� 14)
* ��������� ������� �� ����������. ����� ����� � UTF.
* ��������� ��������� ���������� Countable
* 
* ������ 1.00 -> 1.01
* ----------------------
* ��������� ��������� ����������� ArrayAccess � Iterator
* 
*/

class Dune_Filter_Get_Total implements ArrayAccess, Iterator, Countable
{

	protected $_default = '';
	
    static private $instance = null;
    
    /**
    * ���������� ������ �� ������
    *
    * @param mixed $def �������� �� ���������
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
	 * ���������� ����������� ��������� � ������� $_GET
	 * ��������� ��������� Countable
	 * 
	 * @return integer
	 */
	public function count()
	{
		return count($_GET);
	}
    
    
    /**
     * ��������� ����� �������� �� ���������
     *
     * @param mixed $value
     */
    public function setDefault($value)
    {
    	$this->_default = $value;
    }
    
    /**
     * ��������� �������� � ������� $_GET � ��������� ���.
     * ������ - �����.
     * ��� ���������� ����� � ������� - �������� �� ��������� $default
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
     * ��������� �������� � ������� $_GET � ��������� ���.
     * ������ - ������� htmlspecialchars().
     * ��� ���������� ����� � ������� - �������� �� ��������� $default
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
     * �������� ������������� �����
     *
     * @param string $name
     * @return boolean
     */
    public function have($name)
    {
    	return isset($_GET[$name]);
    }
    /**
     * �������� ������������� �����
     *
     * @param string $name
     * @return boolean
     */
    public function check($name)
    {
    	return isset($_GET[$name]);
    }
    
////////////////////////////////////////////////////////////////
///////////////////////////////     ���������� ������
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
///////////////////////////////     ������ ���������� Iterator
  // ������������� �������� �� ������ �������
  public function rewind()
  {
        return reset($_GET);
  }
  // ���������� ������� �������
  public function current()
  {
      return current($_GET);
  }
  // ���������� ���� �������� ��������
  public function key()
  {
    return key($_GET);
  }
  
  // ��������� � ���������� ��������
  public function next()
  {
    return next($_GET);
  }
  // ���������, ���������� �� ������� ������� ����� ���������� ������ rewind ��� next
  public function valid()
  {
    return isset($_GET[key($_GET)]);
  }    
/////////////////////////////
////////////////////////////////////////////////////////////////    
    
    
////////////////////////////////////////////////////////////////
///////////////////////////////     ������ ���������� ArrayAccess
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
