<?php
/**
 * Dune Framework
 * 
 * ��������� ������. �������-������� ��� ������������.
 * 
 * ----------------------------------------------------
 * | ����������: Dune                                  |
 * | ����: ContainerMB.php                             |
 * | � ����������: Dune/String/ContainerMB.php         |
 * | �����: ������ ����� (Dune) <dune@rznw.ru>         |
 * | ������: 0.93                                      |
 * | ����: www.rznw.ru                                 |
 * ----------------------------------------------------
 *
 *
 *  0.93 (2009 ���� 28)
 *  �������� ucfirst()
 * 
 *  0.92 (2009 ������ 28)
 *  ����� ������ tolower() � toupper().
 *  
 *  0.91 (2009 ������ 27)
 *  ����� ����� setString(). ����� ������������ ��� �������� ������.
 * 
 */

class Dune_String_ContainerMB implements Dune_String_Interface_Container
{
    /**
     * ������.
     *
     * @var string
     */
	protected $_string = '';
	protected $_charset = null;
	
	public function __construct($string = '', $charset = null)
	{
	    $this->_result = $this->_string = (string)$string;
	    $this->_charset = $charset;
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
	    return mb_strlen($string, $this->_charset);
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
	    return mb_strpos($this->string, $string, $offset, $this->_charset);
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
	    return mb_strrpos($this->string, $string, $offset, $this->_charset);
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
	    return mb_strstr($this->_string, $string, null, $this->_charset);
	}

	/**
	 *  ����� str() ��� ����� ��������.
	 *
	 * @param unknown_type $string
	 * @return unknown
	 */
	public function stri($string)
	{
	    return mb_stristr($this->_string, $string, null, $this->_charset);
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
	    return mb_substr($this->_string, $start, $length, $this->_charset);
	}
	
	
	public function trim($charlist = '')
	{
        if($charlist == '') return trim($this->_string);
        return $this->triml($this->trimr($this->_string));
	}
	
	public function trimr($charlist = '')
	{
        if($charlist == '') return rtrim($this->_string);
        //quote charlist for use in a characterclass
        $charlist = preg_replace('!([\\\\\\-\\]\\[/])!', '\\\$1}', $charlist);
        return preg_replace('/[' . $charlist . ']+$/u','', $this->_string);

	}
	
	public function triml($charlist = '')
	{
        if($charlist == '') return ltrim($this->_string);
        //quote charlist for use in a characterclass
        $charlist = preg_replace('!([\\\\\\-\\]\\[/])!','\\\$1}',$charlist);
        return preg_replace('/^[' . $charlist . ']+/u', '', $this->_string);
	}
	
	
	public function tolower()
	{
	    return mb_strtolower($this->_string, $this->_charset);
	}
	public function toupper()
	{
	    return mb_strtoupper($this->_string, $this->_charset);
	}
	

	public function ucfirst()
	{
	    $string = $this->_string;
	    $string = mb_strtoupper(mb_substr($string, 0, 1, $this->_charset), $this->_charset).mb_substr($string, 1, mb_strlen($string), $this->_charset);
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

