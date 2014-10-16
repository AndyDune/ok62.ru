<?php
/**
 * Класс для работы с одной записью cookie как с массивом.
 * Наследует общий класс для работы с пирогами
 * Реализует ArrayAccess 
 * 
 * ----------------------------------------------------
 * | Библиотека: Dune                                  |
 * | Файл: Array.php                                   |
 * | В библиотеке: Dune/Cookie/Array.php               |
 * | Автор: Андрей Рыжов (Dune) <dune@pochta.ru>       |
 * | Версия: 1.02                                      |
 * | Сайт: www.rznlf.ru                                |
 * ----------------------------------------------------
 *
 * История версий:
 * -----------------
 * 
 * Версия 1.00 -> 1.01
 * Укорочены названия некоторых методов. Убрано исключение при считыванияя значения массива из пирога.
 * Введена функция интерфейса для вызова классом-регистратором объектов.
 */

class Dune_Cookie_Array extends Dune_Cookie_Parent_Base implements ArrayAccess, Dune_Interface_BeforePageOut
{
    // Имя пирога-массива
    protected $cookieName;
    // Флаг установки пирога
    protected $cookieExists = false;
    // Флаг корректного считывания пирога
    protected $isArray = false;

    // Флаг запуска метода doBeforePageOut()
    protected $doneBeforePageOut = false;
    
    // Флаг шифровки пирогов. true - фифруются
    protected $cryptCookie = true;
    
    public function __construct($name, $hours = 1,$domain = ".rznlf.ru",$path = "/", $secure = 0)
    {
        // Смотрим флаг шифрования пирога в файле настроек
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
     * Проверка существования пирога
     *
     * @param string $name имя пирога
     * @return boolean
     */
    public function isExist()
    {
        return $this->cookieExists;
    }
    
    /**
     * Проверка корректного считывания пирога
     *
     * @param string $name имя пирога
     * @return boolean
     */
    public function isCorrect()
    {
        return $this->isArray;
    }

    /**
     * Удаление пирога
     *
     */
    public function clear()
    {
        setcookie($this->cookieName);
    }
    /**
     * Установка пирога-массива
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
     * Реализация метода интерфейса Dune_Interface_BeforePageOut.
     * 
     * Действие после работы скрипта, перед выводом страницы.
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
////////////        Закрытые методы    
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
     * Установка закодированного пирога
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
///////////////////////////////     Магические методы
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
///////////////////////////////     Методы интерфейса ArrayAccess
    public function offsetExists($key)
    {
        return key_exists($key,$this->cookieArray);
    }
    public function offsetGet($key)
    {
        if (!key_exists($key,$this->cookieArray))
            throw new Exception('Ошибка чтения значения массива: ключа '.$key.' не существует');
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