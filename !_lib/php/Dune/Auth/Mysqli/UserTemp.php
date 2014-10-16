<?php
/**
 * ����� �������������� � ������� ��. �����
 * 
 * ���� ����������. ����������:
 *   Dune_Data_Container_UserName
 *   Dune_MysqliSystem
 *   Dune_Mysqli_Check
 *   Dune_Static_Generate
 * 
 * ����������:
 *   Dune_Exception_Base
 *   Dune_Exception_Mysqli
 * 
 * ----------------------------------------------------
 * | ����������: Dune                                  |
 * | ����: MailMysqli.php                              |
 * | � ����������: Dune/Auth/MailMysqli.php            |
 * | �����: ������ ����� (Dune) <dune@rznw.ru>        |
 * | ������: 1.08                                      |
 * | ����: www.rznw.ru                                |
 * ----------------------------------------------------
 *
 * ������� ������:
 *
 * 
 */
class Dune_Auth_Mysqli_UserTemp extends Dune_Mysqli_Abstract_SetDataControl
{

     /**
     * ������ ������ ������������. ���� ������.
     *
     * @var array
     * @access private
     */
    protected $_userDataArray = array(
                                      'id' => null,
                                      'mail' => null,
                                      'name' => null,
                                      'code' => null,
                                      'time' => null,
                                      'password' => null,
                                      'status' => null,
                                      'array' => null,
                                      );
                                      
                                      
                                      
    protected $haveDataFromDB = false;
    
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
    protected $userId = 0;
    
    /**
     * e-mail ������������ ��� ���������
     *
     * @var string
     * @access private
     */
    protected $userMail = '';
    
    /**
     * ��� ������������ ��� ���������
     *
     * @var string
     * @access private
     */
    protected $userName = '';
    
    /**
     * ��������� ���
     *
     * @var string
     * @access private
     */
    protected $userCode = '';

    
    /**
     * ��������� ������
     *
     * @var string
     * @access private
     */
    protected $userPass = '';
    
    /**
     * ���� �������� ������ ���� �����
     *
     * @var boolean
     * @access private
     */
    protected $isGetUserCode = false;

    
    /**
     * ���� �������� ������ ������ �����
     *
     * @var boolean
     * @access private
     */
    protected $isGetUserPass = false;
    
    /**
     * ������ ������������
     *
     * @var string
     * @access private
     */
    protected $userStatus = 0;

    /**
     * ��������������� ������ ����������
     *
     * @var string
     * @access private
     */
    protected $userArray = array();
    
    
    protected $userArrayConfig = array();
    
    /**
     * ����� ����������� ������������
     *
     * @var string
     * @access private
     */
    protected $userTimeRegister;
    
    /**
     * ���� ���������� ����� ������������ � ����
     * true - �� ����������
     * 
     * @var boolean
     * @access private
     */
    protected $noExistName = false;

    /**
     * ���� ���������� ������ ��. ����� ������������ � ����
     * true - �� ����������
     * 
     * @var boolean
     * @access private
     */
    protected $noExistMail = false;
    
    /**
     * @access private
     */
    protected $mailStatus = 0;
    
    /**
     * @access private
     */
    protected $mailChecked = false;
    
    /**
     * @access private
     */
    protected $codeChecked = false;

    /**
     * @access private
     */
    protected $passChecked = false;
    
    /**
     * @access private
     */
    protected $codeAfterGeneration = false;
    
    
    /**
     * ��� ������� �������������.
     * 
     * @var string
     */
    public static $authTable = 'dune_auth_user_temp';
    
    
    public function __construct($id = false, $options = array())
    {
        $this->allowFields = array(
                                    'phone'           => array('s', 20),
                                    'contact_name'    => array('s', 50),
                                    'contact_surname' => array('s', 100),
                                    'status'          => array('i', 10000),
                                    'icq'             => array('s', 20),
                                   );

        $this->_allowFields = array(
                                    'phone'           => array('s', 20),
                                    'contact_name'    => array('s', 50),
                                    'contact_surname' => array('s', 100),
                                    'status'          => array('i', 10000),
                                    'icq'             => array('s', 20),
                                   );
                                   
        $this->_initDB();
        if ($id)
        {
            $this->_check('id', $id, 'i');
        }
    }
    
    
    // �������� ���. � ����
    public function useMail($mail)
    {
        $exist = 0;
        $this->userMail = $mail;
        
        return $this->_check('mail', $mail);        
        
    }

