<?php
/**
 * ������ � ������� � ����� ��� � �������� �������.
 * 
 * ���������. ����� ������ ��� ������ �����.
 * ��������� ��������� Dune_Interface_BeforePageOut.
 * 
 * Dune Framework
 * 
 * ----------------------------------------------------
 * | ����������: Dune                                  |
 * | ����: String.php                                  |
 * | � ����������: Dune/AsArray/File/String.php        |
 * | �����: ������ ����� (Dune) <dune@rznw.ru>         |
 * | ������: 1.01                                      |
 * | ����: www.rznw.ru                                 |
 * ----------------------------------------------------
 * 
 * ������� ������:
 * 
 * 
 * ������ 1.01 (2009 ���� 24)
 * -------------------------
 * �������� ����� �� ����������� ������.
 * trim() �� ������������. ������������� � UTF.
 * ���������� ��� ������������� �������� ��������� ����������.
 * ����������� ����������� � ������ Dune_BeforePageOut ��� ������ ������-������� getInstance().
 * �������� ����������� �������� ��������� ������: ��������� �������, ��������.
 * 
 * ������ 1.00 (2009 ������ 24)
 * -------------------
 * ��������� ������� � �������.
 * 
 * ������ 0.99 (2009 ������ 26)
 * -------------------
 * ���������� ��������. ������� ������ � �����.
 * ������ ����������� �����.
 * 
 * ������ 0.90 (2009 ������ 22)
 * -------------------
 * ��������� ������. ������ ������������ ������������.
 * �������� �� ����������.
 * 
 */

class Dune_AsArray_File_String implements Iterator, ArrayAccess, Dune_Interface_BeforePageOut
{
    protected $_data    = array();
    protected $_isWrite = array();
    protected $_isFile = array();
    
    protected $_path = '';
    protected $_tempFolder = '/tmp';
    
    protected $_doneBeforePageOut = false;
    
    static private $instance = array();

    protected $_iteratorCurrentPointer = 0;
    protected $_iteratorTotalPoints = 0;
    protected $_iteratorCurrentKey = null;
    
    protected $_fileNames    = array();
    protected $_getFileNames = false;
    
    /**
     * ����� �������.
     * ������ ������� ������������ ��������� $path
     *
     * @param string $path ���� � ����� � �������. �� ����� �����. ���� �� ��������� - ����������.
     * @return Dune_AsArray_File_String
     */
    static function getInstance($path, $before_page_out = false)
    {
        if (!key_exists($path,self::$instance))
        {
            self::$instance[$path] = new Dune_AsArray_File_String($path);
            if ($before_page_out)
            {
                Dune_BeforePageOut::registerObject(self::$instance[$path], $path);
            }
        }
        return self::$instance[$path];
    }
    
    /**
     * ���������� ���������� ������ � �����.
     *
     * @return boolean ���������� false ���� �� ������� ������� ��������� �����.
     */
    public function commit()
    {
        if (!count($this->_isWrite))
            return true;
        $temp = $this->_path . $this->_tempFolder;
        if (!is_dir($temp))
        {
            if (!mkdir($temp))
                throw new Dune_Exception_Base('���������� ������� ��������� ����������: ' . $temp);
                //return false;
        }
        foreach ($this->_isWrite as $key => $value)
        {                 
            $file_name_full_info = $this->_path . '/' . $key;            
            if (empty($this->_data[$key]))
            {
                
                if ($this->_isFile[$key])
                    $this->_unlink($file_name_full_info, 3, 1000);
                        
                continue;
            }
            $data = (string)$this->_data[$key];
            $data_o = Dune_String_Factory::getStringContainer($data);
            if ($data_o->len() < 1)
                continue;
            $file = uniqid('tmp_', true) . '.txt';
            $file_name_full_temp = $temp . '/' . $file;
            file_put_contents($file_name_full_temp, $data);
            
            if ($this->_unlink($file_name_full_info, 3, 1000))
                rename($file_name_full_temp, $file_name_full_info);
            $this->_unlink($file_name_full_temp, 3, 1000);
            
/*            if (is_file($file_name_full_info))
                unlink($file_name_full_info);
              unset($this->_isWrite[$key]);
*/                
        }
        return true;
    }
    
    protected function _unlink($file, $try = 1, $time = 0)
    {
        if (!is_file($file))
            return 1;
        for($x = 1; $x <= $try; $x++)
        {
           if (unlink($file))
               return 2;
           if ($time)
           {
               time_nanosleep(0, $time);
           }
        }
        return false;
    }
    
    /**
     * ���������� ������ ���������� Dune_Interface_BeforePageOut.
     * 
     * �������� ����� ������ �������, ����� ������� ��������.
     *
     */
    public function doBeforePageOut()
    {
        // ���� ������ ���� � ���������� ���������� 1-� ���
        if (!$this->_doneBeforePageOut)
        {
            $this->commit();
            $this->_doneBeforePageOut = true;
        }
    }
    
