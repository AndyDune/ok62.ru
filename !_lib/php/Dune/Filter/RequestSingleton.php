<?php
/**
*	����� ��� ������������� � ������������ ����������� ������� ����������
*	����������� ������� $_GET, $_POST, $_COOKIE
* 
* ---------------------------------------------------------
* | ����������: Dune                                       |
* | ����: RequestSingleton.php                             |
* | � ����������: Dune/Filter/Parent/RequestSingleton.php  |
* | �����: ������ ����� (Dune) <dune@pochta.ru>            |
* | ������: 1.00                                           |
* | ����: www.rznlf.ru                                     |
* ---------------------------------------------------------
* 
* 
*/

class Dune_Filter_RequestSingleton extends Dune_Filter_Parent_Request
{
    
    static private $instance = array();
    
    /**
    * ���������� ������ �� ������
    *
    * @param string $name
    * @param mixed $def (�������� �� ���������)
    * @param string $filter (���������: 'd','pd','aw','awd')
    * @param string $prioritet (���������� �������� p,g,c - � ����� ������������������)
    * @return object
    */
    static function getInstance($name,$def = 0,$filter = 'd',$prioritet = 'pg')
    {
        $key = $name . $def . $filter . $prioritet;
        if (!key_exists($key,self::$instance))
        {
            self::$instance[$key] = new Dune_Filter_RequestSingleton($name, $def, $filter, $prioritet);
        }
        return self::$instance[$key];
    }


}