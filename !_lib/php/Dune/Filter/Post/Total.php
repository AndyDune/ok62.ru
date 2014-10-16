<?php
/**
*   ������ � �������� $_POST.
* 
* 
* ���������� �����:
*   Dune_String_Functions
* 
* ----------------------------------------------------------
* | ����������: Dune                                        |
* | ����: Total.php                                         |
* | � ����������: Dune/Filter/Post/Total.php                |
* | �����: ������ ����� (Dune) <dune@rznw.ru>               |
* | ������: 1.14                                            |
* | ����: www.rznw.ru                                       |
* ----------------------------------------------------------
* 
* ������ 
* --------------------------------------
* 
* 1.14 (2009 ������ 13)
* ������� ������������� ������� �� ������ �� ������ Dune_String_Functions.
* 
* 1.13 (2009 ������ 23)
* ��� set-������� ����������� ����������� ���������� "�������";
* 
* 1.12 (2009 ������ 16)
* ��������� ����������� ��������� ������������ ������� $_POST
* 
* 1.11 (2008 ������� 26)
* ���� ����� setResultCharset($charset) �������� ������������ ��� ������� ������ � ������ $_POST. ����� ��������� � win-1251.
* 
* 1.10 (2008 ������� 25)
* ���� ����� setIconv($in_charset, $out_charset) �������� ������������ ��� ������� ������ � ������ $_POST.
* ��������� ���c����� � ����������������� �����������
* 
* 1.09 (2008 ������� 02)
* ����������� ��������� �������� ��������� ������� $_POST ��� �������� ArrayAccess,Iterator
* ���������� ���������� Countable.
* 
* 1.08 (2008 ������ 07)
* ��������� �������� ��������� ���������� �� ������� �������� htmlspecialchars()
* 
* 1.07 (2008 ������� 24)
* �������� ����� __toString. �������� ������ ������� $_POST
* 
* 1.06 (2008 ������� 21)
* ������� ����� getDigit() - ������� �������, ������� � �����.
* 
* 1.05 (2008 ������� 16)
* �������� ����� trim - ���������� ������� trim �� ���� ��������� �������.
* ��� ������ �������-�������� trim �� ����������� (������������ trim ��� ����� �������).
* ����� ����� getNoSpaces()
* ������� ����� getFloat() - ������� �������.
* 
* ������ 1.03 -> 1.04 (2008 �������� 25)
* -------------------------------------
* �������� ������������ �� ������ �������� � �������.
* ���. ����� setLength()
* 
* ������ 1.02 -> 1.03 (2008 ������ 30)
* ----------------------
* ����� ����� getFloat()
* 
* ������ 1.01 -> 1.02 (2008 ������ 29)
* ----------------------
* ��������� ������ � getHtmlSpecialChars
* 
* ������ 1.00 -> 1.01
* ----------------------
* ��������� ��������� ����������� ArrayAccess � Iterator
* 
*/

class Dune_Filter_Post_Total implements ArrayAccess,Iterator, Countable
{

	protected $_default = '';
	protected $_noTrimmed = true;
	
    static private $instance = null;
    
  	protected $_lendth = 0; // ���� - ����� ������ �� ���������������

  	protected $_htmlSpecialChars = false;

  	
    /**
     * ��������� ������ - ���������
     *
     * @var string
     * @access private
     */
    protected $_encodingSourse = 'windows-1251';
    
    /**
     * ��������� ������ - ����������
     *
     * @var string
     * @access private
     */
    protected $_encoding = 'windows-1251';
    
    protected $_charset = false;
  	
  	
    const ENC_WINDOWS1251 = 'windows-1251';
    const ENC_UTF8 = 'UTF-8';
  	
  	
    /**
    * ���������� ������ �� ������
    *
    * @param mixed $def �������� �� ���������
    * @return Dune_Filter_Post_Total
    */
    static function getInstance($def = '')
    {
        if (is_null(self::$instance))
        {
            self::$instance = new Dune_Filter_Post_Total($def);
        }
        return self::$instance;
    }
    
    protected function __construct($def)
    {
    	$this->_default = $def;
    }
    
    public function setIconv($in_charset, $out_charset)
    {
        $this->_encodingSourse = $in_charset;
        $this->_encoding = $out_charset;
        return $this;
    }

