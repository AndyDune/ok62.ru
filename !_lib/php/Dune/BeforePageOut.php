<?php
/**
 * ����������� �����. �������� ������ ��� ����. �������� ����� ������� ��������.
 * 
 * ���c����:
 * --------------------
 * 1) ������������ ������ � ����������� ��� �����.
 *    ��� ������ ������ ������� ��� ������� � �������� ����� doBeforePageOut()
 * 
 * 
 * ----------------------------------------------------
 * | ����������: Dune                                  |
 * | ����: BeforePageOut.php                           |
 * | � ����������: Dune/BeforePageOut.php              |
 * | �����: ������ ����� (Dune) <dune@rznlf.ru>        |
 * | ������: 1.01                                      |
 * | ����: www.rznlf.ru                                |
 * ----------------------------------------------------
 * 
 * 
 * ������� ������:
 * -----------------
 * ������ 1.00 -> 1.01
 * ������ ���������, ����������� ��������
 *
 */
class Dune_BeforePageOut
{
    static private $objects = array();
    
    /**
     * ����������� ������� � ����������� ��� �����.
     *
     * ����� �� ��������� ���� - ������ ����� ��������������� � ������ �� ���������
     * 
     * @param string $key ���� ��� �������.
     * @param object $object ������
     */
    static public function registerObject(Dune_Interface_BeforePageOut $object, $key = false)
    {
        if ($key === false)
            self::$objects[] = $object;
        else 
        {
             if (!is_string($key))
                $key = (string)$key;
             if (!key_exists($key, self::$objects))
             {
                self::$objects[$key] = $object;
             }
        }
    }

    /**
     * ���������� ��������.
     *
     */
    static public function make()
    {
        if (count(self::$objects) > 0)
        {
            foreach (self::$objects as $val)
            {
                $val->doBeforePageOut();
            }
        }
    }
    
    
}