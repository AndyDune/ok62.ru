<?php
/**
*   �������� �������� ��� ����������. �� ��������.
* 
* 	����� ��� ������������� � ������������ ����������� ������� ����������
* 
* ----------------------------------------------------
* | ����������: Dune                                       |
* | ����: NoFilter.php                                     |
* | � ����������: Dune/Filter/Get/NoFilter.php             |
* | �����: ������ ����� (Dune) <dune@rznlf.ru>             |
* | ������: 1.00                                           |
* | ����: www.rznlf.ru                                     |
* ----------------------------------------------------
* 
* ������ 1.00 -> 1.01
* ----------------------
* 
*/

class Dune_Filter_Get_NoFilter extends Dune_Filter_Parent_RequestFormatGet
{

    static private $instance = array();
    
    /**
    * ���������� ������ �� ������
    *
    * @param string $name
    * @param mixed $def (�������� �� ���������)
    * @return Dune_Filter_Get_NoFilter
    */
    static function getInstance($name, $def = '')
    {
        $key = $name;
        if (!key_exists($key,self::$instance))
        {
            self::$instance[$key] = new Dune_Filter_Get_NoFilter($name, $def);
        }
        return self::$instance[$key];
    }
}