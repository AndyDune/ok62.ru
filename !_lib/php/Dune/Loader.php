<?php
/**
 * Dune Framework
 *
 * ����� ������ ������ Dune_Zend_Loader ������ ��� �������������� ��������.
 * ������������� ��� ������������ �������.
 * 
 * ----------------------------------------------------
 * | ����������: Dune                                  |
 * | ����: Loader.php                                  |
 * | � ����������: Dune/Loader.php                     |
 * | �����: ������ ����� (Dune) <dune@rznw.ru>         |
 * | ������: 1.00                                      |
 * | ����: www.rznw.ru                                 |
 * ----------------------------------------------------
 *
 * ������� ������:
 * 
 */

class Dune_Loader
{
    
    public static function assignDir($dir)
    {
        $incPath = get_include_path();
        set_include_path($dir . PATH_SEPARATOR . $incPath);
        
        //$incPath = ini_get('include_path')
        //ini_set('include_path', $dir . PATH_SEPARATOR . $incPath);
    }
    
    /**
     * ��������� ����� �� ����� PHP.  ��� ����� ������ ����� ��� ��� "$class.php".
     *
     * If the file was not found in the $dirs, or if no $dirs were specified,
     * it will attempt to load it from PHP's include_path.
     *
     * @param string $class      - ������ ��� ������.
     * 
     * @return void
     * @throws Dune_Exception_Base
     */
    public static function loadClass($class)
    {
        if (class_exists($class, false) || interface_exists($class, false)) {
            return;
        }
        
        // autodiscover the path from the class name
        $file = str_replace('_', DIRECTORY_SEPARATOR, $class) . '.php';
//            self::_securityCheck($file); // ��� ������ ��������� ������������ ����� �����
            include_once $file;

        if (!class_exists($class, false) && !interface_exists($class, false)) {
            //require_once 'Zend/Exception.php';
            throw new Dune_Exception_Base("File \"$file\" does not exist or class \"$class\" was not found in the file");
        }
    }
    
    
    
    /**
     * Register {@link autoload()} with spl_autoload()
     *
     * @param string $class (optional)
     * @param boolean $enabled (optional)
     * @return void
     * @throws Zend_Exception if spl_autoload() is not found
     * or if the specified class does not have an autoload() method.
     */
    public static function registerAutoload($class = 'Dune_Loader', $enabled = true)
    {
        if (!function_exists('spl_autoload_register')) {
            throw new Dune_Exception_Base('spl_autoload does not exist in this PHP installation');
        }

        self::loadClass($class);
        $methods = get_class_methods($class);
        if (!in_array('autoload', (array) $methods)) {
            throw new Dune_Exception_Base("The class \"$class\" does not have an autoload() method");
        }

        if ($enabled === true) {
            spl_autoload_register(array($class, 'autoload'));
        } else {
            spl_autoload_unregister(array($class, 'autoload'));
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
