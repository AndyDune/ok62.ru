<?php
 /**
 *  Класс для подключения модулей
 * 
 *  !!!!!!!!!!!  Устаревший, к использованию не рекомендуется   !!!!!!!!!!!!!
 *
 * Модуль должен использовать следующие массивы для генерации выходных данных
 *    $massage_code = array() - коды сообщений
 *    $massage_text = array() - тексты кодов сообщений
 *    $text = array() - информация
 * 
 * 
 * ----------------------------------------------------
 * | Библиотека: Dune                                  |
 * | Файл: Module.php                                  |
 * | В библиотеке: Dune/Include/Module.php             |
 * | Автор: Андрей Рыжов (Dune) <dune@rznw.ru>         |
 * | Версия: 1.13                                      |
 * | Сайт: www.rznw.ru                                 |
 * ----------------------------------------------------
 * 
 * История версий:
 * -----------------
 * 
 * 1.13 (2008 октябрь 24)
 * Для пущей стабильности изменено имя массива - хранителя параметров.
 * 
 * 1.11 -> 1.12
 * Добавлен магический метод __tostring() вывод на печать результата.
 * 
 * 
 * 1.10 -> 1.11
 * Вывод подключаемого модуля сохраняется и доступен методом getOutput и getResult при отсутствии передаваемого параметра.
 * 
 * 1.00 -> 1.10
 * Для соствления пути к модуля используются собственные статические переменные.
 * Модуль не выполняе тся при вызове конструктора - используется метод make.
 * Текст модуля включается в текст метода make и использует переменные класса $this-><что-то>
 * Результаты в масиве $this->results
 * 
 * 0.99 -> 1.00
 * Добавлено подключение блока кода контроля входных параметров
 * 
 */

class Dune_Include_Module
{
    /**
     * Гененерировать ли исключение при отсутствии указанного можудя
     * True - генерить (по умолчанию)
     *
     * @var boolean
     */
    public static $isExeption = true;
    
    /**
     * Имя главного файла модуля с расширением
     * По умолчанию main.php
     * 
     * @var string
     */
    public static $modulFileName = 'index.php';

    /**
     * Имя файла помощи при подключении модуля
     * По умолчанию .help.php
     * 
     * @var string
     */
    public static $modulHelpFileName = '.help.php';

    /**
     * Имя файла контроля входных данных для модуля
     * 
     * @var string
     */
    public static $modulControlFileName = '.control.php';
    
    public static $modulsPath = '';
    public static $modulsSpace = 'default';
    
    
    /**
     * Флаг существования модуля
     *
     * @var boolean
     * @access private
     */
    protected $moduleExistence = false;
    
    /**
     * Путь к модулю в пределах папки модулей
     *
     * @var string
     * @access private
     */
    protected $moduleLocalPath = '';
    
    /**
     * Полный путь к модулю
     *
     * @var string
     * @access private
     */
    protected $moduleFullPath = '';
    
    /**
     * Полный путь к файлу помощи
     *
     * @var string
     * @access private
     */
    protected $moduleHelpFullPath = '';

    
    /**
     * Полный путь к файлу контроля входных данных
     *
     * @var string
     * @access private
     */
    protected $moduleControlFullPath = '';
    /**
     * Массив кодов сообщений
     *
     * @var array
     * @access private
     */
    protected $messageCode = array();
    
    /**
     * Массив расшифровок кодов сообщений
     *
     * @var array
     * @access private
     */
    protected $messageText = array();
    
    /**
     * Массив сгенерированных текстов
     *
     * @var array
     * @access private
     */
    protected $text = array();
    
    /**
     * Массив результатов работы модуля
     *
     * @var array
     * @access private
     */
    protected $results = array();

