<?php
/**
 * Dune Framework
 * 
 * ��������� ������. �������-������� ��� ������������.
 * ����: ����������� �������� ������� �� utf-8.
 * � ����������� ������� �� php6.
 * ��� ��������� ������� � �������� ����� ���� �����.
 * 
 * ----------------------------------------------------
 * | ����������: Dune                                  |
 * | ����: Container.php                               |
 * | � ����������: Dune/String/Container.php           |
 * | �����: ������ ����� (Dune) <dune@rznw.ru>         |
 * | ������: 0.94                                      |
 * | ����: www.rznw.ru                                 |
 * ----------------------------------------------------
 *
 * ������� ������:
 *
 *  0.94 (2009 ���� 28)
 *  �������� ucfirst()
 * 
 *  0.93 (2009 ������ 28)
 *  ����� ������ tolower() � toupper().
 *  
 *  0.92 (2009 ������ 27)
 *  ����� ����� setString(). ����� ������������ ��� �������� ������.
 * 
 *  0.90 (2009 ������ 06)
 *  ��������� �� ��� �������.
 * 
 *  0.91 (2009 ������ 13)
 *  �������� �������: rpos -> posr, istr -> stri.
 * 
 */

class Dune_String_Container implements Dune_String_Interface_Container
{
    /**
     * ������.
     *
     * @var string
     */
	protected $_string = '';
	
	public function __construct($string = '')
	{
	    $this->_string = (string)$string;
	}

	/**
	 * ��������� �������������� ������.
	 *
	 * @param tring $string
	 */
	public function setString($string)
	{
	    $this->_string = (string)$string;
	    return $this;
	}
	
	
	/**
	 * ��������� �����.
	 *
	 * @param string $str ���������� � ���� string.
	 * @param  $min ����������� ����� �������� � ������.
	 * @return boolean
	 */
	public function equal($str, $min = 0)
	{
	    $str = (string)$str;
	    if ($min)
	    {
	        if ($this->lenlocal($str) >= $min and $this->_string === $str)
	           return true;
	    }
	    else 
	    {
	        if ($this->_string == $str)
	           return true;
	    }
	    return false;
	}
	
	/**
	 * ����� ������.
	 *
	 * @return integer
	 */
	public function len()
	{
	    return $this->lenlocal($this->_string);
	}
	
	/**
	 * ��� ���������� ����.
	 *
	 * @param string $string
	 * @return integer
	 */
	protected function lenlocal($string)
	{
	    return strlen($string);
	}
	
	/**
	 * ���������� �������� ������� ������� ��������� $string.
	 *
	 * @param string $string
	 * @param integer $offset
	 * @return mixed
	 */
	public function pos($string, $offset = 0)
	{
	    return strpos($this->string, $string, $offset);
	}

	/**
	 * ���������� �������� ������� ���������� ��������� $string.
	 *
	 * @param string $string
	 * @param integer $offset 
	 * @return mixed
	 */
	public function posr($string, $offset = null)
	{
	    return strrpos($this->string, $string, $offset);
	}
	
	/**
	 * ���������� ����� ������ haystack �� ������� ��������� needle �� ����� haystack.
     *
     * ���� needle �� ������, ���������� FALSE.
     * ���� needle �� ������, �� �������������� � integer � ����������� ��� ���������� �������� �������.
	 *
	 * @param unknown_type $string
	 * @return unknown
	 */
	public function str($string)
	{
	    return strstr($this->_string, $string);
	}

	/**
	 *  ����� str() ��� ����� ��������.
	 *
	 * @param unknown_type $string
	 * @return unknown
	 */
	public function stri($string)
	{
	    return stristr($this->_string, $string);
	}
	
	/**
	 * ���������� ����� ������.
	 * 
	 * ���� start �������������, ������������ ������ ���������� �� start'����� �������, ������ �� ����� ������ string.
	 * 
	 * ���� length ����� � �������������, ������������ ������ ����� ��������� �������� length ��������,
	 *  ������� �� start (� ����������� �� ����� ������ string. ���� string ������ start, ������������ FALSE).
     *
     * ���� length ����� � ����������, �� ��� ���������� �������� ����� ���������,
     *  ������� � ����� string (����� ���������� ��������� �������, ����� start ����������). ���� start ����� ������� �� ��������� ����� ��������, ������������ ������ ������.
	 *
	 * @param integer $start ���� start �������������, ������������ ������ ���������� �� start'����� �������, ������ �� ����� ������ string.
	 * @param integer $length
	 * @return string
	 */
	public function substr($start, $length = null)
	{
	    return substr($this->_string, $start, $length);
	}
	
	
	public function trim($charlist = '')
	{
	    return trim($this->_string, $charlist);
	}
	public function trimr($charlist = '')
	{
	    return rtrim($this->_string, $charlist);
	}
	
	public function triml($charlist = '')
	{
	    return ltrim($this->_string, $charlist);
	}
	
	
	public function tolower()
	{
	    return strtolower($this->_string);
	}
	public function toupper()
	{
	    return strtoupper($this->_string);
	}
	
	
	public function ucfirst()
	{
	    $string = $this->_string;
	    $string = ucfirst($string);
	    return $string;
	}
	
	
	
////////////////////////////////////////////////////////////////////
////////        ���������� ������	

	// ������ ������ - ����������.
    public function __toString()
    {
    	return  $this->_string;
    }
	
	
}

