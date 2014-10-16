<?php
/**
 * 
 * Клас агрегатный. Использует:
 *   Dune_MysqliSystem
 * 
 * 
 * CREATE TABLE `dune_auth_user_time` (
 * `id` int(10) unsigned NOT NULL,
 *  `password_check` datetime NOT NULL,
 *  `last_enter` datetime NOT NULL,
 * `last_visit` datetime default NULL,
 * `array` text NOT NULL,
 * PRIMARY KEY  (`id`),
 * KEY `last_enter` (`last_enter`)
 * ) ENGINE=MyISAM DEFAULT CHARSET=cp1251;
 * 
 * 
 * Исключение:
 *   Dune_Exception_Base
 *   Dune_Exception_Mysqli
 * 
 * ----------------------------------------------------
 * | Библиотека: Dune                                  |
 * | Файл: UserTime.php                                |
 * | В библиотеке: Dune/Auth/Mysqli/UserTime.php       |
 * | Автор: Андрей Рыжов (Dune) <dune@rznw.ru>         |
 * | Версия: 0.93                                      |
 * | Сайт: www.rznw.ru                                 |
 * ----------------------------------------------------
 *
 * История версий:
 * 
 * 0.93 (2008 декабрь 19) Вариант класса из синглетона зависит от полученного id.
 * 
 * 0.92 (2008 ноябрь 27) Добавилось работа с полем последнего посещения
 * 
 * 0.91 (2008 ноябрь 07) Протестировано - работает. Добавлен синглетон. Интерфей Dune_Interface_BeforePageOut
 * 
 * 0.90 Тестируется и комментируется.
 *
 * 
 */
class Dune_Auth_Mysqli_UserTime implements Dune_Interface_BeforePageOut
{
    /**
     * Указатель на класс
     *
     * @var unknown_type
     * @access private
     */
    protected $_DB = null;


                                      
    protected $_haveDataFromDB = false;
    
    /**
     * Движок базы данных для работы
     *
     * @var unknown_type
     * @access private
     */
    protected $_storageEngine = 'myisam';
    
    /**
     * Движок базы данных для работы
     *
     * @var unknown_type
     * @access private
     */
    protected $_availableStorageEngine = array('myisam', 'innodb');

    /**
     * ID пользователя в базе
     *
     * @var integer
     * @access private
     */
    protected $_userId = 0;
    

    protected $_timeArrayVariable = array();
    
    /**
     * Момент ввода паролья после продолжительного молчания
     * После идет отсчет попыток.
     *
     * @var string
     * @access private
     */
    protected $_timePasswordCheck = 0;

    /**
     * Момент последнего успешного входа.
     * По паролю или коду. Т.е. момент последнего открытия сессии.
     *
     * @var string
     * @access private
     */
    protected $_timeSuccessEnter = 0;
    
    protected $_timeSuccessVisit = 0;    
    
    /**
     * Имя таблицы временных моментов событий авторизации.
     * 
     * @var string
     */
    public static $_tableTime = 'dune_auth_user_time';
    
    protected $_modify = false;
    protected $doneBeforePageOut = false;

    
   /**
    * Иниц. при первом вызове стат. метода и возвращается при последующих
    *
    * @var указатель на объект
    */
  static private $instance = array();

  
  /**
   * Создаёт реализацию класса при первом вызове
   * Возвращает сохранённый указатель объекта при последующих вызовах
   *
   * 
   * @return Dune_Auth_Mysqli_UserTime
   */
  static function getInstance($id)
  {
    if (!key_exists($id, self::$instance))
    {
      self::$instance[$id] = new Dune_Auth_Mysqli_UserTime($id);
    }
    return self::$instance[$id];
  }
    
    
    protected function __construct($id)
    {
        $this->_userId = $id;
        $this->_initDB();
        $this->_readTable();
    }
    
    public function getTimePasswordCheck()
    {
        return $this->_timePasswordCheck;
    }
    
    public function setTimePasswordCheck($value = false)
    {
        $this->_modify = true;
        if ($value)
        {
            $this->_timePasswordCheck = $value;
        }
        else 
        {
            $this->_timePasswordCheck = time();
        }
    }

    
    public function getTimeLastEnter()
    {
        return $this->_timeSuccessEnter;
    }

