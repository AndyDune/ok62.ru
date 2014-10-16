<?php
/**
 * Dune Framework
 * 
 * Преобразование строки только UTF. 
 * В точности аналогичен Dune_String_Transform
 * 
 * ----------------------------------------------------
 *  UTF-8
 * ----------------------------------------------------
 * | Библиотека: Dune                                  |
 * | Файл: TransformMB.php                             |
 * | В библиотеке: Dune/String/TransformMB.php         |
 * | Автор: Андрей Рыжов (Dune) <dune@rznw.ru>         |
 * | Версия: 2.00                                      |
 * | Сайт: www.rznw.ru                                 |
 * ----------------------------------------------------
 *
 * История версий:
 *
 * 
 */

class Dune_String_TransformMB extends Dune_String_Transform
{

	/**
	 * Последовательности из трех точек заменяет на символ &#8230;
	 *
	 */
	public function correctOmissionPoints($backward = false)
	{
	    if ($backward)
	       $this->_stringResult = preg_replace('&#8230;|' . $this->uniChr(0x8230), '...', $this->_stringResult);
	    else 
	       $this->_stringResult = preg_replace('/\.{3}/', $this->uniChr(0x8230), $this->_stringResult);
	    return $this;
	}	

	
    /**
     * Return unicode char by its code
     *
     * Отсюда: http://ru2.php.net/manual/en/function.chr.php
     * 
     * @param int $u
     * @return char
     */
    public function uniChr($u)
    {
        return mb_convert_encoding('&#' . intval($u) . ';', 'UTF-8', 'HTML-ENTITIES');
    }	
    
}

