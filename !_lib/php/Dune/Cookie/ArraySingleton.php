<?php
/**
 * Dune Framework
 * 
 * ����� ��� ������ � ����� ������� cookie ��� � ��������.
 * ��������� ����� ����� ��� ������ � �������
 * ��������� ArrayAccess 
 * 
 * ----------------------------------------------------
 * | ����������: Dune                                  |
 * | ����: ArraySingleton.php                          |
 * | � ����������: Dune/Cookie/ArraySingleton.php      |
 * | �����: ������ ����� (Dune) <dune@rznw.ru>         |
 * | ������: 1.08                                      |
 * | ����: www.rznw.ru                                 |
 * ----------------------------------------------------
 *
 * ������� ������:
 * -----------------
 * 
 * ������ 1.08 (2008 ������ 12)
 * ��������� ���������� ������ __isset() � __unset()
 * 
 * ������ 1.07 (2008 ������ 10)
 * ���������� ������ ��� ����������� ������.
 * 
 * ������ 1.05 -> 1.06
 * ���������� ������ ���������.
 * 
 * ������ 1.04 -> 1.05
 * �������� ��������.
 * ���� ����������� ������ ���������.
 * ��������� ������: getArray(), count()
 * 
 * 
 * ������ 1.03 -> 1.04
 * ���������: $hours � $domain � ����� ������ �������� ������������� - 
 * 
 * ������ 1.02 -> 1.03
 * ������ ����� ������ (��������� ������ ���� - ��������, ������ � ������ �����, )
 * 
 * ������ 1.01 -> 1.02
 * ��������� �������� ��������� �������. ������ ���������� ��� ����������� �������� ������� �� ������.
 * ������� ������� ���������� ��� ������ �������-������������� ��������.
 * ��� ������ ���. � ��� �����. �����������: $this->cookieExists AND $this->isArray
 * 
 * ������ 1.00 -> 1.01
 * �������� ������� ��������� ��������. ���������� � ������, ����� �� �������� - ��� ������ ������
 * 
 * 
 */

class Dune_Cookie_ArraySingleton extends Dune_Cookie_Parent_Base implements ArrayAccess, Dune_Interface_BeforePageOut, Iterator 
{
    /**
     * ��� ������-�������
     *
     * @var string
     * @access private
     */
    protected $cookieName;
    
    /**
     * ���� ��������� ������
     *
     * @var boolean
     * @access private
     */
    protected $cookieExists = false;
    
    /**
     * ���� ����������� ���������� ������
     *
     * @var boolean
     * @access private
     */
    protected $isArray = false;
    
    /**
     * ���� �������� �������. true - ���������
     *
     * @var boolean
     * @access private
     */
    static public $cryptCookie = false;
    
    /**
     * ���� ������� ������ doBeforePageOut()
     *
     * @var boolean
     * @access private
     */
    protected $doneBeforePageOut = false;
    
    /**
     * ����������� �����������
     *
     * @var array
     * @access private
     */
    static private $instance = array();   
     
   /**
    * ������ ���������� ������ ��� ������ ������
    * ���������� ���������� ��������� ������� ��� ����������� �������
    *
    * @param string $fileName
    * @return Dune_Cookie_ArraySingleton
    */
    static function getInstance($name, $hours = null, $domain = null, $path = "/", $secure = 0)
    {
        if (!key_exists($name, self::$instance))
        {
            if ($hours == null)
                $hours = Dune_Parameters::$cookieLifeTime;
            if ($domain == null)
                $domain = Dune_Parameters::$cookieSiteDomain;
            
            self::$instance[$name] = new Dune_Cookie_ArraySingleton($name, $hours, $domain, $path, $secure);
        }
        return self::$instance[$name];
    }

    
        
    protected function __construct($name, $hours, $domain, $path, $secure)
    {
        // ������� ���� ���������� ������ � ����� ��������
        self::$cryptCookie = Dune_Parameters::$cookieMcript;

        $this->cookieName = $name;
        if (key_exists($name,$_COOKIE))
        {
            $this->cookieExists = true;
            if (self::$cryptCookie)
            {
                $this->getCryptCookie();
            }
            else 
            {
                $this->getCookie();
            }
            //$this->cookieExists = $this->isArray;
        }
        parent::__construct($hours, $domain, $path, $secure);  
     }
    
    
    /**
     * �������� ������������� ������. ���� ���� ��������������� �� �������
     *
     * @param string $name ��� ������
     * @return boolean
     */
    public function isExist()
    {
        return $this->cookieExists;
    }

    
    /**
     * �������� ����������� ���������� ������
     *
     * @param string $name ��� ������
     * @return boolean
     */
    public function isCorrect()
    {
        return $this->isArray;
    }

    /**
     * ���������� ��������� � ������� �� ������.
     *
     */
    public function count()
    {
        return count($this->cookieArray);
    }

