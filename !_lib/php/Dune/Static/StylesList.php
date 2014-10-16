<?php
/**
 * Репозиторий функция для хранения ссылок на подключаемые таблицы стилей
 * 
 * ----------------------------------------------------
 * | Библиотека: Dune                                  |
 * | Файл: StylesList.php                              |
 * | В библиотеке: Dune/Static/StylesList.php          |
 * | Автор: Андрей Рыжов (Dune) <dune@rznw.ru>         |
 * | Версия: 1.05                                      |
 * | Сайт: www.rznw.ru                                 |
 * ----------------------------------------------------
 *
 * История версий:
 * -----------------
 * 
 * Версия 1.05 (2009 апрель 30)
 * Присоединение спецстилей для ie7
 * 
 * Версия 1.04
 * Добавлен метод сброса накопленных файлов.
 * 
 * Версия 1.02 -> 1.03
 * Возможно менять порядок при выводе на страницу.
 * 
 * Версия 1.01 -> 1.02
 * Смена пути к включаемым файлам.
 *  
 * Версия 1.00 -> 1.01
 * Удалены переменные для хранения пути файлам стилей.
 * Путь к файлам стилей оирелеляется переменными класса Dune_Parameters
 * $templateSpace
 * $templateRealization
 * 
 */

abstract class Dune_Static_StylesList
{
    
    /**
     * Массив имен файлов и режимов подключения
     *
     * @var array
     * @access private
     */
    protected static $_stylesList = array();
    
    /**
     * Массив групп
     *
     * @var array
     * @access private
     */
    protected static $_stylesGroups = array();

    
    /**
     * Начальный номер групп
     *
     * @var integer
     * @access private
     */
    protected static $_beginGroupNumber = 100;
    
    /**
     * Конечеый номер групп
     *
     * @var integer
     * @access private
     */
    protected static $_endGroupNumber = 100;

    
    const MODE_IE6_STYLES = 'ie6';
    const MODE_IE7_STYLES = 'ie7';
    
    /**
     * Добавление файла css для подключения к шаблону.
     * Дубли отслеживаются.
     *
     * @param string $name имя файла без разширения
     * @param integer $group позиция при выводе по умолчанию 100
     * @param режим $mode использовать константы класса
     */
    public static function add($name, $group = null, $mode = '')
    {
        if (!$group)
        {
            $group = 100;
        }
        $name = str_replace(array(':', '/', '\\'), '/', $name);
        self::$_stylesList[$name]['file'] = $name . '.css';
        self::$_stylesList[$name]['mode'] = $mode;
        self::$_stylesGroups[$group][] = &self::$_stylesList[$name];
    }
    
    
    public static function clear()
    {
         self::$_stylesList = array();
         self::$_stylesGroups = array();
    }
    
    /**
     * Возвращает стору для подключения.
     *
     * @return string
     */
    public static function get()
    {
        ksort(self::$_stylesGroups);
        $string = '';
        $ie6_string = '';
        $folder = '/viewfiles/' 
        		. Dune_Parameters::$templateSpace 
        		. '/' 
        		. Dune_Parameters::$templateRealization 
        		. '/styles/';
        if (count(self::$_stylesList))
        {
            foreach (self::$_stylesGroups as $value)
            {
                foreach ((array)$value as $run)
                {
                    if ($run['mode'] === self::MODE_IE7_STYLES)
                    {
                        $ie6_string .= '<!--[if IE 7]><link href="' 
                           			 . $folder 
                           			 . $run['file'] 
                           			 . '" rel="stylesheet" type="text/css" /><![endif]-->';
                    }
                    else if  ($run['mode'] === self::MODE_IE6_STYLES)
                    {
                        $ie6_string .= '<!--[if lt IE 7]><link href="' 
                           			 . $folder 
                           			 . $run['file'] 
                           			 . '" rel="stylesheet" type="text/css" /><![endif]-->';
                    }
                    else 
                    {
                        $string .= '<link href="' 
                        		 . $folder 
                        		 . $run['file'] 
                        		 . '" rel="stylesheet" type="text/css" />';
                    }
                    
                    
                }
            }
        }
        return $string . $ie6_string;
    }
}