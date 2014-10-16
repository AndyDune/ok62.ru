<?php
/**
*   �������� �������� ��� ����������. �� ��������.
* 
* 	����� ��� ������������� � ������������ ����������� ������� ����������
* 
* ----------------------------------------------------
* | ����������: Dune                                       |
* | ����: UrlCommand.php                                   |
* | � ����������: Dune/Filter/Get/UrlCommand.php           |
* | �����: ������ ����� (Dune) <dune@rznlf.ru>             |
* | ������: 1.00                                           |
* | ����: www.rznlf.ru                                     |
* ----------------------------------------------------
* 
* ������ 1.00 -> 1.01
* ----------------------
* 
*/

class Dune_Filter_Get_UrlCommand  extends Dune_Filter_Parent_RequestFormatGet
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
            self::$instance[$key] = new Dune_Filter_Get_UrlCommand($name, $def);
        }
        return self::$instance[$key];
    }
    
    // �������� �� ������������ ����� ������� �����������������
    protected function makeFilter($value)
    {
        $this->value = preg_replace('|[^-a-zA-Z0-9_]|i','',$value);
    }
    
}