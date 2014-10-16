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
 * | Автор: Андрей Рыжов (Dune) <dune@rznlf.ru>        |
 * | Версия: 1.08                                      |
 * | Сайт: www.rznlf.ru                                |
 * ----------------------------------------------------
 *
 * История версий:
 *
 * Версия 1.07 -> 1.08
 * Исправлены ошибки
 * 
 * Версия 1.06 -> 1.07
 * Условершенствована добыча пароля.
 * Изменен механизм генерации случайного числа.
 * 
 * Версия 1.05 -> 1.06
 * Добавлены методы для работы с паролем.
 * 
 * Версия 1.04 -> 1.05
 * В методе getCode() попытки проверки секретного кода учитываются и для данных из временной таблицы
 * Введена переменная public static $getCodeTimeInteval - интервал подсчёта числа запросов секр. кода
 * 
 * Версия 1.03 -> 1.04
 * Изменение в методе getUserArray() - преобразование строки в массив
 * 
 * Версия 1.02 -> 1.03
 * Добавлен метод getUserId()
 * 
 * Версия 1.01 -> 1.02
 * Исправлена ошибка регенерации кода защиты
 * 
 * Версия 1.00 -> 1.01
 * Добавлена возможность отправки кода 3 раза подряд в течении установленного времени
 *
 * Версия 0.99 -> 1.00
 * Класс прошеёл проверку и доработку.
 * 
 * 
 */
class Dune_Auth_MailMysqli
{
    /**
     * Указатель на класс
     *
     * @var unknown_type
     * @access private
     */
    protected $_DB = null;

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
    
    
    protected $isAskUserPass = false;
    
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
    protected $userArray = '';
    
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
     * Время хранения данны во временной таблице для аутентификации
     * По умолчанию 7000 секунд (2 часа)
     * @var integer
     */
    public static $authTime = 7000;//3600;

    /**
     * Интервал для запросов защитного кода
     * По умолчанию 3600 секунд (1 час)
     * @var integer
     */
    public static $getCodeTimeInteval = 3600;


    /**
     * Интервал для запросов пароля
     * По умолчанию 7200 секунд (2 часа)
     * @var integer
     */
    public static $askPassTimeInteval = 7200;
    
    /**
     * Имя таблицы временных моментов событий авторизации.
     * 
     * @var string
     */
    public static $authTableEventsTime = 'dune_auth_events_in_time';
    
    /**
     * Имя таблицы пользователей.
     * 
     * @var string
     */
    public static $authTableActive = 'dune_auth_user_active';
    
    /**
     * Имя временной таблицы для хранения данных для аутентификации
     * 
     * @var string
     */
    public static $authTableTemp = 'dune_auth_user_temp';

    /**
     * Таблица последнего времени считывания кода доступа
     * 
     * @var string
     */
    public static $authTableGetCodeTime = 'dune_auth_user_last_time';
    
    /**
     * Таблица последнего времени считывания кода доступа
     * 
     * @var string
     */
    public static $authTableGetPassTime = 'dune_auth_last_time_get_pass';
    
    /**
     * Таблица разрешённых доменов почты
     * 
     * @var string
     */
    public static $authTableAlloyDomain = 'dune_mail_alloy_domain';

