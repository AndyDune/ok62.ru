<?php
/**
 * Главный класс для всех классов для работы с cookie.
 * 
 * 
 * ----------------------------------------------------
 * | Библиотека: Dune                                  |
 * | Файл: Base.php                                    |
 * | В библиотеке: Dune/Cookie/Parent/Base.php         |
 * | Автор: Андрей Рыжов (Dune) <dune@pochta.ru>       |
 * | Версия: 1.01                                      |
 * | Сайт: www.rznlf.ru                                |
 * ----------------------------------------------------
 *
 * История версий:
 * -----------------
 * 
 * Версия 1.00 -> 1.01
 * Ликвидирована ошибка вычисления свойства $expires
 * 
 */

class Dune_Cookie_Parent_Base
{
    // Массив из пирогов
    // key - имя cookie
    // value - значение cookie
    protected $cookieArray = array();
    protected $cookieCount = 0;
    
// [expires] - дата окончания действия cookie (по умолчанию - до конца сессии)
    protected $expires = 0;
// [path] - путь, для которого cookie действительно (по умолчанию - документ, в котором значение было установлено)
    protected $path = "/";
// [domain] - домен, для которого cookie действительно (по умолчанию - домен, в котором значение было установлено)
    protected $domain = ".rznlf.ru";
// [secure] - логическое значение, показывающее требуется ли защищенная передача значения cookie    
    protected $secure = 0;
    
// Время жизни куки в секундах
    protected $lifeTime = 3600;
    
    protected function __construct($hours = 1, $domain = ".rznlf.ru", $path = "/", $secure = 0)
    {
        $this->expires = time() + $this->lifeTime * $hours;
        $this->path = $path;
        $this->domain = $domain;
        $this->secure = $secure;
        $this->cookieCount = count($_COOKIE);     
    }
   
    /**
     * Возвращает общее число пирогов куки
     *
     * @param string $name
     */
    public function getCookieCount()
    {
        return $this->cookieCount;
    }
    
    /**
     * Установить тестовый пирог
     *
     * @param string $name
     */
    public function setTestCookie($name = 'check')
    {
        setcookie($name,'checked',0, $this->path, $this->domain, $secure = 0);
    }
    
    /**
     * Проверить, установился ли тестовый пирог
     *
     * @param string $name
     * @return boolean
     */
    public function checkTestCookie($name = 'check')
    {
        if (key_exists($name,$_COOKIE))
            return true;
         else 
            return false;
            
    }
}