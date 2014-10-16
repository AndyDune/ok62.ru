<?php
/**
 * Dune Framework
 * 
 * Оболочка для строковых функций. Важно для работы с UTF-8.
 * 
 * ----------------------------------------------------
 * | Библиотека: Dune                                  |
 * | Файл: Functions.php                               |
 * | В библиотеке: Dune/String/Functions.php           |
 * | Автор: Андрей Рыжов (Dune) <dune@rznw.ru>         |
 * | Версия: 0.05                                      |
 * | Сайт: www.rznw.ru                                 |
 * ----------------------------------------------------
 *
 * История версий:
 *
 * 0.05 (2009 апрель 30)
 * Ошибка была
 * 
 * 0.04 (2009 апрель 23)
 * Внедрил использование объектов-контейнеров повсеместно.
 * 
 * 0.03 (2009 апрель 16)
 * Ошибка в методе sub()
 * 
 * 0.01 (2009 март 25)
 * Рабоатет метод len()
 * 
 * 0.02 (2009 апрель 13)
 * Методы pos(), posr(), str(), stri(), sub()
 * trim() - не проверено.
 * 
 */

abstract class Dune_String_Functions
{

    static $UTF = false;
    
	static function len($string)
	{
	    $stro = Dune_String_Factory::getStringContainer($string);
	    return $stro->len();
	    
/*	    if (self::$UTF)
	       return mb_strlen($string, 'UTF-8');
	    return strlen($string);
*/	    
	}
	
	
	
	
	/**
	 * Возвращает числовую позицию первого вхождения $string.
	 *
	 * @param string $string_what что ищем
	 * @param string $string_where где ищем
	 * @param unknown_type $offset
	 * @return mixed
	 */
	public static function pos($string_what, $string_where, $offset = 0)
	{
	    $stro = Dune_String_Factory::getStringContainer($string_where);
	    return $stro->pos($string_what, $offset);
//	    return strpos($string_where, $string_what, $offset);
	}


	/**
	 * Возвращает числовую позицию последнего вхождения $string.
	 *
	 * @param string $string_what что ищем
	 * @param string $string_where где ищем
	 * @param unknown_type $offset
	 * @return mixed
	 */
	public static function posr($string_what, $string_where, $offset = 0)
	{
	    $stro = Dune_String_Factory::getStringContainer($string_where);
	    return $stro->posr($string_what, $offset);
//	    return strrpos($string_where, $string_what, $offset);
	}
	
	
	
	/**
	 * Находит первое вхождение подстроки
	 * Возвращает часть строки $string_where от первого вхождения $string_what до конца $string_where.
     *
     * Если $string_what не найден, возвращает FALSE.
     * Если $string_what не строка, он конвертируется в integer и применяется как порядковое значение символа.
	 *
	 * @param string $string_what
	 * @param string $string_where
	 * @return mixed
	 */
	public static function str($string_what, $string_where)
	{
	    $stro = Dune_String_Factory::getStringContainer($string_where);
	    return $stro->str($string_what);
//	    return strstr($string_where, $string_what);
	}
	
	/**
	 * Находит первое вхождение подстроки.   Регистро-независимый вариант функции strstr().
	 * 
	 * Возвращает часть строки $string_where от первого вхождения $string_what до конца $string_where.
     *
     * Если $string_what не найден, возвращает FALSE.
     * Если $string_what не строка, он конвертируется в integer и применяется как порядковое значение символа.
	 *
	 * @param string $string_what
	 * @param string $string_where
	 * @return mixed
	 */
	public static function stri($string_what, $string_where)
	{
	    $stro = Dune_String_Factory::getStringContainer($string_where);
	    return $stro->stri($string_what);
//	    return stristr($string_where, $string_what);
	}

	
	/**
	 * Возвращает подстроку.
	 *
	 * Если start неотрицателен, возвращаемая подстрока начинается в позиции start от начала строки, считая от нуля.
	 * Например, в строке 'abcdef', в позиции 0 находится символ 'a', в позиции 2 - символ 'c', и т.д. 
     *
     * Если start отрицательный, возвращаемая подстрока начинается с start символа с конца строки string.
	 * 
     * Если length положительный, возвращаемая строка будет не длиннее length символов. 
     * Если длина строки string меньше или равна start символов, возвращается FALSE. 
     *
     * Если length отрицательный, то будет отброшено указанное этим аргументом число символов с конца строки string.
     * Если при этом позиция начала подстроки, определяемая аргументом start, находится в отброшенной части строки, возвращается пустая строка.
	 * 
     * Пример. Использование отрицательного length:
     *     $rest = substr("abcdef", 0, -1);  // возвращает "abcde"
     *     $rest = substr("abcdef", 2, -1);  // возвращает "cde"
     *     $rest = substr("abcdef", 4, -4);  // возвращает ""
     *     $rest = substr("abcdef", -3, -1); // возвращает "de"
	 * 
	 * @param string $string
	 * @param integer $start
	 * @param integer $length
	 * @return string
	 */
	public static function sub($string, $start, $length = null)
	{
	    $stro = Dune_String_Factory::getStringContainer($string);
	    return $stro->substr($start, $length);
//	    return substr($string, $start, $length);
	}
	