    // �������� ���. � ����
    public function useName($name)
    {
        $exist = 0;
        $this->userName = $name;
        
        return $this->_check('name', $name);
    }
    
    // �������� ���. � ����
    public function useId($id)
    {
        $exist = 0;
        $this->userId = $id;
        
        return $this->_check('id', $id, 'i');
    }
    
    protected function _check($field, $value, $mode = '')
    {
        $query = 'SELECT * FROM `' . self::$authTable . '`
                  WHERE ?c LIKE ?' . $mode . ' LIMIT 1
                  ';
        
        $result = $this->_DB->query($query, array($field, $value), Dune_MysqliSystem::RESULT_ROWASSOC);
        if($result) 
        {
            $this->_userDataArray = $result;
            $exist = true;

            $this->userId = $result['id'];
            $this->userName = $result['name'];
            $this->userMail = $result['mail'];
            $this->userCode = $result['code'];
            $this->userPass = $result['password'];
            $this->userTimeRegister = $result['time'];
            $this->userArray = @unserialize($result['array']);
            if (!is_array($this->userArray))
                $this->userArray = array();

                
            $this->haveDataFromDB = true;
        }
        else 
            $exist = false;
        $this->userCheck = true; // ������ � ������������ ����������
        
        return $exist;
        
    }
    
    public function getAll()
    {
        return $this->_userDataArray;
    }
    
    /**
     * �������� ������������� ����� ������������ � ������� �������������.
     *
     * @param string $name ��� ������������ ��� ��������
     * @return boolean
     */
    public function checkNameExistence($name = null)
    {
        if ($name == null)
            $name = $this->userName;
        else 
            $this->userName = $name;
        $bool = false;
        $object = new Dune_Data_Container_UserName($name);
        
        $bool = Dune_Mysqli_Check::existenceUserName($object, self::$authTable, 'name');
        
        $this->noExistName = !$bool;
        return $bool;
    }

    /**
     * �������� ������������� ������ ��. ����� .
     *
     * @param string $mail ����� ��. �����.
     * @return boolean
     */
    public function checkMailExistence($mail = null)
    {
        if ($mail == null)
            $mail = $this->userMail;
        else 
            $this->userMail = $mail;
        $q = 'SELECT count(id) FROM ?t WHERE mail = ?';
         
        $result = (boolean)$this->_DB->query($q, array(self::$authTable, $mail), Dune_MysqliSystem::RESULT_EL);
        
        return $this->noExistMail = !$result;
        return $result;
    }
    
    
    /**
     * �������� ������ �� ������������ ����������� ��������� ����.
     * ���������� ����� ������ ������� ������� ���������� � ������������
     *
     * @param string $code ��������� ��� � ������ ����������� �� �����. ����������� trin()
     * @return boolean
     */
    public function checkCode($code, $minimum = 5)
    {
        // ���� �������� e-mail, ����� ����������� ����� �������, 
        if ($this->haveDataFromDB and strlen($code) >= $minimum and $code === $this->userCode)
        {
            $this->codeChecked = true;
        }
        return $this->codeChecked;
    }

    /**
     * �������� ������ �� ������������ ����������� ��������� ����.
     * ���������� ����� ������ ������� ������� ���������� � ������������ �� ����.
     *
     * @param string $code ��������� ���
     * @return boolean
     */
    public function checkCodeHash($code, $mode = 0)
    {
        // ���� �������� e-mail, ����� ����������� ����� �������, 
        $code_origin = md5($this->userCode);
        if ($this->haveDataFromDB AND ($code === $code_origin))
        {
            $this->codeChecked = true;
        }
        return $this->codeChecked;
    }
    
    
    
    public function removeOld($interval)
    {
        $query = 'DELETE FROM ' . self::$authTable . '
                  WHERE `time` < NOW() - INTERVAL ?i SECOND';
        return $this->_DB->query($query, array($interval), Dune_MysqliSystem::RESULT_AR);
    }
    
