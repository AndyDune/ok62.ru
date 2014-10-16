<?php
/**
 * Класс-фабрика для объектов аутентификации.
 * 
 * ----------------------------------------------------
 * | Библиотека: Dune                                  |
 * | Файл: Autho.php                                   |
 * | В библиотеке: Dune/Auth.php                       |
 * | Автор: Андрей Рыжов (Dune) <dune@rznlf.ru>        |
 * | Версия: 0.98                                      |
 * | Сайт: www.rznlf.ru                                |
 * ----------------------------------------------------
 *
 * Версия 0.98 -> 0.99
 * 
 */
abstract class Dune_Auth
{
    protected static $availableMode = array('MailMysqli');
    
    
    /**
     * Некоторые режимы имеют имена, состоящие из нескольких слов, например, 'ZendPlatform'.
     * Когда задаете их через фабрику, разделяйте слова с помощью разделителей, таких, как пробел (' '), тире ('-'), или точка.
     *
     * @param string $mode
     * @param array $options
     * @return Dune_Auth_MailMysqli
     */
    public static function factory($mode, $options = array())
    {
        $mode = self::_normalizeName($mode);
        if (!in_array($mode, self::$availableMode))
        {
            throw new Dune_Exception_Base('Недопустимый режим ('. $mode . ')');
        }
        
        $mode = 'Dune_Auth_' . $mode;
        $object = new $mode($options);
        return $object;
    }
    
    /**
     * Normalize frontend and backend names to allow multiple words TitleCased
     *
     * @param  string $name
     * @return string
     */
    protected static function _normalizeName($name)
    {
        $name = ucfirst(strtolower($name));
        $name = str_replace(array('-', '_', '.'), ' ', $name);
        $name = ucwords($name);
        $name = str_replace(' ', '', $name);
        return $name;
    }
    
}