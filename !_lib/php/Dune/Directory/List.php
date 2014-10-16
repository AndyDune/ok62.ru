<?php
/**
 * Преобразование массива.
 * 
 * ----------------------------------------------------
 * | Библиотека: Dune                                  |
 * | Файл: List.php                                    |
 * | В библиотеке: Dune/Directory/List.php             |
 * | Автор: Андрей Рыжов (Dune) <dune@rznlf.ru>        |
 * | Версия: 1.01                                      |
 * | Сайт: www.rznlf.ru                                |
 * ----------------------------------------------------
 *
 * История версий:
 *
 * Версия 1.00 -> 1.01
 * Введена возможность удаления файлов
 * 
 * 
 */


class Dune_Directory_List
{

	protected $_directoryName = '';
	protected $_isDir = false;
	
	protected $_array = array();
	protected $_countArray = 0;
	protected $_arraySorted = array();
	protected $_countArraySorted = 0;
	protected $_arrayFiles = array();
	protected $_countArrayFiles = 0;
	protected $_arrayDir = array();
	protected $_countArrayDir = 0;
	
	/**
	 * Конструктор. Сканирует директорию, если такая есть.
	 * Создаёт отдельные массивы для имён папок и файлов.
	 * Удаляет из массива папки '.' и '..'
	 *
	 * @param string $name Имя папки для сканирования. Не указывать в конце сепаратор директорий!
	 */
	public function __construct($name = '.')
	{
		$this->_directoryName = $name;
		$this->_isDir = is_dir($name);
		if ($this->_isDir)
		{
		    $d = opendir($name);
            while (false !== ($e=readdir($d)))
            {
                if (!(
                    (($e == '.') or ($e == '..')) and 
                    (is_dir($name . DIRECTORY_SEPARATOR . $e))
                   ))
	                $this->_array[] = $e;
            } 

		    $this->_countArray = count($this->_array);
		    $this->_makeArrays();
		}
	}

	/**
	 * Возвращает флаг существования обрабатываемой директории.
	 *
	 * @return boolean
	 */
	public function is()
	{
	    return $this->_isDir;
	}
	
	/**
	 * Сортировка массивов.
	 *
	 */
	public function sort()
	{
	    ksort($this->_arrayDir);
	    ksort($this->_arrayFiles);
	}
	
	/**
	 * Возвращает массив несортированный.
	 *
	 * @return unknown
	 */
	public function getList()
	{
	    return $this->_array;
	}
	
	/**
	 * Возвращает сортированный массив по алфавиту.
	 * В списке сначала папки затем файлы. 
	 *
	 * @return array
	 */
	public function getListSorted()
	{
	    if (!$this->_countArraySorted)
	    {
	        if ($this->_countArrayDir > 0 )
	        {
	            foreach ($this->_arrayDir as $val)
	            {
                    $this->_arraySorted[] = $val;
	            }
	        }
	        if ($this->_countArrayFiles > 0 )
	        {
	            foreach ($this->_arrayFiles as $val)
	            {
	                $this->_arraySorted[] = $val;
	            }
	        }
	        $this->_countArraySorted = count($this->_arraySorted);
	    }
	    return $this->_arraySorted;
	}

	/**
	 * Возвращает массив со списком файлов.
	 * Если вызывается после мотода sort() отсортирован.
	 *
	 * @return array
	 */
	public function getListFiles()
	{
	    return $this->_arrayFiles;
	}

	/**
	 * Возвращает фисло файлов в папке файлов.
	 *
	 * @return array
	 */
	public function getCountFiles()
	{
	    return count($this->_arrayFiles);
	}

	/**
	 * Удаляет все файлы.
	 *
	 * @return array
	 */
	public function deleteFiles()
	{
		if (count($this->_arrayFiles) > 0)
		{
			foreach ($this->_arrayFiles as $file)
			{
				@unlink($this->_directoryName . DIRECTORY_SEPARATOR . $file);
			}
		}
	}
	
	
	/**
	 * Возвращает массив со списком папок.
	 * Если вызывается после мотода sort() отсортирован.
	 *
	 * @return array
	 */
	public function getListDir()
	{
	    return $this->_arrayDir;
	}
	
	
	
	
	/**
	 * Создаёт массивы файлов и папок.
	 *
	 * @access private
	 */
	protected function _makeArrays()
	{
	    if ($this->_directoryName == '.')
	       $name = '';
	    else 
	       $name = $this->_directoryName;
	       
	    if ($this->_countArray)
	    {
	        foreach ($this->_array as $array)
	        {
	            if (is_dir($this->_directoryName . DIRECTORY_SEPARATOR . $array))
	            {
  	                $this->_arrayDir[] = $array;
	            }
	            else 
	            {
	                $this->_arrayFiles[] = $array;
	            }
	        }
	        $this->_countArrayFiles = count($this->_arrayFiles);
	        $this->_countArrayDir   = count($this->_arrayDir);
	    }
	}
}