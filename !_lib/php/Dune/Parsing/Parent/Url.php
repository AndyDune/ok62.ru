<?php
/**
 * ������������ ����� ������� ������ �������.
 * ����� �����������.
 * 
 * !!!!!!  �������� ��������� �����.
 * 
 * 
 * ----------------------------------------------------
 * | ����������: Dune                                  |
 * | ����: Url.php                                     |
 * | � ����������: Dune/Parsing/Parent/Url.php         |
 * | �����: ������ ����� (Dune) <dune@rznw.ru>         |
 * | ������: 1.09                                      |
 * | ����: www.rznw.ru                                 |
 * ----------------------------------------------------
 *
 * ������� ������:
 *
 * 
 * 1.09 (2009 ������ 27)
 * ����� ����� � ��������� ������������ ����� ���� ������.
 * 
 * 1.08 (2009 ������ 21)
 * �������� �������� ����� �������� ��� ��������� �� �����.
 *
 * 1.07 (2009 ���� 20)
 * ��������� ������ ������������� ����� � ������.
 * 
 * 1.06 (2009 ������ 13)
 * ����� ����� clearModifications() - ����� ���������������� ������� �� ����������.
 * ���������� ���������� Countable - ����������� ������� � ������.
 * 
 * 1.05 (2008 ������� 04)
 * ���������� ������ getCommandPart(). ������� ����� ��������.
 * 
 * 1.04 (2008 ������� 03)
 * ���������� ������ getCommandString() ��� �������� ���������������� ������ ������.
 * ���������� ������ setCommand() ��� ����������� ������������������.
 * ���������� ������ cutCommands() ���������� ����������� �������.
 * �������������� ����������� ������ ������� ������. ������������ ������ �������� ����������.
 * ���������� ������ loadCommandsFromClass() �������� ������� ������� �� ���������� ������-����������.
 * 
 * ������ 1.02 -> 1.03 (2008 ������� 02)
 * �������� �������� ��� ����� (������)
 * 
 * ������ 1.01 -> 1.02 (2008.08.25)
 * ������� getCommand ���� ������� ���������� �������� �� ��������� ����������� ����������.
 * 
 * ������ 1.00 -> 1.01
 * ��������� ��������� ������ ��� ������� � ��������.
 * �������� ������ ����� ������.
 * 
 * ������ 1.01 -> 1.02
 * ������ __set � __get �� ���������.
 * ������� ������������� ���������� Arrayaccess ��� ������� � ��������.
 * ��� ����������� ��������� ������� ������������ �������� �� ���������, ������� ����� ������
 * 
 * 
 */
abstract class Dune_Parsing_Parent_Url implements ArrayAccess, Iterator, Countable
{
    protected $_queryString;
    protected $_queryStringLength = 0;
    protected $_requestString;
    protected $_requestStringLength = 0;

    protected $_requestPath = '';
    protected $_requestPathLength = 0;
    protected $_requestPathArray = array();
    protected $_requestPathArrayParts = array();
    protected $_requestPathArrayToModif = array();
    protected $_requestPathArrayExploded = false;
    
    protected $_arrayAccessDefaultValue = false;
    
    protected $_lastSeparator = '_';
    
	protected function __construct()
	{
	    $this->_queryString = $_SERVER['QUERY_STRING'];
//	    $this->_queryStringLength = strlen($_SERVER['QUERY_STRING']);
	    $this->_requestString = $_SERVER['REQUEST_URI'];
//	    $this->_requestStringLength = strlen($_SERVER['REQUEST_URI']);
	    if ($this->_requestString)
	    {
	        $this->_requestPathLength = strpos( $this->_requestString, '?');
	        if ($this->_requestPathLength !== false)
	        {
	           $str = Dune_String_Factory::getStringContainer($this->_requestString);
	           $this->_requestPath = $str->substr(0, $this->_requestPathLength);
//	           $this->_requestPath = substr($this->_requestString, 0, $this->_requestPathLength);
	        }
    	    else 
	        {
	            $this->_requestPath = $this->_requestString;
	            $str = Dune_String_Factory::getStringContainer($this->_requestString);
	            $this->_requestPathLength = $str->len();
    	    }
/*    	    
    	    if($this->_requestPath[0] == '/')
    	    {
    	       $this->_requestPath = substr($this->_requestPath, 1);
    	       --$this->_requestPathLength;
    	    }
            if($this->_requestPath[$this->_requestPathLength-1] == '/')
            {
                $this->_requestPath = substr($this->_requestPath, 0, -1);
                --$this->_requestPathLength;
            }
*/            
	    }
	    $this->_explodePath();
	}
	
	/**
	 * ���������� ����� ������ ������� ($_SERVER['REQUEST_URI']) �� ?
	 * 
	 *
	 * @return string
	 */
	public function getRequestPathString()
	{
	    return $this->_requestPath;
	}

	
	/**
	 * ���������� ������, �������� �������� ����� ������ �������, ������� ���� ��������� "/"
	 * � ������� ��������� ���������.
	 *
	 * @return string
	 */
	public function getRequestPathArray()
	{
		$this->_explodePath();
	    return $this->_requestPathArray;
	}
	