    /**
     * ������ ����� �������
     *
     */
    public function getArray()
    {
        return $this->cookieArray;
    }
    
    
    /**
     * �������� ������
     *
     */
    public function clear()
    {
        // ���������� �����
        setcookie($this->cookieName, '', 0, $this->path, $this->domain, $this->secure);
        // ������� ������ ���������� ������
        //setcookie($this->cookieName);
        $this->isArray = false;
        $this->cookieArray = array();
        $this->cookieExists = false;
    }
    /**
     * ��������� ������-�������
     *
     */
    public function set()
    {
        if (self::$cryptCookie)
        {
            $this->setCryptCookie();
        }
        else 
        {
            $this->setCookie();
        }
    }

    /**
     * ���������� ������ ���������� Dune_Interface_BeforePageOut.
     * 
     * �������� ����� ������ �������, ����� ������� ��������.
     *
     */
    public function doBeforePageOut()
    {
        // ���� ������ ���� � ���������� ���������� 1-� ���
        if (!$this->doneBeforePageOut)
        {
            $this->set();
            $this->doneBeforePageOut = true;
        }
    }
///////////////////////////////////////////////////////////////
////////////        �������� ������    
    protected function getCookie()
    {
        $str_array = urldecode($_COOKIE[$this->cookieName]);
        $this->cookieArray = @unserialize($str_array);
        if (is_array($this->cookieArray))
            $this->isArray = true;
        else 
            $this->cookieArray = array();
    }
    
    protected function getCryptCookie()
    {
        $str_array = Dune_Encrypt_McryptCookie::decrypt(urldecode($_COOKIE[$this->cookieName]));
        $this->cookieArray = @unserialize($str_array);
        if (is_array($this->cookieArray))
            $this->isArray = true;
        else 
            $this->cookieArray = array();
    }
    
    protected function setCryptCookie()
    {
        if (count($this->cookieArray) > 0)
        {
            $str_array = serialize($this->cookieArray);
            $str_array = urlencode(Dune_Encrypt_McryptCookie::encrypt($str_array));
            setcookie($this->cookieName, $str_array, $this->expires, $this->path, $this->domain, $this->secure);        
        }
        else 
        {
            $this->clear();
        }
    }
    protected function setCookie()
    {
        if (count($this->cookieArray) > 0)
        {
            $str_array = urlencode(serialize($this->cookieArray));
            setcookie($this->cookieName, $str_array, $this->expires, $this->path, $this->domain, $this->secure);
        }
        else 
        {
            $this->clear();
        }
    }
    
////////////////////////////////////////////////////////////////
///////////////////////////////     ���������� ������

    public function __toString()
    {
    	$string = '<pre>';
    	ob_start();
    	print_r($this->cookieArray);
    	$string .= ob_get_clean();
    	return  '</pre>' . $string;
    }


    /**
     * ��������� isset() ����������� � PHP 5.1
     *
     * @param string $name
     * @return boolean
     */
    public function __isset($name)
    {
        return isset($this->cookieArray[$name]);
    }

    /**
     * ��������� unset() ����������� � PHP 5.1
     *
     * @param  string $name
     * @return void
     */
    public function __unset($name)
    {
        unset($this->cookieArray[$name]);
    }
    
    
    public function __set($name, $value)
    {
        $this->cookieArray[$name] = $value;
    }
    public function __get($name)
    {
        if (!key_exists($name,$this->cookieArray))
            return false;
        return $this->cookieArray[$name];
    }
/////////////////////////////
////////////////////////////////////////////////////////////////
    
    
////////////////////////////////////////////////////////////////
///////////////////////////////     ������ ���������� ArrayAccess
    public function offsetExists($key)
    {
        return key_exists($key,$this->cookieArray);
    }
    public function offsetGet($key)
    {
        if (!key_exists($key,$this->cookieArray))
            //throw new Exception('������ ������ �������� �������: ����� '.$key.' �� ����������');
            return false;
        return $this->cookieArray[$key];
    }
    
    public function offsetSet($key, $value)
    {
        $this->cookieArray[$key] = $value;
    }
    public function offsetUnset($key)
    {
        unset($this->cookieArray[$key]);
    }

/////////////////////////////
////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////
///////////////////////////////     ������ ���������� Iterator
  // ������������� �������� �� ������ �������
  public function rewind()
  {
        return reset($this->cookieArray);
  }
  // ���������� ������� �������
  public function current()
  {
      return current($this->cookieArray);
  }
  // ���������� ���� �������� ��������
  public function key()
  {
    return key($this->cookieArray);
  }
  
  // ��������� � ���������� ��������
  public function next()
  {
    return next($this->cookieArray);
  }
  // ���������, ���������� �� ������� ������� ����� ���������� ������ rewind ��� next
  public function valid()
  {
    return isset($this->cookieArray[key($this->cookieArray)]);
  }    
/////////////////////////////
////////////////////////////////////////////////////////////////    
    
    
}