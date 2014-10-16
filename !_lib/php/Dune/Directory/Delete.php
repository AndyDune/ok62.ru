<?php
/**
 * Удаление директории и(или) содержимого.
 * 
 * ----------------------------------------------------
 * | Библиотека: Dune                                  |
 * | Файл: Delete.php                                  |
 * | В библиотеке: Dune/Directory/Delete.php           |
 * | Автор: Андрей Рыжов (Dune) <dune@rznw.ru>         |
 * | Версия: 1.02                                      |
 * | Сайт: www.rznw.ru                                 |
 * ----------------------------------------------------
 *
 * История версий:
 *
 * 1.02 (2008 апрель 15)
 * Удаление старых файлов в папке.
 * Удаление пустых старых папок.
 * 
 * 1.01 (2008 декабрь 05)
 * При удалении проверка на существование папки
 * 
 * 
 */


class Dune_Directory_Delete
{

	protected $_directoryName = '';
	protected $_isDir = false;
	protected $_nesting = 0;
	
	public function __construct($name)
	{
	    $this->_directoryName = $name;
	    if (is_dir($name))
	       $this->_isDir = true;
	}
	
	/**
	 * Удалить указанную директорию со всем содержимым.
	 *
	 */
	public function delete()
	{
	    if ($this->_isDir)
	    {
    	    $this->_delete($this->_directoryName, true);
    	    rmdir($this->_directoryName);
	    }
	    $this->_isDir = false;
	}
	/**
	 * Удалить только файлы из директории. Включая вложенные.
	 *
	 */
	public function deleteFiles()
	{
	    $this->_delete($this->_directoryName);
	}

	/**
	 * Удалить только старые файлы из директории. Включая вложенные.
	 *
	 */
	public function deleteFilesOld($time)
	{
	    $this->_deleteOldFiles($this->_directoryName, $time);
	}

	/**
	 * Удалить только старые файлы и папки из директории. Включая вложенные.
	 *
	 */
	public function deleteOld($time)
	{
	    if ($this->_deleteOldFiles($this->_directoryName, $time, true) === 0)
	    {
	        rmdir($this->_directoryName);
	    }
	}
	
	
	/**
	 * Удалить только поддиректории со всем содержимым. Файлы в самой самой директории оставить.
	 *
	 */
	public function deleteSubFolders()
	{
	    $this->_delete($this->_directoryName, true, true);
	}
	
	/**
	 * Удалить только содержимое директории.
	 * Саму директорию оставить.
	 *
	 */
	public function deleteContent()
	{
	    $this->_delete($this->_directoryName, true);
	}
	
	
	/**
	 * Удаляем с параметрами.
	 *
	 * @param string $dir имя директории.
	 * @param boolean $andDirs флаг удаления директорий.
	 * @param boolean $and_files длаг неудаления файлов в самой папке.
	 * @return boolean
	 *
	 * @access private
	 */
    protected function _delete($dir, $andDirs = false, $and_files = false)
    { 
        if (!$this->_isDir)
            return false;
        $this->_nesting++;
        $handle = opendir($dir);  
        while (false !== ($file = readdir($handle)))  
        {  
            if ($file != "." && $file != "..")  
            {  
                $del_file = $dir . "/" . $file; 
                if(!is_dir($del_file))
                {
                    if ($and_files)
                    {
                        if ($this->_nesting > 1)
                            unlink($del_file);
                    }
                    else 
                        unlink($del_file);
                }
                else
                { 
                    $this->_delete($del_file, $andDirs);
                } 
             } 
         } 
         closedir($handle);  
         if ($andDirs and ($this->_nesting > 1))
            rmdir($dir); 
         $this->_nesting--;
         return true;
    }	
    
    
	/**
	 * Удаляем с параметрами.
	 *
	 * @param string $dir имя директории.
	 * @param boolean $andDirs флаг удаления директорий.
	 * @param boolean $and_files длаг неудаления файлов в самой папке.
	 * @return boolean
	 *
	 * @access private
	 */
    protected function _deleteOldFiles($dir, $time, $del_folder = false)
    { 
        if (!$this->_isDir)
            return false;
        $this->_nesting++;
        $handle = opendir($dir);  
        $count = 0;
        while (false !== ($file = readdir($handle)))  
        {  
            if ($file != "." && $file != "..")  
            {  
                $count++;
                $del_file = $dir . "/" . $file; 
                if(!is_dir($del_file))
                {
                    if (filemtime($del_file) < $time)
                    {
                        unlink($del_file);
                        $count--;
                    }
                }
                else
                { 
                    if ($this->_deleteOldFiles($del_file, $time, $del_folder) === 0)
                        $count--;
                } 
             } 
         } 
         closedir($handle);  
         if ($del_folder and !$count and ($this->_nesting > 1))
            rmdir($dir); 
         $this->_nesting--;
         return $count;
    }	
    
}