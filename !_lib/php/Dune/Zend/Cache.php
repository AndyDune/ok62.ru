<?php
/**
 * Dune Framework
 * 
 * Наследник класса Zend_Cache.
 * Усовершенствования:
 *      Синглетон.
 *      Передача парамертов с помощью контейнера Dune_Data_Zend_Cache.
 * 
 * ----------------------------------------------------
 * | Библиотека: Dune                                  |
 * | Файл: Cache.php                                   |
 * | В библиотеке: Dune/Zend/Cache.php                 |
 * | Автор: Андрей Рыжов (Dune) <dune@rznw.ru>         |
 * | Версия: 1.04                                      |
 * | Сайт: www.rznw.ru                                 |
 * ----------------------------------------------------
 * 
 * 
 * История версий:
 * -----------------
 * 
 * 1.04 (2009 февраль 03)
 * Ошибка сохранения кеша при отсутствии тегов.
 * 
 * 1.02 -> 1.03
 * Добавлены методы загрузки и сохранения в кеш с учетом флагов разрешения.
 * 
 * 1.01 -> 1.02
 * Добавлен метод getInstance()
 * 
 * 1.00 -> 1.01
 * В формировании ключа для синглетона участвует параметр впемя жизни кеша
 *
 */



abstract class Dune_Zend_Cache extends Zend_Cache
{
    
    /**
     * Флаг разрешения сохранения данных в кеше.
     *
     * @var boolean
     */
    static public $allowSave = true;
    
    /**
     * Флаг разрешения выборки данных из кеша.
     *
     * @var boolean
     */
    static public $allowLoad = true;
    
    
    /**
     * Массив созданных классов
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
     * @param array $frontendOptions передавать не нужно
     * @param array $backendOptions передавать не нужно
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
     * Статический метд, почти сходный с factory. Только синглетон и необязательные параметры функции.
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