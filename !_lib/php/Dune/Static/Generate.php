<?php
/**
 * ����������� ������� ��� ��������, ������ ��������
 * 
 * ----------------------------------------------------
 * | ����������: Dune                                  |
 * | ����: Generate.php                                |
 * | � ����������: Dune/Static/Generate.php            |
 * | �����: ������ ����� (Dune) <dune@rznlf.ru>        |
 * | ������: 1.00                                      |
 * | ����: www.rznlf.ru                                |
 * ----------------------------------------------------
 *
 */

abstract class Dune_Static_Generate
{
    /**
     * ����� �������� ��� ��������� ���������� ������
     *
     * @var string
     */
    static public $allowedSymbols = '23456789abcdeghkmnpqsuvxyz';
    
    static public function generateRandomString($length = 10)
    {
        $result = '';
        $allowedLength = strlen(self::$allowedSymbols) - 1;
        for ($x = 0; $x < $length; $x++)
        {
            $result .= self::$allowedSymbols[mt_rand(0, $allowedLength)];
        }
        return $result;
    }

}