<?
/**
 * Класс контейне данных для Zend_Cache
 * 
 * 
 *	 
 * --------------------------------------------------------
 * | Библиотека: Dune                                      |
 * | Файл: CacheKey.php                                    |
 * | В библиотеке: Dune/Data/Zend/Cache.php                |
 * | Автор: Андрей Рыжов (Dune) <dune@rznlf.ru>            |
 * | Версия: 1.00                                          |
 * | Сайт: www.rznlf.ru                                    |
 * --------------------------------------------------------
 * 
 */

class Dune_Data_Zend_Cache
{
//////////////////////////////////////////////////////////////////////////////////
/////////////        Опции базового фронтэнда

    /**
     * Включает/отключает кэширование (может быть очень полезным при отладке кэшируемых скриптов).
     */
    static public $caching = true;

    /**
     * Время жизни кэша (в секундах), если установлен в null, то кэш имеет бесконечное время жизни.
     */
    static public $lifetime        = 2600000; // Месяц
    static public $lifetimeDefiult = 2600000; // Месяц

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
    

    static public function setLifeTime($value = false)
    {
        if ($value)
            self::$lifetime = $value;
        else
            self::$lifetime = self::$lifetimeDefiult;
    }
    
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