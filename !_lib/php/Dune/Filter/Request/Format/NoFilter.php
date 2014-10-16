<?php
/**
*   �������� �������� ��� ����������. �� ��������.
* 
* 	����� ��� ������������� � ������������ ����������� ������� ����������
*	����������� ������� $_GET, $_POST, $_COOKIE
* 
* ----------------------------------------------------
* | ����������: Dune                                       |
* | ����: NoFilter.php                                     |
* | � ����������: Dune/Filter/Request/NoFilter.php         |
* | �����: ������ ����� (Dune) <dune@pochta.ru>            |
* | ������: 1.00                                           |
* | ����: www.rznlf.ru                                     |
* ----------------------------------------------------
* 
* ������ 1.00 -> 1.01
* ----------------------
* 
*/

class Dune_Filter_Request_Format_NoFilter  extends Dune_Filter_Parent_RequestFormat
{

    static private $instance = array();
    
    /**
    * ���������� ������ �� ������
    *
    * @param string $name
    * @param mixed $def (�������� �� ���������)
    * @return object
    */
    static function getInstance($name, $def = '', $prioritet = 'gp')
    {
        $key = $name;
        if (!key_exists($key,self::$instance))
        {
            self::$instance[$key] = new Dune_Filter_Request_Format_NoFilter($name, $def, $prioritet);
        }
        return self::$instance[$key];
    }
}