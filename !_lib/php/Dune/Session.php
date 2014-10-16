<?php
/**
 * Dune Framework
 * 
 * ����� - �������� ��� ������ � �������.
 * 
 * ----------------------------------------------------
 * | ����������: Dune                                  |
 * | ����: Session.php                                 |
 * | � ����������: Dune/Session.php                    |
 * | �����: ������ ����� (Dune) <dune@rznw.ru>         |
 * | ������: 1.11                                      |
 * | ����: www.rznw.ru                                 |
 * ----------------------------------------------------
 * 
 * 
 * ������� ������:
 * -----------------
 * 
 * 1.11 (2009 ���� 26)
 * ����� �������� ����� ���� ������.
 * 
 * 1.10 (2009 ������� 18)
 * ������� ����� ��������� �������������� ������.
 * 
 * 1.09 (2008 ������� 09)
 * ����� ����� clearZone(). ���������� ������� ������ ������� �������. ������ killZone().
 * 
 * 1.08 (2008 ������� 05)
 * �������� ����� getInt() - ������� ����� ���� integer. ������� �������.
 * ��������� ���������� ���������� Countable. ����������� ��������� � ����.
 * 
 * 1.07 (2008 ������ 05)
 * ��������� �����. ������ __isset � __unset ��� ������� ����.
 * 
 * 1.06 (2008 ������� 21)
 * �������� ����� getFloat() - ������� ����� ���� float. ������� �������, �������� ������� �� �����.
 * 
 * 1.05 (9 ������� 2008)
 * ���������� ���� � ������.
 * 
 * 1.04 (8 ������� 2008)
 * ��������� ���� �� ����� ������ ����������.
 * �������� �������� �� �������������� ������.
 * ������������ ��� �� ��� ���������� ������.
 * 
 * 1.02 -> 1.03 (2 �������� 2008)
 * �������������� ������ ������ ������� ������� �� �������� ������.
 * ����� setZone() - �����.
 * 
 * 1.01 -> 1.02 (1 �������� 2008)
 * ������� ��������� ������������� �������� ������� ���������.
 * ����� getZone().
 * 
 * 1.00 -> 1.01 (29 ������� 2008)
 * �������� ����� _toString() - �������� ������ ������� ������� �������.
 * 
 * 0.97 -> 1.00 (28 ������� 2008)
 * ��������� ���������� ���������� Iterator
 * 
 * 0.96 -> 0.97
 * ��������� ��������� ZONE_CAPTCHA
 * 
 * 0.95 -> 0.96
 * �������� ��������� ���������� $auth - ��������� �������������� ������
 * 
 *
 */

class Dune_Session implements Iterator, ArrayAccess, Countable
{
   /**
    * ������������ � ������ ������ ����
    * 
    * @var string
    * @access private
    */
    private $_usingZone = 'default___';
    
    /**
     * ��������� ���������� � ������������ ���������.
     *
     * @var string
     * @access private
     */
    protected $_lokingZoneName = '_lkLK_';
    
    static public $auth = false;
    
   /**
    * ����. ��� ������ ������ ����. ������ � ������������ ��� �����������
    *
    * @var Dune_Session
    * @access private
    */
    static private $instance = NULL;
 
    
    const ZONE_AUTH             = 'auth____';
    const ZONE_MESSAGE          = 'message____';    
    const ZONE_CAPTCHA          = 'captcha____';    
    const ZONE_DEFAULT          = 'default____';    
    
  
/////////////////////////////////////////////////////////////////////
//////////////////////////////      ��������� ������    
  /**
   * ������ ���������� ������ ��� ������ ������
   * ���������� ���������� ��������� ������� ��� ����������� �������
   *
   * �������� ��������� �� ������ � ���������� �����������
   * 
   * @param string $zone ��� ����. ���� �� ������� - ���� �� ���������
   * @param string $name ��� �������������� ������
   * @return Dune_Session
   */
    static public function getInstance($zone = null, $name = 'sesID')
    {
        if (self::$instance == NULL)
        {
            self::$instance = new Dune_Session($name);
        }
        if ($zone != null)
            self::$instance->openZone($zone);
        else 
            self::$instance->openZone(Dune_Session::ZONE_DEFAULT);
        return self::$instance;
    }

