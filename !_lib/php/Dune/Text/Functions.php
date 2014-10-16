<?php
/**
 * ����������� ������� ��� ��������� ������.
 * 
 * ----------------------------------------------------
 * | ����������: Dune                                  |
 * | ����: Functions.php                               |
 * | � ����������: Dune/Text/Functions.php             |
 * | �����: ������ ����� (Dune) <dune@rznlf.ru>        |
 * | ������: 1.00                                      |
 * | ����: www.rznlf.ru                                |
 * ----------------------------------------------------
 *
 */

abstract class Dune_Text_Functions
{
	/**
	 * ����������� ����� � ������ �� �����������. ������� ������
	 *
	 * @param unknown_type $str
	 * @param unknown_type $char
	 * @return unknown
	 */
    static public function makeArrayNotEmpty($str, $char = ',')
    {
        $str = trim($str);
        $array_result = array();
        if ($str)
        {
            $array_begin = explode($char, $str);
            foreach ((array)$array_begin as $value)
            {
                $x = trim($value);
                if ($x)
                {
                    $array_result[] = $x;
                }
            }
        }
        return $array_result;
    }

    /**
     * ����������� ������ � ����� float.
     * ��������� ���� �� ������� ����� ���������.
     * �������� ������� � ������ �� �����.
     *
     * @param string $str
     * @return float
     */
    static function strToFloat($str)
    {
        $str = trim($str);
        $temp = str_replace(' ', '', $str); // ����� ����� ���� � ��������� ����� ���������
        $temp = str_replace(',', '.', $temp); // ����� ����� ���� �������� �������
        
        return (float)$temp;
    }
    
    
    /**
     * ����������� ������ � ����� Int.
     * ��������� ���� �� ������� ����� ���������.
     * 
     * @param string $str
     * @return integer
     */
    static function strToInt($str)
    {
        $str = trim($str);
        $temp = str_replace(' ', '', $str); // ����� ����� ���� � ��������� ����� ���������
        return (int)$temp;
    }
    
    
}

