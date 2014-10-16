<?php
/**
 * ������������ � �������� ��������.
 * 
 * ----------------------------------------------------
 * | ����������: Dune                                  |
 * | ����: Array.php                                   |
 * | � ����������: Dune/Test/Array.php                 |
 * | �����: ������ ����� (Dune) <dune@rznlf.ru>        |
 * | ������: 1.00                                      |
 * | ����: www.rznlf.ru                                |
 * ----------------------------------------------------
 *
 * ������� ������:
 *
 * ������ 1.00 -> 1.01
 * 
 * 
 */
class Dune_Test_Array
{

	protected $_array = array();
	protected $_isArray = false;
	
	public function __construct($array)
	{
		if (is_array($array))
		{
			$this->_isArray = true;
			$this->_array = $array;
		}
	}
	
	public function printPre()
	{
		echo '<pre>';
		print_r($this->_array);
		echo '</pre>';
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
           return false;
    }    
}