    /**
     * ��������� ��������� � ������� ����� ������������� ������ �� ����� �� ���������: windows-1251, koi-8r, utf-8
     *
     * @param string $charset
     */
    public function setResultCharset($charset = 'windows-1251')
    {
        $this->_charset = $charset;
        return $this;
    }
    
    /**
     * ��������� ������� trim � ���� ���������-������� ������� $_POST.
     *
     */
    public function trim()
    {
        if ($this->_noTrimmed)
        {
            foreach ($_POST as $key => $value)
            {
                $_POST[$key] = $this->_trim($value);
            }
            $this->_noTrimmed = false;
        }
        return $this;
    }
    
    protected function _trim($value)
    {
    	if (is_array($value))
    	{
    	    foreach ($value as $key => $value_run)
    	    {
    		    $value[$key] =  $this->_trim($value_run);
    	    }
    	}
    	else if (is_string($value))
    	{
    		$value =  trim($value);
    	}
    	return $value;
    }
    
    
    /**
     * ��������� ����� �������� �� ���������
     *
     * @param mixed $value
     */
    public function setDefault($value)
    {
    	$this->_default = $value;
    	return $this;
    }
    
    
    public function get($is_container = false)
    {
        if ($is_container)
            return new Dune_Array_Container($_POST);
        else 
            return $_POST;
    }
    
    /**
     * ��������� �������� � ������� $_POST � ��������� ���.
     * ������ - ����� �����.
     * ��� ���������� ����� � ������� - �������� �� ��������� $default
     *
     * @param string $name
     * @param integer $default
     * @return integer
     */
    public function getDigit($name, $default = 0, $maxLength = 10)
    {
    	if (isset($_POST[$name]))
    	{
//    		$value = substr($_POST[$name], 0, $maxLength);
    		return $this->_getDigit($_POST[$name], $default, $maxLength);
    	}
    	else 
    		return $default;
    }

    protected function _getDigit($value, $default, $maxLength)
    {
    	if (is_array($value))
    	{
    	    foreach ($value as $key => $value_run)
    	    {
    		    $value[$key] =  $this->_getDigit($value_run, $default, $maxLength);
    	    }
    	}
    	else 
    	{
    		$value =  Dune_String_Functions::sub($value, 0, $maxLength);
    		$value = (int)str_replace(array('.', ',', ' '), '', $value);
    	}
    	return $value;
    }
    
    
    /**
     * ��������� �������� � ������� $_POST � ��������� ���.
     * ������ - ������� �����. ! ������� �������������� � �����.
     * ��� ���������� ����� � ������� - �������� �� ��������� $default
     *
     * @param string $name
     * @param integer $default
     * @return integer
     */
    public function getFloat($name, $default = 0, $maxLength = 10)
    {
    	if (isset($_POST[$name]))
    	{
//    		$value = substr($_POST[$name], 0, $maxLength);
//    		return (float)str_replace(array(',', ' '), array('.', ''), $value);
    		return $this->_getFloat($_POST[$name], $default, $maxLength);
    	}
    	else 
    		return $default;
    }
    
    protected function _getFloat($value, $default, $maxLength)
    {
    	if (is_array($value))
    	{
    	    foreach ($value as $key => $value_run)
    	    {
    		    $value[$key] =  $this->_getFloat($value_run, $default, $maxLength);
    	    }
    	}
    	else 
    	{
    		$str = Dune_String_Factory::getStringContainer($value);
    		$value = $str->substr(0, $maxLength);
    		$value = (float)str_replace(array(',', ' '), array('.', ''), $value);
    	}
    	return $value;
    }
    

    /**
     * ��������� �������� � ������� $_POST � ��������� ���.
     * ������� ��� ��������. ����� ����� ��� ����������� �������������� �����.
     * ��� ���������� ����� � ������� - �������� �� ��������� $default
     *
     * @param string $name
     * @param integer $default
     * @return integer
     */
    public function getNoSpaces($name, $default = '', $maxLength = 10)
    {
    	if (isset($_POST[$name]))
    	{
    		$value = Dune_String_Functions::sub($_POST[$name], 0, $maxLength);
    		return str_replace(' ', '', $value);
    	}
    	else 
    		return $default;
    }
    
    
    
