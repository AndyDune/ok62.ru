<?php
/**
 * ��������� ������ SET ��� ���������� ������ � �������.
 * 
 * ----------------------------------------------------
 * | ����������: Dune                                  |
 * | ����: Set.php                                     |
 * | � ����������: Dune/Mysqli/Collector/Set.php       |
 * | �����: ������ ����� (Dune) <dune@rznw.ru>         |
 * | ������: 1.01                                      |
 * | ����: www.dune.rznw.ru                            |
 * ----------------------------------------------------
 *
 *  ������:
 * 
 * 1.01 (2009 ���� 17)
 * ��������� ������ float
 * 
 */

class Dune_Mysqli_Collector_Set
{

    /**
     * ��������� �� ������ - ���������� � ����� ������.
     * 
     * @var string
     * @access private
     */
    protected $_DB = null;
    
    /**
     * ������ ��� ���������� � ����
     * 
     * @var array
     * @access private
     */
    protected $_arrayToSave = array();
    
    protected $_fieldsArrayAllow   = false;
    protected $_fieldsArrayrequire = false;

    /**
     * ������ SET ��� �������
     * 
     * @var string
     * @access private
     */
    protected $_querySetString = '';
    

    /**
     * ������ ������. ����� �����.
     */
    const FORMAT_INTEGER = 'i';

    /**
     * ������ ������. ��������� �����.
     */
    const FORMAT_FLOAT = 'f';
    
    /**
     * ������ ������. ������.
     */
    const FORMAT_STRING  = 's';
    
    /**
     * ������ ������. �����.
     */
    const FORMAT_TIME    = 't';
    
    /**
     * ������ ������. ������. ����� ���� NUL ��� ����������� �������� null ��� false.
     */
    const FORMAT_NULL    = 'n';
    
    /**
     * �����������. ��������� ������, ����������� �� Dune_Mysqli_Abstract_Mysqli.
     *
     * @param Dune_Mysqli_Abstract_Mysqli $object
     */
    public function __construct($object)
    {
        $this->_DB = $object;
    }
    
    /**
     * �������� ������ ��� ����������.
     * ������ $data ����� �������� � �������:
     * array(
     *       '<��� ����>' => array(<��������>, <������>)
     *       )
     * ���� � ������� (������ �� ��������� ������):
     * array(
     *       '<��� ����>' => <��������>
     *       )
     *  ������ ����� ����:
     *  s - ������ (�� ���������) ����������� ������������
     *  i - ����� ����� - ��������� � ���� (int)
     *  t - �����. ���� � �������� ���� ������������� ����� ����� (�� ����) - �������������� � ������ YYYY-MM-DD HH:MM:SS � �����������.
     *             ���� �� �����  - ����������� NOW()
     * 
     * @param mixed $data ��� ���� ������� ���� ������ � �������
     * @param mixed $value   [optional] �������� ���� ��� ����������
     * @param string $format [optional] ������ ������ (i, s, n, t, f)
     */
    public function assign($data, $value = null, $format = 's')
    {
        if (is_array($data))
        {
            foreach ($data as $key => $value)
            {
                if (is_array($value))
                {
                    if (is_array($value[0])) // ����������� ������
                        $value[0] = serialize($value[0]);
                    $this->_arrayToSave[$key]['value']  = $value[0];
                    $this->_arrayToSave[$key]['format'] = $value[1];
                }
                else 
                {
                    $this->_arrayToSave[$key]['value']  = $value;
                    $this->_arrayToSave[$key]['format'] = 's';
                }
            }
        }
        else 
        {
            if ($this->_fieldsArrayAllow and in_array($data, $this->_fieldsArrayAllow))
                throw new Dune_Exception_Mysqli('���������� ���� �� ������ � ������ ����������� ��� ���������');
            if (is_array($value))// ����������� ������
               $value = serialize($value);
            $this->_arrayToSave[$data]['value']  = $value;
            $this->_arrayToSave[$data]['format'] = $format;
        }
    }
    
    /**
     * ��������� ����������� ����� ��� ����������. �� ��������� - ��� �����������.
     *
     * @param array $array
     */
    public function setFieldsAllow($array)
    {
        $this->_fieldsArrayAllow = $array;
    }
    
    /**
     * ��������� ������������ ����� ��� ����������. �� ��������� - ������������ ���.
     *
     * @param array $array
     */
    public function setFieldsRequire($array)
    {
        $this->_fieldsArrayrequire = $array;
    }
    
    /**
     * ����� ������ SET.
     *
     */
    public function get()
    {
        if ($this->_querySetString)
        {
            $result = $this->_querySetString;
        }
        else 
        {
            if (count($this->_arrayToSave))
            {
                $result = $this->_makeSetString();
            }
            else 
                $result = false;
        }
        return $result;
    }


////////////////////////////////////////////////////////////////////////////////////////
/////////////////       ��������� ������    
///////////////////////////////////////////////////////////////////////////////////////

    /**
     * �������� ������ ���������� ������.
     */
    public function __toString()
    {
        return '<pre>' . $this->get() . '</pre>';
    }   

    
////////////////////////////////////////////////////////////////////////////////////////
/////////////////       �������� ������    
///////////////////////////////////////////////////////////////////////////////////////

    

    /**
     * �������� ������ ��� ���������� � ����.
     * 
     * @access private
     */
    protected function _makeSetString()
    {
        
        // �������� �� ������� ������������ ����� � ������ �����������
        if ($this->_fieldsArrayrequire)
        {
            foreach ($this->_fieldsArrayrequire as $run)
            {
                if (!key_exists($run, $this->_arrayToSave))
                {
                     throw new Dune_Exception_Base('� ������� ��� ���������� ��c�������� ���������� ����: ' . $run);
                }
            }
        }
        
       	// ������ ������ SET
       	$set_str = '';
       	$x = 0;
       	foreach ($this->_arrayToSave as $key => $value)
       	{
       	    switch ($value['format'])
       	    {
       	        // ����� �����
       	        case 'i':
       	            $value['value'] = (int)$value['value'];
       	        break;
       	        // ����� �����
       	        case 'f':
       	            $value['value'] = (float)$value['value'];
       	        break;
       	        
       	        // �����. ���� �������� �������� (����� �����, ������� �� ������ �����) - �������� � ������ mysql � ���������.
       	        // ���� ������������
       	        case 't':
       	            $value['value'] = (int)$value['value'];
       	            if ($value['value'])
       	                $value['value'] = 'FROM_UNIXTIME(' . (int)$value['value'] . ')';
       	            else 
       	                $value['value'] = 'NOW()';
       	        break;
       	        // ���������, ����� ���� null(��� false) - ����� � ���� ������������ NULL
       	        case 'n':
       	            if (is_null($value['value']) or $value['value'] === false)
       	                $value['value'] = 'NULL';
       	            else 
       	                $value['value'] = '"' . $this->_DB->real_escape_string($value['value']) . '"';
       	        break;
       	        // ���������
       	        default:
       	            $value['value'] = '"' . $this->_DB->real_escape_string($value['value']) . '"';
       	    }
       		if ($x == 0)
       			$set_str.= ' SET `'.$key.'` = ' . $value['value'];
       		else
       			$set_str.= ', `'.$key.'` = ' . $value['value'];
       		$x++;
       	}
        return $this->_querySetString =  $set_str;
    }
    
}