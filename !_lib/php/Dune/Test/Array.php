<?php
/**
 * Тестирование и проверка массивов.
 * 
 * ----------------------------------------------------
 * | Библиотека: Dune                                  |
 * | Файл: Array.php                                   |
 * | В библиотеке: Dune/Test/Array.php                 |
 * | Автор: Андрей Рыжов (Dune) <dune@rznlf.ru>        |
 * | Версия: 1.00                                      |
 * | Сайт: www.rznlf.ru                                |
 * ----------------------------------------------------
 *
 * История версий:
 *
 * Версия 1.00 -> 1.01
 * 
 * 
 */
class Dune_Test_Array
{

	protected $_array = array();
	protected $_isArray = false;
	
	public function __construct($array)
	{
		if (is_array($array))
		{
			$this->_isArray = true;
			$this->_array = $array;
		}
	}
	
	public function printPre()
	{
		echo '<pre>';
		print_r($this->_array);
		echo '</pre>';
	}

	
////////////////////////////////////////////////////////////////
///////////////////////////////     Магические методы
    public function __set($name, $value)
    {
        $this->_array[$name] = $value;
    }
    public function __get($name)
    {
        if (isset($this->_array[$name]))
            return $this->_array[$name];
        else 
           return false;
    }    
}