<?php
/**
 * Dune Framework
 * 
 * Контейнер строки. Функции-обертки над стандартными.
 * Цель: Максимально сгладить переход на utf-8.
 * В перспекотве переход на php6.
 * Все строковые функции в проектах через этот класс.
 * 
 * ----------------------------------------------------
 * | Библиотека: Dune                                  |
 * | Файл: Container.php                               |
 * | В библиотеке: Dune/String/Container.php           |
 * | Автор: Андрей Рыжов (Dune) <dune@rznw.ru>         |
 * | Версия: 0.94                                      |
 * | Сайт: www.rznw.ru                                 |
 * ----------------------------------------------------
 *
 * История версий:
 *
 *  0.94 (2009 июль 28)
 *  Добавлен ucfirst()
 * 
 *  0.93 (2009 апрель 28)
 *  Новые методы tolower() и toupper().
 *  
 *  0.92 (2009 апрель 27)
 *  Новый метод setString(). Вызов конструктора без передачи строки.
 * 
 *  0.90 (2009 апрель 06)
 *  Реализует не все функции.
 * 
 *  0.91 (2009 апрель 13)
 *  Названия сетодлв: rpos -> posr, istr -> stri.
 * 
 */

class Dune_String_Container implements Dune_String_Interface_Container
{
    /**
     * Строка.
     *
     * @var string
     */
	protected $_string = '';
	
	public function __construct($string = '')
	{
	    $this->_string = (string)$string;
	}

	/**
	 * Установка обрабатываемой строки.
	 *
	 * @param tring $string
	 */
	public function setString($string)
	{
	    $this->_string = (string)$string;
	    return $this;
	}
	
	
	/**
	 * Равенство строк.
	 *
	 * @param string $str Приводится к типу string.
	 * @param  $min Минимальное число символов в строке.
	 * @return boolean
	 */
	public function equal($str, $min = 0)
	{
	    $str = (string)$str;
	    if ($min)
	    {
	        if ($this->lenlocal($str) >= $min and $this->_string === $str)
	           return true;
	    }
	    else 
	    {
	        if ($this->_string == $str)
	           return true;
	    }
	    return false;
	}
	
	/**
	 * Длина строки.
	 *
	 * @return integer
	 */
	public function len()
	{
	    return $this->lenlocal($this->_string);
	}
	
	/**
	 * Для внутренних нужд.
	 *
	 * @param string $string
	 * @return integer
	 */
	protected function lenlocal($string)
	{
	    return strlen($string);
	}
	
	/**
	 * Возвращает числовую позицию первого вхождения $string.
	 *
	 * @param string $string
	 * @param integer $offset
	 * @return mixed
	 */
	public function pos($string, $offset = 0)
	{
	    return strpos($this->string, $string, $offset);
	}

	/**
	 * Возвращает числовую позицию последнего вхождения $string.
	 *
	 * @param string $string
	 * @param integer $offset 
	 * @return mixed
	 */
	public function posr($string, $offset = null)
	{
	    return strrpos($this->string, $string, $offset);
	}
	
	/**
	 * Возвращает часть строки haystack от первого вхождения needle до конца haystack.
     *
     * Если needle не найден, возвращает FALSE.
     * Если needle не строка, он конвертируется в integer и применяется как порядковое значение символа.
	 *
	 * @param unknown_type $string
	 * @return unknown
	 */
	public function str($string)
	{
	    return strstr($this->_string, $string);
	}

	/**
	 *  Метод str() без учёта регистра.
	 *
	 * @param unknown_type $string
	 * @return unknown
	 */
	public function stri($string)
	{
	    return stristr($this->_string, $string);
	}
	
	/**
	 * Возвращает часть строки.
	 * 
	 * Если start отрицательный, возвращаемая строка начинается со start'ового символа, считая от конца строки string.
	 * 
	 * Если length задан и положительный, возвращаемая строка будет содержать максимум length символов,
	 *  начиная со start (в зависимости от длины строки string. Если string меньше start, возвращается FALSE).
     *
     * Если length задан и негативный, то это количество символов будет пропущено,
     *  начиная с конца string (после вычисления стартовой позиции, когда start негативный). Если start задаёт позицию за пределами этого усечения, возвращается пустая строка.
	 *
	 * @param integer $start Если start отрицательный, возвращаемая строка начинается со start'ового символа, считая от конца строки string.
	 * @param integer $length
	 * @return string
	 */
	public function substr($start, $length = null)
	{
	    return substr($this->_string, $start, $length);
	}
	
	
	public function trim($charlist = '')
	{
	    return trim($this->_string, $charlist);
	}
	public function trimr($charlist = '')
	{
	    return rtrim($this->_string, $charlist);
	}
	
	public function triml($charlist = '')
	{
	    return ltrim($this->_string, $charlist);
	}
	
	
	public function tolower()
	{
	    return strtolower($this->_string);
	}
	public function toupper()
	{
	    return strtoupper($this->_string);
	}
	
	
	public function ucfirst()
	{
	    $string = $this->_string;
	    $string = ucfirst($string);
	    return $string;
	}
	
	
	
////////////////////////////////////////////////////////////////////
////////        Магические методы	

	// Печать строки - результата.
    public function __toString()
    {
    	return  $this->_string;
    }
	
	
}

