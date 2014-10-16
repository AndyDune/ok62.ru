<?php
/**
 * Класс для работы с cookie.
 * Наследует общий класс для работы с пирогами
 * 
 * 
 * ----------------------------------------------------
 * | Библиотека: Dune                                  |
 * | Файл: Base.php                                    |
 * | В библиотеке: Dune/Cookie/Base.php                |
 * | Автор: Андрей Рыжов (Dune) <dune@pochta.ru>       |
 * | Версия: 1.01                                      |
 * | Сайт: www.rznlf.ru                                |
 * ----------------------------------------------------
 *
 * 
 */

class Dune_Cookie_Base extends Dune_Cookie_Parent_Base 
{
    
    public function __construct($hours = 1,$domain = ".rznlf.ru",$path = "/", $secure = 0)
    {
        parent::__construct($hours, $domain, $path, $secure);
    }
    
    
    /**
     * Проверка существования пирога
     *
     * @param string $name имя пирога
     * @return boolean
     */
    public function isExistCookie($name)
    {
        if (key_exists($name,$_COOKIE))
            return true;
         else 
            return false;
    }

    /**
     * Enter description here...
     *
     * @param unknown_type $name
     * @return unknown
     */
    public function getCookie($name)
    {
        if (key_exists($name, $_COOKIE))
        {
            return $this->cookieArray[$name];
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