<?php
 /**
  *  Dune Framework
  * 
 *  Астрактный базовый класс для наследования классами подключения цепочек команд
 *
 * 
 * Модуль должен использовать следующие массивы для генерации выходных данных
 *    $massage_code = array() - коды сообщений
 *    $massage_text = array() - тексты кодов сообщений
 *    $text = array() - информация
 * 
 * 
 * ----------------------------------------------------
 * | Библиотека: Dune                                  |
 * | Файл: Command.php                                 |
 * | В библиотеке: Dune/Include/Parent/Command.php     |
 * | Автор: Андрей Рыжов (Dune) <dune@rznw.ru>         |
 * | Версия: 1.11                                      |
 * | Сайт: www.rznw.ru                                 |
 * ----------------------------------------------------
 * 
 * История версий:
 * -----------------
 * 
 * 1.11 (2009 июль 08)
 * В методе setResult при передаче массива присходит слияние с существующим. Не замена, как раньше.
 * 
 * 1.10 (2009 май 13)
 * Проверка статуса сравненем с предлвгаемым через функцию strcmp()
 * 
 * 1.09 (2009 январь 23)
 * Для set-методов реализована возможность построения "цепочек";
 * 
 * 
 * 1.08 (2008 декабрь 18)
 * Исправлена ошибка. Странно что раньше работало.
 * 
 * 1.07 (2008 декабрь 05)
 * !!!!!!!!  Доступ к массиву результатов и переменной статуса через методы.
 * 
 * 
 * 1.06 (2008 октябрь 24)
 * Для пущей стабильности изменено имя массива - хранителя параметров.
 *
 * 1.04 -> 1.05
 * Добавлен магический метод __tostring() вывод на печать результата.
 * 
 * 1.03 -> 1.04 (2008 октябрь 04)
 * В методе make() - сохранение всего вывода из подключаемого кода.
 * 
 * 1.02 -> 1.03 (2008 октябрь 02)
 * Статус выполнение команды по умолчанию - STATUS_PAGE
 * Если файл отсутствует - STATUS_NO
 * 
 * 1.00 -> 1.02
 * Из метода make() изъята инициилизация переменной $_folder
 * 
 * 1.00 -> 1.01
 * Добавлен метода выполнения команды make().
 * Добавлены магические методы для доступа к параметрам объекта.
 * 
 */

abstract class Dune_Include_Parent_Command
{
    /**
     * Гененерировать ли исключение при отсутствии указанного модудя
     * True - генерить (по умолчанию)
     *
     * @var boolean
     */
    public static $isExeption = false;

    /**
     * Полный путь к выполняемому файлу
     *
     * @var string
     * @access private
     */
    protected $fullPath = '';
    
    
    /**
     * Флаг существования файла клманд
     *
     * @var boolean
     * @access private
     */
    protected $existence = false;
    
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
    protected $results = array();


    /**
     * Массив сгенерированных текстов. Новый.
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
    protected $buffer = '';
    
    /**
     * Статус команды после выполнения
     *
     * @var string
     * @access private
     */
//    protected $status = '_page';

    /**
     * Статус команды после выполнения. Новый.
     *
     * @var string
     * @access private
     */
    protected $____status = '_page';
    
    
    protected $____parameters = array();    
    
//////////////////////////////////////////////////////////////////////////
///////////         Описание констант
    const STATUS_EXIT = '_exit'; // Прекращение выполнение скрипта с переходом на реферала
    const STATUS_GOTO = '_goto'; // Директива перенаправить в указанное в выходных данных направление
    const STATUS_PAGE = '_page'; // В результате данные для вывода страницы
    const STATUS_ARRAY = '_array'; // В результате данные массив
    const STATUS_TEXT = '_text'; // В результате данные строка
    const STATUS_NOACCESS = '_noaccess'; // В доступе отказано
    const STATUS_AJAX = '_ajax'; // В результате данные любые
    
