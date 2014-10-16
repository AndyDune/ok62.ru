<?php
/**
 * Репозиторий функция для проверок, всяких проверок
 * 
 * ----------------------------------------------------
 * | Библиотека: Dune                                  |
 * | Файл: Alloy.php                                   |
 * | В библиотеке: Dune/Static/Alloy.php               |
 * | Автор: Андрей Рыжов (Dune) <dune@rznlf.ru>        |
 * | Версия: 1.00                                      |
 * | Сайт: www.rznlf.ru                                |
 * ----------------------------------------------------
 *
 */

abstract class Dune_Static_Alloy
{
    /**
     * Путь к файлу конфигурации dbm
     *
     * @var string
     */
    static public $configFile;
    
    /**
     * Флаг тестового режима - запрс проверок всегда положителен при установке в true
     *
     * @var string
     */
    static public $testMode = false;
    
    /**
     * Возвращает флаг возможности регистрации новых пользователей.
     *
     * @return boolean
     */
    static public function canUserRegister()
    {
        if (self::$testMode)
            return true;
        $dbm = Dune_AsArray_DbmSingleton::getInstance(self::$configFile);
        if (isset($dbm['alloy_user_register']) and ($dbm['alloy_user_register']))
            $result = true;
        else 
            $result = false;
        return $result;
    }
    
    /**
     * Рапрет/разрешение регистрации пользователей
     *
     * @param boolean $bool разрешение или запрет
     */
    static public function setUserRegister($bool = true)
    {
        $dbm = Dune_AsArray_DbmSingleton::getInstance(self::$configFile, 'w');
        $dbm['alloy_user_register'] = $bool;
    }
}