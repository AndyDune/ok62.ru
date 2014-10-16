<?php
/**
*   Работа с массивом $_POST.
* 
* 
* Использует класы:
*   Dune_String_Functions
* 
* ----------------------------------------------------------
* | Библиотека: Dune                                        |
* | Файл: Total.php                                         |
* | В библиотеке: Dune/Filter/Post/Total.php                |
* | Автор: Андрей Рыжов (Dune) <dune@rznw.ru>               |
* | Версия: 1.14                                            |
* | Сайт: www.rznw.ru                                       |
* ----------------------------------------------------------
* 
* Версии 
* --------------------------------------
* 
* 1.14 (2009 апрель 13)
* Введено использование функций со токами из класса Dune_String_Functions.
* 
* 1.13 (2009 январь 23)
* Для set-методов реализована возможность построения "цепочек";
* 
* 1.12 (2009 январь 16)
* Добавлена возможность обработки многомерного массива $_POST
* 
* 1.11 (2008 декабрь 26)
* Ноый метод setResultCharset($charset) включает перекодровку при доступе данных в масиве $_POST. Любую кодировку в win-1251.
* 
* 1.10 (2008 декабрь 25)
* Ноый метод setIconv($in_charset, $out_charset) включает перекодровку при доступе данных в масиве $_POST.
* Добавлены конcтанты с распространенными кодировками
* 
* 1.09 (2008 декабрь 02)
* Специальная обработка значений элементоа массива $_POST при доступах ArrayAccess,Iterator
* Реализация интерфейса Countable.
* 
* 1.08 (2008 ноябрь 07)
* Добавлена пакетная обработка параметров из массива функцией htmlspecialchars()
* 
* 1.07 (2008 октябрь 24)
* Добавлен метод __toString. Тестовая печать массива $_POST
* 
* 1.06 (2008 октябрь 21)
* Изменен метод getDigit() - удаляет пробелы, запятые и точки.
* 
* 1.05 (2008 октябрь 16)
* Добавлен метод trim - применение функции trim ко всем элементам массива.
* При вызове методов-фильтров trim не применяется (Используется trim для всего массива).
* Новый метод getNoSpaces()
* Изменен метод getFloat() - удаляет пробелы.
* 
* Версия 1.03 -> 1.04 (2008 сентябрь 25)
* -------------------------------------
* Возможно ограничивать по длинне значения в массиве.
* Исп. метод setLength()
* 
* Версия 1.02 -> 1.03 (2008 август 30)
* ----------------------
* Новый метод getFloat()
* 
* Версия 1.01 -> 1.02 (2008 август 29)
* ----------------------
* Устранена ошибка в getHtmlSpecialChars
* 
* Версия 1.00 -> 1.01
* ----------------------
* Добавлены реализции интрефейсов ArrayAccess и Iterator
* 
*/

class Dune_Filter_Post_Total implements ArrayAccess,Iterator, Countable
{

	protected $_default = '';
	protected $_noTrimmed = true;
	
    static private $instance = null;
    
  	protected $_lendth = 0; // Ноль - длина данных не контроллируется

  	protected $_htmlSpecialChars = false;

  	
    /**
     * Кодировка текста - источника
     *
     * @var string
     * @access private
     */
    protected $_encodingSourse = 'windows-1251';
    
    /**
     * Кодировка текста - результата
     *
     * @var string
     * @access private
     */
    protected $_encoding = 'windows-1251';
    
    protected $_charset = false;
  	
  	
    const ENC_WINDOWS1251 = 'windows-1251';
    const ENC_UTF8 = 'UTF-8';
  	
  	
    /**
    * Возвращает ссылку на объект
    *
    * @param mixed $def значение по умолчанию
    * @return Dune_Filter_Post_Total
    */
    static function getInstance($def = '')
    {
        if (is_null(self::$instance))
        {
            self::$instance = new Dune_Filter_Post_Total($def);
        }
        return self::$instance;
    }
    
    protected function __construct($def)
    {
    	$this->_default = $def;
    }
    
    public function setIconv($in_charset, $out_charset)
    {
        $this->_encodingSourse = $in_charset;
        $this->_encoding = $out_charset;
        return $this;
    }

    /**
     * Установка кодировки к которой будет преобразована строка из лобой из кодировок: windows-1251, koi-8r, utf-8
     *
     * @param string $charset
     */
    public function setResultCharset($charset = 'windows-1251')
    {
        $this->_charset = $charset;
        return $this;
    }
    
