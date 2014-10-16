<?php
/**
 * Dune Framework
 * 
 * Обрезание строки для создания превью текста.
 * Обработка обрезаемого текста:
 *  не обрезает слова на части;
 *  не обрезает строку после предлогов и некоторых слов;
 *  не отрывает точку, запятую, двоеточие, точку с запятой, закрывающуюся скобку от предыдущего слова.
 *  возможно установить обрезание только по законченым предложениям (после точки)
 * 
 * ----------------------------------------------------
 * | Библиотека: Dune                                  |
 * | Файл: CutShort.php                                |
 * | В библиотеке: Dune/String/CutShort.php            |
 * | Автор: Андрей Рыжов (Dune) <dune@rznw.ru>         |
 * | Версия: 0.92                                      |
 * | Сайт: www.rznw.ru                                 |
 * ----------------------------------------------------
 *
 * История версий:
 *
 * 0.92 (2008 апрель 28)
 * !! Функционал не полный.
 * Работа со строками через методы класса.
 * 
 * 0.91 (2008 декабрь 04)
 * Анализ строки на обрубание слов через массив $_spaces - т.е. все только пробельные символы.
 * 
 */

class Dune_String_CutShort
{
	protected $_string;
	/**
	 * Объект контейнер строки.
	 *
	 * @var Dune_String_Interface_Container
	 */
	protected $_stringObject;
	protected $_stringLength;
	protected $_result = '';
	protected $_direction = true;
    
	protected $_words = array('а', 'б', 'в', 'г', 'д', 'е' , 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я'
	 );
	protected $_spaces = array(' ', "\r", "\n");
	
	public function __construct($string)
	{
	    $this->_string = $string;
	    $this->_stringObject = Dune_String_Factory::getStringContainer($string);
	    $this->_stringLength = $this->_stringObject->len();
	    
	}

	/**
	 * Возврат обрезанной строки без учёта ее состава.
	 *
	 * @param integer $length
	 * @return string
	 */
	public function cutBrute($length)
	{
	    return $this->_stringObject->substr(0, $length);
//	    return substr($this->_string, 0, $length);
	}

	/**
	 * Обрезать строку.
	 * После запуска этого метода вызов методов доступа у данным результата возможен.
	 *
	 * @param unknown_type $length
	 * @return unknown
	 */
	public function cut($length)
	{
	    if ($length >= $this->_stringLength)
	    {
	       $this->_result = $this->_string;
	       return false;
	    }
	    $pointer =  $this->_cutNoWordDivision($length);
	    
	    //return $this->_result;
	    return true;
	}

	
	public function getResultString()
	{
	    return $this->_result;
	}
	public function getResultStringLength()
	{
	    $string = Dune_String_Factory::getStringContainer($this->_result);
	    return $string->len();
//	    return strlen($this->_result);
	}
	
	
	/**
	 * Обрезка строки без рубки слов.
	 * Коррекировка длины результирующей строки..
	 *
	 * @param integer $length
	 * @return integer указатель на текущую позицию в строке-источнике
	 */
	protected function _cutNoWordDivision($length)
	{
	    $pointer = $length - 1;
    // $string =  substr($this->_string, 0, $length);
	    $string = $this->_stringObject->substr(0, $length);
	    $str = Dune_String_Factory::getStringContainer($string[$pointer]);
	    $last_word = $str->tolower();
//	    $last_word = strtolower($string[$pointer]);
	    $corrected_length = $length;
	    $no_find_end_of_word = true;
	    if (!in_array($string[$pointer], $this->_spaces) and !in_array($this->_string[$length], $this->_spaces))
	    {
	        if ($this->_direction) // Направленеи анализа - увеличение строки
	        {
	            for ($run = $length; $run < $this->_stringLength; $run++)
	            {
	                if (in_array($this->_string[$run], $this->_spaces))
	                {
	                    $corrected_length = $run; // В позиции нашлось не слово
	                    $no_find_end_of_word = false;
	                    break;
	                }
	                $no_find_end_of_word = true;
	            }
	            
	            if ($no_find_end_of_word)
	            {
	                $length = $this->_stringLength;
	            }
	            else 
	               $length = $corrected_length;
	               
//	            $string =  substr($this->_string, 0, $length);
	            $string = $this->_stringObject->substr(0, $length);
	            $pointer = $length - 1;
	        }
	        else // Направленеи анализа - уменьшение строки.
	        {
	            for ($run = $length; $run > 0; $run--)
	            {
	                if (in_array($this->_string[$run], $this->_spaces))
	                {
	                    $corrected_length = $run; // В позиции нашлось не слово
	                    $no_find_end_of_word = false;
	                    break;
	                }
	                $no_find_end_of_word = true;
	            }
	            
	            if (!$no_find_end_of_word)
	               $length = $corrected_length;
	               
	            //$string =  substr($this->_string, 0, $length);
	            $string = $this->_stringObject->substr(0, $length);
	            $pointer = $length - 1;
	            
	        }
	    }
	    $this->_result = $string;
	    return $pointer;
	}
	
}

