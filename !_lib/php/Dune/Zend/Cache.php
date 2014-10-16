<?php
/**
 * Dune Framework
 * 
 * ��������� ������ Zend_Cache.
 * ������������������:
 *      ���������.
 *      �������� ���������� � ������� ���������� Dune_Data_Zend_Cache.
 * 
 * ----------------------------------------------------
 * | ����������: Dune                                  |
 * | ����: Cache.php                                   |
 * | � ����������: Dune/Zend/Cache.php                 |
 * | �����: ������ ����� (Dune) <dune@rznw.ru>         |
 * | ������: 1.04                                      |
 * | ����: www.rznw.ru                                 |
 * ----------------------------------------------------
 * 
 * 
 * ������� ������:
 * -----------------
 * 
 * 1.04 (2009 ������� 03)
 * ������ ���������� ���� ��� ���������� �����.
 * 
 * 1.02 -> 1.03
 * ��������� ������ �������� � ���������� � ��� � ������ ������ ����������.
 * 
 * 1.01 -> 1.02
 * �������� ����� getInstance()
 * 
 * 1.00 -> 1.01
 * � ������������ ����� ��� ���������� ��������� �������� ����� ����� ����
 *
 */



abstract class Dune_Zend_Cache extends Zend_Cache
{
    
    /**
     * ���� ���������� ���������� ������ � ����.
     *
     * @var boolean
     */
    static public $allowSave = true;
    
    /**
     * ���� ���������� ������� ������ �� ����.
     *
     * @var boolean
     */
    static public $allowLoad = true;
    
    
    /**
     * ������ ��������� �������
     *
     * @var array
     * @access private
     */
    static protected $instance = array();    
    
    /**
     * Factory
     *
     * @param string $frontend frontend name
     * @param string $backend backend name
     * @param array $frontendOptions ���������� �� �����
     * @param array $backendOptions ���������� �� �����
     */
    public static function factory($frontend, $backend, $frontendOptions = array(), $backendOptions = array(), $customFrontendNaming = false, $customBackendNaming = false, $autoload = false)
    {
//            $frontendOptions = Dune_Data_Zend_Cache::getFrontendOptions();
            $backendOptions = Dune_Data_Zend_Cache::getBackendOptions();
    
            // because lowercase will fail
            $frontend = self::_normalizeName($frontend);
            $backend  = self::_normalizeName($backend);
    
            if (!in_array($frontend, self::$availableFrontends)) {
                self::throwException("Incorrect frontend ($frontend)");
            }
            if (!in_array($backend, Zend_Cache::$availableBackends)) {
                self::throwException("Incorrect backend ($backend)");
            }
    
            // For perfs reasons, with frontend == 'Core', we can interact with the Core itself
            $frontendClass = 'Zend_Cache_' . ($frontend != 'Core' ? 'Frontend_' : '') . $frontend;
    
            $backendClass = 'Zend_Cache_Backend_' . $backend;
    
            // For perfs reasons, we do not use the Zend_Loader::loadClass() method
            // (security controls are explicit)
            require_once str_replace('_', DIRECTORY_SEPARATOR, $frontendClass) . '.php';
            require_once str_replace('_', DIRECTORY_SEPARATOR, $backendClass) . '.php';
    
            $frontendObject = new $frontendClass($frontendOptions);
            $backendObject = new $backendClass($backendOptions);
            $frontendObject->setBackend($backendObject);
            
        return $frontendObject;
    }

    /**
     * ����������� ����, ����� ������� � factory. ������ ��������� � �������������� ��������� �������.
     *
     * @param string $frontend frontend name
     * @param string $backend backend name
     * @return Zend_Cache_Core
     */
    public static function getInstance($frontend = 'Core', $backend = 'File')
    {
        $frontendOptions = Dune_Data_Zend_Cache::getFrontendOptions();        
        $key = $frontend . $backend . (string)$frontendOptions['lifetime'];
        if (!key_exists($key, self::$instance))
        {
//            $frontendOptions = Dune_Data_Zend_Cache::getFrontendOptions();
            $backendOptions = Dune_Data_Zend_Cache::getBackendOptions();
    
            // because lowercase will fail
            $frontend = self::_normalizeName($frontend);
            $backend  = self::_normalizeName($backend);
    
            if (!in_array($frontend, self::$availableFrontends)) {
                self::throwException("Incorrect frontend ($frontend)");
            }
            if (!in_array($backend, Zend_Cache::$availableBackends)) {
                self::throwException("Incorrect backend ($backend)");
            }
    
            // For perfs reasons, with frontend == 'Core', we can interact with the Core itself
            $frontendClass = 'Zend_Cache_' . ($frontend != 'Core' ? 'Frontend_' : '') . $frontend;
    
            $backendClass = 'Zend_Cache_Backend_' . $backend;
    
            // For perfs reasons, we do not use the Zend_Loader::loadClass() method
            // (security controls are explicit)
            require_once str_replace('_', DIRECTORY_SEPARATOR, $frontendClass) . '.php';
            require_once str_replace('_', DIRECTORY_SEPARATOR, $backendClass) . '.php';
    
            $frontendObject = new $frontendClass($frontendOptions);
            $backendObject = new $backendClass($backendOptions);
            $frontendObject->setBackend($backendObject);
            self::$instance[$key] = $frontendObject;
        }
        else 
        {
            $frontendObject = self::$instance[$key];
        }
        return $frontendObject;
    }
    
    public static function loadIfAllow($cache_name)
    {
        if (self::$allowLoad)
        {
            $o_cache = self::getInstance();
            $cache_data = $o_cache->load($cache_name);
        }
        else 
        {
            $cache_data = false;
        }
        return $cache_data;
    }
    
    public static function saveIfAllow($cache_data, $cache_name, $array = array())
    {
        if (self::$allowSave)
        {
            $o_cache = self::getInstance();
            $o_cache->save($cache_data, $cache_name, $array);
        }
    }

    
}