    /**
     * Применить функцию trim к всем элементам-строкам массива $_POST.
     *
     */
    public function trim()
    {
        if ($this->_noTrimmed)
        {
            foreach ($_POST as $key => $value)
            {
                $_POST[$key] = $this->_trim($value);
            }
            $this->_noTrimmed = false;
        }
        return $this;
    }
    
    protected function _trim($value)
    {
    	if (is_array($value))
    	{
    	    foreach ($value as $key => $value_run)
    	    {
    		    $value[$key] =  $this->_trim($value_run);
    	    }
    	}
    	else if (is_string($value))
    	{
    		$value =  trim($value);
    	}
    	return $value;
    }
    
    
    /**
     * Установка новог значение по умолчанию
     *
     * @param mixed $value
     */
    public function setDefault($value)
    {
    	$this->_default = $value;
    	return $this;
    }
    
    
    public function get($is_container = false)
    {
        if ($is_container)
            return new Dune_Array_Container($_POST);
        else 
            return $_POST;
    }
    
    /**
     * Фильтрует значение в массиве $_POST и возвращат его.
     * Фильтр - целое число.
     * При отсутствии ключа в массиве - значение по умолчанию $default
     *
     * @param string $name
     * @param integer $default
     * @return integer
     */
    public function getDigit($name, $default = 0, $maxLength = 10)
    {
    	if (isset($_POST[$name]))
    	{
//    		$value = substr($_POST[$name], 0, $maxLength);
    		return $this->_getDigit($_POST[$name], $default, $maxLength);
    	}
    	else 
    		return $default;
    }

    protected function _getDigit($value, $default, $maxLength)
    {
    	if (is_array($value))
    	{
    	    foreach ($value as $key => $value_run)
    	    {
    		    $value[$key] =  $this->_getDigit($value_run, $default, $maxLength);
    	    }
    	}
    	else 
    	{
    		$value =  Dune_String_Functions::sub($value, 0, $maxLength);
    		$value = (int)str_replace(array('.', ',', ' '), '', $value);
    	}
    	return $value;
    }
    
    
    /**
     * Фильтрует значение в массиве $_POST и возвращат его.
     * Фильтр - дробное число. ! Запятая конвертируется в точку.
     * При отсутствии ключа в массиве - значение по умолчанию $default
     *
     * @param string $name
     * @param integer $default
     * @return integer
     */
    public function getFloat($name, $default = 0, $maxLength = 10)
    {
    	if (isset($_POST[$name]))
    	{
//    		$value = substr($_POST[$name], 0, $maxLength);
//    		return (float)str_replace(array(',', ' '), array('.', ''), $value);
    		return $this->_getFloat($_POST[$name], $default, $maxLength);
    	}
    	else 
    		return $default;
    }
    
    protected function _getFloat($value, $default, $maxLength)
    {
    	if (is_array($value))
    	{
    	    foreach ($value as $key => $value_run)
    	    {
    		    $value[$key] =  $this->_getFloat($value_run, $default, $maxLength);
    	    }
    	}
    	else 
    	{
    		$str = Dune_String_Factory::getStringContainer($value);
    		$value = $str->substr(0, $maxLength);
    		$value = (float)str_replace(array(',', ' '), array('.', ''), $value);
    	}
    	return $value;
    }
    

    /**
     * Фильтрует значение в массиве $_POST и возвращат его.
     * Удаляет все пробелыю. Имеет смысл при сохранениие многоразрядных чисел.
     * При отсутствии ключа в массиве - значение по умолчанию $default
     *
     * @param string $name
     * @param integer $default
     * @return integer
     */
    public function getNoSpaces($name, $default = '', $maxLength = 10)
    {
    	if (isset($_POST[$name]))
    	{
    		$value = Dune_String_Functions::sub($_POST[$name], 0, $maxLength);
    		return str_replace(' ', '', $value);
    	}
    	else 
    		return $default;
    }
    
    
    
