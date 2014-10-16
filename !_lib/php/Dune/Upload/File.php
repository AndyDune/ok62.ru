<?php
/**
 * ����� ������������� � ���� ������ � ����������� ������������ �����
 * ��������� ����������� ����� ������. ������ �� ����� "err_name"
 * 
 * ��������� ����������: ArrayAccess
 * ���������� ���������� ������: __set, __get
 * 
 * ----------------------------------------------------
 * | ����������: Dune                                  |
 * | ����: File.php                                    |
 * | � ����������: Dune/Upload/File.php                |
 * | �����: ������ ����� (Dune) <dune@rznlf.ru>        |
 * | ������: 1.02                                      |
 * | ����: www.rznlf.ru                                |
 * ----------------------------------------------------
 *
 * ������ 1.01 -> 1.02
 * ��������� ������������ ������.
 * 
 * ������ 1.00 -> 1.01
 * ���������� ����������
 * ����� ����� isCorrect()
 * 
 */

class Dune_Upload_File implements ArrayAccess
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
                    $this->file['err_name'] = '������ �� ����, ���� ��������';
                break;
                case 1:
                    $this->file['err_name'] = '������ ������������ ����� ��������� ������ ������������� ���������� upload_max_filesize � php.ini';
                break;
                case 2:
                    $this->file['err_name'] = '������ ������������ ����� ��������� ������ ������������� ���������� MAX_FILE_SIZE � HTML �����';
                break;
                case 3:
                    $this->file['err_name'] = '��������� ������ ����� �����';
                break;                    
                case 4:
                    $this->file['err_name'] = '���� �� ��� �������� (������������ � ����� ������ �������� ���� � �����)';
            }
        }
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
     * ���������� ������ ������������ ��������
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
        if (!key_exists($name,$this->file))
            throw new Dune_Exception_Base('������ ������ �������� ������� $_FILES["'.$this->formFieldName.'"]: ����� '.$name.' �� ����������');
        return $this->file[$name];
    }
/////////////////////////////
////////////////////////////////////////////////////////////////
    
    
////////////////////////////////////////////////////////////////
///////////////////////////////     ������ ���������� ArrayAccess
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
            //throw new Dune_Exception_Base('������ ������ �������� ������� $_FILES["'.
            //                    $this->formFieldName.'"]: ����� '.$key.' �� ����������');
            return false;
                                
        return $this->file[$key];
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