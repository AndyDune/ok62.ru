<?
/**
 * ����� �������� ������ ��� Zend_Cache
 * 
 * 
 *	 
 * --------------------------------------------------------
 * | ����������: Dune                                      |
 * | ����: CacheKey.php                                    |
 * | � ����������: Dune/Data/Zend/Cache.php                |
 * | �����: ������ ����� (Dune) <dune@rznlf.ru>            |
 * | ������: 1.00                                          |
 * | ����: www.rznlf.ru                                    |
 * --------------------------------------------------------
 * 
 */

class Dune_Data_Zend_Cache
{
//////////////////////////////////////////////////////////////////////////////////
/////////////        ����� �������� ���������

    /**
     * ��������/��������� ����������� (����� ���� ����� �������� ��� ������� ���������� ��������).
     */
    static public $caching = true;

    /**
     * ����� ����� ���� (� ��������), ���� ���������� � null, �� ��� ����� ����������� ����� �����.
     */
    static public $lifetime        = 2600000; // �����
    static public $lifetimeDefiult = 2600000; // �����

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
    

    static public function setLifeTime($value = false)
    {
        if ($value)
            self::$lifetime = $value;
        else
            self::$lifetime = self::$lifetimeDefiult;
    }
    
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