    /**
     * ����������. ������, ����� ����� �� ��������� ����������
     *
     * @param string $path
     */
    protected function __construct($path)
    {
        //$path = trim($path, '/ ');
        $str = Dune_String_Factory::getStringContainer($path); // ���� �� ����������
        $path = $str->trim('/');
        
        $this->_path = $_SERVER['DOCUMENT_ROOT'] . '/' . $path;
        if (!is_dir($this->_path))
            throw new Dune_Exception_Base('��� ������ �����: ' . $this->_path);
        if (!is_writeable($this->_path))
            throw new Dune_Exception_Base('����� �� �������� ��� ������: ' . $this->_path);
            
    }
    
    /**
     * ������� ������ ����� ��� �� ���������� ����������.
     *
     * @param string $name
     * @return mixed ��������: null - ��� ������, false - ������ ������ ������.
     * @access private
     */
    protected function _getData($name)
    {
        $result = $this->_checkData($name);
        if (!is_null($result))
        {
            return $result;
        }
        $this->_getFileContent($name);
        return $this->_checkData($name);
    }
    
    /**
     * �������� �� ��������� ������ �����.
     *
     * �������:
     *  - ��������� ����� ������ �� �����;
     *  - false, ���� ���� ����������, �� ������ ������� �� �������;
     *  - null - ���� �� ����������.
     * 
     * @param string $name ��� �����
     * @return mixed
     */
    protected function _checkData($name)
    {
        $result = null;
        if (isset($this->_data[$name]))
        {
            $result = $this->_data[$name];
        }
        else if (isset($this->_isFile[$name]))
        {
            $result = false;
        }
        return $result;
    }

    /**
     * ������������� ���������� �����.
     *
     * @param string $name ��� �����
     * @param string $value ���������� �����
     * @access private
     */
    protected function _setData($name, $value)
    {
        $this->_data[$name] = $value;
        $this->_isWrite[$name] = true;
    }
    
    
    /**
     * ������ ���������� ����� � ��������� ������.
     * ������������� ���� ������������� �����.
     *
     * @param unknown_type $name
     * @return string ��� null ��� ���������� �����.
     * @access private
     */
    protected function _getFileContent($name)
    {
        $result = null;
        $file = $this->_path . '/' . $name;
        if (is_file($file))
        {
            $this->_data[$name] = file_get_contents($file);
            $this->_isFile[$name] = true;
            $result = $this->_data[$name];
        }
        else 
        {
            $this->_isFile[$name] = false;
        }
        return $result;
    }
    
    /**
     * ������ ����� ���� ������.
     *
     * @return boolean ������ true
     * @access private
     */
    protected function _readFileNames()
    {
        if ($this->_getFileNames)
            return true;
        $dir = new DirectoryIterator($this->_path);
        foreach ($dir as $value)
        {
            if ($value->isFile())
            {
                $this->_fileNames[] = $value->getFilename();
            }
            $this->_iteratorTotalPoints = count($this->_fileNames);
        }
        return $this->_getFileNames = true;
    }
    
      ////////////////////////////////////////////////////////////////
///////////////////////////////     ������ ���������� ArrayAccess
    /**
     * @param mixed $key
     * @return mixed
     * @access private
     */
    public function offsetExists($key)
    {
        $data = $this->_getData($key);
        if (is_null($data) or $data === false)
        {
            return false;
        }
        return true;
    }
    public function offsetGet($key)
    {
        return $this->_getData($key);
    }
    
    public function offsetSet($key, $value)
    {
        return $this->_setData($key, $value);
    }
    public function offsetUnset($key)
    {
        unset($this->_data[$key]);
        $this->_isWrite[$key] = true;
    }    
////////////////////////////////////////////////////////////////
///////////////////////////////     ������ ���������� Iterator

  // ������������� �������� �� ������ �������
    public function rewind()
    {
        $this->_readFileNames();
        return $this->_iteratorCurrentPointer = 0;
    }
    
    // ���������� ������� �������
    public function current()
    {
        return $this->_getData($this->_fileNames[$this->_iteratorCurrentPointer]);
    }
    
    // ���������� ���� �������� ��������
    public function key()
    {
        return $this->_fileNames[$this->_iteratorCurrentPointer];
    }
  
    // ��������� � ���������� ��������
    public function next()
    {
        return $this->_iteratorCurrentPointer++;
    }
    
    // ���������, ���������� �� ������� ������� ����� ���������� ������ rewind ��� next
    public function valid()
    {
        if ($this->_iteratorCurrentPointer < $this->_iteratorTotalPoints)
            return true;
        return false;
    }    
/////////////////////////////
////////////////////////////////////////////////////////////////   
    
    
}