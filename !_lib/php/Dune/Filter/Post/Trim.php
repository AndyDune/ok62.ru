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
* | ������: 1.00                                            |
* | ����: www.rznlf.ru                                      |
* ----------------------------------------------------------
* 
* ������ 1.00 -> 1.01
* ----------------------
* 
*/

class Dune_Filter_Post_Trim extends Dune_Filter_Parent_RequestFormatPost
{

    static private $instance = array();
    
    /**
    * ���������� ������ �� ������
    *
    * @param string $name
    * @param mixed $def (�������� �� ���������)
    * @return Dune_Filter_Post_Trim
    */
    static function getInstance($name, $def = '')
    {
        $key = $name;
        if (!key_exists($key,self::$instance))
        {
            self::$instance[$key] = new Dune_Filter_Post_Trim($name, $def);
        }
        return self::$instance[$key];
    }
}