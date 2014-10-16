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
 * | �����: ������ ����� (Dune) <dune@rznlf.ru>        |
 * | ������: 1.08                                      |
 * | ����: www.rznlf.ru                                |
 * ----------------------------------------------------
 *
 * ������� ������:
 *
 * ������ 1.07 -> 1.08
 * ���������� ������
 * 
 * ������ 1.06 -> 1.07
 * ������������������ ������ ������.
 * ������� �������� ��������� ���������� �����.
 * 
 * ������ 1.05 -> 1.06
 * ��������� ������ ��� ������ � �������.
 * 
 * ������ 1.04 -> 1.05
 * � ������ getCode() ������� �������� ���������� ���� ����������� � ��� ������ �� ��������� �������
 * ������� ���������� public static $getCodeTimeInteval - �������� �������� ����� �������� ����. ����
 * 
 * ������ 1.03 -> 1.04
 * ��������� � ������ getUserArray() - �������������� ������ � ������
 * 
 * ������ 1.02 -> 1.03
 * �������� ����� getUserId()
 * 
 * ������ 1.01 -> 1.02
 * ���������� ������ ����������� ���� ������
 * 
 * ������ 1.00 -> 1.01
 * ��������� ����������� �������� ���� 3 ���� ������ � ������� �������������� �������
 *
 * ������ 0.99 -> 1.00
 * ����� ������ �������� � ���������.
 * 
 * 
 */
class Dune_Auth_MailMysqli
{
    /**
     * ��������� �� �����
     *
     * @var unknown_type
     * @access private
     */
    protected $_DB = null;

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
    
    
    protected $isAskUserPass = false;
    
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
    protected $userArray = '';
    
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
    protected $domainChecked = false;
    
    
    /**
     * @access private
     */
    protected $codeAfterGeneration = false;
    
    /**
     * ����� �������� ����� �� ��������� ������� ��� ��������������
     * �� ��������� 7000 ������ (2 ����)
     * @var integer
     */
    public static $authTime = 7000;//3600;

    /**
     * �������� ��� �������� ��������� ����
     * �� ��������� 3600 ������ (1 ���)
     * @var integer
     */
    public static $getCodeTimeInteval = 3600;


    /**
     * �������� ��� �������� ������
     * �� ��������� 7200 ������ (2 ����)
     * @var integer
     */
    public static $askPassTimeInteval = 7200;
    
    /**
     * ��� ������� ��������� �������� ������� �����������.
     * 
     * @var string
     */
    public static $authTableEventsTime = 'dune_auth_events_in_time';
    
    /**
     * ��� ������� �������������.
     * 
     * @var string
     */
    public static $authTableActive = 'dune_auth_user_active';
    
    /**
     * ��� ��������� ������� ��� �������� ������ ��� ��������������
     * 
     * @var string
     */
    public static $authTableTemp = 'dune_auth_user_temp';

    /**
     * ������� ���������� ������� ���������� ���� �������
     * 
     * @var string
     */
    public static $authTableGetCodeTime = 'dune_auth_user_last_time';
    
    /**
     * ������� ���������� ������� ���������� ���� �������
     * 
     * @var string
     */
    public static $authTableGetPassTime = 'dune_auth_last_time_get_pass';
    
    /**
     * ������� ����������� ������� �����
     * 
     * @var string
     */
    public static $authTableAlloyDomain = 'dune_mail_alloy_domain';

