<?php
/**
 * Dune Framework
 * 
 * Преобразование строки
 * Обработка текста:
 *  Удаление лишних переводов строк
 *  Замена последовательности из 3-х точек символом &#8230;
 *  Заменяе кавычки на русские елочки
 *  Замена дефиса длинным тире. 
 * 
 * ----------------------------------------------------
 * | Библиотека: Dune                                  |
 * | Файл: Transform.php                               |
 * | В библиотеке: Dune/String/Transform.php           |
 * | Автор: Андрей Рыжов (Dune) <dune@rznw.ru>         |
 * | Версия: 0.95                                      |
 * | Сайт: www.rznw.ru                                 |
 * ----------------------------------------------------
 *
 * История версий:
 *
 * 0.95 (2009 июнь 1)
 * При замене квычек на елочки открывающиеся елочки получаются и при закрывающемся предыдущем теге.
 * 
 * 0.94 (2009 май 13)
 * Усовершенствование замены елочеке. Уход от строронней функции.
 * Новый метод linkNofollow() обработка ссылки как сторонней.
 * 
 * 0.93 (2009 май 12)
 * При замене двойных кавычек елочками - игнорирование кавычек в тегах.
 * 
 * 0.92 (2009 февраль 06)
 * Метол замены переводов строк на brake
 * 
 * 0.91 (2009 январь 23)
 * Для методов-заданий реализована возможность построения "цепочек";
 * 
 * 0.90 (2009 январь 15)
 * Создан с базовым функционалом.
 * 
 */

class Dune_String_Transform
{
	protected $_stringSourse;
	protected $_stringResult = '';
	
	public function __construct($string)
	{
	    $this->_stringResult = $this->_stringSourse = $string;
	}

	/**
	 * Удаляет несколько подряд идущих символов новой строки.
	 * Призводтся анализ на существование спец сиволов разных ОС.
	 *
	 * @param integer $count сколько символов новой строки оставить
	 * @return Dune_String_Transform
	 */
	public function deleteLineFeed($count = 1)
	{
	    $needle = false;
	    if (strpos($this->_stringResult, "\r\n")) // Текст набран в Win
	    {
	        $needle = "\r\n";
	    }
	    else if (strpos($this->_stringResult, "\n")) // Текст набран в Unix
	    {
	        $needle = "\n";
	    }
	    else if (strpos($this->_stringResult, "\r")) // Текст набран в Mac
	    {
	        $needle = "\r";
	    }
	    
	    $rep = '';
	    if ($count)
	    {
	        for ($x = 1; $x <= $count; $x++ )
	           $rep .= $needle;
	    }
	    if ($needle)
	    {
	        $count++;
	        $this->_stringResult = preg_replace('/(' . $needle . '){' . $count . ',}/', $rep, $this->_stringResult);
	    }
	    return $this;
	}
	
    /**
	 * Заменяет переводы строк на символ <br />
	 * Призводтся анализ на существование спец сиволов разных ОС.
	 *
	 * @param integer $count сколько символов новой строки оставить
	 * @return Dune_String_Transform
	 */
	public function setLineFeedToBreak()
	{
	    $needle = false;
	    if (strpos($this->_stringResult, "\r\n")) // Текст набран в Win
	    {
	        $needle = "\r\n";
	    }
	    else if (strpos($this->_stringResult, "\n")) // Текст набран в Unix
	    {
	        $needle = "\n";
	    }
	    else if (strpos($this->_stringResult, "\r")) // Текст набран в Mac
	    {
	        $needle = "\r";
	    }
	    
	    $rep = '<br />';

	    if ($needle)
	    {
	        $this->_stringResult = preg_replace('/(' . $needle . ')/', $rep, $this->_stringResult);
	    }
	    return $this;
	    
	}
	
	/**
	 * Последовательности из трех точек заменяет на символ &#8230;
	 * 
	 * @return Dune_String_Transform
	 *
	 */
	public function correctOmissionPoints($backward = false)
	{
	    if ($backward)
	       $this->_stringResult = preg_replace('&#8230;', '...', $this->_stringResult);
	    else 
	       $this->_stringResult = preg_replace('/\.{3}/', '&#8230;', $this->_stringResult);
	    return $this;
	}	

	/**
	 * Обработка ссылок против спама.
	 * Добавление <noindex> и rel="external nofollow"
	 * @return Dune_String_Transform
	 *
	 */
	public function linkNofollow()
	{
	    $this->_stringResult = preg_replace('/(<a )/', '<noindex>$1rel="external nofollow" ', $this->_stringResult);	
	    $this->_stringResult = preg_replace('/(\/a>)/', '$1</noindex> ', $this->_stringResult);	
	    return $this;
	}
	
