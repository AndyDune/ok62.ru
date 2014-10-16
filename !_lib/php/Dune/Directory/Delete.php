<?php
/**
 * �������� ���������� �(���) �����������.
 * 
 * ----------------------------------------------------
 * | ����������: Dune                                  |
 * | ����: Delete.php                                  |
 * | � ����������: Dune/Directory/Delete.php           |
 * | �����: ������ ����� (Dune) <dune@rznw.ru>         |
 * | ������: 1.02                                      |
 * | ����: www.rznw.ru                                 |
 * ----------------------------------------------------
 *
 * ������� ������:
 *
 * 1.02 (2008 ������ 15)
 * �������� ������ ������ � �����.
 * �������� ������ ������ �����.
 * 
 * 1.01 (2008 ������� 05)
 * ��� �������� �������� �� ������������� �����
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
	 * ������� ��������� ���������� �� ���� ����������.
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
	 * ������� ������ ����� �� ����������. ������� ���������.
	 *
	 */
	public function deleteFiles()
	{
	    $this->_delete($this->_directoryName);
	}

	/**
	 * ������� ������ ������ ����� �� ����������. ������� ���������.
	 *
	 */
	public function deleteFilesOld($time)
	{
	    $this->_deleteOldFiles($this->_directoryName, $time);
	}

	/**
	 * ������� ������ ������ ����� � ����� �� ����������. ������� ���������.
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
	 * ������� ������ ������������� �� ���� ����������. ����� � ����� ����� ���������� ��������.
	 *
	 */
	public function deleteSubFolders()
	{
	    $this->_delete($this->_directoryName, true, true);
	}
	
	/**
	 * ������� ������ ���������� ����������.
	 * ���� ���������� ��������.
	 *
	 */
	public function deleteContent()
	{
	    $this->_delete($this->_directoryName, true);
	}
	
	
	/**
	 * ������� � �����������.
	 *
	 * @param string $dir ��� ����������.
	 * @param boolean $andDirs ���� �������� ����������.
	 * @param boolean $and_files ���� ���������� ������ � ����� �����.
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
	 * ������� � �����������.
	 *
	 * @param string $dir ��� ����������.
	 * @param boolean $andDirs ���� �������� ����������.
	 * @param boolean $and_files ���� ���������� ������ � ����� �����.
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