    /**
     * ������� "������� ������" �������� ������
     * 
     * @var string
     */
    public static $authTableMailBlackList = 'dune_mail_black_list';
    
    
    public function __construct($options = array())
    {
        if (key_exists('storage_engine', $options))
        {
            $options['storage_engine'] = strtolower($options['storage_engine']);
            if (!in_array($options['storage_engine'], $this->_availableStorageEngine))
            {
                throw new Dune_Exception_Base('������������ ������ �� ('. $options['storage_engine'] . ')');
            }
            $this->_storageEngine = $options['storage_engine'];
        }
        $this->_initDB();        
    }
    
    
    // �������� ���. � ����
    public function checkMail($mail)
    {
        $exist = 0;
        $this->userMail = $mail;
        
        $query = 'SELECT `id`, `name`, `code`, `password`, `status`, `time`, `array` FROM `' . self::$authTableActive . '`
                  WHERE `mail` LIKE ? LIMIT 1
                  ';
        $stmt = $this->_DB->prepare($query);
        $stmt->bind_param('s', $mail);
        $stmt->execute();
        if ($stmt->errno)
            throw new Dune_Exception_Mysqli("������ � ���������� �������: ".$stmt->error);
        $stmt->store_result();
        if($stmt->num_rows > 0) 
        {
        // ����� ����� ��� ���������������
            $stmt->bind_result($userId,
                               $userName,
                               $userCode,
                               $userPass,
                               $userStatus,
                               $userTimeRegister,
                               $userArray
                               ); 
            $stmt->fetch();
            $exist = 1;
            $stmt->close();

            $this->userId = $userId;
            $this->userName = $userName;
            $this->userCode = $userCode;
            $this->userPass = $userPass;
            $this->userStatus = $userStatus;
            $this->userTimeRegister = $userTimeRegister;
            $this->userArray = @unserialize($userArray);
            if (!is_array($this->userArray))
                $this->userArray = array();
        }
        else 
        {
        // ��������� ��������� �������
            $stmt->close();
            // �������� ���������� �����
            $query = 'DELETE FROM ' . self::$authTableTemp . '
                      WHERE `time` < NOW() - INTERVAL ? SECOND';
            $stmt = $this->_DB->prepare($query);
            $stmt->bind_param('d', self::$authTime);
            $stmt->execute();
            $stmt->close();
            // ��������� ���� �� e-mail �� ��������� �������
            $query = 'SELECT `id`, `name`, `code`, `array` FROM `' . self::$authTableTemp . '`
                      WHERE `mail` LIKE ? LIMIT 1
                      ';
            $stmt = $this->_DB->prepare($query);
            $stmt->bind_param('s', $mail);
            $stmt->execute();
            if ($stmt->errno)
                throw new Dune_Exception_Mysqli("������ � ���������� �������: ".$stmt->error);
            $stmt->store_result();
            if($stmt->num_rows > 0) 
            {
            // ����� ����� ��������������� �� ��������� �������
                $stmt->bind_result($userId, $userName, $userCode, $userArray); 
                $stmt->fetch();
                $exist = 2;
                $this->userId = $userId;
                $this->userName = $userName;
                $this->userCode = $userCode;
                $this->userPass = $userCode;
                $this->userArray = $userArray;
                $this->userArray = @unserialize($userArray);
                if (!is_array($this->userArray))
                    $this->userArray = array();
            }
            $stmt->close();
        }
        $this->mailStatus = $exist; // ���������� ������
        $this->mailChecked = true; // ����� ����� ��������
        
        return $exist;
    }
    
    /**
     * �������� ������������� ����� ������������ � �������� ������������� � ���������.
     *
     * @param string $name ��� ������������ ��� ��������
     * @return boolean
     */
    public function checkNameExistence($name)
    {
        $this->userName = $name;
        $bool = false;
        $object = new Dune_Data_Container_UserName($name);
        
        $bool = Dune_Mysqli_Check::existenceUserName($object, self::$authTableActive, 'name') ||
                Dune_Mysqli_Check::existenceUserName($object, self::$authTableTemp, 'name');
        
        $this->noExistName = !$bool;
        return $bool;
    }

