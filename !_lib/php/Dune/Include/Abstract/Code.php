<?php
 /**
 * Абстрактный класс. Системные методы и переменные для осблуживания основного кода, определяемого в дочернем классе.
 * В дочернем классе определяется только рабочий код в методе code().
 *
 * 
 * ----------------------------------------------------
 * | Библиотека: Dune                                  |
 * | Файл: Class.php                                   |
 * | В библиотеке: Dune/Include/Abstract/Code.php      |
 * | Автор: Андрей Рыжов (Dune) <dune@rznw.ru>         |
 * | Версия: 1.03                                      |
 * | Сайт: www.rznw.ru                                 |
 * ----------------------------------------------------
 * 
 * История версий:
 * -----------------
 * 
 * 1.03 (2009 март 19)
 *  Возврат значения при осуьствии - null всесто false
 * 
 * 1.02 (2009 январь 30)
 *  Цепочка вызова set-метода.
 * 
 * 1.01 (2008 декабрь 05)
 * !!! Установка результатов через метод.
 * Установку через переменную тоже работвет, но приоритет за новым методом.
 * 
 */

abstract class Dune_Include_Abstract_Code
{
    /**
     * Гененерировать ли исключение при отсутствии указанного можудя
     * True - генерить (по умолчанию)
     *
     * @var boolean
     */
    public static $isExeption = true;
    
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
    protected $___text121121278273= array();
    
    /**
     * Массив результатов работы модуля
     *
     * @var array
     * @access private
     */
    protected $results = array();

    /**
     * Массив результатов работы модуля новый
     *
     * @var array
     * @access private
     */
    protected $____results = array();
    
    
    /**
     * Текст буфера вывода информации из команды
     *
     * @var string
     * @access private
     */
    protected $____buffer = '';
    
    
    /**
     * Массив вхлдных параметрогв модуля.
     *
     * @var array
     * @access private
     */
    protected $____parameters = array();
    
    
    public function __construct($parameters = array())
    {
    	$this->____parameters = $parameters;
    }
    
    
    public function make()
    {
      // Коды сообщений, возвращаемых из модуля
      $message_code = array();
      // Тексты сообщений возвращаемых из модуля
      $message_text = array();
      // Тексты, возвращаемые из модуля
      $text = array();
      ob_start();
      $this->code();

      $this->____buffer = ob_get_clean();
      return true;
    }
    
    
    protected function code()
    {
        // Основной рабочий код класса. Определяется в дочернем.
        
        
    }
    
    /**
     * Функция для установки результатов работы модуля.
     * !!! Очень желательно применять этот метод.
     * Старый подвержен ошибкам.
     *
     * @param unknown_type $name
     * @param unknown_type $value
     */
    protected function setResult($name, $value)
    {
        $this->____results[$name] = $value;
        return $this;
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
    {
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
        return $this->____buffer;
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
        if (key_exists($key, $this->____results))
            return $this->____results[$key];
        else if (!key_exists($key, $this->results))
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
        return $this->____results;
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
         return true;
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
    		return null;
    }
    
    public function __toString()
    {
        return $this->____buffer;
    }
    
    
/////////////////////////////
////////////////////////////////////////////////////////////////
    
    
}