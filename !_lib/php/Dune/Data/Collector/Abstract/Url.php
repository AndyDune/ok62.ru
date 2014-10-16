<?php
/**
 * Составитель строки запроса. Родитель для стандартного класса и синглетона.
 * 
 * ----------------------------------------------------
 * | Библиотека: Dune                                  |
 * | Файл: Url.php                                     |
 * | В библиотеке: Dune/Data/Colletor/Abstract/Url.php |
 * | Автор: Андрей Рыжов (Dune) <dune@rznw.ru>         |
 * | Версия: 1.02                                      |
 * | Сайт: www.rznw.ru                                 |
 * ----------------------------------------------------
 *
 * История версий:
 *
 * Версия 1.02
 * Новый метод getExeptLastFolder($count = 1) выбрать строку запроса без указаного числа последних каманд (папок).
 * 
 * Версия 1.00 -> 1.01
 * Добавлен метод getFolder() - выбрать папку(команду). Текущую, либо с номером.
 * Дабавлен контроль установки папки с номером - только после добавления. Иначе прерывание.
 * 
 */
abstract class Dune_Data_Collector_Abstract_Url
{
	protected $_domain = '/';
	
	protected $_foldersArray = array(1 => '', '', '', '', '', '');
	protected $_currentFolderNumber = 0;
	protected $_foldersString = '';

	protected $_string = '';
	protected $_parametersString = '';
	protected $_parametersArray = array();
	
	protected $_actionFile = '';
	
	protected function __construct()
	{
	    
	}
	
	/**
	 * Установка домена в запросе. !!! Слеш в конце не использовать.
	 * По умолчанию стоит "/".
	 * 
	 *
	 * @param string $domain
	 */
	public function setDomain($domain)
	{
		$this->_domain = 'http://' . $domain . '/';
	}

	/**
	 * Установка файла-обработчика запроса.
	 * По умолчанию не указано.
	 *
	 * @param string $file
	 */
	public function setActionFile($file)
	{
	    $this->_actionFile = $file;
	}
	
	/**
	 * Установка ипени папки по порядку, начиная с корня сайта.
	 * Нумерация с 1.
	 *
	 * @param string $name
	 * @param integer $position
	 */
	public function setFolder($name, $position = 1)
	{
	    if ($position > $this->_currentFolderNumber)
	       throw new Dune_Exception_Base('Установка папки только после добавления.');
	    $this->_string = '';
		$this->_foldersArray[$position] = $name;
	}

	/**
	 * Добавление папки, следующей по порядку.
	 * Новая позиция сохранияется.
	 *
	 * @param string $name
	 */
	public function addFolder($name)
	{
	    $this->_string = '';
	    ++$this->_currentFolderNumber;
		$this->_foldersArray[$this->_currentFolderNumber] = $name;
	}

	/**
	 * Выбрать папку (команду) с порядковым номером. При передаче номера 0(ноль) - выбрать последнюю добавленную.
	 * Если указан номер, превышающий общее число добавленных - возврат последнего.
	 * 
	 * @param integer $number выбрать папку с номером, начиная с 1 (0 - выбрать прследнюю добавленную)
	 */
	public function getFolder($number = 0)
	{
	    if (!$this->_currentFolderNumber)
	       return false;
	    if (($number > 0) and ($name <= $this->_currentFolderNumber))
	    {
	        $string = $this->_foldersArray[$number];
	    }
	    else 
	    {
	        $string = $this->_foldersArray[$this->_currentFolderNumber];
	    }
	    return $string;
	}
	
	/**
	 * Добавление параметра в строку запроса.
	 * По умолчанию значение пораметра кодируется urlencode().
	 *
	 * @param string $name
	 * @param mixed $value
	 * @param boolean $urlencode флаг применения функции urlencode() к значению
	 */
	public function addParameter($name, $value, $urlencode = true)
	{
	    $this->_string = '';
		if ($urlencode)
			$this->_parametersArray[$name] = urlencode($value);
	    else 
	    	$this->_parametersArray[$name] = $value;
	}

	/**
	 * Возвращает всю строку запроса.
	 * Результат кештруется, но сбрасывается установкой новых параметров, папок и т.д.
	 *
	 * @return string
	 */
	public function get()
	{
		if (!$this->_string)
		{
            $this->_string = $this->_domain
						   . $this->_collectFolders()
						   . $this->_actionFile
						   . $this->_collectParameters();
		}
		return $this->_string;
	}

	/**
	 * Возвращает всю строку запроса, исключает последнюю команду.
	 * Результат кештруется, но сбрасывается установкой новых параметров, папок и т.д.
	 *
	 * @return string
	 */
	public function getExeptLastFolder($count = 1)
	{
//		if (!$this->_string)
//		{
            $this->_string_ex = $this->_domain
						   . $this->_collectFoldersExeptLast($count)
						   . $this->_actionFile
						   . $this->_collectParameters();
//		}
		return $this->_string_ex;
	}
	
////////////////////////////////////////////////
///     Волшебные методы	
	public function __toString()
	{
	    return $this->get();
	}

////////////////////////////////////////////////
///     Защщенные методы	
	
	protected function _collectFolders()
	{
		$string = '';
		foreach ((array)$this->_foldersArray as $value)
		{
			if ($value != '')
    			$string .= $value . '/';
		}
		
		return $string;
	}

	protected function _collectFoldersExeptLast($count)
	{
		$string = '';
		$x = $count;
		foreach ((array)$this->_foldersArray as $value)
		{
		    if ($x == $this->_currentFolderNumber)
		      break;
			if ($value != '')
			{
    			$string .= $value . '/';
			}
			$x++;
		}
		
		return $string;
	}
	
	
	protected function _collectParameters()
	{
		$string = '';
		foreach ((array)$this->_parametersArray as $key => $value)
		{
			if ($string)
    			$string .= '&';
    	   else 
    	       $string .= '?';
    	   $string .= $key . '=' . $value;
		}
		return $string;
	}
	
}