	/**
	 * Заменяет английские открывающие кавычки-«лапки» на русские «елочки».
	 *
	 * @return Dune_String_Transform
	 */
	public function setQuoteRussian()
	{
	    $this->_stringResult = preg_replace('/(\S)&quot;([ .,?!]|$)/', '$1&raquo;$2', $this->_stringResult);	
	    $this->_stringResult = preg_replace('/(^|\s|>)&quot;(\S)/', '$1&laquo;$2', $this->_stringResult);
//	    $this->_stringResult = preg_replace('/"+\s*"+/', '"', $this->_stringResult);
	    $this->_stringResult = $this->_quotesOutTags($this->_stringResult);
//	    $this->_stringResult = preg_replace('/(\S)"([ .,?!]|$)/', '$1&raquo;$2', $this->_stringResult);	
//        $this->_stringResult = preg_replace('/(^|\s)"(\S)/', '$1&laquo;$2', $this->_stringResult);
        return $this;
	}
	
	/**
	 * Кавычки в елочки. Внутри тегов не обрабатывается.
	 *
	 * @param string $str
	 * @return string
	 * @access private
	 */
    protected function _quotesOutTags($str)
    {
        $pos = 0;
        $str_o = Dune_String_Factory::getStringContainer($str);
        $len = $str_o->len();

        $tokens = array(
            '"' => 1, // 0 - кавычки
            '<' => 2, // 1 - открытая угловая скобка
            '>' => 3  // 2 - закрытая угловая скобка
                      // 3 - прочее
            );
        
        
        $find_tag_open = false;
        $find_quote = false;
        
        $cur = 0;
        $result = '';
        $pos_max = $len - 1;
        while ($pos < $len)
        {
            $ch = $str[$pos];
            
            $token = 0;
            
            if (isset($tokens[$ch]))
                $token = $tokens[$ch];
             switch ($token)
             {
                 case 1: // Кавычка
                    if (!$find_tag_open)
                    {
                        if ( !$pos or
                                (
                                    $pos < $pos_max
                                    and 
                                    in_array($str[$pos - 1], array(' ', "\n", "\r", '>'))
                                )
                           )
                        {
                            $result .= '&laquo;';
                        }
                        else 
                            $result .= '&raquo;';
                        $find_quote = !$find_quote;
                    }
                    else 
                        $result .= $ch;
                 break;
                 case 2:
                     $find_tag_open = true;
                     $result .= $ch;
                 break;
                 case 3:
                     $find_tag_open = false;
                     $result .= $ch;
                 break;
                 default:
                     $result .= $ch;
                 break;
                 
             }
             $pos++;
        }
    
        return $result;
    }	
	

    /**
     * Проверка на конечных автоматах - не совершенна и сложна для свободной модификации.
     *
     * @param unknown_type $str
     * @return unknown
     * @access private
     */
    protected  function _quotesOutTagsKA($str)
    {
        $pos = 0;
        $str_o = Dune_String_Factory::getStringContainer($str);
        $len = $str_o->len();
    
        $tokens = array(
            '"' => 0, // 0 - кавычки
            '<' => 1, // 1 - открытая угловая скобка
            '>' => 2  // 2 - закрытая угловая скобка
                      // 3 - прочее
            );
        $flags = array(
            //Лексемы: 0   1   2   3
            0 => array(1,  4,  0,  0), // начало парсинга; ожидается любой символ
            1 => array(2,  1,  2,  2), // встретилась кавычка
            2 => array(3,  2,  2,  2), // находимся внутри кавычек; принимаем любые символы пока не встретим следующую (закрывающую) кавычку
            3 => array(1,  4,  0,  0), // встретилась закрывающая кавычка
            4 => array(5,  5,  6,  5), // встретилось открытие тега (открывающая угловая скобка)
            5 => array(5,  5,  6,  5), // находимся внутри тега; принимаем любые символы пока не встретим закрывающую угловую скобку
            6 => array(1,  4,  0,  0)  // встретилась закрывающая скобка
        );
    
        $cur = 0;
        $result = '';
        $pos_max = $len - 1;
        while ($pos < $len)
        {
            $ch = $str[$pos];
            
            $token = 3;
            if (isset($tokens[$ch]))
                $token = $tokens[$ch];
            $flag = $flags[$cur][$token];
            
            switch ($flag)
            {
                case 1:
                    $result .= '&laquo;';
                    break;
                case 3:
                    if (
                        $pos < $pos_max
                        and 
                        in_array($str[$pos - 1], array(' ', "\n", "\r"))
                       )
                    {
                        $result .= '&laquo;';
                        $flag = 2;
                    }
                    else 
                        $result .= '&raquo;';
                    break;
                default:
                    $result .= $ch;
                    break;            
            }
    
            $cur = $flag;
            $pos++;
        }
    
        return $result;
    }	
    
    
	/**
	 * Замена дефиса длинным тире.
	 *
	 */
	public function correctDash()
	{
	    $this->_stringResult = preg_replace(' - ', '&nbsp;&#8212; ', $this->_stringResult);
	    return $this;
	}	
	
	
	/**
	 * Возврат результирующей строки.
	 *
	 * @return ctring
	 */
	public function getResult()
	{
	    return $this->_stringResult;
	}

	/**
	 * Возврат строки к первоначальному виду.
	 *
	 */
	public function clearResult()
	{
	    $this->_stringResult = $this->_stringSourse;
	    return $this;
	}
	
	
////////////////////////////////////////////////////////////////////
////////        Магические методы	

	// Печать строки - результата.
    public function __toString()
    {
    	return  $this->_stringResult;
    }
	
	
}

