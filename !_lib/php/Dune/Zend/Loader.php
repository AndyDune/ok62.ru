<?php
/**
 * Dune Framework
 *
 * ----------------------------------------------------
 * | Библиотека: Dune                                  |
 * | Файл: Loader.php                                  |
 * | В библиотеке: Dune/Zend/Loader.php                |
 * | Автор: Андрей Рыжов (Dune) <dune@rznw.ru>         |
 * | Версия: 1.00                                      |
 * | Сайт: www.rznw.ru                                 |
 * ----------------------------------------------------
 *
 * История версий:
 * 
 */

class Dune_Zend_Loader extends Zend_Loader
{
    
    static protected $dirs = array();
    
    public static function assignDir($dir)
    {
        self::$dirs[] = $dir;
        $incPath = get_include_path();
        set_include_path($dir . PATH_SEPARATOR . $incPath);
        
    }
    
    /**
     * Загружает класс из файла PHP.  Имя файла должно иметь вид как "$class.php".
     * 
     * 
     * If $dirs is a string or an array, it will search the directories
     * in the order supplied, and attempt to load the first matching file.
     *
     * If $dirs is null, it will split the class name at underscores to
     * generate a path hierarchy (e.g., "Zend_Example_Class" will map
     * to "Zend/Example/Class.php").
     *
     * If the file was not found in the $dirs, or if no $dirs were specified,
     * it will attempt to load it from PHP's include_path.
     *
     * @param string $class      - The full class name of a Zend component.
     * @param string|array $dirs - OPTIONAL Either a path or an array of paths
     *                             to search.
     * @return void
     * @throws Zend_Exception
     */
    public static function loadClass($class, $dirs = null)
    {
        if (class_exists($class, false) || interface_exists($class, false)) {
            return;
        }
//        $dirs = self::$dirs;
        
/*      Массив папок для подключения файлов инициилизируеься отдельно методом assignDir($dir)
         if ((null !== $dirs) && !is_string($dirs) && !is_array($dirs)) {
            require_once 'Zend/Exception.php';
            throw new Zend_Exception('Directory argument must be a string or an array');
        }
*/
        // autodiscover the path from the class name
        $file = str_replace('_', DIRECTORY_SEPARATOR, $class) . '.php';
        if (!empty($dirs) and false) {
            // use the autodiscovered path
            $dirPath = dirname($file);
            if (is_string($dirs)) {
                $dirs = explode(PATH_SEPARATOR, $dirs);
            }
            foreach ($dirs as $key => $dir) {
                if ($dir == '.') {
                    $dirs[$key] = $dirPath;
                } else {
                    $dir = rtrim($dir, '\\/');
                    $dirs[$key] = $dir . DIRECTORY_SEPARATOR . $dirPath;
                }
            }
            $file = basename($file);
            self::loadFile($file, $dirs, true);
        } else {
//            self::_securityCheck($file); // Нет смысла проверять правильность имени файла
            include_once $file;
        }

        if (!class_exists($class, false) && !interface_exists($class, false)) {
            //require_once 'Zend/Exception.php';
            throw new Zend_Exception("File \"$file\" does not exist or class \"$class\" was not found in the file");
        }
    }
    
    
    /**
     * spl_autoload() suitable implementation for supporting class autoloading.
     *
     * Attach to spl_autoload() using the following:
     * <code>
     * spl_autoload_register(array('Zend_Loader', 'autoload'));
     * </code>
     *
     * @param string $class
     * @return string|false Class name on success; false on failure
     */
    public static function autoload($class)
    {
        try {
            self::loadClass($class);
            return $class;
        } catch (Exception $e) {
            return false;
        }
    }
    

}
