<?
/**
 * �����������������
 * ����� �������� ������. ��������� ��� �������� �����������. 
 * 
 * ���������� ����� ��� ����������� � �������� ��� ����������� � ����� ��� � dbm
 * ���� ����� ����� ��� - ������.
 * 
 * ���������� ��������� ���������� $_SERVER['DOCUMENT_ROOT']
 * 
 *	 
 * --------------------------------------------------------
 * | ����������: Dune                                      |
 * | ����: CacheParameters.php                             |
 * | � ����������: Dune/Data/Container/CacheParameters.php |
 * | �����: ������ ����� (Dune) <dune@rznlf.ru>            |
 * | ������: 0.05                                          |
 * | ����: www.rznlf.ru                                    |
 * --------------------------------------------------------
 * 
 */

class Dune_Data_Container_CacheParameters
{
    private $cachePath      = '';
    private $dbmCachePath   = '/dbm';
    private $filesCachePath = '/files';
    private $tempCachePath  = '/temp';
    
    /**
     * ���� ������������� ���� � �������.
     * 
     * ��� ��������� � false ��������� �����-���� �������� � �����.
     *
     * @var boolean
     */
    private $isCache  = true;

    /**
     * ��������� ������
     *
     * @var array $availableModes array ��������� �������
     */
    public $availableModes = array('File', 'Dbm');

    /**
     * ����� ������. � ������� ��� dbm.
     *
     * @var string $availableModes �������� File ��� Dbm
     */
    public $mode = 'Dbm';
    
    
    
    static private $instance = null;
    
    /**
     * 
     *
     * @param string $path ��� ����� ��� �����������. ��������� � �����.
     * @return object
     */
    static function getInstance($mode = 'Dbm', $path = '!_cache')
    {
        if (self::$instance == null)
        {
            self::$instance = new Dune_Data_Container_CacheParameters($mode, $path);
        }
        return self::$instance;
    }
    
    private function __construct($mode, $path)
    {
        if (!in_array($mode, self::$availableModes))
        {
            throw new Dune_Exception_Base('������������ ����� ������ � �����.');
        }
        $this->mode = $mode;
        $this->cachePath = $_SERVER['DOCUMENT_ROOT'] . '/' . $path;
        if (!is_dir($this->cachePath))
        {
            mkdir($this->cachePath);
        }
        $this->dbmCachePath = $this->cachePath . $this->dbmCachePath;
        if (!is_dir($this->dbmCachePath))
        {
            mkdir($this->dbmCachePath);
        }
        $this->filesCachePath = $this->cachePath . $this->filesCachePath;
        if (!is_dir($this->filesCachePath))
        {
            mkdir($this->filesCachePath);
        }
        $this->tempCachePath = $this->cachePath . $this->tempCachePath;
        if (!is_dir($this->tempCachePath))
        {
            mkdir($this->tempCachePath);
        }
    }

    
    /**
     * ���������/���������� �����������
     *
     * @return string
     */
    public function setCache($bool = false)
    {
        $this->isCache = $bool;
    }    
    
    /**
     * ���������� ���� �����������
     *
     * @return string
     */
    public function isCache()
    {
        return $this->isCache;
    }    

    
    /**
     * ���������� ����� �����������. ('File', 'Dbm')
     *
     * @return string
     */
    public function getMode()
    {
        return $this->mode;
    }
    
    
    /**
     * ���������� ���� ��� ����������� � dbm
     *
     * @return string
     */
    public function getDbmPath()
    {
        return $this->dbmCachePath;
    }
    
    /**
     * ���������� ���� ��� ����������� � �����
     *
     * @return string
     */
    public function getFilesPath()
    {
        return $this->filesCachePath;
    }
    
    /**
     * ���������� ���� ��� �����������, �����
     *
     * @return string
     */
    public function getPath()
    {
        return $this->cachePath;
    }
    
    /**
     * ���������� ���� � ��������� �����
     *
     * @return string
     */
    public function getTempPath()
    {
        return $this->cachePath;
    }

}