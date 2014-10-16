<?php
/**
 * ����� ��� ������ � ����� ������� cookie ��� � ��������.
 * ��������� ����� ����� ��� ������ � ��������
 * ��������� ArrayAccess 
 * 
 * ----------------------------------------------------
 * | ����������: Dune                                  |
 * | ����: Array.php                                   |
 * | � ����������: Dune/Cookie/Array.php               |
 * | �����: ������ ����� (Dune) <dune@pochta.ru>       |
 * | ������: 1.02                                      |
 * | ����: www.rznlf.ru                                |
 * ----------------------------------------------------
 *
 * ������� ������:
 * -----------------
 * 
 * ������ 1.00 -> 1.01
 * ��������� �������� ��������� �������. ������ ���������� ��� ����������� �������� ������� �� ������.
 * ������� ������� ���������� ��� ������ �������-������������� ��������.
 */

class Dune_Cookie_Array extends Dune_Cookie_Parent_Base implements ArrayAccess, Dune_Interface_BeforePageOut
{
    // ��� ������-�������
    protected $cookieName;
    // ���� ��������� ������
    protected $cookieExists = false;
    // ���� ����������� ���������� ������
    protected $isArray = false;

    // ���� ������� ������ doBeforePageOut()
    protected $doneBeforePageOut = false;
    
    // ���� �������� �������. true - ���������
    protected $cryptCookie = true;
    
    public function __construct($name, $hours = 1,$domain = ".rznlf.ru",$path = "/", $secure = 0)
    {
        // ������� ���� ���������� ������ � ����� ��������
        $SYS = Dune_System::getInstance();
        if (isset($SYS['cookie_mcript']))
            $this->cryptCookie = $SYS['cookie_mcript'];

        $this->cookieName = $name;
        if (key_exists($name,$_COOKIE))
        {
            $this->cookieExists = true;
            if ($this->cryptCookie)
            {
                $this->getCryptCookie();
            }
            else 
            {
                $this->getCookie();
            }
        }
        parent::__construct($hours, $domain, $path, $secure);  
     }
    
    
    /**
     * �������� ������������� ������
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
     * �������� ������
     *
     */
    public function clear()
    {
        setcookie($this->cookieName);
    }
    /**
     * ��������� ������-�������
     *
     */
    public function set()
    {
        if ($this->cryptCookie)
        {
            $this->setCryptCookie();
        }
        else 
        {
            $str_array = urlencode(serialize($this->cookieArray));
            setcookie($this->cookieName, $str_array, $this->expires, $this->path, $this->domain, $this->secure);
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
        if (($this->isArray) AND (!$this->doneBeforePageOut))
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
    
    /**
     * ��������� ��������������� ������
     *
     * @access private
     */
    protected function setCryptCookie()
    {
        $str_array = serialize($this->cookieArray);
        $str_array = urlencode(Dune_Encrypt_McryptCookie::encrypt($str_array));
        setcookie($this->cookieName, $str_array, $this->expires, $this->path, $this->domain, $this->secure);
    }
////////////////////////////////////////////////////////////////
///////////////////////////////     ���������� ������
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
            throw new Exception('������ ������ �������� �������: ����� '.$key.' �� ����������');
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
    
    
}