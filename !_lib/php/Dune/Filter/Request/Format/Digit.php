<?php
/**
*   ��������� � ������� ������ ���������� ����� (int)
* 
* 	����� ��� ������������� � ������������ ����������� ������� ����������
*	����������� ������� $_GET, $_POST, $_COOKIE
* 
* ---------------------------------------------------------
* | ����������: Dune                                       |
* | ����: Digit.php                                        |
* | � ����������: Dune/Filter/Request/Digit.php            |
* | �����: ������ ����� (Dune) <dune@pochta.ru>            |
* | ������: 1.00                                           |
* | ����: www.rznlf.ru                                     |
* ---------------------------------------------------------
* 
* ������ 1.00 -> 1.01
* ----------------------
* 
*/

class Dune_Filter_Request_Format_Digit  extends Dune_Filter_Parent_RequestFormat
{

    static private $instance = array();
    
    /**
    * ���������� ������ �� ������
    *
    * @param string $name
    * @param mixed $def (�������� �� ���������)
    * @param string $prioritet (���������� �������� p,g,c - � ����� ������������������)
    * @return object
    */
    static function getInstance($name, $def = 0, $prioritet = 'gp')
    {
        $key = $name;
        if (!key_exists($key,self::$instance))
        {
            self::$instance[$key] = new Dune_Filter_Request_Format_Digit($name, $def, $prioritet);
        }
        return self::$instance[$key];
    }



    // �������� �� ������������ ����� ������� �����������������
    protected function makeFilter($value)
    {
        $array['empty'] = false;
        $array['value'] = (int)$value;
        return $array;
    }
}