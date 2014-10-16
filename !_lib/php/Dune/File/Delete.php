<?php
/**
 * Удаление файла.
 * 
 * ----------------------------------------------------
 * | Библиотека: Dune                                  |
 * | Файл: Delete.php                                  |
 * | В библиотеке: Dune/File/Delete.php                |
 * | Автор: Андрей Рыжов (Dune) <dune@rznw.ru>         |
 * | Версия: 0.01                                      |
 * | Сайт: www.rznw.ru                                 |
 * ----------------------------------------------------
 *
 * История версий:
 *
 * 0.01 (2008 июль 24)
 * Создан. Не проверен.
 * Нет комментариев.
 * 
 * 
 */


class Dune_File_Delete
{

	protected $_name = '';
	protected $_path = '';
	protected $_nameFull = '';
	protected $_isNameFull = false;
	
	protected $_toCheck = true;
	
	protected $_have = false;
	protected $_can = false;
	protected $_try = 1;
	protected $_interval = 0;
	
	public function __construct($name, $is_full = true)
	{
        $this->_isNameFull = $is_full;
        if ($is_full)
        {
            $this->_nameFull = $name;
        }
	    else 
	    {
            $this->_name = $name;
	    }
	}
	

	public function setPath($value, $absolute = false)
	{
        $this->_have = false;
        $this->_can = false;
        $this->_toCheck = true;        
	    
	    if ($absolute)
	    {
	        $path = $_SERVER['DOCUMENT_ROOT'] . '/' . $value;
	    }
	    else 
	    {
	        $str = Dune_String_Factory::getStringContainer($value); // Трим из контейнера
            $value = $str->trim('/');
	        $path = $_SERVER['DOCUMENT_ROOT'] . '/' . $value;
	    }
	    
	    $this->_path = $path;
        if ($this->_path)
            $this->_nameFull = $this->_path . '/' . $this->_name;
        return $this;	    
	}
	
	
	public function setName($value)
	{
        $this->_have = false;
        $this->_can = false;
        $this->_toCheck = true;
        
        $this->_name = $value;
        if ($this->_path)
            $this->_nameFull = $this->_path . '/' .$this->_name;
        return $this;
	}
	
	/**
	 * Удалить файл.
	 *
	 */
	public function delete()
	{
	    if ($this->_toCheck)
	    {
	        $this->_checkFile($this->_nameFull);
	        $this->_toCheck = false;
	    }
	    
	    if ($this->_can)
	    {
	        return $this->_unlink();
	    }
	    return false;
	}
	
	public function setTryCount($value = 2)
	{
	    $this->_try = $value;
	}
	
	public function setTryInterval($value = 0)
	{
	    $this->_interval = $value;
	}

	
	public function haveFile()
	{
	    return $this->_have;
	}
	
	public function canDelete()
	{
	    return $this->_can;
	}
	
	protected function _checkFile($name)
    {
        if (is_file($name))
        {
            $this->_have = true;
            if (is_writeable($name))
            {
                $this->_can = true;
                $this->_nameFull = $name;
            }
        }
        return $this->_can;
    }
    
    
	
    protected function _unlink()
    {
        $file = $this->_nameFull;
        $try = $this->_try;
        $time = $this->_interval;
        for($x = 1; $x <= $try; $x++)
        {
           if (unlink($file))
               return true;
           if ($time)
           {
               time_nanosleep(0, $time);
           }
        }
        return false;
    }
	
	

}