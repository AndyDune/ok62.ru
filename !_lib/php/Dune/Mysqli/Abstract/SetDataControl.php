<?php
/**
 * Dune Framework
 * 
 * ����������� �����.
 * ��������� ���������� �������������� ������� ����������� ����� ��� ���������� � ����������.
 * 
 * --------------------------------------------------------
 * | ����������: Dune                                      |
 * | ����: SetDataControl.php                              |
 * | � ����������: Dune/Mysqli/Abstract/SetDataControl.php |
 * | �����: ������ ����� (Dune) <dune@rznw.ru>             |
 * | ������: 0.94                                          |
 * | ����: www.rznw.ru                                     |
 * --------------------------------------------------------
 *
 * ������� ������:
 *
 * ������ 0.94 (2008 ���� 10)
 * ��������� ��������� ����� double
 * 
 * ������ 0.93 (2008 ������ 22)
 *  ���������������� ��������� ������ �������.
 * 
 * ������ 0.92 (2008 ������ 16)
 *  ������ � ������ � ������� �������.
 *  ����� __set()
 * 
 * ������ 0.91 (2008 ������ 08)
 *  ������� ��������������.
 * 
 */
abstract class Dune_Mysqli_Abstract_SetDataControl extends Dune_Mysqli_Abstract_Connect
{
    protected $_dataToSave = array();
    
    protected $_keyField = null;
    protected $_keyFieldType = 's';
    
    /**
     * ������ ����������� ����� ��� ������������� � �������.
     *
     * ������:
     * <��� ����> => array(<����>, <�����>)
     * <��� ����> => array(<����>, <�����>, <����������� ��������>,)
     * ...
     * 
     * �����������:
     * <����> : 'i' - ����� �����
     *          's' - ������
     *          'd' - ��� date
     *          'dt'- ��� datetime 
     *          'f' - ����� � ��������� ������
     * <�����> : ��� ������ - ����� ��������, ��� ����� - ����������� ��������
     * 
     * @var array
     * @access private
     */
    protected $_allowFields = array();
    
    
    protected $_useExeption = false;
    
    /**
     * ���� ��������� ���������� ��� ������ ��������������������� �����.
     *
     * @var boolean
     */
    public static $useExeption = false;
    

    /**
     * ������ ������ ��� ������� ����� SET � ������� �� ����������.
     * ���������� ������ $this->_dataToSave
     *
     * @param boolean $firstComma ������� ',' (�������) ����� 1-� ����������
     * @return string ������ ��� �������
     * @access private
     */
    final protected function _collectDataToSave($firstComma = false)
    {
        unset($this->_dataToSave[$this->_keyField]);
        $set = '';
        $x = (int)$firstComma;
        foreach ($this->_dataToSave as $key => $value)
        {
            if ($x)
                $set .= ',';
            $x++;
            $set .= ' `' . $key .'` = ' . $value;
        }
        return $set;
    }
    
    final protected function _set($name, $value)
    {
        if (key_exists($name, $this->_allowFields))
        {
            if ($this->_allowFields[$name][0] == 'i')
            {
                $value = (int)str_replace(' ', '', $value);
                if ($value > $this->_allowFields[$name][1])
                    $value = $this->_allowFields[$name][1];
                else if (isset($this->_allowFields[$name][2]) and $value < $this->_allowFields[$name][2])
                    $value = $this->_allowFields[$name][2];
            }
            else if ($this->_allowFields[$name][0] == 'f')
            {
                $value = (float)str_replace(array(' ',','), array('','.'), $value);
                if ($value > $this->_allowFields[$name][1])
                    $value = $this->_allowFields[$name][1];
                else if (isset($this->_allowFields[$name][2]) and $value < $this->_allowFields[$name][2])
                    $value = $this->_allowFields[$name][2];
                    
            }
            else if ($this->_allowFields[$name][0] == 'd')
            {
                if ($value == (int)$value)
                    $value = '"' . date('Y-m-d H:i:s', $value) . '"';
                else 
                    $value =  '"' . $this->_DB->real_escape_string(substr($value, 0, $this->_allowFields[$name][1])) . '"';
            }
            else if ($this->_allowFields[$name][0] == 'dt')
            {
                if ($value == (int)$value)
                    $value = '"' . date('Y-m-d H:i:s', $value) . '"';
                else 
                    $value =  '"' . $this->_DB->real_escape_string(substr($value, 0, $this->_allowFields[$name][1])) . '"';
            }
            
            else 
            {
                $value =  '"' . $this->_DB->real_escape_string(substr($value, 0, $this->_allowFields[$name][1])) . '"';
            }
            $this->_dataToSave[$name] = $value;
        }
        else 
        {
            if (self::$useExeption or $this->_useExeption)
                throw new Dune_Exception_Base('��������� ��������������� ����� � ������� ������ �������');
        }
    }
    
    
    