    public function setTimeLastEnter($value = false)
    {
        $this->_modify = true;
        if ($value)
        {
            $this->_timeSuccessEnter = $value;
        }
        else 
        {
            $this->_timeSuccessEnter = time();
        }
    }
    
    public function getTimeLastVisit()
    {
        return $this->_timeSuccessVisit;
    }
    
    public function setTimeLastVisit($value = false)
    {
        $this->_modify = true;
        if ($value)
        {
            $this->_timeSuccessVisit = $value;
        }
        else 
        {
            $this->_timeSuccessVisit = time();
        }
    }
    
    
    public function getTime($name, $default = 0)
    {
        if (isset($this->_timeArrayVariable[$name]))
            $time = $this->_timeArrayVariable[$name];
        else 
            $time = $default;
        return $time;
    }

    public function setTime($name, $value = false)
    {
        $this->_modify = true;
        if ($value)
        {
            $this->_timeArrayVariable[$name] = $value;
        }
        else 
        {
            $this->_timeArrayVariable[$name] = time();
        }
    }
    
    public function commit()
    {
        if ($this->_modify)
        {
            $this->_modify = false;
            $this->_writeTable();
        }
        
    }
    
//////////////////////////////////////////////////////////////////////////////////    
//            Приватные методы
//////////////////////////////////////////////////////////////////////////////////    

    protected function _readTable()
    {
        $q = 'SELECT UNIX_TIMESTAMP(password_check) as `password_check`,
                     UNIX_TIMESTAMP(last_enter) as  `last_enter`,
                     UNIX_TIMESTAMP(last_visit) as  `last_visit`,
                     array
                     FROM `' . self::$_tableTime . '` WHERE `id` = ?i';
        $result = $this->_DB->query($q, array($this->_userId), Dune_MysqliSystem::RESULT_ROWASSOC);
        if ($result !== false)
        {
            $this->_timeArrayVariable = @unserialize($result['array']);
            if (!is_array($this->_timeArrayVariable))
                $this->_timeArrayVariable = array();
            $this->_timePasswordCheck = $result['password_check'];
            $this->_timeSuccessEnter  = $result['last_enter'];
            $this->_timeSuccessVisit  = $result['last_visit'];
            $this->_haveDataFromDB = true;
        }
    }
    
    protected function _writeTable()
    {
        $q = 'INSERT INTO `' . self::$_tableTime . '` 
                     SET
                         id = ?i,
                         password_check = FROM_UNIXTIME(?i),
                         last_enter = FROM_UNIXTIME(?i),
                         last_visit = FROM_UNIXTIME(?i),
                         array = ?
                     ON DUPLICATE KEY UPDATE
                         password_check = FROM_UNIXTIME(?i),
                         last_enter = FROM_UNIXTIME(?i),
                         last_visit = FROM_UNIXTIME(?i),
                         array = ?
                     ';
        $ser = serialize($this->_timeArrayVariable);
        $result = $this->_DB->query($q, array(
                                              $this->_userId,
                                              $this->_timePasswordCheck,
                                              $this->_timeSuccessEnter,
                                              $this->_timeSuccessVisit,
                                              $ser,
                                              $this->_timePasswordCheck,
                                              $this->_timeSuccessEnter,
                                              $this->_timeSuccessVisit,
                                              $ser
                                              ), Dune_MysqliSystem::RESULT_AR);
        if ($result)
        {
            return true;
        }
        else 
        {
            return false;
        }
    }
    
    
    
    /**
     * Реализация метода интерфейса Dune_Interface_BeforePageOut.
     * 
     * Действие после работы скрипта, перед выводом страницы.
     *
     */
    public function doBeforePageOut()
    {
        // Если массив есть и выполнение происходит 1-й раз
        if (!$this->doneBeforePageOut)
        {
            $this->commit();
            $this->doneBeforePageOut = true;
        }
    }
    
    
    /**
     * Инициилизация указателя на объект mysqli
     *
     * @access private
     */
    protected function _initDB()
    {
        if ($this->_DB == null)
            $this->_DB = Dune_MysqliSystem::getInstance();
    }
    
}