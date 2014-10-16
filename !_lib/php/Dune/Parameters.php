<?php
/**
 * Абстрактный класс содержащий в себе системные переменные
 * 
 * 
 * ----------------------------------------------------
 * | Библиотека: Dune                                  |
 * | Файл: Parameters.php                              |
 * | В библиотеке: Dune/Parameters.php                 |
 * | Автор: Андрей Рыжов (Dune) <dune@rznw.ru>         |
 * | Версия: 1.17                                      |
 * | Сайт: www.rznw.ru                                 |
 * ----------------------------------------------------
 * 
 * История версий:
 * -----------------
 * 
 * 1.17 (2009 июнь 20)
 * Рабоат с классом конфигурации.
 * 
 * 1.16 (2009 май 28)
 * Работа с поддоменами.
 * 
 * 1.15 (2009 апрель 28)
 * Новая переменная $siteDisplayFolder. 
 * 
 * 1.14 (2009 апрель 27)
 * Новая переменная $multiByte. Флаг использования мультибайтовых строк.
 * 
 * 1.13 (2009 январь 20)
 * Новая переменная $libDynamicFolder. Имя папки для динамического дерева библиотек.
 * 
 * 1.12 (2008 декабрь 16)
 * Новая переменная $useClassToAssign
 * 
 * 1.11 (2008 ноябрь 27)
 * Новая переменная $timeSetVisit
 * 
 * Версия 1.10 (2008 ноябрь 10)
 * Новый метод $siteClassesFolder
 * 
 * Версия 1.09 (2008 ноябрь 06)
 * Убрана инициилизация переменных (параметры БД и доменов) из метода start().
 * Устанавливается снаружи.
 * 
 * Версия 1.08
 * Добавлены пкременные $captchaPath, $captchaFont
 * 
 * Версия 1.06 -> 1.07
 * Для теста источника запроса (пришло ли от аякса) введена функция.
 *
 * Версия 1.05 -> 1.06
 * Добавленs переменнst $templateSpaceAdmin, $templateRealizationAdmin
 * 
 * Версия 1.04 -> 1.05
 * Добавлена переменная $systemDbmPath
 * 
 * Версия 1.03 -> 1.04
 * Добавлены переменные $cacheSave, $cacheLoad
 * 
 * Версия 1.01 -> 1.02
 * Путь к файлу настроек хранится в новой переменной $configFilePath.
 * $configFilePath определяется до старта. Необходимо при изменении указать обратный слеш в начале.
 * Передавать в start ничего не надо.
 * 
 * Версия 1.00 -> 1.01
 * Добавлены переменные $templateSpace, $templateRealization
 * 
 * Версия 0.99 -> 1.00
 * Добавлена инициилизация переменных $cookieSiteDomain и $siteDomain из файла настроек
 *
 * Версия 0.98 -> 0.99
 * Добавлена переменная $adminMail
 *
 * Версия 0.97 -> 0.98
 * Добавлена переменная $ajax
 * Плюс код для установки ее
 * 
 * Версия 0.96 -> 0.97
 * Добавлена переменная $subCommandPath
 * 
 * Версия 0.95 -> 0.96
 * Исправлена ошибка создания переменной $pageInternalReferer
 * 
 * Версия 0.94 -> 0.95
 * Добавлениы переменные $pathToAdmin, $pathToPage
 * 
 * Версия 0.93 -> 0.94
 * Добавлена переменная self::$pageInternalReferer - реферал с внутренных страниц, при отсутсивии $_SERVER['HTTP_REFERER'] - '/'
 * 
 * Версия 0.92 -> 0.93
 * Добавлена переменная self::$pageReferer - реферал страницы, при отсутсивии $_SERVER['HTTP_REFERER'] - '/'
 * 
 * Версия 0.91 -> 0.92
 * Метод принимает путь к файлу с конфигами.
 * 
 */
abstract class Dune_Parameters
{
    
    /**
     * Флаг использования мультибайтовых строк.
     *
     * @var boolean
     */
    static public $multiByte = false;
    
    /**
     * Путь к папке модулей.
     * По молчанию: $_SERVER['DOCUMENT_ROOT'].'/!_dune/_moduls'
     *
     * @var string
     */
    static public $configFilePath = '/!_system/site.ini';
    
   
    /**
     * Путь к папке модулей.
     * По молчанию: $_SERVER['DOCUMENT_ROOT'].'/!_dune/_moduls'
     *
     * @var string
     */
    static public $modulsPath = '';
    
    /**
     * Путь к папке c файлами команд.
     * По молчанию: $_SERVER['DOCUMENT_ROOT'].'/!_dune/_command'
     *
     * @var string
     */
    static public $commandPath = '';
    
    /**
     * Путь к папке c файлами подкоммандкоманд.
     * По молчанию: $_SERVER['DOCUMENT_ROOT'].'/!_dune/_subcommand'
     *
     * @var string
     */
    static public $subCommandPath = '';
    
