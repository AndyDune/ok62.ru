<?
/**
 * Dune Framework
 * 
 * ��������� ������ Zend_Cache.
 * ������������������:
 *      ���������.
 *      �������� ���������� � ������� ��������� ����������� ����������.
 * 
 * ----------------------------------------------------
 * | ����������: Dune                                  |
 * | ����: Cache.php                                   |
 * | � ����������: Dune/Cache.php                      |
 * | �����: ������ ����� (Dune) <dune@rznw.ru>         |
 * | ������: 1.00                                      |
 * | ����: www.rznw.ru                                 |
 * ----------------------------------------------------
 * 
 * 
 * ������� ������:
 * -----------------
 * 
 * 1.00 (2009 ����� 03)
 * ������ Duen_Zend_Cache ������������� � Dune_Data_Zend_Cache. 
 *
 */



abstract class Dune_Cache extends Zend_Cache
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
     * ����������� ����, ����� ������� � factory. ������ ��������� � �������������� ��������� �������.
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
     * ������� �������� ����, ���� ���������� ���� ����������.
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
     * ������� ���������� ����, ���� ���������� ���� ����������.
     *
     * @param mixed $cache_data ������ ��� ����������
     * @param string $cache_name ��� ��� �����
     * @param array $array ������ �����
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
     * ��������/��������� ����������� (����� ���� ����� �������� ��� ������� ���������� ��������).
     */
    static public $caching = true;

    /**
     * ����� ����� ���� (� ��������), ���� ���������� � null, �� ��� ����� ����������� ����� �����.
     */
    static public $lifetime = 2600000; // �����

    /**
     * ���� ���������� � true, �� ���������� ����������� ����� Zend_Log (�� ������� ����� �������� ���������).
     */
    static public $logging = false;

    /**
     * ��������/��������� �������� ������ (��� �������� ����� ����� ������ ��� ��������� ������������ �������), ��������� write_control ������� �������� ������ ����, �� �� ������. ���� �������� ������� ������� ��������� ������������ ����� ����, �� �� �������� �����������
     */
    static public $write_control = true;
    
    /**
     * ��������/��������� �������������� ������������, ��� ����� �������������� ��� ���������� �������� ������, ������� �� �������� �������� (�� ��� ����� ��������).
     */
    static public $automatic_serialization = false;
    
    /**
     * ���������/����������� ������� �������������� ������� (������ ������): 0 ��������, ��� �������������� ������ ���� �� ������������, 1 �������� ��������������� ������� ����, x (integer) > 1 ��������, ��� �������������� ������ ������������ ��������� ������� 1 ��� �� x ������� ����.
     */
    static public $automatic_cleaning_factor = 300;

    
    
//////////////////////////////////////////////////////////////////////////////////
/////////////       ����� Zend_Cache_Backend_File    


    /**
     * ����� Zend_Cache_Backend_File
     * ����������, � ������� �������� ����� ����
     */
    static public $cache_dir = '!_tmp';
    
    /**
     * ����� Zend_Cache_Backend_File
     * ��������/��������� ���������� ������. ��������� �������� ��������� ������ ���� � ������ ��������, �� ��� �� ������� ��� ������������� ���-������� ��� �������� ������� NFS...
     */
    static public $file_locking = true;
    
    /**
     * ����� Zend_Cache_Backend_File
     * ��������/��������� �������� ������. ���� �������, �� � ���� ���� ����������� ����������� ���� � ���� ���� ������������ � ������, ����������� ����� ������.
     */
    static public $read_control = true;
    
    /**
     * ����� Zend_Cache_Backend_File
     * ��� �������� ������ (������ ���� ������� readControl). ��������� ��������: 'md5' (������, �� ����� ���������), 'crc32' (������� ����� ����������, �� ����� �������, ������ �����), 'strlen' ��� �������� ����� �� ����� (����� �������).
     */
    static public $read_control_type = 'crc32';
    
    /**
     * ����� Zend_Cache_Backend_File
     * ������� ��������� ������������� ��������: 0 �������� "��� ��������� ������������� ��������", 1 � "���� ������� ��������", 2 � "��� ������"... ��� ����� ������� ����������� ������ ���� � ��� ������ ������ ����. ������ ��������� ����� ������ ��� ������� ����������� ��� ��� ��������. ��������, 1 ��� 2 ����� �������� ���������� ��� ������.
     */
    static public $hashed_directory_level = 2;
    
    /**
     * ����� Zend_Cache_Backend_File
     * ����� ������ �������� ������ ��� �������� ������������� ��������.
     */
    static public $hashed_directory_umask = 0700;
    
    /**
     * ����� Zend_Cache_Backend_File
     * ������� ��� ������ ����. ������ ��������� � ���� ������, ��������� ������� ����� �������� � ��������� ���������� ��� ���� (�������� '/tmp') ����� �������� � �������������� ������������ ��� �������� ����.
     */
    static public $file_name_prefix = 'zend_cache';
    
    
///////////////////////////////////////////////////////////////////////
////////////////    ������� �������� ������    

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