    /**
     * �������� ������ ������
     * true - ������ �������
     *
     * @return boolean
     */
    static public function started()
    {
        if (self::$instance == null)
        {
            $bool = false;
        }
        else 
        {
            $bool = true;
        }
        return $bool;
    }
    
    /**
     * ��������� �������������� ������.
     * �������� �� ������ ������-�������.
     *
     * @param string $id
     */
    static function setId($id)
    {
        if (self::$instance != NULL)
        {
            session_id($id);
        }
    }
    
/////////////////////////////////////////////////////////////////////
//////////////////////////////      ��������� ������
    
    
    /**
     * ��������� ���� � ������������ ������
     *
     * @param string $zone
     */
    public function openZone($zone)
    {
        $this->_usingZone = $zone;
        if (!isset($_SESSION[$this->_usingZone]))
        {
            $_SESSION[$this->_usingZone] = array();
        }
        
    }
    
    /**
     * ��������� ���� � ������������ ������, �������� ���� �� ���������.
     * 
     */
    public function closeZone()
    {
        $this->_usingZone = self::ZONE_DEFAULT;
    }
    
    /**
     * ������������ ������� ���� �� ������ ��� ��������.
     * ��������� �� ��� ���������� �����.
     * 
     * @param string $key ���������� ����
     */
    public function lockZone($key = false)
    {
        $_SESSION[$this->_lokingZoneName][$this->_usingZone] = $key;
    }

    /**
     * ������������ ���� ��� ������ ��� ��������.
     * ��������� �� ��� ���������� �����.
     * 
     *  @param string $key ���������� ����. ���� �� ������ - ������������� �� ����������
     */
    public function unlockZone($key = false)
    {
        if (
              isset($_SESSION[$this->_lokingZoneName][$this->_usingZone]) 
              and ($_SESSION[$this->_lokingZoneName][$this->_usingZone] == $key)
           )
        unset($_SESSION[$this->_lokingZoneName][$this->_usingZone]);
    }

    
    /**
     * ����������� ���� ���������� ����.
     * 
     */
    public function killZone()
    {
        $this->_canEditZone();
        unset($_SESSION[$this->_usingZone]);
    }
    
    /**
     * ����������� �������� = array()
     */
    public function clearZone()
    {
        $this->_canEditZone();
        $_SESSION[$this->_usingZone] = array();
    }

    
    /**
     * ����������� ������
     */
    public function destroy()
    {
        self::$auth = false;        
        unset($_SESSION);
        session_destroy();
    }

    /**
     * ��������� ������� ����� - ���������� ������
     */
    public function end()
    {
        session_commit();
    }
    
    /**
     * ���������� ������������� ������
     */
    public function getId()
    {
        return session_id();
    }

    /**
     * ���������� ���� ������ �������.
     */
    public function getZone($array_container = false)
    {
        if ($array_container)
            return new Dune_Array_Container($_SESSION[$this->_usingZone]);
        return $_SESSION[$this->_usingZone];
    }

    /**
     * ��������� ���� ����
     */
    public function setZone($array = array())
    {
        $this->_canEditZone();
        $_SESSION[$this->_usingZone] = $array;
    }

    /**
     * ��� ������� ����.
     */
    public function getZoneName()
    {
        return $this->_usingZone;
    }
    
    /**
     * ��������� �������� � ������� ������� ���� $_SESSION � ��������� ���.
     * ������ - ������� �����. ! ������� �������������� � �����.
     * ��� ���������� ����� � ������� - �������� �� ��������� $default
     *
     * @param string $name
     * @param integer $default
     * @return float
     */
    public function getFloat($name, $default = 0)
    {
    	if (isset($_SESSION[$this->_usingZone][$name]))
    	{
    		return (float)str_replace(array(',', ' '), array('.', ''), $_SESSION[$this->_usingZone][$name]);
    	}
    	else 
    	{
    		return $default;
    	}
    }
    /**
     * ��������� �������� � ������� ������� ���� $_SESSION � ��������� ���.
     * ������ - ����� �����. ! ������� ���������
     * ��� ���������� ����� � ������� - �������� �� ��������� $default
     *
     * @param string $name
     * @param integer $default
     * @return integer
     */
    public function getInt($name, $default = 0)
    {
    	if (isset($_SESSION[$this->_usingZone][$name]))
    	{
    		return (int)str_replace(array(' '), array(''), $_SESSION[$this->_usingZone][$name]);
    	}
    	else 
    	{
    		return $default;
    	}
    }
    
    
/////////////////////////////////////////////////////////////////////
//////////////////////////////      ��������� ������    

