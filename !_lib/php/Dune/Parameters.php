<?php
/**
 * ����������� ����� ���������� � ���� ��������� ����������
 * 
 * 
 * ----------------------------------------------------
 * | ����������: Dune                                  |
 * | ����: Parameters.php                              |
 * | � ����������: Dune/Parameters.php                 |
 * | �����: ������ ����� (Dune) <dune@rznw.ru>         |
 * | ������: 1.17                                      |
 * | ����: www.rznw.ru                                 |
 * ----------------------------------------------------
 * 
 * ������� ������:
 * -----------------
 * 
 * 1.17 (2009 ���� 20)
 * ������ � ������� ������������.
 * 
 * 1.16 (2009 ��� 28)
 * ������ � �����������.
 * 
 * 1.15 (2009 ������ 28)
 * ����� ���������� $siteDisplayFolder. 
 * 
 * 1.14 (2009 ������ 27)
 * ����� ���������� $multiByte. ���� ������������� �������������� �����.
 * 
 * 1.13 (2009 ������ 20)
 * ����� ���������� $libDynamicFolder. ��� ����� ��� ������������� ������ ���������.
 * 
 * 1.12 (2008 ������� 16)
 * ����� ���������� $useClassToAssign
 * 
 * 1.11 (2008 ������ 27)
 * ����� ���������� $timeSetVisit
 * 
 * ������ 1.10 (2008 ������ 10)
 * ����� ����� $siteClassesFolder
 * 
 * ������ 1.09 (2008 ������ 06)
 * ������ ������������� ���������� (��������� �� � �������) �� ������ start().
 * ��������������� �������.
 * 
 * ������ 1.08
 * ��������� ���������� $captchaPath, $captchaFont
 * 
 * ������ 1.06 -> 1.07
 * ��� ����� ��������� ������� (������ �� �� �����) ������� �������.
 *
 * ������ 1.05 -> 1.06
 * ��������s ��������st $templateSpaceAdmin, $templateRealizationAdmin
 * 
 * ������ 1.04 -> 1.05
 * ��������� ���������� $systemDbmPath
 * 
 * ������ 1.03 -> 1.04
 * ��������� ���������� $cacheSave, $cacheLoad
 * 
 * ������ 1.01 -> 1.02
 * ���� � ����� �������� �������� � ����� ���������� $configFilePath.
 * $configFilePath ������������ �� ������. ���������� ��� ��������� ������� �������� ���� � ������.
 * ���������� � start ������ �� ����.
 * 
 * ������ 1.00 -> 1.01
 * ��������� ���������� $templateSpace, $templateRealization
 * 
 * ������ 0.99 -> 1.00
 * ��������� ������������� ���������� $cookieSiteDomain � $siteDomain �� ����� ��������
 *
 * ������ 0.98 -> 0.99
 * ��������� ���������� $adminMail
 *
 * ������ 0.97 -> 0.98
 * ��������� ���������� $ajax
 * ���� ��� ��� ��������� ��
 * 
 * ������ 0.96 -> 0.97
 * ��������� ���������� $subCommandPath
 * 
 * ������ 0.95 -> 0.96
 * ���������� ������ �������� ���������� $pageInternalReferer
 * 
 * ������ 0.94 -> 0.95
 * ���������� ���������� $pathToAdmin, $pathToPage
 * 
 * ������ 0.93 -> 0.94
 * ��������� ���������� self::$pageInternalReferer - ������� � ���������� �������, ��� ���������� $_SERVER['HTTP_REFERER'] - '/'
 * 
 * ������ 0.92 -> 0.93
 * ��������� ���������� self::$pageReferer - ������� ��������, ��� ���������� $_SERVER['HTTP_REFERER'] - '/'
 * 
 * ������ 0.91 -> 0.92
 * ����� ��������� ���� � ����� � ���������.
 * 
 */
abstract class Dune_Parameters
{
    
    /**
     * ���� ������������� �������������� �����.
     *
     * @var boolean
     */
    static public $multiByte = false;
    
    /**
     * ���� � ����� �������.
     * �� ��������: $_SERVER['DOCUMENT_ROOT'].'/!_dune/_moduls'
     *
     * @var string
     */
    static public $configFilePath = '/!_system/site.ini';
    
   
    /**
     * ���� � ����� �������.
     * �� ��������: $_SERVER['DOCUMENT_ROOT'].'/!_dune/_moduls'
     *
     * @var string
     */
    static public $modulsPath = '';
    
    /**
     * ���� � ����� c ������� ������.
     * �� ��������: $_SERVER['DOCUMENT_ROOT'].'/!_dune/_command'
     *
     * @var string
     */
    static public $commandPath = '';
    
    /**
     * ���� � ����� c ������� ����������������.
     * �� ��������: $_SERVER['DOCUMENT_ROOT'].'/!_dune/_subcommand'
     *
     * @var string
     */
    static public $subCommandPath = '';
    