   /** 
     * Trim characters from either (or both) ends of a string in a way that is 
     * multibyte-friendly. 
     * 
     * Mostly, this behaves exactly like trim() would: for example supplying 'abc' as 
     * the charlist will trim all 'a', 'b' and 'c' chars from the string, with, of 
     * course, the added bonus that you can put unicode characters in the charlist. 
     * 
     * We are using a PCRE character-class to do the trimming in a unicode-aware 
     * way, so we must escape ^, \, - and ] which have special meanings here. 
     * As you would expect, a single \ in the charlist is interpretted as 
     * "trim backslashes" (and duly escaped into a double-\ ). Under most circumstances 
     * you can ignore this detail. 
     * 
     * As a bonus, however, we also allow PCRE special character-classes (such as '\s') 
     * because they can be extremely useful when dealing with UCS. '\pZ', for example, 
     * matches every 'separator' character defined in Unicode, including non-breaking 
     * and zero-width spaces. 
     * 
     * It doesn't make sense to have two or more of the same character in a character 
     * class, therefore we interpret a double \ in the character list to mean a 
     * single \ in the regex, allowing you to safely mix normal characters with PCRE 
     * special classes. 
     * 
     * *Be careful* when using this bonus feature, as PHP also interprets backslashes 
     * as escape characters before they are even seen by the regex. Therefore, to 
     * specify '\\s' in the regex (which will be converted to the special character 
     * class '\s' for trimming), you will usually have to put *4* backslashes in the 
     * PHP code - as you can see from the default value of $charlist. 
     * 
     * @param string 
     * @param charlist list of characters to remove from the ends of this string. 
     * @param boolean trim the left? 
     * @param boolean trim the right? 
     * @return String 
     */ 
    static function mb_trim($string, $charlist='\\\\s', $ltrim=true, $rtrim=true) 
    { 
        $both_ends = $ltrim && $rtrim; 

        $char_class_inner = preg_replace( 
            array( '/[\^\-\]\\\]/S', '/\\\{4}/S' ), 
            array( '\\\\\\0', '\\' ), 
            $charlist 
        ); 

        $work_horse = '[' . $char_class_inner . ']+'; 
        $ltrim && $left_pattern = '^' . $work_horse; 
        $rtrim && $right_pattern = $work_horse . '$'; 

        if($both_ends) 
        { 
            $pattern_middle = $left_pattern . '|' . $right_pattern; 
        } 
        elseif($ltrim) 
        { 
            $pattern_middle = $left_pattern; 
        } 
        else 
        { 
            $pattern_middle = $right_pattern; 
        } 

        return preg_replace("/$pattern_middle/usSD", '', $string); 
    }	
	
    
    
    
// Отсюда http://code.elxis.org/20080/nav.html?_functions/index.html
// Требует проверки

    /**
    * Unicode aware replacement for ltrim()
    *
    * @author Andreas Gohr 
    * @see ltrim()
    * @return string
    */
    static function utf8_ltrim($str,$charlist='')
    {
        if($charlist == '') return ltrim($str);
        //quote charlist for use in a characterclass
        $charlist = preg_replace('!([\\\\\\-\\]\\[/])!','\\\$1}',$charlist);
        return preg_replace('/^[' . $charlist . ']+/u', '', $str);
    }
    /**
    * Unicode aware replacement for rtrim()
    *
    * @author Andreas Gohr 
    * @see rtrim()
    * @return string
    */
    static function utf8_rtrim($str,$charlist='')
    {
        if($charlist == '') return rtrim($str);
        //quote charlist for use in a characterclass
        $charlist = preg_replace('!([\\\\\\-\\]\\[/])!', '\\\$1}', $charlist);
        return preg_replace('/[' . $charlist . ']+$/u','', $str);
    }
    /**
    * Unicode aware replacement for trim()
    *
    * @author Andreas Gohr 
    * @see trim()
    * @return string
    */
    static function utf8_trim($str,$charlist='') 
    {
        if($charlist == '') return trim($str);
        return utf8_ltrim(utf8_rtrim($str));
    }    
    
}