	/**
	 * ������� ����� ��������. ��� ����������� �������� URL ���������� /.
	 *
	 * @return integer
	 */
	public function getRequestPathCount()
	{
		$this->_explodePath();
	    return count($this->_requestPathArray);
	}

	/**
	 * ������� ����� �������. ��������� � 1.
	 * ���� �����������, ���������� false.
	 *
	 * @param integer $number ���������� ����� ������� � ������ �������. ����� �������, ������ �� �����������.
	 * @param mixed $default �������� ��� ����������� �������������� �����
	 * @return unknown
	 */
	public function getCommand($number = 1, $default = false)
	{
	    $this->_explodePath();
	    if (isset($this->_requestPathArray[$number]))
	       return $this->_requestPathArray[$number];
	    else 
	       return $default;
	}

	/**
	 * ������� ����� ��������. �������� ����������� ��������� ���������� (�� ��������� _).
	 *
	 * @param integer $number_command ����� �������
	 * @param integer $number_command_part ����� ����� �������
	 * @param mixed $default �������� ������������ ��� ���������� ��������� ������
	 * @param string $separator ���������
	 * @return mixed
	 */
	public function getCommandPart($number_command = 1, $number_command_part = 1, $default = false, $separator = '_')
	{
	    
	    if (isset($this->_requestPathArrayParts[$number_command]) and $separator == $this->_lastSeparator)
	    {
	        if ($number_command_part <= 0)
	        {
	            $number_command_part = $this->_getCommandNumberMinus($number_command, $number_command_part);
	        }
	        if (isset($this->_requestPathArrayParts[$number_command][$number_command_part]))
	           return $this->_requestPathArrayParts[$number_command][$number_command_part];
	    }
	    else if (isset($this->_requestPathArray[$number_command]))
	    {
	       $this->_lastSeparator = $separator;
	       $pars = new Dune_String_Explode($this->_requestPathArray[$number_command], $separator, 1);
	       $parts = $pars->getResultArray();
	       $this->_requestPathArrayParts[$number_command] = $pars;
           if ($number_command_part <= 0)
	       {
	           $number_command_part = $this->_getCommandNumberMinus($number_command, $number_command_part);
	       }
	       
	       if (isset($pars[$number_command_part]))
	           return $pars[$number_command_part];
	    }
	    $this->_lastSeparator = $separator;
        return $default;
	}

	/**
	 * Enter description here...
	 *
	 * @param unknown_type $number_command
	 * @param unknown_type $number_command_part
	 * @return integer
	 * @access private
	 */
	protected function _getCommandNumberMinus($number_command, $number_command_part)
	{
	    $count = count($this->_requestPathArrayParts[$number_command]);
	    $mod = abs($number_command_part);
	    if ($number_command_part == 0 or ($mod > $count and $number_command_part < 0))
	    {
	        $number = $count;
	    }
	    else if ($number_command_part < 0)
	    {
	        $number = $count + 1 - $mod;
	    }
	    else 
	    {
	        $number = $number_command_part;
	    }
	    return $number;
	}
	
	
	/**
	 * ���������� ������ �������, �������� �� ������� �������.
	 * ����������� ��� ����������� ������������� �������.
	 * 
	 *
	 * @return string
	 */
	public function getCommandString($sourse = false)
	{
	    if ($sourse)
	       $array = $this->_requestPathArray;
	    else 
	       $array = $this->_requestPathArrayToModif;
	       
	    $str = '/';
	    if (count($array))
	       $str .= implode('/', $array) . '/';
	    
	    return $str;
	}
	
	/**
	 * ��������� �������� ��� ��������� ������� ������ �������.
	 * ���� ��������������� �� ��������� ������� (��������� ������������������ ���������), ���������� false.
	 *
	 * @param integer $number ���������� ����� ������� � ������ �������. ����� �������, ������ �� �����������.
	 * @param mixed $name ��� ��������
	 * @return Dune_Parsing_Parent_Url
	 */
	public function setCommand($name, $number = 0, $exeption = false)
	{
	    //$this->_explodePath();
	    $number = (int)$number;
	    if (!$number)
	    {
	        $number_array = count($this->_requestPathArrayToModif) + 1;
	        $this->_requestPathArrayToModif[$number_array] = $name;
	    }
        else if ($number > 1)
        {
            if (!isset($this->_requestPathArrayToModif[$number - 1]))
            {
                if ($exeption)
                    throw new Dune_Exception_Base('������ ��������� �������');
                $number_array = count($this->_requestPathArrayToModif) + 1;
	            $this->_requestPathArrayToModif[$number_array] = $name;
            }
            else 
                $this->_requestPathArrayToModif[$number] = $name;
        }
        return $this;
	}
	
