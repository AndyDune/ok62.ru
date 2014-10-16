<?php
/**
 * ����� ������������� � ���� ������ � ����������� ����������� ������ � ������: $_FILES[��� ������]
 * ��������� ����������� ����� ������. ������ �� ����� "err_name"
 * 
 * ��������� ����������: ArrayAccess
 * ���������� ���������� ������: __set, __get
 * 
 * ----------------------------------------------------
 * | ����������: Dune                                  |
 * | ����: FileMulti.php                               |
 * | � ����������: Dune/Upload/FileMulti.php           |
 * | �����: ������ ����� (Dune) <dune@rznlf.ru>        |
 * | ������: 1.00                                      |
 * | ����: www.rznlf.ru                                |
 * ----------------------------------------------------
 * 
 * ������ 1.00 -> 1.01

 * 
 */

class Dune_Upload_FileMulti implements ArrayAccess
{
    // ��� ���� input � �����
    protected $formFieldName;
    
    // ������ $_FILE['$formFieldName']
    /*
    $file["name"] 
    $file["tmp_name"]
    $file["size"]
    $file["type"] 
    $file["error"] 
    �������� $file["error"]: 
    0 - ������ �� ����, ���� ��������. 
    1 - ������ ������������ ����� ��������� ������ ������������� ���������� upload_max_filesize � php.ini 
    2 - ������ ������������ ����� ��������� ������ ������������� ���������� MAX_FILE_SIZE � HTML �����. 
    3 - ��������� ������ ����� ����� 
    4 - ���� �� ��� �������� (������������ � ����� ������ �������� ���� � �����).    
    
    $file['err_name'] - ��� ������
    */
    protected $fileArray = null;
    protected $file = array(
    						'name' => null,
    						'tmp_name' => null,
    						'size' => null,
    						'type' => null,
    						'error' => null,
    						'err_name' => null
    						);
    protected $currentFile;
    
    protected $haveUpload = false;
    
    protected $countFiles = 0;
    
    protected $correctUpload = false;
    
    public function __construct($name)
    {
        $this->formFieldName = $name;
        
        
        if (isset($_FILES[$name]) and is_array($_FILES[$name]))
        {
            $this->haveUpload = true;
            $_files = $_FILES[$name];
            $this->fileArray = array();
            if (is_array($_files['name']))
            { // 3
	            foreach ($_files['name'] as $key => $value)
	            { // 2 
	            	$this->fileArray[$key]['name'] 		= $_files['name'][$key];
	            	$this->fileArray[$key]['type'] 		= $_files['type'][$key];
	            	$this->fileArray[$key]['tmp_name'] 	= $_files['tmp_name'][$key];
	            	$this->fileArray[$key]['error'] 	= $_files['error'][$key];
	            	$this->correctUpload[$key] = false;
		            switch ($_files['error'][$key])
		            { // 1
		                case 0:
		                    $this->correctUpload[$key] = true;
		                    $this->fileArray[$key]['err_name'] = '������ �� ����, ���� ��������';
		                break;
		                case 1:
		                    $this->fileArray[$key]['err_name'] = '������ ������������ ����� ��������� ������ ������������� ���������� upload_max_filesize � php.ini';
		                break;
		                case 2:
		                    $this->fileArray[$key]['err_name'] = '������ ������������ ����� ��������� ������ ������������� ���������� MAX_FILE_SIZE � HTML �����';
		                break;
		                case 3:
		                    $this->fileArray[$key]['err_name'] = '��������� ������ ����� �����';
		                break;                    
		                case 4:
		                    $this->fileArray[$key]['err_name'] = '���� �� ��� �������� (������������ � ����� ������ �������� ���� � �����)';
		            } // 1
	            } // 2
	            $this->countFiles = count($this->fileArray);
	            $this->currentFile = key($this->fileArray);
	            $this->file = current($this->fileArray);
        	} // 3
        }
        
/*        echo '<pre>';
        print_r($this->fileArray);
        echo '</pre>';
*/        
    }
    
    public function getList()
    {
    	return $this->fileArray;
    }
    
