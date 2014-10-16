<?php
/**
 * Класс инкапсулирует в себе массив с параметрами загруженного файла
 * Сохраняет расшифровку кодов ошибок. Доступ по ключу "err_name"
 * 
 * Реализует интерфейсы: ArrayAccess
 * Определены волшебныек методы: __set, __get
 * 
 * ----------------------------------------------------
 * | Библиотека: Dune                                  |
 * | Файл: File.php                                    |
 * | В библиотеке: Dune/Upload/File.php                |
 * | Автор: Андрей Рыжов (Dune) <dune@rznlf.ru>        |
 * | Версия: 1.02                                      |
 * | Сайт: www.rznlf.ru                                |
 * ----------------------------------------------------
 *
 * Версия 1.01 -> 1.02
 * Добавлена интерфейсные методы.
 * 
 * Версия 1.00 -> 1.01
 * Прерывания библиотеки
 * новый метод isCorrect()
 * 
 */

class Dune_Upload_File implements ArrayAccess
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
    protected $file = null;
    
    protected $haveUpload = false;
    
    protected $correctUpload = false;
    
    public function __construct($name)
    {
        $this->formFieldName = $name;
        if (isset($_FILES[$name]) and is_array($_FILES[$name]))
        {
            $this->haveUpload = true;
            $this->file = $_FILES[$name];
            switch ($this->file['error'])
            {
                case 0:
                    $this->correctUpload = true;
                    $this->file['err_name'] = 'Ошибок не было, файл загружен';
                break;
                case 1:
                    $this->file['err_name'] = 'Размер загруженного файла превышает размер установленный параметром upload_max_filesize в php.ini';
                break;
                case 2:
                    $this->file['err_name'] = 'Размер загруженного файла превышает размер установленный параметром MAX_FILE_SIZE в HTML форме';
                break;
                case 3:
                    $this->file['err_name'] = 'Загружена только часть файла';
                break;                    
                case 4:
                    $this->file['err_name'] = 'Файл не был загружен (Пользователь в форме указал неверный путь к файлу)';
            }
        }
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
     * Возвращает маркер безошибочной загрузки
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
        if (!key_exists($name,$this->file))
            throw new Dune_Exception_Base('Ошибка чтения значения массива $_FILES["'.$this->formFieldName.'"]: ключа '.$name.' не существует');
        return $this->file[$name];
    }
/////////////////////////////
////////////////////////////////////////////////////////////////
    
    
////////////////////////////////////////////////////////////////
///////////////////////////////     Методы интерфейса ArrayAccess
    public function offsetExists($key)
    {
        if (!$this->haveUpload)
            return false;
        return key_exists($key,$this->file);
    }
    public function offsetGet($key)
    {
        if (!$this->haveUpload)
            return false;
        if (!key_exists($key,$this->file))
            //throw new Dune_Exception_Base('Ошибка чтения значения массива $_FILES["'.
            //                    $this->formFieldName.'"]: ключа '.$key.' не существует');
            return false;
                                
        return $this->file[$key];
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