	/**
	 * �������� ������� ������� �� ���������� ������-����������.
	 *
	 */
	public function loadCommandsFromClass()
	{
	    $this->_requestPathArrayToModif = Dune_Data_Collector_Commands::getCommands();
	}
	
	/**
	 * ����������� ������� � ��������������.
	 *
	 * @return integer
	 */
	public function count()
	{
	    return count($this->_requestPathArray);
	}
	
	/**
	 * ��������� ������������������ ������� �� ���������� �����������.
	 *
	 * @param integer $number
	 * @return Dune_Parsing_Parent_Url
	 */
	public function cutCommands($number)
	{
	    $number_array = count($this->_requestPathArrayToModif);
	    if ($number_array <= $number)
	       return $this;
	    $temp_array = array();
	    for ($x = 1; $x <= $number; $x++)
	    {
	        $temp_array[$x] = $this->_requestPathArrayToModif[$x];
	    }
	    $this->_requestPathArrayToModif = $temp_array;
	    return $this;
	}

	/**
	 * ����� ���������������� �������� �� ��������.
	 *
	 * @return Dune_Parsing_Parent_Url
	 */
	public function clearModifications()
	{
	    $this->_requestPathArrayToModif = $this->_requestPathArray;
	    return $this;
	}
	
	/**
	 * ������� ����� �������. ��������� � 1.
	 * ���� �����������, ���������� false.
	 *
	 * @param integer $number ���������� ����� ������� � ������ �������. ����� �������, ������ �� �����������.
	 * @param mixed $default �������� ��� ����������� �������������� �����
	 * @return unknown
	 */
	public function getCommandInt($number = 1, $default = 0)
	{
	    $this->_explodePath();
	    if (isset($this->_requestPathArray[$number]))
	       return (int)$this->_requestPathArray[$number];
	    else 
	       return $default;
	}
	
	/**
	 * ��������� ��������, ������������� �� ���������, ���� �������� � ����������� ���������� ������� �����������.
	 * ����� ��� ���������� ArrayAccess.
	 *
	 * @param unknown_type $value
	 */
	public function setArrayAccessDefault($value)
	{
		$this->_arrayAccessDefaultValue = $value;
	}
	
	/**
	 * ���������� ������ �� ��������.
	 * ��������� ������ ����������� � �������. ��� ��������� ������ ������� �������� �� ��������.
	 * 
	 * @access private
	 *
	 */
	protected function _explodePath()
	{
	    if (!$this->_requestPathArrayExploded)
	    {
	        $this->_requestPathArray = explode('/', $this->_requestPath);
	        $count = count($this->_requestPathArray);
	        $array = array();
	        $x = 0;
	        for($i=0; $i < $count; $i++)
            {
                if($this->_requestPathArray[$i] != '')
                {
                    $x++;
                    $array[$x] = $this->_requestPathArray[$i];
                }
            }
            $this->_requestPathArrayToModif = $this->_requestPathArray = $array;
            
	    }
	}
	
////////////////////////////////////////////////////////////////
///////////////////////////////     ���������� ������
    public function __set($name, $value)
    {
        //$this->setCommand($value, $name, true);
    }
    public function __get($name)
    {
    	$name = substr($name, 1);
	    $this->_explodePath();
	    if (isset($this->_requestPathArray[$name]))
	       return $this->_requestPathArray[$name];
	    else 
	       return false;
    }    
    
    
////////////////////////////////////////////////////////////////
///////////////////////////////     ������ ���������� ArrayAccess
    public function offsetExists($key)
    {
    	isset($this->_requestPathArray[$key]);
    }
    public function offsetGet($key)
    {
    	if (isset($this->_requestPathArray[$key]))
    	{
    		return $this->_requestPathArray[$key];
    	}
    	else 
    		return $this->_arrayAccessDefaultValue;
    }
    public function offsetSet($key, $value)
    {
        $this->setCommand($value, $key, true);
    }
    public function offsetUnset($key)
    {
    	unset($this->_requestPathArrayToModif[$key]);
    }

/////////////////////////////
////////////////////////////////////////////////////////////////
    

    ////////////////////////////////////////////////////////////////
///////////////////////////////     ������ ���������� Iterator
  // ������������� �������� �� ������ �������
  public function rewind()
  {
        return reset($this->_requestPathArray);
  }
  // ���������� ������� �������
  public function current()
  {
      return current($this->_requestPathArray);
  }
  // ���������� ���� �������� ��������
  public function key()
  {
    return key($this->_requestPathArray);
  }
  
  // ��������� � ���������� ��������
  public function next()
  {
    return next($this->_requestPathArray);
  }
  // ���������, ���������� �� ������� ������� ����� ���������� ������ rewind ��� next
  public function valid()
  {
    return isset($this->_requestPathArray[key($this->_requestPathArray)]);
  }    
/////////////////////////////
////////////////////////////////////////////////////////////////   


}