    /**
     * Команда не выполнялась
     * 
     * В штатном режиме из-за отсутствия файла команды
     *
     */
    const STATUS_NO = '_no';

/////////////////////////////////////////////////////////////////////////
    

    /**
     * Функция для установки результатов работы модуля.
     * !!! Очень желательно применять этот метод.
     * Старый подвержен ошибкам.
     *
     * @param mixed $name_or_array
     * @param mixed $value
     */
    protected function setResult($name_or_array, $value = null)
    {
        if (is_array($name_or_array))
        {
            $this->____results += $name_or_array;
        }
        else 
            $this->____results[$name_or_array] = $value;
        return $this;
    }



	/**
	 * Включение файла для выполнения, если он существует.
	 *
	 * @return boolean true - если файл существует, false - иначе
	 */
    public function make()
    {
    	if ($this->existence = true)
    	{
    	    ob_start();
            include($this->fullPath);
            $this->buffer = ob_get_clean();     
			return true;    		
    	}
    	else 
    		return false;
    }


    /**
     * Возвращает флаг существования файла команд.
     *
     * @return boolean
     */
    public function isExist()
    {
        return $this->existence;
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
     * Возвращает колличество сообщений выполнения команды
     *
     * @return integer
     */
    public function countMessage()
    {
        return count($this->messageCode);
    }
    
    /**
     * Возвращает код сообщения с указанныи номером.
     * Генерит исключение при отсутствии ключа.
     *
     * @return integer
     */
    public function getMessageCode($num = 0)
    {
        if (!key_exists($num, $this->messageCode))
            throw new Dune_Exception_Base('Нет сообщения с таким кодом.');
        return $this->messageCode[$num];
    }

     /**
     * Возвращает текст сообщения с указанныи номером.
     * Генерит исключение при отсутствии ключа.
     *
     * @return string
     */
    public function getMassageText($num = 0)
    {
        if (!key_exists($num, $this->messageText))
            throw new Dune_Exception_Base('Нет сообщения с таким кодом.');
        return $this->messageText[$num];
    }
    
    /**
     * Возвращает колличество текстовых блоков, сгенерированных командой
     *
     * @return integer
     */
    public function countResults()
    {
        return count($this->____results);
    }
    
     /**
     * Возвращает текстовый блок с указанныи номером.
     * Генерит исключение при отсутствии ключа. Если установлен флаг.
     * Иначе возвращает false
     *
     * @param mixed $num ключ для возврата, устанавливается в подкомманде.
     * @return string
     */
    public function getResult($key = 0)
    {
        if (key_exists($key, $this->____results))
            return $this->____results[$key];
        else if (!key_exists($key, $this->results))
        {
            if ($this->isExeption)
                throw new Dune_Exception_Base('Нет результата с таким кодом.');
            else 
                return false;
        }
        return $this->results[$key];
    }

     /**
     * Возвращает весь результирующий массив.
     *
     * @return string
     */
    public function getResults()
    {
        if (count($this->____results))
            return $this->____results;
        return $this->results;
    }
    
     /**
     * Возвращает статус.
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->____status;
    }
     /**
     * Устанавливает статус.
     *
     * @return string
     */
    public function setStatus($value)
    {
        $this->____status = $value;
        return $this;
    }
    
    
    /**
     * Проверяет статус выполнения команды с передаваемой строкой для метода.
     * Если совпадает - возвращает true. Иначе false.
     * 
     * Возможные статусы описывают константы класса.
     *
     * @param string $status
     * @return boolean
     */
    public function checkStatus($status)
    {
        $bool = false;
        if (!strcmp($status, $this->____status))
        {
            $bool = true;
        }
        return $bool;
      }
      
      
    ////////////////////////////////////////////////////////////////
///////////////////////////////     Магические методы
    public function __set($name, $value)
    {
        if ($name == 'status')     //     !!!!!!!!!!!!!!!       Временная заглушка.
            $this->____status = $value;
        else 
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