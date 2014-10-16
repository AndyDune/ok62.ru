<?php
/**
 * Контейнер строки $_SERVER['HPPT_REFERER]
 * 
 * ----------------------------------------------------
 * | Библиотека: Dune                                  |
 * | Файл: Referer.php                                 |
 * | В библиотеке: Dune/String/Referer.php             |
 * | Автор: Андрей Рыжов (Dune) <dune@rznlf.ru>        |
 * | Версия: 1.00                                      |
 * | Сайт: www.rznlf.ru                                |
 * ----------------------------------------------------
 *
 */

class Dune_String_Referer
{
	protected $_string = '';
	protected $_have = false;
	protected $_array = array(
                                'scheme'    => '',
                                'host'      => '',
                                'user'      => '',
                                'pass'      => '',
                                'path'      => '',
                                'query'     => '',
                                'fragment'  => ''
	                           );
	protected $_noParsed = true;
	
	
	public function __construct()
	{
	    if (isset($_SERVER['HTTP_REFERER']))
	    {
    		$this->_string = $_SERVER['HTTP_REFERER'];
    		if ($this->_string)
    		  $this->_have = true;
	    }
	}

	/**
	 * Возвращает true, если установлен $_SERVER['HTTP_REFERER'].
	 * false - в обратном случае.
	 *
	 * @return boolean
	 */
	public function have()
	{
		return $this->_have;
	}
	
	
	/**
	 * Проверка на вхождение субстроки в исходной строке $_SERVER['HTTP_REFERER']
	 *
	 * @param string $string
	 * @return boolean
	 */
	public function haveSubString($string)
	{
	    if (strpos($this->_string, $string) !== false)
	       $have = true;
	    else 
	       $have = false;
	    return $have;
	}
	
	/**
	 * Возвращает всю строку $_SERVER['HTTP_REFERER']
	 *
	 * @return string
	 */
	public function get()
	{
	    return $this->_string;
	}
	
	public function getHost()
	{
	    if ($this->_noParsed)
	       $this->_parse();
	    return $this->array['host'];
	}
	public function getPath()
	{
	    if ($this->_noParsed)
	       $this->_parse();
	    return $this->array['path'];
	}

	public function getQuery()
	{
	    if ($this->_noParsed)
	       $this->_parse();
	    return $this->array['query'];
	}

	public function getAnchor()
	{
	    if ($this->_noParsed)
	       $this->_parse();
	    return $this->array['fragment'];
	}
	
	/**
	 * Парсирует
	 * 
	 * @access privete
	 *
	 */
	protected function _parse()
	{
	    if ($this->_have)
	       $this->array = parse_url($this->_string);
	    $this->_noParsed = false;
	}	

}

