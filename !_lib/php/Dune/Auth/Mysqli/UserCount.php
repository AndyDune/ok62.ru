<?php
/**
 * 
 * ���� ����������. ����������:
 *   Dune_MysqliSystem
 * 
 * ����������:
 *   Dune_Exception_Base
 *   Dune_Exception_Mysqli
 * 
 * ----------------------------------------------------
 * | ����������: Dune                                  |
 * | ����: UserCount.php                               |
 * | � ����������: Dune/Auth/Mysqli/UserCount.php      |
 * | �����: ������ ����� (Dune) <dune@rznw.ru>         |
 * | ������: 0.90                                      |
 * | ����: www.rznw.ru                                 |
 * ----------------------------------------------------
 *
 * ������� ������:
 * 0.90 ����������� � ��������������.
 *
 * 
 */
class Dune_Auth_Mysqli_UserCount implements Dune_Interface_BeforePageOut
{
    /**
     * ��������� �� �����
     *
     * @var unknown_type
     * @access private
     */
    protected $_DB = null;


                                      
    protected $_haveDataFromDB = false;
    
    /**
     * ������ ���� ������ ��� ������
     *
     * @var unknown_type
     * @access private
     */
    protected $_storageEngine = 'myisam';
    
    /**
     * ������ ���� ������ ��� ������
     *
     * @var unknown_type
     * @access private
     */
    protected $_availableStorageEngine = array('myisam', 'innodb');

    /**
     * ID ������������ � ����
     *
     * @var integer
     * @access private
     */
    protected $_userId = 0;
    

    protected $_countArrayVariable = array();
    
    /**
     * ������� ����� ������ �� ������
     * 
     * @var integer
     * @access private
     */
    protected $_countPasswordCheck = 0;

    /**
     *
     * @var string
     * @access private
     */
    protected $_count = 0;
    
    
    protected $_modify = false;
    protected $doneBeforePageOut = false;
    
    /**
     * ��� ������� 
     * 
     * @var string
     */
    public static $_table = 'dune_auth_user_count';
    
    
    
   /**
    * ����. ��� ������ ������ ����. ������ � ������������ ��� �����������
    *
    * @var ��������� �� ������
    */
  static private $instance = NULL;

  
  /**
   * ������ ���������� ������ ��� ������ ������
   * ���������� ���������� ��������� ������� ��� ����������� �������
   *
   * 
   * @return Dune_Auth_Mysqli_UserCount
   */
  static function getInstance($id)
  {
    if (self::$instance == NULL)
    {
      self::$instance = new Dune_Auth_Mysqli_UserCount($id);
    }
    return self::$instance;
  }
    
    
    protected function __construct($id)
    {
        $this->_userId = $id;
        $this->_initDB();
        $this->_readTable();
    }
    
    public function getCountPasswordCheck()
    {
        return $this->_countPasswordCheck;

    }
    
    public function setCountPasswordCheck($value = 0, $iter = false)
    {
        $this->_modify = true;
        if ($iter)
            $this->_countPasswordCheck = $this->_countPasswordCheck + 1;
        else 
            $this->_countPasswordCheck = $value;
    }

    
    
    
    public function getCount($name, $default = 0)
    {
        if (isset($this->_countArrayVariable[$name]))
            $count = $this->_countArrayVariable[$name];
        else 
            $count = $default;
        return $count;
    }

    public function setCount($name, $value = 0)
    {
        $this->_modify = true;
        $this->_countArrayVariable[$name] = $value;
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
//            ��������� ������
//////////////////////////////////////////////////////////////////////////////////    

    protected function _readTable()
    {
        $q = 'SELECT password_check,
                     array
                     FROM `' . self::$_table . '` WHERE `id` = ?i';
        $result = $this->_DB->query($q, array($this->_userId), Dune_MysqliSystem::RESULT_ROWASSOC);
        if ($result !== false)
        {
            $this->_countArrayVariable = @unserialize($result['array']);
            if (!is_array($this->_countArrayVariable))
                $this->_countArrayVariable = array();
            $this->_countPasswordCheck = $result['password_check'];
            $this->_haveDataFromDB = true;
        }
    }
    
    protected function _writeTable()
    { 
        $q = 'INSERT INTO `' . self::$_table . '` 
                     SET
                         id = ?i,
                         password_check = ?i,
                         array = ?
                     ON DUPLICATE KEY UPDATE
                         password_check = ?i,
                         array = ?
                     ';
        $ser = serialize($this->_countArrayVariable);
        $result = $this->_DB->query($q, array(
                                              $this->_userId,
                                              $this->_countPasswordCheck,
                                              $ser,
                                              $this->_countPasswordCheck,
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
     * ���������� ������ ���������� Dune_Interface_BeforePageOut.
     * 
     * �������� ����� ������ �������, ����� ������� ��������.
     *
     */
    public function doBeforePageOut()
    {
        // ���� ������ ���� � ���������� ���������� 1-� ���
        if (!$this->doneBeforePageOut)
        {
            $this->commit();
            $this->doneBeforePageOut = true;
        }
    }
    
    
    /**
     * ������������� ��������� �� ������ mysqli
     *
     * @access private
     */
    protected function _initDB()
    {
        if ($this->_DB == null)
            $this->_DB = Dune_MysqliSystem::getInstance();
    }
    
}