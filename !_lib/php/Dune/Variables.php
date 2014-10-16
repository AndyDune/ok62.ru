<?php
/**
 * ����������� ����� ���������� � ���� ���������� ����������.
 * 
 * 
 * ----------------------------------------------------
 * | ����������: Dune                                  |
 * | ����: Variables.php                               |
 * | � ����������: Dune/Variables.php                  |
 * | �����: ������ ����� (Dune) <dune@rznw.ru>         |
 * | ������: 1.03                                      |
 * | ����: www.rznw.ru                                 |
 * ----------------------------------------------------
 * 
 * ������� ������:
 * -----------------
 * 
 * 1.03 (2008 ������� 06)
 * ������ � ������� ������������.
 * ����� ����������� ����� addTitle($text, $prior = true)
 * 
 * 1.02 ��������� ����������� ���������� $pathToViewFolder - ���� � ����� ������ �������� ����.
 * 
 * ������ 1.00 -> 1.01 (2008 ������� 02)
 * ����� ������� ���������� �� ini-����� getFromIni()
 * 
 * ������ 0.93 -> 1.00
 * ��������� ����������� ����������.
 * ������ ����� ������� ����������.
 * 
 * ������ 0.92 -> 0.93
 * ����� ����������: $pageName
 * 
 * ������ 0.90 -> 0.91
 * ����� ����������: $commandNameAdmin
 * 
 * ������ 0.91 -> 0.92
 * ����� ����������: $commandHandlerAdmin, $commandHandlerpage
 * 
 * 
 */
class Dune_Variables
{

///////////////////////////////////////////////////////////////////
//////////////////          ���� ����������. ����������
//////////////////////////////////////////////////////////////////
    /**
     * ��� ��������
     *
     * @var string
     */
    static public $pageName = '';
    
    
    /**
     * Title ��������
     *
     * @var string
     */
    static public $pageTitle = '';
    
    /**
     * �������� ����� ��������
     *+
     * @var string
     */
    static public $pageKeywords = '';
    
    /**
     * �������� ��������
     *
     * @var string
     */
    static public $pageDescription = '';
    
    /**
     * ����� ������� ������� ��������
     *
     * @var string
     */
    static public $pageContentMain;

    /**
     * ��� ��������
     *
     * @var string
     */
    static public $pageText = '';
    
    /**
     * ������� ��� ������ � ������ �����������������
     * �� ���������: admin
     * @var string
     */
    static public $commandNameAdmin = 'admin';

    /**
     * ��� ����-����������� �������� �����������������.
     * ���������� ��� ��� �������� � ����� Dune_Parameters::$pathToAdmin
     * �� ���������: default
     * @var string
     */
    static public $commandHandlerAdmin = 'default';
    
    /**
     * ��� ����-����������� �������� ������ �������� ��������.
     * ���������� ��� ��� �������� � ����� Dune_Parameters::$pathToPage
     * �� ���������: default
     * @var string
     */
    static public $commandHandlerPage = 'default';
    
    /**
     * ������ ������ ������������.
     * ��������� �������� user_status � ������� ���������� ������ Dune_Session::ZONE_AUTH
     *
     * @var integer
     */
    static public $userStatus = 0;
    
    
    static public $results = array();
    
    static public $pathToViewFolder = '';
    
    /**
     * ���� � ����� ������� ������ Dune_AsArray_File_String
     *
     * @var string
     */
    static public $pathToArrayFiles = '!_system/data/afiles';
    
///////////////////////////////////////////////////////////////////
//////////////////    ���������. ����� ������������� �����������.
//////////////////////////////////////////////////////////////////
   /**
    * ����. ��� ������ ������ ����. ������ � ������������ ��� �����������
    *
    * @var Dune_Variables
    * @access private
    */
    static private $instance = NULL;
    
    private $_vars_array = array();
    private $_usingZone = 'default__';
    
  /**
   * ������ ���������� ������ ��� ������ ������
   * ���������� ���������� ��������� ������� ��� ����������� �������
   *
   * �������� ��������� �� ������ � ���������� �����������
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
     * ������ ���������� �� ���������� ini-�����
     * ������� ����� ��������� ���������� � Dune_Parameters
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
     * ��������� ����������� ���� � ������������ ����������.
     *
     * @param string $zone
     */
    public function openZone($zone)
    {
        $this->_usingZone = $zone;
    }
    
    /**
     * ��������� ����������� ���� � ������������ ����������
     */
    public function closeZone()
    {
        $this->_usingZone = 'default__';
    }    

////////////////////////////////////////////////////////////////
///////////////////////////////     ���������� ������
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