    /**
     * ���������� ������ ������������ � ������� �������� ��������������.
     * 
     * ����� ����� ���� � �����.
     *
     * @param string $password �������������� ������ ����������. ������������.
     * @return boolean ���� ��������� ����������
     */
    public function add($password = null)
    {
        $bool = false;
//  ����������� ���. ���� ����� �������������            
            $this->_generateCode();
            if ($password == null)
                $password = $this->userCode;
                
            $query = 'INSERT INTO ?t (`id`, `mail`, `name`, `code`, `time`, `password`,`array`)
                      VALUES (null,?, ?, ?, NOW(), ?, ?)';
            
            $bool  = $this->_DB->query($query, array( 
                                                       self::$authTable,
                                                       $this->userMail, 
                                                       $this->userName, 
                                                       $this->userCode, 
                                                       $password, 
                                                       serialize($this->userArray)
                                                      ),
                                        Dune_MysqliSystem::RESULT_ID
                                        );
            return $bool;
    }

    
    
    
     /**
     * ������� ���������� ���� ��� �������� �� �����.
     * 
     * ���������� �� ���� ����������� ����� � ���������� self::$authTim ��� ����� ����� ������ regenerateCode()
     * 
     * 
     * @return string �������� ��� ��� ������ ����� ��� ���������� ������ ������� ����� 
     */
    public function getCode()
    {
       return $this->userCode;
    }

     /**
     * ������� ���������� ���� ��� �������� �� �����.
     * 
     * ���������� �� ���� ����������� ����� � ���������� self::$authTim ��� ����� ����� ������ regenerateCode()
     * 
     * 
     * @return string �������� ��� ��� ������ ����� ��� ���������� ������ ������� ����� 
     */
    public function getCodeHash()
    {
       return md5($this->userCode);
    }
    
    
     /**
     * ������� ������ ��� ��������� � ���������� ��� �����.
     * ���������� ����� �������: checkCode(), checkMail()
     * 
     * ���������� �� ���� ����������� ����� � ���������� self::$authTim ��� ����� ����� ������ regenerateCode()
     * 
     * 
     * @return string �������� ��� ��� ������ ������ ��� ���������� ������ ������� ����� 
     */
    public function getPassword()
    {
        return substr($this->userPass, 0, 30);
    }    
    
    
    /**
     * ��������� ������ ������ ������������ ��� ����������� ����������.
     *
     * @param string $password ����� ������
     */
    public function setPassword($password)
    {
        $this->userPass = $password;
    }
    
    /**
     * ���������� ���� ������������
     *
     * @return string
     */
    public function getUserMail()
    {
        return $this->userMail;
    }

    /**
     * ���������� ��� ������������
     *
     * @return string
     */
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * ���������� ��� ������������
     *
     * @return string
     */
    public function getUserCode()
    {
        return $this->userCode;
    }
    
    /**
     * ���������� ID ������������
     *
     * @return string
     */
    public function getUserId()
    {
        return $this->userId;
    }
    
    
    /**
     * ���������� ��� ������� ������������
     *
     * @return integer
     */
    public function getUserStatus()
    {
        return $this->userStatus;
    }

    /**
     * ���������� ���� ������ �������������� ���������� ������������.
     *
     * @return array
     */
    public function getUserArray($is_object = false)
    {
        if ($is_object)
            return new Dune_Array_Container($this->userArray);
        return $this->userArray;
    }

    
    /**
     * ���������� ���� ������ �������� ������������
     *
     * @return array
     */
    public function getUserArrayConfig($is_object = false)
    {
        if ($is_object)
            return new Dune_Array_Container($this->userArrayConfig);
        return $this->userArrayConfig;
    }
    
    
    /**
     * ������������� ���� ������ �������������� ���������� ������������ ��� ����������� ����������
     *
     *  @param array $array ������ ������ ������������
     */
    public function setUserArray($array)
    {
        if (!is_array($array))
            throw new Dune_Exception_Base('�������� ������� ������ ���� ��������');
        $this->userArray = $array;
    }

    
    
/////////////////////////////////////////////////////////////////////////////////
/////   ����������

    public function __set($name, $value)
    {
        $this->_set($name, $value);
    }
    public function __get($name)
    {
        if (isset($this->_userDataArray[$name]))
            return $this->_userDataArray[$name];
        else 
           return false;
    }  


    public function __toString()
    {
    	$string = '<pre>';
    	ob_start();
    	print_r($this->_userDataArray);
    	$string .= ob_get_clean();
    	return  $string . '</pre>';
    }

    
//////////////////////////////////////////////////////////////////////////////////    
//            ��������� ������
//////////////////////////////////////////////////////////////////////////////////    
    
    /**
     * ���������� ���������� ���.
     *
     * @access private
     */
    protected function _generateCode()
    {
        // 13-�� ���������� ���
        $this->userCode = Dune_Static_Generate::generateRandomString(13);
        //$this->userCode = uniqid();
    }
    
    
}