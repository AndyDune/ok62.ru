<?
/**
 * Экспериментальный
 * Класс контейне данных. Параметры для настроек кеширования. 
 * 
 * Определяет папку для кеширования и подпапки для кеширования в файлы или в dbm
 * Если таких папок нет - создаём.
 * 
 * Использует системную переменную $_SERVER['DOCUMENT_ROOT']
 * 
 *	 
 * --------------------------------------------------------
 * | Библиотека: Dune                                      |
 * | Файл: CacheParameters.php                             |
 * | В библиотеке: Dune/Data/Container/CacheParameters.php |
 * | Автор: Андрей Рыжов (Dune) <dune@rznlf.ru>            |
 * | Версия: 0.05                                          |
 * | Сайт: www.rznlf.ru                                    |
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
     * Флаг использования кеша в системе.
     * 
     * При установке в false запрещает какие-либо действия с кешем.
     *
     * @var boolean
     */
    private $isCache  = true;

    /**
     * Доступные режимы
     *
     * @var array $availableModes array доступных режимов
     */
    public $availableModes = array('File', 'Dbm');

    /**
     * Режим работы. С файлами или dbm.
     *
     * @var string $availableModes Содержит File или Dbm
     */
    public $mode = 'Dbm';
    
    
    
    static private $instance = null;
    
    /**
     * 
     *
     * @param string $path имя папки для кеширования. Находится в корне.
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
            throw new Dune_Exception_Base('Недопустимый режим работы с кешем.');
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
     * Включение/выключение кеширования
     *
     * @return string
     */
    public function setCache($bool = false)
    {
        $this->isCache = $bool;
    }    
    
    /**
     * Возвращает флаг кеширования
     *
     * @return string
     */
    public function isCache()
    {
        return $this->isCache;
    }    

    
    /**
     * Возврящает режим кеширования. ('File', 'Dbm')
     *
     * @return string
     */
    public function getMode()
    {
        return $this->mode;
    }
    
    
    /**
     * Возврящает путь для кеширования в dbm
     *
     * @return string
     */
    public function getDbmPath()
    {
        return $this->dbmCachePath;
    }
    
    /**
     * Возврящает путь для кеширования в файлы
     *
     * @return string
     */
    public function getFilesPath()
    {
        return $this->filesCachePath;
    }
    
    /**
     * Возврящает путь для кеширования, общий
     *
     * @return string
     */
    public function getPath()
    {
        return $this->cachePath;
    }
    
    /**
     * Возврящает путь к временной папке
     *
     * @return string
     */
    public function getTempPath()
    {
        return $this->cachePath;
    }

}