    /**
     * Имя домена проекта указываемы в пирогах.
     * Для использования с поддоменами указывается с точкой
     * 
     * @var string
     */
    static public $cookieSiteDomain = '.rznlf.ru';

    
    /**
     * Время жизни пирогов (системных)
     * Указывается в часах
     *
     * @var integer
     */
    static public $cookieLifeTime = 3000;

    
    /**
     * Флаг шифрования пирогов
     *
     * @var boolean
     */
    static public $cookieMcript = false;
    
    /**
     * Флаг шифрования пирогов
     *
     * @var string
     */
    static public $cookeiMcriptCypher = 'blowfish';
    
    /**
     * Флаг шифрования пирогов
     *
     * @var string
     */
    static public $cookeiMcriptMode = 'cfb';

     /**
     * Ключ для шифрования пирогов
     *
     * @var string
     */
    static public $cookeiMcriptKey;

    
    /**
     * Имя системного пирога
     *
     * @var string
     */
    static public $cookieNameSystem = 'cooc';
    
     /**
     * 
     *
     * @var string
     */
    static public $mysqlHost;
    
     /**
     * 
     *
     * @var string
     */
    static public $mysqlUsername;

     /**
     * 
     *
     * @var string
     */
    static public $mysqlPasswd;

     /**
     * 
     *
     * @var string
     */
    static public $mysqlDbname;
    
    
     /**
     * Кодировка
     *
     * @var string
     */
    static public $mysqlCharsetName = 'cp1251';

     /**
     * Флаг записи в базу данных
     *
     * @var boolean
     */
    static public $mysqlWrite = true;

    
     /**
     * Реферер страницы
     *
     * @var boolean
     */
    static public $pageReferer = '/';
    
     /**
     * Реферер страницы в пределах проекта
     *
     * @var boolean
     */
    static public $pageInternalReferer = '/';

    
    /**
     * Имя домена проекта
     * 
     * @var string
     */
    static public $siteDomain = 'rznw.ru';

    /**
     * Путь к папке, содержащей подпапки с подключаемыми файлами работы административной панели.
     *
     * @var string
     */
    static public $pathToAdmin = '';
    
    /**
     * Путь к папке, содержащей подпапки с подключаемыми файлами для обработки результатов работы команды.
     *
     * @var string
     */
    static public $pathToPage = '';

    
    /**
     * Индикатор запроса по ajax
     *
     * @var boolean
     */
    static public $ajax = false;
    

    /**
     * Почтовый ящик администратора системы
     *
     * @var string
     */
    static public $adminMail = 'mail@mail.ru';

    /**
     * Путь к папке шаблонов.
     * По молчанию: $_SERVER['DOCUMENT_ROOT'].'/!_dune/_templates'
     *
     * @var string
     */
    static public $templatesPath = '';    
    
    /**
     * Пространство (папка) с подключаемыми шаблонами в текущей реализации интерфейса
     * 
     *
     * @var string
     */
    static public $templateSpace = 'default';

    /**
     * Пространство (папка) с подключаемыми шаблонами для панели администирования.
     * 
     *
     * @var string
     */
    static public $templateSpaceAdmin = 'default';
    
    
    /**
     * Папка в пространстве стилей шаблонов для подключения таблиц стилей, файлов скриптов.
     *
     * @var string
     */
    static public $templateRealization = 'default';
    
    /**
     * Папка в пространстве стилей шаблонов для подключения таблиц стилей, файлов скриптов для панели админа.
     *
     * @var string
     */
    static public $templateRealizationAdmin = 'default';

    
    /**
     * Флаг разрешения сохранения данных в кеше.
     *
     * @var boolean
     */
    static public $cacheSave = true;
    
    /**
     * Флаг разрешения выборки данных из кеша.
     *
     * @var boolean
     */
    static public $cacheLoad = true;
    
    
    static public $fontsDirectory;
    
    /**
     * Путь к системному файлу базы DBM
     *
     * @var string
     */
    static public $systemDbmPath = '';

    /**
     * Путь к папке - хранилицу временных картинок капчи.
     *
     * @var string
     */
    static public $captchaPath = '_temp/captcha';
    
    /**
     * Текущий файл шрифта для капчи zend
     *
     * @var string
     */
    static public $captchaFont = 'arial.ttf';
    
    /**
     * Функция начального инициирования переменных.
     *
     */
    
    /**
     * Папка с текущим деревом классов для сайта
     *
     * @var string
     */
    static public $siteClassesFolder = 'default';
    
    /**
     * Папка с текущим деревом классов-дисплеев для сайта
     *
     * @var string
     */
    static public $siteDisplayFolder = 'default';
    
    /**
     * Папка с текущим деревом специальных библиотек.
     * Корень дерева: !_lib/dphp
     *
     * @var string
     */
    static public $libDynamicFolder = 'ver_00';
    
    
    /**
     * Флаг фиксации момента захода пользователя на сайт.
     *
     * @var boolean
     */
    static public $timeSetVisit = false;

    /**
     * Флаг прединициилизации некоторых переменных в виде при вызове синглетона.
     *
     * @var boolean
     */
    static public $useClassToAssign = false;