    /**
     * ��� ������ ������� ���������� � �������.
     * ��� ������������� � ����������� ����������� � ������
     * 
     * @var string
     */
    static public $cookieSiteDomain = '.rznlf.ru';

    
    /**
     * ����� ����� ������� (���������)
     * ����������� � �����
     *
     * @var integer
     */
    static public $cookieLifeTime = 3000;

    
    /**
     * ���� ���������� �������
     *
     * @var boolean
     */
    static public $cookieMcript = false;
    
    /**
     * ���� ���������� �������
     *
     * @var string
     */
    static public $cookeiMcriptCypher = 'blowfish';
    
    /**
     * ���� ���������� �������
     *
     * @var string
     */
    static public $cookeiMcriptMode = 'cfb';

     /**
     * ���� ��� ���������� �������
     *
     * @var string
     */
    static public $cookeiMcriptKey;

    
    /**
     * ��� ���������� ������
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
     * ���������
     *
     * @var string
     */
    static public $mysqlCharsetName = 'cp1251';

     /**
     * ���� ������ � ���� ������
     *
     * @var boolean
     */
    static public $mysqlWrite = true;

    
     /**
     * ������� ��������
     *
     * @var boolean
     */
    static public $pageReferer = '/';
    
     /**
     * ������� �������� � �������� �������
     *
     * @var boolean
     */
    static public $pageInternalReferer = '/';

    
    /**
     * ��� ������ �������
     * 
     * @var string
     */
    static public $siteDomain = 'rznw.ru';

    /**
     * ���� � �����, ���������� �������� � ������������� ������� ������ ���������������� ������.
     *
     * @var string
     */
    static public $pathToAdmin = '';
    
    /**
     * ���� � �����, ���������� �������� � ������������� ������� ��� ��������� ����������� ������ �������.
     *
     * @var string
     */
    static public $pathToPage = '';

    
    /**
     * ��������� ������� �� ajax
     *
     * @var boolean
     */
    static public $ajax = false;
    

    /**
     * �������� ���� �������������� �������
     *
     * @var string
     */
    static public $adminMail = 'mail@mail.ru';

    /**
     * ���� � ����� ��������.
     * �� ��������: $_SERVER['DOCUMENT_ROOT'].'/!_dune/_templates'
     *
     * @var string
     */
    static public $templatesPath = '';    
    
    /**
     * ������������ (�����) � ������������� ��������� � ������� ���������� ����������
     * 
     *
     * @var string
     */
    static public $templateSpace = 'default';

    /**
     * ������������ (�����) � ������������� ��������� ��� ������ ����������������.
     * 
     *
     * @var string
     */
    static public $templateSpaceAdmin = 'default';
    
    
    /**
     * ����� � ������������ ������ �������� ��� ����������� ������ ������, ������ ��������.
     *
     * @var string
     */
    static public $templateRealization = 'default';
    
    /**
     * ����� � ������������ ������ �������� ��� ����������� ������ ������, ������ �������� ��� ������ ������.
     *
     * @var string
     */
    static public $templateRealizationAdmin = 'default';

    
    /**
     * ���� ���������� ���������� ������ � ����.
     *
     * @var boolean
     */
    static public $cacheSave = true;
    
    /**
     * ���� ���������� ������� ������ �� ����.
     *
     * @var boolean
     */
    static public $cacheLoad = true;
    
    
    static public $fontsDirectory;
    
    /**
     * ���� � ���������� ����� ���� DBM
     *
     * @var string
     */
    static public $systemDbmPath = '';

    /**
     * ���� � ����� - ��������� ��������� �������� �����.
     *
     * @var string
     */
    static public $captchaPath = '_temp/captcha';
    
    /**
     * ������� ���� ������ ��� ����� zend
     *
     * @var string
     */
    static public $captchaFont = 'arial.ttf';
    
    /**
     * ������� ���������� ������������� ����������.
     *
     */
    
    /**
     * ����� � ������� ������� ������� ��� �����
     *
     * @var string
     */
    static public $siteClassesFolder = 'default';
    
    /**
     * ����� � ������� ������� �������-�������� ��� �����
     *
     * @var string
     */
    static public $siteDisplayFolder = 'default';
    
    /**
     * ����� � ������� ������� ����������� ���������.
     * ������ ������: !_lib/dphp
     *
     * @var string
     */
    static public $libDynamicFolder = 'ver_00';
    
    
    /**
     * ���� �������� ������� ������ ������������ �� ����.
     *
     * @var boolean
     */
    static public $timeSetVisit = false;

    /**
     * ���� ����������������� ��������� ���������� � ���� ��� ������ ����������.
     *
     * @var boolean
     */
    static public $useClassToAssign = false;

    /**
     * ���� �������������� �������� ������� �� ����������.
     *
     * @var boolean
     */
    static public $useClassToCheckAjax = false;
    static public $classToCheckAjax    = 'System_Site_CheckAjax';
    
    
    static public $checkSubDomain = true;
    
    /**
     * ��������
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
     * �������� �� ������ �� �������. AJAX.
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