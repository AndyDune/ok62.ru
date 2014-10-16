<?php
/**
 * ����� ��� ������ � cookie. ���������� Dune_Cookie_Base, �� ���������.
 * ��������� ����� ����� ��� ������ � ��������
 * 
 * ----------------------------------------------------
 * | ����������: Dune                                  |
 * | ����: BaseSingleton.php                           |
 * | � ����������: Dune/Cookie/BaseSingleton.php       |
 * | �����: ������ ����� (Dune) <dune@pochta.ru>       |
 * | ������: 1.02                                      |
 * | ����: www.rznlf.ru                                |
 * ----------------------------------------------------
 *
 * 
 */

class Dune_Cookie_BaseSingleton extends Dune_Cookie_Parent_Base 
{
   
    static private $instance = array();    
   /**
    * ������ ���������� ������ ��� ������ ������
    * ���������� ���������� ��������� ������� ��� ����������� �������
    *
    * @param string $fileName
    * @return ��������� �� ������
    */
    static function getInstance($name, $hours = 1,$domain = ".rznlf.ru",$path = "/", $secure = 0)
    {
        if (!key_exists($name,self::$instance))
        {
            self::$instance[$name] = new Dune_Cookie_BaseSingleton($name, $hours, $domain, $path, $secure);
        }
        return self::$instance[$name];
    }
    
    /**
     * ��������� ������������� ������ � ������
     *
     * @param string $name
     * @return boolean
     */
    public function isExistCookie($name)
    {
        if (key_exists($name,$_COOKIE))
            return true;
         else 
            return false;
    }

    public function getCookie($name)
    {
        if (key_exists($name, $this->cookieArray))
            return $this->cookieArray[$name];
        if (key_exists($name, $_COOKIE))
        {
            return $this->cookieArray[$name] = $_COOKIE[$name];
        }
        else 
        {
            return false;
        }
    }
    public function setCookie($name, $string)
    {
        setcookie($name, $string, $this->expires, $this->path, $this->domain, $this->secure);
    }
    
    public function getCryptCookie($name = 'rznlf')
    {
        if (key_exists($name, $this->cookieArray))
            return $this->cookieArray[$name];
        if (key_exists($name, $_COOKIE))
        {
            $str_array = Dune_Encrypt_McryptCookie::decrypt(urldecode($_COOKIE[$name]));
            $this->cookieArray[$name] = unserialize($str_array);
            return $this->cookieArray[$name];
        }
        else 
        {
            return false;
        }
    }
    
    public function setCryptCookie($name = 'rznlf', $array)
    {
        $str_array = serialize($array);
        $str_array = urlencode(Dune_Encrypt_McryptCookie::encrypt($str_array));
        setcookie($name, $str_array, $this->expires, $this->path, $this->domain, $this->secure);
    }
}