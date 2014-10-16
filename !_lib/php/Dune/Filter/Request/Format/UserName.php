<?php
/**
*   
*	����� ��� ������������� � ������������ ����������� ������� ����������
*	����������� ������� $_GET, $_POST, $_COOKIE
* 
* --------------------------------------------------------
* | ����������: Dune                                      |
* | ����: UserName.php                                    |
* | � ����������: Dune/Filter/Request/Format/UserName.php |
* | �����: ������ ����� (Dune) <dune@pochta.ru>           |
* | ������: 1.00                                          |
* | ����: www.rznlf.ru                                    |
* --------------------------------------------------------
* 
*
* ������ 1.00 -> 1.01
* ----------------------
* 
*/

class Dune_Filter_Request_Format_UserName  extends Dune_Filter_Parent_RequestFormat
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
    static function getInstance($name, $def = '', $prioritet = 'pg')
    {
        $key = $name;
        if (!key_exists($key,self::$instance))
        {
            self::$instance[$key] = new Dune_Filter_Request_Format_UserName($name, $def, $prioritet);
        }
        return self::$instance[$key];
    }



// �������� �� ������������ ����� ������� �����������������
protected function makeFilter($value)
{
    // ������ ����� � �����
    $res = preg_match("|^[a-z�-��0-9][- !.,a-z�-��0-9'*_@)(%]{1,29}$|i", $value, $array);
    if ($res)
    {
        $array['empty'] = false;
        $array['value'] = $value;
    }
    else 
    {
        $array['empty'] = true;
        $array['value'] = $this->defaultValue;
    }
    
    return $array;
}

}