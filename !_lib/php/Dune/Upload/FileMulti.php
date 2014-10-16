<?php
/**
 * Класс инкапсулирует в себе массив с параметрами загруженных файлов в пакете: $_FILES[имя пакета]
 * Сохраняет расшифровку кодов ошибок. Доступ по ключу "err_name"
 * 
 * Реализует интерфейсы: ArrayAccess
 * Определены волшебныек методы: __set, __get
 * 
 * ----------------------------------------------------
 * | Библиотека: Dune                                  |
 * | Файл: FileMulti.php                               |
 * | В библиотеке: Dune/Upload/FileMulti.php           |
 * | Автор: Андрей Рыжов (Dune) <dune@rznlf.ru>        |
 * | Версия: 1.00                                      |
 * | Сайт: www.rznlf.ru                                |
 * ----------------------------------------------------
 * 
 * Версия 1.00 -> 1.01

 * 
 */

class Dune_Upload_FileMulti implements ArrayAccess
{
    // Имя поля input в форме
    protected $formFieldName;
    
    // Массив $_FILE['$formFieldName']
    /*
    $file["name"] 
    $file["tmp_name"]
    $file["size"]
    $file["type"] 
    $file["error"] 
    Значения $file["error"]: 
    0 - ошибок не было, файл загружен. 
    1 - размер загруженного файла превышает размер установленный параметром upload_max_filesize в php.ini 
    2 - размер загруженного файла превышает размер установленный параметром MAX_FILE_SIZE в HTML форме. 
    3 - загружена только часть файла 
    4 - файл не был загружен (Пользователь в форме указал неверный путь к файлу).    
    
    $file['err_name'] - имя ошибки
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
		                    $this->fileArray[$key]['err_name'] = 'Ошибок не было, файл загружен';
		                break;
		                case 1:
		                    $this->fileArray[$key]['err_name'] = 'Размер загруженного файла превышает размер установленный параметром upload_max_filesize в php.ini';
		                break;
		                case 2:
		                    $this->fileArray[$key]['err_name'] = 'Размер загруженного файла превышает размер установленный параметром MAX_FILE_SIZE в HTML форме';
		                break;
		                case 3:
		                    $this->fileArray[$key]['err_name'] = 'Загружена только часть файла';
		                break;                    
		                case 4:
		                    $this->fileArray[$key]['err_name'] = 'Файл не был загружен (Пользователь в форме указал неверный путь к файлу)';
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
     * Возвращает маркер сущестования массива $_FILES[$name]
     *
     * @return boolean
     */
    public function uploaded()
    {
        return $this->haveUpload;
    }
    /**
     * Возвращает маркер безошибочной загрузки хотя бы одного файла в пакете.
     *
     * @return boolean
     */
    public function isCorrect()
    {
        return $this->correctUpload;
    }

    /**
     * Возвращает исходное имя файла на клиентской машине.
     *
     * @return string
     */
    public function getName()
    {
        return $this->file['name'];
    }
    /**
     * Возвращает временное имя файла. Которое было привоено сервером.
     *
     * @return string
     */
    public function getTmpName()
    {
        return $this->file['tmp_name'];
    }
    
    /**
     * Возвращает размер загруженного файла в байтах
     *
     * @return integer
     */
    public function getSize()
    {
        return $this->file['size'];
    }
    
    /**
     * Возвращает MINE-тип файла
     * 
     *  @return string
     */
    public function getType()
    {
        return $this->file['type'];
    }
    
    /**
     * Возращает код статуса после заугрузки файла.
     * 0 - ошибок не было, файл загружен. 
     * 1 - размер загруженного файла превышает размер установленный параметром upload_max_filesize в php.ini 
     * 2 - размер загруженного файла превышает размер установленный параметром MAX_FILE_SIZE в HTML форме. 
     * 3 - загружена только часть файла 
     * 4 - файл не был загружен (Пользователь в форме указал неверный путь к файлу).    
     *
     * @return integer
     */
    public function getError()
    {
        return $this->file['error'];
    }
    
    /**
     * Возвращает строку с расшифровкой статуса загрузки
     *
     * @return string
     */
    public function getErrorName()
    {
        return $this->file['err_name'];
    }
    
    
    
////////////////////////////////////////////////////////////////
///////////////////////////////     Магические методы
    public function __set($name, $value)
    {
        throw new Dune_Exception_Base('Зарещено менять значения массива $_FILES["'.$this->formFieldName.'"]');
    }
    public function __get($name)
    {
        if (!$this->haveUpload)
            return false;
        if (!key_exists($name,$this->fileArray))
            throw new Dune_Exception_Base('Ошибка чтения значения массива $_FILES["'.$this->formFieldName.'"]['.$name.'] не существует');
        return $this->fileArray[$name];
    }
/////////////////////////////
////////////////////////////////////////////////////////////////
    
    
////////////////////////////////////////////////////////////////
///////////////////////////////     Методы интерфейса ArrayAccess
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
            //throw new Dune_Exception_Base('Ошибка чтения значения массива $_FILES["'.
            //                    $this->formFieldName.'"]: ключа '.$key.' не существует');
            return false;
                                
        return $this->fileArray[$key];
    }
    
    public function offsetSet($key, $value)
    {
        throw new Dune_Exception_Base('Зарещено менять значения массива $_FILES["'.$this->formFieldName.'"]');
    }
    public function offsetUnset($key)
    {
        throw new Dune_Exception_Base('Зарещено менять значения массива $_FILES["'.$this->formFieldName.'"]');
    }

/////////////////////////////
////////////////////////////////////////////////////////////////

}