    /**
     * Флаг дополнительной проверки запроса на аяксовость.
     *
     * @var boolean
     */
    static public $useClassToCheckAjax = false;
    static public $classToCheckAjax    = 'System_Site_CheckAjax';
    
    
    static public $checkSubDomain = true;
    
    /**
     * Субдомен
     *
     * @var array
     * @access private
     */
    static public $subDomain = '';
    
    static public function start($config = null)
    {
        if (!is_null($config))
        {
            date_default_timezone_set($config->time->zone);
            self::$cookieMcript = $config->cookie->mcript->flag;
            self::$cookeiMcriptCypher = $config->cookie->mcript->cypher;
            self::$cookeiMcriptMode = $config->cookie->mcript->mode;
            self::$cookeiMcriptKey = $config->cookie->mcript->key;
            
            self::$checkSubDomain  = $config->subdomain->check;
            
            
            self::$mysqlHost         = $config->mysql->host;
            self::$mysqlUsername     = $config->mysql->username;
            self::$mysqlPasswd       = $config->mysql->passwd;
            self::$mysqlDbname       = $config->mysql->dbname;
            self::$mysqlCharsetName  = $config->mysql->charset_name;
            
            self::$siteClassesFolder = $config->folder->page->siteClasses;
            self::$siteDisplayFolder = $config->folder->page->display;
            self::$libDynamicFolder  = $config->folder->page->lib;
            
            self::$timeSetVisit = $config->time->set_visit;
            
            
        }
        else
        { 
            date_default_timezone_set('Europe/Moscow');
            self::$configFilePath = $_SERVER['DOCUMENT_ROOT'] . self::$configFilePath;
            $SYS = Dune_System::getInstance();
            
            if (isset($SYS['cookie_mcript']))
                self::$cookieMcript = $SYS['cookie_mcript'];
            if (isset($SYS['cookie_mcript_cypher']))
                self::$cookeiMcriptCypher = $SYS['cookie_mcript_cypher'];
            if (isset($SYS['cookie_mcript_mode']))
                self::$cookeiMcriptMode = $SYS['cookie_mcript_mode'];
            if (isset($SYS['cookie_mcript_key']))
                self::$cookeiMcriptKey = $SYS['cookie_mcript_key'];
            
        }


         if (self::$checkSubDomain)
         {
             if (stripos($_SERVER['HTTP_HOST'], self::$siteDomain) !== false)
             {
                 $ex = new Dune_String_Explode($_SERVER['HTTP_HOST'], '.', 1);
                 $count = count($ex);
                 if ($count > 2)
                 {
                     self::$subDomain = $ex[$count - 2];
                 }
             }
        }
            
            
        if (isset($_SERVER['HTTP_REFERER']))
        {
            self::$pageReferer = $_SERVER['HTTP_REFERER'];
            if (stripos($_SERVER['HTTP_REFERER'], self::$siteDomain) !== false)
            {
                self::$pageInternalReferer = $_SERVER['HTTP_REFERER'];
            }
        }
            
        
        self::$systemDbmPath = $_SERVER['DOCUMENT_ROOT'] . '/!_system/dbm/system.dbm';

        
/*        if (isset($SYS['domain_cookie']))
            self::$cookieSiteDomain = $SYS['domain_cookie'];
        if (isset($SYS['domain_url']))
            self::$siteDomain = $SYS['domain_url'];
*/            

/*      self::$mysqlHost = $SYS['mysql_host'];
        self::$mysqlUsername = $SYS['mysql_username'];
        self::$mysqlPasswd = $SYS['mysql_passwd'];
        self::$mysqlDbname = $SYS['mysql_dbname'];
        self::$mysqlCharsetName = $SYS['mysql_charset_name'];
*/
   
        self::$modulsPath = $_SERVER['DOCUMENT_ROOT'].'/!_dune/_moduls';
        self::$templatesPath = $_SERVER['DOCUMENT_ROOT'].'/!_dune/_templates';
        self::$commandPath = $_SERVER['DOCUMENT_ROOT'].'/!_dune/_command';
        self::$subCommandPath = $_SERVER['DOCUMENT_ROOT'].'/!_dune/_subcommand';
        
        self::$pathToAdmin = $_SERVER['DOCUMENT_ROOT'].'/!_dune/_site/admin';
        self::$pathToPage  = $_SERVER['DOCUMENT_ROOT'].'/!_dune/_site/page';
        
        self::$fontsDirectory  = $_SERVER['DOCUMENT_ROOT'].'/!_system/fonts';
        
        if((isset($_SERVER['HTTP_X_REQUESTED_WITH'])) and ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) 
        {
            self::$ajax = true;
        }
        
    }
    /**
     * Проверка на запрос от скрипта. AJAX.
     *
     */
    static public function checkAjax()
    {
        if((isset($_SERVER['HTTP_X_REQUESTED_WITH'])) and ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) 
        {
            self::$ajax = true;
        }
        else if (self::$useClassToCheckAjax)
        {
            $class = new self::$classToCheckAjax();
            $class->make();
        }
        
    }
}