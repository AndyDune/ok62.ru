<?php
/**
 * Dune Framework
 * 
 * ����������� �����.
 * 
 * ------------------------------------------------------------
 * | ����������: Dune                                          |
 * | ����: ArrayAllow.php                                      |
 * | � ����������: Dune_Data_Collector_Abstract_ArrayAllow.php |
 * | �����: ������ ����� (Dune) <dune@rznw.ru>                 |
 * | ������: 0.99                                              |
 * | ����: www.rznw.ru                                         |
 * ------------------------------------------------------------
 *
 * ������� ������:
 * ������ 0.99 (2009 ������ 13)
 *  ���� ������������ ����������� ������������� ������ ���������� �� ���������.
 *  ��� ���������� �������� �� ��������� � ������� $allowFields ��������������� � null.
 * 
 * ������ 0.98 (2008 ������� 27) ��� ������� �������������.
 * 
 * 
 */
abstract class Dune_Data_Collector_Abstract_ArrayAllow extends Dune_Array_Abstract_Interface
{
    
    /**
     * ������ ����������� ����� ��� ������������� � �������.
     *
     * ������:
     * <��� ����> => array(<����>, <�����>, <�� ���������, ����� �������������>)
     * <��� ����> => array(<����>, <�����>, <�� ���������, ����� �������������>)
     * ...
     * 
     * �����������:
     * <����> : 'i' - ����� �����
     *          's' - ������
     *          'f' - ����� � ��������� ������
     * <�����> : ��� ������ - ����� ��������, ��� ����� - ����������� ��������
     * 
     * @var array
     * @access private
     */
    protected $allowFields = array();
    
    /**
     * ���� ��������� ���������� ��� ������ ��������������������� �����.
     *
     * @var boolean
     */
    public static $useExeption = false;
    
   
    final public function __set($name, $value)
    {
        if (key_exists($name, $this->allowFields))
        {
            if ($this->allowFields[$name][0] == 'i')
            {
                $value = (int)str_replace(' ', '', $value);
                if ($value > $this->allowFields[$name][1])
                    $value = $this->allowFields[$name][1];
            }
            else if ($this->allowFields[$name][0] == 'f')
            {
                $value = (float)str_replace(array(' ',','), array('','.'), $value);
                if ($value > $this->allowFields[$name][1])
                    $value = $this->allowFields[$name][1];
            }
            
            else 
            {
                $value =  substr($value, 0, $this->allowFields[$name][1]);
            }
            $this->_array[$name] = $value;
        }
        else 
        {
            if (self::$useExeption)
                throw new Dune_Exception_Base('��������� ��������������� ����� � ������� ������ �������');
        }
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
                $this->__set($key, $value);
            }
        }
    }
    
   
    /**
     * ������� ����� ���������� �������.
     *
     * @param array $array ����� ���� �������� c ����������� ArrayAccess � Countable
     */
    final public function getData($is_container = false, $with_default = false)
    { 
        if ($with_default)
        {
            $this->_checkDeafult();
        }
        if ($is_container)
            return new Dune_Array_Container($this->_array);
        return $this->_array;
    }

    final public function setDefault()
    {
        $this->_checkDeafult();
    }
    
    
    final protected function _checkDeafult()
    {
        foreach ($this->allowFields as $key => $value)
        {
            if (isset($value[2]))
            {
                if (empty($this->_array[$key]))
                {
                    $this->_array[$key] = $value[2];
                }
            }
            else 
            {
                if (empty($this->_array[$key]))
                {
                    $this->_array[$key] = null;
                }
                
            }
        }
    }
    
    
}