<?php
/**
*   �������� �������� ��� ����������. �������� � ������ �����.
* 
* 	����� ��� ������������� � ������������ ����������� ������� ����������
* 
* ----------------------------------------------------------
* | ����������: Dune                                        |
* | ����: Digit.php                                         |
* | � ����������: Dune/Filter/Post/Digit.php                |
* | �����: ������ ����� (Dune) <dune@rznlf.ru>              |
* | ������: 1.00                                            |
* | ����: www.rznlf.ru                                      |
* ----------------------------------------------------------
* 
* ������ 1.00 -> 1.01
* ----------------------
* 
*/

class Dune_Filter_Post_Digit extends Dune_Filter_Parent_RequestFormatPost
{

    static private $instance = array();
    
    /**
    * ���������� ������ �� ������
    *
    * @param string $name
    * @param mixed $def (�������� �� ���������)
    * @return Dune_Filter_Post_Digit
    */
    static function getInstance($name, $def = '')
    {
        $key = $name;
        if (!key_exists($key,self::$instance))
        {
            self::$instance[$key] = new Dune_Filter_Post_Digit($name, $def);
        }
        return self::$instance[$key];
    }
    
    // �������� �� ������������ ����� ������� �����������������
    protected function makeFilter($value)
    {
        $this->value = (int)$value;
    }
}