    /**
     * Фильтрует значение в массиве $_POST и возвращат его.
     * Фильтр - функция htmlspecialchars().
     * При отсутствии ключа в массиве - значение по умолчанию $default
     *
     * @param string $name
     * @param string $default
     * @return string
     */
    public function getHtmlSpecialChars($name, $default = '', $maxLength = 10000)
    {
    	if (isset($_POST[$name]))
    		return $this->_getHtmlSpecialChars($_POST[$name], $default, $maxLength);
    	else 
    		return $default;
    }
    
    
    protected function _getHtmlSpecialChars($value, $default, $maxLength)
    {
    	if (is_array($value))
    	{
    	    foreach ($value as $key => $value_run)
    	    {
    		    $value[$key] =  $this->_getHtmlSpecialChars($value_run, $default, $maxLength);
    	    }
    	}
    	else 
    	{
    		$value =  htmlspecialchars(substr($value, 0, $maxLength));;
    	}
    	return $value;
    }
    
    
    
    /**
     * Проверка существования ключа
     *
     * @param string $name
     * @return boolean
     */
    public function have($name)
    {
    	return isset($_POST[$name]);
    }
    
    /**
     * Проверка существования ключа
     *
     * @param string $name
     * @return boolean
     */
    public function check($name)
    {
    	return isset($_POST[$name]) and ((string)$_POST[$name] != '');
    }
    
    
    /**
     * Установка значения допустимой длинны входных данных.
     * Используется м магическом методе __get()
     *
     * @param integer $value макс. длина данных. 0 - есди не контрроллировать.
     */
    public function setLength($value = 0)
    {
        $this->_lendth = $value;
        return $this;
    }
    
    public function htmlSpecialChars($value = true)
    {
        $this->_htmlSpecialChars = $value;
        return $this;
    }
    
    
////////////////////////////////////////////////////////////////
///////////////////////////////     Магические методы
    public function __set($name, $value)
    {
        $_POST[$name] = $value;
    }
    public function __get($name)
    {
        if (isset($_POST[$name]))
        {
            $str = $this->_filter($_POST[$name]);
        }
        else 
           $str = $this->_default;
        return $str;
    }    
    
    public function __toString()
    {
    	$string = '<pre>';
    	ob_start();
    	print_r($_POST);
    	$string .= ob_get_clean();
    	return  $string . '</pre>';
    }
    
    
////////////////////////////////////////////////////////////////
///////////////////////////////     Метод интерфейса Countable
    public function count()
    {
        return count($_POST);
    }
    
    
////////////////////////////////////////////////////////////////
///////////////////////////////     Методы интерфейса Iterator
  // устанавливает итеретор на первый элемент
  public function rewind()
  {
        return reset($_POST);
  }
  // возвращает текущий элемент
  public function current()
  {
      //return current($_POST);
      return $this->__get(key($_POST));
  }
  // возвращает ключ текущего элемента
  public function key()
  {
    return key($_POST);
  }
  
  // переходит к следующему элементу
  public function next()
  {
    return next($_POST);
  }
  // проверяет, существует ли текущий элемент после выполнения мотода rewind или next
  public function valid()
  {
//    return isset($_POST[key($_POST)]);
    return key_exists(key($_POST), $_POST);

  }    
/////////////////////////////
////////////////////////////////////////////////////////////////    
    
    
////////////////////////////////////////////////////////////////
///////////////////////////////     Методы интерфейса ArrayAccess
    /**
     * @param mixed $key
     * @return mixed
     * @access private
     */
    public function offsetExists($key)
    {
        return isset($_POST[$key]);
    }
    public function offsetGet($key)
    {
        return $this->__get($key);
        
/*     
        if (isset($_POST[$key]))
        {
            return $_POST[$key];
        }
        else 
           return $this->_default;
*/ 
    }
    
    public function offsetSet($key, $value)
    {
        $_POST[$key] = $value;
    }
    public function offsetUnset($key)
    {
        unset($_POST[$key]);
    }    
    
////////////////////////////////////////////////////////////////
///////////////////////////////     Защищенные методы
    protected function _filter($value)
    {
        $str = $value;
        if (is_array($str))
        {
            foreach ($str as $key => $value)
            {
                $str[$key] = $this->_filter($value);
            }
        }
        else 
        {
            if ($this->_charset)
            {
                $obj = new Dune_String_Charset_Convert($str);
                if ($this->_charset == 'windows-1251')
                {
                    $str = $obj->getWindows1251();
                }
             }
             if ($this->_encodingSourse != $this->_encoding)
             {
                $str_new = @iconv($this->_encodingSourse, $this->_encoding, $str);
                $str = $str_new;
             }
                    
             if ($this->_lendth)
                $str = substr($str, 0, $this->_lendth);
                    
             if ($this->_htmlSpecialChars)
                $str = htmlspecialchars($str);
        }   
        return $str;
    }
    
}
