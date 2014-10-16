<?php
/**
 * !! Устаревший - не использовать.
 * Проверяет входной одномерный массив на наличие ключа.
 * Если ключа нет - возвращает значение по умолчанию.
 * 
 * ----------------------------------------------------
 * | Библиотека: Dune                                  |
 * | Файл: IsSet.php                                   |
 * | В библиотеке: Dune/Array/IsSet.php                |
 * | Автор: Андрей Рыжов (Dune) <dune@rznlf.ru>        |
 * | Версия: 1.02                                      |
 * | Сайт: www.rznlf.ru                                |
 * ----------------------------------------------------
 *
 * История версий:
 *
 * Версия 1.01 -> 1.02
 * При запросе несуществующего элемента массива методом get() возвращаетс false
 * 
 * Версия 1.00 -> 1.01
 * Добавлен метод check() - проверка установки ключа в массиве
 * 
 * 
 */
class Dune_Array_IsSet
{

	protected $_array = array();
	protected $_defaultValue = '';
	
	public function __construct($array, $defaultValue = '')
	{
		$this->_array = $array;
		$this->_defaultValue = $defaultValue;
	}
	
	/**
	 * Возвращает колличество элементов массива
	 *
	 * @return integer
	 */
	public function count()
	{
		return count($this->_array);
	}

	/**
	 * Возвращает весь массив, если не указан параметр $key
	 * Возвращает содержимое ячейки массива с индексом переданным в $key
	 *
	 * @param string $key
	 * @return mixed
	 */
	public function get($key = '')
	{
		if ($key)
		{
			if (isset($this->_array[$key]))
				return $this->_array[$key];
			else 
				return false;
		}
		else 
			return $this->_array;
	}
	
	/**
	 * Устанавливает новое значение по умолчанию 
	 *
	 * @param unknown_type $value
	 */
	public function setDefaultValue($value)
	{
		$this->_defaultValue = $value;
	}

	/**
	 * Проверка установки ключа в массиве.
	 *
	 * @param mixed $key ключ для проверки
	 * @return boolean true - если установлен, false - нет
	 */
	public function check($key)
	{
		return isset($this->_array[$key]);
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
           return $this->_defaultValue;
    }    
}