    /**
     * Таблица "чёрного списка" почтовых ящиков
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
                throw new Dune_Exception_Base('Недопустимый движок БД ('. $options['storage_engine'] . ')');
            }
            $this->_storageEngine = $options['storage_engine'];
        }
        $this->_initDB();        
    }
    
    
    // Доделать обр. к базе
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
            throw new Dune_Exception_Mysqli("Ошибка в отложенном запросе: ".$stmt->error);
        $stmt->store_result();
        if($stmt->num_rows > 0) 
        {
        // Адрес почты уже зарегистрирован
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
        // Проверяем временную таблицу
            $stmt->close();
            // Удаление устаревших строк
            $query = 'DELETE FROM ' . self::$authTableTemp . '
                      WHERE `time` < NOW() - INTERVAL ? SECOND';
            $stmt = $this->_DB->prepare($query);
            $stmt->bind_param('d', self::$authTime);
            $stmt->execute();
            $stmt->close();
            // Проверяем есть ли e-mail во временной таблице
            $query = 'SELECT `id`, `name`, `code`, `array` FROM `' . self::$authTableTemp . '`
                      WHERE `mail` LIKE ? LIMIT 1
                      ';
            $stmt = $this->_DB->prepare($query);
            $stmt->bind_param('s', $mail);
            $stmt->execute();
            if ($stmt->errno)
                throw new Dune_Exception_Mysqli("Ошибка в отложенном запросе: ".$stmt->error);
            $stmt->store_result();
            if($stmt->num_rows > 0) 
            {
            // Адрес почты зарегистрирован во временной таблице
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
        $this->mailStatus = $exist; // Запоминаем статус
        $this->mailChecked = true; // Адрес почты проверен
        
        return $exist;
    }
    
    /**
     * Проверка существования имени пользователя в таблицах пользователей и временной.
     *
     * @param string $name имя пользователя для проверки
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
     * Проверка строки на идентичность актуальному защитному коду.
     * Вызывается после вызова метода checkMail($mail)
     *
     * @param string $code секретный код
     * @return boolean
     */
    public function checkCode($code)
    {
        // Если проверен e-mail, адрес электронной почты сохранён, 
        if (($this->mailChecked) AND ($this->mailStatus) AND ($code == $this->userCode))
        {
            $this->codeChecked = true;
        }
        return $this->codeChecked;
    }

