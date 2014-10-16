<?php
/**
 * Класс аутентификации с помощью эл. почты
 * 
 * Клас агрегатный. Использует:
 *   Dune_Data_Container_UserName
 *   Dune_MysqliSystem
 *   Dune_Mysqli_Check
 *   Dune_Static_Generate
 * 
 * Исключение:
 *   Dune_Exception_Base
 *   Dune_Exception_Mysqli
 * 
 * ----------------------------------------------------
 * | Библиотека: Dune                                  |
 * | Файл: MailMysqli.php                              |
 * | В библиотеке: Dune/Auth/MailMysqli.php            |
 * | Автор: Андрей Рыжов (Dune) <dune@rznw.ru>        |
 * | Версия: 1.08                                      |
 * | Сайт: www.rznw.ru                                |
 * ----------------------------------------------------
 *
 * История версий:
 *
 * 
 */
class Dune_Auth_Mysqli_UserTemp extends Dune_Mysqli_Abstract_SetDataControl
{

     /**
     * Массив данных пользователя. Всех данных.
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
    protected $userId = 0;
    
    /**
     * e-mail пользователя для обработки
     *
     * @var string
     * @access private
     */
    protected $userMail = '';
    
    /**
     * имя пользователя для обработки
     *
     * @var string
     * @access private
     */
    protected $userName = '';
    
    /**
     * Секретный код
     *
     * @var string
     * @access private
     */
    protected $userCode = '';

    
    /**
     * Секретный пароль
     *
     * @var string
     * @access private
     */
    protected $userPass = '';
    
    /**
     * Флаг успешной выдачи кода ранее
     *
     * @var boolean
     * @access private
     */
    protected $isGetUserCode = false;

    
    /**
     * Флаг успешной выдачи пароля ранее
     *
     * @var boolean
     * @access private
     */
    protected $isGetUserPass = false;
    
    /**
     * Статус пользователя
     *
     * @var string
     * @access private
     */
    protected $userStatus = 0;

    /**
     * Сериализованный массив параметров
     *
     * @var string
     * @access private
     */
    protected $userArray = array();
    
    
    protected $userArrayConfig = array();
    
    /**
     * Время регистрации пользователя
     *
     * @var string
     * @access private
     */
    protected $userTimeRegister;
    
    /**
     * Флаг отсутствия имени пользователя в базе
     * true - не существует
     * 
     * @var boolean
     * @access private
     */
    protected $noExistName = false;

    /**
     * Флаг отсутствия адреса эл. почты пользователя в базе
     * true - не существует
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
     * Имя таблицы пользователей.
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
    
    
    // Доделать обр. к базе
    public function useMail($mail)
    {
        $exist = 0;
        $this->userMail = $mail;
        
        return $this->_check('mail', $mail);        
        
    }

    // Доделать обр. к базе
    public function useName($name)
    {
        $exist = 0;
        $this->userName = $name;
        
        return $this->_check('name', $name);
    }
    
    // Доделать обр. к базе
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
        $this->userCheck = true; // данные о пользователе выбирались
        
        return $exist;
        
    }
    
    public function getAll()
    {
        return $this->_userDataArray;
    }
    
    /**
     * Проверка существования имени пользователя в таблице пользователей.
     *
     * @param string $name имя пользователя для проверки
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
     * Проверка существования адреса эл. почты .
     *
     * @param string $mail адрес эл. почты.
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
     * Проверка строки на идентичность актуальному защитному коду.
     * Вызывается после вызова методов Выборки информации о пользователе
     *
     * @param string $code секретный код в методе проверяется на длину. Применяется trin()
     * @return boolean
     */
    public function checkCode($code, $minimum = 5)
    {
        // Если проверен e-mail, адрес электронной почты сохранён, 
        if ($this->haveDataFromDB and strlen($code) >= $minimum and $code === $this->userCode)
        {
            $this->codeChecked = true;
        }
        return $this->codeChecked;
    }

    /**
     * Проверка строки на идентичность актуальному защитному коду.
     * Вызывается после вызова методов выборки информации о пользователе из базы.
     *
     * @param string $code секретный код
     * @return boolean
     */
    public function checkCodeHash($code, $mode = 0)
    {
        // Если проверен e-mail, адрес электронной почты сохранён, 
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
     * Добавление нового пользователя в главную таблицеу аутентификации.
     * 
     * После приёма кода с почты.
     *
     * @param string $password сериализованны массив параметров. Необязателен.
     * @return boolean флаг успешного сохранения
     */
    public function add($password = null)
    {
        $bool = false;
//  Регенерация защ. кода после подтверждения            
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
     * Возврат секретного кода для отправки по почте.
     * 
     * Вызывается не чаще колличества часов в переменной self::$authTim или сразу после метода regenerateCode()
     * 
     * 
     * @return string секреный код или пустая стока при прошествии малого времени после 
     */
    public function getCode()
    {
       return $this->userCode;
    }

     /**
     * Возврат секретного кода для отправки по почте.
     * 
     * Вызывается не чаще колличества часов в переменной self::$authTim или сразу после метода regenerateCode()
     * 
     * 
     * @return string секреный код или пустая стока при прошествии малого времени после 
     */
    public function getCodeHash()
    {
       return md5($this->userCode);
    }
    
    
     /**
     * Возврат пароля для сравнения с полученным при входе.
     * Вызывается после методов: checkCode(), checkMail()
     * 
     * Вызывается не чаще колличества часов в переменной self::$authTim или сразу после метода regenerateCode()
     * 
     * 
     * @return string секреный код или пустая строка при прошествии малого времени после 
     */
    public function getPassword()
    {
        return substr($this->userPass, 0, 30);
    }    
    
    
    /**
     * Установка нового пароля пользователя для дальнейшего сохранения.
     *
     * @param string $password новый пароль
     */
    public function setPassword($password)
    {
        $this->userPass = $password;
    }
    
    /**
     * Возвращает ящик пользователя
     *
     * @return string
     */
    public function getUserMail()
    {
        return $this->userMail;
    }

    /**
     * Возвращает имя пользователя
     *
     * @return string
     */
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * Возвращает имя пользователя
     *
     * @return string
     */
    public function getUserCode()
    {
        return $this->userCode;
    }
    
    /**
     * Возвращает ID пользователя
     *
     * @return string
     */
    public function getUserId()
    {
        return $this->userId;
    }
    
    
    /**
     * Возвращает код статуса пользователя
     *
     * @return integer
     */
    public function getUserStatus()
    {
        return $this->userStatus;
    }

    /**
     * Возвращает весь массив дополнительной информации пользователя.
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
     * Возвращает весь массив настроек пользователя
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
     * Устанавливает весь массив дополнительной информации пользователя для дальнейшего сохранения
     *
     *  @param array $array массив данных пользователя
     */
    public function setUserArray($array)
    {
        if (!is_array($array))
            throw new Dune_Exception_Base('Параметр функции должен быть массивом');
        $this->userArray = $array;
    }

    
    
/////////////////////////////////////////////////////////////////////////////////
/////   Магические

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
//            Приватные методы
//////////////////////////////////////////////////////////////////////////////////    
    
    /**
     * Генерирует уникальный код.
     *
     * @access private
     */
    protected function _generateCode()
    {
        // 13-ти символьный код
        $this->userCode = Dune_Static_Generate::generateRandomString(13);
        //$this->userCode = uniqid();
    }
    
    
}