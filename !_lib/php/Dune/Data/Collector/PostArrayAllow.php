<?php
/**
 * ��������� ������� $_POST � ����������� � ����� ������ ���������� �������� � ��������.
 * 
 * ----------------------------------------------------
 * | ����������: Dune                                  |
 * | ����: Url.php                                     |
 * | � ����������: Dune/Data/Colletor/Url.php          |
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
class Dune_Data_Collector_PostArrayAllow
{
	private $_array = array();
	private $_arrayMade = false;
	private $_allowArray = array();
	
	/**
	 * ��� ������� - ������� ������ �����
	 *
	 */
	const FILTER_INT = 'int';
	
	/**
	 * ��� ������� - ��������� ������� htmlcpecialchars()
	 *
	 */
	const FILTER_HTML = 'html';
	
	
	public function __construct()
	{
	    
	}
	
	/**
	 * �������� ���������� ���� ��� ������� $_POST.
	 * ���������� ����� ������ � ��������������� �������.
	 * [����] => array(
	 *                 'filter' => ��� �������, // ������������, ����� ����������
	 *                 'default' => �������� �� ���������, ���� ���� � ������� ������ ���� ���� ���� � $_POST ��� ���.
	 *                 )
	 * ��� �������������, ��� �������� �� ���������
	 * [����] => ��� �������
	 *
	 * @param mixed $value
	 * @param string $filter ��� �������, ����������� ��������� ������
	 * @param mixed $default �� ����������
	 */
	public function allow($value, $filter = 'no', $default = null)
	{
	    $this->_arrayMade = false;
	    if (is_array($value))
	    {
	        foreach ($value as $key => $val)
	        {
	            if (is_array($val))
	            {
	                if (!isset($val['filter'])) // ������������ ����
	                   throw new Dune_Exception_Base('�� ������� ������������ ���� � ������� ���������� ��������. ����� Dune_Data_Collector_PostArrayAllow');
	               $this->_allowArray[$key] = $val;
	            }
	            else 
	               $this->_allowArray[$key] = array('filter' => $val);
	        }
	    }
	    else 
	    {
	        $this->_allowArray[$value] = array('filter' => $filter, 'default' => $default);
	    }
	}
	
	/**
	 * ���������� $_POST.
	 *
	 * @return array ������������ ������
	 */
	public function make()
	{
	    if ($this->_arrayMade)
	    {
	        return $this->_array;
	    }
	    if (count($_POST) and count($this->_allowArray)) // ���� ������� ����
	    {
	        foreach ($this->_allowArray as $key => $value) // ������� �����������
	        {
	            if (key_exists($key, $_POST)) // ���� ���� � $_POST
	            {
	                switch ($value['filter']) // �������� ������
	                {
	                    case 'int':
	                        $this->_array[$key] = (int)$_POST[$key];
	                    break;
	                    case 'html':
	                        $this->_array[$key] = htmlspecialchars($_POST[$key]);
	                    break;
	                    default:
	                        $this->_array[$key] = $_POST[$key];
	                    
	                }
	            }
	            // ���� � $_POST ���
	            else if (isset($value['default']) and (!is_null($value['default']))) //���� ���� �������� �� ���������
	            {
	                $this->_array[$key] = $value['default'];
	            }
	        }
	        $this->_arrayMade = true; // ���� ��������� ���������
	    }
	    return $this->_array;
	}
	
	/**
	 * ������� ������������ ������.
	 * ������ ������������ ���, ���� �� ����� �� �������.
	 *
	 * @return array ������������ ������
	 */
	public function getArray()
	{
	    return $this->make();
	}
	
	/**
	 * ����� ��������� � ������������ �������
	 *
	 * @return integer
	 */
	public function countArray()
	{
	    return count($this->_array);
	}

	/**
	 * ������� ������� �����������
	 *
	 * @return array
	 */
	public function getAllowArray()
	{
	    return $this->_allowArray;
	}
	
}