    /**
     * �������� �� ��������� ���� � ������ ���������������.
     * ���������� ���� �������������.
     *
     * @access private
     * @return boolean
     */
    private function _canEditZone()
    {
        if (empty($_SESSION[$this->_lokingZoneName]))
            return true;
        if (key_exists($this->_usingZone, $_SESSION[$this->_lokingZoneName]))
        {
            throw new Dune_Exception_Base('������� �������������� ��������������� ����. ����: ' . $this->_usingZone);
        }
    }
   /**
    * @access private
    */
    private function __construct($name = '')
    {
        session_name($name);
        session_set_cookie_params(2000, '/', Dune_Parameters::$cookieSiteDomain);
        session_start();
        if (isset($_SESSION[self::ZONE_AUTH]))
        {
            if (count($_SESSION[self::ZONE_AUTH]) > 0)
                self::$auth = true;
        }
    }
////////// ����� �������� ��������� �������
///////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////
///////////////////////////////     ���������� ������
    public function __set($name, $value)
    {
        $this->_canEditZone();
        $_SESSION[$this->_usingZone][$name] = $value;
        
        //$_SESSION[$this->_usingZone . $name] = $value;
    }
    public function __get($name)
    {
        if (isset($_SESSION[$this->_usingZone][$name]))
            return $_SESSION[$this->_usingZone][$name];
        else 
            return false;
    }
    
    
    /**
     * ��������� isset() ����������� � PHP 5.1
     *
     * @param string $name
     * @return boolean
     */
    public function __isset($name)
    {
        return isset($_SESSION[$this->_usingZone][$name]);
    }

    /**
     * ��������� unset() ����������� � PHP 5.1
     *
     * @param  string $name
     * @return void
     */
    public function __unset($name)
    {
        $this->_canEditZone();
        unset($_SESSION[$this->_usingZone][$name]);
    }
    
    
    public function __toString()
    {
    	$string = '<pre>';
    	ob_start();
    	print_r($_SESSION[$this->_usingZone]);
    	$string .= ob_get_clean();
    	return  $string . '</pre>';
    }
/////////////////////////////
////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////////////////
///////////////////////////////     ������ ���������� Iterator
  // ������������� �������� �� ������ �������
  public function rewind()
  {
      return reset($_SESSION[$this->_usingZone]);
  }
  // ���������� ������� �������
  public function current()
  {
      return current($_SESSION[$this->_usingZone]);
  }
  // ���������� ���� �������� ��������
  public function key()
  {
    return key($_SESSION[$this->_usingZone]);
  }
  
  // ��������� � ���������� ��������
  public function next()
  {
    return next($_SESSION[$this->_usingZone]);
  }
  // ���������, ���������� �� ������� ������� ����� ���������� ������ rewind ��� next
  public function valid()
  {
    return isset($_SESSION[$this->_usingZone][key($_SESSION[$this->_usingZone])]);
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
        return isset($_SESSION[$this->_usingZone][$key]);
    }
    public function offsetGet($key)
    {
        if (isset($_SESSION[$this->_usingZone][$key]))
            return $_SESSION[$this->_usingZone][$key];
        else 
            return null;
    }
    
    public function offsetSet($key, $value)
    {
        $this->_canEditZone();
        $_SESSION[$this->_usingZone][$key] = $value;
    }
    public function offsetUnset($key)
    {
        $this->_canEditZone();
        unset($_SESSION[$this->_usingZone][$key]);
    }    


////////////////////////////////////////////////////////////////
///////////////////////////////     ������ ���������� Countable
    public function count()
    {
        return count($_SESSION[$this->_usingZone]);
    }

}