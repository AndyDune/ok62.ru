<?php
/**
 * Расширяет класс Zend_Config_Ini для упрощенной передачи ссылки к файлу настроек.
 * Реализует паттерн синглетон.
 * 
 * ----------------------------------------------------
 * | Библиотека: Dune                                  |
 * | Файл: Ini.php                                     |
 * | В библиотеке: Dune/Zend/Config/Ini.php            |
 * | Автор: Андрей Рыжов (Dune) <dune@rznw.ru>         |
 * | Версия: 1.00                                      |
 * | Сайт: www.rznw.ru                                 |
 * ----------------------------------------------------
 * 
 * 
 */
class Dune_Zend_Config_Ini extends Zend_Config_Ini
{
    /**
     * Ссылка на объект, статичная.
     *
     * @var Dune_Zend_Config_Ini
     * @access private
     */
    static private $instance = null;
    
    /**
     * @var string
     * @access private
     */
    static private $instanceName = null;

    static $filename = '';
    
    /**
     * Возвращает объект класса Dune_Zend_Config_Ini
     *
     * @param  string|null   $section
     * @param  boolean|array $options
     * @return Dune_Zend_Config_Ini
     */
    static function getInstance($section = null, $options = false)
    {
        if (self::$instance === null)
        {
            self::$instance = new Dune_Zend_Config_Ini(self::$filename, $section, $options);
            self::$instanceName = $section;
        }
        else if (($section != null or !$section)  and $section != self::$instanceName)
        {
            self::$instance = new Dune_Zend_Config_Ini(self::$filename, $section, $options);
            self::$instanceName = $section;
        }
        return self::$instance;
    }

}
