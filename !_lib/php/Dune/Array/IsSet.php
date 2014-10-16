<?php
/**
 * !! ���������� - �� ������������.
 * ��������� ������� ���������� ������ �� ������� �����.
 * ���� ����� ��� - ���������� �������� �� ���������.
 * 
 * ----------------------------------------------------
 * | ����������: Dune                                  |
 * | ����: IsSet.php                                   |
 * | � ����������: Dune/Array/IsSet.php                |
 * | �����: ������ ����� (Dune) <dune@rznlf.ru>        |
 * | ������: 1.02                                      |
 * | ����: www.rznlf.ru                                |
 * ----------------------------------------------------
 *
 * ������� ������:
 *
 * ������ 1.01 -> 1.02
 * ��� ������� ��������������� �������� ������� ������� get() ����������� false
 * 
 * ������ 1.00 -> 1.01
 * �������� ����� check() - �������� ��������� ����� � �������
 * 
 * 
 */
class Dune_Array_IsSet
{

	protected $_array = array();
	protected $_defaultValue = '';
	
	public function __construct($array, $defaultValue = '')
	{
		$this->_array = $array;
		$this->_defaultValue = $defaultValue;
	}
	
	/**
	 * ���������� ����������� ��������� �������
	 *
	 * @return integer
	 */
	public function count()
	{
		return count($this->_array);
	}

	/**
	 * ���������� ���� ������, ���� �� ������ �������� $key
	 * ���������� ���������� ������ ������� � �������� ���������� � $key
	 *
	 * @param string $key
	 * @return mixed
	 */
	public function get($key = '')
	{
		if ($key)
		{
			if (isset($this->_array[$key]))
				return $this->_array[$key];
			else 
				return false;
		}
		else 
			return $this->_array;
	}
	
	/**
	 * ������������� ����� �������� �� ��������� 
	 *
	 * @param unknown_type $value
	 */
	public function setDefaultValue($value)
	{
		$this->_defaultValue = $value;
	}

	/**
	 * �������� ��������� ����� � �������.
	 *
	 * @param mixed $key ���� ��� ��������
	 * @return boolean true - ���� ����������, false - ���
	 */
	public function check($key)
	{
		return isset($this->_array[$key]);
	}
	
	
////////////////////////////////////////////////////////////////
///////////////////////////////     ���������� ������
    public function __set($name, $value)
    {
        $this->_array[$name] = $value;
    }
    public function __get($name)
    {
        if (isset($this->_array[$name]))
            return $this->_array[$name];
        else 
           return $this->_defaultValue;
    }    
}