    /**
     * ��������� �������� � ������� $_POST � ��������� ���.
     * ������ - ������� htmlspecialchars().
     * ��� ���������� ����� � ������� - �������� �� ��������� $default
     *
     * @param string $name
     * @param string $default
     * @return string
     */
    public function getHtmlSpecialChars($name, $default = '', $maxLength = 10000)
    {
    	if (isset($_POST[$name]))
    		return $this->_getHtmlSpecialChars($_POST[$name], $default, $maxLength);
    	else 
    		return $default;
    }
    
    
    protected function _getHtmlSpecialChars($value, $default, $maxLength)
    {
    	if (is_array($value))
    	{
    	    foreach ($value as $key => $value_run)
    	    {
    		    $value[$key] =  $this->_getHtmlSpecialChars($value_run, $default, $maxLength);
    	    }
    	}
    	else 
    	{
    		$value =  htmlspecialchars(substr($value, 0, $maxLength));;
    	}
    	return $value;
    }
    
    
    
    /**
     * �������� ������������� �����
     *
     * @param string $name
     * @return boolean
     */
    public function have($name)
    {
    	return isset($_POST[$name]);
    }
    
    /**
     * �������� ������������� �����
     *
     * @param string $name
     * @return boolean
     */
    public function check($name)
    {
    	return isset($_POST[$name]) and ((string)$_POST[$name] != '');
    }
    
    
    /**
     * ��������� �������� ���������� ������ ������� ������.
     * ������������ � ���������� ������ __get()
     *
     * @param integer $value ����. ����� ������. 0 - ���� �� ����������������.
     */
    public function setLength($value = 0)
    {
        $this->_lendth = $value;
        return $this;
    }
    
    public function htmlSpecialChars($value = true)
    {
        $this->_htmlSpecialChars = $value;
        return $this;
    }
    
    
////////////////////////////////////////////////////////////////
///////////////////////////////     ���������� ������
    public function __set($name, $value)
    {
        $_POST[$name] = $value;
    }
    public function __get($name)
    {
        if (isset($_POST[$name]))
        {
            $str = $this->_filter($_POST[$name]);
        }
        else 
           $str = $this->_default;
        return $str;
    }    
    
    public function __toString()
    {
    	$string = '<pre>';
    	ob_start();
    	print_r($_POST);
    	$string .= ob_get_clean();
    	return  $string . '</pre>';
    }
    
    
////////////////////////////////////////////////////////////////
///////////////////////////////     ����� ���������� Countable
    public function count()
    {
        return count($_POST);
    }
    
    
////////////////////////////////////////////////////////////////
///////////////////////////////     ������ ���������� Iterator
  // ������������� �������� �� ������ �������
  public function rewind()
  {
        return reset($_POST);
  }
  // ���������� ������� �������
  public function current()
  {
      //return current($_POST);
      return $this->__get(key($_POST));
  }
  // ���������� ���� �������� ��������
  public function key()
  {
    return key($_POST);
  }
  
  // ��������� � ���������� ��������
  public function next()
  {
    return next($_POST);
  }
  // ���������, ���������� �� ������� ������� ����� ���������� ������ rewind ��� next
  public function valid()
  {
//    return isset($_POST[key($_POST)]);
    return key_exists(key($_POST), $_POST);

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
        return isset($_POST[$key]);
    }
    public function offsetGet($key)
    {
        return $this->__get($key);
        
/*     
        if (isset($_POST[$key]))
        {
            return $_POST[$key];
        }
        else 
           return $this->_default;
*/ 
    }
    
    public function offsetSet($key, $value)
    {
        $_POST[$key] = $value;
    }
    public function offsetUnset($key)
    {
        unset($_POST[$key]);
    }    
    
////////////////////////////////////////////////////////////////
///////////////////////////////     ���������� ������
    protected function _filter($value)
    {
        $str = $value;
        if (is_array($str))
        {
            foreach ($str as $key => $value)
            {
                $str[$key] = $this->_filter($value);
            }
        }
        else 
        {
            if ($this->_charset)
            {
                $obj = new Dune_String_Charset_Convert($str);
                if ($this->_charset == 'windows-1251')
                {
                    $str = $obj->getWindows1251();
                }
             }
             if ($this->_encodingSourse != $this->_encoding)
             {
                $str_new = @iconv($this->_encodingSourse, $this->_encoding, $str);
                $str = $str_new;
             }
                    
             if ($this->_lendth)
                $str = substr($str, 0, $this->_lendth);
                    
             if ($this->_htmlSpecialChars)
                $str = htmlspecialchars($str);
        }   
        return $str;
    }
    
}
