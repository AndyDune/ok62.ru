<?php
/**
 * Dune Framework
 * 
 * �������� ��� ��������� �������. ����� ��� ������ � UTF-8.
 * 
 * ----------------------------------------------------
 * | ����������: Dune                                  |
 * | ����: Functions.php                               |
 * | � ����������: Dune/String/Functions.php           |
 * | �����: ������ ����� (Dune) <dune@rznw.ru>         |
 * | ������: 0.05                                      |
 * | ����: www.rznw.ru                                 |
 * ----------------------------------------------------
 *
 * ������� ������:
 *
 * 0.05 (2009 ������ 30)
 * ������ ����
 * 
 * 0.04 (2009 ������ 23)
 * ������� ������������� ��������-����������� �����������.
 * 
 * 0.03 (2009 ������ 16)
 * ������ � ������ sub()
 * 
 * 0.01 (2009 ���� 25)
 * �������� ����� len()
 * 
 * 0.02 (2009 ������ 13)
 * ������ pos(), posr(), str(), stri(), sub()
 * trim() - �� ���������.
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
	 * ���������� �������� ������� ������� ��������� $string.
	 *
	 * @param string $string_what ��� ����
	 * @param string $string_where ��� ����
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
	 * ���������� �������� ������� ���������� ��������� $string.
	 *
	 * @param string $string_what ��� ����
	 * @param string $string_where ��� ����
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
	 * ������� ������ ��������� ���������
	 * ���������� ����� ������ $string_where �� ������� ��������� $string_what �� ����� $string_where.
     *
     * ���� $string_what �� ������, ���������� FALSE.
     * ���� $string_what �� ������, �� �������������� � integer � ����������� ��� ���������� �������� �������.
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
	 * ������� ������ ��������� ���������.   ��������-����������� ������� ������� strstr().
	 * 
	 * ���������� ����� ������ $string_where �� ������� ��������� $string_what �� ����� $string_where.
     *
     * ���� $string_what �� ������, ���������� FALSE.
     * ���� $string_what �� ������, �� �������������� � integer � ����������� ��� ���������� �������� �������.
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
	 * ���������� ���������.
	 *
	 * ���� start �������������, ������������ ��������� ���������� � ������� start �� ������ ������, ������ �� ����.
	 * ��������, � ������ 'abcdef', � ������� 0 ��������� ������ 'a', � ������� 2 - ������ 'c', � �.�. 
     *
     * ���� start �������������, ������������ ��������� ���������� � start ������� � ����� ������ string.
	 * 
     * ���� length �������������, ������������ ������ ����� �� ������� length ��������. 
     * ���� ����� ������ string ������ ��� ����� start ��������, ������������ FALSE. 
     *
     * ���� length �������������, �� ����� ��������� ��������� ���� ���������� ����� �������� � ����� ������ string.
     * ���� ��� ���� ������� ������ ���������, ������������ ���������� start, ��������� � ����������� ����� ������, ������������ ������ ������.
	 * 
     * ������. ������������� �������������� length:
     *     $rest = substr("abcdef", 0, -1);  // ���������� "abcde"
     *     $rest = substr("abcdef", 2, -1);  // ���������� "cde"
     *     $rest = substr("abcdef", 4, -4);  // ���������� ""
     *     $rest = substr("abcdef", -3, -1); // ���������� "de"
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
	
    
    
    
// ������ http://code.elxis.org/20080/nav.html?_functions/index.html
// ������� ��������

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