    /**
     * Проверка строки на идентичность актуальному защитному коду.
     * Вызывается после вызова метода checkMail($mail)
     *
     * @param string $code секретный код
     * @return boolean
     */
    public function checkCodePlus($code, $mode = 0)
    {
        // Если проверен e-mail, адрес электронной почты сохранён, 
        $code_origin = md5($this->userMail . $this->userCode);
        if (($this->mailChecked) AND ($this->mailStatus) AND ($code == $code_origin))
        {
            $this->codeChecked = true;
        }
        return $this->codeChecked;
    }
    
    
    /**
     * Сохранение данных пользователя во временную таблицу.
     * В ожидании подтверждения кода, посланного по почте.
     *
     * @param string $string сериализованны массив параметров. Необязателен.
     * @return boolean флаг успешного сохранения
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
                throw new Dune_Exception_Mysqli("Ошибка в отложенном запросе: ".$stmt->error);
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
     * Сохранение данных пользователя в главной таблице аутентификации.
     * Вызывается полсе методов: checkCode(), checkMail()
     * 
     * После приёма кода с почты.
     *
     * @param string $string сериализованны массив параметров. Необязателен.
     * @return boolean флаг успешного сохранения
     */
    public function save($string = '')
    {
        $bool = false;
        if (($this->mailChecked) AND ($this->mailStatus == 2) AND ($this->codeChecked))
        {
//  Регенерация защ. кода после подтверждения            
            $this->_generateCode();

            $this->codeAfterGeneration = true;
            $query = 'INSERT INTO ' . self::$authTableActive . '(`id`, `mail`, `name`, `code`, `time`, `password`,`array`)
                      VAlUES (null,?, ?, ?, NOW(), ?, ?)';
            $stmt = $this->_DB->prepare($query);
            $stmt->bind_param('sssss', $this->userMail, $this->userName, $this->userCode, $this->userCode, $string);
            $stmt->execute();
            if ($stmt->errno)
                throw new Dune_Exception_Mysqli("Ошибка в отложенном запросе: ".$stmt->error);
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
     * Сохранение данных пользователя после изменения.
     *
     * @return boolean флаг успешной операции
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
                throw new Dune_Exception_Mysqli("Ошибка в отложенном запросе: ".$stmt->error);
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
     * Сохранение масссива дополнительных данных пользоваиеля в базе.
     * Применяется после метода setArray()
     *
     * @return boolean флаг успешной операции
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
                throw new Dune_Exception_Mysqli("Ошибка в отложенном запросе: ".$stmt->error);
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
     * Сохранение нового пароля в базе.
     * применяется после метода setPassword()
     *
     * @return boolean флаг успешной операции
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
                throw new Dune_Exception_Mysqli("Ошибка в отложенном запросе: ".$stmt->error);
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
     * Регенерация кода безопасности
     * Вызывается полсе методов: checkCode(), checkMail()
     * 
     * После метода возможен вызов getCode()
     * 
     * !!!!! После этого метода необходимо послать письмо с новым кодом и закрыть сессию
     * 
     * @return boolean флаг успешного сохранения
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
                throw new Dune_Exception_Mysqli("Ошибка в отложенном запросе: ".$stmt->error);
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
     * Возврат секретного кода для отправки по почте.
     * Вызывается после методов: checkCode(), checkMail()
     * 
     * Вызывается не чаще колличества часов в переменной self::$authTim или сразу после метода regenerateCode()
     * 
     * 
     * @return string секреный код или пустая стока при прошествии малого времени после 
     */
    public function getCode()
    {
        if ($this->isGetUserCode)
        {
            return $this->userCode;
        }
        $code = '';
        // Если функция вызвана сразу после регенерации кода
        if ($this->codeAfterGeneration)
        {
            $this->isGetUserCode = true;
            return $this->userCode;
        }
//        if (($this->mailChecked) AND ($this->mailStatus == 1)) // счётчик срабатывал только для зарегистрированных
        if (($this->mailChecked) AND ($this->mailStatus)) // Счётчик срабатывает и для зарег. и для ждущих регистрации
        {
            $this->_DB->autocommit(FALSE);
            // Проверяем как давно был запрос на код аутентификации
            $query = 'SELECT UNIX_TIMESTAMP(`time`), `count`  FROM `' . self::$authTableGetCodeTime . '`
                      WHERE `id` = ?
                      LIMIT 1
                     ';
            $stmt = $this->_DB->prepare($query);
            $stmt->bind_param('d', $this->userId);
            $stmt->execute();
            if ($stmt->errno)
                throw new Dune_Exception_Mysqli("Ошибка в отложенном запросе: ".$stmt->error);
            $stmt->store_result();
            
            // Есть ли оезультат в выборке
            switch ($stmt->num_rows)
            {
                case 0:
                    // Ни разу не запрашивался код
                    $query = 'REPLACE INTO `' . self::$authTableGetCodeTime . '`
                              SET `id`   = ?,
                                  `time` = NOW()
                             ';
                    $stmt_2 = $this->_DB->prepare($query);
                    $stmt_2->bind_param('d', $this->userId);
                    $stmt_2->execute();
                    if ($stmt_2->errno)
                        throw new Dune_Exception_Mysqli("Ошибка в отложенном запросе: ".$stmt->error);
                    $stmt_2->close();
                    $code = $this->userCode;
                    $this->isGetUserCode = true;
                break;
                default:
                    // Повторный запрос
                    $stmt->bind_result($time, $count); 
                    $stmt->fetch();
                    if ($time < (time() - self::$getCodeTimeInteval))
                    {
                    // С момента последнего запроса прошло достаточно времени
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
                            throw new Dune_Exception_Mysqli("Ошибка в отложенном запросе: ".$stmt->error);
                        $stmt_2->close();
                        $code = $this->userCode;
                        $this->isGetUserCode = true;
                    }                    
                    else if ($count < 2)
                    {
                    // Счётчика запросов не достиг максимального значения
                        $query = 'UPDATE `' . self::$authTableGetCodeTime . '`
                                  SET `count` = `count` + 1
                                  WHERE `id`  = ? LIMIT 1
                                 ';
                        $stmt_2 = $this->_DB->prepare($query);
                        $stmt_2->bind_param('d', $this->userId);
                        $stmt_2->execute();
                        if ($stmt_2->errno)
                            throw new Dune_Exception_Mysqli("Ошибка в отложенном запросе: ".$stmt->error);
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
     * Возврат секретного кода для сравнения с введённым для проверки сцществования почты.
     * Вызывается после методов: checkCode(), checkMail()
     * 
     * Вызывается не чаще колличества часов в переменной self::$authTim или сразу после метода regenerateCode()
     * 
     * 
     * @return string секреный код или пустая стока при прошествии малого времени после 
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
     * Проверка строки на идентичность актуальному защитному коду.
     * Вызывается после вызова метода checkMail($mail)
     *
     * @param string $code секретный код
     * @return boolean
     */
    public function checkPassword($pass)
    {
        // Если проверен e-mail, адрес электронной почты сохранён, 
        if (($this->mailChecked) AND ($this->mailStatus) AND ($pass == $this->userPass))
        {
            $this->passChecked = true;
        }
        return $this->passChecked;
    }
    
    
    
    
     /**
     * Возврат пароля для сравнения с полученным при входе.
     * Вызывается после методов: checkCode(), checkMail()
     * 
     * Вызывается не чаще колличества часов в переменной self::$authTim или сразу после метода regenerateCode()
     * 
     * 
     * @return string секреный код или пустая стока при прошествии малого времени после 
     */
    public function getPassword()
    {
        if ($this->isGetUserPass)
        {
            return $this->userPass;
        }
        $pass = '';
//        if (($this->mailChecked) AND ($this->mailStatus == 1)) // счётчик срабатывал только для зарегистрированных
        if (($this->mailChecked) AND ($this->mailStatus)) // Счётчик срабатывает и для зарег. и для ждущих регистрации
        {
            $this->_DB->autocommit(FALSE);
            // Проверяем как давно был запрос на код аутентификации
            $query = 'SELECT UNIX_TIMESTAMP(`time`), `count`  FROM `' . self::$authTableGetPassTime . '`
                      WHERE `id` = ?
                      LIMIT 1
                     ';
            $stmt = $this->_DB->prepare($query);
            $stmt->bind_param('d', $this->userId);
            $stmt->execute();
            if ($stmt->errno)
                throw new Dune_Exception_Mysqli("Ошибка в отложенном запросе: ".$stmt->error);
            $stmt->store_result();
            
            // Есть ли оезультат в выборке
            switch ($stmt->num_rows)
            {
                case 0:
                    // Ни разу не запрашивался код
                    $query = 'REPLACE INTO `' . self::$authTableGetPassTime . '`
                              SET `id`   = ?,
                                  `time` = NOW()
                             ';
                    $stmt_2 = $this->_DB->prepare($query);
                    $stmt_2->bind_param('d', $this->userId);
                    $stmt_2->execute();
                    if ($stmt_2->errno)
                        throw new Dune_Exception_Mysqli("Ошибка в отложенном запросе: ".$stmt->error);
                    $stmt_2->close();
                    $pass = $this->userPass;
                    $this->isGetUserPass = true;
                break;
                default:
                    // Повторный запрос
                    $stmt->bind_result($time, $count); 
                    $stmt->fetch();
                    if ($time < (time() - self::$getCodeTimeInteval))
                    {
                    // С момента последнего запроса прошло достаточно времени
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
                            throw new Dune_Exception_Mysqli("Ошибка в отложенном запросе: ".$stmt->error);
                        $stmt_2->close();
                        $pass = $this->userPass;
                        $this->isGetUserPass = true;
                    }                    
                    else if ($count < 2)
                    {
                    // Счётчика запросов не достиг максимального значения
                        $query = 'UPDATE `' . self::$authTableGetPassTime . '`
                                  SET `count` = `count` + 1
                                  WHERE `id`  = ? LIMIT 1
                                 ';
                        $stmt_2 = $this->_DB->prepare($query);
                        $stmt_2->bind_param('d', $this->userId);
                        $stmt_2->execute();
                        if ($stmt_2->errno)
                            throw new Dune_Exception_Mysqli("Ошибка в отложенном запросе: ".$stmt->error);
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
     * Возврат пароля для сравнения с полученным при входе.
     * Вызывается после методов: checkCode(), checkMail()
     * 
     * Вызывается не чаще колличества часов в переменной self::$authTim или сразу после метода regenerateCode()
     * 
     * 
     * @return string секреный код или пустая стока при прошествии малого времени после 
     */
    public function askPassword()
    {
        $pass = '';
        if ($this->isAskUserPass)
        {
            $pass = $this->userPass;
        }
//        if (($this->mailChecked) AND ($this->mailStatus == 1)) // счётчик срабатывал только для зарегистрированных
        else if (($this->mailChecked) AND ($this->mailStatus)) // Счётчик срабатывает и для зарег. и для ждущих регистрации
        {
            $this->_DB->autocommit(FALSE);
            // Проверяем как давно был запрос на код аутентификации
            $query = 'SELECT UNIX_TIMESTAMP(`ask_password`)  FROM `' . self::$authTableEventsTime . '`
                      WHERE `id` = ?
                      LIMIT 1
                     ';
            $stmt = $this->_DB->prepare($query);
            $stmt->bind_param('d', $this->userId);
            $stmt->execute();
            if ($stmt->errno)
                throw new Dune_Exception_Mysqli("Ошибка в отложенном запросе: ".$stmt->error);
            $stmt->store_result();
            
            // Есть ли оезультат в выборке
            switch ($stmt->num_rows)
            {
                case 0:
                    // Ни разу не запрашивался код
                    $query = 'REPLACE INTO `' . self::$authTableEventsTime . '`
                              SET `id`   = ?,
                                  `ask_password` = NOW()
                             ';
                    $stmt_2 = $this->_DB->prepare($query);
                    $stmt_2->bind_param('d', $this->userId);
                    $stmt_2->execute();
                    if ($stmt_2->errno)
                        throw new Dune_Exception_Mysqli("Ошибка в отложенном запросе: ".$stmt->error);
                    $stmt_2->close();
                    $pass = $this->userPass;
                    $this->isAskUserPass = true;
                break;
                case 1:
                    // Повторный запрос
                    $stmt->bind_result($time); 
                    $stmt->fetch();
                    if ($time < (time() - self::$askPassTimeInteval))
                    {
                    // С момента последнего запроса прошло достаточно времени
                        $query = 'UPDATE `' . self::$authTableEventsTime . '`
                                  SET `ask_password` = NOW()
                                  WHERE `id` = ?
                                  LIMIT 1
                                 ';
                        $stmt_2 = $this->_DB->prepare($query);
                        $stmt_2->bind_param('d', $this->userId);
                        $stmt_2->execute();
                        if ($stmt_2->errno)
                            throw new Dune_Exception_Mysqli("Ошибка в отложенном запросе: ".$stmt->error);
                        $stmt_2->close();
                        $pass = $this->userPass;
                        $this->isAskUserPass = true;
                    }
            }
            $stmt->close();      
            
                $this->_DB->commit();
                $this->_DB->autocommit(true);
            
        }
        // Для проверок
        //$pass = $this->userPass;
        return $pass;
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
     * Возвращает ящие пользователя
     *
     * @return string
     */
    public function getMail()
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
     * Возвращает массив настроек пользователя
     *
     * @return array
     */
    public function getUserArray()
    {
        return $this->userArray;
    }

    /**
     * Устанавливает массив настроек пользователя для дальнейшего сохранения
     *
     *  @param array $array массив данных пользователя
     */
    public function setUserArray($array)
    {
        if (!is_array($array))
            throw new Dune_Exception_Base('Параметр функции должен быть массивом');
        $this->userArray = serialize($array);
    }

    
    /**
     * Возвращает код статуса адреса электронной почты
     * 0 - неизвестен
     * 1 - зарегистрирован
     * 2 - находится на проверке
     *
     * @return integer
     */
    public function getMailStatus()
    {
        return $this->mailStatus;
    }
    
    /**
     * Проверка вхождения домена в список дозволенных
     * true - входит в дозволенный список
     * 
     * @param string $domain домен почты вида: mail.ru
     * @return boolean 
     */
    public function checkDomain($domain)
    {
        $bool = false;
        // Проверяем есть ли e-mail во временной таблице
        $query = 'SELECT `id` FROM `' . self::$authTableAlloyDomain . '`
                  WHERE `domain` LIKE ? LIMIT 1
                  ';
        $stmt = $this->_DB->prepare($query);
        $stmt->bind_param('s', $domain);
        $stmt->execute();
        if ($stmt->errno)
            throw new Dune_Exception_Mysqli("Ошибка в отложенном запросе: ".$stmt->error);
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
     * Проверка на вхождение адреса элю почты в чёрный список
     * true - не входит
     * 
     * @param string $mail
     * @return boolean флаг вхождения в список
     */
    public function checkMailBlackList($mail)
    {
        $bool = true;
        // Проверяем есть ли e-mail во временной таблице
        $query = 'SELECT `id` FROM `' . self::$authTableMailBlackList . '`
                  WHERE `mail` LIKE ? LIMIT 1
                  ';
        $stmt = $this->_DB->prepare($query);
        $stmt->bind_param('s', $mail);
        $stmt->execute();
        if ($stmt->errno)
            throw new Dune_Exception_Mysqli("Ошибка в отложенном запросе: ".$stmt->error);
        $stmt->store_result();
        if($stmt->num_rows > 0) 
        {
            $bool = false;
        }
        $stmt->close();
        return $bool;
    }
    
//////////////////////////////////////////////////////////////////////////////////    
//            Приватные методы
//////////////////////////////////////////////////////////////////////////////////    
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