    /**
     * �������� ������ �� ������������ ����������� ��������� ����.
     * ���������� ����� ������ ������ checkMail($mail)
     *
     * @param string $code ��������� ���
     * @return boolean
     */
    public function checkCode($code)
    {
        // ���� �������� e-mail, ����� ����������� ����� �������, 
        if (($this->mailChecked) AND ($this->mailStatus) AND ($code == $this->userCode))
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
    public function checkCodePlus($code, $mode = 0)
    {
        // ���� �������� e-mail, ����� ����������� ����� �������, 
        $code_origin = md5($this->userMail . $this->userCode);
        if (($this->mailChecked) AND ($this->mailStatus) AND ($code == $code_origin))
        {
            $this->codeChecked = true;
        }
        return $this->codeChecked;
    }
    
    
    /**
     * ���������� ������ ������������ �� ��������� �������.
     * � �������� ������������� ����, ���������� �� �����.
     *
     * @param string $string �������������� ������ ����������. ������������.
     * @return boolean ���� ��������� ����������
     */
    public function saveTemp($string = '')
    {
        $bool = false;
        if (($this->noExistName) AND ($this->mailChecked) AND ($this->mailStatus == 0))
        {
            $this->_generateCode();
            $this->codeAfterGeneration = true;
            $query = 'INSERT INTO ' . self::$authTableTemp . '(`id`, `mail`, `name`, `code`, `time`, `array`)
                      VAlUES (null, ?, ?, ?, NOW(), ?)';
            $stmt = $this->_DB->prepare($query);
            $stmt->bind_param('ssss', $this->userMail, $this->userName, $this->userCode, $string);
            $stmt->execute();
            if ($stmt->errno)
                throw new Dune_Exception_Mysqli("������ � ���������� �������: ".$stmt->error);
            $stmt->store_result();                
            if ($stmt->affected_rows > 0)
            {
                $bool = true;
            }
            $stmt->close();
        }
        return $bool;
    }

    
    
    
    /**
     * ���������� ������ ������������ � ������� ������� ��������������.
     * ���������� ����� �������: checkCode(), checkMail()
     * 
     * ����� ����� ���� � �����.
     *
     * @param string $string �������������� ������ ����������. ������������.
     * @return boolean ���� ��������� ����������
     */
    public function save($string = '')
    {
        $bool = false;
        if (($this->mailChecked) AND ($this->mailStatus == 2) AND ($this->codeChecked))
        {
//  ����������� ���. ���� ����� �������������            
            $this->_generateCode();

            $this->codeAfterGeneration = true;
            $query = 'INSERT INTO ' . self::$authTableActive . '(`id`, `mail`, `name`, `code`, `time`, `password`,`array`)
                      VAlUES (null,?, ?, ?, NOW(), ?, ?)';
            $stmt = $this->_DB->prepare($query);
            $stmt->bind_param('sssss', $this->userMail, $this->userName, $this->userCode, $this->userCode, $string);
            $stmt->execute();
            if ($stmt->errno)
                throw new Dune_Exception_Mysqli("������ � ���������� �������: ".$stmt->error);
            $stmt->store_result();                
            if ($stmt->affected_rows > 0)
            {
                $bool = true;
            }
            $stmt->close();
        }
        return $bool;
    }

    /**
     * ���������� ������ ������������ ����� ���������.
     *
     * @return boolean ���� �������� ��������
     */

    public function updateAll()
    {
        $bool = false;
        if (($this->mailChecked) AND ($this->mailStatus == 1))
        {
            $query = 'UPDATE `' . self::$authTableActive . '`
                      SET 
                      `mail` = ?,
                      `name` = ?,
                      `code` = ?,
                      `password` = ?,
                      `array` = ?
                      WHERE `id` = ? LIMIT 1';
            
            $stmt = $this->_DB->prepare($query);
            $array = serialize($this->userArray);
            $stmt->bind_param('sssssi', $this->userMail, $this->userName, $this->userCode, $this->userPass, $array,
                                        $this->userId);
            $stmt->execute();
            if ($stmt->errno)
                throw new Dune_Exception_Mysqli("������ � ���������� �������: ".$stmt->error);
            $stmt->store_result();
            if ($stmt->affected_rows > 0)
            {
                $bool = true;
            }
            $stmt->close();
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
        if (($this->mailChecked) AND ($this->mailStatus == 1))
        {
            $query = 'UPDATE `' . self::$authTableActive . '`
                      SET 
                      `array` = ?
                      WHERE `id` = ? LIMIT 1';
            
            $stmt = $this->_DB->prepare($query);
            $array = serialize($this->userArray);
            $stmt->bind_param('si', $array, $this->userId);
            $stmt->execute();
            if ($stmt->errno)
                throw new Dune_Exception_Mysqli("������ � ���������� �������: ".$stmt->error);
            $stmt->store_result();
            if ($stmt->affected_rows > 0)
            {
                $bool = true;
            }
            $stmt->close();
        }
        return $bool;
    }
    
    /**
     * ���������� ������ ������ � ����.
     * ����������� ����� ������ setPassword()
     *
     * @return boolean ���� �������� ��������
     */
    public function updatePassword()
    {
        $bool = false;
        if (($this->mailChecked) AND ($this->mailStatus == 1))
        {
            $query = 'UPDATE `' . self::$authTableActive . '`
                      SET 
                      `password` = ?
                      WHERE `id` = ? LIMIT 1';
            
            $stmt = $this->_DB->prepare($query);
            $array = serialize($this->userArray);
            $stmt->bind_param('si', $this->userPass, $this->userId);
            $stmt->execute();
            if ($stmt->errno)
                throw new Dune_Exception_Mysqli("������ � ���������� �������: ".$stmt->error);
            $stmt->store_result();
            if ($stmt->affected_rows > 0)
            {
                $bool = true;
            }
            $stmt->close();
        }
        return $bool;
    }
        
    
    /**
     * ����������� ���� ������������
     * ���������� ����� �������: checkCode(), checkMail()
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
        if (($this->mailChecked) AND ($this->mailStatus == 1) AND ($this->codeChecked))
        {
            $this->_generateCode();
            $query = 'UPDATE `' . self::$authTableActive . '` SET `code` = ?
                      WHERE `id` = ? LIMIT 1';
            $stmt = $this->_DB->prepare($query);
            $stmt->bind_param('sd', $this->userCode, $this->userId);
            $stmt->execute();
            if ($stmt->errno)
                throw new Dune_Exception_Mysqli("������ � ���������� �������: ".$stmt->error);
            $stmt->store_result();                
            if ($stmt->affected_rows > 0)
            {
                $bool = true;
                $this->codeAfterGeneration = true;
                $query = 'REPLACE INTO `' . self::$authTableGetCodeTime . '`
                          SET `id`   = ?,
                              `time` = NOW()
                         ';
                $stmt_2 = $this->_DB->prepare($query);
                $stmt_2->bind_param('d', $this->userId);
                $stmt_2->execute();
                $stmt_2->close();
                
            }
            $stmt->close();
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
        if ($this->isGetUserCode)
        {
            return $this->userCode;
        }
        $code = '';
        // ���� ������� ������� ����� ����� ����������� ����
        if ($this->codeAfterGeneration)
        {
            $this->isGetUserCode = true;
            return $this->userCode;
        }
//        if (($this->mailChecked) AND ($this->mailStatus == 1)) // ������� ���������� ������ ��� ������������������
        if (($this->mailChecked) AND ($this->mailStatus)) // ������� ����������� � ��� �����. � ��� ������ �����������
        {
            $this->_DB->autocommit(FALSE);
            // ��������� ��� ����� ��� ������ �� ��� ��������������
            $query = 'SELECT UNIX_TIMESTAMP(`time`), `count`  FROM `' . self::$authTableGetCodeTime . '`
                      WHERE `id` = ?
                      LIMIT 1
                     ';
            $stmt = $this->_DB->prepare($query);
            $stmt->bind_param('d', $this->userId);
            $stmt->execute();
            if ($stmt->errno)
                throw new Dune_Exception_Mysqli("������ � ���������� �������: ".$stmt->error);
            $stmt->store_result();
            
            // ���� �� ��������� � �������
            switch ($stmt->num_rows)
            {
                case 0:
                    // �� ���� �� ������������ ���
                    $query = 'REPLACE INTO `' . self::$authTableGetCodeTime . '`
                              SET `id`   = ?,
                                  `time` = NOW()
                             ';
                    $stmt_2 = $this->_DB->prepare($query);
                    $stmt_2->bind_param('d', $this->userId);
                    $stmt_2->execute();
                    if ($stmt_2->errno)
                        throw new Dune_Exception_Mysqli("������ � ���������� �������: ".$stmt->error);
                    $stmt_2->close();
                    $code = $this->userCode;
                    $this->isGetUserCode = true;
                break;
                default:
                    // ��������� ������
                    $stmt->bind_result($time, $count); 
                    $stmt->fetch();
                    if ($time < (time() - self::$getCodeTimeInteval))
                    {
                    // � ������� ���������� ������� ������ ���������� �������
                        $query = 'UPDATE `' . self::$authTableGetCodeTime . '`
                                  SET `count` = 0,
                                       `time` = NOW()
                                  WHERE `id` = ?
                                  LIMIT 1
                                 ';
                        $stmt_2 = $this->_DB->prepare($query);
                        $stmt_2->bind_param('d', $this->userId);
                        $stmt_2->execute();
                        if ($stmt_2->errno)
                            throw new Dune_Exception_Mysqli("������ � ���������� �������: ".$stmt->error);
                        $stmt_2->close();
                        $code = $this->userCode;
                        $this->isGetUserCode = true;
                    }                    
                    else if ($count < 2)
                    {
                    // �������� �������� �� ������ ������������� ��������
                        $query = 'UPDATE `' . self::$authTableGetCodeTime . '`
                                  SET `count` = `count` + 1
                                  WHERE `id`  = ? LIMIT 1
                                 ';
                        $stmt_2 = $this->_DB->prepare($query);
                        $stmt_2->bind_param('d', $this->userId);
                        $stmt_2->execute();
                        if ($stmt_2->errno)
                            throw new Dune_Exception_Mysqli("������ � ���������� �������: ".$stmt->error);
                        $stmt_2->close();
                        $code = $this->userCode;
                        $this->isGetUserCode = true;
                    }
            }
            $stmt->close();      
            
                $this->_DB->commit();
                $this->_DB->autocommit(true);
            
        }
        return $code;
    }

    
    
     /**
     * ������� ���������� ���� ��� ��������� � �������� ��� �������� ������������� �����.
     * ���������� ����� �������: checkCode(), checkMail()
     * 
     * ���������� �� ���� ����������� ����� � ���������� self::$authTim ��� ����� ����� ������ regenerateCode()
     * 
     * 
     * @return string �������� ��� ��� ������ ����� ��� ���������� ������ ������� ����� 
     */
    public function getCodeFromTemp()
    {
        if ($this->mailStatus == 2)
            $result = $this->userCode;
        else 
            $result = '';
        return  $result;
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
        // ���� �������� e-mail, ����� ����������� ����� �������, 
        if (($this->mailChecked) AND ($this->mailStatus) AND ($pass == $this->userPass))
        {
            $this->passChecked = true;
        }
        return $this->passChecked;
    }
    
    
    
    
     /**
     * ������� ������ ��� ��������� � ���������� ��� �����.
     * ���������� ����� �������: checkCode(), checkMail()
     * 
     * ���������� �� ���� ����������� ����� � ���������� self::$authTim ��� ����� ����� ������ regenerateCode()
     * 
     * 
     * @return string �������� ��� ��� ������ ����� ��� ���������� ������ ������� ����� 
     */
    public function getPassword()
    {
        if ($this->isGetUserPass)
        {
            return $this->userPass;
        }
        $pass = '';
//        if (($this->mailChecked) AND ($this->mailStatus == 1)) // ������� ���������� ������ ��� ������������������
        if (($this->mailChecked) AND ($this->mailStatus)) // ������� ����������� � ��� �����. � ��� ������ �����������
        {
            $this->_DB->autocommit(FALSE);
            // ��������� ��� ����� ��� ������ �� ��� ��������������
            $query = 'SELECT UNIX_TIMESTAMP(`time`), `count`  FROM `' . self::$authTableGetPassTime . '`
                      WHERE `id` = ?
                      LIMIT 1
                     ';
            $stmt = $this->_DB->prepare($query);
            $stmt->bind_param('d', $this->userId);
            $stmt->execute();
            if ($stmt->errno)
                throw new Dune_Exception_Mysqli("������ � ���������� �������: ".$stmt->error);
            $stmt->store_result();
            
            // ���� �� ��������� � �������
            switch ($stmt->num_rows)
            {
                case 0:
                    // �� ���� �� ������������ ���
                    $query = 'REPLACE INTO `' . self::$authTableGetPassTime . '`
                              SET `id`   = ?,
                                  `time` = NOW()
                             ';
                    $stmt_2 = $this->_DB->prepare($query);
                    $stmt_2->bind_param('d', $this->userId);
                    $stmt_2->execute();
                    if ($stmt_2->errno)
                        throw new Dune_Exception_Mysqli("������ � ���������� �������: ".$stmt->error);
                    $stmt_2->close();
                    $pass = $this->userPass;
                    $this->isGetUserPass = true;
                break;
                default:
                    // ��������� ������
                    $stmt->bind_result($time, $count); 
                    $stmt->fetch();
                    if ($time < (time() - self::$getCodeTimeInteval))
                    {
                    // � ������� ���������� ������� ������ ���������� �������
                        $query = 'UPDATE `' . self::$authTableGetPassTime . '`
                                  SET `count` = 0,
                                       `time` = NOW()
                                  WHERE `id` = ?
                                  LIMIT 1
                                 ';
                        $stmt_2 = $this->_DB->prepare($query);
                        $stmt_2->bind_param('d', $this->userId);
                        $stmt_2->execute();
                        if ($stmt_2->errno)
                            throw new Dune_Exception_Mysqli("������ � ���������� �������: ".$stmt->error);
                        $stmt_2->close();
                        $pass = $this->userPass;
                        $this->isGetUserPass = true;
                    }                    
                    else if ($count < 2)
                    {
                    // �������� �������� �� ������ ������������� ��������
                        $query = 'UPDATE `' . self::$authTableGetPassTime . '`
                                  SET `count` = `count` + 1
                                  WHERE `id`  = ? LIMIT 1
                                 ';
                        $stmt_2 = $this->_DB->prepare($query);
                        $stmt_2->bind_param('d', $this->userId);
                        $stmt_2->execute();
                        if ($stmt_2->errno)
                            throw new Dune_Exception_Mysqli("������ � ���������� �������: ".$stmt->error);
                        $stmt_2->close();
                        $pass = $this->userPass;
                        $this->isGetUserPass = true;
                    }
            }
            $stmt->close();      
            
                $this->_DB->commit();
                $this->_DB->autocommit(true);
            
        }
        return $pass;
    }    
    
    
    
    
    
     /**
     * ������� ������ ��� ��������� � ���������� ��� �����.
     * ���������� ����� �������: checkCode(), checkMail()
     * 
     * ���������� �� ���� ����������� ����� � ���������� self::$authTim ��� ����� ����� ������ regenerateCode()
     * 
     * 
     * @return string �������� ��� ��� ������ ����� ��� ���������� ������ ������� ����� 
     */
    public function askPassword()
    {
        $pass = '';
        if ($this->isAskUserPass)
        {
            $pass = $this->userPass;
        }
//        if (($this->mailChecked) AND ($this->mailStatus == 1)) // ������� ���������� ������ ��� ������������������
        else if (($this->mailChecked) AND ($this->mailStatus)) // ������� ����������� � ��� �����. � ��� ������ �����������
        {
            $this->_DB->autocommit(FALSE);
            // ��������� ��� ����� ��� ������ �� ��� ��������������
            $query = 'SELECT UNIX_TIMESTAMP(`ask_password`)  FROM `' . self::$authTableEventsTime . '`
                      WHERE `id` = ?
                      LIMIT 1
                     ';
            $stmt = $this->_DB->prepare($query);
            $stmt->bind_param('d', $this->userId);
            $stmt->execute();
            if ($stmt->errno)
                throw new Dune_Exception_Mysqli("������ � ���������� �������: ".$stmt->error);
            $stmt->store_result();
            
            // ���� �� ��������� � �������
            switch ($stmt->num_rows)
            {
                case 0:
                    // �� ���� �� ������������ ���
                    $query = 'REPLACE INTO `' . self::$authTableEventsTime . '`
                              SET `id`   = ?,
                                  `ask_password` = NOW()
                             ';
                    $stmt_2 = $this->_DB->prepare($query);
                    $stmt_2->bind_param('d', $this->userId);
                    $stmt_2->execute();
                    if ($stmt_2->errno)
                        throw new Dune_Exception_Mysqli("������ � ���������� �������: ".$stmt->error);
                    $stmt_2->close();
                    $pass = $this->userPass;
                    $this->isAskUserPass = true;
                break;
                case 1:
                    // ��������� ������
                    $stmt->bind_result($time); 
                    $stmt->fetch();
                    if ($time < (time() - self::$askPassTimeInteval))
                    {
                    // � ������� ���������� ������� ������ ���������� �������
                        $query = 'UPDATE `' . self::$authTableEventsTime . '`
                                  SET `ask_password` = NOW()
                                  WHERE `id` = ?
                                  LIMIT 1
                                 ';
                        $stmt_2 = $this->_DB->prepare($query);
                        $stmt_2->bind_param('d', $this->userId);
                        $stmt_2->execute();
                        if ($stmt_2->errno)
                            throw new Dune_Exception_Mysqli("������ � ���������� �������: ".$stmt->error);
                        $stmt_2->close();
                        $pass = $this->userPass;
                        $this->isAskUserPass = true;
                    }
            }
            $stmt->close();      
            
                $this->_DB->commit();
                $this->_DB->autocommit(true);
            
        }
        // ��� ��������
        //$pass = $this->userPass;
        return $pass;
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
    public function getMail()
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
     * ���������� ������ �������� ������������
     *
     * @return array
     */
    public function getUserArray()
    {
        return $this->userArray;
    }

    /**
     * ������������� ������ �������� ������������ ��� ����������� ����������
     *
     *  @param array $array ������ ������ ������������
     */
    public function setUserArray($array)
    {
        if (!is_array($array))
            throw new Dune_Exception_Base('�������� ������� ������ ���� ��������');
        $this->userArray = serialize($array);
    }

    
    /**
     * ���������� ��� ������� ������ ����������� �����
     * 0 - ����������
     * 1 - ���������������
     * 2 - ��������� �� ��������
     *
     * @return integer
     */
    public function getMailStatus()
    {
        return $this->mailStatus;
    }
    
    /**
     * �������� ��������� ������ � ������ �����������
     * true - ������ � ����������� ������
     * 
     * @param string $domain ����� ����� ����: mail.ru
     * @return boolean 
     */
    public function checkDomain($domain)
    {
        $bool = false;
        // ��������� ���� �� e-mail �� ��������� �������
        $query = 'SELECT `id` FROM `' . self::$authTableAlloyDomain . '`
                  WHERE `domain` LIKE ? LIMIT 1
                  ';
        $stmt = $this->_DB->prepare($query);
        $stmt->bind_param('s', $domain);
        $stmt->execute();
        if ($stmt->errno)
            throw new Dune_Exception_Mysqli("������ � ���������� �������: ".$stmt->error);
        $stmt->store_result();
        if($stmt->num_rows > 0) 
        {
            $bool = true;
            $this->domainChecked = true;
        }
        $stmt->close();
        return $bool;
    }
    
    /**
     * �������� �� ��������� ������ ��� ����� � ������ ������
     * true - �� ������
     * 
     * @param string $mail
     * @return boolean ���� ��������� � ������
     */
    public function checkMailBlackList($mail)
    {
        $bool = true;
        // ��������� ���� �� e-mail �� ��������� �������
        $query = 'SELECT `id` FROM `' . self::$authTableMailBlackList . '`
                  WHERE `mail` LIKE ? LIMIT 1
                  ';
        $stmt = $this->_DB->prepare($query);
        $stmt->bind_param('s', $mail);
        $stmt->execute();
        if ($stmt->errno)
            throw new Dune_Exception_Mysqli("������ � ���������� �������: ".$stmt->error);
        $stmt->store_result();
        if($stmt->num_rows > 0) 
        {
            $bool = false;
        }
        $stmt->close();
        return $bool;
    }
    
//////////////////////////////////////////////////////////////////////////////////    
//            ��������� ������
//////////////////////////////////////////////////////////////////////////////////    
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