    /**
     * Текст буфера вывода информации из команды
     *
     * @var string
     * @access private
     */
    protected $buffer = '';
    
    
    /**
     * Массив вхлдных параметрогв модуля.
     *
     * @var array
     * @access private
     */
    protected $____parameters = array();
    
    
    public function __construct($module, $parameters = array())
    {
        $this->moduleLocalPath = str_replace(array(':', '/', '\\'), DIRECTORY_SEPARATOR, $module);
        $this->moduleFullPath = self::$modulsPath
        					  . DIRECTORY_SEPARATOR 
        					  . self::$modulsSpace 
        					  . DIRECTORY_SEPARATOR
        					  . $this->moduleLocalPath
        					  . DIRECTORY_SEPARATOR 
        					  . self::$modulFileName;
                                
        $this->moduleHelpFullPath = self::$modulsPath
        						  . DIRECTORY_SEPARATOR
        						  . self::$modulsSpace 
        						  . DIRECTORY_SEPARATOR
        						  .	$this->moduleLocalPath
        						  . DIRECTORY_SEPARATOR
        						  . self::$modulHelpFileName;

        $this->moduleControlFullPath = self::$modulsPath
        							 . DIRECTORY_SEPARATOR
        							 . self::$modulsSpace
        							 . DIRECTORY_SEPARATOR
        							 . $this->moduleLocalPath
        							 . DIRECTORY_SEPARATOR
        							 . self::$modulControlFileName;
                  
         if (!file_exists($this->moduleFullPath))
         { 
         	
             if (self::$isExeption)
                throw new Dune_Exception_Base('Нет указанного модуля: ' . $this->moduleFullPath);
         }
         else 
         {
            $this->moduleExistence = true;
         }  
        
    	$this->____parameters = $parameters;
    }
    
    
    public function make()
    {
    	if ($this->moduleExistence)
    	{
	         // Коды сообщений, возвращаемых из модуля
	         $message_code = array();
	         // Тексты сообщений возвращаемых из модуля
	         $message_text = array();
	         // Тексты, возвращаемые из модуля
	         $text = array();
	         ob_start();
	         include($this->moduleFullPath);

//	         if (isset($DF_RESULTS)) // В модулях используется для передачи результатов специальная переменная вместо члена класса.
//	           $this->results = $DF_RESULTS;
	         
	         $this->buffer = ob_get_clean();
	         return true;
    	}
    	else 
    		return false;
    }
    
    /**
     * Возвращает флаг существлвания модуля.
     *
     * @return boolean
     */
    public function isModuleExist()
    {
        return $this->moduleExistence;
    }
    
    /**
     * Возвращает колличество сообщений модуля
     *
     * @return integer
     */
    public function countMessage()
    {
        return count($this->messageCode);
    }
    
    /**
     * Возвращает код сообщения с указанныи номером.
     * Генерит исключение при отсутствии кключа.
     *
     * @return integer
     */
    public function getMessageCode($num = 0)
    {         print_r($this->messageCode);
//        if (!key_exists($num, $this->messageCode))
//            throw new Dune_Exception_Base('Нет сообщения с таким кодом.');
        return $this->messageCode[$num];
        
    }

     /**
     * Возвращает текст сообщения с указанныи номером.
     * Генерит исключение при отсутствии кключа.
     *
     * @return string
     */
    public function getMassageText($num = 0)
    {
        if (!key_exists($num, $this->messageText))
            throw new Dune_Exception_Base('Нет текстовой информации с таким кодом.');
        return $this->messageText[$num];
    }

    /**
     * Выбрать содержимое буфера результатов вывода команды
     *
     * @return string
     */
    public function getOutput()
    {
        return $this->buffer;
    }
   
     /**
     * Возвращает результат с указанныи номером.
     * Генерит исключение при отсутствии ключа.
     *
     * @param mixed $key ключ для возврата, устанавливается в подкомманде. Если не указан - возврат вывода команды.
     * @return string
     */
    public function getResult($key = 0)
    {
        
        if (!key_exists($key, $this->results))
            throw new Dune_Exception_Base('Нет результата с таким кодом.');
        return $this->results[$key];
    }

     /**
     * Возвращает весть массив результатов.
     *
     * @return string
     */
    public function getResults()
    {
        return $this->results;
    }
    
    
    /**
     * Возвращает колличество текстовых блоков, сгенерированных модулем
     *
     * @return integer
     */
    public function countText()
    {
        return count($this->results);
    }
    
     /**
     * Возвращает текстовый блок с указанныи номером.
     * Генерит исключение при отсутствии кключа.
     *
     * @return string
     */
    public function getText($key = 'text')
    {
        if (!key_exists($key, $this->results))
        	return false;
            //throw new Dune_Exception_Base('Нет сообщения с таким кодом.');
        return $this->results[$key];
    }

     /**
     * Возвращает текстовый блок помощи.
     * или false если блока помощи нет.
     *
     * @return string
     */
    public function help()
    {
         if (!file_exists($this->moduleHelpFullPath))
         {
            ob_start();
            include($this->moduleHelpFullPath);
            $result = ob_get_clean();
         }
         else 
            $result = false;
         return $result;
    }
    
////////////////////////////////////////////////////////////////
///////////////////////////////     Магические методы
    public function __set($name, $value)
    {
    	$this->____parameters[$name] = $value;
    }
    public function __get($name)
    {
    	if (isset($this->____parameters[$name]))
    		return $this->____parameters[$name];
    	else 
    		return false;
    }
    
    public function __toString()
    {
        return $this->buffer;
    }
    
    
/////////////////////////////
////////////////////////////////////////////////////////////////
    
    
}