    protected function _parseStructure($table)
    {
        $q = 'DESCRIBE `' . $table . '`';
        $this->_initDB();
        $result = $this->_DB->query($q, null, Dune_MysqliSystem::RESULT_IASSOC);
        if ($result)
        {
            $array = array();
            foreach ($result as $value)
            {
                $permation = $this->_permitField($value['Type']);
                if ($value['Key'] == 'PRI')
                {
                    $this->_keyField = $value['Field'];
                    $this->_keyFieldType = $permation[0];
                }
                $array[$value['Field']] = $permation;
            }
            $this->_allowFields = $array;
        }
        
//        echo '<pre>';
//        print_r($array);
//        echo '</pre>';
        
    }
    
    protected function _permitField($value)
    {
        $result = array();
        $array = array();
        
/*  �� �����������
        $type = preg_match('/([^\( ]+)/iu', $value, $array);
        $number = preg_match('/\(([^\(]+)\)/iu', $value, $array);
        $unsigned = preg_match('/ (unsigned)/iu', $value, $array);
*/        

        preg_match('/([^\( ]+)(\(([^\(]+)\))* *(unsigned)*/iu', $value, $array);                
        $type = strtolower($array[1]);
        if (isset($array[3]))
            $number = $array[3];
        else 
            $number = 0;
        if (isset($array[4]))
            $unsigned = true;
        else 
            $unsigned = false;
            
        $result[1] = 0;
        $result[2] = 0;
        switch ($type)
        {
            case 'char':
            case 'varchar':
                $result[0] = 's';
                $result[1] = $number;
            break;
            case 'date':
                $result[0] = 'd';
                $result[1] = 10;
            break;
            case 'datetime':
            case 'timestamp':
                $result[0] = 'dt';
                $result[1] = 19;
            break;
            
            case 'text':
            case 'blob':
                $result[0] = 's';
                $result[1] = 65535;
            break;
            case 'longtext':
            case 'longblob':
                $result[0] = 's';
                $result[1] = 16777215;
            break;
            
            case 'int':
            case 'integer':
                $result[0] = 'i';
                if ($unsigned)
                {
                    $result[1] = 4294967295;
                    $result[2] = 0;
                }
                else
                {
                    $result[1] = 2147483647;
                    $result[2] = -2147483648;
                } 
            break;
            case 'double':
                $result[0] = 'f';
                if ($unsigned)
                {
                    $result[1] = 1.7976931348623157E+308;
                    $result[2] = 0;
                }
                else
                {
                    $result[1] = 1.7976931348623157E+308;
                    $result[2] = -1.7976931348623157E+308;
                } 
            break;
            
            case 'tinyint':
                $result[0] = 'i';
                if ($unsigned)
                {
                    $result[1] = 255;
                    $result[2] = 0;
                }
                else
                {
                    $result[1] = 127;
                    $result[2] = -128;
                } 
            break;
            case 'smallint':
                $result[0] = 'i';
                if ($unsigned)
                {
                    $result[1] = 65535;
                    $result[2] = 0;
                }
                else
                {
                    $result[1] = 32767;
                    $result[2] = -32768;
                } 
            break;
            case 'mediumint':
                $result[0] = 'i';
                if ($unsigned)
                {
                    $result[1] = 16777215;
                    $result[2] = 0;
                }
                else
                {
                    $result[1] = 8388607;
                    $result[2] = -8388608;
                } 
            break;
            
            case 'bigint':
                $result[0] = 'i';
                if ($unsigned)
                {
                    $result[1] = 18446744073709551615;
                    $result[2] = 0;
                }
                else
                {
                    $result[1] = 9223372036854775807;
                    $result[2] = -9223372036854775808;
                } 
            break;
            
            case 'float':
                $result[0] = 'f';
                if ($unsigned)
                {
                    $result[1] = 3.402823466E+38;
                    $result[2] = 0;
                }
                else
                {
                    $result[1] = 3.402823466E+38;
                    $result[2] = -3.402823466E+38;
                } 
            break;
            default:
                throw new Dune_Exception_Base('��������� �� �������������� ��� ������ �� �������.');
            
        }
        return $result;
            
    }

    static function permit($value)
    {
//        preg_match('/([^\( ]+)/iu', $value, $array);
//        preg_match('/\(([^\(]+)\)/iu', $value, $array);
//        preg_match('/ (unsigned)/iu', $value, $array);
        
        preg_match('/([^\( ]+)(\(([^\(]+)\))* *(unsigned)*/iu', $value, $array);        
        
/*        echo '<pre>';
        print_r($array);
        echo '</pre>';
*/ 
    }
    
    
    /**
     * �������� �������� ������� ��� ����������.
     *
     * @param array $array ����� ���� �������� c ����������� ArrayAccess � Countable
     */
    final public function loadData($array)
    {
        if (count($array))
        {
            foreach ($array as $key => $value)
            {
                $this->_set($key, $value);
            }
        }
    }
    
    public function __toString()
    {
        ob_start();
        echo '<pre>';
        print_r($this->_allowFields);
        echo '</pre>';
        return ob_get_clean();
    }
    
    public function __set($name, $value)
    {
        $this->_set($name, $value);
    }

}