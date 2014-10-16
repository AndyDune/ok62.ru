<?php
/**
 * Репозиторий функция для хранения ссылок на подключаемые фалы JavaScripts
 * 
 * 
 * 
 * ----------------------------------------------------
 * | Библиотека: Dune                                  |
 * | Файл: JavaScriptsList.php                         |
 * | В библиотеке: Dune/Static/JavaScriptsList.php     |
 * | Автор: Андрей Рыжов (Dune) <dune@rznw.ru>         |
 * | Версия: 1.04                                      |
 * | Сайт: www.rznw.ru                                 |
 * ----------------------------------------------------
 *
 * История версий:
 * -----------------
 * 
 *  1.04 Добавлена возможность добавления зависимых файлов. Файлы фреймворков, которые нужны только при наличии кода их использующего.
 * 
 * Версия 1.02 -> 1.03
 * исправлена ошибка сортировки массиваю
 * Смена пути к включаемым файлам.
 * 
 * Версия 1.01 -> 1.02
 * Добавлена возможность указания порядка составления строки с подключением файлов скриптов
 * 
 * Версия 1.00 -> 1.01
 * Путь к файлам скриптов оирелеляется переменными класса Dune_Parameters
 * $templateSpace
 * $templateRealization
 * 
 * 
 */

abstract class Dune_Static_JavaScriptsList
{
    /**
     * Имя папки-пространства для подключаемых таблиц стилей.
     * Все пространства расположены в папке styles
     *
     * @var string
     */
    public static $javaScriptsFolder = 'js';
    
    /**
     * Массив имен файлов и режимов подключения
     *
     * @var array
     * @access private
     */
    protected static $_jsList = array();

    
    /**
     * Массив имен файлов и режимов подключения. С указанием приоритете вывода.
     *
     * @var array
     * @access private
     */
    protected static $_jsListInOrder = array();
    
    
    protected static $_jsListDependent = array();
    
    /**
     * Добавление файла js для подключения к шаблону.
     * Дубли отслеживаются.
     *
     * @param string $name имя файла без разширения
     * @param integer $order порядок в генерации строки
     */
    public static function add($name, $order = 500)
    {
        if (!key_exists($name, self::$_jsList))
        {
            self::$_jsList[$name] = $order;//$name;
            self::$_jsListInOrder[$order][$name] = &self::$_jsList[$name];
        }
    }

    /**
     * Добавление зависимых файлов. Подсоединяются если были добавлены обычные.
     * 
     * @param string $name имя файла без разширения
     */
    public static function addDependent($name, $path = '')
    {
            self::$_jsListDependent[$name] = $path;
    }
    
    
    
    /**
     * Возвращает строку для подключения без учета порядка.
     *
     * @return string
     */
    public static function getWithNoOrder()
    {
        $string = '';
        $folder = '/viewfiles/' 
        		. Dune_Parameters::$templateSpace 
        		. '/' 
        		. Dune_Parameters::$templateRealization 
        		. '/js/';
        if (count(self::$_jsList))
        {
            $string = self::getDependent();
            foreach (self::$_jsList as $key => $run)
            {
                $string .= '<script src="' . $folder . $key . '.js" type="text/javascript"></script>';
            }
        }
        return $string;
    }
    
    /**
     * Возвращает строку для подключения с учётом порядка.
     *
     * @return string
     */
    public static function get()
    {
        $string = '';
        $folder = '/viewfiles/' . Dune_Parameters::$templateSpace . '/' . Dune_Parameters::$templateRealization . '/js/';
        if (count(self::$_jsList))
        { 
            $string = self::getDependent();
            //ksort(self::$_jsListInOrder);
            foreach (self::$_jsListInOrder as $run)
            {
                foreach ($run as $key => $run2)
                {
                    $string .= '<script src="' 
                    		 . $folder 
                    		 . $key 
                    		 . '.js" type="text/javascript"></script>';
                }
            }
        }
        return $string;
        
        
        
        
        
        
/*        $string = '';
        $folder = '/js/' . Dune_Parameters::$templateSpace . '/' . Dune_Parameters::$templateRealization . '/';
        if (count(self::$_jsList))
        {
        	asort(self::$_jsList);
            foreach (self::$_jsList as $key => $run)
            {
                $string .= '<script src="' . $folder . $key . '.js" type="text/javascript"></script>';
            }
        }
        return $string;
*/ 
    }
   
    protected static function getDependent()
    {
        $string = '';
        $folder = '/viewfiles/' . Dune_Parameters::$templateSpace . '/' . Dune_Parameters::$templateRealization . '/js/';
        if (count(self::$_jsListDependent))
        { 
            foreach (self::$_jsListDependent as $key => $value)
            {
                if ($value)
                    $value .= '/';
                $string .= '<script src="' 
                 		 . $folder 
                 		 . $value 
                   		 . $key 
                   		 . '.js" type="text/javascript"></script>';

            }
        }
        return $string;
    }
    
}