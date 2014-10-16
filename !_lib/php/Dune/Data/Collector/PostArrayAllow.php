<?php
/**
 * Обработка массива $_POST с сохранением в масив только допустимых значений с фильтром.
 * 
 * ----------------------------------------------------
 * | Библиотека: Dune                                  |
 * | Файл: Url.php                                     |
 * | В библиотеке: Dune/Data/Colletor/Url.php          |
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
class Dune_Data_Collector_PostArrayAllow
{
	private $_array = array();
	private $_arrayMade = false;
	private $_allowArray = array();
	
	/**
	 * Код фильтра - возврат целого числа
	 *
	 */
	const FILTER_INT = 'int';
	
	/**
	 * Код фильтра - примерить функцию htmlcpecialchars()
	 *
	 */
	const FILTER_HTML = 'html';
	
	
	public function __construct()
	{
	    
	}
	
	/**
	 * Добавить разрешённы ключ для массива $_POST.
	 * Передавать можно массив в соответствующем формате.
	 * [ключ] => array(
	 *                 'filter' => код фильтра, // обязательный, иначе прерывание
	 *                 'default' => значение по умолчанию, если ключ в массиве должен быть даже если в $_POST его нет.
	 *                 )
	 * или альтернативно, без значения по умолчанию
	 * [ключ] => код фильтра
	 *
	 * @param mixed $value
	 * @param string $filter код фильтра, используйте константы класса
	 * @param mixed $default по умолчанимю
	 */
	public function allow($value, $filter = 'no', $default = null)
	{
	    $this->_arrayMade = false;
	    if (is_array($value))
	    {
	        foreach ($value as $key => $val)
	        {
	            if (is_array($val))
	            {
	                if (!isset($val['filter'])) // Обязательный ключ
	                   throw new Dune_Exception_Base('Не передан обязательный ключ в массиве допустимых значений. Класс Dune_Data_Collector_PostArrayAllow');
	               $this->_allowArray[$key] = $val;
	            }
	            else 
	               $this->_allowArray[$key] = array('filter' => $val);
	        }
	    }
	    else 
	    {
	        $this->_allowArray[$value] = array('filter' => $filter, 'default' => $default);
	    }
	}
	
	/**
	 * Обработать $_POST.
	 *
	 * @return array обработанный массив
	 */
	public function make()
	{
	    if ($this->_arrayMade)
	    {
	        return $this->_array;
	    }
	    if (count($_POST) and count($this->_allowArray)) // Если массивы есть
	    {
	        foreach ($this->_allowArray as $key => $value) // Перебор разрещённых
	        {
	            if (key_exists($key, $_POST)) // Если есть в $_POST
	            {
	                switch ($value['filter']) // Выбираем фильтр
	                {
	                    case 'int':
	                        $this->_array[$key] = (int)$_POST[$key];
	                    break;
	                    case 'html':
	                        $this->_array[$key] = htmlspecialchars($_POST[$key]);
	                    break;
	                    default:
	                        $this->_array[$key] = $_POST[$key];
	                    
	                }
	            }
	            // Если в $_POST нет
	            else if (isset($value['default']) and (!is_null($value['default']))) //Если есть значение по умолчанию
	            {
	                $this->_array[$key] = $value['default'];
	            }
	        }
	        $this->_arrayMade = true; // Флаг сделанной обработки
	    }
	    return $this->_array;
	}
	
	/**
	 * Вернуть обработанный массив.
	 * Прежде обрабатывает его, если до этого не сделано.
	 *
	 * @return array обработанный массив
	 */
	public function getArray()
	{
	    return $this->make();
	}
	
	/**
	 * Число элементов в обработанном массиве
	 *
	 * @return integer
	 */
	public function countArray()
	{
	    return count($this->_array);
	}

	/**
	 * Возврат массива разрещённых
	 *
	 * @return array
	 */
	public function getAllowArray()
	{
	    return $this->_allowArray;
	}
	
}