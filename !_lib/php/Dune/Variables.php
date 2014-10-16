<?php
/**
 * Абстрактный класс содержащий в себе глобальные переменные.
 * 
 * 
 * ----------------------------------------------------
 * | Библиотека: Dune                                  |
 * | Файл: Variables.php                               |
 * | В библиотеке: Dune/Variables.php                  |
 * | Автор: Андрей Рыжов (Dune) <dune@rznw.ru>         |
 * | Версия: 1.03                                      |
 * | Сайт: www.rznw.ru                                 |
 * ----------------------------------------------------
 * 
 * История версий:
 * -----------------
 * 
 * 1.03 (2008 декабрь 06)
 * Рабоат с классом конфигурации.
 * Новый статичкский метод addTitle($text, $prior = true)
 * 
 * 1.02 Добавлена статическая переменная $pathToViewFolder - путь к папке файлов текущего вида.
 * 
 * Версия 1.00 -> 1.01 (2008 октябрь 02)
 * Метод выборки информации из ini-файла getFromIni()
 * 
 * Версия 0.93 -> 1.00
 * Поддержка призвольных переменных.
 * Классу можно создать реализацию.
 * 
 * Версия 0.92 -> 0.93
 * Новая переменная: $pageName
 * 
 * Версия 0.90 -> 0.91
 * Новая переменная: $commandNameAdmin
 * 
 * Версия 0.91 -> 0.92
 * Новые переменные: $commandHandlerAdmin, $commandHandlerpage
 * 
 * 
 */
class Dune_Variables
{

///////////////////////////////////////////////////////////////////
//////////////////          Мега переменные. Статичныею
//////////////////////////////////////////////////////////////////
    /**
     * Имя страницы
     *
     * @var string
     */
    static public $pageName = '';
    
    
    /**
     * Title страницы
     *
     * @var string
     */
    static public $pageTitle = '';
    
    /**
     * Ключевые слова страницы
     *+
     * @var string
     */
    static public $pageKeywords = '';
    
    /**
     * Описание страницы
     *
     * @var string
     */
    static public $pageDescription = '';
    
    /**
     * Самый главный контент страницы
     *
     * @var string
     */
    static public $pageContentMain;

    /**
     * Вся страница
     *
     * @var string
     */
    static public $pageText = '';
    
    /**
     * Команда для выхода в панель администрирования
     * По умолчанию: admin
     * @var string
     */
    static public $commandNameAdmin = 'admin';

    /**
     * Имя пост-обработчика комманды администрирования.
     * Фактически это имя подпапки в папке Dune_Parameters::$pathToAdmin
     * По умолчанию: default
     * @var string
     */
    static public $commandHandlerAdmin = 'default';
    
    /**
     * Имя пост-обработчика комманды вывода страницы контента.
     * Фактически это имя подпапки в папке Dune_Parameters::$pathToPage
     * По умолчанию: default
     * @var string
     */
    static public $commandHandlerPage = 'default';
    
    /**
     * Хранит статус пользователя.
     * Дублирует параметр user_status в области переменных сессии Dune_Session::ZONE_AUTH
     *
     * @var integer
     */
    static public $userStatus = 0;
    
    
    static public $results = array();
    
    static public $pathToViewFolder = '';
    
    /**
     * Путь к папке файлами класса Dune_AsArray_File_String
     *
     * @var string
     */
    static public $pathToArrayFiles = '!_system/data/afiles';
    
///////////////////////////////////////////////////////////////////
//////////////////    Синглетон. Обмен произвольными переменными.
//////////////////////////////////////////////////////////////////
   /**
    * Иниц. при первом вызове стат. метода и возвращается при последующих
    *
    * @var Dune_Variables
    * @access private
    */
    static private $instance = NULL;
    
    private $_vars_array = array();
    private $_usingZone = 'default__';
    
  /**
   * Создаёт реализацию класса при первом вызове
   * Возвращает сохранённый указатель объекта при последующих вызовах
   *
   * Вызывает указаталь на объект с системными параметрами
   * 
   * @return Dune_Variables
   */
    static public function getInstance()
    {
        if (self::$instance == NULL)
        {
            self::$instance = new Dune_Variables();
        }
        return self::$instance;
    }
    
    /**
     * Выбрка информации из системного ini-файла
     * Вызыват после установки переменных в Dune_Parameters
     *
     */
    static public function getFromIni($config = null)
    {
        if (!is_null($config))
        {
            self::$pageTitle = $config->page->title;
            self::$pageDescription = $config->page->description;
            self::$pageKeywords = $config->page->keywords;
        }
        else 
        {
            $SYS = Dune_System::getInstance();
            self::$pageTitle = $SYS['page_title'];
            self::$pageDescription = $SYS['page_description'];
            self::$pageKeywords = $SYS['page_keywords'];
        }
    }
    
    public static function addTitle($text, $prior = true)
    {
        if ($prior)
            self::$pageTitle = $text . ' ' . self::$pageTitle;
        else 
            self::$pageTitle .= $text;
    }
    
   /**
    * @access private
    */
    private function __construct()
    {
        
    }
    
    
    /**
     * Открывает специальную зону в пространстве переменных.
     *
     * @param string $zone
     */
    public function openZone($zone)
    {
        $this->_usingZone = $zone;
    }
    
    /**
     * Закрывает специальную зону в пространстве переменных
     */
    public function closeZone()
    {
        $this->_usingZone = 'default__';
    }    

////////////////////////////////////////////////////////////////
///////////////////////////////     Магические методы
    public function __set($name, $value)
    {
        $this->_vars_array[$this->_usingZone][$name] = $value;
    }
    public function __get($name)
    {
        if (isset($this->_vars_array[$this->_usingZone][$name]))
            return $this->_vars_array[$this->_usingZone][$name];
        else 
            return false;
    }    
    
    
    public function __toString()
    {
        ob_start();
        print_r($this->_vars_array);
        $t = ob_get_clean();
        return '<pre>' . $t . '</pre>';
    }
    
}