    public function getCount()
    {
    	return $this->countFiles;
    }    
    public function isKeyExist($key)
    {
    	return key_exists($key, $this->fileArray);
    }
    public function nextKey()
    {
   		next($this->fileArray);
   		$file = current($this->fileArray);
   		if ($file !== false)
   		{
   			$this->file = $file;
    		$this->currentFile = key($this->fileArray);
    		return $this->currentFile;
   		}
   		return false;
    }
    public function resetKey()
    {
   		reset($this->fileArray);
   		$file = current($this->fileArray);
   		if ($file !== false)
   		{
   			$this->file = $file;
    		$this->currentFile = key($this->fileArray);
    		return $this->currentFile;
   		}
   		return false;
    }    
   public function useKey($key)
    {
    	if (key_exists($key, $this->fileArray))
    	{
    		$this->file = $this->fileArray[$key];
    		$this->currentFile = $key;
    		return true;
    	}
    	return false;
    }     
    /**
     * ���������� ������ ������������ ������� $_FILES[$name]
     *
     * @return boolean
     */
    public function uploaded()
    {
        return $this->haveUpload;
    }
    /**
     * ���������� ������ ������������ �������� ���� �� ������ ����� � ������.
     *
     * @return boolean
     */
    public function isCorrect()
    {
        return $this->correctUpload;
    }

    /**
     * ���������� �������� ��� ����� �� ���������� ������.
     *
     * @return string
     */
    public function getName()
    {
        return $this->file['name'];
    }
    /**
     * ���������� ��������� ��� �����. ������� ���� �������� ��������.
     *
     * @return string
     */
    public function getTmpName()
    {
        return $this->file['tmp_name'];
    }
    
    /**
     * ���������� ������ ������������ ����� � ������
     *
     * @return integer
     */
    public function getSize()
    {
        return $this->file['size'];
    }
    
    /**
     * ���������� MINE-��� �����
     * 
     *  @return string
     */
    public function getType()
    {
        return $this->file['type'];
    }
    
    /**
     * ��������� ��� ������� ����� ��������� �����.
     * 0 - ������ �� ����, ���� ��������. 
     * 1 - ������ ������������ ����� ��������� ������ ������������� ���������� upload_max_filesize � php.ini 
     * 2 - ������ ������������ ����� ��������� ������ ������������� ���������� MAX_FILE_SIZE � HTML �����. 
     * 3 - ��������� ������ ����� ����� 
     * 4 - ���� �� ��� �������� (������������ � ����� ������ �������� ���� � �����).    
     *
     * @return integer
     */
    public function getError()
    {
        return $this->file['error'];
    }
    
    /**
     * ���������� ������ � ������������ ������� ��������
     *
     * @return string
     */
    public function getErrorName()
    {
        return $this->file['err_name'];
    }
    
    
    
////////////////////////////////////////////////////////////////
///////////////////////////////     ���������� ������
    public function __set($name, $value)
    {
        throw new Dune_Exception_Base('�������� ������ �������� ������� $_FILES["'.$this->formFieldName.'"]');
    }
    public function __get($name)
    {
        if (!$this->haveUpload)
            return false;
        if (!key_exists($name,$this->fileArray))
            throw new Dune_Exception_Base('������ ������ �������� ������� $_FILES["'.$this->formFieldName.'"]['.$name.'] �� ����������');
        return $this->fileArray[$name];
    }
/////////////////////////////
////////////////////////////////////////////////////////////////
    
    
////////////////////////////////////////////////////////////////
///////////////////////////////     ������ ���������� ArrayAccess
    public function offsetExists($key)
    {
        if (!$this->haveUpload)
            return false;
        return key_exists($key,$this->fileArray);
    }
    public function offsetGet($key)
    {
        if (!$this->haveUpload)
            return false;
        if (!key_exists($key,$this->fileArray))
            //throw new Dune_Exception_Base('������ ������ �������� ������� $_FILES["'.
            //                    $this->formFieldName.'"]: ����� '.$key.' �� ����������');
            return false;
                                
        return $this->fileArray[$key];
    }
    
    public function offsetSet($key, $value)
    {
        throw new Dune_Exception_Base('�������� ������ �������� ������� $_FILES["'.$this->formFieldName.'"]');
    }
    public function offsetUnset($key)
    {
        throw new Dune_Exception_Base('�������� ������ �������� ������� $_FILES["'.$this->formFieldName.'"]');
    }

/////////////////////////////
////////////////////////////////////////////////////////////////

}