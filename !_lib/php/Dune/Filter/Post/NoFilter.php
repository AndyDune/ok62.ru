<?php
/**
*   �������� �������� ��� ����������. �� ��������.
* 
* 	����� ��� ������������� � ������������ ����������� ������� ����������
* 
* ----------------------------------------------------------
* | ����������: Dune                                        |
* | ����: NoFilter.php                                      |
* | � ����������: Dune/Filter/Post/NoFilter.php             |
* | �����: ������ ����� (Dune) <dune@rznlf.ru>              |
* | ������: 1.01                                            |
* | ����: www.rznlf.ru                                      |
* ----------------------------------------------------------
* 
* ������ 1.00 -> 1.01
* ----------------------
* �������� ��������� ����������� �� ����� ������� ������
* 
*/

class Dune_Filter_Post_NoFilter extends Dune_Filter_Parent_RequestFormatPost
{

    static private $instance = array();
    
    /**
    * ���������� ������ �� ������
    *
    * @param string $name
    * @param mixed $def (�������� �� ���������)
    * @param integer $def ����������� ���������� �����, 0 - ��� �����������
    * @return Dune_Filter_Post_NoFilter
    */
    static function getInstance($name, $def = '', $maxLength = 0)
    {
        $key = $name;
        if (!key_exists($key,self::$instance))
        {
            self::$instance[$key] = new Dune_Filter_Post_NoFilter($name, $def, $maxLength);
        }
        return self::$instance[$key];
    }
}