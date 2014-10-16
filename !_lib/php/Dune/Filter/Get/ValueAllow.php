<?php
/**
*   ���������� ����� ����� �� ������� $_GET.
* 
* 	����� ��� ������������� � ������������ ����������� ������� ����������
* 
* ----------------------------------------------------
* | ����������: Dune                                  |
* | ����: ValueAllow.php                              |
* | � ����������: Dune/Filter/Get/ValueAllow.php      |
* | �����: ������ ����� (Dune) <dune@rznlf.ru>        |
* | ������: 1.00                                      |
* | ����: www.rznlf.ru                                |
* ----------------------------------------------------
* 
* ������ 1.00 -> 1.01
* ----------------------
* 
*/

class Dune_Filter_Get_ValueAllow extends Dune_Filter_Parent_RequestFormatGet
{

    static private $instance = array();
    protected $allowValueArray = array();
    
    /**
    * ���������� ������ �� ������
    *
    * @param string $name
    * @param mixed $def (�������� �� ���������)
    * @param array $arrau ������� ���������� ��������
    * @return Dune_Filter_Get_ValueAllow
    */
    static function getInstance($name, $def = '', $array = array())
    {
        $key = $name;
        if (!key_exists($key,self::$instance))
        {
            self::$instance[$key] = new Dune_Filter_Get_ValueAllow($name, $def, $array);
        }
        return self::$instance[$key];
    }

   
    public function __construct($name, $def = '', $array = array())
    {
        $this->allowValueArray = $array;
    	$this->defaultValue = $def;
    	
      	if (empty($_GET[$name]))
      	{
       		$this->value = $this->defaultValue;
      	}
       	else 
       	{
            $this->makeFilter(trim($_GET[$name]));
            if ($this->value !== false)
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
        if (in_array($value, $this->allowValueArray)) 
        {
        	$this->value = $value;
        }
        else 
            $this->value = false;
    }
    
}