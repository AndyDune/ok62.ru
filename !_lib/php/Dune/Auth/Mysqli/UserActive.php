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
class Dune_Auth_Mysqli_UserActive extends Dune_Mysqli_Abstract_SetDataControl
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
    public static $authTableActive = 'dune_auth_user_active';
    
    
    public function __construct($id = false, $options = array())
    {
        $this->allowFields = array(
                                    'phone'           => array('s', 100),
                                    'contact_name'    => array('s', 254),
                                    'contact_surname' => array('s', 100),
                                    'status'          => array('i', 10000),
                                    'icq'             => array('s', 20),
                                   );

        $this->_allowFields = array(
                                    'phone'           => array('s', 100),
                                    'contact_name'    => array('s', 254),
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
        $query = 'SELECT * FROM `' . self::$authTableActive . '`
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
            $this->userStatus = $result['status'];
            $this->userTimeRegister = $result['time'];
            $this->userArray = @unserialize($result['array']);
            if (!is_array($this->userArray))
                $this->userArray = array();

            $this->userArrayConfig = @unserialize($result['array_config']);
            if (!is_array($this->userArrayConfig))
                $this->userArrayConfig = array();
                
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
        
        $bool = Dune_Mysqli_Check::existenceUserName($object, self::$authTableActive, 'name');
        
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
        $q = 'SELECT count(id) FROM ?t WHERE mail = ?';
         
        $result = (boolean)$this->_DB->query($q, array(self::$authTableActive, $mail), Dune_MysqliSystem::RESULT_EL);
        
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
        if ($this->haveDataFromDB and strlen($code) >= $minimum and $code == $this->userCode)
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
    
    
    /**
     * �������� ������ �� ������������ ����������� ��������� ����.
     * ���������� ����� ������ ������ checkMail($mail)
     *
     * @param string $code ��������� ���
     * @return boolean
     */
    public function checkPassword($pass)
    {
        if ($this->haveDataFromDB AND (!strcmp($pass,$this->userPass)))
        {
            $this->passChecked = true;
        }
        return $this->passChecked;
    }
    
    /**
     * �������� ������ �� ������������ ����������� ��������� ����.
     * ���������� ����� ������ ������ checkMail($mail)
     *
     * @param string $code ��������� ���
     * @return boolean
     */
    public function checkPasswordHash($pass)
    {
        if ($this->haveDataFromDB AND (!strcmp($pass,md5($this->userPass))))
        {
            $this->passChecked = true;
        }
        return $this->passChecked;
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
                
            $query = 'INSERT INTO ?t (`id`, `mail`, `name`, `code`, `time`, `password`, `status`,`array`, `array_config`)
                      VAlUES (null,?, ?, ?, NOW(), ?, ?i, ?, ?)';
            
            $bool  = $this->_DB->query($query, array( 
                                                       self::$authTableActive,
                                                       $this->userMail, 
                                                       $this->userName, 
                                                       $this->userCode, 
                                                       $password, 
                                                       $this->userStatus, 
                                                       serialize($this->userArray), 
                                                       serialize($this->userArrayConfig)
                                                      ),
                                        Dune_MysqliSystem::RESULT_ID
                                        );
            return $bool;
    }

    /**
     * ���������� �������� ������ ������������ ����� ���������.
     *
     * @return boolean ���� �������� ��������
     */

    public function updateData()
    {
        $bool = false;
        if ($this->haveDataFromDB)        
        {
            $query = 'UPDATE ?t
                      SET 
                      `array` = ?,
                      `array_config` = ? 
                      ' . $this->_collectDataToSave(true) . '
                      WHERE `id` = ? LIMIT 1';
            
            $result = $this->_DB->query($query, array( self::$authTableActive,
                                                        serialize($this->userArray), 
                                                        serialize($this->userArrayConfig),
                                                        $this->userId
                                                      ),
                                        Dune_MysqliSystem::RESULT_AR
                                        );
            if ($result > 0)
            {
                $bool = true;
            }
        }
        return $bool;
    }

    /**
     * ���������� �������� �������������� ������ ������������ � ����.
     * ����������� ����� ������ setArray()
     *
     * @return boolean ���� �������� ��������
     */
    public function updateArray()
    {
        $bool = false;
        if ($this->haveDataFromDB)        
        {
        
            $query = 'UPDATE ?t
                      SET 
                      `array` = ?
                      WHERE `id` = ?i LIMIT 1';
            
            $array = serialize($this->userArray);
            
            $results = $this->_DB->query($query, array(self::$authTableActive,
                                                       $array,
                                                       $this->userId),
                                                  Dune_MysqliSystem::RESULT_AR);
            if ($results)
            {
                $bool = true;
            }
        }
        return $bool;
    }

    /**
     * ���������� �������� �������������� ������ ������������ � ����.
     * ����������� ����� ������ setArray()
     *
     * @return boolean ���� �������� ��������
     */
    public function updateArrayConfig()
    {
        $bool = false;
        if ($this->haveDataFromDB)        
        {
        
            $query = 'UPDATE ?t
                      SET 
                        `array_config` = ?
                      WHERE `id` = ?i LIMIT 1';
            
            $array = serialize($this->userArrayConfig);
            $results = $this->_DB->query($query, array(self::$authTableActive,
                                                       $array,
                                                       $this->userId),
                                                  Dune_MysqliSystem::RESULT_AR);
            if ($results)
            {
                $bool = true;
            }
        }
        return $bool;
    }
    
    
    /**
     * ���������� ������ ������ � ����.
     * ����������� ����� ������ setPassword() � ����� �������� �������
     *
     * @return boolean ���� �������� ��������
     */
    public function updatePassword()
    {
        $bool = false;
        if ($this->haveDataFromDB)        
        {
            $query = 'UPDATE ?t
                      SET `password` = ?
                      WHERE `id` = ?i LIMIT 1';

            $results = $this->_DB->query($query,
                                         array(
                                                self::$authTableActive,
                                                $this->userPass,
                                                $this->userId
                                               ),
                                         Dune_MysqliSystem::RESULT_AR
                                        );
            if ($results)
            {
                $bool = true;
            }
        }
        return $bool;
    }
        
    
    /**
     * ����������� ���� ������������
     * 
     * ����� ������ �������� ����� getCode()
     * 
     * !!!!! ����� ����� ������ ���������� ������� ������ � ����� ����� � ������� ������
     * 
     * @return boolean ���� ��������� ����������
     */
    public function regenerateCode()
    {
        $bool = false;
        if ($this->haveDataFromDB)        
        {
            $this->_generateCode();
            $query = 'UPDATE ?t SET `code` = ?
                      WHERE `id` = ?i LIMIT 1';
            
            $results = $this->_DB->query($query,
                                         array(
                                                self::$authTableActive,
                                                $this->userCode,
                                                $this->userId
                                               ),
                                         Dune_MysqliSystem::RESULT_AR
                                        );
            if ($results)
            {
                $bool = true;
            }
        }
        return $bool;
    }
    
     /**
     * ������� ���������� ���� ��� �������� �� �����.
     * ���������� ����� �������: checkCode(), checkMail()
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
     * ������������� ��� ������������
     *
     * @return string
     */
    public function setUserName($value)
    {
        $this->userName = $value;
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
     * ������������� ��� ������� ������������
     *
     * @return integer
     */
    public function setUserStatus($value)
    {
        $this->userStatus = $value;
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
     * ���������� ���� ������ �������������� ���������� ������������.
     *
     * @return array
     */
    public function getUserArrayCell($key)
    {
        if (isset($this->userArray[$key]))
            return $this->userArray[$key];
        else 
            return null;
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
     * ���������� ���� ������ �������� ������������
     *
     * @return array
     */
    public function getUserArrayConfigCell($key)
    {
        if (isset($this->userArrayConfig[$key]))
            return $this->userArrayConfig[$key];
        else 
            return null;
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

    public function setUserArrayCell($key, $value)
    {
        $this->userArray[$key] = $value;
    }
    
    /**
     * ������������� ���� ������ �������� ������������ ��� ����������� ����������
     *
     *  @param array $array ������ ������ ������������
     */
    public function setUserArrayConfigCell($key, $value)
    {
        $this->userArrayConfig[$key] = $value;
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