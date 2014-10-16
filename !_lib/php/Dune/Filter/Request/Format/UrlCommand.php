<?php
/**
*   �������� �������� ��� ����������. �� ��������.
* 
* 	����� ��� ������������� � ������������ ����������� ������� ����������
*	����������� ������� $_GET, $_POST, $_COOKIE
* 
* ----------------------------------------------------
* | ����������: Dune                                       |
* | ����: UrlCommand.php                                   |
* | � ����������: Dune/Filter/Request/UrlCommand.php       |
* | �����: ������ ����� (Dune) <dune@rznlf.ru>             |
* | ������: 1.00                                           |
* | ����: www.rznlf.ru                                     |
* ----------------------------------------------------
* 
* ������ 1.00 -> 1.01
* ----------------------
* 
*/

class Dune_Filter_Request_Format_UrlCommand  extends Dune_Filter_Parent_RequestFormatGet
{

    static private $instance = array();
    
    /**
    * ���������� ������ �� ������
    *
    * @param string $name
    * @param mixed $def (�������� �� ���������)
    * @return object
    */
    static function getInstance($name, $def = '')
    {
        $key = $name;
        if (!key_exists($key,self::$instance))
        {
            self::$instance[$key] = new Dune_Filter_Request_Format_UrlCommand($name, $def);
        }
        return self::$instance[$key];
    }
}