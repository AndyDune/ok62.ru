<?php
/**
*   ��������� � ������� ������ ������� HtmlSpecialChars()
* 
* 	����� ��� ������������� � ������������ ����������� ������� ����������
*	����������� ������� $_GET, $_POST, $_COOKIE
* 
* ----------------------------------------------------
* | ����������: Dune                                       |
* | ����: HtmlSpecialChars.php                             |
* | � ����������: Dune/Filter/Request/HtmlSpecialChars.php |
* | �����: ������ ����� (Dune) <dune@pochta.ru>            |
* | ������: 1.00                                           |
* | ����: www.rznlf.ru                                     |
* ----------------------------------------------------
* 
* ������ 1.00 -> 1.01
* ----------------------
* 
*/

class Dune_Filter_Request_Format_HtmlSpecialChars  extends Dune_Filter_Parent_RequestFormat
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
    static function getInstance($name, $def = '', $prioritet = 'pg')
    {
        $key = $name;
        if (!key_exists($key,self::$instance))
        {
            self::$instance[$key] = new Dune_Filter_Request_Format_HtmlSpecialChars($name, $def, $prioritet);
        }
        return self::$instance[$key];
    }



    // �������� �� ������������ ����� ������� �����������������
    protected function makeFilter($value)
    {
        $array['empty'] = false;
        $array['value'] = htmlspecialchars($value);
        return $array;
    }
}