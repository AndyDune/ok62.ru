<?php
/**
*   ������������ ����������� ����� ��� ���� ������� ������ � �������� $_GET[]
*	����� ��� ������������� � ������������ ����������� ������� ����������
* 
* ---------------------------------------------------------
* | ����������: Dune                                       |
* | ����: RequestFormatGet.php                             |
* | � ����������: Dune/Filter/Parent/RequestFormatGet.php  |
* | �����: ������ ����� (Dune) <dune@pochta.ru>            |
* | ������: 1.01                                           |
* | ����: www.rznlf.ru                                     |
* ---------------------------------------------------------
* 
*
* ������ 1.00 -> 1.01
* ----------------------
*  ��������� ������. �������� ������ = 0 ������������������ ��� ���������� ������
* 
*/

abstract class Dune_Filter_Parent_RequestFormatGet
{

    protected $value;
    protected $have = false;
    
    /**
     * ������ �������� �� ���������
     *
     * @var mixed
     */
    protected $defaultValue;
    
    protected function __construct($name, $def = '')
    {
    	$this->defaultValue = $def;
    	
      	if (empty($_GET[$name]))
      	{
       		$this->value = $this->defaultValue;
      	}
       	else 
       	{
            $this->makeFilter(trim($_GET[$name]));
            if ($this->value !== '')
            {
                $this->have = true;
            }
            else 
                $this->value = $this->defaultValue;
       	}
    }
    
    // �������� �� ������������ ����� ������� �����������������
    protected function makeFilter($value)
    {
        $this->value = $value;
    }
    
    public function get()
    {
    	return $this->value;
    }
    
    public function have()
    {
    	return $this->have;
    }

}