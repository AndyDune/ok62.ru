<?
/**
 * Dune Framework
 * 
 * Наследник класса Zend_Cache.
 * Усовершенствования:
 *      Синглетон.
 *      Передача парамертов с помощью установки статичексих переменных.
 * 
 * ----------------------------------------------------
 * | Библиотека: Dune                                  |
 * | Файл: Cache.php                                   |
 * | В библиотеке: Dune/Cache.php                      |
 * | Автор: Андрей Рыжов (Dune) <dune@rznw.ru>         |
 * | Версия: 1.00                                      |
 * | Сайт: www.rznw.ru                                 |
 * ----------------------------------------------------
 * 
 * 
 * История версий:
 * -----------------
 * 
 * 1.00 (2009 июень 03)
 * Аналог Duen_Zend_Cache объединенного с Dune_Data_Zend_Cache. 
 *
 */



abstract class Dune_Cache extends Zend_Cache
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
            $frontendOptions = self::getFrontendOptions();
            $backendOptions = self::getBackendOptions();
    
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
        $frontendOptions = self::getFrontendOptions();        
        $key = $frontend . $backend . (string)$frontendOptions['lifetime'];
        if (!key_exists($key, self::$instance))
        {
//            $frontendOptions = Dune_Data_Zend_Cache::getFrontendOptions();
            $backendOptions = self::getBackendOptions();
    
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
//            require_once str_replace('_', DIRECTORY_SEPARATOR, $frontendClass) . '.php';
//            require_once str_replace('_', DIRECTORY_SEPARATOR, $backendClass) . '.php';
    
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
    
    /**
     * Попытка загрузки кеша, если установлен флаг разрешения.
     *
     * @param string $cache_name
     * @return mixed
     */
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

    /**
     * Попытка сохранения кеша, если установлен флаг разрешения.
     *
     * @param mixed $cache_data данные для сохранения
     * @param string $cache_name имя кеш файла
     * @param array $array массив тегов
     */
    public static function saveIfAllow($cache_data, $cache_name, $array = array())
    {
        if (self::$allowSave)
        {
            $o_cache = self::getInstance();
            $o_cache->save($cache_data, $cache_name, $array);
        }
    }

    
    
    
    
    /**
     * Включает/отключает кэширование (может быть очень полезным при отладке кэшируемых скриптов).
     */
    static public $caching = true;

    /**
     * Время жизни кэша (в секундах), если установлен в null, то кэш имеет бесконечное время жизни.
     */
    static public $lifetime = 2600000; // Месяц

    /**
     * Если установлен в true, то включается логирование через Zend_Log (но система будет работать медленнее).
     */
    static public $logging = false;

    /**
     * Включает/отключает контроль записи (кэш читается сразу после записи для выявления поврежденных записей), включение write_control немного замедлит запись кэша, но не чтение. Этот контроль поможет выявить некоторые поврежденные файлы кэша, но не является совершенным
     */
    static public $write_control = true;
    
    /**
     * Включает/отключает автоматическую сериализацию, она может использоваться для сохранения напрямую данных, которые не являются строками (но это будет меденнее).
     */
    static public $automatic_serialization = false;
    
    /**
     * Отключает/настраивает процесс автоматической очистки (сборки мусора): 0 означает, что автоматическая чистка кэша не производится, 1 означает систематическую очистку кэша, x (integer) > 1 означает, что автоматическая чистка производится случайным образом 1 раз на x записей кэша.
     */
    static public $automatic_cleaning_factor = 300;

    
    
//////////////////////////////////////////////////////////////////////////////////
/////////////       Опции Zend_Cache_Backend_File    


    /**
     * Опция Zend_Cache_Backend_File
     * Директория, в которой хранятся файлы кэша
     */
    static public $cache_dir = '!_tmp';
    
    /**
     * Опция Zend_Cache_Backend_File
     * Включает/отключает блокировку файлов. Позволяет избежать искажения данных кэша в плохих условиях, но это не поможет при многопоточном веб-сервере или файловой системе NFS...
     */
    static public $file_locking = true;
    
    /**
     * Опция Zend_Cache_Backend_File
     * Включает/отключает контроль чтения. Если включен, то в файл кэша добавляется контрольный ключ и этот ключ сравнивается с другим, вычисляемым после чтения.
     */
    static public $read_control = true;
    
    /**
     * Опция Zend_Cache_Backend_File
     * Тип контроля чтения (только если включен readControl). Возможные значения: 'md5' (лучший, но самый медленный), 'crc32' (немного менее безопасный, но более быстрый, лучший выбор), 'strlen' для контроля толко по длине (самый быстрый).
     */
    static public $read_control_type = 'crc32';
    
    /**
     * Опция Zend_Cache_Backend_File
     * Уровень структуры хэшированного каталога: 0 означает "нет структуры хэшированного каталога", 1 — "один уровень каталога", 2 — "два уровня"... Эта опция ускорит кэширование только если у вас тысячи файлов кэша. Только сравнение может помочь вам выбрать оптимальное для вас значение. Возможно, 1 или 2 будут хорошими значениями для начала.
     */
    static public $hashed_directory_level = 2;
    
    /**
     * Опция Zend_Cache_Backend_File
     * Маска режима создания файлов для стуктуры хэшированного каталога.
     */
    static public $hashed_directory_umask = 0700;
    
    /**
     * Опция Zend_Cache_Backend_File
     * Префикс для файлов кэша. Будьте осторожны с этой опцией, поскольку слишком общее значение в системной директории для кэша (например '/tmp') может привести к катастрофичным последствиям при очищении кэша.
     */
    static public $file_name_prefix = 'zend_cache';
    
    
///////////////////////////////////////////////////////////////////////
////////////////    Функции передачи данных    

    static public function getBackendOptions()
    {
       $array = array(
             'cache_dir'              => $_SERVER['DOCUMENT_ROOT'] . '/' . self::$cache_dir . '/',            
             'file_locking'           => self::$file_locking,
             'read_control'           => self::$read_control,
             'read_control_type'      => self::$read_control_type,
             'hashed_directory_level' => self::$hashed_directory_level,
             'hashed_directory_umask' => self::$hashed_directory_umask,
             'file_name_prefix'       => self::$file_name_prefix);
        return $array;
    }
    
    static public function getFrontendOptions()
    {
        $array = array(
            'caching'                   => self::$caching,
            'lifetime'                  => self::$lifetime, 
            'logging'                   => self::$logging,
            'write_control'             => self::$write_control,
            'automatic_serialization'   => self::$automatic_serialization,
            'automatic_cleaning_factor' => self::$automatic_cleaning_factor);
        return $array;
    }    
    
    
    
    
    
    
    
}