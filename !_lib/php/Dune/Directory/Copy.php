<?php
/**
 * ����������� ���������� � ����� �����������.
 * 
 * ----------------------------------------------------
 * | ����������: Dune                                  |
 * | ����: Copy.php                                    |
 * | � ����������: Dune/Directory/Copy.php             |
 * | �����: ������ ����� (Dune) <dune@rznw.ru>         |
 * | ������: 0.98                                      |
 * | ����: www.rznw.ru                                 |
 * ----------------------------------------------------
 *
 * ������� ������:
 *
 * 0.98 (2009 ������� 24)
 * �������� �������� ���� ����. ���� ������������.
 * 
 * 
 */


class Dune_Directory_Copy
{

	protected $_directorySourse = '';
	protected $_directoryDestination = '';
	protected $_isDir = false;
	protected $_nesting = 0;
	
	protected $_deleteIfExists = false;	
	
	public function __construct($sourse, $destination)
	{
	    $this->_directorySourse = trim($sourse, ' /\\') ;
	    $this->_directoryDestination = ltrim($destination, ' /\\');
	    if (is_dir($_SERVER['DOCUMENT_ROOT'] . '/' . $this->_directorySourse))
	       $this->_isDir = true;
	}
	
	/**
	 * ���������� ���������� � ����������.
	 *
	 */
	public function copy()
	{
	    if ($this->_isDir)
	    {
	        $this->_nesting = 0;
    	    if (!$this->copyDir())
    	    {
    	        return false;
    	    }
    	    $this->_nesting = 0;
    	    $this->copyFiles();
	    }
	    $this->_isDir = false;
	}
	
	public function setDeleteFunctionIfExists($value = true)
	{
	    $this->_deleteIfExists = $value;
	    return $this;
	}
	
	/**
	 * ���������� ��������� ����� ����������.
	 *
	 */
	public function copyFiles()
	{
	    if ($this->_isDir)
	    {
    	    if (!$this->_copyFiles($_SERVER['DOCUMENT_ROOT'] . '/' . $this->_directorySourse, $_SERVER['DOCUMENT_ROOT'] . '/' . $this->_directoryDestination))
    	    {
    	        return false;
    	    }
    	    return true;
	    }
	    return false;
	}
	

	/**
	 * ���������� ��������� ����� ����������.
	 *
	 */
	public function copyDir()
	{
	    if ($this->_isDir)
	    {
	        if (!$this->_makeNewDir())
	           return false;
    	    if (!$this->_copyDir($_SERVER['DOCUMENT_ROOT'] . '/' . $this->_directorySourse, $_SERVER['DOCUMENT_ROOT'] . '/' . $this->_directoryDestination))
    	    {
    	        return false;
    	    }
    	    return true;
	    }
	    $this->_isDir = false;
	    return false;
	}
	
	
	protected function _makeNewDir()
	{
	    $result = false;
	    if (!is_dir($this->_directoryDestination))
	    {
	        $ndir = new Dune_Directory_Make($this->_directoryDestination);
	        if ($ndir->make(1))
	           $result = true;
	    }
	    else if ($this->_deleteIfExists)
	    {
	        $ndir = new Dune_Directory_Delete($this->_directoryDestination);
	        $ndir->deleteContent();
	        $result = true;
	    }
	    else 
	    {
	        $result = true;
	    }
	    return $result;
	}
	
	/**
	 * �������� ��������� �����.
	 *
	 * @param unknown_type $dirSourse
	 * @param unknown_type $dirDest
	 * @return boolean
	 * 
	 * @access private
	 */
    protected function _copyDir($dirSourse, $dirDest)
    {
        $this->_nesting++;
        $handle = opendir($dirSourse);
        while (false !== ($file = readdir($handle)))  
        {  
            if ($file != "." && $file != "..")  
            {  
                $file_full = $dirSourse   . "/" . $file; 
                $file_full_new = $dirDest . "/" . $file; 
                if(is_dir($file_full))
                {
                    if (!is_dir($file_full_new))
                    {
                        if (!mkdir($file_full_new))
                            return false;

                    }
                    if (!$this->_copyDir($file_full, $file_full_new))
                        return false;
                }
             } 
         } 
         closedir($handle);  
         $this->_nesting--;
         return true;
    }	
    
	/**
	 * �������� ��������� �����.
	 *
	 * @param string $dirSourse
	 * @param string $dirDest
	 * @return boolean
	 * 
	 * @access private
	 */
    protected function _copyFiles($dirSourse, $dirDest)
    { 
        $this->_nesting++;
        $handle = opendir($dirSourse);
        while (false !== ($file = readdir($handle)))  
        {  
            if ($file != "." && $file != "..")  
            {  
                $file_full     = $dirSourse   . "/" . $file; 
                $file_full_new = $dirDest . "/" . $file; 
                if(is_file($file_full))
                {
                    if (!is_file($file_full_new))
                    {
                        if (!copy($file_full, $file_full_new))
                            return false;
                    }
                }
                else 
                {
                    $this->_copyFiles($file_full, $file_full_new);
                }
             } 
         } 
         closedir($handle);  
         $this->_nesting--;
         return true;
    }	    
}